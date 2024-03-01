<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\DataTables;
use Modules\CourseSetting\Entities\Package;
use Modules\CourseSetting\Entities\PackageCourse;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\PackageCategory;
use Intervention\Image\Facades\Image;
use App\User;
use Auth;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\ImageStore;

class PackageController extends Controller
{

    use ImageStore;
    public function course_data_with_ajax(Request $request) {
        if ($request->ajax()) {
            $term = trim($request->term);
            $results = [];

            if ($request->has('category_ids') && $request->category_ids != '') {
                $results = course_data_with_select2_search_ajax($term, $request->category_ids, 10); //term, categories, pagination
            }

            return $results;
        }
    }

    public function getAllPackages() {
        $cps = User::whereIn('role_id',[ 7,8])->get();
        $categories = Category::where('status', 1)->get();
        return view('coursesetting::packages.index',compact('categories','cps'));
    }

    public function getAllPackageData(Request $request) {
        $query = Package::with('package_courses','categories');
        $category = $request->category;

        if ($request->category != "") {
            $query->whereHas('categories',function($q) use($category){
                $q->where('category_id', $category);
            });
        }

        if ($request->status != "") {
            $query->where('status', $request->status);
        }

        if ($request->expiry_period != "") {
            $query->where('expiry_period', $request->expiry_period);
        }

        if ($request->title != "") {
            $query->where('name',"like",'%'.$request->title.'%');
        }

        if ($request->content_provider != "") {
            $cp = $request->content_provider;
            $query->where('user_id', '=', $cp);
        }

        if (check_whether_cp_or_not() || isPartner()) {
            $query = $query->where('user_id', Auth::id());
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function ($query) {
                if ($query->status == 0) {
                    $view = "Saved";
                } else {
                    if (isAdmin() || isHRDCorp() || isMyLL()) {
                        $checked = ($query->status == 1) ? "checked" : "";

                        $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                    <input type="checkbox" class="package_status_enable_disable" id="active_checkbox' . $query->id . '" value="' . $query->id . '" ' . $checked . '>
                                    <i class="slider round"></i>
                                </label>';
                    } else {
                        if ($query->status == 1) {
                            $view = "Published";
                        } else {
                            $view = "UnPublished";
                        }
                    }
                }

                return $view;
            })
            ->addColumn('user', function($query) {
                return ($query->user) ? $query->user->name : '';
            })
            ->addColumn('courses', function($query) {
                $courses = '';

                foreach ($query->package_courses as $key => $package_course) {
                    if ($package_course->course != '') {
                        $comma = ($query->package_courses->keys()->last() != $key) ? ', ' : '';
                        $courses .= $package_course->course->title.$comma;
                    }
                }

                return $query->total_course;
            })
            ->addColumn('categories', function($query) {
                $categories = '';

                foreach ($query->categories as $key => $package_category) {
                    if ($package_category->category != '') {
                        $comma = ($query->categories->keys()->last() != $key) ? ', ' : '';
                        $categories .= $package_category->category->name.$comma;
                    }
                }

                return $categories;
            })
            ->editColumn('price', function($query) {
                return getPriceFormat($query->price);
            })

            ->editColumn('published_at', function($query) {
                return ($query->published_at) ? date('d F Y ', strtotime($query->published_at)) : '';
            })

            ->addColumn('action', function ($query) {
                $assign_certificate = "";
                $frontend_view = "";
                $course_edit = "";

                if ((isAdmin() || isHRDCorp()) && permissionCheck('package.edit')) {
                    $assign_certificate = '<a onclick="assign_certificate(\'' . $query->id. '\')" class="dropdown-item">Assign Certificate</a>';
                }


                if (permissionCheck('package.edit')) {
                    $course_edit = '<a href="'.route('editPackage', $query->id).'" class="dropdown-item">'. __('common.Edit') .'</a>';
                }

                if (isAdmin() || isPartner() || check_whether_cp_or_not() || isHRDCorp() || isMyLL()) {
                    $frontend_view = '<a target="_blank" href="'.route('packageDetailsView', $query->slug ) .'"
                                        class="dropdown-item"> ' . trans('courses.Frontend View') . '</a>';
                }
                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $frontend_view . '
                                        ' . $assign_certificate . '
                                        ' . $course_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['status', 'price', 'action','published_at'])
            ->make(true);
    }

    public function addPackage() {
        $content_providers = User::select('id', 'name')->whereIn('role_id', [7, 8])->get();

        return view('coursesetting::packages.create', compact('content_providers'));
    }

    public function editPackage($id) {
        $package = Package::with('package_courses.course', 'categories.category')->where('id', $id)->first();

        $content_providers = User::select('id', 'name')->whereIn('role_id', [7, 8])->get();

        $package_courses = [];
        foreach ($package->package_courses as $key => $value) {
            if (isset($value->course)) {
                $package_courses[$key]['id']    = $value->course->id;
                $package_courses[$key]['title'] = $value->course->title;
            }
        }

        $package_categories = [];
        foreach ($package->categories as $key => $value) {
            if (isset($value->category)) {
                $package_categories[$key]['id']    = $value->category->id;
                $package_categories[$key]['title'] = $value->category->name;
            }
        }

        return view('coursesetting::packages.create', compact('package', 'package_courses', 'package_categories', 'content_providers'));
    }

    public function savePackage(Request $request) {
        $rules = [
            'name'              => "required",
            'price'             => "required",
            'expiry_period'     => "required",
            'description'       => "required",
            'overview'          => "required",
            'terms'             => "required",
            'category_ids'      => "required",
            'max_license_no'    => "gte:min_license_no",
            'upload_method'     => "required",
        ];

        if (isAdmin() || isHRDCorp() || isMyLL()) {
            $rules['user_id'] = 'required';
        }

        if ($request->has('image') || $request->image_field == '') {
            $rules['image'] = "required|mimes:jpeg,bmp,png,jpg|max:5120";
        }

        if ($request->upload_method == 1) {
            $rules['course_url'] = 'required|url';
            $rules['total_course'] = 'required';
        } else {
            $rules['package_courses'] = 'required';
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if ($request->has('package_id') && $request->package_id != '') {
                $package = Package::where('id', $request->package_id)->first();
            } else {
                $package = new Package();
            }

            $packageFolderPath = public_path('uploads/packages/');
            if(!File::isDirectory($packageFolderPath)) {
                File::makeDirectory($packageFolderPath, 0777, true, true);
            }

            if ($image = $request->file('image')) {
                if ($package->image != '') {
                    $packageImage = $package->image;

                    if (File::exists($packageImage)) {
                        unlink($packageImage);
                    }
                }

                $strpos = strpos($request->image, ';');
                $sub = substr($request->image, 0, $strpos);
                $name = md5($request->name . rand(0, 1000)).'.'.'png';
                $img = Image::make($request->image);
                $upload_path = 'uploads/packages/';
                $img->save($upload_path . $name);
                $package->image = 'uploads/packages/'. $name;
            }

            $package->user_id        = (isAdmin() || isHRDCorp() || isMyLL()) ? $request->user_id : Auth::id();
            $package->name           = $request->name;
            $package->slug           = Str::slug($request->name, '-');
            $package->price          = $request->price;
            $package->expiry_period  = $request->expiry_period;
            $package->description    = $request->description;
            $package->min_license_no = $request->min_license_no;
            $package->max_license_no = $request->max_license_no;
            $package->overview       = $request->overview;
            $package->upload_method  = $request->upload_method;

            if ($request->upload_method == 1) {
                $package->course_url     = $request->course_url;
                $package->total_course  = $request->total_course;
            } else {
                $package->course_url     = null;
                $package->total_course  = count($request->package_courses);
            }

            if ($request->status != '') {
                $package->status = $request->status;
            }

            if ($package->save()) {
                if ($request->upload_method == 1) {
                    $removed_package_course = PackageCourse::where('package_id', $package->id);
                } else {
                    $removed_package_course = PackageCourse::where('package_id', $package->id)->whereNotIn('course_id', $request->package_courses);
                }

                if ($removed_package_course->count() > 0) {
                    $removed_package_course->delete();
                }

                $removed_package_caegory = PackageCategory::where('package_id', $package->id)->whereNotIn('category_id', $request->category_ids);

                if ($removed_package_caegory->count() > 0) {
                    $removed_package_caegory->delete();
                }

                if ($request->upload_method == 2) {
                    foreach ($request->package_courses as $value) {
                        $package_course = PackageCourse::where('package_id', $package->id)->where('course_id', $value)->first();

                        if ($package_course == '') {
                            $package_course             = new PackageCourse();
                            $package_course->package_id = $package->id;
                            $package_course->course_id  = $value;
                            $package_course->save();
                        }
                    }
                }

                foreach ($request->category_ids as $value) {
                    $package_category = PackageCategory::where('package_id', $package->id)->where('category_id', $value)->first();

                    if ($package_category == '') {
                        $package_category                 = new PackageCategory();
                        $package_category->package_id     = $package->id;
                        $package_category->category_id    = $value;
                        $package_category->save();
                    }
                }
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('getAllPackages');
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function get_categories(Request $request) {
        if ($request->ajax()) {
            $term = trim($request->term);

            $posts = Category::select('id', 'name as text')->where('status', 1);

            if (isset($term) && $term != '') {
                $posts = $posts->where('name', 'like', '%' . $term . '%');
            }

            $posts = $posts->simplePaginate(10);

            $morePages = true;
            $pagination_obj = json_encode($posts);
            if (empty($posts->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return $results;
        }
    }

    public function assign_certificate(Request $request)
    {
        try {
            $certificate_id = $request->certificate_id;

            $rules = [
                'certificate_id'            => 'required',
            ];
            $messages = [
                'certificate_id.required'   => 'Select Certificate first!!',
            ];

            $validator = \Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $response['errors']         = $validator->errors()->all();
                $response['success']        = false;
                $response['status']         = 0;
                return response()->json($response);
            }else{
                $package                    = Package::where('id', $request->package_id)->first();
                $package->certificate_id    = $request->certificate_id;
                $package->save();
                $response['success']        = true;
                $response['message']        = 'Certificate assign to package successfully!';
                return response()->json($response);
            }
        }catch (\Exception $e){
            return  null;
        }

    }

    public function changePackageStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }

        try {
            $id = $request->id;
            $status = $request->status;

            $package = Package::where('id', $id)->first();
            $package->status = $status;
            if ($status == 1) {
                $package->published_at = now();
            } else {
                $package->published_at = null;
            }

            if ($package->save()) {
                return response()->json(['success' => trans('common.Status has been changed')]);
            } else {
                return response()->json(['error' => trans('common.Something went wrong') . '!'], 400);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getAllCourseHighlights()
    {
        $course_highlights = DB::table('course_highlights')->get();
        $group_course_highlights = $course_highlights->groupBy('user_id');
        $packages = Package::where('status', 1)->where('user_id', auth()->user()->id)->get();

        if (isPartner() || check_whether_cp_or_not()) {
            $course_highlights = DB::table('course_highlights')->where('user_id', auth()->user()->id)->get();
        }

        return view('coursesetting::packages.course_highlights', compact('course_highlights', 'group_course_highlights', 'packages'));
    }

    public function addCourseHighlights(Request $request)
    {
        try {

            if($request->thumbnail != null && $request->package_id != "" && $request->course_title!= "" && $request->description != "" ) {
                $thumbnail = $this->saveImage($request->thumbnail);
                    DB::table('course_highlights')
                    ->insert([
                        'user_id' => auth()->user()->id,
                        'package_id' => $request->package_id,
                        'course_title' => $request->course_title,
                        'description' => $request->description,
                        'thumbnail' => $thumbnail,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Please fill out all the field']);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return $this->getAllCourseHighlights();
        }
    }

    public function editCourseHighlights(Request $request)
    {
        try {

            $course_highlight = DB::table('course_highlights')->where('id', $request->id);
            if ($course_highlight) {
                if ($request->thumbnail != null ) {
                    $thumbnail = $this->saveImage($request->thumbnail);
                    $course_highlight->update(['thumbnail' => $thumbnail]);
                }

                if ($request->package_id != "") {
                    $course_highlight->update(['package_id' => $request->package_id]);
                }

                if ($request->course_title != "") {
                    $course_highlight->update(['course_title' => $request->course_title]);
                }

                if ($request->description != "") {
                    $course_highlight->update(['description' => $request->description]);
                }
                return response()->json(['success' => true]);
            } else {
                Toastr::error("Can't find the course highlight", "Failed");
                return response()->json(['success' => false]);
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return $this->getAllCourseHighlights();
        }
    }

    public function deleteCourseHighlights(Request $request)
    {
        try {
            $course_highlight = DB::table('course_highlights')->where('id', $request->id)->limit(1);
            if ($course_highlight) {
                $course_highlight->delete();

                return response()->json(['success' => true]);
            } else {
                Toastr::error("Can't find the Course Higlight", "Failed");
                return back();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return $this->getAllCourseHighlights();
        }
    }
}

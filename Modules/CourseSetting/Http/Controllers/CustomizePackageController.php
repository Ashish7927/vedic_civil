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
use Modules\CourseSetting\Entities\PackageCustomRequest;
use Modules\CourseSetting\Entities\auditTrailPackage;
use App\Models\User;
use Auth;
use File;
use Image;

class CustomizePackageController extends Controller
{
    public function packageRequest(){
        return view('coursesetting::customize-packages.package-request');
    }
    public function getAllPackageRequest(){
        $query = PackageCustomRequest::with('user');
         if (check_whether_cp_or_not() || isPartner()) {
            $query = $query->where('assign_to', Auth::id());
        }
        return Datatables::of($query)
            ->addIndexColumn()
             ->addColumn('user', function($query) {
                return $query->user->name;
            })
            ->addColumn('action', function ($query) {
                $course_edit = "";           
                if (permissionCheck('package.request')) {
                    $course_edit = '<a href="'.route('editPackageRequest', $query->id).'" class="dropdown-item">'. __('common.Edit') .'</a>';
                }
                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $course_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['action','user'])
            ->make(true);
    }

    public function course_data_with_ajax(Request $request) {
       // dd("kfdkf");
        if ($request->ajax()) {
            $term = trim($request->term);
            $results = custom_package_for_course_data_with_select2_search_ajax($term, 10); //term, pagination

            return $results;
        }
    }
    public function PackageRequestEdit($id){
        $requestPackage = PackageCustomRequest::where('id',$id)->first();
        $content_providers = User::select('id', 'name')->whereIn('role_id', [7, 8])->paginate(10);
        return view('coursesetting::customize-packages.package-request-edit',compact('requestPackage','content_providers'));
    }
    public function PackageRequestUpdate(Request $request){
        $rules = [
            'name'              => "required",
            'email_address'     => "required",
            'phone_number'     => "required",
            'company_name'       => "required",
            'company_registration' => "required",
        ];
        $this->validate($request, $rules, validationMessage($rules));
        try{
            $id = $request->package_request_id;
            $customRequest = PackageCustomRequest::where('id',$id)->first();
            $customRequest->full_name  = $request->name;
            $customRequest->email_address = $request->email_address;
            $customRequest->phone_number = $request->phone_number;
            $customRequest->company_name  = $request->company_name;
            $customRequest->company_registration  = $request->company_registration;
            $customRequest->request_status  = $request->request_status;
            $customRequest->assign_to  = $request->user_id;
            $customRequest->updated_by =  Auth::id();
            $customRequest->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('packageRequest');
        }
        catch (\Exception $e) {
            dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function getAllPackages() {
        return view('coursesetting::customize-packages.index');
    }

    public function getAllPackageData() {
        $query = Package::with('corporate_user')->where('package_type','1');
        if (check_whether_cp_or_not() || isPartner()) {
          $query->where('user_id', Auth::id());
        }
        return Datatables::of($query)
            ->addIndexColumn()
             ->addColumn('user',function($query) {
                 return $query->corporate_user->name;
            })
           ->addColumn('status', function ($query) {
                $approve = (isAdmin()) ? true : false;

                if ($approve) {
                    if (permissionCheck('package.change_status')) {
                        $status_enable_eisable = "status_enable_disable";
                    } else {
                        $status_enable_eisable = "";
                    }

                    $checked = $query->status == 1 ? "checked" : "";

                    $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                <input type="checkbox" class="' . $status_enable_eisable . '" id="active_checkbox' . $query->id . '" value="' . $query->id . '" ' . $checked . '>
                                <i class="slider round"></i>
                            </label>';
                } else {
                    if ($query->status == 1) {
                        $view = "Published";
                    } else {
                        $view = "Saved";
                    }
                }

                return $view;
            })
            ->addColumn('aprove_status', function ($query) {
                    if ($query->aprove_status == 1) {
                        $view = "Approved";
                    }else{
                        $view = "Not Approve";
                    }
               return $view;
            })
            ->editColumn('price', function($query) {
                return getPriceFormat($query->price);
            })
            ->addColumn('action', function ($query) {
                $course_edit = "";

                
                if (permissionCheck('customize.packages.edit')) {
                    $course_edit = '<a href="'.route('editCutomizePackage', $query->id).'" class="dropdown-item">'. __('common.Edit') .'</a>';
                }
                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $course_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['status','price', 'action','user'])
            ->make(true);
    }

    public function addPackage() {
        $id = Auth::id();
        $corporates = PackageCustomRequest::with('user')->where('assign_to',$id)->where("request_status",'!=',["Completed","Closed"])->get();
        return view('coursesetting::customize-packages.create', compact('corporates'));
    }
    public function editPackage($id) {
        $users_id = Auth::id();
        $package = Package::with('package_courses.course')->where('id', $id)->first();
        $query = PackageCustomRequest::with('user');
        if (check_whether_cp_or_not() || isPartner()) {
            $query = $query->where('assign_to', Auth::id());
        }
        $corporates = $query->get();
        $package_courses = [];
        foreach ($package->package_courses as $key => $value) {
            if (isset($value->course)) {
                $package_courses[$key]['id']    = $value->course->id;
                $package_courses[$key]['title'] = $value->course->title;
            }
        }
        return view('coursesetting::customize-packages.create', compact('package','corporates','package_courses'));
    }

    public function savePackage(Request $request) {
        
        $rules = [
            'name'              => "required",
            'price'             => "required",
            'expiry_period'     => "required",
            'description'       => "required",
        ];

        if ($request->has('image')) {
            $rules['image'] = "required|mimes:jpeg,bmp,png,jpg|max:5120";
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if ($request->has('package_id') && $request->package_id != '') {
                $package = Package::where('id', $request->package_id)->first();
                $oldData = Package::with('package_courses')->where('id',$request->package_id)->first();
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

            $package->corporate_id  = $request->user_id;
            $package->package_type = '1';
            $package->name          = $request->name;
            $package->price         = $request->price;
            $package->slug          = Str::slug($request->name, '-');
            $package->expiry_period = $request->expiry_period;
            $package->description   = $request->description;
            $package->total_courses = count($request->package_courses);
            if(isAdmin()){
               $package->status = $request->status;
               $package->aprove_status = $request->aprove_status; 
               $package->aproved_by  = ($request->aprove_status == 1) ? Auth::id() : '';
            }
            if (check_whether_cp_or_not() || isPartner()) {
                    $package->user_id     = Auth::id();
            }
            
            //$package->save();
             if ($package->save()) {
                if($request->package_courses != ''){
                foreach ($request->package_courses as $value) {
                    $package_course = PackageCourse::where('package_id', $package->id)->where('course_id', $value)->first();

                    if ($package_course == '') {
                        $package_course    = new PackageCourse();
                        $package_course->package_id = $package->id;
                        $package_course->course_id  = $value;
                        $package_course->save();
                    }
                }
            }
            } 
            if($request->has('package_id') && $request->package_id != ''){
            if (!empty($package->getChanges()) || $this->getCoursesChange($request->package_courses,$oldData) == true) {
                    $original = $oldData->getOriginal();
                    $changes = [];
                    $originalData = $this->getOriginalData($oldData,$original);
                    foreach ($this->getChagePackageData($package->getChanges(),$request->package_courses) as $key => $value) {
                        $changes[$key] = [
                            'original' => $originalData[$key],
                            'changes' => $value,
                        ];
                    }
                    auditTrailPackage::create([
                            'subject' => json_encode($changes),
                            'type' => '1',
                            'url' => url()->current(),
                            'ip' => request()->ip(),
                            "agent" => request()->userAgent(),
                            "user_id" => Auth::user()->id,
                            'package_id' => $package->id
                        ]
                    );
                }
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('getAllCustomizePackages');
        } catch (\Exception $e) {
            dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }
    public function getCoursesChange($requestData,$oldData){
                $courses = [];
                foreach($oldData->package_courses as $key => $values){
                    array_push($courses,$values->course_id);
                    }
                $result = array_diff($requestData,$courses);
                if(!empty($result)){
                    return true;
                }else{
                    return false;
                }
                
    }
    public function getChagePackageData($changeData,$requestData){
        $re = implode(',',$requestData);
                    $couseArray = [
                    'course_id' => $re,
                    ];
        $changePackageData = array_merge($changeData,$couseArray);
        return $changePackageData;
    }
    public function getOriginalData($oldData,$original){
        $courses = [];
        foreach($oldData->package_courses as $key => $values){
            array_push($courses,$values->course_id);
                }
        $arr = [
            'course_id' => implode(',',$courses),
            ];
        return array_merge($original,$arr);
    }


}

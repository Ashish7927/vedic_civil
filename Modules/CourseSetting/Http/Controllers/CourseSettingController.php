<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\LessonComplete;
use DB;
use App\User;
use Exception;
use App\Traits\Filepond;
use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\BundleSubscription\Entities\BundleCourse;
use Modules\BundleSubscription\Entities\BundleCoursePlan;

use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgMaterial;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
// use Vimeo\Vimeo;
use Yajra\DataTables\DataTables;
use Modules\Payment\Entities\Cart;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Modules\Quiz\Entities\OnlineQuiz;
use Illuminate\Support\Facades\Session;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuestionLevel;
use Modules\Setting\Model\GeneralSetting;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\Chapter;
use Modules\Localization\Entities\Language;
use Modules\CourseSetting\Entities\Category;
use Modules\Certificate\Entities\Certificate;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseExercise;
use Modules\AmazonS3\Http\Controllers\AmazonS3Controller;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Newsletter\Http\Controllers\MailchimpController;
use Modules\Newsletter\Http\Controllers\GetResponseController;
use App\Models\Group;
use App\Models\UserGroup;
use Modules\CourseSetting\Entities\CourseFeedback;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CourseSettingController extends Controller
{
    use Filepond;

    public function getSubscriptionList()
    {
        $list = [];

        try {
            $user = Auth::user();
            if ($user->subscription_method == "Mailchimp" && $user->subscription_api_status == 1) {
                $mailchimp = new MailchimpController();
                $mailchimp->mailchimp($user->subscription_api_key);
                $getlists = $mailchimp->mailchimpLists();
                foreach ($getlists as $key => $l) {
                    $list[$key]['name'] = $l['name'];
                    $list[$key]['id'] = $l['id'];
                }
            } elseif ($user->subscription_method == "GetResponse" && $user->subscription_api_status == 1) {
                $getResponse = new GetResponseController();
                $getResponse->getResponseApi($user->subscription_api_key);
                $getlists = $getResponse->getResponseLists();
                foreach ($getlists as $key => $l) {
                    $list[$key]['name'] = $l->name;
                    $list[$key]['id'] = $l->campaignId;
                }
            } elseif ($user->subscription_method == "Acelle" && $user->subscription_api_status == 1) {
                $acelleController = new AcelleController();

                $acelleController->getAcelleApiResponse();
                $getlists = $acelleController->getAcelleList();
                foreach ($getlists as $key => $l) {
                    $list[$key]['name'] = $l['name'];
                    $list[$key]['id'] = $l['uid'];
                }
            }
        } catch (\Exception $exception) {
        }
        return $list;
    }

    public function ajaxGetCourseSubCategory(Request $request)
    {
        try {
            $sub_categories = Category::where('parent_id', '=', $request->id)->get();
            return response()->json([$sub_categories]);
        } catch (Exception $e) {
            return response()->json("", 404);
        }
    }

    public function courseSortByCat($id)
    {
        try {
            if (!empty($id))
                $courses = Course::whereHas('enrolls')
                    ->where('category_id', $id)->with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons')->paginate(15);
            else
                $courses = Course::whereHas('enrolls')->with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons')->paginate(15);

            return response()->json([
                'courses' => $courses
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function getAllFeaturedCourseData(Request $request)
    {
        $query = Course::whereIn('type', [1, 2])->with('category', 'quiz', 'user');

        if (check_whether_cp_or_not() || isPartner()) {
            $query->whereHas('user', function ($q) {
                $q->where('id', auth()->user()->id);
            });
        }

        $query->where('courses.status', 1);

        $category = $request->category;
        if ($request->category != "") {
            $query->where(function($q) use($category){
                $q->where('category_id', $category)->orWhere('category_ids', 'LIKE', '%' . "," . $category . "," . '%');
            });
        }
        if ($request->type != "") {
            $query->where('type', $request->type);
        }
        if ($request->status != "") {
            $query->where('courses.status', $request->status);
        }
        if ($request->instructor != "") {
            $query->where('user_id', $request->instructor);
        }

        if ($request->from_duration != "" || $request->to_duration != "") {
            if ($request->from_duration != "" && $request->to_duration != "") {
                $query->where('duration', ">=", (int)$request->from_duration)->where("duration", "<=", (int)$request->to_duration);
            } elseif ($request->from_duration != "" && $request->to_duration == "") {
                $query->where('duration', "=", (int)$request->from_duration);
            } elseif ($request->from_duration == "" && $request->to_duration != "") {
                $query->where('duration', "=", (int)$request->to_duration);
            }
        }
        if (!empty($request->start_price)  && $request->start_price != "") {
            $query->where('price', '>=', $request->start_price);
        }
        if (!empty($request->end_price)  && $request->end_price != "") {
            $query->where('price', '<=', $request->end_price);
        }


        if ($request->total_rating != "") {
            $query->where('total_rating', $request->total_rating);
        }
        if ($request->content_provider != "") {
            $cp = $request->content_provider;
            $query->where('user_id', '=', $cp);

        }

        if ($request->from_submission_date != "" || $request->to_submission_date != "") {
            if ($request->from_submission_date != "" && $request->to_submission_date != "") {
                $query->whereDate('submitted_at', ">=", $request->from_submission_date)->whereDate("submitted_at", "<=", $request->to_submission_date);
            } elseif ($request->from_submission_date != "" && $request->to_submission_date == "") {
                $query->whereDate('submitted_at', ">=", $request->from_submission_date);
            } elseif ($request->from_submission_date == "" && $request->to_submission_date != "") {
                $query->whereDate('submitted_at', "<=", $request->to_submission_date);
            }
        }

        if (isInstructor()) {
            $query->where('user_id', '=', Auth::id());
        }

        if (isCourseReviewer()) {
            // $query->where('reviewer_id', '=', Auth::id());
            $query->latest('submitted_at');
        }

        $query->where('type', 1);
        $query->select('courses.*');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('type', function ($query) {
                return $query->type == 1 ? 'Course' : 'Quiz';
            })->addColumn('status', function ($query) {
                $approve = false;
                // if (isAdmin() || isHRDCorp() || isMyLL() || isPIC()) {
                if (isAdmin() || isHRDCorp() || isMyLL()) {
                    $approve = true;
                } else {
                    $courseApproval = Settings('course_approval');
                    if ($courseApproval == 0) {
                        $approve = true;
                    }
                }
                if ($query->status == 2 || $query->status == 0 || $query->status == 4) {
                    $approve = false;
                }

                if ($approve) {
                    if (permissionCheck('course.status_update')) {
                        $status_enable_eisable = "status_enable_disable";
                    } else {
                        $status_enable_eisable = "";
                    }
                    $checked = $query->status == 1 ? "checked" : "";
                    $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="' . $status_enable_eisable . '"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';
                } else {
                    if ($query->status == 1) {
                        $view = "Published";
                    } elseif ($query->status == 2) {
                        $view = "Saved";
                    } elseif ($query->status == 3) {
                        $view = "Approved";
                    } elseif ($query->status == 4) {
                        $view = "Rejected";
                    } else {
                        $view = "In Review";
                    }
                }


                return $view;
            })->addColumn('lessons', function ($query) {
                return $query->lessons->count();
            })
            ->addColumn('submitted_at', function ($query) {
                $date = '';
                if ($query->status == 0 || $query->status == 1 || $query->status == 3 || $query->status == 4) { //Pending
                    if ($query->submitted_at == null)
                        $date = showDate($query->updated_at);
                    else
                        $date = showDate($query->submitted_at);
                }
                return $date;
            })
            ->addColumn('published_at', function ($query) {
                $date = '';
                if ($query->status == 1) { //Active
                    $date = showDate($query->published_at);
                }
                return $date;
            })
            ->editColumn('category', function ($query) {
                if ($query->category) {
                    return $query->category->name;
                    if (isset($query->category_ids) || $query->category_id != 0) {
                        if (isset($query->category_ids)) {
                            $categoryIds = explode(",", $query->category_ids);
                            if ($query->category_id != 0) {
                                array_push($categoryIds, $query->category_id);
                                $categoryIds = array_unique($categoryIds);
                            }

                            $data = [];
                            foreach ($categoryIds as $categoryId) {
                                $categoryFindName = Category::where("id", $categoryId)->first();
                                if (isset($categoryFindName->name)) {
                                    $data[] = $categoryFindName->name;
                                }
                            }

                            $data = implode(";", $data);
                            return $data;
                        } else {
                            return $query->category->name;
                        }
                    } else {
                        return '';
                    }
                }
            })
            ->editColumn('quiz', function ($query) {
                if ($query->quiz) {
                    return $query->quiz->title;
                } else {
                    return '';
                }
            })->editColumn('user', function ($query) {
                if (isset($query->user) && $query->user->role_id == 7 || is_partner($query->user)) {
                    return $query->trainer;
                } elseif ($query->user) {
                    return $query->user->name;
                } else {
                    return '';
                }
            })->addColumn('enrolled_users', function ($query) {
                // return $query->enrollUsers->where('teach_via', 1)->count() . "/" . $query->enrollUsers->where('teach_via', 2)->count();
                return $query->enrollUsers->where('teach_via', 1)->count();
            })
            ->editColumn('scope', function ($query) {
                if ($query->scope == 1) {
                    $scope = trans('courses.Public');
                } else {
                    $scope = trans('courses.Private');
                }
                return $scope;
            })
            // ->addColumn('publishedDate', function ($query) {
            //     $date = '';
            //     //if($query->status == 1){ //Active
            //     $date = showDate($query->publishedDate);
            //     //}
            //     return $date;
            // })
            ->addColumn('price', function ($query) {
                $priceView = '';
                if ($query->discount_price != null) {
                    $priceView = '<span>' . getPriceFormat($query->discount_price) . '</span>';
                } else {
                    $priceView = '<span>' . getPriceFormat($query->price) . '</span>';
                }
                return $priceView;
            })->addColumn('approval_at', function ($query) {
                $date = '';
                //if($query->status == 3 || $query->status == 4){
                    $date = showDate($query->approval_at);
                //}
                return $date;
            })->addColumn('action', function ($query) {
                if (permissionCheck('course.details')) {
                    if ($query->type == 1) {
                        if ($query->curriculum_tab == 1) {
                            $course_detalis = '<a href="' . route('courseDetails', [$query->id]) . '" class="dropdown-item" >' . __('courses.Add Lesson') . '</a>';
                        } else {
                            $course_detalis = '<a href="' . route('courseDetails', [$query->id]) . '?type=courseDetails" class="dropdown-item" >' . __('courses.Add Lesson') . '</a>';
                        }
                    } else {
                        $course_detalis = "";
                    }
                } else {
                    $course_detalis = "";
                }

                if (permissionCheck('course.edit')) {


                    $title = 'data-title ="' . escapHtmlChar($query->title) . '"';

                    $course_edit = '<a href="' . route('featuredCourseDetails', [$query->id]) . '?type=courseDetails" class="dropdown-item" >' . __('common.Edit') . '</a>';
                } else {
                    $course_edit = "";
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                    <a target="_blank"
                                       href="' . courseDetailsUrl($query->id, $query->type, $query->slug) . '"
                                       class="dropdown-item"
                                    > ' . trans('courses.Frontend View') . '</a>

                                    ' . $course_edit . '

                                </div>
                                </div>';

                return $actioinView;
            })->rawColumns(['status', 'price', 'action', 'enrolled_users'])
            ->make(true);
    }

    public function getAllFeaturedCourse()
    {
        try {
            $user = Auth::user();

            $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();

            $courses = [];
            $categories = Category::where('status', 1)->get();
            $cps = User::where('role_id', 7)->get();

            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::latest()->get();
            } else {
                $quizzes = OnlineQuiz::where('created_by', $user->id)->latest()->get();
            }

            // $instructors = User::whereIn('role_id', [1, 2])->get();
            $instructors = [];
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $levels = CourseLevel::where('status', 1)->get();
            $title = trans('courses.All');

            $sub_lists = $this->getSubscriptionList();

            $durations = Course::get();

            return view('coursesetting::fearured_courses', compact('sub_lists', 'levels', 'video_list', 'vdocipher_list', 'title', 'quizzes', 'courses', 'categories', 'languages', 'instructors', 'cps', 'durations'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function featuredCourseDetails($id, $data = null)
    {
        $taggingData = [];
        $user = Auth::user();
        $course = Course::findOrFail($id);
        if ($course->type == 1) {

            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::where('status', 1)->where('category_id', $course->category_id)->latest()->get();
            } else {
                $quizzes = OnlineQuiz::where('status', 1)->where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
            }
        } else {
            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::where('status', 1)->get();
            } else {
                $quizzes = OnlineQuiz::where('status', 1)->where('created_by', $user->id)->get();
            }
        }

        if (isset($course->category_ids)) {
            $categoriesIds = explode(",", $course->category_ids);

            foreach ($categoriesIds as $categoriesId) {
                if (!empty($categoriesId)) {
                    $categoryFindName = Category::findOrFail($categoriesId);
                    $taggingData[] = [
                        'key' => $categoriesId,
                        'name' => $categoryFindName->name
                    ];
                }
            }
        }

        if ($quizzes->count() > 0) {
            $course->curriculum_tab = 1;
        }

        $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();
        if ($chapters->count() > 0) {
            $course->curriculum_tab = 1;
        }

        $course->detail_tab = 1;

        $categories = Category::where('status', 1)->get();
        $instructors = User::where('role_id', 2)->get();
        $reviewers = User::where('role_id', 10)->get();
        $languages = Language::select('id', 'native', 'code')
            ->where('status', '=', 1)
            ->get();
        $course_exercises = CourseExercise::where('course_id', $id)->get();

        $video_list = $this->getVimeoList();

        $vdocipher_list = $this->getVdoCipherList();


        $levels = CourseLevel::where('status', 1)->get();
        // if (Auth::user()->role_id == 1) {
        //     $certificates = Certificate::latest()->get();
        // } else {
        //     $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
        // }
        if ($course->price == 0 && $course->discount_price == null) {
            $certificates = Certificate::where('is_free', 1)->latest()->get();

            $first_certificate = Certificate::where('is_free', 1)->first();
            if ($first_certificate) {
                $course->certificate_id = $first_certificate->id;
                $course->certificate_tab = 1;
            }
        } else {
            $certificates = Certificate::where('is_free', 0)->latest()->get();

            $first_certificate = Certificate::where('is_free', 0)->first();
            if ($first_certificate) {
                $course->certificate_id = $first_certificate->id;
                $course->certificate_tab = 1;
            }
        }
        $course->save();

        return view('coursesetting::featured_course_details', compact('data', 'vdocipher_list', 'levels', 'video_list', 'course', 'chapters', 'categories', 'instructors', 'reviewers', 'languages', 'course_exercises', 'quizzes', 'certificates', 'taggingData'));
    }

    public function AdminUpdateFeaturedCourse(Request $request)
    {
            Session::flash('type', 'update');
            Session::flash('id', $request->id);

            if (demoCheck()) {
                return redirect()->back();
            }
            Session::flash('type', 'courseDetails');

            try {

                $course = Course::find($request->id);

                $course->feature = $request->feature;

                $course->updated_at = now();
                $course->submitted_at = now();

                $course->save();


                Session::forget('typeCourse');
                Toastr::success('Course has been submitted', trans('common.Success'));
                return redirect()->to(route('getAllFeaturedCourse'));
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
    }

    public function getAllCourse()
    {
        try {
            $user = Auth::user();

            // $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();

            $courses = [];
            $categories = Category::where('status', 1)->get();
            $cps = User::withoutGlobalScope('corporate')->whereIn('role_id', [7, 8])->get();

            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::latest()->get();
            } else {
                $quizzes = OnlineQuiz::where('created_by', $user->id)->latest()->get();
            }

            // $instructors = User::whereIn('role_id', [1, 2])->get();
            $instructors = [];
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $levels = CourseLevel::where('status', 1)->get();
            $title = trans('courses.All');

            $sub_lists = $this->getSubscriptionList();

            $durations = Course::get();

            return view('coursesetting::courses', compact('sub_lists', 'levels', 'vdocipher_list', 'title', 'quizzes', 'courses', 'categories', 'languages', 'instructors', 'cps', 'durations'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courseSortBy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $user = Auth::user();

            $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();

            $categories = Category::where('status', 1)->get();
            // $instructors = User::whereIn('role_id', [1, 2])->get();
            $instructors = [];
            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::latest()->get();
            } else {
                $quizzes = OnlineQuiz::where('created_by', $user->id)->latest()->get();
            }
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();


            $courses = Course::query();
            // $courses->where('active_status', 1);
            if ($request->category != "") {
                $courses->where('category_id', $request->category)->orWhere('category_ids', 'LIKE', '%' . $request->category . ',' . '%');
            }
            if ($request->type != "") {
                $courses->where('type', $request->type);
            } else {
                $courses->whereIn('type', [1, 2]);
            }
            if ($request->instructor != "") {
                $courses->where('user_id', $request->instructor);
            }
            if ($request->status != "") {
                $courses->where('status', $request->status);
            }
            if (Route::current()->getName() == 'getActiveCourse') {
                $courses->where('status', 1);
            }
            if (Route::current()->getName() == 'getPendingCourse') {
                $courses->where('status', 0);
            }

            if ($request->category) {
                $category_search = $request->category;
            } else {
                $category_search = '';
            }

            if ($request->type) {
                $category_type = $request->type;
            } else {
                $category_type = '';
            }

            if ($request->instructor) {
                $category_instructor = $request->instructor;
            } else {
                $category_instructor = '';
            }

            if ($request->search_status) {
                $category_status = $request->search_status;
            } else {
                $category_status = '';
            }

            $cps = User::where('role_id', 7)->get();
            $courses = $courses->with('user', 'category', 'subCategory', 'enrolls', 'lessons')->orderBy('id', 'desc')->get();

            $levels = CourseLevel::where('status', 1)->get();
            $sub_lists = $this->getSubscriptionList();
            return view('coursesetting::courses', compact('sub_lists', 'levels', 'category_search', 'vdocipher_list', 'category_instructor', 'category_type', 'category_status', 'video_list', 'quizzes', 'courses', 'categories', 'languages', 'instructors', 'cps'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function saveCourseValidation(Request $request)
    {
        if ($request->status_code == 2) {
            $rules = [
                'title' => 'required',
            ];
        }

        if ($request->status_code == 1) {
            $rules = [
                'language' => 'required',
                'title' => 'required',
                'duration' => 'required',
                'image' => 'required|mimes:jpeg,bmp,png,jpg|max:5120',
                'about' => 'required'

            ];
            $rules['course_type'] = 'required|not_in:0';
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'image.max' => 'The maximum file size of course thumbnail is 5MB.',
            'image.mimes' => 'Course thumbnail file format is not correct',
            'course_type.not_in' => 'The course type field is required.',
            'about.required' => 'The course description is required'
        ];

        // $validation = $this->validate($request, $rules, $messages);
        $validator  = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response['errors']  = $validator->errors()->all();
            $response['success'] = false;
            $response['status'] = 0;
            return response()->json($response);
        }
        $response['success'] = true;
        $response['status'] = 1;

        return response()->json($response);
    }

    public function saveCourse(Request $request)
    {
        if ($request->status_code == 1) {
            Session::flash('type', 'store');

            if (demoCheck()) {
                return redirect()->back();
            }

            if ($request->type == 1) {
                $rules = [
                    'level' => 'required',
                ];
                $this->validate($request, $rules, validationMessage($rules));

                if (isset($request->show_overview_media)) {

                    $rules = [
                        'host' => 'required',
                    ];
                    $this->validate($request, $rules, validationMessage($rules));

                    if ($request->get('host') == "VdoCipher") {
                        $rules = [
                            'vdocipher' => 'required',
                        ];
                        $this->validate($request, $rules, validationMessage($rules));
                    }
                }
            }


            try {
                if (!empty($request->image)) {
                    $course = new Course();
                    $fileName = "";
                    if ($request->hasFile('image')) {

                        $strpos = strpos($request->image, ';');
                        $sub = substr($request->image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->image);
                        //                    $img->resize(800, 500);
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->image = 'uploads/courses/' . $name;

                        $strpos = strpos($request->image, ';');
                        $sub = substr($request->image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->image);
                        //                    $img->resize(270, 181);
                        $img->resize(270, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->thumbnail = 'uploads/courses/' . $name;
                    }

                    if ($request->hasFile('trainer_image')) {

                        $strpos = strpos($request->trainer_image, ';');
                        $sub = substr($request->trainer_image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->trainer_image);
                        //                    $img->resize(270, 181);
                        $img->resize(270, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->trainer_image = 'uploads/courses/' . $name;
                    }

                    $course->user_id = Auth::id();
                    if ($request->type == 1) {
                        if ($request->input("category_ids")) {
                            $category_ids = $request->input('category_ids');
                            $categoryIds = implode(",", $category_ids);
                            $categoryIds = "," . $categoryIds . ",";
                            $course->category_ids = $categoryIds;
                        }
                        $course->quiz_id = null;
                        $course->category_id = $request->category;
                        $course->subcategory_id = $request->sub_category;
                    } elseif ($request->type == 2) {
                        $course->quiz_id = $request->quiz;
                        $course->category_id = null;
                        $course->subcategory_id = null;
                    }


                    $course->lang_id = $request->language;
                    $course->scope = $request->scope;
                    $course->title = $request->title;
                    $course->slug = null;
                    $course->duration = $request->duration;


                    if ($request->is_discount == 1) {
                        $course->discount_price = $request->discount_price;
                        $course->discount_start_date = $request->discount_start_date;
                        $course->discount_end_date = $request->discount_end_date;
                    } else {
                        $course->discount_price = null;
                        $course->discount_start_date = null;
                        $course->discount_end_date = null;
                    }
                    if ($request->is_free == 1) {
                        $course->price = 0;
                        $course->discount_price = null;
                        $course->discount_start_date = null;
                        $course->discount_end_date = null;
                    } else {
                        $course->price = $request->price;
                    }


                    $course->publish = 1;
                    $course->status = 0;
                    $course->level = $request->level;

                    $course->mode_of_delivery = $request->mode_of_delivery;

                    $course->show_overview_media = $request->show_overview_media ? 1 : 0;
                    $course->host = $request->host;
                    $course->subscription_list = $request->subscription_list;

                    if (!empty($request->assign_instructor)) {
                        $course->user_id = $request->assign_instructor;
                    }

                    if ($request->get('host') == "VdoCipher") {
                        $course->trailer_link = $request->vdocipher;
                    } else {
                        $course->trailer_link = null;
                    }


                    if (!empty($request->assign_instructor)) {
                        $course->user_id = $request->assign_instructor;
                    }

                    $course->meta_keywords = $request->meta_keywords;
                    $course->meta_description = $request->meta_description;
                    $course->is_subscription = $request->is_subscription;
                    $course->about = $request->about;
                    $course->requirements = $request->requirements;
                    $course->outcomes = $request->outcomes;
                    $course->type = $request->type;
                    $course->drip = $request->drip;
                    $course->complete_order = $request->complete_order;
                    if (isset($request->course_type)) {
                        $course->course_type = $request->course_type;
                    }
                    if (isset($request->trainer)) {
                        $course->trainer = $request->trainer;
                    }

                    if (isset($request->declaration)) {
                        if ($request->declaration == 'on')
                            $course->declaration = 1; //Yes
                        else
                            $course->declaration = 0; //No
                    } else {
                        $course->declaration = 0; //No
                    }
                    if (Settings('frontend_active_theme') == "edume") {
                        $course->what_learn1 = $request->what_learn1;
                        $course->what_learn2 = $request->what_learn2;
                    }
                    $course->save();
                    $course->detail_tab = 1;
                    $course->save();
                }

                $getCourseAfterSave = Course::withoutGlobalScope('withoutsubscription')->latest()->first();

                Toastr::success('Course has been submitted', trans('common.Success'));

                return redirect()->to(route('courseDetails', [$getCourseAfterSave->id]) . '?type=courseDetails');
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else {
            $rules = [
                'title' => 'required',
            ];
            $messages = [
                'required' => 'The :attribute field is required.',
            ];

            $this->validate($request, $rules, $messages);
            Session::flash('type', 'store');

            if (demoCheck()) {
                return redirect()->back();
            }

            try {
                $course = new Course();
                if (!empty($request->image)) {
                    $fileName = "";
                    if ($request->hasFile('image')) {
                        $strpos = strpos($request->image, ';');
                        $sub = substr($request->image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->image);
                        //                    $img->resize(800, 500);
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->image = 'uploads/courses/' . $name;

                        $strpos = strpos($request->image, ';');
                        $sub = substr($request->image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->image);
                        //                    $img->resize(270, 181);
                        $img->resize(270, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->thumbnail = 'uploads/courses/' . $name;
                    }
                }
                if (!empty($request->trainer_image)) {
                    if ($request->hasFile('trainer_image')) {

                        $strpos = strpos($request->trainer_image, ';');
                        $sub = substr($request->trainer_image, 0, $strpos);
                        $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                        $img = Image::make($request->trainer_image);
                        //                    $img->resize(270, 181);
                        $img->resize(270, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $upload_path = 'uploads/courses/';
                        $img->save($upload_path . $name);
                        $course->trainer_image = 'uploads/courses/' . $name;
                    }
                } else {
                    if (file_exists($course->trainer_image) && $request->trainer_image_placeholder == '') {
                        unlink($course->trainer_image);
                        $course->trainer_image = $request->trainer_image;
                    }
                }


                $course->user_id = Auth::id();
                if ($request->type == 1) {
                    if ($request->input("category_ids")) {
                        $category_ids = $request->input('category_ids');
                        $categoryIds = implode(",", $category_ids);
                        $categoryIds = "," . $categoryIds . ",";
                        $course->category_ids = $categoryIds;
                    }
                    $course->quiz_id = null;
                    $course->category_id = $request->category;
                    $course->subcategory_id = $request->sub_category;
                } elseif ($request->type == 2) {
                    $course->quiz_id = $request->quiz;
                    $course->category_id = null;
                    $course->category_ids = null;
                    $course->subcategory_id = null;
                }


                $course->lang_id = $request->language;
                $course->scope = $request->scope;
                $course->title = $request->title;
                $course->slug = null;
                $course->duration = $request->duration;


                if ($request->is_discount == 1) {
                    $course->discount_price = $request->discount_price;
                    $course->discount_start_date = $request->discount_start_date;
                    $course->discount_end_date = $request->discount_end_date;
                } else {
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                }
                if ($request->is_free == 1) {
                    $course->price = 0;
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                } else {
                    $course->price = $request->price;
                }


                $course->publish = 1;
                $course->status = 0;
                $course->level = $request->level;

                $course->mode_of_delivery = $request->mode_of_delivery;

                $course->show_overview_media = $request->show_overview_media ? 1 : 0;
                $course->host = $request->host;
                $course->subscription_list = $request->subscription_list;

                if (!empty($request->assign_instructor)) {
                    $course->user_id = $request->assign_instructor;
                }

                if ($request->get('host') == "VdoCipher") {
                    $course->trailer_link = $request->vdocipher;
                } else {
                    $course->trailer_link = null;
                }


                if (!empty($request->assign_instructor)) {
                    $course->user_id = $request->assign_instructor;
                }

                $course->meta_keywords = $request->meta_keywords;
                $course->meta_description = $request->meta_description;
                $course->is_subscription = $request->is_subscription;
                $course->about = $request->about;
                $course->requirements = $request->requirements;
                $course->outcomes = $request->outcomes;
                $course->type = $request->type;
                $course->drip = $request->drip;
                $course->complete_order = $request->complete_order;
                if (isset($request->course_type)) {
                    $course->course_type = $request->course_type;
                }
                if (isset($request->trainer)) {
                    $course->trainer = $request->trainer;
                }

                if (isset($request->declaration)) {
                    if ($request->declaration == 'on')
                        $course->declaration = 1; //Yes
                    else
                        $course->declaration = 0; //No
                } else {
                    $course->declaration = 0; //No
                }
                if (Settings('frontend_active_theme') == "edume") {
                    $course->what_learn1 = $request->what_learn1;
                    $course->what_learn2 = $request->what_learn2;
                }
                $course->status = 2;
                $course->save();
                $course->detail_tab = 1;
                $course->save();

                $getCourseAfterSave = Course::withoutGlobalScope('withoutsubscription')->latest()->first();


                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->to(route('courseDetails', [$getCourseAfterSave->id]) . '?type=courseDetails');
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        }
    }

    public function uploadFileIntoVimeo($course_title, $file)
    {
        try {
            $response = $this->configVimeo()->upload($file, [
                'name' => $course_title,
                'privacy' => [
                    'view' => 'disable',
                    'embed' => 'whitelist'
                ],
                'embed' => [
                    'title' => [
                        'name' => 'hide',
                        'owner' => 'hide',
                    ]
                ]
            ]);
            $this->configVimeo()->request($response . '/privacy/domains/' . request()->getHttpHost(), [], 'PUT');
            return $response;
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return null;
        }
    }

    public function AdminUpdateCourseValidation(Request $request)
    {

        if ($request->status_code == 2) {
            $rules = [
                'title' => 'required',
            ];
        }
        if ($request->status_code == 1 || $request->status_code == 4) {
            $rules = [
                // 'type' => 'required',
                'language' => 'required',
                'title' => 'required',
                'outcomes' => 'required',
                'image' => 'nullable|mimes:jpeg,bmp,png,jpg|max:5120',
                'requirements' => 'required',
                'about' => 'required'
            ];
            $rules['course_type'] = 'required|not_in:0';
            $rules['trainer'] = 'required';
        }
        if ($request->status_code == 0) {
            $rules = [];
        }
        $messages = [
            'required' => 'The :attribute field is required.',
            'image.max' => 'The maximum file size of course thumbnail is 5MB.',
            'image.mimes' => 'Course thumbnail file format is not correct',
            'course_type.not_in' => 'The course type field is required.',
            'about.required' => 'The course description is required',
            'requirements.required' => 'The course requirements is required'
        ];

        // $this->validate($request, $rules, $messages);
        $validator  = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response['errors']  = $validator->errors()->all();
            $response['success'] = false;
            $response['status'] = 0;
            return response()->json($response);
        }
        $response['success'] = true;
        $response['status'] = 1;

        return response()->json($response);
    }

    public function AdminUpdateCourse(Request $request)
    {
        if ($request->status_code == 1) {
            Session::flash('type', 'update');
            Session::flash('id', $request->id);

            if (demoCheck()) {
                return redirect()->back();
            }
            Session::flash('type', 'courseDetails');


            if ($request->type == 1) {
                $rules = [
                    'duration' => 'required',
                    'level' => 'required'
                ];
                $this->validate($request, $rules, validationMessage($rules));

                if (isset($request->show_overview_media)) {

                    if ($request->get('host') == "VdoCipher") {
                        $rules = [
                            'vdocipher' => 'required',
                        ];
                        $this->validate($request, $rules, validationMessage($rules));
                    } else {
                    }
                }
            }


            try {

                $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
                $course->scope = $request->scope;
                if ($request->file('image') != "") {
                    $strpos = strpos($request->image, ';');
                    $sub = substr($request->image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->image);
                    //                $img->resize(800, 500);
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->image = 'uploads/courses/' . $name;

                    $strpos = strpos($request->image, ';');
                    $sub = substr($request->image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->image);
                    //                $img->resize(270, 181);
                    $img->resize(270, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->thumbnail = 'uploads/courses/' . $name;
                }

                if ($request->file('trainer_image') != "") {

                    $strpos = strpos($request->trainer_image, ';');
                    $sub = substr($request->trainer_image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->trainer_image);
                    //                $img->resize(270, 181);
                    $img->resize(270, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->trainer_image = 'uploads/courses/' . $name;
                } else {
                    if (file_exists($course->trainer_image) && $request->trainer_image_placeholder == '') {
                        unlink($course->trainer_image);
                        $course->trainer_image = $request->trainer_image;
                    }
                }


                if (!empty($request->assign_instructor)) {
                    $course->user_id = $request->assign_instructor;
                }
                $course->drip = $request->drip;
                $course->complete_order = $request->complete_order;
                $course->lang_id = $request->language;
                $course->title = $request->title;
                $course->duration = $request->duration;
                $course->subscription_list = $request->subscription_list;


                if ($request->is_discount == 1) {
                    $old_discount_price = $course->discount_price;
                    $course->discount_price = $request->discount_price;
                    $course->discount_start_date = $request->discount_start_date;
                    $course->discount_end_date = $request->discount_end_date;

                    if ($old_discount_price != $request->discount_price) {
                        $carts = Cart::where('course_id', $request->id)->get();

                        foreach ($carts as $cart) {
                            $cart->price = $request->discount_price;
                            $cart->save();
                        }
                    }
                } else {
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                }
                if ($request->is_free == 1) {
                    $course->price = 0;
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                } else {
                    $course->price = $request->price;
                }


                $course->level = $request->level;
                $course->mode_of_delivery = $request->mode_of_delivery;

                $course->show_overview_media = $request->show_overview_media ? 1 : 0;
                if ($request->get('host') == "VdoCipher") {
                    $course->trailer_link = $request->vdocipher;
                } else {
                    $course->trailer_link = null;
                }
                $course->host = $request->host;
                $course->meta_keywords = $request->meta_keywords;
                $course->meta_description = $request->meta_description;
                $course->is_subscription = $request->is_subscription;
                $course->about = $request->about;
                $course->type = $request->type;
                if ($request->type == null) {
                    $course->type = 1;
                    $request->type = 1;
                }
                $course->requirements = $request->requirements;
                $course->outcomes = $request->outcomes;
                if ($request->type == 1) {
                    if ($request->input("category_ids")) {
                        $category_ids = $request->input('category_ids');
                        $categoryIds = implode(",", $category_ids);
                        $categoryIds = "," . $categoryIds . ",";
                        $course->category_ids = $categoryIds;
                    }
                    $course->quiz_id = null;
                    $course->category_id = $request->category;
                    $course->subcategory_id = $request->sub_category;
                } elseif ($request->type == 2) {
                    $course->quiz_id = $request->quiz;
                    $course->category_id = null;
                    $course->category_ids = null;
                    $course->subcategory_id = null;
                }

                if (isset($request->course_type)) {
                    $course->course_type = $request->course_type;
                }
                if (isset($request->trainer)) {
                    $course->trainer = $request->trainer;
                }


                if (Settings('frontend_active_theme') == "edume") {
                    $course->what_learn1 = $request->what_learn1;
                    $course->what_learn2 = $request->what_learn2;
                }

                if (check_whether_cp_or_not() || isPartner()) {
                    if ($course->status == 4) {
                        $reviewer_id = $course->reviewer_id;
                        $reviewer = User::find($reviewer_id);
                        $user_id = $course->user_id;
                        $user = User::find($user_id);
                        if ($reviewer) {
                            $type_of_mail = 2;
                            course_send_email($type_of_mail, 'course_updated', $request, $reviewer, $user);
                        }
                    } else {
                        $users = User::whereHas('role', function ($query) {
                            // return $query->where('name', 'PIC');
                            return $query->where('name', 'Course Reviewer');
                        })->get();

                        $type_of_mail = 2;
                        new_course_submitted($type_of_mail, $request, $users);
                    }
                }

                if ($course->status == 1) {
                    $course->status = 1;
                } else {
                    $course->status = 0;
                }


                $course->save();
                $course->updated_at = now();
                $course->submitted_at = now();
                $course->detail_tab = 1;
                $course->save();

                if ((isAdmin() || isHRDCorp() || isMyLL() && $course->status == 1) || (check_whether_cp_or_not() || isPartner() && $course->status == 0 && $request->update_course_status == 1)){
                        $type = '';
                        if (!(Session::get('typeCourse'))) {
                            if ($_GET['typeUpdateCourse'] == 'courseDetails') {
                                $type = 'courses';
                            }

                            if ($_GET['typeUpdateCourse'] == 'courses') {
                                $type = 'files';
                            }
                            Session::put('typeCourse', $type);
                        } else {
                            if (Session::get('typeCourse') == 'courseDetails') {
                                $type = 'courses';
                                Session::put('typeCourse', $type);
                            } elseif (Session::get('typeCourse') == 'courses') {
                                $type = 'files';
                                Session::put('typeCourse', $type);
                            } elseif (Session::get('typeCourse') == 'files') {
                                Session::put('typeCourse', "certificates");
                            } elseif (Session::get('typeCourse') == 'certificates') {
                                Session::put('typeCourse', "courseDetails");
                            }
                        }

                        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                        if ($request->update_course_status == 2) {
                            return redirect()->to(route("getAllCourse"));
                        }
                        if (!!Session::get('typeCourse')) {
                            return redirect()->to(route('courseDetails', [$course->id]) . '?type=' . Session::get('typeCourse'));
                        }

                        return redirect()->back();

                }

                Session::forget('typeCourse');
                Toastr::success('Course has been submitted', trans('common.Success'));
                return redirect()->to(route('getAllCourse'));
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } elseif ($request->status_code == 2 || $request->status_code == 4) {
            Session::flash('type', 'update');
            Session::flash('id', $request->id);

            $rules = [
                'title' => 'required',
            ];
            $messages = [
                'required' => 'The :attribute field is required.',
            ];

            $this->validate($request, $rules, $messages);

            if (demoCheck()) {
                return redirect()->back();
            }
            Session::flash('type', 'courseDetails');


            try {

                $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
                $course->scope = $request->scope;
                if ($request->file('image') != "") {
                    $strpos = strpos($request->image, ';');
                    $sub = substr($request->image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->image);
                    //                $img->resize(800, 500);
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->image = 'uploads/courses/' . $name;

                    $strpos = strpos($request->image, ';');
                    $sub = substr($request->image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->image);
                    //                $img->resize(270, 181);
                    $img->resize(270, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->thumbnail = 'uploads/courses/' . $name;
                }

                if ($request->file('trainer_image') != "") {

                    $strpos = strpos($request->trainer_image, ';');
                    $sub = substr($request->trainer_image, 0, $strpos);
                    $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                    $img = Image::make($request->trainer_image);
                    //                $img->resize(270, 181);
                    $img->resize(270, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $upload_path = 'uploads/courses/';
                    $img->save($upload_path . $name);
                    $course->trainer_image = 'uploads/courses/' . $name;
                } else {
                    if (file_exists($course->trainer_image) && $request->trainer_image_placeholder == '') {
                        unlink($course->trainer_image);
                        $course->trainer_image = $request->trainer_image;
                    }
                }

                // $course->user_id = Auth::id();

                if (!empty($request->assign_instructor)) {
                    $course->user_id = $request->assign_instructor;
                }

                $course->drip = $request->drip;
                $course->complete_order = $request->complete_order;
                $course->lang_id = $request->language;
                $course->title = $request->title;
                $course->duration = $request->duration;
                // $course->feature = $request->feature;
                $course->subscription_list = $request->subscription_list;

                if ($request->is_discount == 1) {
                    $old_discount_price = $course->discount_price;
                    $course->discount_price = $request->discount_price;
                    $course->discount_start_date = $request->discount_start_date;
                    $course->discount_end_date = $request->discount_end_date;

                    if ($old_discount_price != $request->discount_price) {
                        $carts = Cart::where('course_id', $request->id)->get();

                        foreach ($carts as $cart) {
                            $cart->price = $request->discount_price;
                            $cart->save();
                        }
                    }
                } else {
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                }
                if ($request->is_free == 1) {
                    $course->price = 0;
                    $course->discount_price = null;
                    $course->discount_start_date = null;
                    $course->discount_end_date = null;
                } else {
                    $course->price = $request->price;
                }


                $course->level = $request->level;
                $course->mode_of_delivery = $request->mode_of_delivery;

                $course->show_overview_media = $request->show_overview_media ? 1 : 0;
                if ($request->get('host') == "VdoCipher") {
                    $course->trailer_link = $request->vdocipher;
                } else {
                    $course->trailer_link = null;
                }
                $course->host = $request->host;
                $course->meta_keywords = $request->meta_keywords;
                $course->meta_description = $request->meta_description;
                $course->is_subscription = $request->is_subscription;
                $course->about = $request->about;
                $course->type = $request->type;
                $course->requirements = $request->requirements;
                $course->outcomes = $request->outcomes;
                if ($request->type == null) {
                    $course->type = 1;
                    $request->type = 1;
                }
                if ($request->type == 1) {
                    if ($request->input("category_ids")) {
                        $category_ids = $request->input('category_ids');
                        $categoryIds = implode(",", $category_ids);
                        $categoryIds = "," . $categoryIds . ",";
                        $course->category_ids = $categoryIds;
                    }
                    $course->quiz_id = null;
                    $course->category_id = $request->category;
                    $course->subcategory_id = $request->sub_category;
                } elseif ($request->type == 2) {
                    $course->quiz_id = $request->quiz;
                    $course->category_ids = null;
                    $course->category_id = null;
                    $course->subcategory_id = null;
                }

                if (isset($request->course_type)) {
                    $course->course_type = $request->course_type;
                }
                if (isset($request->trainer)) {
                    $course->trainer = $request->trainer;
                }



                if (Settings('frontend_active_theme') == "edume") {
                    $course->what_learn1 = $request->what_learn1;
                    $course->what_learn2 = $request->what_learn2;
                }

                if ($request->status_code == 4) {
                    $course->status = 4;
                } elseif ($request->status_code == 2) {
                    $course->status = 2;
                }
                $course->save();
                $course->updated_at = now();
                $course->detail_tab = 1;
                $course->save();

                $type = '';
                if (!(Session::get('typeCourse'))) {
                    if ($_GET['typeUpdateCourse'] == 'courseDetails') {
                        $type = 'courses';
                    }

                    if ($_GET['typeUpdateCourse'] == 'courses') {
                        $type = 'files';
                    }
                    Session::put('typeCourse', $type);
                } else {
                    if (Session::get('typeCourse') == 'courseDetails') {
                        $type = 'courses';
                        Session::put('typeCourse', $type);
                    } elseif (Session::get('typeCourse') == 'courses') {
                        $type = 'files';
                        Session::put('typeCourse', $type);
                    } elseif (Session::get('typeCourse') == 'files') {
                        Session::put('typeCourse', "certificates");
                    } elseif (Session::get('typeCourse') == 'certificates') {
                        Session::put('typeCourse', "courseDetails");
                    }
                }

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                if ((isAdmin() || isHRDCorp() || isMyLL())) {
                    if ($request->update_course_status == 2) {
                        return redirect()->to(route("getAllCourse"));
                    }
                }

                if ($request->update_course_status == 4) {
                    return redirect()->to(route("getAllCourse"));
                }
                if (!!Session::get('typeCourse')) {
                    return redirect()->to(route('courseDetails', [$course->id]) . '?type=' . Session::get('typeCourse'));
                }

                return redirect()->back();
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else {
            $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);

            if ($request->file('image') != "") {
                $strpos = strpos($request->image, ';');
                $sub = substr($request->image, 0, $strpos);
                $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                $img = Image::make($request->image);
                //                $img->resize(800, 500);
                $upload_path = 'uploads/courses/';
                $img->save($upload_path . $name);
                $course->image = 'uploads/courses/' . $name;

                $strpos = strpos($request->image, ';');
                $sub = substr($request->image, 0, $strpos);
                $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                $img = Image::make($request->image);
                //                $img->resize(270, 181);
                $img->resize(270, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $upload_path = 'uploads/courses/';
                $img->save($upload_path . $name);
                $course->thumbnail = 'uploads/courses/' . $name;

                $course->updated_at = now();
                $course->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            }


            $type = '';
            if (!(Session::get('typeCourse'))) {
                if ($_GET['typeUpdateCourse'] == 'courseDetails') {
                    $type = 'courses';
                }

                if ($_GET['typeUpdateCourse'] == 'courses') {
                    $type = 'files';
                }
                Session::put('typeCourse', $type);
            } else {
                if (Session::get('typeCourse') == 'courseDetails') {
                    $type = 'courses';
                    Session::put('typeCourse', $type);
                } elseif (Session::get('typeCourse') == 'courses') {
                    $type = 'files';
                    Session::put('typeCourse', $type);
                } elseif (Session::get('typeCourse') == 'files') {
                    Session::put('typeCourse', "certificates");
                } elseif (Session::get('typeCourse') == 'certificates') {
                    Session::put('typeCourse', "courseDetails");
                }
            }

            if (!!Session::get('typeCourse')) {
                return redirect()->to(route('courseDetails', [$course->id]) . '?type=' . Session::get('typeCourse'));
            }
        }
    }

    public function AdminUpdateCourseCertificate(Request $request)
    {

        Session::flash('type', 'update');
        Session::flash('id', $request->course_id);

        if (demoCheck()) {
            return redirect()->back();
        }
        Session::flash('type', 'courseDetails');


        $rules = [
            'certificate' => 'required',

        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {

            $course = Course::find($request->course_id);
            $course->certificate_id = $request->certificate;
            $course->save();
            $course->certificate_tab = 1;
            $course->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function CourseQuetionShow($question_id, $id, $chapter_id, $lesson_id)
    {
        try {
            $taggingData = [];
            $levels = QuestionLevel::get();
            $groups = QuestionGroup::get();
            $banks = [];
            $bank = QuestionBank::with('category', 'subCategory', 'questionGroup')->find($question_id);
            $categories = Category::where('status', 1)->get();
            $data = [];
            $data['lesson_id'] = $lesson_id;
            $data['chapter_id'] = $chapter_id;
            $data['edit_chapter_id'] = $chapter_id;

            $user = Auth::user();
            $course = Course::withoutGlobalScope('withoutsubscription')->findOrFail($id);
            if ($course->type == 1) {

                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->latest()->get();
                } else {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
                }
            } else {
                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('active_status', 1)->get();
                } else {
                    $quizzes = OnlineQuiz::where('created_by', $user->id)->where('active_status', 1)->get();
                }
            }

            if (isset($course->category_ids)) {
                $categoriesIds = explode(",", $course->category_ids);

                foreach ($categoriesIds as $categoriesId) {
                    if (!empty($categoriesId)) {
                        $categoryFindName = Category::findOrFail($categoriesId);
                        $taggingData[] = [
                            'key' => $categoriesId,
                            'name' => $categoryFindName->name
                        ];
                    }
                }
            }

            $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();


            $categories = Category::where('status', 1)->get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $course_exercises = CourseExercise::where('course_id', $id)->get();

            $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();
            $levels = CourseLevel::where('status', 1)->get();
            if (Auth::user()->role_id == 1) {
                $certificates = Certificate::latest()->get();
            } else {
                $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
            }


            // return $quizzes;
            return view('coursesetting::course_details', compact('data', 'bank', 'vdocipher_list', 'levels', 'video_list', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'quizzes', 'certificates', 'taggingData'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function CourseLessonShow($id, $chapter_id, $lesson_id)
    {
        try {
            $taggingData = [];
            $data = [];
            $data['edit_lesson_id'] = $lesson_id;
            $data['chapter_id'] = $chapter_id;

            $user = Auth::user();
            $course = Course::withoutGlobalScope('withoutsubscription')->findOrFail($id);
            if ($course->type == 1) {
                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->latest()->get();
                } else {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
                }
            } else {
                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('active_status', 1)->get();
                } else {
                    $quizzes = OnlineQuiz::where('created_by', $user->id)->where('active_status', 1)->get();
                }
            }

            if (isset($course->category_ids)) {
                $categoriesIds = explode(",", $course->category_ids);

                foreach ($categoriesIds as $categoriesId) {
                    if (!empty($categoriesId)) {
                        $categoryFindName = Category::findOrFail($categoriesId);
                        $taggingData[] = [
                            'key' => $categoriesId,
                            'name' => $categoryFindName->name
                        ];
                    }
                }
            }

            $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();

            $categories = Category::where('status', 1)->get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $course_exercises = CourseExercise::where('course_id', $id)->get();

            $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();

            $levels = CourseLevel::where('status', 1)->get();
            if (Auth::user()->role_id == 1) {
                $certificates = Certificate::latest()->get();
            } else {
                $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
            }
            // $editChapter = Chapter::where('id', $chapter_id)->first();
            $editLesson = Lesson::where('id', $lesson_id)->first();


            $data['isDefault'] = false;
            if (isModuleActive('Org')) {
                $material = OrgMaterial::where('link', $editLesson->video_url)->first();
                if ($material) {
                    $data['isDefault'] = false;
                } else {
                    $data['isDefault'] = true;
                }
            }

            return view('coursesetting::course_details', $data, compact('data', 'editLesson', 'levels', 'video_list', 'vdocipher_list', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'quizzes', 'certificates', 'taggingData'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function CourseChapterShow($id, $chapter_id)
    {
        try {
            $taggingData = [];
            $data = [];
            $data['chapter_id'] = $chapter_id;

            $user = Auth::user();
            $course = Course::withoutGlobalScope('withoutsubscription')->findOrFail($id);
            if ($course->type == 1) {

                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->latest()->get();
                } else {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
                }
            } else {
                if ($user->role_id == 1) {
                    $quizzes = OnlineQuiz::where('active_status', 1)->get();
                } else {
                    $quizzes = OnlineQuiz::where('created_by', $user->id)->where('active_status', 1)->get();
                }
            }

            if (isset($course->category_ids)) {
                $categoriesIds = explode(",", $course->category_ids);

                foreach ($categoriesIds as $categoriesId) {
                    if (!empty($categoriesId)) {
                        $categoryFindName = Category::findOrFail($categoriesId);
                        $taggingData[] = [
                            'key' => $categoriesId,
                            'name' => $categoryFindName->name
                        ];
                    }
                }
            }

            $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();

            $categories = Category::where('status', 1)->get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $course_exercises = CourseExercise::where('course_id', $id)->get();

            $video_list = $this->getVimeoList();
            $vdocipher_list = $this->getVdoCipherList();

            $levels = CourseLevel::where('status', 1)->get();
            if (Auth::user()->role_id == 1) {
                $certificates = Certificate::latest()->get();
            } else {
                $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
            }
            $editChapter = Chapter::where('id', $chapter_id)->first();

            return view('coursesetting::course_details', compact('data', 'editChapter', 'levels', 'video_list', 'vdocipher_list', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'quizzes', 'certificates', 'taggingData'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function courseDetails($id, $data = null)
    {
        $taggingData = [];
        $user = Auth::user();
        $course = Course::withoutGlobalScope('withoutsubscription')->findOrFail($id);
        if ($course->type == 1) {

            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::where('status', 1)->where('category_id', $course->category_id)->latest()->get();
            } else {
                $quizzes = OnlineQuiz::where('status', 1)->where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
            }
        } else {
            if ($user->role_id == 1) {
                $quizzes = OnlineQuiz::where('status', 1)->get();
            } else {
                $quizzes = OnlineQuiz::where('status', 1)->where('created_by', $user->id)->get();
            }
        }

        if (isset($course->category_ids)) {
            $categoriesIds = explode(",", $course->category_ids);

            foreach ($categoriesIds as $categoriesId) {
                if (!empty($categoriesId)) {
                    $categoryFindName = Category::findOrFail($categoriesId);
                    $taggingData[] = [
                        'key' => $categoriesId,
                        'name' => $categoryFindName->name
                    ];
                }
            }
        }


        $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();

        if ($chapters->count() > 0 || $quizzes->count() > 0) {
            $course->curriculum_tab = 1;
        } else {
            $course->curriculum_tab = 0;
        }
        
        $course->detail_tab = 1;

        $categories = Category::where('status', 1)->get();
        $instructors = User::where('role_id', 2)->get();
        $reviewers = User::where('role_id', 10)->get();
        $languages = Language::select('id', 'native', 'code')
            ->where('status', '=', 1)
            ->get();
        $course_exercises = CourseExercise::where('course_id', $id)->get();

        $video_list = $this->getVimeoList();

        $vdocipher_list = $this->getVdoCipherList();


        $levels = CourseLevel::where('status', 1)->get();

        if ($course->price == 0 && $course->discount_price == null) {
            $certificates = Certificate::where('is_free', 1)->latest()->get();

            $first_certificate = Certificate::where('is_free', 1)->first();
            if ($first_certificate) {
                $course->certificate_id = $first_certificate->id;
                $course->certificate_tab = 1;
            }
        } else {
            $certificates = Certificate::where('is_free', 0)->latest()->get();

            $first_certificate = Certificate::where('is_free', 0)->first();
            if ($first_certificate) {
                $course->certificate_id = $first_certificate->id;
                $course->certificate_tab = 1;
            }
        }
        $course->save();

        return view('coursesetting::course_details', compact('data', 'vdocipher_list', 'levels', 'video_list', 'course', 'chapters', 'categories', 'instructors', 'reviewers', 'languages', 'course_exercises', 'quizzes', 'certificates', 'taggingData'));
    }

    public function courseDetailsSetSession(Request  $request)
    {
        Session::put('typeCourse', $request->type);

        return true;
    }

    public function setCourseDripContent(Request $request)
    {

        Session::flash('type', 'drip');
        $course_id = $request->get('course_id');


        $lesson_id = $request->get('lesson_id');
        $lesson_date = $request->get('lesson_date');
        $lesson_day = $request->get('lesson_day');
        $drip_type = $request->get('drip_type');


        if (!empty($lesson_id) && is_array($lesson_id)) {
            foreach ($lesson_id as $l_key => $l_id) {
                $lesson = Lesson::find($l_id);

                if ($lesson) {

                    $checkType = $drip_type[$l_key];

                    if ($checkType == 1) {
                        $lesson->unlock_days = null;

                        if (!empty($lesson_date[$l_key])) {
                            $lesson->unlock_date = date('Y-m-d', strtotime($lesson_date[$l_key]));
                        } else {
                            $lesson->unlock_date = null;
                        }
                    } else {
                        $lesson->unlock_date = null;
                        if (!empty($lesson_day[$l_key])) {
                            $lesson->unlock_days = $lesson_day[$l_key];
                        } else {
                            $lesson->unlock_days = null;
                        }
                    }


                    $lesson->save();
                }
            }
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


    public function changeChapterPosition(Request $request)
    {
        $ids = $request->get('ids');
        if (count($ids) != 0) {
            foreach ($ids as $key => $id) {

                $chapter = Chapter::find($id);
                if ($chapter) {
                    $chapter->position = $key + 1;
                    $chapter->save();
                }
            }
        }
        return true;
    }

    public function changeLessonPosition(Request $request)
    {
        $ids = $request->get('ids');
        // return $ids;
        if (count($ids) != 0) {
            foreach ($ids as $key => $id) {
                $lesson = Lesson::find($id);
                if ($lesson) {
                    $lesson->position = $key + 1;
                    $lesson->save();
                }
            }
        }
        return true;
    }


    public function courseDelete($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $hasCourse = CourseEnrolled::where('course_id', $id)->count();
        if ($hasCourse != 0) {
            Toastr::error('Course Already Enrolled By ' . $hasCourse . ' Student', trans('common.Failed'));
            return redirect()->back();
        }

        $carts = Cart::where('course_id', $id)->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }

        $course = Course::withoutGlobalScope('withoutsubscription')->findOrFail($id);
        if ($course->host == "Self") {
            if (file_exists($course->trailer_link)) {
                unlink($course->trailer_link);
            }
        }
        if (file_exists($course->image)) {
            unlink($course->image);
        }
        if (file_exists($course->thumbnail)) {
            unlink($course->thumbnail);
        }
        if (file_exists($course->trainer_image)) {
            unlink($course->trainer_image);
        }

        $chapters = Chapter::where('course_id', $course->id)->get();
        foreach ($chapters as $chapter) {
            $lessons = Lesson::where('chapter_id', $chapter->id)->where('course_id', $course->id)->get();
            foreach ($lessons as $key => $lesson) {
                $complete_lessons = LessonComplete::where('lesson_id', $lesson->id)->get();
                foreach ($complete_lessons as $complete) {
                    $complete->delete();
                }
                $lessonController = new LessonController();
                $lessonController->lessonFileDelete($lesson);
                $lesson->delete();
            }

            $chapter->delete();
        }

        if (isModuleActive('BundleSubscription')) {
            $bundle = BundleCourse::where('course_id', $course->id)->get();
            foreach ($bundle as $b) {
                $b->delete();
            }
        }

        $course->delete();


        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function getAllCourseData(Request $request)
    {
        $query = Course::withoutGlobalScope('withoutsubscription')->whereIn('type', [1, 2])->with('category', 'quiz', 'user');
        if (isCourseReviewer()) {
            $query->whereIn('status', [0, 1, 3, 4]);
        }
        if (check_whether_cp_or_not() || isPartner()) {
            $query->whereHas('user', function ($q) {
                $q->where('id', auth()->user()->id);
            });
        }
        if ($request->course_status != "") { //Active
            if ($request->course_status == 1) {
                // $query->where('courses.status', 1);
                $query->whereIn('courses.status', [1, 3]);
            } elseif ($request->course_status == 0) { //Pending
                $query->where('courses.status', 0);
                // $query->whereIn('courses.status', [0,4]);
            } elseif ($request->course_status == 2) { //Saved
                $query->where('courses.status', 2);
            }
        }


        $category = $request->category;
        if ($request->category != "") {
            $query->where(function($q) use($category){
                $q->where('category_id', $category)->orWhere('category_ids', 'LIKE', '%' . "," . $category . "," . '%');
            });
        }
        if ($request->type != "") {
            $query->where('type', $request->type);
        }
        if ($request->status != "") {
            $query->where('courses.status', $request->status);
        }
        if ($request->instructor != "") {
            $query->where('user_id', $request->instructor);
        }

        if ($request->from_duration != "" || $request->to_duration != "") {
            if ($request->from_duration != "" && $request->to_duration != "") {
                $query->where('duration', ">=", (int)$request->from_duration)->where("duration", "<=", (int)$request->to_duration);
            } elseif ($request->from_duration != "" && $request->to_duration == "") {
                $query->where('duration', "=", (int)$request->from_duration);
            } elseif ($request->from_duration == "" && $request->to_duration != "") {
                $query->where('duration', "=", (int)$request->to_duration);
            }
        }
        if (!empty($request->start_price)  && $request->start_price != "") {
            $query->where('price', '>=', $request->start_price);
        }
        if (!empty($request->end_price)  && $request->end_price != "") {
            $query->where('price', '<=', $request->end_price);
        }

        if ($request->total_rating != "") {
            $query->where('total_rating', $request->total_rating);
        }
        if ($request->content_provider != "") {
            $cp = $request->content_provider;
            $query->where('user_id', '=', $cp);

        }

        if ($request->from_submission_date != "" || $request->to_submission_date != "") {
            if ($request->from_submission_date != "" && $request->to_submission_date != "") {
                $query->whereDate('updated_at', ">=", $request->from_submission_date)->whereDate("updated_at", "<=", $request->to_submission_date);
            } elseif ($request->from_submission_date != "" && $request->to_submission_date == "") {
                $query->whereDate('updated_at', ">=", $request->from_submission_date);
            } elseif ($request->from_submission_date == "" && $request->to_submission_date != "") {
                $query->whereDate('updated_at', "<=", $request->to_submission_date);
            }
        }

        if (isInstructor()) {
            $query->where('user_id', '=', Auth::id());
        }

        if (isCourseReviewer()) {
            // $query->where('reviewer_id', '=', Auth::id());
            $query->latest('submitted_at');
        }

        $query->select('courses.*');
        // dd($query->toSql());
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('type', function ($query) {
                return $query->type == 1 ? 'Course' : 'Quiz';
            })->addColumn('status', function ($query) {
                $approve = false;
                // if (isAdmin() || isHRDCorp() || isMyLL() || isPIC()) {
                if (isAdmin() || isHRDCorp() || isMyLL()) {
                    $approve = true;
                } else {
                    $courseApproval = Settings('course_approval');
                    if ($courseApproval == 0) {
                        $approve = true;
                    }
                }
                if ($query->status == 2 || $query->status == 0 || $query->status == 4) {
                    $approve = false;
                }

                if ($approve) {
                    if (permissionCheck('course.status_update')) {
                        $status_enable_eisable = "status_enable_disable";
                    } else {
                        $status_enable_eisable = "";
                    }
                    $checked = $query->status == 1 ? "checked" : "";
                    $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="' . $status_enable_eisable . '"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';
                } else {
                    if ($query->status == 1) {
                        $view = "Published";
                    } elseif ($query->status == 2) {
                        $view = "Saved";
                    } elseif ($query->status == 3) {
                        $view = "Approved";
                    } elseif ($query->status == 4) {
                        $view = "Rejected";
                    } else {
                        $view = "In Review";
                    }
                }


                return $view;
            })->addColumn('lessons', function ($query) {
                return $query->lessons->count();
            })
            ->addColumn('submitted_at', function ($query) {
                $date = '';
                if ($query->status == 0 || $query->status == 1 || $query->status == 3 || $query->status == 4) { //Pending
                    // if ($query->submitted_at == null)
                        $date = showDate($query->updated_at);
                    // else
                        // $date = showDate($query->submitted_at);
                }
                return $date;
            })
            ->addColumn('published_at', function ($query) {
                $date = '';
                if ($query->status == 1) { //Active
                    $date = showDate($query->published_at);
                }
                return $date;
            })
            ->editColumn('category', function ($query) {
                if ($query->category) {
                    return $query->category->name;
                    if (isset($query->category_ids) || $query->category_id != 0) {
                        if (isset($query->category_ids)) {
                            $categoryIds = explode(",", $query->category_ids);
                            if ($query->category_id != 0) {
                                array_push($categoryIds, $query->category_id);
                                $categoryIds = array_unique($categoryIds);
                            }

                            $data = [];
                            foreach ($categoryIds as $categoryId) {
                                $categoryFindName = Category::where("id", $categoryId)->first();
                                if (isset($categoryFindName->name)) {
                                    $data[] = $categoryFindName->name;
                                }
                            }

                            $data = implode(";", $data);
                            return $data;
                        } else {
                            return $query->category->name;
                        }
                    } else {
                        return '';
                    }
                }
            })
            ->editColumn('quiz', function ($query) {
                if ($query->quiz) {
                    return $query->quiz->title;
                } else {
                    return '';
                }
            })->editColumn('user', function ($query) {
                if (isset($query->user) && $query->user->role_id == 7 || is_partner($query->user)) {
                    return $query->trainer;
                } elseif ($query->user) {
                    return $query->user->name;
                } else {
                    return '';
                }
            })->addColumn('enrolled_users', function ($query) {
                // return $query->enrollUsers->where('teach_via', 1)->count() . "/" . $query->enrollUsers->where('teach_via', 2)->count();
                return $query->enrollUsers->where('teach_via', 1)->count();
            })
            ->editColumn('scope', function ($query) {
                if ($query->scope == 1) {
                    $scope = trans('courses.Public');
                } else {
                    $scope = trans('courses.Private');
                }
                return $scope;
            })

            ->addColumn('price', function ($query) {
                $priceView = '';
                if ($query->discount_price != null) {
                    $priceView = '<span>' . getPriceFormat($query->discount_price) . '</span>';
                } else {
                    $priceView = '<span>' . getPriceFormat($query->price) . '</span>';
                }
                return $priceView;
            })->addColumn('approval_at', function ($query) {
                $date = '';
                //if($query->status == 3 || $query->status == 4){
                    $date = showDate($query->approval_at);
                //}
                return $date;
            })->addColumn('action', function ($query) {
                if (permissionCheck('course.details')) {
                    if ($query->type == 1) {
                        if ($query->curriculum_tab == 1) {
                            $course_detalis = '<a href="' . route('courseDetails', [$query->id]) . '" class="dropdown-item" >' . __('courses.Add Lesson') . '</a>';
                        } else {
                            $course_detalis = '<a href="' . route('courseDetails', [$query->id]) . '?type=courseDetails" class="dropdown-item" >' . __('courses.Add Lesson') . '</a>';
                        }
                    } else {
                        $course_detalis = "";
                    }
                } else {
                    $course_detalis = "";
                }

                if (permissionCheck('course.edit')) {


                    $title = 'data-title ="' . escapHtmlChar($query->title) . '"';

                    $course_edit = '<a href="' . route('courseDetails', [$query->id]) . '?type=courseDetails" class="dropdown-item" >' . __('common.Edit') . '</a>';
                } else {
                    $course_edit = "";
                }

                if (permissionCheck('course.view')) {
                    $course_view = '<a href="' . route('courseDetails', [$query->id]) . '" class="dropdown-item" >' . trans('common.View') . '</a>';
                } else {
                    $course_view = "";
                }

                if (permissionCheck('course.delete')) {
                    $deleteUrl = route('course.delete', $query->id);
                    $course_delete = '<a onclick="confirm_modal(\'' . $deleteUrl . '\')"
                                                               class="dropdown-item edit_brand">' . trans('common.Delete') . '</a>';
                } else {
                    $course_delete = "";
                }
                if (permissionCheck('course.enrolled_students') && $query->type == 1) {
                    if ($query->status != 2) {
                        $enrolled_students = '<a href="' . route('course.enrolled_students', $query->id) . '" class="dropdown-item edit_brand">' . trans('student.Students') . '</a>';
                    } else {
                        $enrolled_students = "";
                    }
                } else {
                    $enrolled_students = "";
                }
                if (isModuleActive('CourseInvitation') && permissionCheck('course.courseInvitation') && $query->type == 1) {
                    $course_invitation = '<a href="' . route('course.courseInvitation', $query->id) . '" class="dropdown-item edit_brand">' . trans('common.Send Invitation') . '</a>';
                } else {
                    $course_invitation = "";
                }
                if (Settings('frontend_active_theme') == "edume") {
                    if ($query->feature == 0) {
                        $markAsFeature = '<a href="' . route('courseMakeAsFeature', [$query->id, 'make']) . '" class="dropdown-item" >' . trans('courses.Mark As Feature') . '</a>';
                    } else {
                        $markAsFeature = '<a href="' . route('courseMakeAsFeature', [$query->id, 'remove']) . '" class="dropdown-item" >' . trans('courses.Remove Feature') . '</a>';
                    }
                } else {
                    $markAsFeature = '';
                }

                $approve_course = '';
                if (permissionCheck('course.approve_course')) {
                    if ($query->status != 1 || $query->status != 2) {
                        $approve_course = '<a class="dropdown-item approve_course_click" data-id="' . $query->id . '" > Approve/Reject Course </a>';
                    }
                }

                $feedback_opt = '';
                if (permissionCheck('course.feedback')) {
                    if ($query->status != 1) {
                        $feedback_opt = '<a class="dropdown-item feedback_option_click" data-id="' . $query->id . '" > Feedback </a>';
                    }
                }

                if (permissionCheck('course.view_course_feedback')) {
                    $view_course_feedback = '<a href="' . route('getCourseFeedbackData', [$query->id]) . '" class="dropdown-item" >' . trans('View Course Feedback') . '</a>';
                } else {
                    $view_course_feedback = "";
                }

                $course_assign_to_learners = '';
                if (permissionCheck('assignCourseToLearners')) {
                    if ($query->status == 1) {
                        $course_assign_to_learners = '<a onclick="course_assign_to_learners(\'' . $query->id . '\')" class="dropdown-item">Course Assign To Learners</a>';
                    }
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                    <a target="_blank"
                                       href="' . courseDetailsUrl($query->id, $query->type, $query->slug) . '"
                                       class="dropdown-item"
                                    > ' . trans('courses.Frontend View') . '</a>
                                    ' . $course_detalis . '
                                    ' . $markAsFeature . '
                                    ' . $course_edit . '
                                    ' . $course_view . '
                                    ' . $course_delete . '
                                    ' . $enrolled_students . '
                                    ' . $course_invitation . '
                                    ' . $feedback_opt . '
                                    ' . $view_course_feedback . '
                                    ' . $approve_course . '
                                    ' . $course_assign_to_learners . '
                                </div>
                                </div>';

                return $actioinView;
            })->rawColumns(['status', 'price', 'action', 'enrolled_users'])
            ->make(true);
    }

    public function configVimeo()
    {
        try {

            if (config('vimeo.connections.main.common_use')) {
                $vimeo_client = env('VIMEO_CLIENT');
                $vimeo_secret = env('VIMEO_SECRET');
                $vimeo_access = env('VIMEO_ACCESS');
            } else {
                $vimeos = Cache::rememberForever('vimeoSetting', function () {
                    return \Modules\VimeoSetting\Entities\Vimeo::all();
                });
                $vimeo = $vimeos->where('created_by', Auth::user()->id)->first();
                if ($vimeo) {
                    $vimeo_client = $vimeo->vimeo_client;
                    $vimeo_secret = $vimeo->vimeo_secret;
                    $vimeo_access = $vimeo->vimeo_access;
                }
            }
            $vimeo_client = env('VIMEO_CLIENT');
            $vimeo_secret = env('VIMEO_SECRET');
            $vimeo_access = env('VIMEO_ACCESS');

            $lib = new  Vimeo($vimeo_client, $vimeo_secret);
            $lib->setToken($vimeo_access);
            return $lib;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getVideoFromVimeoApi($page = 1)
    {
        try {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                return [];
            }
            $folder_data = get_vimeo_videos_using_folder_id();
            if (count($folder_data) == 0 || isset($folder_data['body']['error'])) {
                if ($this->configVimeo()) {
                    $result = $this->configVimeo()->request('/me/videos', [
                        'per_page' => 20,
                        'page' => $page,
                    ], 'GET');
                    return $result;
                } else {
                    return [];
                }
            }
        } catch (\Exception $e) {
            dd($e);
            return [];
        }
    }

    public function getVimeoList()
    {

        try {
            $video_list = [];
            $page = 1;
            $vimeo_video_list = $this->getVideoFromVimeoApi($page);

            if (isset($vimeo_video_list['body']['error'])) {
                //Toastr::error($vimeo_video_list['body']['error'], trans('common.Failed'));
            }
            if (isset($vimeo_video_list['body']['total'])) {
                $total_videos = $vimeo_video_list['body']['total'];

                if (isset($vimeo_video_list['body']['data'])) {
                    if (count($vimeo_video_list['body']['data']) != 0) {
                        foreach ($vimeo_video_list['body']['data'] as $data) {
                            $video_list[] = $data;
                        }
                    }
                    return $video_list;
                    $totalPage = round($total_videos / 3);



                }
            }
        } catch (\Exception $e) {
            $video_list = [];
        }

        return $video_list;
    }

    public function addNewCourse()
    {
        $user = Auth::user();
        $vdocipher_list = $this->getVdoCipherList();
        $categories = Category::where('status', 1)->get();
        $quizzes = OnlineQuiz::where('status', 1)->latest()->get();
        $languages = Language::select('id', 'native', 'code')
            ->where('status', '=', 1)
            ->get();
        $title = trans('courses.All');

        return view('coursesetting::add_course', compact('vdocipher_list', 'title', 'quizzes', 'categories', 'languages'));
    }

    public function changeLessonChapter(Request $request)
    {
        $chapter_id = $request->chapter_id;
        $lesson_id = $request->lesson_id;

        $lesson = Lesson::findOrFail($lesson_id);
        $lesson->chapter_id = $chapter_id;
        $lesson->save();
        return true;
    }

    public function getVdoCipherList()
    {
        /*
            try {
                $curl = curl_init();

                $header = array(
                    "Accept: application/json",
                    "Authorization:Apisecret " . env('VDOCIPHER_API_SECRET'),
                    "Content-Type: application/json"
                );

                // &q=array
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://dev.vdocipher.com/api/videos?page=1&limit=20",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => $header,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                if ($err) {
                    return [];
                } else {
                    return json_decode($response)->rows;
                }
            } catch (\Exception $e) {
                return [];
            }
        */
        return [];
    }

    public function courseMakeAsFeature($id, $type)
    {
        try {
            if ($type == "make") {
                $items = Course::all();
                foreach ($items as $item) {
                    if ($id == $item->id) {
                        $featureStatus = 1;
                    } else {
                        $featureStatus = 0;
                    }
                    $item->feature = $featureStatus;
                    $item->save();
                }
            } else {
                $course = Course::find($id);
                $course->feature = 0;
                $course->save();
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->to(route('getAllCourse'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function CourseQuestionDelete($quiz_id, $question_id)
    {
        $assign = OnlineExamQuestionAssign::where('online_exam_id', $quiz_id)->where('question_bank_id', $question_id)->first();
        if ($assign) {
            $assign->delete();
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function getAllVdocipherData(Request $request)
    {
        try {
            $curl = curl_init();

            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . env('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );
            if ($request->page) {
                $page = $request->page;
            } else {
                $page = 1;
            }

            if ($request->search) {
                $search = $request->search;
            } else {
                $search = '';
            }

            //            &q=array
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos?page=" . $page . "&limit=20&q=" . $search,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                return [];
            } else {
                $items = json_decode($response)->rows;
                $response = [];
                foreach ($items as $item) {
                    $response[] = [
                        'id' => $item->id,
                        'text' => $item->title
                    ];
                }
                $data['results'] = $response;
                $data['pagination'] = ["more" => count($response) != 0 ? true : false];
                return response()->json($data);
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getSingleVdocipherData($id)
    {
        try {
            $curl = curl_init();

            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . env('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );

            //            &q=array
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos/" . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                return null;
            } else {
                $item = json_decode($response);

                return response()->json($item);
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function auto_select2_ajax_vimeo_video_list(Request $request)
    {
        $video_list = [];
        // $courseSetting = new CourseSettingController();
        $video_list = $this->getVimeoList();

        $search = $request->q;

        $data = assign_to_users_manager_secretary($search, $video_list);

        return response()->json($data);
    }

    public function user_data_with_ajax(Request $request)
    {
        if ($request->ajax()) {

            $term = trim($request->term);
            //2 = Instructor
            $is_array = 1;
            $results = rolewise_user_data_with_select2_search_ajax($is_array, [1, 2], $term, 10); //role_id, term, pagination

            return $results;
        }
    }

    public function send_course_feedback(Request $request)
    {
        $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
        if ($course) {
            $user_id = $course->user_id;
            $user = User::find($user_id);
            if ($user) {
                if ($user->role_id == 7 || is_partner($user)) {
                    send_email($user, 'course_feedback', ['course' => $course->title, 'comment' => $request->feedback]);

                    $response['success'] = true;
                    $response['status'] = 1;
                    $response['message'] = 'Mail sent to content provider successfully!!';
                    return response()->json($response);
                }
            }
        }

        $response['success'] = false;
        $response['status'] = 0;
        $response['message'] = 'Something went wrong!!';
        return response()->json($response);
    }

    public function reject_feedback(Request $request)
    {
        $rules = [
            'feedback' => 'required',
        ];
        $messages = [
            'required' => 'Please enter your feedback.'
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response['errors']  = $validator->errors()->all();
            $response['vsuccess'] = false;
            $response['vstatus'] = 0;
            return response()->json($response);
        }
        $response['vsuccess'] = true;
        $response['vstatus'] = 1;

        $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
        if ($course) {
            $user_id = $course->user_id;
            $user = User::find($user_id);
            if ($user) {
                if ($user->role_id == 7 || $user->role->name == 'Content Provider') {
                    send_email($user, 'reject_with_feedback', ['course' => $course->title, 'comment' => $request->feedback, 'course_link' => route('courseDetails', $request->id)]);

                    $response['message'] = 'Mail sent to Content Provider successfully!!';
                } elseif ($user->role_id == 8 || $user->role->name == 'Partner') {
                    send_email($user, 'reject_with_feedback', ['course' => $course->title, 'comment' => $request->feedback, 'course_link' => route('courseDetails', $request->id)]);

                    $response['message'] = 'Mail sent to Partner successfully!!';
                }
            }

            $reviewer_id = $course->reviewer_id;
            $reviewer = User::find($reviewer_id);
            if (isAdmin() || isHRDCorp() || isMyLL()) {
                if ($reviewer) {
                    if ($reviewer->role_id == 9 || $reviewer->role->name == 'Course Reviewer') {
                        send_email($reviewer, 'reject_with_feedback', ['course' => $course->title, 'comment' => $request->feedback, 'course_link' => route('courseDetails', $request->id)]);
                    }
                }
                $response['message'] = 'Mail sent to Content Provider/Partner & Course Reviewer successfully!!';
            }

            $feedback = new CourseFeedback();
            $feedback->reviewer_id = Auth::user()->id;
            $feedback->course_id = $request->id;
            $feedback->cp_id = $course->user_id;
            $feedback->course_title = $course->title;
            $feedback->feedback = $request->feedback;
            $feedback->save();

            $response['success'] = true;
            $response['status'] = 1;

            return response()->json($response);
        }

        $response['success'] = false;
        $response['status'] = 0;
        $response['message'] = 'Something went wrong!!';
        return response()->json($response);
    }

    /* 21-07-2022 */
    public function getCourseFeedbackData(Request $request)
    {

        try {
            $coursefeedback = CourseFeedback::where('course_id', $request->id)->first();

            //$coursefeedbacks = CourseFeedback::where('course_id', $request->id)->latest('created_at');

            $coursefeedbacks = DB::table('course_feedback')->join('users', 'course_feedback.reviewer_id', '=', 'users.id')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->select('course_feedback.*', 'roles.name')->where('course_id', $request->id);

            // if (isCourseReviewer()) {
            //     $coursefeedbacks->where('reviewer_id', '=', Auth::id());
            // }

            if (isPartner()) {
                $coursefeedbacks->where('course_feedback.cp_id', '=', Auth::id());
            }

            if (check_whether_cp_or_not()) {
                $coursefeedbacks->where('course_feedback.cp_id', '=', Auth::id());
            }
            $coursefeedbacks->latest()->get();


            if ($request->ajax()) {
                return Datatables::of($coursefeedbacks)
                    ->addIndexColumn()
                    ->editColumn('feedback', function ($coursefeedbacks) {
                        return $coursefeedbacks->feedback;
                    })->addColumn('role', function ($coursefeedbacks) {
                        return $coursefeedbacks->name;
                    })->editColumn('date', function ($coursefeedbacks) {
                        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $coursefeedbacks->created_at)->format('d-M-Y');
                        return $formatedDate;
                    })
                    ->make(true);
            }
            return view('coursesetting::course_feedback_list', compact('coursefeedbacks', 'coursefeedback'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            \Log::info($e->getMessage());
            return redirect()->back();
        }
    }

    public function approve_course(Request $request)
    {
        $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
        // $pic_id = $course->assigner_id;
        // $pic_user = User::find($pic_id);
        $users = User::whereHas('role', function ($query) {
            return $query->whereIn('name', ['Super admin', 'HRDCorp', 'MyLL Admin']);
        })->get();

        if ($course) {

            if (isCourseReviewer()) {
                foreach ($users as $user) {
                    send_email($user, 'course_approve_by_reviewer', ['course' => $course->title]);
                }
            }

            $course->id = $request->id;
            $course->status = 3;
            if (isCourseReviewer()) {
                $course->reviewer_id = Auth::id();
            }
            $course->approver_id = Auth::id();
            $course->approval_at = now();
            $course->save();

            $response['id'] = $request->id;
            $response['success'] = true;
            $response['status'] = 1;
            $response['message'] = 'Approved the course!';
            return response()->json($response);
        }

        $response['success'] = false;
        $response['status'] = 0;
        $response['message'] = 'Something went wrong!';
        return response()->json($response);
    }

    public function reject_course(Request $request)
    {
        $course = Course::withoutGlobalScope('withoutsubscription')->find($request->id);
        if ($course) {

            $course->id = $request->id;
            $course->status = 4;
            if (isCourseReviewer()) {
                $course->reviewer_id = Auth::id();
            }
            $course->approver_id = Auth::id();
            $course->approval_at = now();
            $course->save();

            $response['id'] = $request->id;
            $response['success'] = true;
            $response['status'] = 1;
            $response['message'] = 'Rejected the course!';
            return response()->json($response);
        }

        $response['success'] = false;
        $response['status'] = 0;
        $response['message'] = 'Something went wrong!';
        return response()->json($response);
    }

    public function CourseListExcelDownload(Request $request) {
        $instructor = (!check_whether_cp_or_not() && !isPartner()) ? $request->instructor : '';

        $course_status = '';

        if ($request->previous_route == 'getAllCourse') {
            $course_status = 3;
        } elseif ($request->previous_route == 'getActiveCourse') {
            $course_status = 1;
        } elseif ($request->previous_route == 'getPendingCourse') {
            $course_status = 0;
        }

        $status = '';

        if (($request->previous_route != 'getActiveCourse' && $request->previous_route != 'getPendingCourse') || $request->previous_route == 'getPendingCourse' || $request->previous_route == 'getActiveCourse') {
            $status = $request->search_status;
        }

        $start_price = '';
        $end_price = '';
        $total_rating = '';

        if (check_whether_cp_or_not() || isPartner()) {
            $start_price = $request->start_price;
            $end_price = $request->end_price;
            $total_rating = $request->total_rating;
        }

        $content_provider = (isAdmin() || isHRDCorp() || isCourseReviewer() || isMyLL()) ? $request->content_provider : '';

        $from_submission_date = '';
        $to_submission_date = '';

        if ($request->previous_route == 'getPendingCourse') {
            $from_submission_date = $request->from_submission_date;
            $to_submission_date = $request->to_submission_date;
        }

        return Excel::download(new CourseExport($request->category, $instructor, $request->course, $course_status, $status, $request->from_duration, $request->to_duration, $start_price, $end_price, $total_rating, $content_provider, $from_submission_date, $to_submission_date), 'course-list.xlsx');
    }

    public function assign_course_to_learners_ajax(Request $request) {
        $rules = [
            'user_id' => 'required',
        ];

        $messages = [
            'user_id.required' => 'Select Learner first!!',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $response['errors'] = $validator->errors()->all();
            $response['success'] = false;
            $response['status'] = 0;

            return response()->json($response);
        }

        $user_ids = $request->user_id;

        if (isset($user_ids) && count($user_ids) > 0) {
            $course = Course::withoutGlobalScope('withoutsubscription')->find($request->course_id);

            foreach ($user_ids as $user_id) {
                $course_enrolled = CourseEnrolled::where('user_id', $user_id)->where('course_id', $request->course_id)->first();
                $user = User::find($user_id);

                if ($course_enrolled) {
                    $learner_name = isset($course_enrolled->user) ? $course_enrolled->user->name : '';
                    $response['success'] = false;
                    $response['message'] = 'Course already enrolled for user '.$learner_name;

                    return response()->json($response);
                } else {
                    $course_enrolled = new CourseEnrolled();
                    $course_enrolled->user_id = $user_id;
                    $course_enrolled->course_id = $request->course_id;

                    if (!empty($request->due_date)) {
                        $course_enrolled->due_date = $request->due_date;
                    }

                    $course_enrolled->is_assigned = 1;
                    $course_enrolled->assigner_id = auth()->user()->id;

                    if ($course) {
                        $course_enrolled->purchase_price = ($course->discount_price != null) ? $course->discount_price : $course->price;
                    }

                    $course_enrolled->save();

                    if (UserEmailNotificationSetup('Course_Enroll_Payment', $course_enrolled->user)) {
                        send_email($course_enrolled->user, 'send_email_assigned_course', [
                            'name'          => $course_enrolled->user->name,
                            'course_title' => $course_enrolled->course->title,
                            'due_date'      => $course_enrolled->due_date
                        ]);
                    }

                    if (UserBrowserNotificationSetup('Course_Enroll_Payment', $course_enrolled->user)) {
                        send_browser_notification(
                            $course_enrolled->user,
                            $type = 'send_email_assigned_course',
                            $shortcodes = [
                                'name' => $course_enrolled->user->name,
                                'course_title' => $course_enrolled->course->title,
                                'due_date' => $course_enrolled->due_date,
                            ],
                            '', //actionText
                            '' //actionUrl
                        );
                    }
                }
            }

            $response['success'] = true;
            $response['message'] = 'Course enrolled successfully!';

            return response()->json($response);
        }
    }

    public function course_learner_list(Request $request) {
        if ($request->ajax()) {
            $paginate = 10;

            if ($request->course_id != '') {
                $paginate = (int)$paginate;
                $term = trim($request->term);
                $posts = [];

                $results = array(
                    "results" => '',
                    "pagination" => array(
                        "more" => false,
                    )
                );

                if ($term != "") {
                    $posts = User::select('id', 'name as text')
                    ->where('role_id', 3)
                    ->where('name', 'LIKE', '%' . $term . '%')
                    ->where('is_corporate_user', 0)
                    ->simplePaginate($paginate);

                    $morePages = true;
                    $pagination_obj = json_encode($posts);

                    if (!empty($posts) && empty($posts->nextPageUrl())) {
                        $morePages = false;
                    }

                    if (empty($posts)) {
                        $morePages = false;
                    }

                    $results = array(
                        "results" => !empty($posts) ? $posts->items() : '',
                        "pagination" => array(
                            "more" => $morePages,
                        )
                    );
                }

                return $results;
            }
        }
    }
}

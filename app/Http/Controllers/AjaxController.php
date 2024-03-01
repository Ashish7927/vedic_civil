<?php

namespace App\Http\Controllers;

use App\Events\CourseUpdate;
use App\Events\OneToOneConnection;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\SubCategory;
use Modules\Quiz\Entities\OnlineQuiz;
use Illuminate\Support\Facades\Schema;
use Modules\CourseSetting\Entities\Package;
use Modules\Certificate\Entities\Certificate;

class AjaxController extends Controller
{


    public function topbarEnableDisable(Request $request)
    {
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['topbar' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function footerEnableDisable(Request $request)
    {

        Log::error($request->all());
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['footer' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function statusEnableDisable(Request $request)
    {
        if (appMode()) {
            return response()->json(['warning' => trans('common.For the demo version, you cannot change this')], 200);
        }
        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }

        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;

           if (Schema::hasColumn($table, 'published_at')) {
                $result = DB::table($table)->where('id', $id)->update(['status' => $status, 'published_at' => now()]);
           } else {
                $result = DB::table($table)->where('id', $id)->update(['status' => $status, 'updated_at' => now()]);
           }


            //========= End For Chat Module ========

            if ($table == "courses") {

                // ======= For Chat Module ========
                if (isModuleActive('Chat')) {
                    $course = Course::withoutGlobalScope('withoutsubscription')->find($id);
                    if ($course && $course->status) {
                        $instructor = User::find($course->user_id);
                        event(new OneToOneConnection($instructor, null, $course));
                    }
                }
                $course = Course::withoutGlobalScope('withoutsubscription')->find($id);
                if ($status == 1) {
                    if (UserEmailNotificationSetup('Course_Publish_Successfully', $course->user)) {
                        send_email($course->user, 'Course_Publish_Successfully', [
                            'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $course->title,
                        ]);
                    }

                    $mail_val = [
                        'send_to_name' => $course->user->name,
                        'send_to' => $course->user->email,
                        'email_from' => env('MAIL_FROM_ADDRESS'),
                        'email_from_name' => env('MAIL_FROM_NAME'),
                        'subject' => 'Course Approve By Admin',
                        'user_id' => $course->user->id,
                    ];
                    $type_of_mail = 1;
                    // send_email_to_instructor_by_admin($mail_val,'new_cource_approval',[
                    //     'course' => $course->title,
                    // ], $type_of_mail);
                    send_email_to_instructor_by_admin($mail_val, 'new_cource_approval', [
                        'cp_name' => $course->user->name,
                        'course_published_date' => date("d M Y")
                    ], $type_of_mail);


                    if (UserBrowserNotificationSetup('Course_Publish_Successfully', $course->user)) {
                        send_browser_notification(
                            $course->user,
                            $type = 'Course_Publish_Successfully',
                            $shortcodes = [
                                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                            ],
                            '', //actionText
                            '' //actionUrl
                        );
                    }
                } else {
                    if (UserEmailNotificationSetup('Course_Unpublished', $course->user)) {
                        send_email($course->user, 'Course_Unpublished', [
                            'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $course->title,
                        ]);
                    }
                    if (UserBrowserNotificationSetup('Course_Unpublished', $course->user)) {

                        send_browser_notification(
                            $course->user,
                            $type = 'Course_Unpublished',
                            $shortcodes = [
                                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                            ],
                            '', //actionText
                            '' //actionUrl
                        );
                    }
                }
            } elseif ($table == "categories") {
                Cache::forget('categories');
            } elseif ($table == "country_wish_taxes") {
                Cache::forget('countryWishTaxList');
            } elseif ($table == "sponsors") {
                Cache::forget('SponsorList');
            } elseif ($table == "course_levels") {
                Cache::forget('CourseLevel');
            }

            if ($result) {
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

    public function publishEnableDisable(Request $request)
    {

        // Log::error($request->all());
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['publish' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function ajaxGetSubCategoryList(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->id)->get();
        return response()->json([$subcategories]);
    }


    public function ajaxGetCourseList(Request $request)
    {
        try {
            $category_id = $request->category_id;
            $subcategory_id = $request->subcategory_id;
            if (Auth::user()->role_id == 1) {
                $query = Course::select('id', 'title');
                if ($category_id) {
                    $query->where('category_id', $category_id);
                }
                if ($subcategory_id) {
                    $query->where('subcategory_id', $subcategory_id);
                }
                $subcategories = $query->get();
            } else {
                $subcategories = Course::select('id', 'title')->where('category_id', $category_id)->where('subcategory_id', $subcategory_id)->where('user_id', Auth::user()->id)->get();
            }
            return response()->json([$subcategories]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function ajaxGetQuizList(Request $request)
    {
        try {
            $category_id = $request->category_id;
            $subcategory_id = $request->subcategory_id;
            $course_id = $request->course_id;


            $quiz_list = OnlineQuiz::query();
            if ($request->category_id != "") {
                $quiz_list->where('category_id', $request->category_id);
            }
            if ($request->subcategory_id != "") {
                $quiz_list->where('sub_category_id', $request->subcategory_id);
            }
            if ($request->course_id != "") {
                $quiz_list->where('course_id', $request->course_id);
            }


            $quiz_list = $quiz_list->with('category', 'subCategory', 'course')->get();

            return response()->json([$quiz_list]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateActivity()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity_at = now();
            $user->save();
        }
        return true;
    }

    public function courses_which_not_added_with_ajax(Request $request)
    {
        if ($request->ajax()) {

            $term = trim($request->term);

            $results = courses_data_which_not_added_with_select2_search_ajax($term, 10, $request); //term, pagination

            return $results;
        }
    }

    public function get_certificate_list(Request $request)
    {
        if ($request->ajax()) {
            $paginate           = 10;
            $paginate           = (int)$paginate;
            $term               = trim($request->term);
            $certificate           = [];

            $certificate           = Certificate::select('id', 'title as text')->where('is_partner','=',1);

            if ($term != "") {
                $certificate = $certificate->where('title', 'like', '%'.$term.'%')->where('is_partner','=',1);
            }

            $certificate           = $certificate->simplePaginate($paginate);
            $morePages          = true;
            $pagination_obj     = json_encode($certificate);

            if (!empty($certificate) && empty($certificate->nextPageUrl())) {
                $morePages      = false;
            }
            if (empty($certificate)) {
                $morePages       = false;
            }
            $results = array(
                "results"       => !empty($certificate) ? $certificate->items() : '',
                "pagination"    => array(
                "more"          => $morePages,
                ),
            );
            return $results;
        }
    }
    
    public function get_selected_certificate(Request $request)
    {
        if ($request->ajax()) {
            $certificate = "";
            $package = Package::findOrFail($request->package_id);
            if (!empty($package->certificate_id)) {
                $certificate = Certificate::select('id', 'title')->where('id', $package->certificate_id)->first();
            }
            return response()->json([$certificate]);
        }
    }
}
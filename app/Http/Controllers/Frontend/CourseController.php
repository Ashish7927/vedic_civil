<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Modules\Localization\Entities\Language;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }


    public function courses(Request $request)
    {
        try {
            return view(theme('pages.courses'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courses_new(Request $request)
    {
        try {
            return view(theme('pages.courses_new'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getSmeCourses(Request $request)
    {
        try {
            $url = "";
            $apiURL = \Config::get('app.go1_api_url_access_token');
            $postInput = [
                'client_id' => \Config::get('app.go1_client_id'),
                'client_secret' => \Config::get('app.go1_client_secret'),
                'grant_type' =>  \Config::get('app.go1_grant_type')
            ];

            $response = Http::post($apiURL, $postInput);

            $statusCode = $response->status();
            if($statusCode == 200){
                $data = json_decode($response->getBody(), true);

                $accessToken = $data['access_token'];

                if (Session::get('Go1_ID') && Session::get('CourseType')) {
                    $apiGetSmeCourseContent = \Config::get('app.go1_api_url_get_sme_content');

                    $headers = [
                        'Authorization'=> 'Bearer '. $accessToken
                    ];

                    $app_url = config("app.url") ?: "https://elatihdev.hrdcorp.gov.my";
                    $addOnAction = "?exitAction=2&exitUrl={$app_url}/sme-courses-page";

                    if (Session::get('CourseType') == "Strategic") {
                        $postInputSmeContent = [
                            'redirect_url' => "https://sme40.mygo1.com/play/36501919{$addOnAction}",
                        ];
                    } else if (Session::get('CourseType') == "Functional") {
                        $postInputSmeContent = [
                            'redirect_url' => "https://sme40.mygo1.com/play/36502009{$addOnAction}",
                        ];
                    } else {
                        $postInputSmeContent = [];
                    }

                    $response = Http::withHeaders($headers)->post($apiGetSmeCourseContent . '/' . Session::get('Go1_ID') .'/login', $postInputSmeContent);

                    $status = $response->status();

                    if($status == 200){
                        $url = json_decode($response->getBody(), true)['url'];
                    }
                }
            }
            return view(theme('pages.getSmeCourses'), compact('request','url'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function freeCourses(Request $request)
    {
        try {
            return view(theme('pages.free_courses'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function courseDetails($slug, Request $request)
    {
        try {
            $is_cart = 0;
            $course = Course::withoutGlobalScope('withoutsubscription')->with('enrollUsers', 'user', 'user.courses', 'user.courses.enrollUsers', 'user.courses.lessons', 'chapters.lessons', 'enrolls', 'lessons', 'reviews', 'chapters', 'activeReviews')
                ->where('slug', $slug)->first();

            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('courses'));
            }
            if (Auth::check()) {
                $isEnrolled = $course->isLoginUserEnrolled;
            } else {
                $isEnrolled = false;
            }

            if ($isEnrolled) {
                $enroll = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                if ($enroll) {
                    if ($enroll->subscription == 1) {
                        if (isModuleActive('Subscription')) {
                            if (!isSubscribe()) {
                                Toastr::error('Subscription has expired, Please Subscribe again.', 'Failed');
                                return redirect()->route('courseSubscription');
                            }
                        }
                    }
                }
            }

            $data = '';
            if ($request->ajax()) {
                if ($request->type == "comment") {
                    $comments = CourseComment::where('course_id', $course->id)->with('replies', 'replies.user', 'user')->paginate(10);
                    foreach ($comments as $comment) {
                        $data .= view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    return $data;
                }

            }


            if ($request->ajax()) {
                if ($request->type == "review") {
                    $reviews = DB::table('course_reveiws')
                        ->select(
                            'course_reveiws.id',
                            'course_reveiws.star',
                            'course_reveiws.comment',
                            'course_reveiws.instructor_id',
                            'course_reveiws.created_at',
                            'users.id as userId',
                            'users.name as userName',
                        )
                        ->join('users', 'users.id', '=', 'course_reveiws.user_id')
                        ->where('course_reveiws.course_id', $course->id)->paginate(10);
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_review'), ['review' => $review, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }

            if ($course->host == "VdoCipher") {
                $websiteController = new WebsiteController();
                $otp = $websiteController->getOTPForVdoCipher($course->trailer_link);
                $course->otp = $otp['otp'];
                $course->playbackInfo = $otp['playbackInfo'];
            }

            $course->view = $course->view + 1;
            $course->save();

            if ($course->type == 1) {
                return view(theme('pages.courseDetails'), compact('request', 'course', 'isEnrolled'));
            } elseif ($course->type == 2 || $course->type == 3) {
                return \redirect()->to(courseDetailsUrl($course->id, $course->type, $course->slug));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function smeCoursesPage(Request $request) {
        return view(theme('pages.sme_course_page'), compact('request'));
    }

    public function offer(Request $request)
    {
        try {
            return view(theme('pages.offer'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getCourseList(Request $request) {
        $type = $request->type;

        $query = Course::with('user','lessons')->where('scope', 1)->where('type', 1)->where('status', 1);

        $category = $request->categories;
        if (empty($category)) {
            $category = '';
        } else {
            $categories = explode(',', $category);

            $query->whereIn('category_id', $categories);
        }

        $level = $request->levels;
        if (empty($level)) {
            $level = '';
        } else {
            $levels = explode(',', $level);
            $query->whereIn('level', $levels);
        }

        $language = $request->languages;
        if (empty($language)) {
            $language = '';
        } else {
            $row_languages = explode(',', $language);
            $languages = [];
            $LanguageList = Language::whereIn('code', $row_languages)->first();
            foreach ($row_languages as $l) {
                $lang = $LanguageList->where('code', $l)->first();
                if ($lang) {
                    $languages[] = $lang->id;
                }
            }
            $query->whereIn('lang_id', $languages);
        }

        if ($request->start_duration != '') {
            $query->where('duration', '>=', (int)$request->start_duration);
        }

        if ($request->end_duration != '') {
            $query->where('duration', '<=', (int)$request->end_duration);
        }

        $content_provider = $request->content_provider;
        if ($content_provider == '') {
            $content_provider = '';
        } else {
            $query->whereHas('user', function ($query) use ($content_provider) {
                return $query->where('id', $content_provider);
            });
        }

        $rate = $request->ratings;
        if (empty($rate)) {
            $rate = '';
        } else {
            $rating = explode(',', $rate);
            $query->whereIn('total_rating', $rating);
        }

        $version = $request->version;
        if ($version == '') {
            $version = '';
        } else {
            if ($version == 'free') {
                $query->where('price', 0)->where('discount_price', null);
            } else {
                $query->where(function($q) {
                    $q->where('price', '!=', 0)->orWhere('discount_price', '!=', null);
                });
            }
        }

        $startprice = $request->start_price;
        if ($startprice == '') {
            $startprice = '';
        } else {
            $query->where('price', '>=', $startprice);
        }

        $endprice = $request->end_price;
        if ($endprice == '') {
            $endprice = '';
        } else {
            $query->where('price', '<=', $endprice);
        }

        $order = $request->order;
        if (empty($order)) {
            $order = '';
            $query->orderBy('courses.total_enrolled', 'DESC');
        } else {
            if ($order=="popularity") {
                $query->orderBy('courses.total_enrolled', 'DESC');
            } elseif($order=="alphabet") {
                $query->orderBy('courses.title', 'ASC');
            } elseif($order=="date") {
                $query->orderBy('courses.created_at', 'ASC');
            } else {
                $query->orderBy('courses.total_enrolled', 'DESC')->latest();
            }
        }

        $courses = $query->paginate(itemsGridSize());
        $total_courses = $courses->total();

        $response['course_list'] = view(theme('pages.course_list'), compact('type', 'courses', 'total_courses'))->render();
        $response['total_courses'] = $total_courses;

        return response()->json($response);
    }
}

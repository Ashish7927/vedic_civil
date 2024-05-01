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
use App\User;

class CplandingController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }


    public function cplanding($id)
    {

        $user = User::where('id', $id)->with('role')->first();
        $courses = Course::where('user_id', $id)->where('type', 1)->where('status', '=', 1)->get();
        //$courses = DB::table('courses')->where('user_id', $id)->where('type', 1)->where('status', '!=', 2)->get();
        $course_count = $courses->count();

        $course_enrolleds = DB::table('courses')
        ->join('course_enrolleds', 'courses.id', '=', 'course_enrolleds.course_id')
        ->where('courses.user_id', $id)->where('courses.type', 1)->where('courses.status', '=', 1)->get();
        $enrolleds = $course_enrolleds->count();

        $featured_courses = Course::where('user_id', $id)->where('type', 1)->where('status', 1)->where('feature', 1)->take(5)->get();
        // $featured_courses = DB::table('courses')->where('user_id', $id)->where('feature', 1)->where('type', 1)->where('status', '!=', 2)->get();
        // $companies = DB::table('companies')
        //     ->where('show_log_in_front', '1')
        //     ->take(8)->get();
        // echo $id; die;

        $corporate_access_page_content = app('getHomeContent');
        $cp = json_decode(isset($corporate_access_page_content->content_provider_list) ? $corporate_access_page_content->content_provider_list : '');
        $content_provider = collect($cp)->where('id', $user->id)->first();
        

        try {
            return view(theme('pages.cplanding'), compact('user', 'course_count', 'enrolleds', 'featured_courses', 'content_provider'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}

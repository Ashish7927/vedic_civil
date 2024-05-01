<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\StudentSetting\Entities\BookmarkPackage;
use Modules\CourseSetting\Entities\PackageEnrolled;
use Modules\CourseSetting\Entities\PackageComment;
use Modules\CourseSetting\Entities\Package;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Payment\Entities\Cart;
use App\LessonComplete;
use App\Models\User;

class PackageController extends Controller
{
    public function __construct() {
        $this->middleware('maintenanceMode');
    }

    public function packageDetails(Request $request, $slug) {
        try {
            $package = Package::with('enrollUsers', 'package_courses', 'categories.category', 'package_courses.course', 'package_courses.course.chapters', 'package_courses.course.chapters.lessons')->where('slug', $slug)->first();

            if (!$package) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

            if (!isViewable($package)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('getAllPackages'));
            }

            $isEnrolled = (Auth::check()) ? $package->isLoginUserEnrolled : false;

            $data = '';
            if ($request->ajax()) {
                if ($request->type == "comment") {
                    $comments = PackageComment::where('package_id', $package->id)->with('replies', 'replies.user', 'user')->paginate(10);

                    foreach ($comments as $comment) {
                        $data .= view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'package' => $package])->render();
                    }
                    return $data;
                }
            }

            if ($request->ajax()) {
                if ($request->type == "review") {
                    $reviews = DB::table('package_reviews')
                        ->select(
                            'package_reviews.id',
                            'package_reviews.star',
                            'package_reviews.comment',
                            'package_reviews.instructor_id',
                            'package_reviews.created_at',
                            'users.id as userId',
                            'users.name as userName',
                        )
                        ->join('users', 'users.id', '=', 'package_reviews.user_id')
                        ->where('package_reviews.package_id', $package->id)->paginate(10);
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_review'), ['review' => $review, 'isEnrolled' => $isEnrolled, 'course' => $package])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }

            $package_img    = \Config::get('app.url')."/".$package->image;            
            $packageImage          = \Config::get('app.url')."/".$package->image;
            

            return view(theme('pages.packageDetails'), compact('request', 'package', 'isEnrolled', 'packageImage'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function packageBookmarkSave($id) {
        try {
            $bookmarked = BookmarkPackage::where('user_id', Auth::id())->where('package_id', $id)->first();

            if (empty($bookmarked)) {
                $bookmark               = new BookmarkPackage;
                $bookmark->package_id   = $id;
                $bookmark->user_id      = Auth::id();
                $bookmark->date         = date("jS F Y");
                $bookmark->save();

                Toastr::success('Bookmark Added Successfully', 'Success');
            } else {
                $bookmarked->delete();
                Toastr::success('Bookmark Remove Successfully', 'Success');
            }

            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function continuePackage($slug)
    {
        try {
            $lesson_id = null;

            if (!Auth::check()) {
                Toastr::error('You must login for continue', 'Failed');
                return redirect()->route('packageDetailsView', $slug);
            }

            $user    = Auth::user();
            $package = Package::where('slug', $slug)->first();

            if (!$package) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->route('packageDetailsView', $slug);
            }

            $isEnrolled = (Auth::check()) ? $package->isLoginUserEnrolled : false;

            if ($isEnrolled) {
                $lesson = '';

                foreach ($package->package_courses as $package_course) {
                    if (isset($package_course->course)) {
                        $lesson = LessonComplete::where('course_id', $package_course->course->id)->where('user_id', $user->id)->has('lesson')->orderBy('updated_at', 'desc')->first();

                        if ($lesson != '') {
                            break;
                        }
                    }
                }

                if (empty($lesson)) {
                    $chapter = '';
                    $lesson = '';

                    foreach ($package->package_courses as $package_course) {
                        if (isset($package_course->course)) {
                            $chapter = Chapter::where('course_id', $package_course->course->id)->whereHas('lessons')->orderBy('position', 'asc')->first();

                            if ($chapter != '') {
                                $lesson = Lesson::where('course_id', $package_course->course->id)->where('chapter_id', $chapter->id)->orderBy('position', 'asc')->first();

                                break;
                            }
                        }
                    }

                    if (empty($chapter)) {
                        Toastr::error('No lesson found', 'Failed');
                        return redirect()->route('packageDetailsView', $slug);
                    }

                    if (!empty($lesson)) {
                        $lesson_id = $lesson->id;
                    }
                } else {
                    $lesson_id = $lesson->lesson_id;
                }

                if (!empty($lesson_id)) {
                    return \redirect()->to(url('fullscreen-view/' . $package->id . '/' . $lesson_id));
                } else {
                    Toastr::error('There is no lesson for this course!', 'Failed');
                    return redirect()->route('packageDetailsView', $slug);
                }
            } else {
                Toastr::error('You are not enrolled for this course !', 'Failed');
                return redirect()->route('packageDetailsView', $slug);
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}

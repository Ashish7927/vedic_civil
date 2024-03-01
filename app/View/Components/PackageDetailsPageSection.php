<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Payment\Entities\Cart;
use Modules\StudentSetting\Entities\BookmarkPackage;
use Modules\CourseSetting\Entities\PackageEnrolled;
use Modules\CourseSetting\Entities\Package;

class PackageDetailsPageSection extends Component
{
    public $request, $package, $isEnrolled;

    public function __construct($request, $package, $isEnrolled)
    {
        $this->request = $request;
        $this->package = $package;
        $this->isEnrolled = $isEnrolled;
    }

    public function render()
    {
        $category_ids = [];
        foreach ($this->package->categories as $category) {
            $category_ids[] = $category->category_id;
        }

        $related_packages = Package::whereHas('categories', function($q) use($category_ids) {
            $q->whereIn('category_id', $category_ids);
        })
        ->with('categories', 'activeReviews', 'enrollUsers', 'cartUsers', 'package_courses.course.lessons')
        ->where('id', '!=', $this->package->id)
        ->take(2)->get();

        $more_packages_by_author = Package::with('enrollUsers', 'package_courses')->where('user_id', $this->package->user_id)->where('id', '!=', $this->package->id)->take(2)->get();

        $package_reviews = DB::table('package_reviews')->select('user_id')->where('package_id', $this->package->id)->get();

        $isEnrolled = $this->isEnrolled;

        $bookmarked = BookmarkPackage::where('user_id', Auth::id())->where('package_id', $this->package->id)->count();
        $isBookmarked = ($bookmarked == 0) ? false : true;

        if ($this->package->price == 0) {
            $isFree = true;
        } else {
            $isFree = false;
        }

        $course_ids = [];
        foreach ($this->package->package_courses as $package_course) {
            $course_ids[] = $package_course->course_id;
        }

        if ($isEnrolled) {
            $enroll = PackageEnrolled::where('user_id', Auth::id())->where('package_id', $this->package->id)->first();

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

        $reviewer_user_ids = [];
        foreach ($package_reviews as $key => $review) {
            $reviewer_user_ids[] = $review->user_id;
        }

        $course_enrolled_std = [];
        // foreach ($this->package->enrolls as $key => $enroll) {
        //     $course_enrolled_std[] = $enroll['user_id'];
        // }

        $is_cart = 0;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('package_id', $this->package->id)->first();

            if ($cart) {
                $is_cart = 1;
            }
        } else {
            $sessonCartList = session()->get('cart');
            if (!empty($sessonCartList)) {
                foreach ($sessonCartList as $item) {
                    if ($item['package_id'] == $this->package->id) {
                        $is_cart = 1;
                    }
                }
            }
        }

        $userRating = userRating($this->package->id, 1);

        return view(theme('components.package-details-page-section'), compact('userRating', 'is_cart', 'reviewer_user_ids', 'related_packages', 'isFree', 'isBookmarked', 'isEnrolled', 'more_packages_by_author'));
    }
}

<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;

class HomePageCourseSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        // $top_courses = Course::orderBy('total_enrolled', 'desc')->where('status', 1)->where('type', 1)->take(12)->with('lessons')->get();
        $free_courses = Course::orderBy('published_at', 'desc')->where('status', 1)->where('type', 1)-> where('price', 0)->where('discount_price', null)->take(20)->with('lessons')->get();
        $premium_courses = Course::orderBy('published_at', 'desc')->where('status', 1)->where('type', 1)
        ->where(function ($q){
            $q->where('price', '!=', 0)->orWhere('discount_price', '!=', null);
        })
        ->take(20)->with('lessons')->get();

        // $top_free_courses = Course::orderBy('total_enrolled', 'desc')->where('status', 1)->where('type', 1)->where('price', 0)->where('discount_price', null)->take(20)->with('lessons')->get();

        // $top_premium_courses = Course::orderBy('total_enrolled', 'desc')->where('status', 1)->where('type', 1)
        // ->where(function ($q) {
        //     $q->where('price', '!=', 0)->orWhere('discount_price', '!=', null);
        // })
        // ->take(20)->with('lessons')->get();

        $free_featured_courses = DB::table('featured_courses')->where('type', 0)->orderBy('order', 'asc')->get();
        $premium_featured_courses = DB::table('featured_courses')->where('type', 1)->orderBy('order', 'asc')->get();

        $homecat = Category::orderBy('position_order', 'ASC')->where('status', 1)->take(4)->get();

        $top_premium_courses = Course::join(
                                DB::raw('(SELECT category_id, MAX(total_enrolled) maxTotalEnrolled 
                                            FROM courses WHERE type=1 AND status=1 AND `price` > 0.00 OR `discount_price` IS NOT NULL GROUP BY category_id) courses1'),
                                            function ($join) {
                                                $join->on('courses.category_id', '=', 'courses1.category_id')
                                                    ->on('courses.total_enrolled', '=', 'courses1.maxTotalEnrolled');
                                            }
                            )->where('status', 1)->where('type', 1)
                            ->where(function ($q) {
                                    $q->where('price', '!=', 0)->orWhere('discount_price', '!=', null);
                            })->take(5)->orderBy('total_enrolled', 'desc')->get();

        $top_free_courses = Course::join(
                                DB::raw('(SELECT category_id, MAX(total_enrolled) maxTotalEnrolled 
                                            FROM courses WHERE type=1 AND status=1 AND `price` = 0.00 AND `discount_price` IS NULL GROUP BY category_id) courses1'),
                                            function ($join) {
                                                $join->on('courses.category_id', '=', 'courses1.category_id')
                                                ->on('courses.total_enrolled', '=', 'courses1.maxTotalEnrolled');
                                            }
                            )->where('status', 1)->where('type', 1)->where('price', 0)->where('discount_price', null)->take(5)->orderBy('total_enrolled', 'desc')->get();

        // return view(theme('components.home-page-course-section'), compact('top_courses','homecat'));
        return view(theme('components.home-page-course-section'), compact('free_courses', 'premium_courses','top_premium_courses', 'top_free_courses','homecat', 'free_featured_courses', 'premium_featured_courses'));
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCourseOld;

class MyHistoryPageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $course_records=UserCourseOld::where('Email',Auth::user()->email)->latest()->paginate(5);
        return view(theme('components.my-history-page-section'), compact('course_records'));
    }
}

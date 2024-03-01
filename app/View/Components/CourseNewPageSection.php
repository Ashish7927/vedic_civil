<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Localization\Entities\Language;

class CourseNewPageSection extends Component
{
    public $request, $categories, $languages;

    public function __construct($request, $categories, $languages)
    {
        $this->request = $request;
        $this->categories = $categories;
        $this->languages = $languages;
    }

    public function render()
    {
        return view(theme('components.course-new-page-section'));
    }
}

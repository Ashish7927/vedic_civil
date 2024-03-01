<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseLevel;

class ClassNewPageSectionSidebar extends Component
{
    public $categories, $languages;

    public function __construct($categories, $languages)
    {
        $this->categories = $categories;
        $this->languages = $languages;
    }


    public function render()
    {
        $levels = CourseLevel::getAllActiveData();
        $cpdata = User::whereIn('role_id', [7, 8])->get();

        return view(theme('components.class-new-page-section-sidebar'), compact('levels', 'cpdata'));
    }
}

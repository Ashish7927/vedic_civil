<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class FrontendContoller extends Controller
{


    public function aboutOne()
    {

            return view('frontend.about_one');
    }

    public function contactUs()
    {

            return view('frontend.contact_us');
    }

    public function courseOne()
    {

            return view('frontend.course_one');
    }

    public function faqPage()
    {

            return view('frontend.faq');
    }

    public function galleryGrid()
    {

            return view('frontend.gallery_grid');
    }

    public function indexPage()
    {

            return view('frontend.index');
    }

    public function privacyPolicy()
    {

            return view('frontend.privacy_policy');
    }

    public function termsCondition()
    {

            return view('frontend.terms_condition');
    }
}

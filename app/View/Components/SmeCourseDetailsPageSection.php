<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Payment\Entities\Cart;
use Modules\StudentSetting\Entities\BookmarkCourse;

class SmeCourseDetailsPageSection extends Component
{
    CONST GET_SME_COURSE_DATA = "api/V1/getSmeCourseInfo";
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function render()
    {

        $apiToken = \Config::get('app.ldap_api_token');
        $apiURL = \Config::get('app.ldap_api_url_sme_courses');
        $postInput = [
            'email' => \Auth::user()->email,
        ];

        $headers = [
            'Authorization'=> 'Bearer '. $apiToken
        ];

        $response = Http::withHeaders($headers)->get($apiURL . self::GET_SME_COURSE_DATA, $postInput);

        $statusCode = $response->status();
        $isSmeUser = [];
        if($statusCode == 200) {
            $isSmeUser = json_decode($response->getBody(), true);
        }

        return view(theme('components.sme-course-details-page-section'),compact('isSmeUser'));
    }
}

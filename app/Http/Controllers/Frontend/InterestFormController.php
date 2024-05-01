<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\User;

class InterestFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }


    public function interestform()
    {
        try {
            $companies = DB::table('companies')
            ->where('show_log_in_front', '1')
            ->take(8)->get();
            //print_r($companies); die;
            //->where('name', 'John')->first();
            return view(theme('pages.interestform'), compact('companies'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function saveInterestForm(Request $request)
    {
        // print_r($request->full_name); die;
        // $request->validate([
        //     'course_id' => 'required',
        //     //'comment' => 'required',
        // ]);


        try {

            $full_name = $request->input('full_name');
            $email_address = $request->input('email_address');
            $phone_number = $request->input('phone_number');
            $company_name = $request->input('company_name');
            $company_registration_no = $request->input('company_registration_no');
            $location = $request->input('location');
            $industry = $request->input('industry');
            $no_of_employees = $request->input('no_of_employees');
            $hrd_corp = $request->input('hrd_corp');
            $created_at = Carbon::now();

            DB::insert('insert into booked_demo (`full_name`, `email_address`, `phone_number`, `company_name`, `company_registration_no`, `location`, `industry`, `no_of_employees`, `hrd_corp`, `created_at`) values(?,?,?,?,?,?,?,?,?,?)',[$full_name, $email_address, $phone_number, $company_name, $company_registration_no, $location, $industry, $no_of_employees, $hrd_corp, $created_at]);


            //if (isset($course)) {


                $user = User::where('role_id', '5')->first();
                // if (UserEmailNotificationSetup('Course_comment', $courseUser)) {
                    send_email($user, 'Interest_form', [
                        'time' => Carbon::now()->format('d-M-Y, s:i A'),
                        'full_name' => $full_name,
                        'email_address' => $email_address,
                        'phone_number' => $phone_number,
                        'company_name' => $company_name,
                        'company_registration_no' => $company_registration_no,
                        'location' => $location,
                        'industry' => $industry,
                        'no_of_employees' => $no_of_employees,
                        'hrd_corp' => $hrd_corp,
                        'created_at' => $created_at,
                    ]);


                    // if (UserEmailNotificationSetup('Course_comment', $courseUser)) {
                        send_email($email_address, 'Interest_form', [
                            'time' => Carbon::now()->format('d-M-Y, s:i A'),
                            'full_name' => $full_name,
                            'email_address' => $email_address,
                            'phone_number' => $phone_number,
                            'company_name' => $company_name,
                            'company_registration_no' => $company_registration_no,
                            'location' => $location,
                            'industry' => $industry,
                            'no_of_employees' => $no_of_employees,
                            'hrd_corp' => $hrd_corp,
                            'created_at' => $created_at,
                        ]);


                // }
                // if (UserBrowserNotificationSetup('Course_comment', $courseUser)) {

                //     send_browser_notification($courseUser, $type = 'Course_comment', $shortcodes = [
                //         'time' => Carbon::now()->format('d-M-Y, s:i A'),
                //         'course' => $course->title,
                //         'comment' => $comment->comment,
                //     ],
                //         '',//actionText
                //         ''//actionUrl
                //     );
                // }


                Toastr::success(trans('The interest form successfully submitted'), trans('common.Success'));
                return redirect()->back();
            // } else {
            //     Toastr::error('Invalid Action !', 'Failed');
            //     return redirect()->back();
            // }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}

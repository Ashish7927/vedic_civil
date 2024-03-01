<?php

namespace Modules\StudentSetting\Http\Controllers;


use App\LessonComplete;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use Carbon\Carbon;
use App\Subscription;
use App\StudentCustomField;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Events\OneToOneConnection;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Notifications\GeneralNotification;

use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Payment\Entities\InstructorPayout;

use Yajra\DataTables\Facades\DataTables;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Group\Entities\GroupMember;
use Modules\Group\Repositories\GroupRepository;
use Illuminate\Support\Facades\Password;
use App\Models\HrdcPayout;

class StudentSettingController extends Controller
{


    public function index()
    {
        try {
            $students = [];
            $countries = DB::table('countries')->select('id','name')->whereActiveStatus(1)->get();
            return view('studentsetting::student_list', compact('students', 'countries'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function store(Request $request)
    {
        Session::flash('type', 'store');

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[@$!%*#?&]/', 'confirmed'],
            'dob' => 'required',
            'citizenship' => 'required',
            'race' => 'required',
            'gender' => 'required',
            'identification_number' => ['min:12', 'max:12']
        ];

        if (isModuleActive('Org')) {
            $rules['position'] = 'required';
            $rules['branch'] = 'required';
            $rules['start_working_date'] = 'required';
            $rules['employee_id'] = 'required';
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $success = trans('lang.Student') . ' ' . trans('lang.Added') . ' ' . trans('lang.Successfully');


            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = null;
            $user->password = bcrypt($request->password);
            $user->about = $request->about;

            if (empty($request->phone)) {
                $user->phone = null;
            } else {
                $user->phone = $request->phone;
            }
            $user->citizenship = $request->citizenship;
            $user->race = $request->race;
            $user->employment_status = $request->employment_status;
            $user->job_designation = $request->job_designation;
            $user->business_nature = $request->business_nature;
            $user->business_nature_other = $request->business_nature_other;
            $user->sector = $request->sector;
            $user->highest_academic = $request->highest_academic;
            $user->current_residing = $request->current_residing;
            $user->race_other = $request->race_other;
            $user->sector_other = $request->sector_other;
            $user->country_code = $request->country_code;
            $user->nationality = $request->nationality;
            $user->identification_number = $request->identification_number;
            $user->zip = $request->zip;


            $user->dob = $request->dob;
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->youtube = $request->youtube;
            $user->gender = $request->gender;

            if (isModuleActive('Org')) {
                $user->org_position_code = $request->position;
                $branch = $request->branch;
                $branch = explode('/', $branch);
                $user->org_chart_code = end($branch);
                $user->start_working_date = $request->start_working_date;
                $user->employee_id = $request->employee_id;
            }

            $user->language_id = Settings('language_id');
            $user->language_code = Settings('language_code');
            $user->language_name = Settings('language_name');
            $user->language_rtl = Settings('language_rtl');
            $user->country = Settings('country_id');
            $user->username = null;
            $user->teach_via = 1;


            $user->added_by = Auth::user()->id;
            $user->email_verify = 1;
            $user->email_verified_at = now();
            $user->referral = Str::random(10);


            if ($request->file('image') != "") {
                $file = $request->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/students/', $fileName);
                $fileName = 'uploads/students/' . $fileName;
                $user->image = $fileName;
            }

            $user->role_id = 3;


            $user->save();
            if (Schema::hasTable('users') && Schema::hasTable('chat_statuses')) {
                if (isModuleActive('Chat')) {
                    userStatusChange($user->id, 0);
                }
            }
            $mailchimpStatus = env('MailChimp_Status') ?? false;
            $getResponseStatus = env('GET_RESPONSE_STATUS') ?? false;
            $acelleStatus = env('ACELLE_STATUS') ?? false;
            if (hasTable('newsletter_settings')) {
                $setting = NewsletterSetting::getData();

                if ($setting->student_status == 1) {
                    $list = $setting->student_list_id;
                    if ($setting->student_service == "Mailchimp") {

                        if ($mailchimpStatus) {
                            try {
                                $MailChimp = new MailChimp(env('MailChimp_API'));
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $user->email,
                                    'status' => 'subscribed',
                                ]);
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "GetResponse") {
                        if ($getResponseStatus) {

                            try {
                                $getResponse = new \GetResponse(env('GET_RESPONSE_API'));
                                $getResponse->addContact(array(
                                    'email' => $user->email,
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->instructor_service == "Acelle") {
                        if ($acelleStatus) {

                            try {
                                $email = $user->email;
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $user->email)->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $user->email;
                                $subscribe->type = 'Student';
                                $subscribe->save();
                            } else {
                                $check->type = "Student";
                                $check->save();
                            }
                        } catch (\Exception $e) {
                        }
                    }
                }
            }

            send_email($user, 'New_Student_Reg', [
                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                'name' => $user->name
            ]);

            Toastr::success($success, 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function field()
    {
        $field = StudentCustomField::getData();
        $countries = DB::table('countries')->whereActiveStatus(1)->get();

        return view('studentsetting::field_setting', compact('field', 'countries'));
    }

    public function fieldStore(Request $request)
    {


        try {
            $entry = StudentCustomField::first();
            if ($entry) {
                $entry->delete();
            }

            $request = $this->editableConfig($request);


            StudentCustomField::create($request->all());

            Toastr::success('Student custom field updated!', trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function editableConfig(Request $request): Request
    {
        $request['editable_company'] = $request->editable_company ? 1 : 0;
        $request['editable_gender'] = $request->editable_gender ? 1 : 0;
        $request['editable_student_type'] = $request->editable_student_type ? 1 : 0;
        $request['editable_identification_number'] = $request->editable_identification_number ? 1 : 0;
        $request['editable_job_title'] = $request->editable_job_title ? 1 : 0;
        $request['editable_dob'] = $request->editable_dob ? 1 : 0;
        $request['editable_name'] = $request->editable_name ? 1 : 0;
        $request['editable_phone'] = $request->editable_phone ? 1 : 0;

        $request['show_company'] = $request->show_company ? 1 : 0;
        $request['show_gender'] = $request->show_gender ? 1 : 0;
        $request['show_student_type'] = $request->show_student_type ? 1 : 0;
        $request['show_identification_number'] = $request->show_identification_number ? 1 : 0;
        $request['show_job_title'] = $request->show_job_title ? 1 : 0;
        $request['show_dob'] = $request->show_dob ? 1 : 0;
        $request['show_name'] = $request->show_name ? 1 : 0;
        $request['show_phone'] = $request->show_phone ? 1 : 0;

        $request['required_company'] = $request->required_company ? 1 : 0;
        $request['required_gender'] = $request->required_gender ? 1 : 0;
        $request['required_student_type'] = $request->required_student_type ? 1 : 0;
        $request['required_identification_number'] = $request->required_identification_number ? 1 : 0;
        $request['required_job_title'] = $request->required_job_title ? 1 : 0;
        $request['required_dob'] = $request->required_dob ? 1 : 0;
        $request['required_name'] = $request->required_name ? 1 : 0;
        $request['required_phone'] = $request->required_phone ? 1 : 0;
        return $request;
    }


    public function update(Request $request)
    {
        Session::flash('type', 'update');

        if (demoCheck()) {
            return redirect()->back();
        }


        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => ['bail', 'nullable', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[@$!%*#?&]/', 'confirmed'],
            'dob' => 'required',
            'citizenship' => 'required',
            'race' => 'required',
            'gender' => 'required',
            'identification_number' => ['min:12', 'max:12']

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {
                // $success = trans('lang.Student') .' '.trans('lang.Updated').' '.trans('lang.Successfully');

                $user = User::find($request->id);
                $oldData = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->username = null;
                if (empty($request->phone)) {
                    $user->phone = null;
                } else {
                    $user->phone = $request->phone;
                }
                $user->dob = $request->dob;

                $user->citizenship = $request->citizenship;
                $user->race = $request->race;
                $user->employment_status = $request->employment_status;
                $user->job_designation = $request->job_designation;
                $user->business_nature = $request->business_nature;
                $user->business_nature_other = $request->business_nature_other;
                $user->sector = $request->sector;
                $user->highest_academic = $request->highest_academic;
                $user->current_residing = $request->current_residing;
                $user->race_other = $request->race_other;
                $user->sector_other = $request->sector_other;
                $user->country_code = $request->country_code;
                $user->nationality = $request->nationality;
                $user->identification_number = $request->identification_number;
                $user->zip = $request->zip;

                $user->facebook = $request->facebook;
                $user->twitter = $request->twitter;
                $user->linkedin = $request->linkedin;
                $user->youtube = $request->youtube;
                $user->about = $request->about;
                if (isModuleActive('Org')) {
                    $user->org_position_code = $request->position;
                    // $user->org_chart_code = $request->branch;
                    $user->start_working_date = $request->start_working_date;
                    $user->employee_id = $request->employee_id;
                }
                $user->email_verify = 1;
                $user->gender = $request->gender;
                if ($request->password) {
                    $user->password = bcrypt($request->password);
                }
                if ($request->file('image') != "") {
                    $file = $request->file('image');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('uploads/students/', $fileName);
                    $fileName = 'uploads/students/' . $fileName;
                    $user->image = $fileName;
                }
                $user->role_id = 3;
                $user->save();
                if (!empty($user->getChanges())) {
                    $original = $oldData->getOriginal();
                    $changes = [];

                    foreach ($user->getChanges() as $key => $value) {
                        $changes[$key] = [
                            'original' => $original[$key],
                            'changes' => $value,
                        ];
                    }
                    \App\Models\auditTrailLearnerProfile::create(
                        [
                            'subject' => json_encode($changes),
                            'email' => $user->email,
                            'type' => '1',
                            'url' => url()->current(),
                            'ip' => request()->ip(),
                            "agent" => request()->userAgent(),
                            "user_id" => Auth::user()->id,
                            'learner_name' => $user->name
                        ]
                    );
                }
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::findOrFail($request->id);

        try {
            $success = trans('lang.Student') . ' ' . trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            $user->delete();

            Toastr::success($success, 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function resetPassword(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::findOrFail($request->id);

        try {
            $success = trans('lang.The Email had been sent ') . trans('lang.Successfully');

            $status = Password::sendResetLink(
                ["email" => $user["email"]]
            );

            Toastr::success($success, 'Success');
            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function getAllStudentData(Request $request)
    {
        $query = User::where('role_id', 3);
        // if ($request->created_at != 'all' && !is_null($request->created_at) && !$request->created_at=="") {
        //     $query = $query->where('created_at', 'like', '%' . $request->created_at . '%');
        // }
        if (!empty($request->start_date)  && $request->start_date != "") {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if (!empty($request->end_date)  && $request->end_date != "") {

            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ((empty($request->start_date)  || $request->start_date == "") && (empty($request->end_date)  || $request->end_date == "")) {
            //  $today = date("Y-m-d", strtotime("-3 months"));
            //  $query = $query->where('created_at', '>=', $today);
        }

        if ($request->name != 'all' && !is_null($request->name) && !$request->name == "") {
            $query = $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email != 'all' && !is_null($request->email) && !$request->email == "") {
            $query = $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->citizenship != 'all' && !is_null($request->citizenship) && !$request->citizenship == "") {
            $query = $query->where('citizenship', $request->citizenship);
        }
        if ($request->country != 'all' && !is_null($request->country) && !$request->country == "") {
            $query = $query->where('nationality', $request->country);
        }
        if ($request->race != 'all' && !is_null($request->race) && !$request->race == "") {
            $query = $query->where('race', $request->race);
        }
        if ($request->identification_number != 'all' && !is_null($request->identification_number) && !$request->identification_number == "") {
            $query = $query->where('identification_number', 'like', '%' . $request->identification_number . '%');
        }

        if ($request->dob != 'all' && !is_null($request->dob) && !$request->dob == "") {
            $query = $query->where('dob', 'like', '%' . date('m/d/Y', strtotime($request->dob)) . '%');
        }

        if ($request->gender != 'all' && !is_null($request->gender) && !$request->gender == "") {
            $query = $query->where('gender', $request->gender);
        }
        if ($request->phone != 'all' && !is_null($request->phone) && !$request->phone == "") {
            $query = $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->employment_status != 'all' && !is_null($request->employment_status) && !$request->employment_status == "") {
            $query = $query->where('employment_status', $request->employment_status);
        }
        if ($request->job_designation != 'all' && !is_null($request->job_designation) && !$request->job_designation == "") {
            $query = $query->where('job_designation', $request->job_designation)->where('employment_status', 'working');
        }
        if ($request->sector != 'all' && !is_null($request->sector) && !$request->sector == "") {
            $query = $query->where('sector', $request->sector)->where('employment_status', 'working');
        }
        if ($request->not_working != 'all' && !is_null($request->not_working) && !$request->not_working == "") {
            $query = $query->where('not_working', $request->not_working)->where('employment_status', 'not-working');
        }
        if ($request->business_nature != 'all' && !is_null($request->business_nature) && !$request->business_nature == "") {
            $query = $query->where('business_nature', $request->business_nature)->where('employment_status', 'self-employed');
        }
        if ($request->business_nature_other != 'all' && !is_null($request->business_nature_other) && !$request->business_nature_other == "") {
            $query = $query->where('business_nature_other', 'like', '%' . $request->business_nature_other . '%');
        }
        if ($request->highest_academic != 'all' && !is_null($request->highest_academic) && !$request->highest_academic == "") {
            $query = $query->where('highest_academic', $request->highest_academic);
        }
        if ($request->current_residing != 'all' && !is_null($request->current_residing) && !$request->current_residing == "") {
            $query = $query->where('current_residing', $request->current_residing);
        }
        if ($request->zip != 'all' && !is_null($request->zip) && !$request->zip == "") {
            $query = $query->where('zip', 'like', '%' . $request->zip . '%');
        }


        // dd(date('m/d/Y', strtotime($request->dob)));
        // dd($query->where('name', $request->name));
        // if ($request->request_type != 'all' && !is_null($request->request_type)) {
        //     $query = $query->where('request_type', $request->request_type);
        // }
        // if ($request->status != 'all' && !is_null($request->status)) {
        //     $query = $query->where('status', $request->status);
        // }

        return Datatables::of($query)
            ->addIndexColumn()->editColumn('name', function ($query) {
                return $query->name;
            })->editColumn('email', function ($query) {
                return $query->email;
            })
            ->addColumn('phone', function ($query) {
                $countrycode = str_replace('+', '', $query->country_code);
                return $countrycode . '' . $query->phone;
            })
            ->editColumn('gender', function ($query) {
                return ucfirst($query->gender);
            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);
            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;
            })
            ->addColumn('race', function ($query) {
                $race = $query->race;
                $race_other = $query->race_other;
                $view = '<div>' . $race . '<br/>' . $race_other . '</div>';

                return $view;
            })
            ->editColumn('citizenship', function ($query) {
                return $query->citizenship;
            })
            ->editColumn('identification_number', function ($query) {
                return $query->identification_number;
            })
            ->editColumn('job_designation', function ($query) {
                return $query->job_designation;
            })
            ->addColumn('sector', function ($query) {
                $sector = $query->sector;
                $sector_other = $query->sector_other;
                $view = '<div>' . $sector . '<br/>' . $sector_other . '</div>';

                return $view;
            })
            ->editColumn('not_working', function ($query) {
                return $query->not_working;
            })
            ->editColumn('business_nature', function ($query) {
                return $query->business_nature;
            })
            ->editColumn('business_nature_other', function ($query) {
                return $query->business_nature_other;
            })->editColumn('zip', function ($query) {
                return $query->zip;
            })
            ->addColumn('employment_status', function ($query) {
                $employment_status = $query->employment_status;
                if ($employment_status == 'Working') {
                    $type = 'Job Designation -' . $query->job_designation . '<br/>Sector -' . $query->sector . '<br/>' . $query->other;
                } elseif ($employment_status == 'Not Working') {
                    $type = 'Not Working Status -' . $query->not_working;
                } else {
                    $type = 'Business Nature -' . $query->business_nature . '<br/>' . $query->business_nature_other;
                }
                $view = '<div>' . $employment_status . '<br/>' . $type . '</div>';

                return $employment_status;
            })
            ->editColumn('highest_academic', function ($query) {
                return $query->highest_academic;
            })
            ->editColumn('current_residing', function ($query) {
                return $query->current_residing;
            })
            ->editColumn('created_at', function ($query) {
                return showDate($query->created_at);
            })
            ->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })->addColumn('course_count', function ($query) {

                $link = '<a class="dropdown-item" href="' . route('student.courses', $query->id) . '" data-id="' . $query->id . '" type="button">' . $query->enrollCourse->count() . '</a>';
                return $link;
            })->addColumn('action', function ($query) {

                if (permissionCheck('student.edit')) {

                    $student_edit = '  <button data-item-id =\'' . $query->id . '\'
                                                                class="dropdown-item editStudent"
                                                                type="button">' . trans('common.Edit') . '</button>';
                } else {
                    $student_edit = "";
                }
                if (permissionCheck('student.view_learner_profile')) {
                    $student_view_learner_profile = '  <button data-item-id =\'' . $query->id . '\'
                                                                    class="dropdown-item viewLearnerProfile"
                                                                    type="button">' . trans('common.View Profile') . '</button>';
                } else {
                    $student_view_learner_profile = "";
                }


                if (permissionCheck('student.reset_password')) {

                    $student_reset_password = '<button class="dropdown-item resetPasswordStudent"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Reset Password') . '</button>';
                } else {
                    $student_reset_password = "";
                }
                if (permissionCheck('student.delete')) {

                    $student_delete = '<button class="dropdown-item deleteStudent"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Delete') . '</button>';
                } else {
                    $student_delete = "";
                }
                if (permissionCheck('student.courses')) {

                    $student_courses = '<a class="dropdown-item" href="' . route('student.courses', $query->id) . '" data-id="' . $query->id . '" type="button"><b>' . trans('courses.Courses Enrolled') . '</b></a>';
                } else {
                    $student_courses = "";
                }

                if (permissionCheck('student.impersonate')) {
                    $student_impersonate = '<button class="dropdown-item impersonateStudent"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Impersonate') . '</button>';
                } else {
                    $student_impersonate = "";
                }

                if (permissionCheck('student.send_mail')) {
                    $student_send_mail = '<button class="dropdown-item sendEmailStudent"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Send Reminder Email') . '</button>';
                } else {
                    $student_send_mail = "";
                }

                $student_notification = "";
                if (permissionCheck('student.notification')) {
                    $student_notification = '<button class="dropdown-item notificationstudent" data-id="' . $query->id . '" type="button">Send Notification</button>';
                }

                if (empty($student_edit)) {
                    $actioinView = ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        ' . $student_view_learner_profile . '
                                                        ' . $student_delete . '
                                                        ' . $student_courses . '
                                                        ' . $student_reset_password . '
                                                        ' . $student_impersonate . '
                                                        ' . $student_send_mail . '
                                                        ' . $student_notification . '
                                                    </div>
                                                </div>';
                } else {
                    $actioinView = ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        ' . $student_edit . '
                                                        ' . $student_delete . '
                                                        ' . $student_courses . '
                                                        ' . $student_reset_password . '
                                                        ' . $student_impersonate . '
                                                        ' . $student_send_mail . '
                                                        ' . $student_notification . '
                                                    </div>
                                                </div>';
                }

                return $actioinView;
            })->rawColumns(['status', 'image', 'course_count', 'action', 'race', 'employment_status', 'phone', 'sector'])
            ->make(true);
    }

    public function studentAssignedCourses($id)
    {
        try {
            $certificateIds = [];
            $user = User::find($id);
            $courses = $user->enrollCourse;
            $instance = $user->enCoursesInstance->load('course.user');
            $notEnrolled = Course::where('status', 1)->whereNotIn('id', $courses->pluck('id')->toArray())->get();
            $certificateReports = CertificateRecord::select("*")->whereIn("course_id", $instance->pluck('course_id')->toArray())->where("student_id", $id)->get();
            foreach ($certificateReports as $certificateReport) {
                $certificateIds[] =
                    [
                        "certificate_id" => $certificateReport["certificate_id"],
                        "course_id"      => $certificateReport["course_id"]
                    ];
            }
            // return $instance;
            return view('studentsetting::student_courses', compact('courses', 'instance', 'user', 'notEnrolled', 'certificateIds'));
        } catch (\Throwable $th) {
            GettingError($th->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function newEnroll()
    {

        try {
            $courses = Course::where('status', 1)->select('id', 'title', 'type')->get();
            $students = User::where('role_id', 3)->where('status', 1)->select('id', 'name')->get();
            return view('studentsetting::new_enroll', compact('courses', 'students'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function newEnrollSubmit(Request $request)
    {


        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'student' => 'required|array',
            'course' => 'required'

        ];

        $this->validate($request, $rules, validationMessage($rules));
        try {
            $students = $request->student;

            foreach ($students as $student) {

                $user = User::find($student);
                if ($user) {
                    $course = Course::findOrFail($request->course);
                    $instractor = User::findOrFail($course->user_id);

                    $check = CourseEnrolled::where('user_id', $user->id)->where('course_id', $request->course)->first();
                    if ($check) {
                        Toastr::error($user->name . ' has already been enrolled to this course', 'Success');
                    } else {
                        if (isModuleActive('Group')) {
                            if ($course->isGroupCourse) {
                                $groupRepo = new GroupRepository();
                                $group = $groupRepo->find($course->isGroupCourse->id);
                                if ($group && $group->maximum_enroll > $group->members->where('user_role_id', 3)->count()) {
                                    GroupMember::create([
                                        'group_id' => $course->isGroupCourse->id,
                                        'user_id' => $user->id,
                                        'user_role_id' => 3,
                                    ]);
                                    if ($group->maximum_enroll <= $group->members->where('user_role_id', 3)->count()) {
                                        $group->update(['quota_status' => 1]);
                                    } else {
                                        $group->update(['quota_status' => 0]);
                                    }
                                    Toastr::success('User Add To Group Successfully');
                                } else {
                                    Toastr::warning("Group Member Can't exceed Maximum Limit");
                                }
                            }
                        }


                        $enrolled = $course->total_enrolled;
                        $course->total_enrolled = ($enrolled + 1);
                        $enrolled = new CourseEnrolled();
                        $enrolled->user_id = $user->id;
                        $enrolled->course_id = $request->course;
                        $enrolled->purchase_price = $course->discount_price != null ? $course->discount_price : $course->price;
                        $enrolled->save();


                        $itemPrice = $enrolled->purchase_price;


                        // if (!is_null($course->special_commission) && $course->special_commission != 0) {
                        //     $commission = $course->special_commission;
                        //     $reveune = ($itemPrice * $commission) / 100;
                        //     $enrolled->reveune = $reveune;
                        // } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                        //     $commission = $instractor->special_commission;
                        //     $reveune = ($itemPrice * $commission) / 100;
                        //     $enrolled->reveune = $reveune;
                        // } else {
                        //     $commission = 100 - Settings('commission');
                        //     $reveune = ($itemPrice * $commission) / 100;
                        //     $enrolled->reveune = $reveune;
                        // }

                        if (check_if_instructor_cp_or_partner($course->user_id)) {
                            $commission = get_instructor_commission();
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        } else {
                            $commission = 100 - Settings('commission');
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        }

                        $payout = new InstructorPayout();
                        $payout->instructor_id = $course->user_id;
                        $payout->reveune = $reveune;
                        $payout->status = 0;
                        $payout->save();

                        if (!is_null($course->hrdc_commission) && $course->hrdc_commission != 0) {
                            $hrdccommission = $course->hrdc_commission;
                            $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                            $enrolled->hrdc_reveune = $hrdc_reveune;
                        } elseif (!is_null($instractor->hrdc_commission) && $instractor->hrdc_commission != 0) {
                            $hrdccommission = $instractor->hrdc_commission;
                            $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                            $enrolled->hrdc_reveune = $hrdc_reveune;
                        } else {
                            $hrdccommission = 100 - Settings('hrdc_commission');
                            $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                            $enrolled->hrdc_reveune = $hrdc_reveune;
                        }

                        $myll_commission = 100 - ($commission + $hrdccommission);
                        $myll_reveune = ($itemPrice * $myll_commission) / 100;

                        $hrdc_payout = new HrdcPayout();
                        $hrdc_payout->instructor_id = $course->user_id;
                        $hrdc_payout->hrdc_reveune = $hrdc_reveune;
                        $hrdc_payout->myll_reveune = $myll_reveune;
                        $hrdc_payout->status = 0;
                        $hrdc_payout->save();


                        if (UserEmailNotificationSetup('Course_Enroll_Payment', $user)) {
                            send_email($user, 'Course_Enroll_Payment', [
                                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                                'currency' => $user->currency->symbol ?? '$',
                                'price' => ($user->currency->conversion_rate * $itemPrice),
                                'instructor' => $course->user->name,
                                'gateway' => 'Offline',
                            ]);
                        }
                        if (UserBrowserNotificationSetup('Course_Enroll_Payment', $user)) {

                            send_browser_notification(
                                $user,
                                $type = 'Course_Enroll_Payment',
                                $shortcodes = [
                                    'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                                    'course' => $course->title,
                                    'currency' => $user->currency->symbol ?? '$',
                                    'price' => ($user->currency->conversion_rate * $itemPrice),
                                    'instructor' => $course->user->name,
                                    'gateway' => 'Offline',
                                ],
                                '', //actionText
                                '' //actionUrl
                            );
                        }
                        if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                            send_email($instractor, 'Enroll_notify_Instructor', [
                                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                                'currency' => $instractor->currency->symbol ?? '$',
                                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                                'rev' => @$reveune,
                            ]);
                        }
                        if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instractor)) {

                            send_browser_notification(
                                $instractor,
                                $type = 'Enroll_notify_Instructor',
                                $shortcodes = [
                                    'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                    'course' => $course->title,
                                    'currency' => $instractor->currency->symbol ?? '$',
                                    'price' => ($instractor->currency->conversion_rate * $itemPrice),
                                    'rev' => @$reveune,
                                ],
                                '', //actionText
                                '' //actionUrl
                            );
                        }


                        $enrolled->save();

                        $course->reveune = (($course->reveune) + ($enrolled->reveune));

                        $course->save();

                        // $notification = new Notification();
                        // $notification->author_id = $course->user_id;
                        // $notification->user_id = $user->id;
                        // $notification->course_id = $course->id;
                        // $notification->course_enrolled_id = $enrolled->id;
                        // $notification->status = 0;

                        // $notification->save();

                        if (isModuleActive('Chat')) {
                            event(new OneToOneConnection($instractor, $user, $course));
                        }

                        //start email subscription
                        if ($instractor->subscription_api_status == 1) {
                            try {
                                if ($instractor->subscription_method == "Mailchimp") {
                                    $list = $course->subscription_list;
                                    $MailChimp = new MailChimp($instractor->subscription_api_key);
                                    $MailChimp->post("lists/$list/members", [
                                        'email_address' => Auth::user()->email,
                                        'status' => 'subscribed',
                                    ]);
                                } elseif ($instractor->subscription_method == "GetResponse") {

                                    $list = $course->subscription_list;
                                    $getResponse = new \GetResponse($instractor->subscription_api_key);
                                    $getResponse->addContact(array(
                                        'email' => Auth::user()->email,
                                        'campaign' => array('campaignId' => $list),

                                    ));
                                }
                            } catch (\Exception $exception) {
                                GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                            }
                        }
                        Toastr::success($user->name . ' Successfully Enrolled this course', 'Success');
                    }
                }
            }


            return redirect()->to(route('admin.enrollLogs'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function impersonate(Request $request)
    {
        if (permissionCheck('student.impersonate')) {
            Auth::logout();
            Auth::loginUsingId($request->id);
            return redirect()->to('student-dashboard');
        }
        return true;
    }

    public function sendMail(Request $request)
    {
        $students = User::query();
        $time = strtotime(now());
        $students = $students->where("id", "=", $request->id);
        $students = $students->with("enrollCourse")->get();
        foreach ($students as $student) {
            $courses = $student->enrollCourse->toArray();
            foreach ($courses as $course) {
                if (round($this->userTotalPercentage($student->id, $course["id"])) != 100) {
                    $dataSendMail =
                        [
                            "name" => $student->name,
                            "content" => url("/") . "/my-courses"
                        ];
                    Mail::to($student->email)
                        ->send(new SendMail($dataSendMail));
                    break;
                }
            }

            DB::table("users")->where("id", $request->id)->update(["send_reminder_email_time" => now()]);

            Toastr::success(trans('common.Send Email'), trans('common.Success'));
            return redirect()->to(route('student.student_list'));
        }
    }

    private function userTotalPercentage($user_id, $course_id)
    {
        $complete_lesson = LessonComplete::where('user_id', $user_id)->where('course_id', $course_id)->where('status', 1)->get();
        $lesson = Lesson::where('course_id', $course_id)->get();
        $countCourse = count($complete_lesson);
        if ($countCourse != 0) {
            $percentage = ceil($countCourse / count($lesson) * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;
    }

    public function notify(Request $request)
    {
        // dd($request->all());
        $rules = [
            'type' => 'required',
            'notification' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::find($request->id);
        if ($user) {
            if (in_array("email", $request->type)) {
                send_email($user, 'student_notification', ['name' => $user->name, 'comment' => $request->notification]);
                Toastr::success('Mail Sent Successfully!', trans('common.Success'));
            }
            if (in_array("portal", $request->type)) {
                $details = [
                    "title" => "Custom Notification",
                    "body" => $request->notification,
                    "actionText" => "",
                    "actionURL" => ""
                ];
                \Illuminate\Support\Facades\Notification::send($user, new GeneralNotification($details));
                Toastr::success('Notification Sent Successfully!', trans('common.Success'));
            }
            return redirect()->back();
        }
        Toastr::error('User not found!', trans('common.Failed'));
        return redirect()->back();
    }
}

<?php

namespace Modules\RolePermission\Http\Controllers;


use Image;
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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;


use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\Notification;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Setting\Model\GeneralSetting;
use Modules\RolePermission\Entities\Role;
use Yajra\DataTables\Facades\DataTables;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Group\Entities\GroupMember;
use Modules\Group\Repositories\GroupRepository;


class AdminuserController extends Controller
{


    public function index()
    {
        try {
            $students = [];
            $roles = DB::table('roles')->where('id','!=','1')->where('id','!=','2')->where('id','!=','3')->get(); 
            return view('rolepermission::adminuser/index', compact('students', 'roles'));

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
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*(_|[^\w])).+$/', 'confirmed'],
            'gender' => 'required'
        ];
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

            $user->country_code=$request->country_code;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
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

            $user->role_id = $request->role_id;


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


                if ($setting->instructor_status == 1) {
                    $list = $setting->instructor_list_id;
                    if ($setting->instructor_service == "Mailchimp") {

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
                    } elseif ($setting->instructor_service == "GetResponse") {
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
                    } elseif ($setting->instructor_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $user->email)->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $user->email;
                                $subscribe->type = 'Instructor';
                                $subscribe->save();
                            } else {
                                $check->type = "Instructor";
                                $check->save();
                            }
                        } catch (\Exception $e) {

                        }
                    }
                }


            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
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

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {

                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->username = null;
                if (empty($request->phone)) {
                    $user->phone = null;
                } else {
                    $user->phone = $request->phone;
                }
                $user->dob = $request->dob;
                $user->country_code=$request->country_code;
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
                $user->role_id = $request->role_id;
                $user->save();
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
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            $user->delete();

            Toastr::success($success, 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function getAllAdminData(Request $request)
    {


        $query = User::where('role_id','!=',3)->where('role_id','!=',1)->where('role_id','!=',2);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getInstructorImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })->addColumn('group_policy', function ($query) {
                $policy = '';
                if (isModuleActive('OrgInstructorPolicy')) {
                    $policy = $query->policy->name;
                }
                return $policy;

            })->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;


            })->addColumn('action', function ($query) {

               
                    $admin_edit = '  <button data-item-id =\'' . $query->id . '\' class="dropdown-item editAdmin" type="button">' . trans('common.Edit') . '</button>';
                    $admin_delete = '<button class="dropdown-item deleteAdmin" data-id="' . $query->id . '" type="button">' . trans('common.Delete') . '</button>';

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        ' . $admin_edit . '
                                                        ' . $admin_delete . '




                                                    </div>
                                                </div>';

                return $actioinView;


            })->rawColumns(['status', 'image', 'action'])->make(true);
    }


   
}

<?php

namespace Modules\SystemSetting\Http\Controllers;

use App\City;
use App\Country;
use App\Exports\PartnerExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Image;
use App\User;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DrewM\MailChimp\MailChimp;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Illuminate\Support\Facades\Mail;
use Modules\FrontendManage\Entities\HeaderMenu;
use Modules\FrontendManage\Entities\FrontPage;
use Illuminate\Support\Str;

class PartnerSettingController extends Controller
{
    public function index()
    {
        try {
            $partners = [];

            return view('systemsetting::partner', compact('partners'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    // public function store(Request $request)
    // {
    //     Session::flash('type', 'store');

    //     if (demoCheck()) {
    //         return redirect()->back();
    //     }


    //     $rules = [
    //         'name' => 'required',
    //         'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|unique:users,phone',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:8|confirmed',
    //     ];


    //     $this->validate($request, $rules, validationMessage($rules));


    //     try {

    //         $user = new User;
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->username = null;
    //         $user->password = bcrypt($request->password);
    //         $user->about = $request->about;
    //         $user->dob = $request->dob;

    //         if (empty($request->phone)) {
    //             $user->phone = null;
    //         } else {
    //             $user->phone = $request->phone;
    //         }
    //         $user->language_id = Settings('language_id');
    //         $user->language_code = Settings('language_code');
    //         $user->language_name = Settings('language_name');
    //         $user->language_rtl = Settings('language_rtl');
    //         $user->country = Settings('country_id');
    //         $user->username = null;
    //         $user->facebook = $request->facebook;
    //         $user->twitter = $request->twitter;
    //         $user->linkedin = $request->linkedin;
    //         $user->instagram = $request->instagram;
    //         $user->added_by = 1;
    //         $user->email_verify = 1;
    //         $user->email_verified_at = now();

    //         if ($request->file('image') != "") {
    //             $file = $request->file('image');
    //             $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
    //             $file->move('uploads/instructors/', $fileName);
    //             $fileName = 'uploads/instructors/' . $fileName;
    //             $user->image = $fileName;
    //         }

    //         $user->role_id = 8;
    //         $user->save();


    //         if (Schema::hasTable('users') && Schema::hasTable('chat_statuses')) {
    //             if (isModuleActive('Chat')) {
    //                 userStatusChange($user->id, 0);
    //             }
    //         }


    //         $mailchimpStatus = env('MailChimp_Status') ?? false;
    //         $getResponseStatus = env('GET_RESPONSE_STATUS') ?? false;
    //         $acelleStatus = env('ACELLE_STATUS') ?? false;
    //         if (hasTable('newsletter_settings')) {
    //             $setting = NewsletterSetting::getData();


    //             if ($setting->instructor_status == 1) {
    //                 $list = $setting->instructor_list_id;
    //                 if ($setting->instructor_service == "Mailchimp") {

    //                     if ($mailchimpStatus) {
    //                         try {
    //                             $MailChimp = new MailChimp(env('MailChimp_API'));
    //                             $MailChimp->post("lists/$list/members", [
    //                                 'email_address' => $user->email,
    //                                 'status' => 'subscribed',
    //                             ]);

    //                         } catch (\Exception $e) {
    //                         }
    //                     }
    //                 } elseif ($setting->instructor_service == "GetResponse") {
    //                     if ($getResponseStatus) {

    //                         try {
    //                             $getResponse = new \GetResponse(env('GET_RESPONSE_API'));
    //                             $getResponse->addContact(array(
    //                                 'email' => $user->email,
    //                                 'campaign' => array('campaignId' => $list),
    //                             ));
    //                         } catch (\Exception $e) {

    //                         }
    //                     }
    //                 } elseif ($setting->instructor_service == "Acelle") {
    //                     if ($acelleStatus) {

    //                         try {
    //                             $email = $user->email;
    //                             $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
    //                             $acelleController = new AcelleController();
    //                             $response = $acelleController->curlPostRequest($make_action_url);
    //                         } catch (\Exception $e) {

    //                         }
    //                     }
    //                 } elseif ($setting->instructor_service == "Local") {
    //                     try {
    //                         $check = Subscription::where('email', '=', $user->email)->first();
    //                         if (empty($check)) {
    //                             $subscribe = new Subscription();
    //                             $subscribe->email = $user->email;
    //                             $subscribe->type = 'Instructor';
    //                             $subscribe->save();
    //                         } else {
    //                             $check->type = "Instructor";
    //                             $check->save();
    //                         }
    //                     } catch (\Exception $e) {

    //                     }
    //                 }
    //             }


    //         }


    //         Toastr::success(trans('common.Operation successful'), trans('common.Success'));
    //         return redirect()->back();

    //     } catch (\Exception $e) {
    //         GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
    //     }
    // }


    // public function update(Request $request)
    // {
    //     Session::flash('type', 'update');

    //     if (demoCheck()) {
    //         return redirect()->back();
    //     }
    //     $rules = [
    //         'name' => 'required',
    //         'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->id,
    //         'email' => 'required|email|unique:users,email,' . $request->id,
    //         'password' => 'bail|nullable|min:8|confirmed',

    //     ];

    //     $this->validate($request, $rules, validationMessage($rules));


    //     try {

    //         if (Config::get('app.app_sync')) {
    //             Toastr::error('For demo version you can not change this !', 'Failed');
    //             return back();
    //         } else {

    //             $user = User::find($request->id);
    //             $user->name = $request->name;
    //             $user->email = $request->email;
    //             $user->username = null;
    //             $user->facebook = $request->facebook;
    //             $user->twitter = $request->twitter;
    //             $user->linkedin = $request->linkedin;
    //             $user->instagram = $request->instagram;
    //             $user->about = $request->about;
    //             $user->dob = $request->dob;
    //             if (empty($request->phone)) {
    //                 $user->phone = null;
    //             } else {
    //                 $user->phone = $request->phone;
    //             }
    //             if ($request->password)
    //                 $user->password = bcrypt($request->password);


    //             $fileName = "";
    //             if ($request->file('image') != "") {
    //                 $file = $request->file('image');
    //                 $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
    //                 $file->move('uploads/instructors/', $fileName);
    //                 $fileName = 'uploads/instructors/' . $fileName;
    //                 $user->image = $fileName;
    //             }

    //             $user->role_id = 8;
    //             $user->save();

    //         }

    //         Toastr::success(trans('common.Operation successful'), trans('common.Success'));
    //         return redirect()->back();

    //     } catch (\Exception $e) {
    //         GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
    //     }
    // }


    // public function destroy(Request $request)
    // {
    //     if (demoCheck()) {
    //         return redirect()->back();
    //     }

    //     $rules = [
    //         'id' => 'required'
    //     ];

    //     $this->validate($request, $rules, validationMessage($rules));

    //     try {

    //         if (Config::get('app.app_sync')) {
    //             Toastr::error('For demo version you can not change this !', 'Failed');
    //             return redirect()->back();
    //         } else {
    //             $success = trans('lang.Instructor') . ' ' . trans('lang.Updated') . ' ' . trans('lang.Successfully');

    //             $user = User::with('courses')->findOrFail($request->id);
    //             if (count($user->courses) > 0) {
    //                 Toastr::error($user->name . ' has course. Please remove it first', 'Failed');
    //                 return back();
    //             }
    //             $user->delete();

    //         }
    //         Toastr::success(trans('common.Operation successful'), trans('common.Success'));
    //         return redirect()->back();

    //     } catch (\Exception $e) {
    //         GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
    //     }
    // }

    public function get_all_partner_data(Request $request)
    {
        $with = [];

        $query = User::where('role_id', 8)->with($with);

        if ($request->search_partner_status != "") {
            $query->where('verified_by_admin', $request->search_partner_status);
        }

        if ($request->email_address != '') {
            $query->where('email', $request->email_address);
        }

        if ($request->partner_name != '') {
            $query->where('name', $request->partner_name);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getInstructorImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })
            ->editColumn('name', function ($query) {
                return $query->name;

            })
            ->editColumn('email', function ($query) {
                return $query->email;

            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? "checked" : "";
                $view = 'Approved';

                if ($query->verified_by_admin == 0) {
                    $view = 'Pending';
                } elseif ($query->verified_by_admin == 2) {
                    $view = 'Rejected';
                }
                return $view;
            })
            ->addColumn('enabled_package', function($query) {
                $checked = $query->is_enabled_package == 1 ? "checked" : "";
                if (isAdmin() || isHRDCorp() || isMyLL()) {
                    $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                <input type="checkbox" class="enabled_package" id="active_checkbox'.$query->id.'" value="'.$query->id.'" data-id="'.$query->id.'" data-enabled-package="'.$query->is_enabled_package.'" '.$checked.'>
                                <i class="slider round"></i>
                            </label>';
                } else {
                    $view = ($checked == 'checked') ? 'Enable' : 'Disable' ;
                }


                return $view;
            })
            ->addColumn('action', function ($query) {
                $instructor_edit        = "";
                $instructor_delete      = "";
                $instructor_course_api  = "";
                $impersonate            = '';

                if (permissionCheck('instructor.edit')) {
                    $instructor_edit = '  <button data-id =\'' . $query->id . '\' class="dropdown-item edit_partner_btn" type="button">' . trans('common.Edit') . '</button>';
                }

                if (permissionCheck('instructor.delete')) {
                    $instructor_delete = '<button class="dropdown-item deleteInstructor" data-id="' . $query->id . '" type="button">' . trans('common.Delete') . '</button>';
                }

                if (permissionCheck('instructor.course_api_key') && $query->is_allow_course_api_key != 1) {
                    $instructor_course_api = '<button class="dropdown-item allowInstructorCourseApi" data-id="' . $query->id . '" type="button">' . trans('common.Allow Course Api Key') . '</button>';
                }

                $viewButton = ' <button class="dropdown-item view_partner_btn" data-id="' . $query->id . '">View</button>';

                if ($query->verified_by_admin == 1) {
                    $impersonate = ' <button class="dropdown-item impersonate_partner_btn" data-id="' . $query->id . '">Impersonate</button>';
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                            aria-labelledby="dropdownMenu2">
                                        ' . $instructor_edit . '
                                        ' . $instructor_delete . '
                                        ' . $viewButton . '
                                        ' . $impersonate . '
                                        ' . $instructor_course_api . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['status', 'image', 'action', 'enabled_package'])
            ->make(true);
    }

    public function change_enabled_package_status(Request $request) {
        if (appMode()) {
            return response()->json(['warning' => trans('common.For the demo version, you cannot change this')], 200);
        }
        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }

        try {
            $user = User::where('id', $request->partner_id)->where('is_enabled_package', $request->enabled_package)->first();

            if ($user) {
                $update_enable_package_status = ($user->is_enabled_package == 1) ? 0 : 1;
                $user->is_enabled_package = $update_enable_package_status;

                if ($user->save()) {
                    $user_name = str_replace(' ', '-', Str::lower($user->name));
                    $link = "/partner/".$user_name."/packages";
                    $header_menu = HeaderMenu::where('link', $link)->first();

                    if(empty($header_menu)){
                        $header_menu_parent = HeaderMenu::select('id')->where('title', 'Partners')->first();
                        $header_menu_position = HeaderMenu::select('position')->where('parent_id', $header_menu_parent->id)->orderBy('position','DESC')->first();
                        $front_page = FrontPage::select('id')->where('title', 'Partners')->first();

                        if (isset($header_menu_position)) {
                            $position = $header_menu_position->position + 1;
                        } else {
                            $position = 1;
                        }
                        $header_menu_store = new HeaderMenu;
                        $header_menu_store->type = 'Dynamic Page';
                        $header_menu_store->element_id = $front_page->id;
                        $header_menu_store->title = $user->name;
                        $header_menu_store->link = $link;
                        $header_menu_store->parent_id = $header_menu_parent->id;
                        $header_menu_store->position = $position;
                        $header_menu_store->status = $user->is_enabled_package;
                        $header_menu_store->save();
                    } else {
                        $header_menu->status = $user->is_enabled_package;
                        $header_menu->save();
                    }

                    $response['status'] = true;
                    $response['message'] = trans('common.Status has been changed');
                } else {
                    $response['status'] = false;
                    $response['message'] = trans('common.Something went wrong') . '!';
                }
            } else {
                $response['status'] = false;
                $response['message'] = trans('CP not found!');
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::error($errorMessage);

            $response['status'] = false;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function not_verified_partner()
    {
        try {
            $partners = [];
            return view('systemsetting::not_verified_partner', compact('partners'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function allow_using_course_api_partners()
    {
        try {
            $partners = [];
            return view('systemsetting::allow_using_course_api_partner', compact('partners'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function partner_list_excel_download(Request $request)
    {
        return Excel::download(new PartnerExport($request->partner_name, $request->email_address, $request->search_partner_status), 'partner-list.xlsx');
    }

    public function view_partner($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $countries = DB::table('countries')->whereActiveStatus(1)->get();
            if ($user->country != "" && $user->city != "") {
                $cities = DB::table('spn_cities')->where('country_id', $user->country)->where('id', $user->city)->select('id', 'name')->get();
            } else {
                $cities = DB::table('spn_cities')->where('country_id', 132)->where('id', 47953)->select('id', 'name')->get();
            }
            $partners = User::where('id', $id)->first();
            $html = view('systemsetting::view_partner', ['partners' => $partners,'countries' => $countries,'cities' => $cities])->render();
            return $html;

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function edit_partner($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $countries = DB::table('countries')->whereActiveStatus(1)->get();
            if ($user->country != "" && $user->city != "") {
                $cities = DB::table('spn_cities')->where('country_id', $user->country)->where('id', $user->city)->select('id', 'name')->get();
            } else {
                $cities = DB::table('spn_cities')->where('country_id', 132)->where('id', 47953)->select('id', 'name')->get();
            }
            $partners = User::where('id', $id)->first();
            $html = view('systemsetting::edit_partner', ['partners' => $partners,'countries' => $countries,'cities' => $cities, 'id' => $id])->render();
            return $html;

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function not_verified_partner_data(Request $request)
    {
        $with = [];
        $query = User::where('role_id', 8)->where('verified_by_admin', 0)->with($with);

        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })->addColumn('action', function ($query) {
                if ($query->message_sent_by_admin == 0) {
                    $approveButton = ' <button class="dropdown-item approve_instructor_btn" data-id="' . $query->id . '">Approve</button>';
                } else {
                    $approveButton = '';
                }
                $viewButton = ' <button class="dropdown-item view_partner_btn" data-id="' . $query->id . '">View</button>';
                $deleteButton = ' <button class="dropdown-item delete_partner_btn" data-id="' . $query->id . '">Reject</button>';

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                    ' . $viewButton    . '
                                    ' . $deleteButton  . '
                                    ' . $approveButton . '
                                </div>
                                </div>';
                return $actioinView;
            })->rawColumns(['action'])->make(true);
    }

    public function allow_using_course_api_partners_data()
    {
        $with = [];
        $query = User::where('role_id', 8)->where('is_allow_course_api_key', 1)->with($with);

        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })->addColumn('action', function ($query) {
                $viewButton = ' <button class="dropdown-item view_partner_btn" data-id="' . $query->id . '">View</button>';
                if (permissionCheck('instructor.course_api_key')) {

                    $instructor_course_api = '<button class="dropdown-item declinedInstructorCourseApi"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Refuse Course Api Key') . '</button>';
                } else {
                    $instructor_course_api = "";
                }
                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                    ' . $viewButton    . '
                                    ' . $instructor_course_api    . '
                                </div>
                                </div>';
                return $actioinView;
            })->rawColumns(['action'])->make(true);
    }

    public function verify_partner($id)
    {
        $user = User::find($id);
        if($user){
            $user->verified_by_admin = 1;
            $user->save();

            // Toastr::error('Partner Approved Successfully!!', 'Success');
            $response['success'] = 1;
            $response['message'] = "Partner Approved Successfully!!";
            return response()->json($response);
        }
        // Toastr::error('Partner Not Found!!', 'Failed');
        $response['success'] = 0;
        $response['message'] = "Partner Not Found!!";
        return response()->json($response);
    }

    public function delete_partner(Request $request)
    {
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::find($request->id);
        if ($user) {
            $user->update(['verified_by_admin' => 2]);

             Toastr::error('Partner Rejected Successfully!!', 'Success');
           return redirect()->back();
        }
        // Toastr::error('Partner Not Found!!', 'Failed');
        $response['success'] = 0;
        $response['message'] = "Partner Not Found!!";
        return response()->json($response);
    }

    public function impersonate(Request $request)
    {
        Auth::logout();
        Auth::loginUsingId($request->id);
        return redirect()->to('/');
    }

    public function send_mail_to_partner(Request $request)
    {
        // dd($request->all(), env('MAIL_FROM_ADDRESS'));
        try{
            $mail_val = [
                'user_id' => $request->id,
                'send_to_name' => $request->name,
                'send_to' => $request->email,
                'email_from' => env('MAIL_FROM_ADDRESS'),
                'email_from_name' => env('MAIL_FROM_NAME'),
                'instructions' => $request->instructions,
                'subject' => 'Instructions given by Admin',
            ];

            // Mail::send('partials.email_instructions_by_admin', ['body' => $request->instructions], function ($send) use ($mail_val) {
            //     $send->from($mail_val['email_from'], $mail_val['email_from_name']);
            //     $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
            //     $send->to($mail_val['send_to'])->subject($mail_val['subject']);
            // });

            send_email_to_instructor_by_admin($mail_val, 'admin_instructions', [
                            'instructions' => $mail_val['instructions']
                        ], 1);

            $user_data = User::find($request->id);
            if($user_data){
                $user_data->message_sent_by_admin = 1;
                $user_data->save();
            }

            $response['success'] = 1;
            $response['message'] = "Mail Sent successfully";
            return response()->json($response);
        }
        catch (\Exception $e) {
            // dd($e->getMessage());
            // Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            $response['success'] = 0;
            $response['message'] = $e->getMessage();
            // $response['message'] = trans('common.Operation failed');
            return response()->json($response);
        }
    }
}

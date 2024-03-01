<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Localization\Entities\Language;
use Modules\SystemSetting\Entities\Currency;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Newsletter\Http\Controllers\MailchimpController;
use Modules\Newsletter\Http\Controllers\GetResponseController;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function changePassword()
    {
        try {
            $user = User::where('id', Auth::id())->with('role')->first();
            $currencies = Currency::whereStatus('1')->get();
            $languages = Language::whereStatus('1')->get();
            $countries = DB::table('countries')->whereActiveStatus(1)->get();
            $cities = DB::table('spn_cities')->where('country_id', $user->country)->where('id', $user->city)->select('id', 'name')->get();
            return view('backend.changePassword', compact('cities', 'user', 'currencies', 'languages', 'countries'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => "required",
            'new_password' => "required|same:confirm_password|min:8|different:current_password",
            'confirm_password' => 'required|min:8'
        ]);

        try {
            if (demoCheck()) {
                return redirect()->back();
            }
            $user = Auth::user();
            if (Hash::check($request->current_password, $user->password)) {

                $user->password = Hash::make($request->new_password);
                $result = $user->save();

                if ($result) {
                    send_email($user, $type = 'PASS_UPDATE', $shortcodes = ['time' => now()->format(Settings('active_date_format') . ' H:i:s A')]);

                    Auth::logout();
                    session(['role_id' => '']);
                    Session::flush();
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();

                } else {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                    return redirect()->back();

                }
            } else {
                Toastr::error('Current password not match!', 'Failed');
                return redirect()->back();

            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update_user(Request $request)
    {
        if(check_whether_cp_or_not()){
            $request->validate([
                'name' => "required",
                'my_co_id' => "required",
                'checkbox' => "required",
                'checkbox1' => "required",
                'sst_registration_no' => 'required_if:sst_registered,1',
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1,' . Auth::id(),
            ],[
            'checkbox.required' => 'Please read and agree to the Terms & Conditions',
            'checkbox1.required' => 'Please read and agree to the Terms & Conditions',
            'sst_registration_no.required_if' => 'Please enter SST registratin number.',
            ]);
        }
        if (isPartner()) {
            $request->validate([
                'name' => "required",
                'checkbox' => "required",
                'checkbox1' => "required",
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1,' . Auth::id(),
                'city_text' => 'required'
            ],[
                'checkbox.required' => 'Please read and agree to the Terms & Conditions',
                'checkbox1.required' => 'Please read and agree to the Terms & Conditions',
                'city_text.required' => 'City is required'
            ]);
        }
        if(isAdmin()){
            $request->validate([
                'name' => "required",
                'email' => "required|unique:users,email," . Auth::id(),
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1,' . Auth::id(),
            ]);
        }
        if(!isAdmin() && !check_whether_cp_or_not() && !isPartner()){
            $request->validate([
                'name' => "required",
                // 'my_co_id' => "required",
                'checkbox' => "required",
                'email' => "required|unique:users,email," . Auth::id(),
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1,' . Auth::id(),
            ],[
            'checkbox.required' => 'Please read and agree to the Terms & Conditions',
            'required' => 'The :attribute field is required'
            ]);
        }

        try {
            $user = Auth::user();

            if($request->checkbox == 'on'){
                $user->agreed_to_terms = 1;
            }
            else{
                $user->agreed_to_terms = 0;
            }

            $user->name = $request->name;

            $user->phone = $request->phone;
            $user->city = $request->city;
            $user->zip = $request->zip;
            $user->currency_id = $request->currency;
            /*$user->language_id = $request->language;*/
            $user->country_code = $request->country_code;

            if(isInstructor()){
                $user->ic_no_for_trainer = $request->ic_no_for_trainer;
                $user->address = $request->address;
                $user->address2 = $request->address2;
                $user->city_text = $request->city_text;
                $user->company_profile_summary = $request->company_profile_summary;
            }
            if(check_whether_cp_or_not() || isPartner()){
                $user->brand_name = $request->brand_name;
                $user->my_co_id = $request->my_co_id;
                $user->address = $request->address;
                $user->address2 = $request->address2;
                $user->company_profile_summary = $request->company_profile_summary;
                $user->account_holder_name = $request->account_holder_name;
                $user->bank_account_number = $request->bank_account_number;
                $user->bank_name = $request->bank_name;
                $user->city_text = $request->city_text;
                $user->email = $request->email;
                if(isset($request->sst_registered) && $request->sst_registered == 1){
                    $user->sst_registration_no = $request->sst_registration_no;
                }
                else{
                    $user->sst_registration_no = null;
                }
                $user->company_banner_title = $request->company_banner_title;
                $user->company_banner_subtitle = $request->company_banner_subtitle;
                // dd($user);
            }
            else{
                $user->email = $request->email;
            }

            /*$language = Language::find($request->language);

            $user->language_code = $language->code;
            $user->language_name = $language->name;*/

            $user->country = $request->country;
            $user->website = $request->website;
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->instagram = $request->instagram;
            /*$user->short_details = $request->short_details;

            $user->subscription_method = $request->subscription_method;
            $user->subscription_api_key = $request->subscription_api_key;*/
            /*$sub_status = false;
            if ($request->subscription_method == "Mailchimp") {
                $mailchimp = new MailchimpController();
                $mailchimp->mailchimp($request->subscription_api_key);
                $sub_status = $mailchimp->connected;

            } elseif ($request->subscription_method == "GetResponse") {
                $getResponse = new GetResponseController();
                $getResponse->getResponseApi($request->subscription_api_key);
                $sub_status = $getResponse->connected;
            } elseif ($request->subscription_method == "Acelle") {

                $acelleController = new AcelleController();
                $acelle = $acelleController->getAcelleApiResponse();
                $sub_status = $acelleController->connected;

            }

            $user->subscription_api_status = $sub_status;*/

            if (!empty($request->about)) {
                $user->about = $request->about;
            }
            $fileName = "";
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/staff/', $fileName);
                $fileName = 'uploads/staff/' . $fileName;
                $user->image = $fileName;
            }
            $user->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            // return redirect()->route('dashboard');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function update_partner_user(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($user->role_id === 8 || $user->role->name === 'Partner') {
            $request->validate([
                'name' => "required",
                'checkbox' => "required",
                'checkbox1' => "required",
                'city_text' => 'required'
            ], [
                'checkbox.required' => 'Please read and agree to the Terms & Conditions',
                'checkbox1.required' => 'Please read and agree to the Terms & Conditions',
                'city_text.required' => 'City is required'
            ]);
        }
        try {
            if($request->checkbox == 'on'){
                $user->agreed_to_terms = 1;
            }
            else{
                $user->agreed_to_terms = 0;
            }

            $user->name = $request->name;

            $user->phone = $request->phone;
            if (isset($request->city)) {
                $user->city = $request->city;
            }
            $user->zip = $request->zip;
            /*$user->language_id = $request->language;*/
            $user->country_code = $request->country_code;

            if(isInstructor()){
                $user->ic_no_for_trainer = $request->ic_no_for_trainer;
                $user->address = $request->address;
                $user->address2 = $request->address2;
                $user->city_text = $request->city_text;
                $user->company_profile_summary = $request->company_profile_summary;
            }
            if($user->role_id === 8 || $user->role->name === 'Partner'){
                $user->brand_name = $request->brand_name;
                $user->my_co_id = $request->my_co_id;
                $user->address = $request->address;
                $user->address2 = $request->address2;
                $user->company_profile_summary = $request->company_profile_summary;
                $user->account_holder_name = $request->account_holder_name;
                $user->bank_account_number = $request->bank_account_number;
                $user->bank_name = $request->bank_name;
                $user->city_text = $request->city_text;
                $user->email = $request->email;
                if(isset($request->sst_registered) && $request->sst_registered == 1){
                    $user->sst_registration_no = $request->sst_registration_no;
                }
                else{
                    $user->sst_registration_no = null;
                }
            }
            if (isset($request->country)) {
                $user->country = $request->country;
            }

            if (!empty($request->about)) {
                $user->about = $request->about;
            }
            $fileName = "";
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/staff/', $fileName);
                $fileName = 'uploads/staff/' . $fileName;
                $user->image = $fileName;
            }
            $user->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            // return redirect()->route('dashboard');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function changeLanguage($language_code)
    {

        $language = Language::where('status', 1)->where('code', $language_code)->first();
        if ($language) {
            if (Auth::check()) {
                //set session & set user
                $user = Auth::user();
                $user->language_id = $language->id;
                $user->language_code = $language->code;
                $user->language_name = $language->name;
                $user->language_rtl = $language->rtl;
                $user->save();
            } else {
                Session::put('locale', $language->code);
                Session::put('language_name', $language->name);
                Session::put('language_rtl', $language->rtl);

            }
            App::setLocale($language->code);
            $success_msg = trans('setting.Successfully changed language');
            Toastr::success($success_msg, trans('common.Success'));
            return redirect()->back();
        } else {
            Toastr::error('Failed to change language', trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function cp_register()
    {
        return view('frontend.elatihlmstheme.auth.cp_register');
    }

    public function cp_get_ldap_data(Request $request)
    {
        $apiToken = \Config::get('app.ldap_api_token');
        $apiURL = \Config::get('app.ldap_api_url');
        $postInput = [
            'username' => $request->username,
            'password' => $request->password,
            'myco_id' => $request->my_co_id
        ];

        $headers = [
            'Authorization'=> 'Bearer '. $apiToken
        ];

        $response = Http::withHeaders($headers)->get($apiURL, $postInput);

        $statusCode = $response->status();

        // dd($statusCode, $response);
        if($statusCode == 200){
            $responseBody = json_decode($response->getBody(), true);

            return response()->json(['status'=>1, 'data'=>$responseBody]);
        }
        if($statusCode == 403){
            return response()->json(['status'=>0, 'message'=>'Unauthenticated.']);
        }
        if($statusCode == 404){
            return response()->json(['status'=>0, 'message'=>'Username not found, please contact admin.']);
        }
        if($statusCode == 401){
            return response()->json(['status'=>0, 'message'=>'Wrong password/username']);
        }
        if($statusCode == 500){
            return response()->json(['status'=>0, 'message'=>'Wrong password/username']);
        }
        return response()->json(['status'=>0, 'message'=>'Data not found']);
    }

    public function cp_find(Request $request)
    {
        try {
            $is_login = 0;
            $data = $request->data;
            $user = User::where('my_co_id', $data['myco_id'])->first();

            if ($user == null) //Register
            {
                $user = User::where('email', $data['EMAIL'])->first();
                if ($user == null) //Register
                {
                    $user = new User();
                    $user->role_id = 7;
                    $user->my_co_id  = $data['myco_id'];
                    $user->name = $data['TP_NAME'];
                    $user->address = $data['ADDRESS_LINE_1'].$data['ADDRESS_LINE_2'].$data['ADDRESS_LINE_3'];
                    $user->zip = $data['PINCODE'];
                    if ($data['state_name'] == "Penang") {
                        $user->city = 47961;
                    } else {
                        $user->city = $data['state_id'];
                    }

                    $user->city_text = $data['city_name'];
                    $user->country = 132;
                    $user->phone = $data['OFFICE_PHONE'];

                    if ($data['OFFICE_PHONE'] == "") {
                        $user->phone = $data['MOBILE'];
                    }

                    $user->email = $data['EMAIL'];
                    $user->username = $request->username;
                    $user->password = Hash::make($request->password);
                    $user->email_verified_at = now();
                    $user->save();
                } else { //login
                    if($user->agreed_to_terms == 1) {
                        $is_login = 1;
                    } else {
                        $user->role_id = 7;
                        $user->my_co_id  = $data['myco_id'];
                        $user->name = $data['TP_NAME'];

                        $user->address = $data['ADDRESS_LINE_1'].$data['ADDRESS_LINE_2'].$data['ADDRESS_LINE_3'];
                        $user->zip = $data['PINCODE'];
                        if($data['state_name'] == "Penang") {
                            $user->city = 47961;
                        } else if($data['state_name'] == "Selangor") {
                            $user->city = 47968;
                        }
                        else {
                            $user->city = 47953;
                        }

                        $user->city_text = $data['city_name'];
                        $user->country = 132;
                        $user->phone = $data['OFFICE_PHONE'];
                        if($data['OFFICE_PHONE'] == ""){
                            $user->phone = $data['MOBILE'];
                        }
                        $user->email = $data['EMAIL'];
                        $user->username = $request->username;

                        $user->password = Hash::make($request->password);
                        $user->email_verified_at = now();
                        $user->save();
                    }
                }

                return response()->json(['status' => 1, 'data' => $user, 'is_login' => $is_login]);
            }

            if ($user->count() > 0) //Login
            {
                if ($user->agreed_to_terms == 1) {
                    $is_login = 1;
                    $user->name = $data['TP_NAME'];
                    $user->password = Hash::make($request->password);

                    $user->address = $data['ADDRESS_LINE_1'].$data['ADDRESS_LINE_2'].$data['ADDRESS_LINE_3'];
                    $user->zip = $data['PINCODE'];
                    if($data['state_name'] == "Penang") {
                        $user->city = 47961;
                    } else if($data['state_name'] == "Selangor") {
                        $user->city = 47968;
                    }
                    else {
                        $user->city = 47953;
                    }

                    $user->city_text = $data['city_name'];
                    $user->country = 132;

                    $user->save();
                }

                if ($user->role_id != 7) {
                    $user->role_id = 7;
                    $user->my_co_id  = $data['myco_id'];
                    $user->name = $data['TP_NAME'];
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                return response()->json(['status' => 1, 'data' => $user, 'is_login' => $is_login]);
            }

            return response()->json(['status' => 0, 'message' => 'User not created']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }

        // $apiToken = \Config::get('app.ldap_api_token');
        // $apiURL = \Config::get('app.ldap_api_url');
        // $postInput = [
        //     'username' => $request->username,
        //     'password' => $request->password,
        //     'myco_id' => $request->my_co_id
        // ];

        // $headers = [
        //     'Authorization'=> 'Bearer '. $apiToken
        // ];

        // $response = Http::withHeaders($headers)->get($apiURL, $postInput);

        // $statusCode = $response->status();

        // if($statusCode == 200){
        //     $responseBody = json_decode($response->getBody(), true);

        //     $data = $responseBody[0];

        //     $user = User::where('my_co_id', $data['myco_id'])->first();
        //     if($user->count() == 0) //Register :- No record found
        //     {
        //         $apiURL = route('login');
        //         $postInput = [
        //             'email' => $data['EMAIL'],
        //             'password' => $request->password
        //         ];

        //         $headers = [
        //             'X-CSRF-TOKEN' => csrf_token()
        //         ];

        //         $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        //     }
        //     if($user->count() > 0) //Login :- Record found
        //     {
        //         $apiURL = route('login');
        //         $postInput = [
        //             'email' => $user->email,
        //             'password' => $request->password
        //         ];

        //         $headers = [
        //             'X-CSRF-TOKEN' => csrf_token(),
        //             'Accept' => 'Application/json'
        //         ];

        //         $response = Http::withHeaders($headers)->get($apiURL, $postInput);
        //     }
        // }
    }

    public function user_data_with_ajax_select2($role_id, Request $request)
    {
        $role_id = (int)$role_id;
        if ($request->ajax()) {

            $term = trim($request->term);
            //2 = Instructor
            $is_array = 0;
            $results = rolewise_user_data_with_select2_search_ajax($is_array, $role_id, $term, 10); //role_id, term, pagination

            return $results;
        }
    }

    public function partner_register()
    {
        return view(theme('auth.partner_register'));
    }
}

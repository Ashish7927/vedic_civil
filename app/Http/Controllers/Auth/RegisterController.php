<?php

namespace App\Http\Controllers\Auth;

use App\StudentCustomField;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Modules\FrontendManage\Entities\LoginPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Brian2694\Toastr\Facades\Toastr;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (env('nocaptcha_for_reg')) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[@$!%*#?&]/', 'confirmed'],
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $rules = [
                'dob' => 'required',
                'citizenship' => 'required',
                'gender' => 'required',
                'phone' => 'nullable|string|unique:users',
                'identification_number' => ['min:12', 'max:12'],
            ];
            if ($data['citizenship'] == 'Malaysian') {
                $rules['identification_number'] = 'required';
            }
        }

        return Validator::make($data, $rules,
            validationMessage($rules)
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        

        if (isset($data['type']) && $data['type'] == "Instructor") {
            $role = 2;
        } else {
            $role = 3;
        }

        if (empty($data['phone'])) {
            $data['phone'] = null;
        }
        return $this->userRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'role_id' => $role,
            'password' => Hash::make($data['password']),
            'language_id' => Settings('language_id') ?? '19',
            'language_name' => Settings('language_name') ?? 'English',
            'language_code' => Settings('language_code') ?? 'en',
            'language_rtl' => Settings('language_rtl') ?? '0',
            'country' => Settings('country_id'),
            'username' => null,
            'referral' => generateUniqueId(),
            'dob' => $data['dob'],
            'country_code' =>$data['country_code'],
            'gender' => $data['gender'],
            'citizenship' => $data['citizenship'],
            'nationality' => $data['nationality'],
            'race' => $data['race'],
            'race_other' => $data['race_other'],
            'employment_status' => $data['employment_status'],
            'job_designation' => $data['job_designation'],
            'sector' => $data['sector'],
            'business_nature' => $data['business_nature'],
            'business_nature_other' => $data['business_nature_other'],
            'not_working' => $data['not_working'],
            'highest_academic' => $data['highest_academic'],
            'current_residing' => $data['current_residing'],
            'sector_other' => $data['sector_other'],
            'zip'=> $data['zip'],
            'identification_number' => $data['identification_number']
        ]);
    }

    public function RegisterForm(Request $request)
    { 
        $register = $request->session()->get('register');

        abort_if(!Settings('student_reg'), 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        $countries = DB::table('countries')->whereActiveStatus(1)->get();  
        return view(theme('auth.register'), compact('page','custom_field','countries','register'));
    }
    public function RegisterFormStepOne(Request $request)
    {        
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*(_|[^\w])).+$/', 'confirmed'],
                'email_confirmation' => 'required|string|email|same:email|max:255',
                'checkbox' => 'required'
        ],[
         'name.required' => 'Please enter your full name',
         'email.required' => 'Please enter your Email Id',
         'email.unique' => 'Email Id already register',
         'email_confirmation.required' => 'Please enter your Confirm Email Id',
         'email_confirmation.same' => 'Email Id not matched',
         'password.required' => 'Please enter password',
         'password_confirmation.same' => 'Password not matched',
         'password.confirmed' => 'Password not matched',
         'password.regex' => 'Minimum 8 characters including 1 capital letters and 1 unique symbol',
         'password.string' => 'Please insert minimum 8 characters',
         'checkbox.required' => 'This checkbox is required',
         'max' => 'The :attribute field is may not be greater than :max characters.',
         'min' => 'The :attribute field is may not be less than :min characters.' 
        ]);
  
        if(empty($request->session()->get('register'))){
            $register=new User();
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }else{
            $register = $request->session()->get('register');
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }
  
        return redirect()->route('register-personal');
    }
    public function RegisterFormSecond(Request $request)
    { 
        $register = $request->session()->get('register');
        if($register==''){
            return redirect()->route('register');
        }
        abort_if(!Settings('student_reg'), 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        $countries = DB::table('countries')->whereActiveStatus(1)->get();  
        return view(theme('auth.registersecond'), compact('page','custom_field','countries', 'register'));
    }

    public function showRegistrationForm()
    {
        $page = LoginPage::getData();
        return view(theme('auth.register'), compact('page'));
    }

    public function register_partner(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*(_|[^\w])).+$/', 'confirmed'],
                'email_confirmation' => 'required|string|email|same:email|max:255',
        ],[
         'name.required' => 'Please enter your full name',
         'email.required' => 'Please enter your Email Id',
         'email.unique' => 'Email Id already register',
         'email_confirmation.required' => 'Please enter your Confirm Email Id',
         'email_confirmation.same' => 'Email Id not matched',
         'password.required' => 'Please enter password',
         'password_confirmation.same' => 'Password not matched',
         'password.confirmed' => 'Password not matched',
         'password.regex' => 'Minimum 8 characters including 1 capital letters and 1 unique symbol',
         'password.string' => 'Please insert minimum 8 characters',
         'checkbox.required' => 'This checkbox is required',
         'max' => 'The :attribute field is may not be greater than :max characters.',
         'min' => 'The :attribute field is may not be less than :min characters.' 
        ]);
        
        $user = User::where('email', $request->email)->first();

        if($user == null){
            $user = new User();
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = now();
        }else{
            Toastr::error('Email already exists!!', trans('common.Failed'));
            return redirect()->back();
        }
        $user->save();
  
        return redirect()->route('login');
    }
}

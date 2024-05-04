<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Models\ApiDevelopmentSetup;
use App\Models\CourseAccessToken;
use App\Models\CourseAuthenticationToken;
use App\Notifications\VerifyEmail;
use App\User;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @group  User management
 *
 * APIs for managing user
 */
class AuthController extends Controller
{
    use VerifiesEmails {
        VerifiesEmails::verify as parentVerify;
    }

    public function signup(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'wp_no' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = $validator->messages();
            } else {

                $fileName = "";
                if ($request->file('photo') != "") {
                    $file = $request->file('photo');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('profile/', $fileName);
                    $fileName = 'profile/' . $fileName;
                }
                $otp = rand(100000, 999999);

                $user =  User::create([
                    'name' => $request->name,
                    'father_name' => $request->father_name,
                    'wp_no' => $request->wp_no,
                    'where_did_you_know' => $request->where_did_you_know,
                    'photo' => $fileName,
                    'email' => $request->email,
                    'phone' => $request->phone ?? null,
                    'username' => $request->email,
                    'otp' => $otp,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'country' => $request->country,
                    'password' => bcrypt($request->password)
                ]);

                if (Settings('email_verification') != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                } else {
                    $user->sendEmailVerificationNotification();
                }

                $result = $user->save();
                if ($result) {
                    $response = [
                        'success' => true,
                        'message' => 'Successfully created user!',
                        'otp' => $otp,
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Something went wrong',
                    ];
                }
            }


            return response()->json($response, 200);
        } catch (\Exception $exception) {

            return $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    private function sendOtp($user_id)
    {
        $otp = rand(100000, 999999);
        $user = user::find($user_id);
        $user->otp = $otp;
        $user->save();
        return $otp;
    }
    /*{
         "email": "ashif@gmail.com",
         "password": "123456"
        }*/
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);

        try {
            if (!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
           $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $result = $token->save();

            $data = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'is_verify' => $user->email_verified_at,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ];

            if ($result) {
                $request->merge([
                    'api_token' => $token->id,
                ]);

                $check = $this->attemptUserCheck($request);
                if (!$check['type']) {
                    $response = [
                        'success' => false,
                        'message' => $check['message'],
                    ];
                } else {
                    $otp = $this->sendOtp($user->id);

                    $response = [
                        'success' => true,
                        'data' => $user,
                        'auth_data' =>$data,
                        'otp' => $otp,
                        'message' => 'Successfully login!',
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong',
                ];
            }

            return response()->json($response, 200);
        } catch (\Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_otp' => 'required',
            'email_otp' => 'required',
            'user_id' => 'required'
        ]);

        $user = user::find($request->user_id);
        if ($user && $user != null) {
            if ($user->otp == $request->phone_otp && $user->otp == $request->email_otp) {
                $response = [
                    'success' => true,
                    'message' => 'Successfully logged in',
                    'userDetails' => $user
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Invalid otp!'
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Invalid user id'
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            $response = [
                'success' => true,
                'message' => 'Successfully logged out',
            ];
            return response()->json($response, 200);
        } catch (\Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Get the authenticated User
     *
     * @response
     *  {
     * "success": true,
     * "data": [
     * {
     * "id": 6,
     * "role_id": 3,
     * "name": "Ashif",
     * "photo": "public/infixlms/img/admin.png",
     * "image": "public/infixlms/img/admin.png",
     * "avatar": "public/infixlms/img/admin.png",
     * "mobile_verified_at": null,
     * "email_verified_at": null,
     * "notification_preference": "mail",
     * "is_active": 1,
     * "username": "ashif@gmail.com",
     * "email": "ashif@gmail.com",
     * "email_verify": "0",
     * "phone": "01722334455",
     * "address": null,
     * "city": "1374",
     * "country": "19",
     * "zip": null,
     * "dob": null,
     * "about": null,
     * "facebook": null,
     * "twitter": null,
     * "linkedin": null,
     * "instagram": null,
     * "subscribe": 0,
     * "provider": null,
     * "provider_id": null,
     * "status": 1,
     * "balance": 0,
     * "currency_id": 112,
     * "special_commission": 1,
     * "payout": "Paypal",
     * "payout_icon": "/uploads/payout/pay_1.png",
     * "payout_email": "demo@paypal.com",
     * "referral": null,
     * "added_by": 0,
     * "created_at": "2020-11-16T12:09:40.000000Z",
     * "updated_at": "2020-11-16T12:09:40.000000Z"
     * } ,
     * "message": "Getting user info"
     * }
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        try {
            $data = user::find($request->user_id);
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Getting user info',
            ];

            return response()->json($response, 200);
        } catch (\Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    /**
     * Change Password
     *
     * @bodyParam old_password string required The current password of the User.
     * @bodyParam new_password string required The new password of the User.
     * @bodyParam confirm_password string required The confirm password of the User.
     * @response {
     * "success": true,
     * "message": "Password updated successfully."
     * }
     */
    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = $data = $request->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        if ($arr['status'] == 200) {
            $status = true;
        } else {
            $status = false;
        }
        $response = [
            'success' => $status,
            'message' => $arr['message'],
        ];
        return response()->json($response, $arr['status']);
    }

    public function setFcmToken(Request $request)
    {

        try {
            $user = User::find($request->id);
            $user->device_token = $request->token;
            $user->save();

            $response = [
                'success' => true,
                'message' => 'Successfully set fcm token',
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function setCoursesOauthToken(Request $request)
    {
        try {
            $input = $request->all();
            if (!isset($input['client_key']) || !isset($input['secret_key'])) {
                $response = [
                    'success' => false,
                    'message' => 'Please input your client key and your secret key',
                ];

                return response()->json($response, 403);
            }
            $userId = auth('api')->user()->id;
            $checkKey = CourseAccessToken::where('client_key', $input['client_key'])->where('secret_key', $input['secret_key'])->where('user_id', $userId)->first();
            if (!isset($checkKey->user_id)) {
                $response = [
                    'success' => false,
                    'message' => 'your client key or secret key is wrong!',
                ];

                return response()->json($response, 403);
            }
            $user = User::find($userId);
            $checkPermission = true;

            if ($user) {
                $token = \Str::random(64);
                $checkAuthentication = CourseAuthenticationToken::where('user_id', $user->id)->first();
                if (isset($checkAuthentication->user_id)) {
                    $checkAuthentication->api_token = $token;
                    $checkAuthentication->expiry_time = "3600";
                    $checkAuthentication->created_at = date("Y-m-d H:i:s");
                    $checkAuthentication->updated_at = date("Y-m-d H:i:s");
                    $checkAuthentication->save();
                } else {
                    $authenticationToken = new CourseAuthenticationToken();
                    $authenticationToken->user_id = $user->id;
                    $authenticationToken->api_token = $token;
                    $authenticationToken->expiry_time = "3600";
                    $authenticationToken->save();
                }


                $getAuthenticationToken = CourseAuthenticationToken::where('user_id', $userId)->first();


                $response = [
                    'success' => true,
                    'api_token' => $getAuthenticationToken->api_token,
                    'message' => 'Successfully authenticate course token',
                ];

                return response()->json($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Cannot find this user in this website!',
                ];

                return response()->json($response, 403);
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function attemptUserCheck($request)
    {
        $result['type'] = true;
        $result['message'] = '';

        if (Auth::user()->status == 0) {
            Auth::logout();

            $result['type'] = false;
            $result['message'] = 'Your account has been disabled !';
            return $result;
        }

        if (Auth::user()->role_id == 3) {

            //device  limit
            $user = Auth::user();
            $time = Settings('device_limit_time');
            $last_activity = $user->last_activity_at;
            if ($time != 0) {
                if (!empty($last_activity)) {
                    $valid_activity = Carbon::parse($last_activity)->addMinutes($time);
                    $current_time = Carbon::now();
                    if ($current_time->lt($valid_activity)) {
                    } else {
                        $login = UserLogin::where('user_id', Auth::id())->where('status', 1)->latest()->first();
                        if ($login) {
                            $login->status = 0;
                            $login->logout_at = Carbon::now(Settings('active_time_zone'));
                            $login->save();
                        }
                    }
                }
            }
            $user->last_activity_at = now();
            $user->save();

            $loginController = new LoginController();
            if (!$loginController->multipleLogin($request)) {
                $result['type'] = false;
                $result['message'] = 'Your Account is already logged in, into ' . Settings('device_limit') . ' devices';
                return $result;
            }
        }

        session(['role_id' => Auth::user()->role_id]);
        if (isModuleActive('Chat')) {
            userStatusChange(auth()->id(), 1);
        }


        return $result;
    }
}

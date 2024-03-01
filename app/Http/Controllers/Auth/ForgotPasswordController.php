<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Modules\FrontendManage\Entities\LoginPage;
use App\Notifications\BulkPasswordReset;
use Hash;
use DB; 
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use App\User;
use App\Models\PasswordReset;

use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use Notifiable,SendsPasswordResetEmails;


    public function showLinkRequestForm()
    {
        $page = LoginPage::getData();
        return view(theme('auth.passwords.email'), compact('page'));
    }

    public function SendPasswordResetLink()
    {
        $page = LoginPage::getData();
        return view(theme('auth.passwords.email'), compact('page'));
    }

    public function ResetPassword()
    {
        $page = LoginPage::getData();
        return view(theme('auth.passwords.reset'), compact('page'));
    }
    public function reset_bulk_send_cron(){
        $data = User::where('role_id','3')->whereNotIn('email',function($query) {
            $query->select('email')->from('password_resets');
        })->get();
        Notification::send($data, new BulkPasswordReset());
        return back();
    }
}

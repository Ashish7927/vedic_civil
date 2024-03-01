<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Hash;
use Illuminate\Support\Str;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;
use DB; 
use App\Models\PasswordReset;
use Carbon\Carbon; 

class BulkPasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        // The $notifiable is already a User instance so not really necessary to pass it here
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = Hash::make(str::random(64));
        DB::table('password_resets')->insert([
              'email' => $notifiable->email, 
              'token' => $token,
              'created_at' => Carbon::now()
            ]); 
       $tamplate = EmailTemplate::where('act', 'Reset_Password')->first();
        $subject = $tamplate->subj;
        $body = $tamplate->email_body;

        $key = ['http://{{reset_link}}', '{{reset_link}}', '{{app_name}}', '{{name}}', '{{email}}'];
        $value = [route('password.reset', $token), route('password.reset', $token), Settings('site_title'), $notifiable->name, $notifiable->email];
        $body = str_replace($key, $value, $body);

        $config = EmailSetting::where('active_status', 1)->first();
        if ($config && $config->id == 3) {
            $email = !empty($notifiable->email)?$notifiable->email:Auth::user()->email;
            $emailSendGrid = new \SendGrid\Mail\Mail();
            $emailSendGrid->setFrom($config->from_email, $config->from_name);
            $emailSendGrid->setSubject($subject);
            $emailSendGrid->addTo($email, $email);
            $emailSendGrid->addContent(
                "text/html", $body
            );
            $sendgrid = new \SendGrid($config->api_key);
            $response = $sendgrid->send($emailSendGrid);
        }
        return (new MailMessage)
            ->view('partials.email', ["body" => $body])->subject($subject);
            
        

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

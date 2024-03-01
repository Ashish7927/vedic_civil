<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class StudentNotificationPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql1 = [
            ['module_id' => 2, 'parent_id' => 31, 'name' => 'Send Notification', 'route' => 'student.notification', 'type' => 3, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql1);

        $template = EmailTemplate::where('act', 'student_notification')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'student_notification';
        }
        $shortCode = '{"name":"Name", "comment":"Comment"}';
        $subject = 'New Notification From Admin';
        $br = "<br/>";
        $body['name'] = "{{name}}";
        $body['comment'] = "{{comment}}";
        $body['footer'] = "{{footer}}";
        $body['logo'] = asset('logo2.png');
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = $this->htmlPart($subject, $body);
        $template->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('route', 'student.notification')->delete();

        EmailTemplate::where('act', 'student_notification')->delete();
    }

    public function htmlPart($subject, $body)
    {
        $html = '
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                     .social_links {
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }

                    .social_links a {
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .blue_div{
                        color: rgb(255, 255, 255);
                        font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;
                        text-align: center;
                        background-color: #212F64;
                        padding: 30px;
                        border-top-left-radius: 3px;
                        border-top-right-radius: 3px;
                        margin: 0px;
                    }
                    .h1_header{
                        color: rgb(255, 255, 255);
                        font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;
                        text-align: center;
                        background-color: #212F64;
                        padding: 30px;
                        border-top-left-radius: 3px;
                        border-top-right-radius: 3px;
                        margin: 0px;
                    }
                </style>
                <div class="">
                    <div class="blue_div">
                        <h1 class="h1_header">
                            <img src="' . $body['logo'] . '">
                        </h1>
                    </div>
                    <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                        <p style="color: rgb(85, 85, 85);"> Hello, ' . $body['name'] . ' <br></p>
                        <p style="color: rgb(85, 85, 85);"><br></p>
                        <p style="color: rgb(85, 85, 85);"> ' . $body['comment'] . ' </p>
                    </div>
                </div>

                <div class="email_invite_wrapper" style="text-align: center">
                    <div class="social_links">
                        e-LATiH All Rights Reserved.
                    </div>
                </div>';
        return $html;
    
    }
}

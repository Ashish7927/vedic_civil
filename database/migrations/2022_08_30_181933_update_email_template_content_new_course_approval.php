<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class UpdateEmailTemplateContentNewCourseApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = EmailTemplate::where('act', 'new_cource_approval')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'new_cource_approval';
        }
        $shortCode = '{"cp_name":"Content Provider/Partner Name", "course_published_date":"Course Published Date"}';
        $subject = 'Course Approval';
        $br = "<br/>";
        $body['cp_name'] = "{{cp_name}}";
        $body['course_published_date'] = "{{course_published_date}}";
        $body['footer'] = "{{footer}}";
        $body['url'] = url('/');
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = $this->htmlPart($subject, $body);
        $template->save();
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


                </style>

                <div class="">
                <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;"><img src="' . $body['url'] . '/public/logo2.png" style="position: relative;top: 20px;" />

                </h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                <p style="color: rgb(85, 85, 85);"><br></p></div>
                    <p style="color: rgb(85, 85, 85);">Dear <b>' . $body['cp_name'] . '</b>,</p>
                </div>
                <p style="color: rgb(85, 85, 85);"><br></p></div>
                    <p style="color: rgb(85, 85, 85);">Congratulations! Your course has been published on e-LATiH on ' . $body['course_published_date'] . ' .</p>
                </div>
                <p style="color: rgb(85, 85, 85);">We certainly look forward to more courses from you and we thank you for your great efforts and support in encouraging and cultivating lifelong learning culture among Malaysians with e-LATiH!</p></div>
                <p style="color: rgb(85, 85, 85);"><br></p></div>
                <p style="color: rgb(85, 85, 85);">Thanks, <br>e-LATiH Team</p></div>
                </div>

                <div class="email_invite_wrapper" style="text-align: center">
                    <div class="social_links">
                        e-LATiH All Rights Reserved.
                    </div>
                </div>

                ';
        return $html;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

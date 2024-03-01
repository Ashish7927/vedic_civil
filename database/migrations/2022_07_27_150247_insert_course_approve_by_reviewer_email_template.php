<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class InsertCourseApproveByReviewerEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = EmailTemplate::where('act', 'course_approve_by_reviewer')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'course_approve_by_reviewer';
        }
        $shortCode = '{"course":"Course Name"}';
        $subject = 'Course Approval by Reviewer';
        $br = "<br/>";
        $body['course'] = "{{course}}";
        $body['footer'] = "{{footer}}";
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
        //
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
                <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
                ' . $subject . '
                </h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                <p style="color: rgb(85, 85, 85);"><br></p>
                <p style="color: rgb(85, 85, 85);"> Course <b>' . $body['course'] . '</b> approved by Course Reviewer successfully.</p></div>
                </div>
                <div class="email_invite_wrapper" style="text-align: center">
                    <div class="social_links">
                        e-LATiH All Rights Reserved.
                    </div>
                </div>';
        return $html;
    }
}

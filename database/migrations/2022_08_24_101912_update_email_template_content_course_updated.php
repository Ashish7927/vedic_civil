<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailTemplateContentCourseUpdated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template1 = \Modules\SystemSetting\Entities\EmailTemplate::where('act', 'course_updated')->first();
        if (!$template1) {
            $template1 = new \Modules\SystemSetting\Entities\EmailTemplate();
            $template1->act = 'course_updated';
        }
        $shortCode1 = '{"cp_name":"Content Provider Name", "course":"Course Name", "course_duration":"Duration of Content", "course_submission_date":"Submitted Date", "course_link":"Course Link"}';
        $subject1 = 'Course Updated';
        $body['footer'] = "{{footer}}";
        $body['cp_name'] = "{{cp_name}}";
        $body['course'] = "{{course}}";
        $body['course_duration'] = "{{course_duration}}";
        $body['course_submission_date'] = "{{course_submission_date}}";
        $body['course_link'] = "{{course_link}}";
        $template1->name = $subject1;
        $template1->subj = $subject1;
        $template1->shortcodes = $shortCode1;
        $template1->status = 1;
        $body['url'] = url('/');
        $template1->email_body = $this->htmlPart1($subject1, $body);
        $template1->save();
    }

    public function htmlPart1($subject1, $body)
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
                <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;">
                    <h1 style="margin: 20px 0px 10px;margin-top: -14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
                    <img src="' . $body['url'] . '/public/logo2.png" style="position: relative;top: 20px;" /></h1>
                </div>
                <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                    <p style="color: rgb(85, 85, 85);"><br></p>
                    <p style="color: rgb(85, 85, 85);">The following course has been updated for review:</p>
                </div>
                    <p style="color: rgb(85, 85, 85);"> Content Provider Name : <b>' . $body['cp_name'] . '</b></p>
                </div>
                    <p style="color: rgb(85, 85, 85);"> Course Title : <b>' . $body['course'] . '</b></p>
                </div>
                    <p style="color: rgb(85, 85, 85);"> Duration of Content : <b>' . $body['course_duration'] . '</b> minutes</p>
                </div>
                    <p style="color: rgb(85, 85, 85);"> Course Submission Date : <b>' . $body['course_submission_date'] . '</b></p>
                </div>
                    <p style="color: rgb(85, 85, 85);"> Course : <a href="{{course_link}}">' . $body['course_link'] . '</a></p>
                </div>
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

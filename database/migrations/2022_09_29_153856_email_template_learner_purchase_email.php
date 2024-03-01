<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmailTemplateLearnerPurchaseEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = \Modules\SystemSetting\Entities\EmailTemplate::where('act', 'course_purchase')->first();
        if (!$template) {
            $template = new \Modules\SystemSetting\Entities\EmailTemplate();
            $template->act = 'course_purchase';
        }
        $shortCode = '{"name": "Name","course_title": "Course Title","price": "Price","purchased_date":"Purchased Date"}';
        $subject = 'New Course Purchased by Learner';
        $br = "<br/>";
        $body['name']           = "{{name}}";
        $body['course_title']   = "{{course_title}}";
        $body['price']          = "{{price}}";
        $body['purchased_date'] = "{{purchased_date}}";
        $body['footer'] = "{{footer}}";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;
        $body['url'] = url('/');
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
                <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;">
                    <h1 style="margin: 20px 0px 10px;margin-top: -14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
                    <img src="' . $body['url'] . '/public/logo2.png" style="position: relative;top: 20px;" /></h1>
                </div>
                <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                    <p style="color: rgb(85, 85, 85);"><br></p>
                    <p style="color: rgb(85, 85, 85);"><b>' . $body['name'] . '</b> has purchased new course. </p>
                </div>

                <p style="color: rgb(85, 85, 85);"> Course Title : <b>' . $body['course_title'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Price : <b>' . $body['price'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Purchased Date : <b>' . $body['purchased_date'] . '</b></p>
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

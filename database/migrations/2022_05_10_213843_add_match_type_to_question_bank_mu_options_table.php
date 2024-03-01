<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddMatchTypeToQuestionBankMuOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_bank_mu_options', function (Blueprint $table) {
            $table->tinyInteger("match_type")->default(0)->comment('1 = question, 2 = answer')->after('active_status');
            $table->integer("match_ans_id")->nullable()->after('match_type');
        });

        $template = EmailTemplate::where('act', 'course_feedback')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'course_feedback';
        }
        $shortCode = '{"course":"Course Name","comment":"Comment"}';
        $subject = 'Course Feedback';
        $br = "<br/>";
        $body['course'] = "{{course}}";
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
        Schema::table('question_bank_mu_options', function (Blueprint $table) {
            $table->dropColumn(['match_type', 'match_ans_id']);
        });

        EmailTemplate::where('act', 'course_feedback')->delete();
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
                        <p style="color: rgb(85, 85, 85);"><br></p>
                        <p style="color: rgb(85, 85, 85);"> Course :  <b>' . $body['course'] . '</b> </p>
                        <p style="color: rgb(85, 85, 85);"><br></p>
                        <p style="color: rgb(85, 85, 85);"> Feedback : </p>
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

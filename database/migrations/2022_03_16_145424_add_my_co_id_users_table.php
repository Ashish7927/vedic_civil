<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddMyCoIdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('my_co_id')->nullable();
            $table->string('ic_no_for_trainer')->nullable();
            $table->string('ttt_certificate')->nullable();
            $table->string('ttt_exemption')->nullable();
            $table->tinyInteger('verified_by_admin')->default(0)->comment('1=yes, 0=no');
            $table->tinyInteger('message_sent_by_admin')->default(0)->comment('1=yes, 0=no');
        });

        $template = EmailTemplate::where('act', 'admin_instructions')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'admin_instructions';
        }

        $shortCode = '';
        $subject = 'Instructions given by Admin';
        $br = "<br/>";
        $body = "{{instructions}} ";
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['my_co_id','ic_no_for_trainer','ttt_certificate','ttt_exemption','verified_by_admin']);
        });
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

            </h1></div>
            <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
            <p style="color: rgb(85, 85, 85);"><br></p>
            <p style="color: rgb(85, 85, 85);">' . $body . '</p></div>
            </div>

            <div class="email_invite_wrapper" style="text-align: center">


                <div class="social_links">
                    e-LATih All Rights Reserved.
                </div>
            </div>

            ';
        return $html;
    }
}

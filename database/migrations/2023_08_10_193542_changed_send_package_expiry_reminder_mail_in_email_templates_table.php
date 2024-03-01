<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class ChangedSendPackageExpiryReminderMailInEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = EmailTemplate::where('act', 'send_package_expiry_reminder_mail')->first();

        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'send_package_expiry_reminder_mail';
        }

        $shortCode = '{"name": "Name", "package_name": "Package Name", "expiry_date": "Expiry Date"}';
        $subject = 'Package Expiry Reminder';
        $br = "<br/>";
        $body['name'] = "{{name}}";
        $body['package_name'] = "{{package_name}}";
        $body['expiry_date'] = "{{expiry_date}}";
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
        $template = EmailTemplate::where('act', 'send_package_expiry_reminder_mail')->first();

        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'send_package_expiry_reminder_mail';
        }

        $shortCode = '{"name": "Name", "package_name": "Package Name", "expiry_date": "Expiry Date"}';
        $subject = 'Package Expiry Reminder';
        $br = "<br/>";
        $body['name'] = "{{name}}";
        $body['package_name'] = "{{package_name}}";
        $body['expiry_date'] = "{{expiry_date}}";
        $body['footer'] = "{{footer}}";
        $body['logo'] = asset('logo2.png');
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = $this->htmlPartOld($subject, $body);
        $template->save();
    }

    public function htmlPart($subject, $body)
    {
        $html = '
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
            <div class="">
                <div style="color: rgb(255, 255, 255);font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;text-align: center;background-color: #212F64;padding: 30px;border-top-left-radius: 3px;border-top-right-radius: 3px;margin: 0px;">
                    <h1 style="color: rgb(255, 255, 255);font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;text-align: center;background-color: #212F64;padding: 30px;border-top-left-radius: 3px;border-top-right-radius: 3px;margin: 0px;">
                        <img src="' . $body['logo'] . '">
                    </h1>
                </div>
                <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                    <p style="color: rgb(85, 85, 85);"> Hi, ' . $body['name'] . ' <br></p>
                    <p style="color: rgb(85, 85, 85);">Your Package Expired in 7 Days.<br></p>
                    <p style="color: rgb(85, 85, 85);">Package Name: '. $body['package_name'].'<br></p>
                    <p style="color: rgb(85, 85, 85);">Expiry Date: '. $body['expiry_date'].'<br></p>
                    <p style="color: rgb(85, 85, 85);">Thanks, <br></p>
                    <p style="color: rgb(85, 85, 85);">e-LATiH<br></p>
                </div>
            </div>

            <div class="email_invite_wrapper" style="text-align: center">
                <div class="social_links" style="background: #F4F4F8;padding: 15px;margin: 30px 0 30px 0;">
                    e-LATiH All Rights Reserved.
                </div>
            </div>';

        return $html;
    }

    public function htmlPartOld($subject, $body)
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
                    <p style="color: rgb(85, 85, 85);"> Hi, ' . $body['name'] . ' <br></p>
                    <p style="color: rgb(85, 85, 85);">Your Package Expired in 7 Days.<br></p>
                    <p style="color: rgb(85, 85, 85);">Package Name: '. $body['package_name'].'<br></p>
                    <p style="color: rgb(85, 85, 85);">Expiry Date: '. $body['expiry_date'].'<br></p>
                    <p style="color: rgb(85, 85, 85);">Thanks, <br></p>
                    <p style="color: rgb(85, 85, 85);">e-LATiH<br></p>
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailTemplateContentNewPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add_new_payout
        $template = \Modules\SystemSetting\Entities\EmailTemplate::where('act', 'add_new_payout')->first();
        if (!$template) {
            $template = new \Modules\SystemSetting\Entities\EmailTemplate();
            $template->act = 'add_new_payout';
        }
        $shortCode = '{"instructor_name": "Instructor Name","amount": "Amount","issue_date": "Issue Date","Billing Cycle": "billing_cycle"}';
        $subject = 'New Payment Created';
        $br = "<br/>";
        $body['instructor_name'] = "{{instructor_name}}";
        $body['amount']          = "{{amount}}";
        $body['issue_date']      = "{{issue_date}}";
        $body['billing_cycle']   = "{{billing_cycle}}";
        $body['footer'] = "{{footer}}";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;
        $body['url'] = url('/');
        $template->email_body = $this->htmlPart($subject, $body);
        $template->save();

        // new_payment_for_cp
        $template1 = \Modules\SystemSetting\Entities\EmailTemplate::where('act', 'new_payment_for_cp')->first();
        if (!$template1) {
            $template1 = new \Modules\SystemSetting\Entities\EmailTemplate();
            $template1->act = 'new_payment_for_cp';
        }
        $shortCode1 = '{"trainer_name": "Trainer Name","amount": "Amount","issue_date": "Issue Date","Billing Cycle": "billing_cycle"}';
        $subject1 = 'New Payment for CP Created';
        $br = "<br/>";
        $body['trainer_name']    = "{{trainer_name}}";
        $body['amount']          = "{{amount}}";
        $body['issue_date']      = "{{issue_date}}";
        $body['billing_cycle']   = "{{billing_cycle}}";
        $body['footer'] = "{{footer}}";
        $template1->name = $subject1;
        $template1->subj = $subject1;
        $template1->shortcodes = $shortCode1;
        $template1->status = 1;
        $body['url'] = url('/');
        $template1->email_body = $this->htmlPart1($subject1, $body);
        $template1->save();

        // new_payment_for_myll
        $template2 = \Modules\SystemSetting\Entities\EmailTemplate::where('act', 'new_payment_for_myll')->first();
        if (!$template2) {
            $template2 = new \Modules\SystemSetting\Entities\EmailTemplate();
            $template2->act = 'new_payment_for_myll';
        }
        $shortCode2 = '{"name": "Name","amount": "Amount","issue_date": "Issue Date","Billing Cycle": "billing_cycle"}';
        $subject2 = 'New Payment for MyLL Created';
        $br = "<br/>";
        $body['name']           = "{{name}}";
        $body['amount']         = "{{amount}}";
        $body['issue_date']     = "{{issue_date}}";
        $body['billing_cycle']   = "{{billing_cycle}}";
        $body['footer'] = "{{footer}}";
        $template2->name = $subject2;
        $template2->subj = $subject2;
        $template2->shortcodes = $shortCode2;
        $template2->status = 1;
        $body['url'] = url('/');
        $template2->email_body = $this->htmlPart2($subject2, $body);
        $template2->save();
    }

    // add_new_payout email_body
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
                    <p style="color: rgb(85, 85, 85);">A new Payment has successfully created</p>
                </div>

                <p style="color: rgb(85, 85, 85);"> Name : <b>' . $body['instructor_name'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Billing Cycle : <b>' . $body['billing_cycle'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Payment Date : <b>' . $body['issue_date'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Total Amount : <b>' . $body['amount'] . '</b></p>
                
            </div>

            <div class="email_invite_wrapper" style="text-align: center">
                <div class="social_links">
                    e-LATiH All Rights Reserved.
                </div>
            </div>
        ';

        return $html;
    }

    // new_payment_for_cp email_body
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
                    <p style="color: rgb(85, 85, 85);">A new CP Payment has successfully created</p>
                </div>

                <p style="color: rgb(85, 85, 85);"> Name : <b>' . $body['trainer_name'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Billing Cycle : <b>' . $body['billing_cycle'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Payment Date : <b>' . $body['issue_date'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Total Amount : <b>' . $body['amount'] . '</b></p>
            </div>

            <div class="email_invite_wrapper" style="text-align: center">
                <div class="social_links">
                    e-LATiH All Rights Reserved.
                </div>
            </div>
        ';

        return $html;
    }

    // new_payment_for_myll email_body
    public function htmlPart2($subject2, $body)
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
                    <p style="color: rgb(85, 85, 85);">A new MyLL Payment has successfully created</p>
                </div>

                <p style="color: rgb(85, 85, 85);"> Name : <b>' . $body['name'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Billing Cycle : <b>' . $body['billing_cycle'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Payment Date : <b>' . $body['issue_date'] . '</b></p>
                <p style="color: rgb(85, 85, 85);"> Total Amount : <b>' . $body['amount'] . '</b></p>
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddContentProvideReceipt extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = EmailTemplate::where('act', 'content_provider_receipt')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'content_provider_receipt';
        }
        /*$shortCode = '{"date":"Date","company": "Company","pay_method":"Pay Method","status":"Status","phone": "Phone","payment_period":"Payment Period","email": "Email","address": "Address","bill_to_name":"Bill To Name","bill_to_phone":"Bill To Phone","cource_details":"cource_details","bill_to_email":"Bill To Email","bill_to_address":"Bill To Address","cource_title":"Cource Title","quantity":"Quantity","unit_price":"Unit Price","unit_amount":"Unit Amount","total":"Total","deduction":"Deduction(if applicable)","net_total_pay_out":"Net Total Pay Out","balance_due":"Balance Due","remarks":"Remarks"}';*/

        $shortCode = '{"date":"Date","pay_method":"Pay Method","status":"Status","payment_period":"Payment Period","bill_to_name":"Bill To Name","bill_to_phone":"Bill To Phone","cource_details":"cource_details","bill_to_email":"Bill To Email","bill_to_address":"Bill To Address"}';
        $subject = 'Content Provider';
        $br = "<br/>";
        $body['date'] = "Date: {{date}}";
        $body['company'] = "Company: MyLiveLearning Sdn Bhd";
        $body['pay_method'] = "Pay Method: {{pay_method}}";
        $body['status'] = "Status: {{status}}";
        $body['phone'] = "Phone: ";
        $body['payment_period'] = "Payment Period: {{payment_period}}";
        $body['email'] = "Email: management@mylivelearing.space";
        $body['address'] = "Address:  H-20-01, Block H, Empire City, No.8, Jalan Damansara PJU 8, <br>Damansara Perdana, 47820 Petaling Jaya, Selangor, Malaysia";
        $body['bill_to_name'] = "Name: {{bill_to_name}}";
        $body['bill_to_phone'] = "Phone: {{bill_to_phone}}";
        $body['bill_to_email'] = "Email: {{bill_to_email}}";
        $body['bill_to_address'] = "Address: {{bill_to_address}}";
        $body['cource_details'] = "{{cource_details}}";
        /*$body['cource_title'] = "{{cource_title}}";
        $body['quantity'] = "{{quantity}}";
        $body['unit_price'] = "{{unit_price}}";
        $body['unit_amount'] = "{{unit_amount}}";
        $body['total'] = "{{total}}";
        $body['deduction'] = "{{deduction}}";
        $body['net_total_pay_out'] = "{{net_total_pay_out}}";
        $body['balance_due'] = "{{balance_due}}";*/
        // $body['remarks'] = "Remarks: {{remarks}}";
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
        EmailTemplate::where('act', 'content_provider_receipt')->delete();
    }

    public function htmlPart($subject, $body)
    {
        $html = '
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <style>
            table td{
                    font-size: 13px!important;
            }
            table th{
                    font-size: 14px!important;
            }
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
            .no_border_class{
                border-left:none;
                border-top:none;
                border-right:none;
                border-bottom:none;
            }
            .border_class{
                border:1px solid;
            }
            .custome-td-padding1 tr td{
               padding: 7px 15px !important;
            }
            .remove-border-bottom{
                border-bottom:unset !important;
            }
            .border_class-left{
                border-left: unset;
                border-right: unset !important;
            }
            .apply-width{
                width:100%;
                min-width:299px;
            }
            .remove-border-top-left-right{
                border-left: unset;
                border-right: unset;
                border-top: unset;
            }
            .margin_bottom{
                margin-bottom: 15px
            }
        </style>

        <div class="">
            <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
            ' . $subject . '

            </h1></div>
            <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;"></table>
                <table width="100%">
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['date'] . '</p></td>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['company'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['pay_method'] . '</p></td>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['email'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['status'] . '</p></td>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['address'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['payment_period'] . '</p></td>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">&nbsp;</p></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);"><b>Billed To,</b></p></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_name'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_phone'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_email'] . '</p></td>
                    </tr>
                    <tr>
                        <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_address'] . '</p></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                </table>
                ' . $body['cource_details'] . '
                <div style="padding-top:10px;">
                    <p style="font-size: 13px"><b>Remarks:</b> This is computer generated receipt and no signature is required.By using the HRD Corp e-LATiH platform, you expressly agree and accept that all transactions are strictly between you and MyLL, of which PSMB is not a party to the transactions.</p>
                </div>
            </div>
        </div>

        <div class="email_invite_wrapper" style="text-align: center">


            <div class="social_links">
                <a href="https://twitter.com/codetheme"> <i class="fab fa-facebook-f"></i> </a>
                <a href="https://codecanyon.net/user/codethemes/portfolio"><i class="fas fa-code"></i> </a>
                <a href="https://twitter.com/codetheme" target="_blank"> <i class="fab fa-twitter"></i> </a>
                <a href="https://dribbble.com/codethemes"> <i class="fab fa-dribbble"></i></a>
            </div>
        </div>

';
        return $html;
    }
}

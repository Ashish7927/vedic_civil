<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class ChangeEmailBodyForContentProviderReceiptInEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $template = EmailTemplate::where('act', 'content_provider_receipt')->first();
        $shortCode = '{"date":"Date","bill_to_name":"Bill To Name","transaction_id":"Transaction Id","cource_details":"Cource Details"}';
        $subject = 'Content Provider';
        $body['date'] = "Date: {{date}}";
        $body['bill_to_name'] = "Name: {{bill_to_name}}";
        $body['transaction_id'] = "Transaction ID: {{transaction_id}}";
        $body['cource_details'] = "{{cource_details}}";
        $template->email_body = $this->htmlPart($subject, $body);
        $template->shortcodes = $shortCode;
        $template->save();

    }
    
    public function htmlPart($subject, $body)
    {
        $html = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <style>
            .social_links {
                padding: 15px;
            }
    
            .social_links a {
                display: inline-block;
                font-size: 15px;
                color: #252B33;
                padding: 5px;
            }
    
            .no_border_class {
                border-left: none;
                border-top: none;
                border-right: none;
                border-bottom: none;
            }
    
            .border_class {
                border: 1px solid;
            }
    
            .custome-td-padding1 tr td {
                padding: 7px 15px !important;
            }
    
            .remove-border-bottom {
                border-bottom: unset !important;
            }
    
            .border_class-left {
                border-left: unset;
                border-right: unset !important;
            }
    
            .apply-width {
                width: 100%;
                min-width: 299px;
            }
        </style>
        <div class="">
            <div style="padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;">
                <div>
                    <div style="float: left;">
                        <img src="https://elatihdev.hrdcorp.gov.my/public/uploads/editor-image/HRDCorpLogo-01-p619t8tdt51ghw3vbeulbvu7i3z9blja41poix5khs.png1643334555.png"
                            style="width: 100%; height: auto;">
                    </div>
                    <div style="float: right;">
                        <p style="margin: 0;"><b>PEMBANGUNAN SUMBER MANUSIA BERHAD (545143-D)</b></p>
                        <p style="margin: 0;">Wisma HRD Corp, Jalan Beringin,</p>
                        <p style="margin: 0;">Damansara Heights,</p>
                        <p style="margin: 0;">50490 Kuala Lumpur, Malaysia.</p>
                        <p style="margin: 0;">Tel : +603 2096 4800</p>
                        <p style="margin: 0;">Fax : +603 2096 4907/4848</p>
                        <p style="margin: 0;">Website : www.hrdcorp.gov.my</p>
                        <p style="margin: 0;">SST Registration No.: W10-1906-32000027</p>
                    </div>
    <div style="clear: both;"></div>
                </div>
            </div>
            <hr>
            <div
                style="color: rgb(0, 0, 0); font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; padding: 20px;">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td class="remove-border-bottom" style="width: 50%;">
                                <p style="margin: 0; color: rgb(85, 85, 85);">Billed To:</p>
                            </td>
                            <td class="remove-border-bottom" style="width: 50%;">
                                <p style="margin: 0; color: rgb(85, 85, 85);">' . $body['date'] . '</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="remove-border-bottom" style="width: 50%;">
                                <p style="margin: 0; color: rgb(85, 85, 85);">' . $body['bill_to_name'] . '</p>
                            </td>
                            <td class="remove-border-bottom" style="width: 50%;">
                                <p style="margin: 0; color: rgb(85, 85, 85);">' . $body['transaction_id'] . '</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <p>Course Information:</p>
                </div>
                ' . $body['cource_details'] . '
            </div>
            <hr>
            <div style="position: relative;">
                <div>
                    <img style="width: 150px; margin-left: 15px;"
                        src="https://elatihdev.hrdcorp.gov.my/public/uploads/images/23-01-2022/61eca4d64f9d4.png">
                </div>
                <div style="position: absolute; left: 50%; transform: translateX(-50%); top: 13px;">
                    <p style="margin: 0px; color: lightgray;">This is computer generated receipt and no signature is
                        required.
                    </p>
                </div>
            </div>
            <div style="padding-top:10px;">
                <p><b>Remarks:</b> This is computer generated receipt and no signature is required.By using the HRD Corp
                    e-LATiH platform, you expressly agree and accept that all transactions are strictly between you and
                    MyLL, of which PSMB is not a party to the transactions.</p>
            </div>
        </div>
        <div class="email_invite_wrapper" style="text-align: center">
            <div class="social_links">e-LATiH All Rights Reserved.<br></div>
        </div>';

        return $html;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $template = EmailTemplate::where('act', 'content_provider_receipt')->first();
        $shortCode = '{"date":"Date","pay_method":"Pay Method","status":"Status","payment_period":"Payment Period","bill_to_name":"Bill To Name","bill_to_address":"Bill To Address","cource_details":"Cource Details"}';
        $subject = 'Content Provider';
        $body['date'] = "Date: {{date}}";
        $body['pay_method'] = "Pay Method: {{pay_method}}";
        $body['status'] = "Status: {{status}}";
        $body['payment_period'] = "Payment Period: {{payment_period}}";
        $body['bill_to_name'] = "Name: {{bill_to_name}}";
        $body['bill_to_address'] = "Address: {{bill_to_address}}";
        $body['cource_details'] = "{{cource_details}}";
        $template->email_body = $this->htmlPartOld($subject, $body);
        $template->shortcodes = $shortCode;
        $template->save();
    }

    public function htmlPartOld($subject, $body)
    {
        $html = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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
        
                </style>
        
                <div class="">
                    <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(255, 255, 255); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
                    <img src="https://elatihdev.hrdcorp.gov.my/public/myll_logo-2.png" style="width: 273.75px; height: 111.75px;">
        
                    </h1></div>
                    <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
                        <table width="100%">
                            <tbody><tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">'.$body['date'].'</p></td>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">Company: My Live Learning Sdn Bhd</p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['pay_method'] . '</p></td>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">Phone:&nbsp;</p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['status'] . '</p></td>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">Email: management@mylivelearning.space</p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['payment_period'] . '</p></td>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">Address: H-20-01, Block H, Empire City, No. 8, Jalan Damansara PJU 8, Damansara Perdana, 47820 Petaling Jaya, Selangor.</p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">&nbsp;</p></td>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);"></p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);"><b>Billed To,</b></p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_name'] . '</p></td>
                            </tr>
                            <tr>
                                <td class="remove-border-bottom"><p style="color: rgb(85, 85, 85);">' . $body['bill_to_address'] . '</p></td>
                            </tr>
                        </tbody></table>
                        ' . $body['cource_details'] . '
                        <div style="padding-top:10px;">
                            <p><b>Remarks:</b> This is computer generated receipt and no signature is required.By using the HRD Corp e-LATiH platform, you expressly agree and accept that all transactions are strictly between you and MyLL, of which PSMB is not a party to the transactions.</p>
                        </div>
                    </div>
                </div>
        
                <div class="email_invite_wrapper" style="text-align: center">
                    <div class="social_links">e-LATiH All Rights Reserved.<br></div>
                </div>';
    }
}

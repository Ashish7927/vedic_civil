<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRefundPolicyPageStyle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $check = \Modules\FrontendManage\Entities\FrontPage::where('slug', 'refund-policy')->first();
        if (!$check) {
            DB::table('front_pages')->insert([
                'name' => 'Refund Policy',
                'title' => 'Refund Policy',
                'sub_title' => '',
                'details' => '<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>file_1653997152718</title>
    <meta name="author" content="MOHAMAD FAHMI BIN MOHAMED NASSER"/>
    <style type="text/css"> * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }

    h1 {
        color: black;
        font-family: Calibri, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: underline;
        font-size: 18pt;
    }

    p {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
        margin: 0pt;
    }

    h2 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
    }

    .s1 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
    }

    .s2 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
    }

    .s3 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 10pt;
    }

    li {
        display: block;
    }

    #l1 {
        padding-left: 0pt;
    }

    #l1 > li > *:first-child:before {
        content: ". ";
        color: black;
        font-family: Symbol, serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
    }
    </style>
</head>
<body><h1 style="padding-left: 102pt;text-indent: 0pt;text-align: center;">e-LATiH Premium Refund Policy</h1>
<p style="padding-top: 9pt;padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">For details on our
    refund deadlines and policies, please refer to the information below. Learners have the responsibility to activate
    the purchased courses and request for a refund (in the event of any technical issue that arises in the course)
    within 48 hours from the date and time of purchase. However, the course becomes non-refundable if the refund
    requests are raised after 48 hours of the course activation.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Please also note that we treat
    violations of our Terms of Use very seriously, and we have no obligation to offer refunds to learners who violate
    these or other e-LATiH policies, even if their requests are made within the designated refund period.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">You may request a refund where:</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Course technical issues cannot be
    fixed by the content provider or vendor. We may require further information from you; hence, the 7 working days
    period will start from the day PSMB sends you an acknowledgment email that your investigation has started. Content
    providers or vendors are responsible for ensuring that any technical issue that arises in the course is fixed within
    7 working days from the acknowledgment date of the learner’s complaint.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Your refund request may be denied where:</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<ul id="l1">
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 109%;text-align: justify;">
        Multiple refunds (more than 1 time) were requested by a learner for the same course.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">
        Excessive refunds (more than 5 times) were requested by a learner for the different course.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">
        Learner who requests for their account deleted/deactivated or have their account banned or course access
        disabled due to a violation of our Terms and Condition.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">We
        have no obligation to offer refunds to users who do not pass the assessment in the courses, or who are otherwise
        unsatisfied with their final assessment marks.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;text-align: justify;">The course was not
        activated within 48 hours from the date of purchase.</p></li>
</ul>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Please note that to avoid any
    confusion, any refund request is within the sole discretion of PSMB and may be declined if the above conditions are
    not met.</p>
<h2 style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Availability of Premium Courses on
    learner account</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Premium courses that were
    subscribed will generally remain available for as long as you keep your e-LATiH account activated. On rare
    occasions, we may need to remove certain courses for legal or other reasons. We reserve the right to update courses
    without offering a refund or exchange.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Procedure to request for refund and check refund
    status</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;"><a
        href="mailto:elatih@hrdcorp.gov.my" class="s2" target="_blank">All refund requests and refund status must be
    made by email to </a><span
        style=" color: #0462C1; font-family:Verdana, sans-serif; font-style: normal; font-weight: normal; text-decoration: underline; font-size: 12pt;">elatih@hrdcorp.gov.my</span>.
    Please provide your email address, phone number, order ID, and justification to request for refund.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Refund process</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">All refunds will be processed
    within 30 days from the date of the acknowledgment of the refund request by PSMB via email. However, PSMB reserves
    the right to extend the period by more than 30 days to allow a thorough investigation. All refund requests will be
    reviewed by PSMB on a case-to-case basis and will determine whether the learner’s request is successful at our sole
    discretion.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Refund payment</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">The refund amount will be credited
    back to the learners’ account within 14 days of the successful refund application.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">For payment made using Credit Card,
    the refund will be made to the same Credit Card that the learner used to purchase. However, the number of days for
    the refund process varies accordingly to the respective bank processing time. Learners may contact the relevant bank
    for more information.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Others</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">From time to time, the refund policy may be revised
    without prior notice and reason by PSMB. The revised version will be made available on e-LATiH.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: left;"><a href="mailto:elatih@hrdcorp.gov.my" class="s2"
                                                                   target="_blank">For further information, kindly
    email </a><a href="mailto:elatih@hrdcorp.gov.my" class="s1" target="_blank">elatih@hrdcorp.gov.my</a><a
        href="mailto:elatih@hrdcorp.gov.my" class="s2" target="_blank">.</a></p>
<p style="text-indent: 0pt;text-align: left;"><br/></p></body>
</html>
',
                'slug' => 'refund-policy',
                'status' => 1,
                'is_static' => 1,
            ]);
        } else {
            $check->update(["details" => '<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>file_1653997152718</title>
    <meta name="author" content="MOHAMAD FAHMI BIN MOHAMED NASSER"/>
    <style type="text/css"> * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }

    h1 {
        color: black;
        font-family: Calibri, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: underline;
        font-size: 18pt;
    }

    p {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
        margin: 0pt;
    }

    h2 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
    }

    .s1 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
    }

    .s2 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
    }

    .s3 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 10pt;
    }

    li {
        display: block;
    }

    #l1 {
        padding-left: 0pt;
    }

    #l1 > li > *:first-child:before {
        content: ". ";
        color: black;
        font-family: Symbol, serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 12pt;
    }
    </style>
</head>
<body><h1 style="padding-left: 102pt;text-indent: 0pt;text-align: center;">e-LATiH Premium Refund Policy</h1>
<p style="padding-top: 9pt;padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">For details on our
    refund deadlines and policies, please refer to the information below. Learners have the responsibility to activate
    the purchased courses and request for a refund (in the event of any technical issue that arises in the course)
    within 48 hours from the date and time of purchase. However, the course becomes non-refundable if the refund
    requests are raised after 48 hours of the course activation.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Please also note that we treat
    violations of our Terms of Use very seriously, and we have no obligation to offer refunds to learners who violate
    these or other e-LATiH policies, even if their requests are made within the designated refund period.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">You may request a refund where:</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Course technical issues cannot be
    fixed by the content provider or vendor. We may require further information from you; hence, the 7 working days
    period will start from the day PSMB sends you an acknowledgment email that your investigation has started. Content
    providers or vendors are responsible for ensuring that any technical issue that arises in the course is fixed within
    7 working days from the acknowledgment date of the learner’s complaint.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Your refund request may be denied where:</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<ul id="l1">
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 109%;text-align: justify;">
        Multiple refunds (more than 1 time) were requested by a learner for the same course.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">
        Excessive refunds (more than 5 times) were requested by a learner for the different course.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">
        Learner who requests for their account deleted/deactivated or have their account banned or course access
        disabled due to a violation of our Terms and Condition.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;line-height: 108%;text-align: justify;">We
        have no obligation to offer refunds to users who do not pass the assessment in the courses, or who are otherwise
        unsatisfied with their final assessment marks.</p></li>
    <li><p style="padding-left: 41pt;text-indent: -18pt;text-align: justify;">The course was not
        activated within 48 hours from the date of purchase.</p></li>
</ul>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Please note that to avoid any
    confusion, any refund request is within the sole discretion of PSMB and may be declined if the above conditions are
    not met.</p>
<h2 style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Availability of Premium Courses on
    learner account</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">Premium courses that were
    subscribed will generally remain available for as long as you keep your e-LATiH account activated. On rare
    occasions, we may need to remove certain courses for legal or other reasons. We reserve the right to update courses
    without offering a refund or exchange.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Procedure to request for refund and check refund
    status</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;"><a
        href="mailto:elatih@hrdcorp.gov.my" class="s2" target="_blank">All refund requests and refund status must be
    made by email to </a><span
        style=" color: #0462C1; font-family:Verdana, sans-serif; font-style: normal; font-weight: normal; text-decoration: underline; font-size: 12pt;">elatih@hrdcorp.gov.my</span>.
    Please provide your email address, phone number, order ID, and justification to request for refund.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Refund process</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">All refunds will be processed
    within 30 days from the date of the acknowledgment of the refund request by PSMB via email. However, PSMB reserves
    the right to extend the period by more than 30 days to allow a thorough investigation. All refund requests will be
    reviewed by PSMB on a case-to-case basis and will determine whether the learner’s request is successful at our sole
    discretion.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Refund payment</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">The refund amount will be credited
    back to the learners’ account within 14 days of the successful refund application.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: justify;">For payment made using Credit Card,
    the refund will be made to the same Credit Card that the learner used to purchase. However, the number of days for
    the refund process varies accordingly to the respective bank processing time. Learners may contact the relevant bank
    for more information.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Others</h2>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">From time to time, the refund policy may be revised
    without prior notice and reason by PSMB. The revised version will be made available on e-LATiH.</p>
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: left;"><a href="mailto:elatih@hrdcorp.gov.my" class="s2"
                                                                   target="_blank">For further information, kindly
    email </a><a href="mailto:elatih@hrdcorp.gov.my" class="s1" target="_blank">elatih@hrdcorp.gov.my</a><a
        href="mailto:elatih@hrdcorp.gov.my" class="s2" target="_blank">.</a></p>
<p style="text-indent: 0pt;text-align: left;"><br/></p></body>
</html>
']);
        }
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

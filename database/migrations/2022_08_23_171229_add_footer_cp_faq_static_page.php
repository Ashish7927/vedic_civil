<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFooterCpFaqStaticPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $url = env('APP_URL');
        $cpFaq = \Modules\FrontendManage\Entities\FrontPage::where('slug', 'cp-faq')->first();
        if (!$cpFaq) {
            DB::table('front_pages')->insert([
                'name' => 'Content Provider FAQ',
                'title' => 'Content Provider FAQ',
                'sub_title' => 'Content Provider FAQ',
                'details' => '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CP FAQ 123</title>
    <style>
        body {
            all: initial;
        }

        body {
            all: unset
        }
        .cp-faq-container {
            width: 800px;
            margin: 0 auto;
        }
        .cp-faq-header{
            width: 100%;
            height: 80px;
        }
        .cp-faq-header img {
            width: 200px;
            height: 80px;
            float: right;
        }
        .container-nav {
            width: 100%;
            height: 80px;
            background-color: #171772;
            margin-top: 10px
            color: white;
        }
        .container-nav h1 {
            padding-top: 14px;
            padding-right: 35px;
            text-align: center;
            font-size: 2.5em;
        }
        .cp-faq-body-container {
            margin-left: 95px;
        }
        .cp-faq-body-container h2 {
            font-size: 1.8em;
            margin-top: 10px;
            color: #1a1a64;
        }
        .cp-faq-body-1-content {
            margin-left: 10px;
        }
        .cp-faq-container-image-right {
            float: right;
        }
        .table-1 {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table-1 td, th {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        .table-1 tr:nth-child(even) {
            background-color: lightgray;
        }
        .table-2 {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table-2 td, th {
            border: 1px solid orange;
            padding: 8px;
        }

        .table-2 tr:nth-child(even) {
            background-color: #f5ddd3;
        }
    </style>
</head>
<body>
    <div class="cp-faq-container">
        <div class="cp-faq-page-1">
            <div class="cp-faq-header">
                <img src="'.$url.'/images/CP-faq.png" class="cp-faq-container-image-right"  alt="" />
            </div>
            <div class="container-nav">
                <h1>FAQs e-LATiH Content Provider</h1>
            </div>
            <div class="cp-faq-body-container">
                <h2>Getting Started – General</h2>
                <div class="cp-faq-body-content">
                    <h3>1. What is E-LATIH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH is Malaysia’s premier e-learning platform that provides unlimited
                                access to online courses from reputable content providers. The main
                                objective of this platform is to encourage and cultivate a lifelong learning
                                culture via easily accessible learning resources that are customised to the
                                needs of the Malaysian industry.
                            </li>
                        </ul>
                    </div>
                    <h3>2. What is e-LATiH Premium?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH Premium is a marketplace to sell high-quality e-learning courses
                                designed by professional content providers with an enhanced learning
                                experience. HRD Corp provides an opportunity to all HRD Corp registered
                                Training Providers to develop, create and market e-learning courses on the
                                e-LATiH platform.
                            </li>
                        </ul>
                    </div>
                    <h3>3. Why should I be a part of e-LATiH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH Premium shall provide a new avenue for you to offer your services
                                and provide long-term value for the learners through easily accessible
                                learning resources.
                            </li>
                            <li>
                                You will be entitled to the following benefits but not limited to:<br>
                                i.&nbsp&nbsp&nbsp&nbsp  Gain access to a wider audience through e-LATiH;<br>
                                ii.&nbsp&nbsp&nbsp Create a new revenue stream through existing contents;<br>
                                iii.&nbsp&nbsp&nbspGenerate continuous income with a one-time effort;<br>
                                iv.&nbsp&nbsp&nbsp&nbspAccess to content creation tools to kick start your e-learning journey.<br>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="cp-faq-page-2">
            <div class="cp-faq-header-2">
                <img src="'.$url.'/images/elatih_logo.png" class="cp-faq-container-image-left" width="80px" height="40px" alt="" />
                <img src="'.$url.'/images/CP-faq.png" class="cp-faq-container-image-right" width="80px" height="40px"  alt="" />
            </div>
            <div class="container-nav-2">
                <h2 style="color: #1a1a64">Become a Content Provider (CP) on e-LATiH</h2>
                <div class="cp-faq-body-content" style="margin-left: 25px;">
                    <h3>1. Who is eligible to be a Content Provider on e-LATiH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                All HRD Corp Registered Training Providers are eligible to access the
                                Content Provider account on e-LATiH.
                            </li>
                        </ul>
                    </div>
                    <h3>2. How do I become an HRD Corp Registered Training Provider?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                To become an HRD Corp Registered Training Provider, kindly visit
                                <a href="https://hrdcorp.gov.my/training-providers/">https://hrdcorp.gov.my/training-providers/</a> for more information.
                            </li>
                        </ul>
                    </div>
                    <h3>3. How do I access the Content Provider account?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                No additional registration is required for HRD Corp Registered Training
                                Providers.
                            </li>
                            <li>
                                Visit <a style="text-decoration: none;color: black" href="https://elatih.hrdcorp.gov.my">https://elatih.hrdcorp.gov.my</a> and scroll down to the bottom of the
                                page to find the <a style="text-decoration: none; font-weight: bold;color: black" href="https://elatih.hrdcorp.gov.my/content-provider/">CP Log In.</a>
                            </li>
                            <li>
                                Use your existing eTris credentials (MyCoID and password) to access the
                                Content Provider account.
                            </li>
                        </ul>
                    </div>
                    <h3>4. How do I set up / update my Content Provider account?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                Click on your profile icon> MyProfile > Capture the updates > Agree to the
                                Terms and Conditions > Click “Update”.
                            </li>
                            <li>
                                The following information fields marked with an asterisk (*) are filled in
                                automatically based on your eTris database and cannot be edited:<br>
                                i. &nbsp&nbsp&nbsp&nbsp Company Name<br>
                                ii. &nbsp&nbsp&nbsp&nbsp MyCoID<br>
                                iii. &nbsp&nbsp&nbsp&nbspPhone<br>
                                iv. &nbsp&nbsp&nbsp&nbspAddress 1, Address 2<br>
                                v. &nbsp&nbsp&nbsp&nbsp Postcode<br>
                                vi. &nbsp&nbsp&nbsp&nbspCity<br>
                                vii. &nbsp&nbsp&nbspState<br>
                                viii. &nbsp&nbspCountry<br>
                            </li>
                            <li>
                                For any changes to the above information, please make the amendment
                                on eTris.
                            </li>
                        </ul>
                    </div>
                    <h3>5. Is there any agreement to become an e-LATiH Content
                        Provider?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                Yes, you must read and agree to the legally binding CP Terms & Conditions
                                whilst setting up your profile before proceeding with the course
                                development.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-nav-3">
                <div class="container-nav-2">
                    <h2 style="color: #1a1a64">Courses</h2>
                    <div class="cp-faq-body-content" style="margin-left: 25px;">
                        <h3>1. How do I create courses in e-LATiH?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    Please refer to the e-LATiH Course Creation Guideline which is available at
                                    the “Add course” tab on the CP account.
                                </li>
                            </ul>
                        </div>
                        <h3>2. How long does it take to publish a course?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    Upon course submission, you are subjected to a course review process to
                                    ensure the course is of high quality and minimum requirements are met. You
                                    shall receive email feedback from e-LATiH within 14 working days for
                                    publication/amendment/query if any. The review will be made based on
                                    the course criteria from the e-LATiH Course Creation Guideline.
                                </li>
                            </ul>
                        </div>
                        <h3>3. What is the maximum number of courses that can be created
                            on e-LATiH?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    There is no limit when creating a course on e-LATiH. You can create free
                                    and paid courses at your own discretion.
                                </li>
                            </ul>
                        </div>
                        <h3>4. Do I need to get approval from HRD Corp on the price setting
                            for Premium Courses?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    No, HRD Corp provides freedom to CPs to set their own course prices.
                                </li>
                            </ul>
                        </div>
                        <h3>5. What are the Course Requirements?</h3>
                        <div class="cp-faq-body-1-content">
                            <table class="table-1" style="border: 1px solid lightgray">
                                <tr style="background-color: #3f64d3;color: white">
                                    <th>Item</th>
                                    <th>Description / Requirements</th>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td>The Course title should be simple and reflect the course content.</td>
                                </tr>
                                <tr>
                                    <td>Course requirements</td>
                                    <td>Qualification or preliminary knowledge needed to pursue the course.</td>
                                </tr>
                                <tr>
                                    <td>Course description</td>
                                    <td>General overview of the course to manage learners’ expectations.</td>
                                </tr>
                                <tr>
                                    <td>Course outcomes</td>
                                    <td>A summary of the significant learning that learners will demonstrate by the completion of a course.</td>
                                </tr>
                                <tr>
                                    <td>Course curriculum</td>
                                    <td>The content of the course is relevant, up-to-date, and appropriate for all ages, which does not violate the terms and conditions.<br>The respective lessons in each course are in complete
                                        sequence and able to be played.</td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td>Minimum 30 minutes duration. Kindly ensure the minimum requirement is met before submitting the course.</td>
                                </tr>
                                <tr>
                                    <td>Language</td>
                                    <td>
                                        <ul>
                                            <li>Courses in English, Bahasa Malaysia, Mandarin,
                                                and Tamil are preferable to be published on the e-
                                                LATiH.</li>
                                            <li>Ensure the accent of any language used is clear
                                                and understandable by the learners.</li>
                                            <li>There should no mixing of languages in a course
                                                except for certain technical terms.</li>
                                        </ul>
                                    </td>
                                </tr>

                            </table>
                            <br><br>
                            <table class="table-2" style="border: 1px solid orange">
                                <tr style="background-color: orange;color: white">
                                    <th>Learning Materials</th>
                                    <th>Description / Requirements</th>
                                </tr>
                                <tr>
                                    <td>Video</td>
                                    <td>
                                        <ul>
                                            <li>Accepted format is MP4</li>
                                            <li>The video quality must be at least 1080p.</li>
                                            <li>Audio quality of each course must be clear for learners without any surrounding background interruption.</li>
                                            <li>Maximum recommended file size for each learning material to be uploaded is 800MB.</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interactive</td>
                                    <td>
                                        <ul>
                                            <li>Accepted format is SCORM.</li>
                                            <li>If Content Providers are using SCORM packages,
                                                kindly ensure it is SCORM 1.2 version.</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Categorization</td>
                                    <td>
                                        <ul>
                                            <li>The courses are well organized and consistent.
                                                Each course submitted for approval must be
                                                categorised properly according to the:<br>
                                                <ul>
                                                    <li>Skill Area</li>
                                                    <li>Course Level</li>
                                                    <li>Delivery Language</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Overall Quality</td>
                                    <td>Please ensure there is no typing error or third-party
                                        copyright issue for the title, course description, and
                                        others.</td>
                                </tr>
                                <tr>
                                    <td>Assessment/Quiz</td>
                                    <td>
                                        <ul>
                                            <li>Multiple-choice</li>
                                            <li>Matching</li>
                                            <li>Fill in the blank</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Additional
                                        Resources</td>
                                    <td>
                                        <ul>
                                            <li>This learning material serves only as additional
                                                resources for learners.</li>
                                            <li>Accepted formats are doc,pdf,ppt,xls.</li>
                                            <li>These resources can be downloaded by learners.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                            <h3>6. Can I amend/disable/remove courses that have been
                                published on e-LATiH?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, you are not allowed to amend/disable/remove any published
                                        courses without obtaining HRD Corp’s approval through email.
                                    </li>
                                    <li>
                                        For any issue, please contact <a href="mailto: elatihpremium@hrdcorp.gov.my">elatihpremium@hrdcorp.gov.my.</a>
                                    </li>
                                </ul>
                            </div>
                            <h3>7. Is e-LATiH Premium course levy claimable and what are the
                                requirements?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        Yes, it is levy claimable.
                                    </li>
                                    <li>
                                        You must follow all the requirements of Allowable Course Matrix (ACM) <a href="https://hrdcorp.gov.my/employer-guidelines/">https://hrdcorp.gov.my/employer-guidelines/</a>
                                    </li>
                                    <li>
                                        As a temporary measure, employers can only utilise their levy with the
                                        reimbursement method as described below:<br>
                                        i. Employers submit for grant application on eTris.<br>
                                        ii. Upon grant approval, employers may purchase the course.<br>
                                        iii. Employers apply for reimbursement.<br>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cp-faq-nav-4">
                <div class="cp-faq-page-2">
                    <div class="container-nav-2">
                        <h2 style="color: #1a1a64">Content Provider Payments</h2>
                        <div class="cp-faq-body-content" style="margin-left: 25px;">
                            <h3>1. Do I have to pay any fees to become a Content Provider on
                                e-LATiH?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        There is no fee required to become a Content Provider on e-LATiH.
                                    </li>
                                </ul>
                            </div>
                            <h3>2. How do I gain revenue from the Premium Courses?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You will gain revenue when learners buy your published courses.
                                </ul>
                            </div>
                            <h3>3. Do I need to submit for claim application?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, an invoice to HRD Corp will be automatically generated by the
                                        system.
                                    </li>
                                </ul>
                            </div>
                            <h3>4. How will I get paid for my Premium courses?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You must provide your banking details at the Content Provider account
                                        to receive payments. Payments will be made based on revenue
                                        generated at agreed intervals.
                                    </li>
                                    <li>
                                        For more information on payments, please refer to the CP Terms and
                                        Conditions.
                                    </li>
                                </ul>
                            </div>
                            <h3>5. Do I have to pay for the Sales and Services Tax (SST)?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, SST charged to the end user will be paid by HRD Corp to the Jabatan
                                        Kastam Diraja Malaysia.
                                    </li>
                                </ul>
                            </div>
                            <h3>6. How often will I get my payment?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You will receive your payment on a monthly basis.
                                    </li>
                                </ul>
                            </div>
                            <h3>7. How can I track my revenue?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You are able to track and monitor all their revenue and enrolments
                                        through the CP Course Revenue tab.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cp-faq-nav-5">
                <div class="cp-faq-page-2">
                    <div class="container-nav-2">
                        <h2 style="color: #1a1a64">Support</h2>
                        <div class="cp-faq-body-content" style="margin-left: 25px;">
                            <h3>1. Who should I contact for technical support?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul style="list-style: none">
                                    <li>
                                        Please email your feedback,
                                        suggestions, or technical queries to <a href="mailto: elatihpremium@hrdcorp.gov.my.">elatihpremium@hrdcorp.gov.my.</a>
                                    </li>
                                </ul>
                            </div>
                            <h3>2. How do I get more information about e-LATiH Premium?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You may join our upcoming briefing by registering at <a href="https://hrdcorp.gov.my/list-of-events/#elatih">https://hrdcorp.gov.my/list-of-events/#elatih</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>',
                'slug' => 'cp-faq',
                'status' => 1,
                'is_static' => 0,
            ]);
            $cpFaq = \Modules\FrontendManage\Entities\FrontPage::where('slug', 'cp-faq')->first();
        } else {
            DB::table('front_pages')->where('slug', 'cp-faq')->update([
                'name' => 'Content Provider FAQ',
                'title' => 'Content Provider FAQ',
                'sub_title' => 'Content Provider FAQ',
                'slug' => 'cp-faq',
                'status' => 1,
                'is_static' => 0,
                'details' => '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CP FAQ 123</title>
    <style>
        .cp-faq-container {
            width: 800px;
            height: 800px;
            margin: 0 auto;
        }
        .cp-faq-header{
            width: 100%;
            height: 80px;
        }
        .cp-faq-header img {
            width: 200px;
            height: 80px;
            float: right;
        }
        .container-nav {
            width: 100%;
            height: 80px;
            background-color: #171772;
            color: white;
        }
        .container-nav h1 {
            padding-top: 14px;
            padding-right: 35px;
            text-align: center;
            font-size: 2.5em;
        }
        .cp-faq-body-container {
            margin-left: 95px;
        }
        .cp-faq-body-container h2 {
            font-size: 1.8em;
            margin-top: 10px;
            color: #1a1a64;
        }
        .cp-faq-body-1-content {
            margin-left: 10px;
        }
        .cp-faq-container-image-right {
            float: right;
        }
        .table-1 {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table-1 td, th {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        .table-1 tr:nth-child(even) {
            background-color: lightgray;
        }
        .table-2 {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table-2 td, th {
            border: 1px solid orange;
            padding: 8px;
        }

        .table-2 tr:nth-child(even) {
            background-color: #f5ddd3;
        }
    </style>
</head>
<body>
    <div class="cp-faq-container">
        <div class="cp-faq-page-1">
            <div class="cp-faq-header">
                <img src="'.$url.'/images/CP-faq.png" class="cp-faq-container-image-right"  alt="" />
            </div>
            <div class="container-nav">
                <h1>FAQs e-LATiH Content Provider</h1>
            </div>
            <div class="cp-faq-body-container">
                <h2>Getting Started – General</h2>
                <div class="cp-faq-body-content">
                    <h3>1. What is E-LATIH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH is Malaysia’s premier e-learning platform that provides unlimited
                                access to online courses from reputable content providers. The main
                                objective of this platform is to encourage and cultivate a lifelong learning
                                culture via easily accessible learning resources that are customised to the
                                needs of the Malaysian industry.
                            </li>
                        </ul>
                    </div>
                    <h3>2. What is e-LATiH Premium?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH Premium is a marketplace to sell high-quality e-learning courses
                                designed by professional content providers with an enhanced learning
                                experience. HRD Corp provides an opportunity to all HRD Corp registered
                                Training Providers to develop, create and market e-learning courses on the
                                e-LATiH platform.
                            </li>
                        </ul>
                    </div>
                    <h3>3. Why should I be a part of e-LATiH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                e-LATiH Premium shall provide a new avenue for you to offer your services
                                and provide long-term value for the learners through easily accessible
                                learning resources.
                            </li>
                            <li>
                                You will be entitled to the following benefits but not limited to:<br>
                                i.&nbsp&nbsp&nbsp&nbsp  Gain access to a wider audience through e-LATiH;<br>
                                ii.&nbsp&nbsp&nbsp Create a new revenue stream through existing contents;<br>
                                iii.&nbsp&nbsp&nbspGenerate continuous income with a one-time effort;<br>
                                iv.&nbsp&nbsp&nbsp&nbspAccess to content creation tools to kick start your e-learning journey.<br>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="cp-faq-page-2">
            <div class="cp-faq-header-2">
                <img src="'.$url.'/images/elatih_logo.png" class="cp-faq-container-image-left" width="80px" height="40px" alt="" />
                <img src="'.$url.'/images/CP-faq.png" class="cp-faq-container-image-right" width="80px" height="40px"  alt="" />
            </div>
            <div class="container-nav-2">
                <h2 style="color: #1a1a64">Become a Content Provider (CP) on e-LATiH</h2>
                <div class="cp-faq-body-content" style="margin-left: 25px;">
                    <h3>1. Who is eligible to be a Content Provider on e-LATiH?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                All HRD Corp Registered Training Providers are eligible to access the
                                Content Provider account on e-LATiH.
                            </li>
                        </ul>
                    </div>
                    <h3>2. How do I become an HRD Corp Registered Training Provider?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                To become an HRD Corp Registered Training Provider, kindly visit
                                <a href="https://hrdcorp.gov.my/training-providers/">https://hrdcorp.gov.my/training-providers/</a> for more information.
                            </li>
                        </ul>
                    </div>
                    <h3>3. How do I access the Content Provider account?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                No additional registration is required for HRD Corp Registered Training
                                Providers.
                            </li>
                            <li>
                                Visit <a style="text-decoration: none;color: black" href="https://elatih.hrdcorp.gov.my">https://elatih.hrdcorp.gov.my</a> and scroll down to the bottom of the
                                page to find the <a style="text-decoration: none; font-weight: bold;color: black" href="https://elatih.hrdcorp.gov.my/content-provider/">CP Log In.</a>
                            </li>
                            <li>
                                Use your existing eTris credentials (MyCoID and password) to access the
                                Content Provider account.
                            </li>
                        </ul>
                    </div>
                    <h3>4. How do I set up / update my Content Provider account?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                Click on your profile icon> MyProfile > Capture the updates > Agree to the
                                Terms and Conditions > Click “Update”.
                            </li>
                            <li>
                                The following information fields marked with an asterisk (*) are filled in
                                automatically based on your eTris database and cannot be edited:<br>
                                i. &nbsp&nbsp&nbsp&nbsp Company Name<br>
                                ii. &nbsp&nbsp&nbsp&nbsp MyCoID<br>
                                iii. &nbsp&nbsp&nbsp&nbspPhone<br>
                                iv. &nbsp&nbsp&nbsp&nbspAddress 1, Address 2<br>
                                v. &nbsp&nbsp&nbsp&nbsp Postcode<br>
                                vi. &nbsp&nbsp&nbsp&nbspCity<br>
                                vii. &nbsp&nbsp&nbspState<br>
                                viii. &nbsp&nbspCountry<br>
                            </li>
                            <li>
                                For any changes to the above information, please make the amendment
                                on eTris.
                            </li>
                        </ul>
                    </div>
                    <h3>5. Is there any agreement to become an e-LATiH Content
                        Provider?</h3>
                    <div class="cp-faq-body-1-content">
                        <ul>
                            <li>
                                Yes, you must read and agree to the legally binding CP Terms & Conditions
                                whilst setting up your profile before proceeding with the course
                                development.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-nav-3">
                <div class="container-nav-2">
                    <h2 style="color: #1a1a64">Courses</h2>
                    <div class="cp-faq-body-content" style="margin-left: 25px;">
                        <h3>1. How do I create courses in e-LATiH?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    Please refer to the e-LATiH Course Creation Guideline which is available at
                                    the “Add course” tab on the CP account.
                                </li>
                            </ul>
                        </div>
                        <h3>2. How long does it take to publish a course?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    Upon course submission, you are subjected to a course review process to
                                    ensure the course is of high quality and minimum requirements are met. You
                                    shall receive email feedback from e-LATiH within 14 working days for
                                    publication/amendment/query if any. The review will be made based on
                                    the course criteria from the e-LATiH Course Creation Guideline.
                                </li>
                            </ul>
                        </div>
                        <h3>3. What is the maximum number of courses that can be created
                            on e-LATiH?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    There is no limit when creating a course on e-LATiH. You can create free
                                    and paid courses at your own discretion.
                                </li>
                            </ul>
                        </div>
                        <h3>4. Do I need to get approval from HRD Corp on the price setting
                            for Premium Courses?</h3>
                        <div class="cp-faq-body-1-content">
                            <ul>
                                <li>
                                    No, HRD Corp provides freedom to CPs to set their own course prices.
                                </li>
                            </ul>
                        </div>
                        <h3>5. What are the Course Requirements?</h3>
                        <div class="cp-faq-body-1-content">
                            <table class="table-1" style="border: 1px solid lightgray">
                                <tr style="background-color: #3f64d3;color: white">
                                    <th>Item</th>
                                    <th>Description / Requirements</th>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td>The Course title should be simple and reflect the course content.</td>
                                </tr>
                                <tr>
                                    <td>Course requirements</td>
                                    <td>Qualification or preliminary knowledge needed to pursue the course.</td>
                                </tr>
                                <tr>
                                    <td>Course description</td>
                                    <td>General overview of the course to manage learners’ expectations.</td>
                                </tr>
                                <tr>
                                    <td>Course outcomes</td>
                                    <td>A summary of the significant learning that learners will demonstrate by the completion of a course.</td>
                                </tr>
                                <tr>
                                    <td>Course curriculum</td>
                                    <td>The content of the course is relevant, up-to-date, and appropriate for all ages, which does not violate the terms and conditions.<br>The respective lessons in each course are in complete
                                        sequence and able to be played.</td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td>Minimum 30 minutes duration. Kindly ensure the minimum requirement is met before submitting the course.</td>
                                </tr>
                                <tr>
                                    <td>Language</td>
                                    <td>
                                        <ul>
                                            <li>Courses in English, Bahasa Malaysia, Mandarin,
                                                and Tamil are preferable to be published on the e-
                                                LATiH.</li>
                                            <li>Ensure the accent of any language used is clear
                                                and understandable by the learners.</li>
                                            <li>There should no mixing of languages in a course
                                                except for certain technical terms.</li>
                                        </ul>
                                    </td>
                                </tr>

                            </table>
                            <br><br>
                            <table class="table-2" style="border: 1px solid orange">
                                <tr style="background-color: orange;color: white">
                                    <th>Learning Materials</th>
                                    <th>Description / Requirements</th>
                                </tr>
                                <tr>
                                    <td>Video</td>
                                    <td>
                                        <ul>
                                            <li>Accepted format is MP4</li>
                                            <li>The video quality must be at least 1080p.</li>
                                            <li>Audio quality of each course must be clear for learners without any surrounding background interruption.</li>
                                            <li>Maximum recommended file size for each learning material to be uploaded is 800MB.</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interactive</td>
                                    <td>
                                        <ul>
                                            <li>Accepted format is SCORM.</li>
                                            <li>If Content Providers are using SCORM packages,
                                                kindly ensure it is SCORM 1.2 version.</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Categorization</td>
                                    <td>
                                        <ul>
                                            <li>The courses are well organized and consistent.
                                                Each course submitted for approval must be
                                                categorised properly according to the:<br>
                                                <ul>
                                                    <li>Skill Area</li>
                                                    <li>Course Level</li>
                                                    <li>Delivery Language</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Overall Quality</td>
                                    <td>Please ensure there is no typing error or third-party
                                        copyright issue for the title, course description, and
                                        others.</td>
                                </tr>
                                <tr>
                                    <td>Assessment/Quiz</td>
                                    <td>
                                        <ul>
                                            <li>Multiple-choice</li>
                                            <li>Matching</li>
                                            <li>Fill in the blank</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Additional
                                        Resources</td>
                                    <td>
                                        <ul>
                                            <li>This learning material serves only as additional
                                                resources for learners.</li>
                                            <li>Accepted formats are doc,pdf,ppt,xls.</li>
                                            <li>These resources can be downloaded by learners.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                            <h3>6. Can I amend/disable/remove courses that have been
                                published on e-LATiH?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, you are not allowed to amend/disable/remove any published
                                        courses without obtaining HRD Corp’s approval through email.
                                    </li>
                                    <li>
                                        For any issue, please contact <a href="mailto: elatihpremium@hrdcorp.gov.my">elatihpremium@hrdcorp.gov.my.</a>
                                    </li>
                                </ul>
                            </div>
                            <h3>7. Is e-LATiH Premium course levy claimable and what are the
                                requirements?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        Yes, it is levy claimable.
                                    </li>
                                    <li>
                                        You must follow all the requirements of Allowable Course Matrix (ACM) <a href="https://hrdcorp.gov.my/employer-guidelines/">https://hrdcorp.gov.my/employer-guidelines/</a>
                                    </li>
                                    <li>
                                        As a temporary measure, employers can only utilise their levy with the
                                        reimbursement method as described below:<br>
                                        i. Employers submit for grant application on eTris.<br>
                                        ii. Upon grant approval, employers may purchase the course.<br>
                                        iii. Employers apply for reimbursement.<br>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cp-faq-nav-4">
                <div class="cp-faq-page-2">
                    <div class="container-nav-2">
                        <h2 style="color: #1a1a64">Content Provider Payments</h2>
                        <div class="cp-faq-body-content" style="margin-left: 25px;">
                            <h3>1. Do I have to pay any fees to become a Content Provider on
                                e-LATiH?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        There is no fee required to become a Content Provider on e-LATiH.
                                    </li>
                                </ul>
                            </div>
                            <h3>2. How do I gain revenue from the Premium Courses?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You will gain revenue when learners buy your published courses.
                                </ul>
                            </div>
                            <h3>3. Do I need to submit for claim application?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, an invoice to HRD Corp will be automatically generated by the
                                        system.
                                    </li>
                                </ul>
                            </div>
                            <h3>4. How will I get paid for my Premium courses?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You must provide your banking details at the Content Provider account
                                        to receive payments. Payments will be made based on revenue
                                        generated at agreed intervals.
                                    </li>
                                    <li>
                                        For more information on payments, please refer to the CP Terms and
                                        Conditions.
                                    </li>
                                </ul>
                            </div>
                            <h3>5. Do I have to pay for the Sales and Services Tax (SST)?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        No, SST charged to the end user will be paid by HRD Corp to the Jabatan
                                        Kastam Diraja Malaysia.
                                    </li>
                                </ul>
                            </div>
                            <h3>6. How often will I get my payment?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You will receive your payment on a monthly basis.
                                    </li>
                                </ul>
                            </div>
                            <h3>7. How can I track my revenue?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You are able to track and monitor all their revenue and enrolments
                                        through the CP Course Revenue tab.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cp-faq-nav-5">
                <div class="cp-faq-page-2">
                    <div class="container-nav-2">
                        <h2 style="color: #1a1a64">Support</h2>
                        <div class="cp-faq-body-content" style="margin-left: 25px;">
                            <h3>1. Who should I contact for technical support?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul style="list-style: none">
                                    <li>
                                        Please email your feedback,
                                        suggestions, or technical queries to <a href="mailto: elatihpremium@hrdcorp.gov.my.">elatihpremium@hrdcorp.gov.my.</a>
                                    </li>
                                </ul>
                            </div>
                            <h3>2. How do I get more information about e-LATiH Premium?</h3>
                            <div class="cp-faq-body-1-content">
                                <ul>
                                    <li>
                                        You may join our upcoming briefing by registering at <a href="https://hrdcorp.gov.my/list-of-events/#elatih">https://hrdcorp.gov.my/list-of-events/#elatih</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>']);
            $cpFaq = \Modules\FrontendManage\Entities\FrontPage::where('slug', 'cp-faq')->first();
        }


        $check1 = \Modules\FooterSetting\Entities\FooterWidget::where('slug', '/cp-faq')->first();
        if($check1) {
            $check1->delete();
        }
        $check2 = \Modules\FooterSetting\Entities\FooterWidget::where('slug', 'cp-faq')->first();
        if ($check2) {
            $check2->slug = $cpFaq->slug;
            $check2->page = $cpFaq->slug;
            $check2->page_id = $cpFaq->id;
            $check2->is_static = $cpFaq->is_static;
            $check2->save();
        } else {
            \Modules\FooterSetting\Entities\FooterWidget::create([
                'user_id' => 1,
                'name' => 'CP FAQ',
                'slug' => $cpFaq->slug,
                'description' => 'CP FAQ',
                'page_id' => $cpFaq->id,
                'category_id' => 3,
                'page' => $cpFaq->slug,
                'section' => 4,
                'is_static' => 0
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Modules\FrontendManage\Entities\FrontPage::where('slug', 'cp-faq')->delete();
        \Modules\FooterSetting\Entities\FooterWidget::where('slug', 'cp-faq')->delete();
    }
}

@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'e-Latih LMS' }} | {{ __('courses.Courses') }}
@endsection
@section('css')
    <link href="{{ asset('public/frontend/elatihlmstheme/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('js')
    <script src="{{ asset('public/frontend/elatihlmstheme/js/classes.js') }}"></script>
    <script src="{{ asset('public/frontend/elatihlmstheme/js/select2.min.js') }}"></script>
@endsection
@section('mainContent')
    <style>
        .select2-container--default .select2-selection--single {
            display: block;
            width: 100%;
            /* height: calc(1.5em + .75rem + 2px); */
            height: 100% !important;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            /* height: 35px; */
            height: 100% !important;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        /* flexible select box width when max/min the page */
        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            word-wrap: break-word;
            text-overflow: inherit;
            white-space: normal;
        }

        #select2-industry-results .select2-results__option {
            word-wrap: break-word;
            text-overflow: inherit;
            white-space: normal;
        }

        /* body {
                                                                                                                                                background: #ccc;
                                                                                                                                            } */

        .h1 {
            font-weight: bold;
            font-size: 36px;
        }

        .penTitle {
            font-family: Lato;
            font-size: 5vw;
            font-weight: bold;
            color: #222;
            text-shadow: -1px -1px 2px #666,
                1px 1px 2px #aaa;
            margin: 2em auto;
            text-align: center;
        }

        .timeline {
            display: block;
            width: 562px;
            background-color: var(--system_primery_color);
            border-radius: 5px;
            margin: 72px auto;
            /* counter-reset: step; */
        }

        .timeline::after {
            content: "";
            display: block;
            clear: both;
        }

        .progressbar-text li {
            list-style: none;
            text-align: center;
            width: 33%;
        }

        .li {
            float: left;
            width: 10px;
            height: 1px;
            margin-right: 200px;
            background-color: var(--system_primery_color);
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            line-height: 10px;
            text-indent: -9999px;
            position: relative;
        }

        .li::after {
            text-indent: 0;
            display: block;
            counter-increment: step;
            content: "1";
            width: 50px;
            height: 50px;
            background-color: var(--system_primery_color);
            color: #fff;
            line-height: 54px;
            position: absolute;
            top: -26px;
            left: -45px;
            border-radius: 50%;
            -webkit-transition: .2s ease-in 0s;
            transition: .2s ease-in 0s;
            box-shadow: 0px -1px 3px 10px #ef4d2370;
        }

        .li:nth-child(2)::after {
            text-indent: 0;
            display: block;
            counter-increment: step;
            content: "2";
            width: 50px;
            height: 50px;
            background-color: var(--system_primery_color);
            color: #fff;
            line-height: 54px;
            position: absolute;
            top: -26px;
            left: -25px;
            border-radius: 50%;
            -webkit-transition: .2s ease-in 0s;
            transition: .2s ease-in 0s;
        }

        .li:last-child::after {
            text-indent: 0;
            display: block;
            counter-increment: step;
            content: "3";
            width: 50px;
            height: 50px;
            background-color: var(--system_primery_color);
            color: #fff;
            line-height: 54px;
            position: absolute;
            top: -26px;
            left: 0px;
            border-radius: 50%;
            -webkit-transition: .2s ease-in 0s;
            transition: .2s ease-in 0s;
        }

        .li:last-child {
            margin: 0 0 0 215px;
        }

        .li:nth-child(2) {
            /* margin-right: 0; */
            margin: 0 0 0 38px;
        }

        .li:hover::after {
            transform: scale(1.2);
        }

        .progressbar-text {
            display: flex;
            justify-content: space-between;
            /* margin: -50px auto 0; */
            margin-left: 159px;
            width: 90%;
            font-weight: bold;
            margin: 0 auto;
        }

        .text-bold {
            font-weight: bold;
        }

        /* .form-contant {
                                border: 1px solid #d2d2d2;
                                border-radius: 5px;
                            } */

        .heading {
            padding: 10px 8px 14px;
        }

        .form-control:focus {
            border: 2px solid #EF4D23;
            box-shadow: none;
        }

        .form-group label {
            font-weight: 500;
        }

        .checkbox label a {
            color: hsl(224.8deg 56.39% 26.08%);
            text-decoration: underline;
            font-weight: bold;
        }

        .checkbox label {
            padding-bottom: 15px;
        }


        /* input css */

        .form-group label::before {
            line-height: 20px;
            font-size: 12px;
            top: -10px;
            background: #fff;
            padding: 0 6px;
            left: 9px;
        }

        .form-group label::before {
            content: attr(title);
            position: absolute;
            top: 0;
            left: 30px;
            line-height: 2px;
            font-size: 14px;
            color: #777;
            transition: 300ms all;
        }

        .form-group input::placeholder {
            color: #ddd;
        }

        .inner-form {
            background-color: #fff;
            border: 1px solid #d2d2d2;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border: 1px solid #d2d2d2;

        }

        .primary_checkbox {
            display: flex;
            align-items: center;
            position: relative;
            line-height: 20px;
            font-size: 16px;
            font-weight: 400;
            color: var(--system_secendory_color);
            margin: 0px 32px 15px 0;
        }

        .primary_checkbox .checkmark {
            position: relative;
            width: 20px;
            height: 20px;
            top: 0;
            left: 0;
            display: inline-block;
            cursor: pointer;
            line-height: 56px;
            flex: 20px 0 0;
            border: 1px solid #c4c4c4;
            margin-right: 6px;
        }

        .primary_checkbox input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
        }

        input[type=checkbox],
        input[type=radio] {
            box-sizing: border-box;
            padding: 0;
        }

        .label_name {
            font-weight: bold !important;
        }

        .radio-button {
            margin: -13px 0px 0px 0px;
        }

        .checkbox-label {
            margin: 0px 0px 0px 8px;
        }

        input {
            font-weight: bold;
        }

        .corporate-contant {
            margin: 30px 50px 0 50px;
        }

        .corporate-access {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .corporate-access h4 {
            font-size: 15px;
            padding-right: 10px;
            font-weight: 700;
            padding-left: 10px;
        }

        .download img {
            padding-right: 9px;
        }

        .interest-btn {
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
        }
    </style>
    <div>
        <div class="breadcrumb_area bradcam_bg_2"
            style="background-image: url('./public/frontend/elatihlmstheme/img/banner/banner_bookademo.jpg');background-size: 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="breadcam_wrap">
                            <h3>
                                Get Corporate Access
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid"
        style="background-image: url('./public/frontend/elatihlmstheme/img/banner/bookademo_body_bg.png');background-size: 100% 100%; background-color:#fff">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10 offset-sm-1">
                    <div class="mt_40 mb_40" style="text-align: center;">
                        <h4 class="h1">
                            Accelerate your talent development and business transformation with e-LATiH Corporate Access
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb_40">
                <div class="col-lg-5 offset-sm-1">
                    <ul class="ml-5">
                        <li class="mb-3 text-bold d-flex">
                            <div>

                                <img style="width: 20px;" src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                FREE demo account
                            </div>
                        </li>
                        <li class="mb-3 text-bold d-flex">
                            <div>
                                <img style="width: 20px;" src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                Learn anytime, anywhere from the world’s leading content providers
                            </div>
                        </li>
                        <li class="mb-3 text-bold d-flex">
                            <div>
                                <img style="width: 20px;" src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                Track, monitor, and manage the employees’ learning journey
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <ul class="ml-5">
                        <li class="mb-3 text-bold d-flex">
                            <div>
                                <img style="width: 20px;"src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                Full admin management and advanced reporting
                            </div>
                        </li>
                        <li class="mb-3 text-bold d-flex">
                            <div>
                                <img style="width: 20px;" src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                Curate and upload e-learning courses specifically for your organisation
                            </div>
                        </li>
                        <li class="mb-3 text-bold d-flex">
                            <div>
                                <img style="width: 20px;" src="./public/frontend/elatihlmstheme/img/banner/tic_icon.png">
                            </div>
                            <div class="ml-3">
                                Integrated levy system for HRD Corp registered employers
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="">
                <div class="col-lg-8 offset-sm-2 p-4"
                    style="background-color:#f6f7fc; -moz-box-shadow: 0 0 3px #ccc; -webkit-box-shadow: 0 0 3px #ccc;box-shadow: 0 0 3px #ccc; border-radius: 3px;">
                    <h3 class="h1" style="text-align: center">
                        3 Easy Steps To Get Corporate Access
                    </h3>
                    <div class="">
                        <ol class="timeline">
                            <li class="li">1</li>
                            <li class="li">2</li>
                            <li class="li">3</li>

                        </ol>
                        <div class="progressbar-text">
                            <li class="">Submit the interest form <br> to join the demo session</li>
                            <li class="space-between">Submit the CARF to create <br> Corporate Access Account</li>
                            <li class="">Enjoy the corporate <br> Access Features</li>
                        </div>
                    </div>
                    <div class="form-contant mt-5">
                        <div class="interest-btn" style="background-color: #17254c">
                            <h4 class="text-white text-center heading mb-0 ">Interest Form</h4>
                        </div>
                        <form class="p-3 inner-form" action="{{ route('saveInterestForm') }}" method="post" id="interestForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="full_name" placeholder="Full Name"
                                            name="full_name" required>
                                        <label for="full_name" data-title="full_name" title="Full Name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email_address"
                                            placeholder="email@example.com" name="email_address" required>
                                        <label for="email_address" data-title="email_address" title="Email Address"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="phone_number"
                                            placeholder="+601 XXXX XXX" name="phone_number" required>
                                        <label for="phone_number" data-title="phone_number" title="Phone Number"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="company_name"
                                            placeholder="ABC Inc." name="company_name" required>
                                        <label for="company_name" data-title="company_name" title="Company Name"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="company_registration_no"
                                            placeholder="XXXX XXXX XXXX" name="company_registration_no" required>
                                        <label for="company_registration_no" data-title="company_registration_no"
                                            title="Company Registration No."></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <select class="form-control" id="location" name="location" required>
                                            <option>Select Location</option>
                                            <option value="Johor">Johor</option>
                                            <option value="Kedah">Kedah</option>
                                            <option value="Kelantan">Kelantan</option>
                                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                                            <option value="Labuan">Labuan</option>
                                            <option value="Melaka">Melaka</option>
                                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                                            <option value="Pahang">Pahang</option>
                                            <option value="Penang">Penang</option>
                                            <option value="Perak">Perak</option>
                                            <option value="Perlis">Perlis</option>
                                            <option value="Putrajaya">Putrajaya</option>
                                            <option value="Sabah">Sabah</option>
                                            <option value="Sarawak">Sarawak</option>
                                            <option value="Selangor">Selangor</option>
                                            <option value="Terengganu">Terengganu</option>
                                        </select>
                                        <label for="location" data-title="location" title="Location"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="industry" name="industry" required>
                                            <option>Select Industry</option>
                                            <option value="Agriculture, forestry and fishing">Agriculture, forestry and
                                                fishing
                                            </option>
                                            <option value="Mining and quarrying">Mining and quarrying</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Electricity, gas, steam and air conditioning supply">
                                                Electricity,
                                                gas, steam and air conditioning supply</option>
                                            <option
                                                value="Water supply; sewerage, waste management and remediation activitiesy">
                                                Water supply; sewerage, waste management and remediation activities</option>
                                            <option value="Construction">Construction</option>
                                            <option
                                                value="Wholesale and retail trade; repair of motor vehicles and motorcycles">
                                                Wholesale and retail trade; repair of motor vehicles and motorcycles
                                            </option>
                                            <option value="Transportation and storage">Transportation and storage</option>
                                            <option value="Accommodation and food service activities">Accommodation and
                                                food
                                                service activities</option>
                                            <option value="Information and communication">Information and communication
                                            </option>
                                            <option value="Financial and insurance/takaful activities">Financial and
                                                insurance/takaful activities</option>
                                            <option value="Real estate activities">Real estate activities</option>
                                            <option value="Professional, scientific and technical activities">Professional,
                                                scientific and technical activities</option>
                                            <option value="Administrative and support service activities">Administrative
                                                and
                                                support service activities</option>
                                            <option value="Public administration and defence; compulsory social security">
                                                Public administration and defence; compulsory social security</option>
                                            <option value="Education">Education</option>
                                            <option value="Human health and social work activities">Human health and social
                                                work activities</option>
                                            <option value="Arts, entertainment and recreation">Arts, entertainment and
                                                recreation</option>
                                            <option value="Other service activities">Other service activities</option>
                                            <option
                                                value="Activities of households as employers; undifferentiated goods- and services-producing activities of households for own use">
                                                Activities of households as employers; undifferentiated goods- and
                                                services-producing activities of households for own use
                                            </option>
                                            <option value="Activities of extraterritorial organizations and bodies">
                                                Activities
                                                of extraterritorial organizations and bodies</option>

                                        </select>
                                        <label for="industry" data-title="industry" title="Industry"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="no_of_employees" placeholder="0"
                                            name="no_of_employees" required>
                                        <label for="no_of_employees" data-title="no_of_employees"
                                            title="No. of Employees"></label>
                                    </div>
                                </div>

                                <div class="col-md-6 radio-button">
                                    <label for="hrd_corp">HRD Corp Registered Employers</label>
                                    <div class="radio" style="display:flex">
                                        <label class="primary_checkbox">
                                            <input type="radio" name="hrd_corp" value="Yes" required>
                                            <span class="checkmark mr_15"></span>
                                            <span class="label_name">Yes</span>
                                        </label>
                                        <label class="primary_checkbox">
                                            <input type="radio" name="hrd_corp" value="No" required>
                                            <span class="checkmark mr_15"></span>
                                            <span class="label_name">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label class="primary_checkbox"><input type="checkbox" name="" required>
                                            <span class="checkmark mr_15"></span>
                                            <span class="checkbox-label">
                                                By submitting your info in the form above, you agree to our <a
                                                    href="pages/terms-of-use" target="_blank">Terms of
                                                    Use</a> and <a href="pages/privacy-policy-and-cookie-policy"
                                                    target="_blank">Privacy Policy</a>. We may use this info to contact you
                                                and/or
                                                use the data to personalise your experience.
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="hasCaptcha" value="{{env('nocaptcha_for_interest')}}">
                            <div class="col-12 mt_10 mb_20">
                                @if(config('captcha.for_interest'))
                                    @if(config('captcha.is_invisible'))
                                        {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                                        {!! NoCaptcha::renderJs() !!}
                                    @else
                                        {!! NoCaptcha::display() !!}
                                        {!! NoCaptcha::renderJs() !!}
                                    @endif

                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger"
                                                role="alert">{{$errors->first('g-recaptcha-response')}}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert-msg"></div>
                                    @if(config('captcha.is_invisible')=="true")
                                        <button type="button"
                                                class="g-recaptcha theme_btn small_btn submit-btn w-100 text-center"
                                                data-sitekey="{{config('captcha.sitekey')}}"
                                                data-size="invisible"
                                                data-callback="onSubmit">
                                                Submit
                                        </button>

                                        <script src="https://www.google.com/recaptcha/api.js" async
                                                defer></script>
                                        <script>
                                            function onSubmit(token) {
                                                document.getElementById("interestForm").submit();
                                            }
                                        </script>
                                    @else
                                        <button type="submit" class="btn"
                                        style="background:#EF4D23; color:white;width:100%;">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="corporate-contant">
                        <div class="corporate-access" style="background-color: #1d3068">
                            <div>
                                <h4 class="text-white mb-0 download"> <img
                                        src=" {{ asset('public/images/icons/pdf-icon.png') }} " alt=""> Corporate
                                    Access Request Form (CARF)</h4>
                            </div>
                            <div>
                                <a href="{{ asset('/public/CARF1.1.pdf') }}" class="btn" style="background:#EF4D23; color:white;" target="_blank" download><img
                                        src="{{ asset('public/images/icons/download-icon.png') }}" alt="" >
                                    Download</a>
                            </div>
                        </div>
                        <div class="corporet-access-user">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="corporet-access-left corporate-access" style="background-color: #1d3068">
                                        <div>
                                            <h4 class="text-white mb-0 pr-3">Corporate Access User Agreement</h4>
                                        </div>
                                        <div>
                                            <a href="public/e_LATiH_CORPORATE_ACCESS_USER_AGREEMENT_1_0.pdf" class="btn"
                                                style="background:#EF4D23; color:white;" target="_blank"><img
                                                    src="{{ asset('public/images/icons/redirect-icon.png') }}"
                                                    alt="" ></a>
                                        </div>
                                    </div>
                                </div>
                               {{-- <div class="col-lg-6">
                                    <div class="corporet-access-right corporate-access" style="background-color:#1d3068">
                                        <div>
                                            <h4 class="text-white mb-0 pr-3">Frequently Asked Questions (FAQs)</h4>
                                        </div>
                                        <div>
                                            <a href="pages/faq" class="btn"
                                                style="background:#EF4D23; color:white;" target="_blank"><img
                                                    src="{{ asset('public/images/icons/redirect-icon.png') }}"
                                                    alt="" ></a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-sm-4 mb-4 mt-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <a class="btn"
                                style="color:#F15C33; border:2px solid #F15C33; width:100%; padding: 10px; font-weight: bold;"
                                href="{{ url('/') }}">Back to Homepage</a>
                        </div>
                        <div class="col-lg-6">
                            <a class="btn"
                                style="color:#F15C33; border:2px solid #F15C33; width:100%; padding: 10px; font-weight: bold;"
                                href="{{ route('corporate_access_page') }}">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <x-corporate-access-page-trusted-by-section :homeContent="$homeContent" />
    </div>
    {{-- <div class="container-fluid" style="background-color:#F2F2F2;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 offset-sm-1"></div>
                <div class="mt_40">
                    <h1 class="h1">
                    Trusted by
                    </h13>
                </div>
            </div>
        </div>
        <div class="row align-items-center offset-sm-1 pb-4">

        @foreach ($companies as $company)
        <div class="col-lg-3 mt_40">
                <img class="img" src="{{ $company->logo }}">
            </div>
        @endforeach

            <!-- <div class="col-lg-12 ml-5 mb_40">
                <img class="img" src="/public/frontend/elatihlmstheme/img/banner/image 21.png">
            </div>
             -->
        </div>



        </div>
    </div>
</div> --}}
    <script>
        $(document).ready(function() {
            $('#industry').select2({
                minimumResultsForSearch: -1
            });
            $('#location').select2({
                minimumResultsForSearch: -1
            });
        });
    </script>
@endsection

@extends(theme('auth.layouts.app'))
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/elatihlmstheme/css/register/assets/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('frontend/elatihlmstheme/css/register/assets/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/elatihlmstheme/css/register/assets/font-awesome.css') }}">
    <link href="{{ asset('frontend/elatihlmstheme/css/register/assets/bootstrap.min.css') }}" rel="stylesheet" type="text/css')}}" />
    <link href="{{ asset('frontend/elatihlmstheme/css/register/assets/datepicker.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .chinputn {
            font-size: 16px !important;
            padding: 0 18px !important;
            font-family: inherit !important;
        }

        .chinputn::placeholder {
            font-size: 15px !important;
            font-family: inherit !important;
        }

        .input-phone::placeholder {
            font-size: 15px !important;
            font-family: inherit !important;
        }

        .nice-select.open .list {
            white-space: pre-line;
        }

        body {
            background: url('{{ asset('uploads/images/') }}/23-12-2021/registration-bg.png') fixed;
            background-repeat: no-repeat;
            background-position: right top;
            background-size: 1180px 100%;
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px;
            font-family: Jost, sans-serif;
        }

        .login_wrapper {
            justify-content: center;
            float: left;
        }

        .login_wrapper .login_wrapper_left .login_wrapper_content {

            max-width: 609px;
        }

        .login_wrapper .login_wrapper_left .logo {
            margin-bottom: 50px;
        }

        #msform fieldset .form-card {

            border: 0 none;
            border-radius: 0px;

            padding: 20px 40px 0px 40px;
            box-sizing: border-box;
            width: 94%;
            margin: 0 3% 0px 3%;
            position: relative;
            font-family: Jost, sans-serif;
        }

        #msform fieldset {

            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative;
            font-family: Jost, sans-serif;
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform fieldset .form-card {
            text-align: left;
            color: #9E9E9E
        }

        #msform input,
        #msform textarea {
            padding: 0px 8px 4px 8px;
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            color: #7088d0;
            font-size: 16px;
            letter-spacing: 1px;
            font-family: Jost, sans-serif;
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: none;
            font-weight: bold;
            border-bottom: 2px solid skyblue;
            outline-width: 0
        }

        #msform .action-button {
            width: 100%;
            background: #465584;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
            font-size: 24px;
        }

        .login_wrapper .login_wrapper_left .shitch_text {
            font-size: 14px;
            font-weight: 500;
            color: #465584;
            text-align: center;
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
        }

        #msform .action-button-previous {
            width: 100%;
            background: #465584;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
            font-size: 24px;
            margin-top: 35px;
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
        }

        select.list-dt {
            border: none;
            outline: 0;
            border-bottom: 1px solid #ccc;
            padding: 2px 5px 3px 5px;
            margin: 2px
        }

        select.list-dt:focus {
            border-bottom: 2px solid skyblue
        }

        .card {
            z-index: 0;
            border: none;
            border-radius: 0.5rem;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #2C3E50;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #000000
        }

        #progressbar li {
            list-style-type: none;
            font-size: 16px;
            width: 25%;
            float: left;
            position: relative
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f023"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f09d"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 16px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: skyblue
        }

        .radio-group {
            position: relative;
            margin-bottom: 25px
        }

        .radio {
            display: inline-block;
            width: 204;
            height: 104;
            border-radius: 0;
            background: lightblue;
            box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            cursor: pointer;
            margin: 8px 2px
        }

        .radio:hover {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
        }

        .radio.selected {
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }

        #progressbar li {
            list-style-type: none;
            font-size: 16px;
            width: 50%;
            float: left;
            position: relative;
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey;
            width: 100%;
            padding: 0 25px;
        }

        .login_wrapper .login_wrapper_left .logo {
            margin-bottom: 14px;
            text-align: center;
        }

        .custom_group_field {
            border-bottom: none;
        }

        .login_wrapper {
            height: auto;
        }

        .login_wrapper_right {
            width: 874px !imporatnt;
        }

        #msform fieldset .form-card {
            text-align: left;
            color: #9E9E9E;
            padding-left: 5px;
            padding-right: 5px;
        }

        .login_wrapper .login_wrapper_left .logo {
            margin-bottom: 14px;
            text-align: left;
        }

        #msform input,
        #msform textarea {
            padding: 0px 8px 4px 8px;
            border: none;
            border-bottom: 2px solid #203369;
            border-radius: 0px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            color: #7088D0;
            font-size: 16px;
            letter-spacing: 1px;
            background-color: transparent;
            font-family: Jost, sans-serif;

        }

        .small_select .current {
            font-family: Open Sans;
            font-size: 16px;
            font-weight: 400;
            color: #7088D0;
            line-height: 30px;
            font-family: Jost, sans-serif;
        }

        input.form-control::placeholder {
            color: #7088d0;
            font-size: 18px;
        }

        .form-control {
            -webkit-box-shadow: inset 0 0px 0px rgb(0 0 0 / 8%) !important;
            box-shadow: inset 0 0px 0px rgb(0 0 0 / 8%) !important;
        }

        .custom_group_field input:focus {
            outline: none;
            background-color: transparent;
            color: #7088d0;
        }

        .primary_checkbox .checkmark {
            border-color: #1C2F67;
        }

        .primary_checkbox p {
            margin-top: 10px;
        }

        .chf h2 {
            color: #1C2F67;
            font-size: 40px;
            text-align: left;
            font-weight: bold;
        }

        span.cco {
            color: #EE4E22;
        }

        .chf p {
            text-align: left;
            font-size: 18px;
            color: #1C2F67;
            padding-bottom: 10px;
            padding-left: 3px;
        }

        .login_wrapper .login_wrapper_left .shitch_text a {
            color: red;
        }

        #progressbar #account:before {
            display: none;
        }

        #account strong {
            margin-top: 34px;
            float: left;
            text-align: center;
            width: 100%;
            color: #1C2F67;
            font-size: 16px;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #1C2F67;

        }

        #progressbar #personal:before {
            display: none;
        }

        #personal strong {
            margin-top: 34px;
            float: left;
            text-align: center;
            width: 100%;
            color: #1C2F67;
        }

        h5.mr_10.font_15.f_w_500.mb-0 {
            color: #1C2F67;
        }

        .small_select {
            border: 1px solid #e9e7f7 !important;
            height: 30px;
            min-width: 95px;
            line-height: 30px;
            border: none !important;
            background-color: transparent;
            border-bottom: 2px solid #1C2F67 !important;
            border-radius: 0;
            color: #BBE8FF;
            font-weight: bold;
        }

        input#dob {
            border: none !important;
            float: left;
            width: 100%;
            margin: 0;
            border-radius: 0;
            border-bottom: 2px solid #1C2F67 !important;
            padding: 0px 8px 4px 18px;
            background-color: transparent;
            color: #7088d0;
        }

        span.input-group-addon {
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #1C2F67;
            border-radius: 0;
        }

        i.glyphicon.glyphicon-calendar {
            color: #1C2F67;
        }

        li.option {
            color: #7088d0;
        }

        .nice-select.open .list {
            opacity: 1;
            pointer-events: auto;
            max-height: 400px;
            overflow-y: scroll;
            transform: scale(1) translateY(0);
            max-height: 250px;
        }

        .login_wrapper_content {
            background-color: white;
            border-radius: 5px;
            float: left;
        }

        #progressbar li:after {
            z-index: 1
        }

        .login_wrapper .login_wrapper_left .login_wrapper_content {
            padding-bottom: 20px;
        }

        .login_wrapper_content .row {
            margin: 0;
            float: left;
            width: 100%
        }

        #msform .action-button {
            width: 94%;
            background: #465584;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 0;
            font-size: 24px;
        }

        #msform .action-button-previous {
            width: 93%;
            background: #465584;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
            font-size: 24px;
            margin-top: 35px;
        }
    </style>

    <div class="login_wrapper" style="overflow-y: hidden; ">
        <div class="col-lg-12 login_wrapper_left" style="overflow-y: hidden; ">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 250px" src="{{ asset(Settings('logo')) }} " alt="">
                </a>
            </div>

            <div class="login_wrapper_content">
                <form action="{{ route('register') }}" method="POST" id="msform">
                    @csrf

                    <div class="row">
                        <ul id="progressbar">
                            <li class="active" id="account">
                                <strong>Account Information</strong>
                            </li>

                            <li class="active" id="personal">
                                <strong>Personal Information</strong>
                            </li>
                        </ul>

                        <fieldset>
                            <input type="hidden" class="form-control pl-0" placeholder="{{ __('student.Enter Full Name') }} {{ $custom_field->required_company ? '*' : '' }}" {{ $custom_field->required_name ? '' : '' }} aria-label="Username" name="name" value="{{ $register->name ?? '' }}">
                            <input type="hidden" class="form-control pl-0" placeholder="{{ __('common.Enter Email') }} *" aria-label="email" name="email" value="{{ $register->email ?? '' }}">
                            <input type="hidden" class="form-control pl-0" placeholder="{{ __('frontend.Enter Password') }} *" aria-label="password" name="password" value="{{ $register->password ?? '' }}">

                            <div class="form-card">
                                <div class="col-12 text-center chf">
                                    <h2>Tell us about yourself.</h2>
                                    <p> Your details are essential to understand your needs and provide you with a better experience.</p>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Citizenship</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100 citizenship" name="citizenship">
                                                    <option value="">Select Citizenship</option>
                                                    <option value="Malaysian">Malaysian</option>
                                                    <option value="Non-Malaysian">Non-Malaysian</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('citizenship') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 nationalitydiv" style="display:none">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Nationality</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100 nationality" name="nationality">
                                                    @if (isset($countries))
                                                        @foreach ($countries as $country)
                                                            <option value="{{ @$country->id }}">{{ @$country->name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('citizenship') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 racediv">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Race</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100 race" name="race">
                                                    <option value="">Select Race</option>
                                                    <option value="Malay" @if (old('race') == 'Malay') {{ 'selected' }} @endif>Malay </option>
                                                    <option value="Chinese" @if (old('race') == 'Chinese') {{ 'selected' }} @endif> Chinese</option>
                                                    <option value="Indian" @if (old('race') == 'Indian') {{ 'selected' }} @endif>Indian </option>
                                                    <option value="Others" @if (old('race') == 'Others') {{ 'selected' }} @endif>Others </option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('race') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt_20" id="race_other" style="display: none;">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <h5 class="mr_10 font_15 f_w_500 mb-0"> Race Other</h5>
                                        </div>

                                        <div class="col-xl-8">
                                            <div class="input-group custom_group_field">
                                                <input type="text" class="form-control pl-0" placeholder="Race Other" aria-label="race_other" name="race_other" value="{{ old('race_other') }}">

                                                <span class="text-danger" role="alert">{{ $errors->first('race_other') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 racediv">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> NRIC Number</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <input type="text" class="form-control chinputn pl-0" placeholder="NRIC Number" onkeypress="javascript:return isNumber(event)" id="identification_number" name="identification_number" value="{{ old('identification_number') }}">

                                                <span class="text-danger" role="alert">{{ $errors->first('identification_number') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Date Of Birth </h5>
                                            </div>

                                            <style type="text/css">
                                                label {
                                                    margin-left: 20px;
                                                }

                                                #dob>span:hover {
                                                    cursor: pointer;
                                                }

                                                #datepickernn>span:hover {
                                                    cursor: pointer;
                                                }

                                                input#dob {
                                                    float: left;
                                                    width: 100%;
                                                    margin: 0;

                                                }

                                                .iti {
                                                    width: 100%;
                                                    margin: 0;
                                                }

                                                input.form-control.flag-with-code.input-phone {
                                                    border-top: none !important;
                                                    box-shadow: none;
                                                    border: none !important;
                                                    border-bottom: 2px solid #1C2F67 !important
                                                }
                                            </style>

                                            <div class="col-xl-8 ">
                                                <div id="datepickernn" class="input-group date" data-date-format="dd/mm/yyyy">
                                                    <input id="dob" type="text" class="form-control datepicker" autocomplete="off" placeholder="Birth Date" data-date-format="dd/mm/yyyy" {{ $custom_field->required_dob ? '' : '' }} aria-label="Username" name="dob" value="{{ old('dob') }}">

                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>

                                                    <span class="text-danger" role="alert">{{ $errors->first('dob') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0">{{ __('common.choose_gender') }} {{ $custom_field->required_gender ? '*' : '' }}</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="gender"
                                                    {{ $custom_field->required_gender ? 'selected' : '' }}>

                                                    <option value="">Select Gender</option>
                                                    <option value="male" @if (old('gender') == 'male') {{ 'selected' }} @endif>Male </option>
                                                    <option value="female" @if (old('gender') == 'female') {{ 'selected' }} @endif>Female </option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('gender') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Phone Number </h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <input type="text" class="form-control flag-with-code input-phone" placeholder="{{ __('Enter Mobile Number') }} {{ $custom_field->required_phone ? '*' : '' }}" {{ $custom_field->required_phone ? '' : '' }} aria-label="phone" name="phone" value="{{ old('phone') }}" onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9" autocomplete="off" style="padding-left:50px">

                                                <span class="text-danger" role="alert">{{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" class="country_code" name="country_code" id="country_code" />

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Employment Status</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="employment_status" id="employment_status">
                                                    <option value="">Select Employment Status</option>
                                                    <option value="working">Working</option>
                                                    <option value="not-working">Not Working</option>
                                                    <option value="self-employed">Self Employed</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('employment_status') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12" id="job_designation">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Job Designation</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="job_designation">
                                                    <option value="">Select Job Designation</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="Professional">Professional</option>
                                                    <option value="Technician and Associate Professional">Technician and Associate Professional</option>
                                                    <option value="Clerical Support Worker">Clerical Support Worker </option>
                                                    <option value="Service and Sale Worker">Service and Sale Worker
                                                    </option>
                                                    <option value="Skilled Agricultural,Forestry and Fishery Worker"> Skilled Agricultural,Forestry and Fishery Worker</option>
                                                    <option value="Craft and Related Trade Worker">Craft and Related Trade Worker</option>
                                                    <option value="Elementary Worker">Elementary Worker</option>
                                                    <option value="Plant and Machine Operator and Assembler Worker">Plant and Machine Operator and Assembler Worker</option>
                                                    <option value="Armed Forced Worker">Armed Forced Worker</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('job_designation') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12" id="sector">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Sector</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100 sector" name="sector">
                                                    <option value="">Select Sector</option>
                                                    <option value="Manufacturing">Manufacturing</option>
                                                    <option value="Mining and quarrying">Mining and quarrying</option>
                                                    <option value="Construction">Construction</option>
                                                    <option value="Agriculture">Agriculture</option>
                                                    <option value="Government">Government</option>
                                                    <option value="NGO">NGO</option>
                                                    <option value="Services(eg: Financial Institution, Hospitality, F&B)"> Services(eg: Financial Institution, Hospitality, F&B)</option>
                                                    <option value="Others">Others</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('sector') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt_20" id="sector_other" style="display: none;">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <h5 class="mr_10 font_15 f_w_500 mb-0"> Sector Other</h5>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="input-group custom_group_field">
                                                <input type="text" class="form-control pl-0" placeholder="Sector Other" aria-label="sector_other" name="sector_other" value="{{ old('sector_other') }}">

                                                <span class="text-danger" role="alert">{{ $errors->first('sector_other') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12" style="display:none" id="business_nature">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Business Nature/Activity</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select business_nature w-100" name="business_nature">
                                                    <option value="">Select a Business Nature</option>
                                                    <option value="Accomodation/Food Beverage service Activities"> Accomodation/Food Beverage service Activities</option>
                                                    <option value="Agriculture/Forestry/Fishing"> Agriculture/Forestry/Fishing</option>
                                                    <option value="Arts/Entertainment/Recreation/Construction"> Arts/Entertainment/Recreation/Construction</option>
                                                    <option value="Education">Education</option>
                                                    <option value="Electricity/Gas/Steam/Air conditioning Supply"> Electricity/Gas/Steam/Air conditioning Supply</option>
                                                    <option value="Financial/Insurance/Takaful activities"> Financial/Insurance/Takaful activities</option>
                                                    <option value="Human Health/Social Work Activities">Human Health/Social Work Activities</option>
                                                    <option value="Information/Communication">Information/Communication </option>
                                                    <option value="Manufacturing">Manufacturing</option>
                                                    <option value="Mining/Quarrying">Mining/Quarrying</option>
                                                    <option value="Professional/Scientific/Technical Activities"> Professional/Scientific/Technical Activities</option>
                                                    <option value="Public Administration/Defence/Compulsory Social Security"> Public Administration/Defence/Compulsory Social Security</option>
                                                    <option value="Real Estate Activities">Real Estate Activities</option>
                                                    <option value="Transportation/Storage">Transportation/Storage</option>
                                                    <option value="Water Supply/Sewage/Waste Management/Remediation Activities"> Water Supply/Sewage/Waste Management/Remediation Activities</option>
                                                    <option value="Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles"> Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles</option>
                                                    <option value="Others">Others</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('business_nature') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt_20" id="business_nature_other" style="display: none;">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <h5 class="mr_10 font_15 f_w_500 mb-0"> Business Nature Other</h5>
                                        </div>

                                        <div class="col-xl-8">
                                            <div class="input-group custom_group_field">
                                                <input type="text" class="form-control pl-0" placeholder="Business Nature Other" aria-label="business_nature_other" name="business_nature_other" value="{{ old('business_nature_other') }}">

                                                <span class="text-danger" role="alert">{{ $errors->first('business_nature_other') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12" style="display:none" id="not_working">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Not Working Status</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="not_working">
                                                    <option value="">Select Not Working Status</option>
                                                    <option value="Student">Student</option>
                                                    <option value="Fresh Graduate">Fresh Graduate</option>
                                                    <option value="Retrenched">Retrenched</option>
                                                    <option value="Retired">Retired</option>
                                                    <option value="Home Worker/House Wife">Home Worker/House Wife</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('not_working') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Highest Academic Qualification</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="highest_academic">
                                                    <option value="">Select Highest Academic Qualification</option>
                                                    <option value="Primary School">Primary School</option>
                                                    <option value="Secondary School">Secondary School</option>
                                                    <option value="SPM/O-Level/SVM/equivalent">SPM/O-Level/SVM/equivalent </option>
                                                    <option value="STPM/A-Level/Diploma/equivalent"> STPM/A-Level/Diploma/equivalent</option>
                                                    <option value="Bachelor's Degree/equivalent">Bachelor's Degree/equivalent</option>
                                                    <option value="Master's Degree/equivalent">Master's Degree/equivalent </option>
                                                    <option value="Doctoral Degree">Doctoral Degree</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('highest_academic') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="short_select mt-3">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <h5 class="mr_10 font_15 f_w_500 mb-0"> Current Residing State</h5>
                                            </div>

                                            <div class="col-xl-8">
                                                <select class="small_select w-100" name="current_residing">
                                                    <option value="">Select Current Residing State</option>
                                                    <option value="Kuala Lumpur" @if (old('current_residing') == 'Kuala Lumpur') {{ 'selected' }} @endif>Kuala Lumpur</option>
                                                    <option value="Selangor" @if (old('current_residing') == 'Selangor') {{ 'selected' }} @endif> Selangor</option>
                                                    <option value="Putrajaya" @if (old('current_residing') == 'Putrajaya') {{ 'selected' }} @endif> Putrajaya</option>
                                                    <option value="Labuan" @if (old('current_residing') == 'Labuan') {{ 'selected' }} @endif> Labuan</option>
                                                    <option value="Sabah" @if (old('current_residing') == 'Sabah') {{ 'selected' }} @endif> Sabah</option>
                                                    <option value="Sarawak" @if (old('current_residing') == 'Sarawak') {{ 'selected' }} @endif> Sarawak</option>
                                                    <option value="Melaka" @if (old('current_residing') == 'Melaka') {{ 'selected' }} @endif> Melaka</option>
                                                    <option value="Kelantan" @if (old('current_residing') == 'Kelantan') {{ 'selected' }} @endif> Kelantan</option>
                                                    <option value="Pahang" @if (old('current_residing') == 'Pahang') {{ 'selected' }} @endif> Pahang</option>
                                                    <option value="Perak" @if (old('current_residing') == 'Perak') {{ 'selected' }} @endif> Perak</option>
                                                    <option value="Pulau Pinang" @if (old('current_residing') == 'Pulau Pinang') {{ 'selected' }} @endif> Pulau Pinang</option>
                                                    <option value="Negeri Sembilan" @if (old('current_residing') == 'Negeri Sembilan') {{ 'selected' }} @endif> Negeri Sembilan</option>
                                                    <option value="Kedah" @if (old('current_residing') == 'Kedah') {{ 'selected' }} @endif> Kedah</option>
                                                    <option value="Perlis" @if (old('current_residing') == 'Perlis') {{ 'selected' }} @endif> Perlis</option>
                                                    <option value="Johor" @if (old('current_residing') == 'Johor') {{ 'selected' }} @endif> Johor</option>
                                                    <option value="Terengganu" @if (old('current_residing') == 'Terengganu') {{ 'selected' }} @endif> Terengganu</option>
                                                </select>

                                                <span class="text-danger" role="alert">{{ $errors->first('current_residing') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <h5 class="mr_10 font_15 f_w_500 mb-0"> Postcode</h5>
                                        </div>

                                        <div class="col-xl-8">
                                            <div class="input-group custom_group_field">
                                                <input type="text" class="form-control chinputn pl-0" placeholder="Postcode" onkeypress="javascript:return isNumber(event)" aria-label="business_nature_other" name="zip" value="{{ old('zip') }}">

                                                <span class="text-danger" role="alert">{{ $errors->first('zip') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('register') }}">
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                            </a>

                            <input type="submit" name="submit" class="action-button" value="Create Account" id="btn_submit" />
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('frontend/elatihlmstheme/css/register/assets/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/elatihlmstheme/css/register/assets/bootstrap-datepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#dob").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());

            $("#datepickernn").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $(document).on('submit', '#msform', function() {
            $('#btn_submit').prop('disabled', true);
        });

        $('.input-phone').keyup(function() {
            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
            var countryCode = countryCode.replace(/[^0-9]/g, '')

            $('.country_code').val("");
            $('.country_code').val("+" + countryCode);
        });

        $('#employment_status').change(function() {
            if ($(this).val() == 'working') {
                $('#job_designation').show();
                $('#sector').show();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else if ($(this).val() == 'not-working') {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').show();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else if ($(this).val() == 'self-employed') {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').show();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            }
        });

        $('.business_nature').change(function() {
            if ($(this).val() == 'Others') {
                $('#business_nature_other').show();
            } else {
                $('#business_nature_other').hide();
            }
        });

        $('.sector').change(function() {
            if ($(this).val() == 'Others') {
                $('#sector_other').show();
            } else {
                $('#sector_other').hide();
            }
        });

        $('.race').change(function() {
            if ($(this).val() == 'Others') {
                $('#race_other').show();
            } else {
                $('#race_other').hide();
            }
        });

        $(function() {
            $('#checkbox').click(function() {

                if ($(this).is(':checked')) {
                    $('#submitBtn').removeClass('disable_btn');
                    $('#submitBtn').removeAttr('disabled');

                } else {
                    $('#submitBtn').addClass('disable_btn');
                    $('#submitBtn').attr('disabled', 'disabled');

                }
            });
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy'
        });

        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode

            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
                return false;
            }

            return true;
        }
    </script>

    <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}">
    </script>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />

    <script>
        const phoneInputField = document.querySelector(".input-phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            preferredCountries: ["my"],
            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
        });
    </script>
@endsection

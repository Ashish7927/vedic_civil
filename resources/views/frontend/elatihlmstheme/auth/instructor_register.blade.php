@extends(theme('auth.layouts.app'))
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/elatihlmstheme/css/register/assets/bootstrap.min-2.css')}}">
<script type="text/javascript" src="{{asset('frontend/elatihlmstheme/css/register/assets/bootstrap.bundle.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('frontend/elatihlmstheme/css/register/assets/font-awesome.css')}}">
<script src="{{asset('js/intlInputPhone.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/intlInputPhone.min.css')}}">
<style>
    body {
        {{-- background: url('{{ asset('uploads/images/') }}/23-12-2021/registration-bg.png')  fixed; --}}
        background-repeat: no-repeat;
        background-position:right top ;
        background-size: 1180px 100%;
    }
    .image_eye{
        max-height: 13px!important;
        margin-top: 14px!important;
        max-width: 5%!important;
    }
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    	font-family: Jost,sans-serif;
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

        padding:20px 40px 0px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 0px 3%;
        position: relative
    }

    #msform fieldset {

        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative;
    	font-family: Jost,sans-serif;
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
        font-family: montserrat;
        color: #9CACDE;
        font-size: 16px;
        letter-spacing: 1px
    	font-family: Jost,sans-serif;
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0;
    	font-family: Jost,sans-serif;
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
    	font-family: Jost,sans-serif;
    }
    .login_wrapper .login_wrapper_left .shitch_text {
        font-size: 16px;
        font-weight: 500;
        color: #465584;
        text-align: center;
    	font-family: Jost,sans-serif;
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
    }

    #msform .action-button-previous {
        width: 100%;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
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
        font-size: 18px;
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
    .login_wrapper{
        height: auto;
    }
    .login_wrapper_right{width:874px!imporatnt;}

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
    #msform input, #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 2px solid #203369;
        border-radius: 0px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #9cacde;
        font-size: 16px;
        letter-spacing: 1px;
        background-color: transparent;
        padding-left: 10px!important;
    	font-family: Jost,sans-serif;
    }
    input.form-control::placeholder{
    color: #7088d0;
    font-size: 18px;


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
    	padding-bottom:20px;
    	padding-left:3px;
    }

    .login_wrapper .login_wrapper_left .shitch_text a {
        color: red;
    }
    #progressbar #account:before{display: none;}
    #account strong {
        margin-top: 34px;
        float: left;
        text-align: center;
        width: 100%;
        color: #1C2F67;
    }
    #progressbar li.active:before, #progressbar li.active:after {
        background: #1C2F67;
    }
    #progressbar #personal:before{display: none;}

    #personal strong{
        margin-top: 34px;
        float: left;
        text-align: center;
        width: 100%;
        color: #1C2F67;
    }

    /* @media only screen and (max-width: 1600px){ body {    background-size: 100% 100%!important;}}
    @media only screen and (max-width: 900px){ body {    background-size: 780px 100%!important;}}
    @media only screen and (max-width: 768px){ body {    background-image:none!important;}} */


    .login_wrapper_content{background-color: white; border-radius: 5px; float: left;}
    #progressbar li:after{z-index: 1}
    .login_wrapper .login_wrapper_left .login_wrapper_content {
        padding-bottom: 20px;
    }
    .login_wrapper_content .row{margin: 0; float: left;width: 100%}
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
    }
</style>

    <div class="login_wrapper" style="overflow-y: hidden; width: 100%;">
        <div class="col-lg-12 login_wrapper_left" style="overflow-y: hidden; ">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 250px" src="{{asset(Settings('logo') )}} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">
                <form action="{{route('registerone')}}" method="POST" id="msform">
                    @csrf
                    <input type="hidden" name="role_id" value="2">
                    <div class="row">
                            {{-- <ul id="progressbar">
                                <li class="active" id="account"><strong>{{__('common.Account Information')}}</strong></li>
                                <li  id="personal"><strong>{{__('common.Personal Information')}}</strong></li>
                            </ul> --}}
                        <fieldset>
                            <div class="form-card">
                                <div class="col-12 text-center chf">
                                    <h2>Welcome to <span class="cco">e-LATiH</span></h2>
                                    {{-- <p>Capture your details below and start learning.</p> --}}
                                </div>
                                <div class="col-12">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0"
                                       placeholder="{{__('student.Enter Full Name')}}" aria-label="Username"
                                       name="name" value="{{ $register->name ?? old('name') }}">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="Co Id" aria-label="my_co_id" name="my_co_id" value="{{ $register->my_co_id ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('my_co_id')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="IC number for trainer" aria-label="ic_no_for_trainer" name="ic_no_for_trainer" value="{{ $register->ic_no_for_trainer ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('ic_no_for_trainer')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="TTT certificate" aria-label="ttt_certificate" name="ttt_certificate" value="{{ $register->ttt_certificate ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('ttt_certificate')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="TTT exemption" aria-label="ttt_exemption" name="ttt_exemption" value="{{ $register->ttt_exemption ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('ttt_exemption')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="number" class="form-control pl-0" placeholder="Contact Number" aria-label="phone" name="phone" value="{{ $register->phone ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="email" class="form-control pl-0"
                                               placeholder="{{__('common.Enter Email')}} *" aria-label="email" name="email"
                                               value="{{ $register->email ?? old('email') }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="email" class="form-control pl-0"
                                               placeholder="{{__('common.confirm_email')}} *" aria-label="email_confirmation" name="email_confirmation"
                                               value="{{ $register->email ?? '' }}" autocomplete="off">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('email_confirmation')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field" style="border-bottom: 2px solid #203369;">
                                        <input type="password" class="form-control pl-0" id="password"
                                               placeholder="{{__('frontend.Enter Password')}} *"
                                               aria-label="password" name="password" value="{{ $register->password ?? '' }}" autocomplete="off" style="max-width: 95%;border-bottom: none;">
                                        <img src="{{ asset('images/eye.png') }}" class="hide_show_pass image_eye">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                                </div>
                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field" style="border-bottom: 2px solid #203369;">
                                        <input type="password" class="form-control pl-0" id="c_password"
                                               placeholder="{{__('common.Enter Confirm Password')}} *"
                                               name="password_confirmation" aria-label="password_confirmation" value="{{ $register->password ?? '' }}" autocomplete="off" style="max-width: 95%;border-bottom: none;">
                                        <img src="{{ asset('images/eye.png') }}" class="hide_show_conf_pass image_eye">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('password_confirmation')}}</span>
                                </div>
                                <div class="col-12 mt_20">
                                    @if(config('captcha.for_login'))

                                        @if(config('captcha.is_invisible'))
                                            {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                                        @else
                                            {!! NoCaptcha::display() !!}
                                        @endif

                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger"
                                                  role="alert">{{$errors->first('g-recaptcha-response')}}</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-12 mt_20">
                                    <div class="remember_forgot_passs d-flex align-items-center">
                                        <label class="primary_checkbox d-flex" for="checkbox">
                                            <input name="checkbox" type="checkbox" id="checkbox">

                                            <span class="checkmark mr_15"></span>
                                            <p>I have read and agree to e-LATiH <a href="{{asset('pages/privacy-policy-and-cookie-policy')}}" target=_blank>Privacy Policy</a> and <a href="{{asset('pages/terms-of-use')}}" target=_blank>Terms of Use</a>.</p>
                                        </label>

                                    </div>

                                        <span class="text-danger" role="alert">{{$errors->first('checkbox')}}</span>
                                </div>
                            </div>
                            <input type="submit" class="action-button" value="Continue" />
                        </fieldset>
                    </div>
                </form>
                <h5 class="shitch_text">
                {{__('common.You have already an account?')}} <a href="{{route('login')}}"> {{__('common.Login')}}</a>

            </h5>
            </div>



        </div>



    </div>
    <script>
        $('#employment_status').change(function(){
            if($(this).val() == 'Working'){
                $('#job_designation').show();
                $('#sector').show();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
            }else if($(this).val() == 'Not Working'){
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').show();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
            }else if($(this).val() == 'Self Employeed'){
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').show();
                 $('#business_nature_other').hide();
            }else{
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').hide();
                 $('#business_nature_other').hide();
            }
        });
        $('.business_nature').change(function(){
            if($(this).val() == 'Others'){
            $('#business_nature_other').show();
        }else{
            $('#business_nature_other').hide();
        }
        });


        /*$('.citizenship').change(function(){
            if($(this).val() == '132'){
                $('.race').show();
            }else{
                $('.race').hide();
            }
        });
*/
        $('.input-phone').intlInputPhone();

    </script>
    <script>
  function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }

    $(document).on('click','.hide_show_pass',function(){
        if($('#password').is("[type=password]"))
        {
            $("#password").prop("type", "text");
            $(this).attr("src","{{ asset('images/eye_slash.png') }}");
            // $(this).addClass('fa-eye-slash');
            // $(this).removeClass('fa-eye');
        }else{
            $("#password").prop("type", "password");
            $(this).attr("src","{{ asset('images/eye.png') }}");
            // $(this).removeClass('fa-eye-slash');
            // $(this).addClass('fa-eye');
        }
    })
    $(document).on('click','.hide_show_conf_pass',function(){
        if($('#c_password').is("[type=password]"))
        {
            $("#c_password").prop("type", "text");
            $(this).attr("src","{{ asset('images/eye_slash.png') }}");
            // $(this).addClass('fa-eye-slash');
            // $(this).removeClass('fa-eye');
        }else{
            $("#c_password").prop("type", "password");
            $(this).attr("src","{{ asset('images/eye.png') }}");
            // $(this).removeClass('fa-eye-slash');
            // $(this).addClass('fa-eye');
        }
    })
</script>


@endsection

@extends(theme('auth.layouts.app'))
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/elatihlmstheme/css/register/assets/font-awesome.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('frontend/elatihlmstheme/css/register/assets/bootstrap.min-2.css')}}">
<script type="text/javascript" src="{{asset('frontend/elatihlmstheme/css/register/assets/bootstrap.bundle.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('css/intlInputPhone.min.css')}}">
<script src="{{ asset('js/toastr.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}"> --}}
<style>
    body {
        background: url('{{ asset('uploads/images/') }}/23-12-2021/login-bg-1.jpg')  fixed;
        background-repeat: no-repeat;
        background-position:right top ;
        background-size: 100% 100%;
    }
    .image_eye{
        max-height: 13px!important;
        margin-top: 14px!important;
        max-width: 5%!important;
    }
    /*#msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    	font-family: Jost,sans-serif;
    }*/

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

    /*#msform fieldset .form-card {

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
    }*/

    /*#msform input,*/
    /*#msform textarea {
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
    }*/

    /*#msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0;
    	font-family: Jost,sans-serif;
    }*/

    /*#msform .action-button {
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
    }*/
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

    /*#msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E;
        padding-left: 5px;
        padding-right: 5px;
    }*/
    .login_wrapper .login_wrapper_left .logo {
        margin-bottom: 14px;
        text-align: left;
    }
    /*#msform input, #msform textarea {
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
    }*/
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
        width: 100%;
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

    /*Login*/
    .login_wrapper {
        justify-content: center;
        float: left;
    }
    .login_wrapper .login_wrapper_left .login_wrapper_content {
        padding-bottom: 20px;
        background-color: #FFF;
        padding: 25px;
        box-shadow: 0px 0px 10px #111;
        border-radius: 25px;
        max-width: 609px;
    }
    .login_wrapper .login_wrapper_left .logo {
        margin-bottom: 50px;
    }
    .login_wrapper .login_wrapper_left .login_wrapper_content h4 {

        font-size: 40px;
        color: #1C2F67;
    }
    .primary_checkbox .checkmark {
        border-color: #1C2F67;
    }

    input.form-control {
        background-color: transparent;
        font-size: 18px;
        color: #7088d0;
    }
    .custom_group_field {
        border-bottom: 5px solid #1C2F67;
    }
    .login_wrapper .login_wrapper_left .login_wrapper_content .remember_forgot_pass .forgot_pass {
        font-size: 17px;
        font-weight: 500;
        color: #1c2f67;
        font-family: Open Sans;
    }
    .login_wrapper .login_wrapper_left .login_wrapper_content .remember_forgot_pass .primary_checkbox .label_name {
        font-size: 17px;
        color:#1c2f67;
    }
    .primary_checkbox{padding-top: 9px;}
    .login_wrapper .login_wrapper_left .shitch_text {
        font-size: 14px;
        font-weight: 500;
        color: #373737;
        text-align: center;
        width: 100%;
        margin-top: 17px;
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
    .input-group-prepend {
        margin-right: -1px;
        padding-left: 18px;
    }

    button.theme_btn.text-center.w-100 {
        background-color: #1C2F67;
        border-radius: 0;
        font-size: 28px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .modal-body{font-size:18px;}
    .modal.show .modal-dialog {top:30%;}
    @media only screen and (max-width: 500px){
        .remember_forgot_pass.d-flex.justify-content-between {
        display: block!important;
        }
        .login_wrapper .login_wrapper_left .login_wrapper_content .remember_forgot_pass {
            align-items: center;
            margin-bottom: 25px;
        }
    }
    .login_wrapper .login_wrapper_left .login_wrapper_content h4{margin-bottom:20px;}
    .login-text{margin-bottom:20px;margin-left: 3px;color:#F1592A;}
</style>
<style type="text/css">
    .loading-spinner {
        display: none;
    }

    .loading-spinner.active {
        display: inline-block;
    }
</style>

    <div class="login_wrapper" style="overflow-y: hidden; ">
        <div class="login_wrapper_left" style="height:1000px;overflow-y: hidden; ">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 250px" src="{{asset(Settings('logo') )}} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">
                <h4>Content Provider Login </h4>
                <div class="login-text">Please use your eTris credentials (MYCO_ID and password) to login. </div>
                <div class="socail_links">

                    @if(config('social.allowFacebook'))

                        <a href="{{ route('social.oauth', 'facebook') }}"
                           class="theme_btn small_btn2 text-center facebookLoginBtn">
                            <i class="fab fa-facebook-f"></i>
                            {{__('frontend.Login with Facebook')}}</a>
                    @endif
                    @if(config('social.allowGoogle'))

                        <a href="{{ route('social.oauth', 'google') }}"
                           class="theme_btn small_btn2 text-center googleLoginBtn">
                            <i class="fab fa-google"></i>
                            {{__('frontend.Login with Google')}}</a>
                    @endif
                </div>
                @if(config('social.allowFacebook')  || config('social.allowGoogle'))
                    <p class="login_text">{{__('frontend.Or')}} {{__('frontend.login with Email Address')}}</p>
                @endif

                <form method="POST" id="msform">
                    @csrf
                    <input type="hidden" name="role_id" value="7">
                    <div class="row">
                        <fieldset style="width: 100%;">
                            <div class="form-card">
                                {{-- <div class="col-12 text-center chf mb-5">
                                    <h2>Welcome to <span class="cco">e-LATiH</span></h2>
                                </div> --}}
                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="MyCoID" aria-label="Username" name="username" id="username" value="{{ $register->username ?? old('username') }}" required>
                                    </div>
                                    <span class="text-danger username_error" role="alert">{{$errors->first('username')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field" style="border-bottom: 2px solid #203369;">
                                        <input type="password" class="form-control pl-0" id="password" placeholder="{{__('frontend.Enter Password')}} *" aria-label="password" name="password" value="{{ $register->password ?? '' }}" autocomplete="off" style="max-width: 95%;border-bottom: none;" required>
                                        <img src="{{ asset('images/eye.png') }}" class="hide_show_pass image_eye">
                                    </div>
                                    <span class="text-danger password_error" role="alert">{{$errors->first('password')}}</span>
                                </div>
                                {{-- <div class="col-12 mt_20">
                                    <div class="remember_forgot_passs d-flex align-items-center">
                                        <label class="primary_checkbox d-flex" for="checkbox">
                                            <input name="checkbox" type="checkbox" id="checkbox">

                                            <span class="checkmark mr_15"></span>
                                            <p>I have read and agree to e-LATiH <a href="{{asset('pages/privacy-policy-and-cookie-policy')}}" target=_blank>Privacy Policy</a> and <a href="{{asset('pages/terms-of-use')}}" target=_blank>Terms of Use</a>.</p>
                                        </label>
                                    </div>
                                    <span class="text-danger checkbox_error" role="alert">{{$errors->first('checkbox')}}</span>
                                </div> --}}
                                <div class="col-12 mt_20">
                                    <span class="text-danger common_error" role="alert"></span>
                                </div>
                            </div>


                            <div class="col-12 mt_20">
                                @if(config('captcha.for_reg'))

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

                            <div class="col-12">
                                @if(config('captcha.is_invisible')=="true")
                                    <button type="button" class="g-recaptcha theme_btn text-center w-100"
                                            data-sitekey="{{config('captcha.sitekey')}}" data-size="invisible"
                                            data-callback="onSubmit"
                                            class="theme_btn text-center w-100">
                                            <span class="submit_btn_text">Continue</span>
                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                    </button>
                                    <button type="button" id="submit_cp" style="display: none"></button>
                                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                    <script>
                                        function onSubmit(token) {
                                            document.getElementById("submit_cp").click();
                                        }
                                    </script>
                                @else

                                    <button type="button" class="action-button" id="submit_cp">
                                        <span class="submit_btn_text">Continue</span>
                                        <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>

        </div>
    </div>
    {{-- <div class="login_wrapper" style="overflow-y: hidden; width: 100%;">
        <div class="col-lg-12 login_wrapper_left" style="overflow-y: hidden; ">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 250px" src="{{asset(Settings('logo') )}} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">

                <form method="POST" id="msform">
                    @csrf
                    <input type="hidden" name="role_id" value="7">
                    <div class="row">
                        <fieldset>
                            <div class="form-card">
                                <div class="col-12 text-center chf mb-5">
                                    <h2>Welcome to <span class="cco">e-LATiH</span></h2>
                                </div>
                                <div class="col-12">
                                    <div class="input-group custom_group_field">
                                        <input type="text" class="form-control pl-0" placeholder="MyCoID" aria-label="Username" name="username" id="username" value="{{ $register->username ?? old('username') }}" required>
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('username')}}</span>
                                </div>

                                <div class="col-12 mt_20">
                                    <div class="input-group custom_group_field" style="border-bottom: 2px solid #203369;">
                                        <input type="password" class="form-control pl-0" id="password" placeholder="{{__('frontend.Enter Password')}} *" aria-label="password" name="password" value="{{ $register->password ?? '' }}" autocomplete="off" style="max-width: 95%;border-bottom: none;" required>
                                        <img src="{{ asset('images/eye.png') }}" class="hide_show_pass image_eye">
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
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

                            <button type="button" class="action-button" id="submit_cp">
                                <span class="submit_btn_text">Continue</span>
                                <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                            </button>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <script>
        $(document).on('click', '#submit_cp', function (e) {
            e.preventDefault();

            let username = $("#username").val();
            let password = $("#password").val();

            let agreement_checkbox = $("#checkbox").is(":checked");
            $(".username_error").text('');
            $(".password_error").text('');
            // $(".checkbox_error").text('');
            $(".common_error").text('');

            if(username == ""){
                // toastr.error('Username is required');
                $(".username_error").text('The username is required');
            }
            else if(password == ""){
                // toastr.error('Password is required');
                $(".password_error").text('The password is required');
            }
            // else if(!agreement_checkbox){
            //     // toastr.error('Agree to Terms and Condition first!!');
            //     $(".checkbox_error").text('Agree to Terms and Condition first');
            // }
            else
            {
              // $('.loading-spinner').toggleClass('active');
              $('.loading-spinner').addClass('active');
                $('.submit_btn_text').text('');
                let url = '{{ route('cp_get_ldap_data') }}';
                $.ajax({
                    url: url,
                    type: "POST",
                    // headers: {
                    //     'Authorization': 'Bearer ' + ldap_token,
                    //     'Accept' : 'application/json'
                    // },
                    data: {
                        username: username,
                        password: password,
                        "_token": "{{ csrf_token() }}",
                        // myco_id: my_co_id,
                    },
                    success: function (response) {
                      //loaderstop();
                        if(response.status == 1)
                        {
                            var data = response.data[0];
                            $.ajax({
                                    url: "{{ route('cp_find') }}",
                                    type: "POST",
                                    data: {
                                        data: data,
                                        password: password,
                                        username: username,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function (response) {
                                        if(response.status == 1)
                                        {
                                            if(response.is_login !== 'undefined' && response.is_login == 1)
                                                var url_href = '{{ route('dashboard') }}';
                                            else
                                                var url_href = '{{ route('changePassword') }}';

                                            $.ajax({
                                                url: "{{ route('login') }}",
                                                type: "POST",
                                                data: {
                                                    email: response.data.email,
                                                    password: password,
                                                    "_token": "{{ csrf_token() }}",
                                                },
                                                success: function (response) {
                                                    loaderstop();
                                                    window.location.href = url_href;
                                                },
                                                error: function (response) {
                                                    // toastr.error('Something went wrong');
                                                    loaderstop();
                                                    $(".common_error").text('Something went wrong');
                                                }
                                            })
                                            .done( function( data ) {
                                                loaderstop();
                                            });
                                        }
                                    },
                                    error: function (response) {
                                        loaderstop();
                                        // toastr.error('Something went wrong');
                                        $(".common_error").text('Something went wrong');
                                    }
                            })
                        }
                        else{
                            loaderstop();
                            // toastr.error(response.message);
                            $(".common_error").text(response.message);
                        }
                    },
                    error: function (response) {
                        // if(response.responseJSON == "username not found, please contact admin."){
                        //     toastr.error(response.responseJSON);
                        // }
                        // else if(typeof response.responseJSON.message !== 'undefined' && response.responseJSON.message){
                        //     toastr.error(response.responseJSON.message);
                        // }
                        // else{
                        // }
                        loaderstop();
                        // toastr.error('Something went wrong');
                        $(".common_error").text('Something went wrong');
                    }
                })
            }
        });

        function loaderstop(){
            $('.submit_btn_text').text('Continue');
            $('.loading-spinner').removeClass('active');
            // $('.loading-spinner').toggleClass('active');
        }

        $(document).on('click','.hide_show_pass',function(){
            if($('#password').is("[type=password]"))
            {
                $("#password").prop("type", "text");
                $(this).attr("src","{{ asset('images/eye_slash.png') }}");
            }else{
                $("#password").prop("type", "password");
                $(this).attr("src","{{ asset('images/eye.png') }}");
            }
        })
        // $(document).on('click','.hide_show_conf_pass',function(){
        //     if($('#c_password').is("[type=password]"))
        //     {
        //         $("#c_password").prop("type", "text");
        //         $(this).attr("src","{{ asset('images/eye_slash.png') }}");
        //     }else{
        //         $("#c_password").prop("type", "password");
        //         $(this).attr("src","{{ asset('images/eye.png') }}");
        //     }
        // })
    </script>


@endsection

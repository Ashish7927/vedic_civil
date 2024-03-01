@extends(theme('auth.layouts.app'))
@section('content')

<style type="text/css">
   body {
    background: url('{{ asset('uploads/images/') }}/23-12-2021/login-bg-1.jpg')  fixed;
    background-repeat: no-repeat;
    background-position:right top ;
    background-size: 100% 100%;
}
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
    <div class="login_wrapper" style="overflow-y: hidden; ">
        <div class="login_wrapper_left" style="height:1000px;overflow-y: hidden; ">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 250px" src="{{asset(Settings('logo') )}} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">
                <h4>Partner Login</h4>
				{{-- <div class="login-text">Please use your eTris credentials (MYCO_ID and password) to login.</div> --}}
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

                <form action="{{route('plogin')}}" method="POST" id="loginForm">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">
                                        <!-- svg -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                             viewBox="0 0 13.328 10.662">
                                            <path id="Path_44" data-name="Path 44"
                                                  d="M13.995,4H3.333A1.331,1.331,0,0,0,2.007,5.333l-.007,8a1.337,1.337,0,0,0,1.333,1.333H13.995a1.337,1.337,0,0,0,1.333-1.333v-8A1.337,1.337,0,0,0,13.995,4Zm0,9.329H3.333V6.666L8.664,10l5.331-3.332ZM8.664,8.665,3.333,5.333H13.995Z"
                                                  transform="translate(-2 -4)" fill="#687083"/>
                                        </svg>
                                        <!-- svg -->
                                    </span>
                                </div>
                                <input type="email" value="{{old('email')}}"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{__('common.Enter Email')}}" name="email" aria-label="Username"
                                       aria-describedby="basic-addon3">
                            </div>
                            @if($errors->first('email'))
                                <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon4">
                                        <!-- svg -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                             viewBox="0 0 10.697 14.039">
                                        <path id="Path_46" data-name="Path 46"
                                              d="M9.348,11.7A1.337,1.337,0,1,0,8.011,10.36,1.341,1.341,0,0,0,9.348,11.7ZM13.36,5.68h-.669V4.343a3.343,3.343,0,0,0-6.685,0h1.27a2.072,2.072,0,0,1,4.145,0V5.68H5.337A1.341,1.341,0,0,0,4,7.017V13.7a1.341,1.341,0,0,0,1.337,1.337H13.36A1.341,1.341,0,0,0,14.7,13.7V7.017A1.341,1.341,0,0,0,13.36,5.68Zm0,8.022H5.337V7.017H13.36Z"
                                              transform="translate(-4 -1)" fill="#687083"/>
                                        </svg>
                                        <!-- svg -->
                                    </span>
                                </div>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="{{__('common.Enter Password')}}" aria-label="password"
                                       aria-describedby="basic-addon4">
                                       {{-- <i class="fab fa-google" style="margin-left: 30px; height: 50px;"></i> --}}
                                       <img src="{{ asset('images/eye.png') }}" class="hide_show_pass" style="max-height: 13px; margin-top: 14px;">
                            </div>
                            @if($errors->first('password'))
                                <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                            @endif
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
                        <div class="col-12 ">
                            {{-- <div class="remember_forgot_pass d-flex justify-content-between">
                                <label class="primary_checkbox d-flex">
                                    <input type="checkbox" name="remember"
                                           {{ old('remember') ? 'checked' : '' }} value="1">
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{__('common.Remember Me')}}</span>
                                </label> --}}
                            <div class="remember_forgot_pass d-flex justify-content-end">
                                <a href="{{route('SendPasswordResetLink')}}"
                                   class="forgot_pass">{{__('common.Forgot Password ?')}}</a>
                            </div>
                        </div> 

                        <div class="col-12">
                            @if(config('captcha.is_invisible')=="true")
                                <button type="button" class="g-recaptcha theme_btn text-center w-100"
                                        data-sitekey="{{config('captcha.sitekey')}}" data-size="invisible"
                                        data-callback="onSubmit"
                                        class="theme_btn text-center w-100"> {{__('common.Login')}}</button>
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <script>
                                    function onSubmit(token) {
                                        document.getElementById("loginForm").submit();
                                    }
                                </script>
                            @else

                                <button type="submit"
                                        class="theme_btn text-center w-100"> {{__('common.Login')}}</button>
                            @endif
                        </div>

                            <!-- @if(Settings('student_reg')==1)
                <h5 class="shitch_text">{{__("frontend.Don’t have an account")}}? <a href="{{route('register')}}">
                        {{__('common.Register')}}
                    </a></h5> -->
            @endif
                    </div>
                </form>
            </div>

            @if(appMode())
                <div class="row mt-4">
                    <div class="col-md-4 mb_10">

                        <a class="theme_btn small_btn2 text-center w-100"
                           href="{{route('auto.login','admin')}}">Admin</a>

                    </div>

                    <div class="col-md-4 mb_10">
                        <a class="theme_btn small_btn2 text-center w-100"
                           href="{{route('auto.login','teacher')}}">Instructor</a>
                    </div>
                    <div class="col-md-4 mb_10">
                        <a class="theme_btn small_btn2 text-center w-100"
                           href="{{route('auto.login','student')}}">Student</a>

                    </div>
                </div>
            @endif
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        For existing e-LATiH user, kindly click on <a href="{{route('SendPasswordResetLink')}}"
                                   class="forgot_pass">Forgot Password</a> to reset password.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@if (session('password'))
<script type="text/javascript">
    $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });


</script>
@endif
    {!! Toastr::message() !!}
<script type="text/javascript">
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
</script>
@endsection

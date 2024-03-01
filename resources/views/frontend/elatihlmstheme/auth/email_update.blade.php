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
                <h4>{{__('Update Email')}} </h4>

                <form action="{{ route('updateEmailSave') }}" method="POST" id="loginForm">
                    @csrf

                    @php $session_data = request()->session()->get('user_data'); @endphp

                    <input type="hidden" name="password" value="{{ $session_data['password'] }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 13.328 10.662">
                                            <path id="Path_44" data-name="Path 44" d="M13.995,4H3.333A1.331,1.331,0,0,0,2.007,5.333l-.007,8a1.337,1.337,0,0,0,1.333,1.333H13.995a1.337,1.337,0,0,0,1.333-1.333v-8A1.337,1.337,0,0,0,13.995,4Zm0,9.329H3.333V6.666L8.664,10l5.331-3.332ZM8.664,8.665,3.333,5.333H13.995Z" transform="translate(-2 -4)" fill="#687083"/>
                                        </svg>
                                    </span>
                                </div>
                                <input type="email" value="{{old('email')}}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{__('Enter New Email')}}" name="email" aria-label="Username" aria-describedby="basic-addon3">
                            </div>

                            @if($errors->first('email'))
                                <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="col-12 mt_20"> </div>

                        <div class="col-12">
                            <button type="submit" class="theme_btn text-center w-100"> {{__('common.Login')}}</button>
                        </div>
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
@endsection

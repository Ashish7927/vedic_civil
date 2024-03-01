@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('backend/css/bbb.css')}}">
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('bbb.Manage')}} {{__('bbb.BigBlueButton Setting')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('bbb.Dashboard')}}</a>
                    <a href="#">{{__('bbb.Setting')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('bbb.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="white-box">
                            <div class="row p-0">
                                <div class="col-lg-12">
                                    <h3 class="text-center">{{__('bbb.Setting')}}</h3>
                                    <hr>


                                    <div class="row mb-40 ">
                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Password Length')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="number" min="1" max="50"
                                                                           name="password_length"
                                                                           id="host_video_on"
                                                                           value="@if(!empty($setting)){{ old('password_length',$setting->password_length)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Welcome Message')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="text" name="welcome_message"
                                                                           value="@if(!empty($setting)){{old('welcome_message',$setting->welcome_message)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Dial Number')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="text" name="dial_number"
                                                                           value="@if(!empty($setting)){{old('dial_number',$setting->dial_number)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Max Participants')}}
                                                        <small class="text-secondary">{{__('bbb.0 means Unlimited')}}</small></p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="number" name="max_participants"
                                                                           min="0"
                                                                           value="@if(!empty($setting)){{ old('max_participants',$setting->max_participants)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Logout Url')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="text" name="logout_url"
                                                                           value="@if(!empty($setting)){{ old('logout_url',$setting->logout_url)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Record')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="record"
                                                                                   id="record_on" value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('record',$setting->record) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="record_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="record"
                                                                                   id="record" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('record',$setting->record) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="record">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Duration')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <input type="number" name="duration"
                                                                           min="0"
                                                                           value="@if(!empty($setting)){{ old('duration',$setting->duration)}}@endif"
                                                                           class="form-control">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Is Breakout')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="is_breakout"
                                                                                   id="is_breakout_on" value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('is_breakout',$setting->is_breakout) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="is_breakout_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="is_breakout"
                                                                                   id="is_breakout" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('is_breakout',$setting->is_breakout) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="is_breakout">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Moderator Only Message')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="">
                                                                            <input type="text"
                                                                                   name="moderator_only_message"
                                                                                   value="@if(!empty($setting)) {{ old('moderator_only_message',$setting->moderator_only_message)}}@endif"
                                                                                   class="form-control">

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Auto Start Recording')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="auto_start_recording"
                                                                                   id="auto_start_recording_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('auto_start_recording',$setting->auto_start_recording) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="auto_start_recording_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="auto_start_recording"
                                                                                   id="auto_start_recording" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('auto_start_recording',$setting->auto_start_recording) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="auto_start_recording">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Allow Start Stop Recording')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="allow_start_stop_recording"
                                                                                   id="allow_start_stop_recording_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('allow_start_stop_recording',$setting->allow_start_stop_recording) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="allow_start_stop_recording_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="allow_start_stop_recording"
                                                                                   id="allow_start_stop_recording"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('allow_start_stop_recording',$setting->allow_start_stop_recording) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="allow_start_stop_recording">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Webcams Only For Moderator')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="webcams_only_for_moderator"
                                                                                   id="webcams_only_for_moderator_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('webcams_only_for_moderator',$setting->webcams_only_for_moderator) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="webcams_only_for_moderator_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="webcams_only_for_moderator"
                                                                                   id="webcams_only_for_moderator"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('webcams_only_for_moderator',$setting->webcams_only_for_moderator) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="webcams_only_for_moderator">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Copyright')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="number" min="1" max="50"
                                                                       name="copyright"
                                                                       value="@if(!empty($setting)){{ old('copyright',$setting->copyright)}}@endif"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Mute On Start')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="mute_on_start"
                                                                                   id="mute_on_start_on" value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('mute_on_start',$setting->mute_on_start) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="mute_on_start_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="mute_on_start"
                                                                                   id="mute_on_start" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('mute_on_start',$setting->mute_on_start) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Disable Mic')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_mic"
                                                                                   id="lock_settings_disable_mic_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_disable_mic',$setting->lock_settings_disable_mic) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_disable_mic_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_mic"
                                                                                   id="lock_settings_disable_mic"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_disable_mic',$setting->lock_settings_disable_mic) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Disable Private Chat')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_private_chat"
                                                                                   id="lock_settings_disable_private_chat_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_disable_private_chat',$setting->lock_settings_disable_private_chat) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_disable_private_chat_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_private_chat"
                                                                                   id="lock_settings_disable_private_chat"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_disable_private_chat',$setting->lock_settings_disable_private_chat) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Disable Public Chat')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_public_chat"
                                                                                   id="lock_settings_disable_public_chat_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_disable_public_chat',$setting->lock_settings_disable_public_chat) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_disable_public_chat_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_public_chat"
                                                                                   id="lock_settings_disable_public_chat"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_disable_public_chat',$setting->lock_settings_disable_public_chat) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="lock_settings_disable_public_chat">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Disable Note')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_note"
                                                                                   id="lock_settings_disable_note_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_disable_note',$setting->lock_settings_disable_note) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_disable_note_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_disable_note"
                                                                                   id="lock_settings_disable_note"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_disable_note',$setting->lock_settings_disable_note) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Locked Layout')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_locked_layout"
                                                                                   id="lock_settings_locked_layout_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_locked_layout',$setting->lock_settings_locked_layout) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_locked_layout_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_locked_layout"
                                                                                   id="lock_settings_locked_layout"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_locked_layout',$setting->lock_settings_locked_layout) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Lock On Join')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_lock_on_join"
                                                                                   id="lock_settings_lock_on_join_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_lock_on_join',$setting->lock_settings_lock_on_join) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_lock_on_join_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_lock_on_join"
                                                                                   id="lock_settings_lock_on_join"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_lock_on_join',$setting->lock_settings_lock_on_join) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Lock Settings Lock On Join Configurable')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_lock_on_join_configurable"
                                                                                   id="lock_settings_lock_on_join_configurable_on"
                                                                                   value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('lock_settings_lock_on_join_configurable',$setting->lock_settings_lock_on_join_configurable) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="lock_settings_lock_on_join_configurable_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio"
                                                                                   name="lock_settings_lock_on_join_configurable"
                                                                                   id="lock_settings_lock_on_join_configurable"
                                                                                   value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('lock_settings_lock_on_join_configurable',$setting->lock_settings_lock_on_join_configurable) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Guest Policy')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="">
                                                                            <select name="guest_policy"
                                                                                    id="guest_policy"
                                                                                    class="form-control">
                                                                                <option value="ALWAYS_ACCEPT"
                                                                                        @if(!empty($setting)) @if($setting->guest_policy=="ALWAYS_ACCEPT") selected @endif @endif>
                                                                                    Always Accept
                                                                                </option>
                                                                                <option value="ALWAYS_DENY"
                                                                                        @if(!empty($setting)) @if($setting->guest_policy=="ALWAYS_DENY") selected @endif @endif>
                                                                                    Always Deny
                                                                                </option>
                                                                                <option value="ASK_MODERATOR"
                                                                                        @if(!empty($setting)) @if($setting->guest_policy=="ASK_MODERATOR") selected @endif @endif>
                                                                                    Ask Moderator
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Redirect')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="redirect"
                                                                                   id="redirect_on" value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('redirect',$setting->redirect) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="redirect_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="redirect"
                                                                                   id="redirect" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('redirect',$setting->redirect) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="logo">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.Join Via Html 5')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="join_via_html5"
                                                                                   id="join_via_html5_on" value="1"
                                                                                   class="common-radio relationButton" @if(!empty($setting)) {{ old('join_via_html5',$setting->join_via_html5) == 1? 'checked': ''}}@endif>
                                                                            <label
                                                                                for="join_via_html5_on">{{__('bbb.Enable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="">
                                                                            <input type="radio" name="join_via_html5"
                                                                                   id="join_via_html5" value="0"
                                                                                   class="common-radio relationButton"@if(!empty($setting)) {{ old('join_via_html5',$setting->join_via_html5) == 0? 'checked': ''}} @endif>
                                                                            <label
                                                                                for="join_via_html5">{{__('bbb.Disable')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-10">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('bbb.State')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex ml-20">
                                                        <div class="row">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                    <div class="col-lg-12">

                                                                        <select name="state" id="state"
                                                                                class="form-control">
                                                                            <option value="any"
                                                                                    @if(!empty($setting)) @if($setting->state=="any") selected @endif @endif>
                                                                                Any
                                                                            </option>
                                                                            <option value="published"
                                                                                    @if(!empty($setting)) @if($setting->state=="published") selected @endif @endif>
                                                                                Published
                                                                            </option>
                                                                            <option value="unpublished"
                                                                                    @if(!empty($setting)) @if($setting->state=="unpublished") selected @endif @endif>
                                                                                Unpublished
                                                                            </option>
                                                                        </select>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-40 mt-40">
                                        <div class="col-lg-6">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input
                                                    class="primary-input form-control{{ $errors->has('security_salt') ? ' is-invalid' : '' }}"
                                                    type="text" name="security_salt"
                                                    value=" @if(!empty($setting)) {{ old('secret_key',$setting->security_salt) }} @endif">
                                                <label>{{__('bbb.BBB Security Salt') }}<span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('security_salt'))
                                                    <span class="invalid-feedback invalid-select" role="alert">
                                                                <strong>{{ $errors->first('security_salt') }}</strong>
                                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input
                                                    class="primary-input form-control{{ $errors->has('server_base_url') ? ' is-invalid' : '' }}"
                                                    type="text" name="server_base_url"
                                                    value=" @if(!empty($setting)) {{ old('server_base_url',$setting->server_base_url) }} @endif">
                                                <label>{{__('bbb.BBB Server Base URL') }}<span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('server_base_url'))
                                                    <span class="invalid-feedback invalid-select" role="alert">
                                                                <strong>{{ $errors->first('server_base_url') }}</strong>
                                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button  type="submit" class="primary-btn fix-gr-bg" id="_submit_btn_admission">
                                                <span class="ti-check"></span>
                                                {{__('bbb.Update')}}
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

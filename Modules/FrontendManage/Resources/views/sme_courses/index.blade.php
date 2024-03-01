@extends('backend.master')
@section('mainContent')
    @include("backend.partials.alertMessage")
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('setting.Sme Courses')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    {{__('setting.Sme Courses')}}
                                </h3>
                            </div>

                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'frontend.smeCourses.store','method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-6 mt-40" id="showResultDiv">
                                            <ul class="permission_list">
                                                <div class="col-lg-6 mb-25">
                                                    <div class="checkbox_wrap d-flex align-items-center mt-40">
                                                        <label for="is_sme_courses_enabled" class="switch_toggle mr-2">
                                                            <input id="is_sme_courses_enabled" name="is_sme_courses_enabled" data-toggle="tooltip" title="1" @if (@$sme_setup->is_enabled==1) checked
                                                                   @endif value="1" type="checkbox">
                                                            <i class="slider round"></i>
                                                        </label>
                                                        <label
                                                            class="mb-0">{{ __('setting.Sme Courses') }} {{__('setting.Enable')}}</label>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip">
                                                <span class="ti-check"></span>
                                                {{__('quiz.Save Setup')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>

    {{-- @include('coupons::create') --}}
    @include('backend.partials.delete_modal')
@endsection

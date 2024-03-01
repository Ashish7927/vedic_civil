@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}" />
    <style>
        .progress-bar {
            background-color: #9734f2;
        }

        input .label {
            width: 200px;
        }
    </style>
@endpush
@php
    $table_name = 'users';
@endphp
@section('table')
    {{ $table_name }}
@endsection

@section('mainContent')
    <div class="container-fluid p-0 ">
        <section class="sms-breadcrumb white-box" style="margin-bottom: 80px">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <h1>{{ __('courses.Course Bulk') }}</h1>
                    <div class="bc-pages">
                        <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                        <a href="#">{{ __('courses.Courses') }}</a>
                        <a href="#">{{ __('courses.Course Bulk') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <form action="{{ route('course.course_bulk_export_template') }}" method="POST" id="export-corporate-revenue-form"
            style="float: right">
            @csrf

            <div class="col-lg-12 col-md-12 no-gutters">
                <div class="main-title">
                    <li>
                        <input type="submit" class="primary-btn radius_30px mr-10 fix-gr-bg"
                            id="excel_export_corporate_revenue_table_data" value="{{ __('Download Template') }}" />
                    </li>
                </div>
            </div>
        </form>

        <div class="main-title d-md-flex">
            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('courses.Course Details') }}</h3>
            <ul class="d-flex" style="padding-left: 40px;">
                <form action="{{ route('course.import_course_bulk_action_details') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    @if (isAdmin())
                        <div class="input-group mb-3">
                            <select class="primary_select label" name="user_id" title="{{__('common.Content Provider')}}/{{__('common.Partner')}}" id="user_id">
                                <option title="" data-display="{{__('common.Select')}} {{__('common.Content Provider')}}/{{__('common.Partner')}}"
                                value="">{{__('common.Select')}} {{__('common.Content Provider')}}/{{__('common.Partner')}} </option>
                                @foreach ($content_providers as $content_provider)
                                    <option value="{{ $content_provider->id }}"> {{ $content_provider->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif

                    <div class="input-group mb-3">
                        <input type="file" name="file" class="form-control label">
                        <input class="btn btn-primary" type="submit" value="Import">
                    </div>
                </form>
            </ul>
        </div>
    </div>
@endsection

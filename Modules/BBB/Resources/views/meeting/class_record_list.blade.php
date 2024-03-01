@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('bbb.BigBlueButton') }} {{ __('bbb.Classes') }} {{ __('bbb.Manage') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('dashboard.Dashboard') }}</a>
                    <a href="{{ route('virtual-class.index') }}">{{ __('bbb.Classes') }}</a>
                    <a href="#">{{ __('bbb.Record List') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class=" col-lg-12">
                    <div class="main-title">
                        <h3 class="mb-20">{{ __('bbb.Class') }} {{ __('bbb.List') }}</h3>
                    </div>

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.SL') }}</th>
                                            <th> {{ __('bbb.Meeting ID') }}</th>
                                            <th> {{ __('bbb.Topic') }}</th>
                                            <th> {{ __('bbb.Start Time') }}</th>
                                            <th> {{ __('bbb.End Time') }}</th>
                                            <th> {{ __('bbb.Participants') }}</th>
                                            <th> {{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recorList as $key => $meeting)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $meeting['meetingID'] }}</td>
                                                <td>{{ $meeting['name'] }}</td>
                                                <td class="text-center">
                                                    {{ \Illuminate\Support\Carbon::parse(microtime($meeting['startTime']))->format(Settings('active_date_format') . ' H:i:s') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ \Illuminate\Support\Carbon::parse(microtime($meeting['endTime']))->format(Settings('active_date_format') . ' H:i:s') }}
                                                </td>
                                                <td class="text-center">{{ $meeting['participants'] }}</td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenu2">
                                                            <a class="dropdown-item"
                                                                href="{{ url($meeting['playback']['format']['url']) }}"
                                                                target="_blank">@lang('bbb.Video') @lang('bbb.Link') </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

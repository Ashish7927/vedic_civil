@extends('backend.master')
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> {{__('common.Details')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('report.Report')}}</a>
                    <a href="#">{{__('report.Scorm Report')}} {{__('common.List')}}</a>
                    <a href="#">{{__('courses.Lesson List')}}</a>
                    <a href="#">{{__('common.Details')}}</a>
                </div>
            </div>
        </div>
    </section>



    <section class="mt-20 admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title mb_xs_20px">
                            <h3 class="mb-0 mb_xs_20px">"{{$lesson->name}}" {{__('common.Details')}} {{__('setting.For')}} "{{$user->name}}"


                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table ">

                    <table id="" class="table Crm_table_active3 scormReportTable">
                        <thead>
                        <tr>
                            <th> {{__('common.SL')}} </th>
                            <th> {{__('setting.Key')}} </th>
                            <th> {{__('setting.Value')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $key=>$report)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$report->key}}</td>
                                <td>{{$report->value}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush

@extends('backend.master')
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> {{__('courses.Lesson List')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('report.Report')}}</a>
                    <a href="#">{{__('report.Scorm Report')}}</a>
                    <a href="#">{{__('courses.Lesson List')}}</a>
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
                            <h3 class="mb-0 mb_xs_20px">{{__('courses.Lesson List')}} {{__('setting.For')}} "{{$course->title}}"


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
                            <th> {{__('common.Name')}} </th>
                            <th> {{__('setting.Version')}} </th>
                            <th> {{__('frontend.Last Updated')}} </th>
                            <th> {{__('common.Action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lessons as $key=>$lesson)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$lesson->name}}</td>
                                <td>{{$lesson->scorm_version}}</td>
                                <td>{{$lesson->updated_at->diffForHumans()}}</td>
                                <td>
                                    <!-- shortby  -->
                                    <div class="dropdown CRM_dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                            {{ __('common.Action') }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a class="dropdown-item details_show"
                                               href="{{route('scorm.report.lesson-details',[$user_id,$lesson->id])}}">{{__('common.Details')}}</a>
                                        </div>
                                    </div>
                                    <!-- shortby  -->
                                </td>
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

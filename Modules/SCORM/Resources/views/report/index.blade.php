
@extends('backend.master')
@section('mainContent')


    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> {{__('report.Scorm Report')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('report.Report')}}</a>
                    <a href="#">{{__('report.Scorm Report')}}</a>
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
                            <h3 class="mb-0 mb_xs_20px"> {{__('report.Scorm Report')}}


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
                            <th> {{__('quiz.Student')}} </th>
                            <th>{{__('courses.Course')}}</th>
                            <th>{{__('common.Total Scorm')}}</th>
                            <th> {{__('common.Action')}} </th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>





@endsection
@push('scripts')
    <script src="{{asset('/')}}/Modules/Quiz/Resources/assets/js/quiz.js"></script>



    <script>
        $('.scormReportTable').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            processing: true,
            serverSide: true,
            // short:false,
            // order: [[0, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! route('scorm.report.data') !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'user.name', name: 'user.name'},
                {data: 'course.title', name: 'course.title'},
                {data: 'lesson', name: 'lesson', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
            language: {
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: 'frtip',

            columnDefs: [{
                visible: false
            }, {responsivePriority: 1, targets: -1},
                {responsivePriority: 2, targets: -2},
            ],
            responsive: true,
        });

    </script>
@endpush

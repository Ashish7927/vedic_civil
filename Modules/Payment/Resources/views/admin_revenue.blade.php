@extends('backend.master')
@php
    $role_id = Auth::user()->role_id;
@endphp
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('payment.Admin Course Revenue List')}}</h1>
                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('quiz.Report')}} </a>
                    <a href="#">{{__('payment.Admin Course Revenue List')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('courses.Advanced Filter')}}</h4>
                    </div>
                    <form action="" method="GET" id="filter-form">
                        <div class="row">
                            @if ($role_id == 1 || $role_id == 5 || $role_id == 6)
                            <div class="col-lg-4 mt-30">
                                <label class="primary_input_label" for="instructor">
                                    {{__('Content Provider')}}
                                </label>
                                <select class="primary_select" name="instructor" id="instructor">
                                    <option data-display="{{__('common.Select')}} {{__('Content Provider')}}"
                                            value="">
                                        {{__('common.Select')}} {{__('Content Provider')}}
                                    </option>
                                    @foreach($instructors as $instructor)
                                    <?php $search_instructor = $_GET['instructor'] ?? 0; ?>
                                    <option {{ $search_instructor == $instructor->id ? 'selected' : '' }}
                                            value="{{ $instructor->id }}">
                                        {{ @$instructor->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="col-lg-4 mt-30 ">
                                <label class="primary_input_label" for="start_date">
                                    {{__('courses.Start Date')}}
                                </label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input class="primary_input_field"
                                                       type="date"
                                                       value="{{ $_GET['start_date'] ?? '' }}"
                                                       name="start_date"
                                                       id="start_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-30 ">
                                <label class="primary_input_label" for="end_date">
                                    {{__('courses.End Date')}}
                                </label>
                                <div class="primary_datepicker_input">
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field"
                                                           type="date"
                                                           value="{{ $_GET['end_date'] ?? '' }}"
                                                           name="end_date"
                                                           id="end_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="
                                @if ($role_id == 1 || $role_id == 5 || $role_id == 6)
                                col-12 mt-20
                                @else
                                col-lg-4 float-right mt-30
                                @endif
                                ">
                                @if($role_id != 1 && $role_id != 5 && $role_id != 6)
                                <label class="primary_input_label pt-4" style="margin-top: 5px;">
                                </label>
                                @endif
                                <div class="search_course_btn @if($role_id == 1) text-right @endif">
                                    <button type="submit"
                                            class="primary-btn radius_30px mr-10 fix-gr-bg">
                                        {{__('courses.Filter')}}
                                    </button>
                                    <button type="button"
                                            class="primary-btn radius_30px mr-10 fix-gr-bg"
                                            id="reset-filter">
                                        {{__('Reset')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-12 mt-60">
                <div class="box_header">
                    <div class="main-title d-md-flex mb-0">
                        <h3 class="mb-0">{{__('payment.Admin Course Revenue List')}}</h3>
                    </div>
                </div>
            </div>

            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div class="">
                        <table id="lms_table" class="table Crm_table_active3" style="word-break: break-word">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('courses.Course Title')}}</th>
                                    <th scope="col">{{__('common.Content Provider')}} / {{__('courses.Trainer')}}</th>
                                    <th scope="col">{{__('courses.Price')}}</th>
                                    <th scope="col">{{__('courses.Publish')}}</th>
                                    <th scope="col">{{__('payment.Total')}} {{__('courses.Enrolled')}}</th>
                                    <th scope="col">{{__('courses.Revenue')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @php
        $instructor = $_GET['instructor'] ?? '';
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';
        $url = route('admin.getmyllAdminRevenueData') . '?instructor=' . $instructor . '&start_date=' . $start_date . '&end_date=' . $end_date;
    @endphp
    <script>
        let table = $('#lms_table').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            processing: true,
            serverSide: true,
            order: [[3, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'course.title', name: 'course.title'},
                {data: 'course.user.name', name: 'course.user.name'},
                {data: 'course.price', name: 'course.price'},
                {data: 'course.created_at', name: 'course.created_at'},
                {data: 'cnt', name: 'cnt'},
                {data: 'myll_revenue', name: 'myll_revenue'},
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
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="far fa-copy"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{ __("common.Copy") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: '{{ __("common.Excel") }}',
                    title: $("#logo_title").val(),
                    margin: [10, 10, 10, 0],
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },

                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="far fa-file-alt"></i>',
                    titleAttr: '{{ __("common.CSV") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{ __("common.PDF") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    header: true,
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }

                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: '{{ __("common.Print") }}',
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ['colvisRestore']
                }
            ],
            columnDefs: [{
                visible: false
            }],
            responsive: true,
        });
    </script>
@endpush

@push('scripts')
    <script>
        $('#excel_export_corporate_revenue_table_data').click(function(){
            $('#get_instructor_value_export').val($('#instructor').val());
            $('#get_start_date_value_export').val($('#start_date').val());
            $('#get_end_date_value_export').val($('#end_date').val());

            $('#export-corporate-revenue-form').submit();
        });
        $('#reset-filter').click(function(){
            window.location.href = "<?= route('admin.reveuneList'); ?>";
        });
    </script>
@endpush

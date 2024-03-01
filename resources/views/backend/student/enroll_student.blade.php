@extends('backend.master')
@php
    $table_name = 'course_enrolleds';
@endphp
@section('table'){{ $table_name }}@stop
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('student.Enrolled Student') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('dashboard.Dashboard') }}</a>
                    <a href="#">{{ __('student.Students') }}</a>
                    <a href="#">{{ __('student.Enrolled Student') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center mt-50">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('student.Filter Enroll History') }}</h4>
                        </div>
                        <input type="hidden" name="role_id" id="current_user_role_id"
                            value="{{ auth()->user()->role_id }}">
                        <form id="filter-form" method="post" action="{{ route('admin.enroll_list_excel_download') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-3 col-md-3 col-lg-3">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="startDate">Enroll Date From</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="start_date"
                                                            id="start_date">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="admissionDate">Enroll Date To</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="end_date"
                                                            id="end_date">
                                                        {{-- <input placeholder="{{__('common.Date')}}" class="primary_input_field primary-input date form-control" id="end_date" type="text" name="end_date" autocomplete="off"> --}}
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    {{-- <i class="ti-calendar" id="admission-date-icon"></i> --}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="primary_input form-group">
                                        <label class="primary_input_label">Status</label>
                                        <select class="primary_select form-control select2" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1">Completed</option>
                                            <option value="0">In Progress</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Name</label>
                                        <input class="primary_input_field" type="text" name="name" id="name">
                                    </div>
                                </div>
                                @if (Auth::user()->role_id !== 7 && Auth::user()->role_id !== 2 && !isPartner())
                                    <div class="col-md-3">
                                        <div class="primary_input form-group">
                                            <label class="primary_input_label">Email</label>
                                            <input class="primary_input_field" type="text" name="email" id="email">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 col-xl-12 mt-30">
                                <div class="search_course_btn">
                                    <button type="button" id="apply-filters"
                                        class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('common.Filter History') }}</button>
                                    <button type="button" id="reset-filters" class="btn btn-default"
                                        style="background:white;color:#1b191f;boder:1 px solid black;"
                                        data-dismiss="modal">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('student.Enrolled Student') }}
                                {{ __('common.List') }}</h3>
                            <ul class="d-flex">

                                <li>
                                    <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_import_table_data"
                                        href="javascript:void(0)">
                                        Export
                                    </a>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="table-responsive">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }} </th>
                                            <th scope="col">{{ __('common.Image') }} </th>
                                            <th scope="col">{{ __('common.Name') }} </th>

                                            @if (check_whether_cp_or_not() || isInstructor() || isPartner())
                                                <th class="disabled-email-column">
                                                    <span style="display: none">{{ __('common.Email Address') }}</span>
                                                </th>
                                            @else
                                                <th scope="col">{{ __('common.Email Address') }} </th>
                                            @endif
                                            <th scope="col">{{ __('courses.Courses') }} {{ __('courses.Enrolled') }}
                                            </th>
                                            <th scope="col">{{ __('Course Status') }}</th>
                                            <th scope="col">{{ __('certificate.Duration') }} </th>
                                            <th scope="col">{{ __('courses.Duration of course (Minutes)') }} </th>
                                            <th scope="col">{{ __('courses.Enrollment') }} {{ __('common.Date') }}
                                            </th>
                                            <th scope="col">{{ __('End Date') }} </th>
                                            @if (isAdmin() || isHRDCorp())
                                                <th scope="col">{{ __('common.Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->
            </div>
        </div>
    </section>
    @include('backend.partials.delete_modal')
    @include('backend.partials.markAsCompleteModal')
@endsection
@push('scripts')
    @php
        $url = route('admin.getEnrollLogsData');
    @endphp

    <script>
        var dom_data = '';
        var current_user_role_id = 0;
        $(function() {
            $("#start_date").change(function() {
                var start_date = $(this).val();
                $("#end_date").attr("min", start_date);
                var d = new Date(start_date);
                d.setMonth(d.getMonth() + 3);
                $("#end_date").attr("max", d.toISOString().substring(0, 10));
            })
            $("#end_date").change(function() {
                var start_date = $(this).val();
                $("#start_date").attr("max", start_date);
                var d = new Date(start_date);
                d.setMonth(d.getMonth() - 3);
                $("#start_date").attr("min", d.toISOString().substring(0, 10));
            })
            current_user_role_id = $("#current_user_role_id").val();

            if (current_user_role_id == 7 || current_user_role_id == 8) {
                dom_data = 'frtip';
            } else {
                dom_data = 'Bfrtip';
            }
            tableLoad();
        });
        tableLoad = () => {
            let table = $('#lms_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 1 // number of pages to cache
                }),
                @if (!check_whether_cp_or_not() && !isInstructor() && !isPartner())
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'user.image',
                            name: 'user.image',
                            orderable: false
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'user.email',
                            name: 'user.email'
                        },
                        {
                            data: 'course.title',
                            name: 'course.title'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'duration',
                            name: 'duration',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'course.duration',
                            name: 'course.duration'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],
                @else
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'user.image',
                            name: 'user.image',
                            orderable: false
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'course.title',
                            name: 'course.title'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'duration',
                            name: 'duration',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'course.duration',
                            name: 'course.duration'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date',
                            orderable: false,
                            searchable: false
                        },
                        @if (isAdmin())
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false
                            },
                        @endif
                    ],
                @endif
                language: {
                    emptyTable: "{{ __('common.No data available in the table') }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __('common.Quick Search') }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: dom_data,
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.Copy') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __('common.Excel') }}',
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
                        titleAttr: '{{ __('common.CSV') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.PDF') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __('common.Print') }}',
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
                responsive: false,
            });
        }
        $('#lms_table').on('preXhr.dt', function(e, settings, data) {
            var status = $('#status').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var name = $('#name').val();
            var email = $('#email').val();
            data['status'] = status;
            data['start_date'] = start_date;
            data['end_date'] = end_date;
            data['name'] = name;
            data['email'] = email;
        });
        $('#apply-filters').click(function() {
            tableLoad();
        });
        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            // $('select#status option[value=""]').attr("selected","selected");
            tableLoad();
        });
        $('#excel_import_table_data').click(function() {
            if (confirm("The export will take some time and it will consume the server usage!") == true) {
                $("#filter-form").submit();
            }

        })
    </script>
    <style>
        .disabled-email-column {
            display: none;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>th:first-child:before {
            display: none;
        }
    </style>
@endpush

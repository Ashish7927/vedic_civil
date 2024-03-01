@extends('backend.master')

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('Corporate Access Monthly Statement Reports') }}</h1>
                <div class="bc-pages">
                    <a href="{{ url('/dashboard') }}">{{ __('common.Dashboard') }} </a>
                    <a href="#">{{ __('quiz.Report') }} </a>
                    <a href="#">{{ __('Corporate Access Monthly Statement Reports') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('courses.Advanced Filter') }} </h4>
                        </div>

                        <form action="" method="GET" id="filter-form">
                            <div class="row">
                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label" for="partner"> {{ __('Partner') }} </label>
                                    <select class="primary_select" name="partner" id="partner">
                                        <option data-display="{{ __('common.Select') }} {{ __('Partner') }}" value=""> {{ __('common.Select') }} {{ __('Partner') }} </option>

                                        @foreach ($partners as $partner)
                                            <option {{ $search_partner == $partner->id ? 'selected' : '' }} value="{{ $partner->id }}"> {{ @$partner->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label" for="instructor"> {{ __('Content Provider') }} </label>
                                    <select class="primary_select" name="instructor" id="instructor">
                                        <option data-display="{{ __('common.Select') }} {{ __('Content Provider') }}" value=""> {{ __('common.Select') }} {{ __('Content Provider') }} </option>

                                        @foreach ($instructors as $instructor)
                                            <option {{ $search_instructor == $instructor->id ? 'selected' : '' }} value="{{ $instructor->id }}"> {{ @$instructor->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 mt-30 ">
                                    <label class="primary_input_label" for="start_date"> {{ __('courses.Start Date') }} </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field" type="date" name="start_date" id="start_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label" for="end_date"> {{ __('courses.End Date') }} </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field" type="date" name="end_date" id="end_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="search_course_btn text-right">
                                <button type="button" class="apply-filter-dates primary-btn radius_30px mr-10 fix-gr-bg"> {{ __('courses.Filter') }} </button>
                                <button type="button" id="reset-filters" class="primary-btn radius_30px mr-10 fix-gr-bg"> {{ __('Reset') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-40 mb-25">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">{{ __('Corporate Access Monthly Statement Reports') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.ca_export_monthly_statement_report') }}" method="POST" id="export-monthly-statement-report-form">
                @csrf

                <input type="hidden" name="partner" id="get_partner_value_export">
                <input type="hidden" name="instructor" id="get_instructor_value_export">
                <input type="hidden" name="start_date" id="get_start_date_value_export">
                <input type="hidden" name="end_date" id="get_end_date_value_export">

                <div class="col-lg-12 col-md-12 no-gutters">
                    <div class="main-title">
                        <li>
                            <button type="button" class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_export_monthly_statement_reports_table_data">
                                Export
                            </button>
                        </li>
                    </div>
                </div>
            </form>

            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <div class="table-responsive">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.No') }}</th>
                                        <th scope="col">{{ __('common.Transaction Date') }}</th>
                                        <th scope="col">{{ __('report.Transaction ID') }}</th>
                                        <th scope="col">{{ __('common.Company') }}</th>
                                        <th scope="col">{{ __('common.Customer Name') }}</th>
                                        <th scope="col">{{ __('common.Tax Invoice No.') }}</th>
                                        <th scope="col">{{ __('common.Customer Details 1 (MyCOID/IC.NO)') }}</th>
                                        <th scope="col">{{ __('common.Customer Details 2 (Address)') }}</th>
                                        <th scope="col">{{ __('common.Content Provider Name') }}</th>
                                        <th scope="col">{{ __('courses.Course Title') }}</th>
                                        <th scope="col">{{ __('common.Qty') }}</th>
                                        <th scope="col">{{ __('common.Unit') }} {{ __('common.Price') }}</th>
                                        <th scope="col">{{ __('common.Total Sales') }}</th>
                                        <th scope="col">{{ __('common.Payment Type') }}</th>
                                        <th scope="col">{{ __('report.Amount Paid via Levy') }}</th>
                                        <th scope="col">{{ __('report.Amount Paid via Ipay') }}</th>
                                        <th scope="col">{{ __('common.SST') }} (6%)</th>
                                        <th scope="col">{{ __('common.Total Sales') }} {{ __('common.Inclusive SST') }}</th>
                                        <th scope="col">{{ __('common.Content Provider') }} ({{ 100 - Settings('commission') - Settings('hrdc_commission') }}%)</th>
                                        <th scope="col">{{ __('common.Vendor') }} ({{ Settings('commission') }}%)</th>
                                        <th scope="col">{{ __('common.HRDCORP + SST OF TOTAL SALES') }} ({{ Settings('hrdc_commission') }}% + 6%)</th>
                                        <th scope="col">{{ __('common.PAYMENT TO HRDCORP') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @php
        $url = route('admin.getCaMonthlyStatementReports');
    @endphp

    <script>
        tableLoadMonthlyStatementReports = () => {
            let table = $('#lms_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                order: [
                    [1, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 5 // number of pages to cache
                }),
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    {
                        name: 'transaction_date.timestamp',
                        data: {
                            _: 'transaction_date.display',
                            sort: 'transaction_date.timestamp'
                        }
                    },
                    { data: 'transaction_id', name: 'transaction_id' },
                    { data: 'customer_corporate_name', name: 'customer_corporate_name' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'tax_invoice_number', name: 'tax_invoice_number' },
                    { data: 'my_co_id', name: 'my_co_id' },
                    { data: 'customer_address', name: 'customer_address' },
                    { data: 'cp_name', name: 'cp_name' },
                    { data: 'course_title', name: 'course_title' },
                    { data: 'qty', name: 'qty' },
                    { data: 'unit_price', name: 'unit_price' },
                    { data: 'total_sales', name: 'total_sales' },
                    { data: 'payment_type', name: 'payment_type' },
                    { data: 'amount_paid_via_levy', name: 'amount_paid_via_levy' },
                    { data: 'amount_paid_via_ipay', name: 'amount_paid_via_ipay' },
                    { data: 'sst', name: 'sst' },
                    { data: 'total_sales_inclusive_sst', name: 'total_sales_inclusive_sst' },
                    { data: 'content_provider_amount', name: 'content_provider_amount' },
                    { data: 'vendor', name: 'vendor' },
                    { data: 'hrdcorp_sst', name: 'hrdcorp_sst' },
                    { data: 'payment_to_hrdcorp', name: 'payment_to_hrdcorp' },
                ],
                language: {
                    emptyTable: "{{ __('common.No data available in the table') }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __('common.Quick Search') }}',
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
                    visible: false,
                }],
                responsive: false,
            });
        }

        $('#lms_table').on('preXhr.dt', function(e, settings, data) {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var instructor = $('#instructor').val();
            var partner = $('#partner').val();

            data['start_date'] = start_date;
            data['end_date'] = end_date;
            data['instructor'] = instructor;
            data['partner'] = partner;
        });

        $('.apply-filter-dates').click(function() {
            tableLoadMonthlyStatementReports();
        });

        $(function() {
            tableLoadMonthlyStatementReports();
        });

        $('#excel_export_monthly_statement_reports_table_data').click(function() {
            $('#get_partner_value_export').val($('#partner').val());
            $('#get_instructor_value_export').val($('#instructor').val());
            $('#get_start_date_value_export').val($('#start_date').val());
            $('#get_end_date_value_export').val($('#end_date').val());
            $('#export-monthly-statement-report-form').submit();
        });

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            $('#instructor, #partner').val($('#instructor, #partner').data('display'));
            $('#instructor, #partner').niceSelect('update')
            tableLoadMonthlyStatementReports();
        });
    </script>

    <style>
        table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>th:first-child:before {
            display: none;
        }
    </style>
@endpush

@extends('backend.master')

@section('table')
    @php
        $table_name='withdraws';
    @endphp
    {{$table_name}}@endsection
@section('mainContent')
        <section class="sms-breadcrumb mb-40 white-box">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <h1>{{__('MYll Admin Payment')}}</h1>
                    <div class="bc-pages">
                        <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                        <a href="#">{{__('quiz.Report')}} </a>
                        <a href="#">{{__('MYll Admin Payment')}}</a>
                    </div>
                </div>
            </div>
        </section>

    @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
        <div class="row justify-content-center mt-50">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('courses.Advanced Filter')}} </h4>
                    </div>
                    <form action="{{ route('admin.myll.admin.payout') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3 mt-30">
                                <label class="primary_input_label" for="month">{{__('courses.Month')}}</label>
                                <select name="month" size='1' class="primary_select" id="month">
                                    <option data-display="{{__('common.Select')}} {{__('courses.Month')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Month')}}</option>
                                    @php
                                        for ($i = 0; $i < 12; $i++) {
                                        $time = strtotime(sprintf('%d months', $i));
                                        $label = date('F', $time);
                                        $value = date('n', $time);
                                    @endphp
                                    <option value="{{$value}}"
                                    @if(isset($_GET['month'])) {{$_GET['month']==$value?'selected':''}} @endif>
                                        {{$label}}
                                    </option>
                                    @php
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-lg-3 mt-30">
                                <label class="primary_input_label" for="year">{{__('courses.Year')}}</label>
                                <select name="year" size='1' class="primary_select" id="year">
                                    <option data-display="{{__('common.Select')}} {{__('courses.Year')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Year')}}</option>
                                    @php
                                        for ($i = date('Y'); $i > 2010; $i--) {
                                    @endphp
                                    <option value="{{$i}}"
                                        @if(isset($_GET['year']))
                                            {{$_GET['year']==$i?'selected':''}}
                                        @endif
                                    >
                                        {{$i}}
                                    </option>
                                    @php
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-lg-3 mt-30">
                                @if ($rolesId == 8)
                                    <label class="primary_input_label"
                                           for="instructor">{{__('Partner')}}</label>
                                    <select class="primary_select" name="instructor" id="instructor">
                                        <option data-display="{{__('common.Select')}} {{__('Partner')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Trainer')}}</option>
                                        @foreach(@$instructors as $instructor)
                                            <option
                                                value="{{$instructor->id}}"
                                            @if(isset($_GET['instructor'])) {{$_GET['instructor']==$instructor->id?'selected':''}} @endif
                                            >{{@$instructor->name}} </option>
                                        @endforeach
                                    </select>
                                @elseif ($rolesId == 7)
                                    <label class="primary_input_label"
                                           for="instructor">{{__('Content Provider')}}</label>
                                    <select class="primary_select" name="instructor" id="instructor">
                                        <option data-display="{{__('common.Select')}} {{__('Content Provider')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Trainer')}}</option>
                                        @foreach (@$instructors as $instructor)
                                            <option
                                                value="{{$instructor->id}}"
                                            @if(isset($_GET['instructor'])) {{$_GET['instructor']==$instructor->id?'selected':''}} @endif
                                            >{{@$instructor->name}} </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="col-lg-3 mt-30">
                                <div class="search_course_btn mt-40">
                                    <button type="submit"
                                            class="primary-btn radius_30px mr-10 fix-gr-bg">{{__('courses.Filter')}} </button>
                                </div>
                            </div>

                            <div class="col-12 mt-20"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <form action="{{route('admin.transaction_myll_admin_download_pdf')}}" id="transaction-download-pdf-form" method="post">
        @csrf

        <input type="hidden" value="" name="instructor_id" id="instructor_id_download_pdf">
        <input type="hidden" value="" name="date" id="date_download_pdf">
        <input type="hidden" value="" name="withdraw_id" id="data_withdraw_id">
        <input type="button" value="downloadPdf" style="display: none"/>
    </form>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if ($rolesId == 8)
                <div class="row mt-40 mb-25">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">{{__('Partner Payment')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($rolesId == 7)
                <div class="row mt-40 mb-25">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">{{__('MYll Admin Payment')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <table id="lms_table" class="table Crm_table_active3">
                        <thead>
                        <tr>
                            <th scope="col">{{__('common.No')}}</th>
                            <th scope="col">{{__('common.Month/Year')}}</th>
                            <th scope="col">{{__('common.Total Sales')}}</th>
                            <th scope="col">{{__('common.Total Revenue')}}</th>
                            <th scope="col">{{__('common.Total SST')}}</th>
                            <th scope="col">{{__('common.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade admin-query" id="requestForm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('withdraw.Request for payment')}}? </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.instructor.instructorRequestPayout')}}" method="post">
                        @csrf
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="nameInput">{{ __('common.Amount') }} <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="amount" type="number" min="0"
                                   value="{{$remaining}}"
                                   max="{{$remaining}}" required step="any">
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('withdraw.Confirm')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade admin-query" id="makeAsPay">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('withdraw.Confirm')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.instructor.instructorCompletePayout')}}" method="post">
                        @csrf
                        <div class="text-center">
                            <input type="hidden" value="" name="withdraw_id" id="withdraw_id">
                            <input type="hidden" value="" name="instructor_id" id="instructor_id">
                            <input type="hidden" value="1" name="type" id="instructor_type">
                            <input type="hidden" value="myll_admin_payout" name="payout_type" id="payout_type">
                            <h4>{{__('withdraw.Are you Sure, You want to mark as payment?')}} </h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('withdraw.Confirm')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('payment::modal_payout_details')

@push('scripts')
    <script>
        $(document).on('click', '.makeAsPaid', function () {
            let instructor_id = $(this).data('instructor_id');
            let id = $(this).data('withdraw_id');

            $("#instructor_id").val(instructor_id);
            $("#withdraw_id").val(id);
            $("#viewdetails").modal('hide');
            $("#makeAsPay").modal('show');
        });
    </script>

    <script>
        $(document).on('click', '.downloadPDF', function () {
            let instructor_id = $(this).data('instructor_id');
            let date = $(this).data('date');
            let withdraw_id = $(this).data('withdraw_id');

            $("#instructor_id_download_pdf").val(instructor_id);
            $("#date_download_pdf").val(date);
            $("#data_withdraw_id").val(withdraw_id);
            $('#transaction-download-pdf-form').submit();
        });
    </script>
@endpush

@push('scripts')
    @php
    if (isset($_GET['instructor'])){
        $instructor =$_GET['instructor'];
    } else {
        $instructor ='';
    }

    if (isset($_GET['month'])){
        $month =$_GET['month'];
    } else {
        $month ='';
    }

    if (isset($_GET['year'])){
        $year =$_GET['year'];
    } else {
        $year ='';
    }


    $url = route('admin.getmyllAdminPayoutData').'?instructor='.$instructor.'&month='.$month.'&year='.$year;
    @endphp

    <script>
        // $("#requestForm").modal('show');
        let table = $('#lms_table').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            processing: true,
            serverSide: true,
            order: [[1, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'month_year', name: 'created_at'},
                {data: 'amount', name: 'total_amount', orderable: false},
                {data: 'total_revenue', name: 'amount'},
                {data: 'total_sst', name: 'amount'},
                {data: 'action', name: 'action', orderable: false},
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


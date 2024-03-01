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
                <h1>Interest Form</h1>
                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('quiz.Report')}} </a>
                    <a href="#">Interest Form</a>
                </div>
            </div>
        </div>

    </section>
    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 || \Illuminate\Support\Facades\Auth::user()->role_id==5 || \Illuminate\Support\Facades\Auth::user()->role_id==6)
        <div class="row justify-content-center mt-50">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('courses.Advanced Filter')}} </h4>
                    </div>
                    <form method="POST" id="filter_form" action="{{route('admin.interest_list_excel_download')}}" >
                    @csrf
                        <div class="row">

                            <div class="col-lg-3 mt-30">

                                <label class="primary_input_label" for="month">From Date</label>
                                <input type="date" class="primary_input_field" value="@if(isset($_GET['from_date'])) {{$_GET['from_date']}} @endif" name="from_date" id="from_date">

                            </div>
                            <div class="col-lg-3 mt-30">

                                <label class="primary_input_label" for="year">To Date</label>
                                <input type="date" class="primary_input_field" value="@if(isset($_GET['to_date'])) {{$_GET['to_date']}} @endif" name="to_date" id="to_date">
                                
                            </div>
                           

                            <div class="col-lg-3 mt-30">


                                <div class="search_course_btn mt-40">
                                <button type="button" id="apply-filters" class="primary-btn radius_30px mr-10 fix-gr-bg">Filter</button>
                                        <!-- <button type="button" id="reset-filters"   class="btn btn-default" style="background:white;color:#1b191f;boder:1 px solid black;" data-dismiss="modal">Reset</button> -->
                                </div>

                            </div>


                            <div class="col-12 mt-20">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="white-box p-3" style="height: 200px">
                    <h1>{{__('payment.Balance')}} </h1>
                    <p class="mt-30">{{__('withdraw.You Currently Have')}}
                        @if(Auth::user()->balance==0)
                            {{Settings('currency_symbol')??'৳'}} 0
                        @else
                            {{getPriceFormat(Auth::user()->balance)}}
                        @endif
                    </p>
                </div>
            </div>

          

            <div class="col-md-4">
                <div class="white-box p-3" style="height: 200px">
                    <h1>{{__('withdraw.Payout Account')}}</h1>
                    <div class="row">
                        <div class="col-md-12">
                            @if(auth()->user()->payout=="Bank Payment")
                                <p class="pb-20">
                                    <b>{{__('setting.Bank Name')}}</b>: {{auth()->user()->bank_name}} <br>
                                    <b>{{__('setting.Branch Name')}}</b>: {{auth()->user()->branch_name}} <br>
                                    <b>{{__('setting.Account Number')}}</b>: {{auth()->user()->bank_account_number}}
                                    <br>
                                    <b>{{__('setting.Account Holder')}}</b>: {{auth()->user()->account_holder_name}}
                                    <br>
                                </p>
                            @else
                                <img src="{{asset(auth()->user()->payout_icon)}}" width="100px"
                                     alt="{{auth()->user()->payout_icon}}">
                                <p class="pt-3 pb-3">{{auth()->user()->payout_email}}</p>
                            @endif

                            <a href="{{route('set.payout')}}" class="primary-btn fix-gr-bg pl-2 pr-2" style="    right: 15px; width: 120px; text-align: center; float: right; top: 0; position: absolute; right: 15px;">{{__('withdraw.Set Account')}}</a>

                        </div>
                    </div>

                </div>
            </div>
        </div> --}}
    @endif

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row mt-40 mb-25">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0" style="float:left; margin-right:20px;">Interest Form</h3>
                                <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_import_table_data" href="javascript:void(0)">
                                Export
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
            <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <table id="lms_table" class="table Crm_table_active3 table-responsive">
                        <thead>
                        <tr>
                            <th scope="col">{{__('common.SL')}}</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Company Reg. No.</th>
                            <th scope="col">Location</th>
                            <th scope="col">Industry</th>
                            <th scope="col">No. of Employees</th>
                            <th scope="col">HRD Corp Registered Employers</th>
                            <th scope="col">Status</th>
                            <th scope="col">Submission Date</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <th scope="col">{{__('common.Action')}}</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>



<style>
    table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>th:first-child:before{
        display:none;
    }
</style>
    
@endsection



@push('scripts')

    @php
       

    if (isset($_GET['from_date'])){
        $from_date =$_GET['from_date'];
    }else{
        $from_date ='';
    }

    if (isset($_GET['to_date'])){
        $to_date =$_GET['to_date'];
    }else{
        $to_date ='';
    }


            $url =route('admin.getInterestFormData').'?from_date='.$from_date.'&to_date='.$to_date;
    @endphp


    <script>
        $(function() {
            $('#lms_table').on('preXhr.dt', function (e, settings, data) {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
            //console.log(from_date);
                data['from_date'] = from_date;
                data['to_date'] = to_date;
            });
            tableLoad();
            $('#apply-filters').click(function () {
                tableLoad();
            });
            $('#excel_import_table_data').click(function () {
                if (confirm("The export will take some time and it will consume the server usage!") == true) {
                    $("#filter_form").submit();
                }

            });
        });
        tableLoad = () => {
        let table = $('#lms_table').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'email_address', name: 'email_address'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'company_name', name: 'company_name', orderable: false},
                {data: 'company_registration_no', name: 'company_registration_no', orderable: false},
                {data: 'location', name: 'location'},
                {data: 'industry', name: 'industry'},
                {data: 'no_of_employees', name: 'no_of_employees'},
                {data: 'hrd_corp', name: 'hrd_corp'},
                {data: 'status', name: 'status'},
                {data: 'submission_date', name: 'submission_date'},
                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                {
                    data: 'action', name: 'action', orderable: false
                },
                @endif

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
            responsive: false,
        });
        }

    </script>
@endpush


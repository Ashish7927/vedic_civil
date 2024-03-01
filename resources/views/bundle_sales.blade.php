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
                <h1>{{__('common.bundle')}} {{__('common.Sales')}}</h1>
                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('quiz.Report')}} </a>
                    <a href="#">{{__('common.bundle')}} {{__('common.Sales')}}</a>
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
                    <form action="{{ route('admin.bundleSales') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3 mt-30">
                                <label class="primary_input_label"
                                        for="content_provider">{{__('Content Provider')}}</label>
                                <select class="primary_select" name="content_provider" id="content_provider">
                                    <option data-display="{{__('common.Select')}} {{__('Content Provider')}}"
                                            value="">{{__('common.Select')}} </option>
                                    @foreach (@$content_providers as $content_provider)
                                        @if($content_provider->name)
                                        <option
                                            value="{{$content_provider->id}}"
                                        @if(isset($_GET['content_provider'])) {{$_GET['content_provider']==$content_provider->id?'selected':''}} @endif
                                        >{{@$content_provider->name}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mt-30">
                                <label class="primary_input_label"
                                        for="corporate_admin">{{__('Corporate Admins')}}</label>
                                <select class="primary_select" name="corporate_admin" id="corporate_admin">
                                    <option data-display="{{__('Corporate Admins')}}"
                                            value="">{{__('corporate admins')}} </option>
                                    @foreach(@$corporate_admins as $corporate_admin)
                                        <option
                                            value="{{$corporate_admin->id}}"
                                        @if(isset($_GET['corporate_admin'])) {{$_GET['corporate_admin']==$corporate_admin->id?'selected':''}} @endif
                                        >{{@$corporate_admin->name}} </option>
                                    @endforeach
                                </select>
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
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row mt-40 mb-25">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">{{__('common.bundle')}} {{__('common.Sales')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
            <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <table id="lms_table" class="table Crm_table_active3">
                        <thead>
                        <tr>
                            <th scope="col">{{__('common.SL')}}</th>
                            <th scope="col">{{__('common.transaction date')}}</th>
                            <th scope="col">{{__('common.package name')}}</th>
                            <th scope="col">{{__('common.content provider name')}}</th> 
                            <!-- <th scope="col">{{__('common.corporate name')}}</th> -->
                            <th scope="col">{{__('common.corporate admin name')}}</th>
                            <th scope="col">{{__('common.price')}}</th>
                            <th scope="col">{{__('common.payment method')}}</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
   @include('payment::modal_payout_details')
@endsection
@push('scripts')
    @php
        if (isset($_GET['content_provider'])){
        $content_provider =$_GET['content_provider'];
    }else{
        $content_provider ='';
    }

    if (isset($_GET['corporate_admin'])){
        $corporate_admin =$_GET['corporate_admin'];
    }else{
        $corporate_admin ='';
    }

    $url =route('admin.bundleSalesData').'?content_provider='.$content_provider.'&corporate_admin='.$corporate_admin;
    @endphp
    <script>
        // $("#requestForm").modal('show');
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
                {data: 'transaction_date', name: 'transaction_date'},
                {data: 'package_name', name: 'package_name'},
                {data: 'content_provider_name', name: 'content_provider_name'},
                {data: 'corporate_name', name: 'corporate_name'},
                {data: 'checkout_price', name: 'checkout_price'},
                {data: 'payment_method', name: 'payment_method'},           
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


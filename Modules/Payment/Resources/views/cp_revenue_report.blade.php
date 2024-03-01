@extends('backend.master')
@php
    $table_name='course_enrolleds';
    $role_id =\Illuminate\Support\Facades\Auth::user()->role_id;
@endphp
@section('table'){{ $table_name }}@stop
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                @if($rolesId == 8)
                    <h1>{{__('Partner')}} {{__('courses.Revenue')}}</h1>
                @elseif($rolesId == 7)
                    <h1>{{__('Content Provider')}} {{__('courses.Revenue')}}</h1>
                @endif

                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('quiz.Report')}} </a>
                    @if($rolesId == 8)
                        <a href="#">{{__('Partner')}} {{__('courses.Revenue')}}</a>
                    @elseif($rolesId == 7)
                        <a href="#">{{__('Content Provider')}} {{__('courses.Revenue')}}</a>
                    @endif
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
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form action="" method="GET" id="filter-form">
                            <div class="row">
                                @if($role_id==1 || $role_id == 5 || $role_id == 6)
                                    <div class="col-lg-4 mt-30">
                                        @if ($rolesId == 8)
                                            <label class="primary_input_label" for="instructor">
                                                {{__('Partner')}}
                                            </label>
                                        @elseif ($rolesId == 7)
                                            <label class="primary_input_label" for="instructor">
                                                {{__('Content Provider')}}
                                            </label>
                                        @endif
                                        @if ($rolesId == 8)
                                            <select class="primary_select" name="instructor" id="instructor">
                                                <option data-display="{{__('common.Select')}} {{__('Partner')}}"
                                                        value="">
                                                    {{__('common.Select')}} {{__('Partner')}}
                                                </option>
                                                @foreach($instructors as $instructor)
                                                    <option {{$search_instructor==$instructor->id?'selected':''}}
                                                            value="{{$instructor->id}}">
                                                        {{@$instructor->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($rolesId == 7)
                                            <select class="primary_select" name="instructor" id="instructor">
                                                <option data-display="{{__('common.Select')}} {{__('Content Provider')}}"
                                                        value="">
                                                    {{__('common.Select')}} {{__('Content Provider')}}
                                                </option>
                                                @foreach($instructors as $instructor)
                                                    <option {{$search_instructor==$instructor->id?'selected':''}}
                                                            value="{{$instructor->id}}">
                                                        {{@$instructor->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                @endif
                                <div class="col-lg-4 mt-30 ">
                                    <label class="primary_input_label" for="product_type">
                                        {{__('report.Learning Type')}}
                                    </label>
                                    <select class="select2 primary_select" name="product_type" id="product_type">
                                        <option data-display="{{ __('common.Select') }} {{ __('report.Learning Type') }}" value="">{{ __('common.Select') }} {{ __('report.Learning Type') }}</option>
                                        <option {{ $search_learning_type == 1 ? 'selected':'' }} value="1">Pay Per Use</option>
                                        <option {{ $search_learning_type == 2 ? 'selected' : '' }} value="2">Subscription</option>
                                    </select>
                                </div>
                                {{-- <div class="col-lg-4 mt-30 ">
                                    <label class="primary_input_label" for="user">
                                        {{__('User/Company')}}
                                    </label>
                                    <select class="select2 primary_select" name="user" id="user">
                                        <option data-display="{{__('common.Select')}} {{__('User/Company')}}"
                                            value="">
                                            {{__('common.Select')}} {{__('User/Company')}}
                                        </option>
                                        @foreach($users as $group => $user)
                                        <div>
                                            <optgroup label="{{ $group }}">
                                                <option value="users_opt" disabled="disabled">
                                                    {{ $group }}
                                                </option>
                                                @foreach($user as $i => $elem)
                                                <option {{$search_user == $elem->id ? 'selected' :''}}
                                                    value="{{ $group . $elem->id }}">
                                                        {{@$elem->name}}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                        </div>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-lg-4 mt-30 ">
                                    <label class="primary_input_label" for="title">
                                        {{__('common.Title')}}
                                    </label>
                                    <input class="primary_input_field" type="text" name="title" id="title" placeholder="Title" value="{{ $search_title ?? '' }}">
                                </div>
                                <div class="col-lg-4 mt-30 ">
                                    <label class="primary_input_label" for="start_date">
                                        {{__('courses.Start Date')}}
                                    </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field" type="date" value="{{$start_date ?? ''}}" name="start_date" id="start_date">
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
                                                            <input class="primary_input_field" type="date" value="{{$end_date ?? ''}}" name="end_date" id="end_date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @if($role_id==1 || $role_id == 5 || $role_id == 6)
                                    <div class="col-12 mt-20">
                                @else
                                        <div class="col-lg-4 float-right mt-30">
                                            <label class="primary_input_label pt-4" style="    margin-top: 5px;">

                                            </label>
                                @endif
                                            <div
                                                class="search_course_btn  @if($role_id==1) text-right @endif">
                                                <button
                                                    type="submit"
                                                    class="primary-btn radius_30px mr-10 fix-gr-bg"
                                                >
                                                    {{__('courses.Filter')}}
                                                </button>
                                                <button type="button"
                                                        class="primary-btn radius_30px mr-10 fix-gr-bg" id="reset-filter">{{__('Reset')}} </button>
                                            </div>
                                        </div>
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
                                @if($rolesId == 8)
                                    <h3 class="mb-0">{{__('Partner')}} {{__('courses.Revenue')}}</h3>
                                @elseif($rolesId == 7)
                                    <h3 class="mb-0">{{__('Content Provider')}} {{__('courses.Revenue')}}</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{route('admin.reveune_cp_export')}}" method="POST" id="export-corporate-revenue-form">
                @csrf
                <input type="hidden" name="instructor" id="get_instructor_value_export">
                <input type="hidden" name="start_date" id="get_start_date_value_export">
                <input type="hidden" name="end_date" id="get_end_date_value_export">
                <input type="hidden" name="role_id" id="get_role_id_value_export" value="{{ $rolesId }}">
                <input type="hidden" name="title" id="get_title_value_export">
                <input type="hidden" name="search_learning_type" id="get_learning_type_value_export">
                <input type="hidden" name="user" id="get_user_value_export">
                <div class="col-lg-12 col-md-12 no-gutters">
                    <div class="main-title">
                        <li>
                            <button type="button" class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_export_corporate_revenue_table_data">
                                Export
                            </button>
                        </li>
                    </div>
                </div>
            </form>

            <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                <div class="QA_table ">
                    <table id="lms_table" class="table Crm_table_active3"
                           style="word-break: break-word">
                        <thead>
                            <tr>
                                <th scope="col">{{__('report.Transaction ID')}}</th>
                                <th scope="col"><span class="m-2">{{__('common.Title')}}</span></th>
                                <th scope="col"><span class="m-2">{{__('report.Learning Type')}}</span></th>
                                <th scope="col">{{__('courses.Purchase')}} {{__('certificate.Date')}}</th>
                                @if($role_id==1 || $role_id == 5 || $role_id == 6 )
                                    <th scope="col">{{__('CP / Partner')}} </th>

                                @endif
                                <th scope="col">{{__('User/Company')}}</th>
                                <th scope="col">{{__('courses.Course')}} {{__('courses.Price')}}</th>
                                <th scope="col">{{__('report.Quantity')}}</th>
                                <th scope="col">{{__('report.Grand Total')}}</th>
                                @if ($rolesId == 8)
                                    <th scope="col">{{__('Partner')}} {{__('courses.Revenue')}}</th>
                                @elseif ($rolesId == 7)
                                    <th style="word-wrap:break-word" scope="col">{{__('Content Provider')}} {{__('courses.Revenue')}}</th>
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
@endsection

@push('scripts')
    @php
        if (isset($_GET['instructor'])) {
            $instructor = $_GET['instructor'];
        } else {
            $instructor = '';
        }

        if (isset($_GET['start_date'])) {
            $start_date = $_GET['start_date'];
        } else {
            $start_date = '';
        }

        if (isset($_GET['end_date'])) {
            $end_date = $_GET['end_date'];
        } else {
            $end_date = '';
        }

        if (isset($_GET['user'])) {
            $user = $_GET['user'];
        } else {
            $user = '';
        }

        if (isset($_GET['product_type'])) {
            $product_type = $_GET['product_type'];
        } else {
            $product_type = '';
        }

        if (isset($_GET['title'])) {
            $title = $_GET['title'];
        }else {
            $title = '';
        }

        $url = route('admin.reveune_cp_data') . '?role=' . $rolesId;
        $url = $url . '&instructor=' . $instructor . '&start_date=' . $start_date . '&end_date=' . $end_date . '&user=' . $user . '&product_type=' . $product_type . '&title=' . $title;
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
                {data: 'purchase_id', name: 'purchase_id'},
                {data: 'title', name: 'title'},
                {data: 'learning_type', name: 'learning_type'},
                // {data: 'created_at', name: 'created_at'},
                {name:'created_at.timestamp', data: {
                        _: 'created_at.display',
                        sort: 'created_at.timestamp'
                    }
                },
                @if ($role_id == 1 || $role_id == 5 || $role_id == 6)
                {data: 'cp_partner_name', name: 'cp_partner_name'},
                @endif
                {data: 'user_name', name: 'user_name'},
                {data: 'purchase_price', name: 'purchase_price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'grand_total', name: 'grand_total'},
                @if ($rolesId == 7 || $rolesId == 8)
                {data: 'reveune', name: 'reveune'},
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
            // dom: 'Bfrtip',
            dom: 'frtip',
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
            columnDefs: [
                { visible: false },
            ],
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
            $('#get_role_id_value_export').val();
            $('#get_title_value_export').val($('#title').val());
            $('#get_learning_type_value_export').val($('#product_type').val());
            $('#get_user_value_export').val($('#user').val());

            $('#export-corporate-revenue-form').submit();
        });
        $('#reset-filter').click(function(){
            if (window.location.href.indexOf("reveuneListCP") > -1) {
                window.location.href = "<?= route('admin.reveune_list_cp'); ?>";
            } else {
                window.location.href = "<?= route('admin.reveune_list_partner'); ?>";
            }
        });

        $(document).ready(function(){
            $("#user + .select2 ul li").each(function(){
                var value = $(this).attr("data-value");
                if(value != "users_opt"){
                    $(this).css({'margin-bottom':'0px','padding-bottom':'0'});
                } else {
                    $(this).css({'margin-left':'10px', 'color':'gray','font-weight':'bold', 'border-bottom':'none', 'margin-bottom' : '0px', 'background' : 'transparent', 'padding' : '0px'});
                }
            });
        });
    </script>
@endpush

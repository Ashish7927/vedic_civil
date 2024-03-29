@extends('backend.master')

<!-- @php $table_name = 'customize_packages'; @endphp
@section('table'){{ $table_name }} @stop -->

@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/select2_custom.css') }}?{{ $version }}" />
    <style type="text/css">
        .loading-spinner,
        .submit-loading-spinner {
            display: none;
        }

        .loading-spinner.active,
        .submit-loading-spinner.active {
            display: inline-block;
        }
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
             <div class="row justify-content-between">
                <h1>
                    {{ __('courses.Packages') }} {{ __('courses.Request') }}
                </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('courses.Packages') }}</a>
                    <a href="#">
                       
                        {{ __('courses.Request') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">
                <!-- <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('Advanced Filter') }} </h4>
                        </div>
                        <input type="hidden" name="role_id" id="current_user_role_id" value="{{ auth()->user()->role_id }}">
                    </div>
                </div>
 -->
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{ __('courses.Packages') }} {{ __('courses.Request') }}  {{ __('common.List') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="">
                                <table id="lms_table" class="table classList">
                                    <thead>
                                        <tr>
                                            <th scope="col"> {{ __('common.SL') }}</th>
                                            <th scope="col"> {{ __('common.request by') }}</th>
                                            <th scope="col"> {{ __('common.Name') }}</th>
                                            
                                            <th scope="col"> {{ __('common.Email') }}</th>
                                            <th scope="col"> {{ __('common.Phone Number') }}</th>
                                            <th scope="col"> {{ __('common.Company Name') }}</th>
                                            <th scope="col"> {{ __('common.Company Registration') }}</th>
                                             @if (isAdmin())
                                                <th scope="col"> {{ __('common.Status') }}</th>
                                            @endif
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
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('/') }}/Modules/commonetting/Resources/assets/js/course.js"></script>

    @php $url = route('getAllPackageRequest'); @endphp

    <script>
        var dom_data = '';
        var current_user_role_id = 0;

        $(function() {
            current_user_role_id = $("#current_user_role_id").val();

            if (current_user_role_id == 7 || current_user_role_id == 8) {
                dom_data = 'frtip';
            } else {
                dom_data = 'Bfrtip';
            }

            tableLoad();
        });

        tableLoad = () => {
            let table = $('.classList').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 1 // number of pages to cache
                }),
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'user', name: 'user' },
                    { data: 'full_name', name: 'full_name' },
                     { data: 'email_address', name: 'email_address' },
                      { data: 'phone_number', name: 'phone_number' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'company_registration', name: 'company_registration' },
                    @if (isAdmin())
                        { data: 'request_status', name: 'request_status',orderable: false, searchable: false},
                    @endif
                    @if (isAdmin() || isHRDCorp())
                    { data: 'action', name: 'action', orderable: false },
                    @endif

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
                responsive: true,
            });
        }

        $('#lms_table').on('preXhr.dt', function(e, settings, data) {
            var category = $('#category').val();

            data['category'] = category;
        });

        $('#apply-filters').click(function() {
            tableLoad();
        });

        $('#reset-filters').click(function() {
            tableLoad();
        });
        function statusChange(id){
           
            alert(id);
        }
     
    </script>
    <style>
        #dropdownMenu2{
            height:25px;
        }
    </style>
@endpush

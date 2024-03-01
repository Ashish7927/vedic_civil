@extends('backend.master')

@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('common.Audit Trail')}} {{__('common.Learner Profile')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('common.Audit Trail')}} {{__('common.Learner Profile')}}</a>
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
                        <div class="row">
                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label">{{__('common.Email Address')}} / {{__('common.Name')}}</label>
                                    <input type="text" name="email_address" id="email_address_name_audit_trail"
                                           class="primary_input_field form-control" placeholder="Email Address / Name"/>
                                </div>
                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label">{{__('common.Date From')}}</label>
                                    <input class="primary_input_field" type="date" name="start_date" id="start_date">
                                </div>
                                <div class="col-lg-4 mt-30">
                                    <label class="primary_input_label">{{__('common.Date To')}}</label>
                                    <input class="primary_input_field" type="date" name="end_date" id="end_date">
                                </div>
                        </div>
                        <div class="col-12 mt-20">
                            <div class="search_course_btn text-right">
                                <button type="button" class="primary-btn radius_30px mr-10 fix-gr-bg audit-apply-filter">{{__('courses.Filter')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.Audit Trail')}} {{__('common.Learner Profile')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_audit_table" class="table Crm_table_active5 wrap">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Email Address')}}</th>
                                        <th scope="col">{{__('common.URL')}}</th>
                                        <th scope="col">{{__('setting.IP')}}</th>
                                        <th scope="col">{{__('setting.Attempted At')}}</th>
                                        <th scope="col">{{__('setting.User')}}</th>
                                        <th scope="col">{{__('setting.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="viewStudentAuditTrail">

                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')

    @if ($errors->any())
        <script>
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_error_log').modal('show');
            @else
            $('#editError_log').modal('show');
            @endif
            @endif
        </script>
    @endif


    @php
        $url = route('admin.auditTrailLearnerProfileData');
    @endphp

    <script>
        tableLoad = () => {
            let table = $('#lms_audit_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 5 // number of pages to cache
                }),
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'email', name: 'email'},
                    {data: 'url', name: 'url'},
                    {data: 'ip', name: 'ip'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'user', name: 'user'},
                    {data: 'action', name: 'action'},
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
        }

        $(function() {
            tableLoad();
        });

        $('#lms_audit_table').on('preXhr.dt', function (e, settings, data) {
           var email = $("#email_address_name_audit_trail").val();
           var start_date = $("#start_date").val();
           var end_date = $("#end_date").val();

            data["email"] = email;
            data["start_date"] = start_date;
            data["end_date"] = end_date;
        });

        $(document).on('click', '.viewStudentAuditTrail', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.getCompareAuditTrailLearnerProfileData', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $("#viewStudentAuditTrail").html(data);
                    $("#viewStudentAuditTrail").modal('show');
                }
            });
        });

        $(".audit-apply-filter").on('click',function(){
            tableLoad();
        });

    </script>

@endpush

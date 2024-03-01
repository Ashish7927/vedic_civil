@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}"/>
@endpush

@section('table')
    @php
        $table_name='users';
    @endphp
    {{$table_name}}@stop
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>Not Verified {{__('quiz.Instructor')}} {{__('common.List')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('instructor.Instructors')}}</a>
                    <a href="#">Not Verified {{__('quiz.Instructor')}} {{__('common.List')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Not Verified {{__('quiz.Instructor')}} {{__('common.List')}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Name')}}</th>
                                        <th scope="col">{{__('common.Email')}}</th>
                                        <th scope="col">{{__('MyCoId')}}</th>
                                        <th scope="col">{{__('IC number')}}</th>
                                        <th scope="col">{{__('TTT certificate')}}</th>
                                        <th scope="col">{{__('TTT exemption')}}</th>
                                        <th scope="col">{{__('Contact Number')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="send_instructor">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Send Instructions </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" name="id" id="instructor_id">
                                    <input type="hidden" name="name" id="instructor_name">
                                    <input type="hidden" name="email" id="instructor_email">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label">Instructions</label>
                                                {{-- lms_summernote / primary_textarea --}}
                                                <textarea class="lms_summernote_instructions" name="instructions" id="instructions"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="button" id="send_mail">{{__('Send Mail')}}</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
            $('#add_instructor').modal('show');
            @else
            $('#editInstructor').modal('show');
            @endif
            @endif
        </script>
    @endif

    @php
        $url = route('not_verified_instructors_data');
    @endphp

    <script>
        $(document).ready(function () {
            if ($('.lms_summernote_instructions').length) {
                $('.lms_summernote_instructions').summernote({
                    tabsize: 2,
                    height: 188,
                    tooltip: true,
                    toolbar: [
                        ['bold', ['bold']],
                        ['italic', ['italic']],
                        ['underline', ['underline']],
                        ['para', ['ul', 'ol']],
                        // [groupName, [list of button]]
                        // ['style', ['bold', 'italic', 'underline', 'clear']],
                        // ['font', ['bold', 'underline']],
                        // ['font', ['strikethrough']],
                        // ['fontsize', ['fontsize']],
                        // ['color', ['color']],
                        // ['height', ['height']]
                    ]
                });
            }
        });
        $(function() {
            tableLoad();
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
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'my_co_id', name: 'my_co_id'},
                    {data: 'ic_no_for_trainer', name: 'ic_no_for_trainer'},
                    {data: 'ttt_certificate', name: 'ttt_certificate'},
                    {data: 'ttt_exemption', name: 'ttt_exemption'},
                    {data: 'phone', name: 'phone'},
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
        }
        $(document).on("click", ".approve_instructor_btn", function() {
            var id = $(this).data("id");

            var url = "{{ route('verify_instructor',':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function (data) {
                    if(data.success == 1)
                    {
                        toastr.success(data.message, 'Success');
                        tableLoad();
                    }
                    if(data.success == 0)
                        toastr.error(data.message, 'Error');
                },
                error: function (data) {
                    console.log("Error:", data);
                },
            });

            // swal({
            //     title: "Confirmation",
            //     text: "Are you sure you want to approve this Instructor?",
            //     showCancelButton: true,
            //     confirmButtonColor: "#DD6B55",
            //     confirmButtonText: "@lang('app.yes')",
            //     cancelButtonText: "@lang('messages.confirmNoArchive')",
            //     closeOnConfirm: true,
            //     closeOnCancel: true
            // }, function (isConfirm) {
            //     if (isConfirm) {

            //     }
            // });
        })

        $(document).on("click", ".send_instruction_btn", function() {
            var id = $(this).data("id");
            var name = $(this).data("name");
            var email = $(this).data("email");

            $("#instructor_id").val(id);
            $("#instructor_name").val(name);
            $("#instructor_email").val(email);
            $('#send_instructor').modal('show');
        })
        $(document).on("click", "#send_mail", function() {
            var url = "{{ route('send_mail') }}";

            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: {
                    id: $("#instructor_id").val(),
                    name: $("#instructor_name").val(),
                    email: $("#instructor_email").val(),
                    instructions: $("#instructions").val()
                },
                success: function (data) {
                    if(data.success == 1)
                    {
                        toastr.success(data.message, 'Success');
                        $('#send_instructor').modal('hide');
                        tableLoad();
                    }
                    if(data.success == 0)
                        toastr.error(data.message, 'Error');
                },
                error: function (data) {
                    console.log("Error:", data);
                },
            });
        })
    </script>
    <script src="{{asset('backend/js/instructor_list.js')}}"></script>
@endpush



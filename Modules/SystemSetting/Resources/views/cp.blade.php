@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}"/>
@endpush

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('Content Provider')}} {{__('common.List')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('content providers')}}</a>
                    <a href="#">{{__('Content Provider')}} {{__('common.List')}}</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('Content Provider')}} {{__('common.List')}}</h3>
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
                                        <th scope="col">{{__('common.Image')}}</th>
                                        <th scope="col">{{__('common.Name')}}</th>
                                        <th scope="col">{{__('common.Email')}}</th>
                                        <th scope="col">{{__('common.Tax')}}</th>
                                        @if (isAdmin())
                                            <th scope="col">{{__('Enable Logo')}}</th>
                                        @endif
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

            </div>
        </div>
    </section>
    <div class="modal fade admin-query" id="edit_cp">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Update')}} {{__('Content Provider')}}</h4>
                    <button type="button" class="close " data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{route('cp.update')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="" id="cpId">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Name')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field"
                                           {{$errors->first('name') ? 'autofocus' : ''}}
                                           value="{{old('name')}}"
                                           name="name"
                                           id="cpName"
                                           placeholder="-" type="text" disabled>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                           for="">{{__('instructor.About')}}</label>
                                    <textarea class="lms_summernote" name="about"
                                              id="cpAbout"
                                              cols="30"
                                              rows="10">{{old('about')}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="">{{__('instructor.Date of Birth')}}
                                    </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                           class="primary_input_field primary-input date form-control"
                                                           id="cpDob"
                                                           {{$errors->first('dob') ? 'autofocus' : ''}}
                                                           type="text" name="dob"
                                                           value="{{old('dob')}}"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar"
                                                   id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Phone')}}  </label>
                                    <input class="primary_input_field"
                                           value="{{old('phone')}}"
                                           name="phone" placeholder="-"
                                           id="cpPhone"
                                           type="text" {{$errors->first('phone') ? 'autofocus' : ''}} disabled>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Email')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field"
                                           value="{{old('email')}}"
                                           name="email" placeholder="-"
                                           id="cpEmail"
                                           type="email" {{$errors->first('email') ? 'autofocus' : ''}} disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Image')}}
                                        <small>{{__('student.Recommended size')}}
                                            (330x400)</small></label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input imgName"
                                               type="text"
                                               id="cpImage"
                                               readonly="">
                                        <button class="" type="button">
                                            <label
                                                class="primary-btn small fix-gr-bg"
                                                for="document_file_edit">{{__('common.Browse')}}</label>
                                            <input type="file"
                                                   class="d-none imgBrowse"
                                                   name="image"
                                                   id="document_file_edit">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Password')}} </label>

                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i
                                                    style="cursor:pointer;"
                                                    class="fas fa-eye-slash eye toggle-password"></i>
                                            </div>
                                        </div>
                                        <input type="password"
                                               class="form-control primary_input_field"
                                               id="password" name="password"
                                               placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password') ? 'autofocus' : ''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Confirm Password')}}
                                    </label>

                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i
                                                    style="cursor:pointer;"
                                                    class="fas fa-eye-slash eye toggle-password"></i>
                                            </div>
                                        </div>
                                        <input type="password"
                                               class="form-control primary_input_field"
                                               id="password"
                                               name="password_confirmation"
                                               placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password_confirmation') ? 'autofocus' : ''}}>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""> {{__('common.Facebook URL')}}</label>
                                    <input class="primary_input_field"
                                           value="{{old('facebook')}}"
                                           name="facebook" placeholder="-"
                                           id="cpFacebook"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""> {{__('common.Twitter URL')}}</label>
                                    <input class="primary_input_field"
                                           value="{{old('twitter')}}"
                                           name="twitter" placeholder="-"
                                           id="cpTwitter"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""> {{__('common.LinkedIn URL')}}</label>
                                    <input class="primary_input_field"
                                           value="{{old('linkedin')}}"
                                           name="linkedin" placeholder="-"
                                           id="cpLinkedin"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""> {{__('common.Instagram URL')}}</label>
                                    <input class="primary_input_field"
                                           value="{{old('instagram')}}"
                                           name="instagram" placeholder="-"
                                           id="cpInstragram"
                                           type="text">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg"
                                        id="save_button_parent" type="submit"><i
                                        class="ti-check"></i> {{__('common.Update')}} {{__('Content Provider')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    @php
        $url = route('getAllCpData');
    @endphp

    <script>
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
                {data: 'image', name: 'image', orderable: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'tax', name: 'tax'},
                @if (isAdmin())
                    {data: 'enabled_package', name: 'enabled_package', orderable: false},
                @endif
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

        $(document).on('click', '.edit_cp', function () {
            let cp_id = $(this).data('item-id');
            let url = $('#url').val();
            url = url + '/admin/get-user-data/' + cp_id
            let token = $('.csrf_token').val();

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': token,
                },
                success: function (cp) {
                    $('#cpId').val(cp.id);
                    $('#cpName').val(cp.name);
                    $('#cpAbout').summernote("code", cp.about);
                    $('#cpDob').val(cp.dob);
                    $('#cpPhone').val(cp.phone);
                    $('#cpEmail').val(cp.email);
                    $('#cpImage').val(cp.image);
                    $('#cpFacebook').val(cp.facebook);
                    $('#cpTwitter').val(cp.twitter);
                    $('#cpLinkedin').val(cp.linkedin);
                    $('#cpInstragram').val(cp.instagram);
                    $("#edit_cp").modal('show');
                },
                error: function (data) {
                    toastr.error('Something Went Wrong', 'Error');
                }
            });
        });

        $(document).on('change', '.enabled_package', function() {
            let partner_id = $(this).attr('data-id');
            let enabled_package = $(this).attr('data-enabled-package');

            $.ajax({
                type: "post",
                url: "{!! route('cp.change_enabled_package_status') !!}",
                data: {
                    partner_id: partner_id,
                    enabled_package: enabled_package,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        if (enabled_package == 0) {
                            $('#active_checkbox'+partner_id).attr('data-enabled-package', 1);
                        } else {
                            $('#active_checkbox'+partner_id).attr('data-enabled-package', 0);
                        }

                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                }
            });
        });
    </script>
@endpush

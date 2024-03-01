@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{asset('backend/css/student_list.css')}}?{{ $version }}"/>
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
                <h1>Partner {{__('common.List')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">Partners</a>
                    <a href="#">Partner {{__('common.List')}}</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Partner {{__('common.List')}}</h3>
                            {{-- @if (permissionCheck('instructor.store'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                           id="add_instructor_btn"
                                           data-target="#add_instructor" href="#"><i
                                                class="ti-plus"></i>{{__('instructor.Add Instructor')}}</a></li>
                                </ul>
                            @endif --}}

                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form method="POST" id="filter-form-partner" action="{{route('partner_list_excel_download')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="search_partner_status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="search_partner_status" id="search_partner_status">
                                        <option data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                value="">{{__('common.Select')}} {{__('common.Status')}}</option>
                                        <option
                                            value="1">{{__('common.Approved')}} </option>
                                        <option
                                            value="0">{{__('common.Pending')}} </option>
                                        <option
                                            value="2">{{__('common.Reject')}} </option>
                                    </select>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mt-30">
                                        <label class="primary_input_label" for="from_duration">Name</label>
                                        <input type="text" name="partner_name" id="partner_name"
                                               class="primary_input_field form-control" placeholder="Partner Name"/>
                                    </div>
                                    <div class="col-lg-6 mt-30">
                                        <label class="primary_input_label" for="from_duration">Email Address</label>
                                        <input type="text" name="email_address" id="email_address"
                                               class="primary_input_field form-control" placeholder="Email Address"/>
                                    </div>
                                </div>

                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <button type="button" id="apply-filters-partner" class="primary-btn radius_30px mr-10 fix-gr-bg">Filter</button>
                                    </div>
                                </div>
                                <div class="col-12 mt-20">
                                    <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="export-filters-partner" href="javascript:void(0)">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </form>
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
                                        <th scope="col">{{__('common.Status')}}</th>
                                        @if (isAdmin() || isHRDCorp())
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
                <!-- Add Modal Item_Details -->
                <!-- new product -->
                <div class="modal fade admin-query" id="add_instructor">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Add New')}} Partner</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('instructor.store')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" placeholder="-"
                                                       id="addName"
                                                       type="text"
                                                       value="{{ old('name') }}" {{$errors->first('name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('instructor.About')}}</label>
                                                <textarea class="lms_summernote" name="about" id="addAbout" cols="30"
                                                          rows="10">{{ old('about') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('common.Date of Birth')}}
                                                </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="{{__('common.Date')}}"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="startDate" type="text" name="dob"
                                                                       value="{{old('dob')}}"
                                                                       {{$errors->first('dob') ? 'autofocus' : ''}}
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Phone')}} </label>
                                                <input class="primary_input_field" value="{{old('phone')}}" name="phone"
                                                       id="addPhone"
                                                       placeholder="-" {{$errors->first('phone') ? 'autofocus' : ''}}
                                                       type="text">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Email')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" placeholder="-"
                                                       id="addEmail"
                                                       value="{{old('email')}}"
                                                       {{$errors->first('email') ? 'autofocus' : ''}}
                                                       type="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('common.Image')}}
                                                    <small>{{__('student.Recommended size')}} (330x400)</small></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input imgName" type="text"
                                                           id="placeholderFileOneName"
                                                           placeholder="{{__('student.Browse Image file')}}"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file">{{__('common.Browse')}}</label>
                                                        <input type="file" class="d-none imgBrowse" name="image"
                                                               id="document_file">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('Password')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           id="addPassword" name="password"
                                                           placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Confirm Password')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           {{$errors->first('password_confirmation') ? 'autofocus' : ''}}
                                                           id="addCpassword" name="password_confirmation"
                                                           placeholder="{{__('common.Minimum 8 characters')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Facebook URL')}}</label>
                                                <input class="primary_input_field" name="facebook" placeholder="-"
                                                       id="addFacebook"
                                                       type="text" value="{{ old('facebook') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Twitter URL')}}</label>
                                                <input class="primary_input_field" name="twitter" placeholder="-"
                                                       id="addTwitter"
                                                       type="text" value="{{ old('twitter') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.LinkedIn URL')}}</label>
                                                <input class="primary_input_field" name="linkedin" placeholder="-"
                                                       id="addLinkedin"
                                                       type="text" value="{{ old('linkedin') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Instagram URL')}}</label>
                                                <input class="primary_input_field" name="instagram" placeholder="-"
                                                       id="addInstagram"
                                                       type="text" value="{{ old('instagram') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} {{__('courses.Trainer')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editInstructor">

                </div>
                <div class="modal fade admin-query" id="deleteInstructor">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('instructor.delete')}}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} Partner </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}}</h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="instructorDeleteId">

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="impersonatePartner">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('impersonate') }}" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo e(__('common.Impersonate')); ?> Partner </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4><?php echo e(__('common.Are you sure to impersonate ?')); ?></h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="impersonatePartnerId">

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal"><?php echo e(__('common.Cancel')); ?></button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit"><?php echo e(__('common.Impersonate')); ?></button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="allowInstructorCourseApi">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('instructor.course_api_key')}}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Allow Course Api Key')}} Partner </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('Are you sure to allow this function to this partner ?')}}</h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="instructorCourseApiKeyId">

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Save')}}</button>

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
        $url = route('get_all_partner_data');
    @endphp

    <script>
        tableLoadPartner = () => {
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
                    {data: 'status', name: 'status', orderable: false},
                    @if (isAdmin() || isHRDCorp())
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
        }
        $('#lms_table').on('preXhr.dt', function (e, settings, data) {
            var partnerName = $('#partner_name').val();
            var emailAddress = $('#email_address').val();
            var searchPartnerStatus = $('#search_partner_status').val();

            data['partner_name'] = partnerName;
            data['email_address'] = emailAddress;
            data['search_partner_status'] = searchPartnerStatus;
        });

        $(document).on("click", ".view_partner_btn", function() {
            var id = $(this).data("id");
            var url = "{{ route('view_partner',':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $("#editInstructor").html(data);
                    $('#editInstructor').modal('show');
                }
            });
        });
        $(document).on("click", ".impersonate_partner_btn", function() {
            let id = $(this).data('id');
            $('#impersonatePartnerId').val(id);
            $("#impersonatePartner").modal('show');
        });

        $(document).on("click", ".edit_partner_btn", function() {
            var id = $(this).data("id");
            var url = "{{ route('edit_partner',':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $("#editInstructor").html(data);
                    $('#editInstructor').modal('show');
                }
            });
        });

        $(document).on('change', '.enabled_package', function() {
            let partner_id = $(this).attr('data-id');
            let enabled_package = $(this).attr('data-enabled-package');

            $.ajax({
                type: "post",
                url: "{!! route('change_enabled_package_status') !!}",
                data: {
                    partner_id: partner_id,
                    enabled_package: enabled_package,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status) {
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

        $(function() {
            tableLoadPartner();
        });
    </script>

    <script>
        $('#apply-filters-partner').click(function () {
            tableLoadPartner();
        });
        $('#export-filters-partner').click(function () {
            $("#filter-form-partner").submit();
        });
    </script>
    <script src="{{asset('backend/js/instructor_list.js')}}"></script>
@endpush



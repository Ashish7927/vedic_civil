@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}"/>
@endpush
@php
    $table_name='users';
@endphp
@section('table'){{$table_name}}@endsection

@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('student.Admin')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('student.Admin')}}</a>
                    <a href="#">{{__('student.Admin List')}}</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('student.Admin List')}}</h3>

                            <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                           id="add_admin_btn"
                                           data-target="#add_admin" href="#"><i
                                                    class="ti-plus"></i>{{__('student.Add Admin')}}</a>
                                    </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-40">
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
                                        @if(isModuleActive('OrgInstructorPolicy'))
                                            <th scope="col">{{__('policy.Group')}} {{__('policy.Policy')}}</th>
                                        @endif
                                        <th scope="col">{{__('common.Status')}}</th>
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
                <div class="modal fade admin-query" id="add_admin">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('student.Add New Admin')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('permission.admin.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" placeholder="-"
                                                       type="text" id="addName"
                                                       value="{{ old('name') }}" {{$errors->first('name') ? 'autofocus' : ''}}>
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
                                                                <input placeholder="Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="startDate" type="text" name="dob"
                                                                       value="{{ old('dob') }}"
                                                                       autocomplete="off" {{$errors->first('dob') ? 'autofocus' : ''}} data-date-format="dd/mm/yyyy">
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
                                                <input class="primary_input_field input-phone" value="{{ old('phone') }}"
                                                       name="phone" id="addPhone"
                                                       placeholder="-" style="width:100%"
                                                       type="text" {{$errors->first('phone') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="country_code" name="country_code" id="country_code" value="{{ old('country_code') }}"/>
                                    <script type="text/javascript">
                                        $('.input-phone').keyup(function(){
                                            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                            var countryCode = countryCode.replace(/[^0-9]/g,'');
                                            $('.country_code').val("");
                                            $('.country_code').val("+"+countryCode);
                                        });
                                    </script>
<?php $version = 'v=' . config('app.version'); ?>
<script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}?{{ $version }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}?{{ $version }}"/>

<?php
$countryc= old('country_code');
if ($countryc!='') {
    $countryc = old('country_code');
    $countrycode = str_replace('+','',$countryc);
    $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
    $countryiso = $countryname->iso2;
?>
<script>
    const phoneInputField = document.querySelector(".input-phone");
    const phoneInput = window.intlTelInput(phoneInputField,{
        initialCountry:"<?php echo $countryiso; ?>",
        utilsScript:"{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,
   });
</script>
<?php
} else {?>
    <script>
    const phoneInputField = document.querySelector(".input-phone");
    const phoneInput = window.intlTelInput(phoneInputField,{
        initialCountry:"my",
        utilsScript:"{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,
   });
</script>
<?php } ?>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Email')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" placeholder="-"
                                                       value="{{ old('email') }}" id="addEmail"
                                                       {{$errors->first('email') ? 'autofocus' : ''}}
                                                       type="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Role')}}</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                <select class="primary_select"
                                                    name="role_id" required>
                                                     @if(isset($roles))
                                                    @foreach ($roles as $role)
                                                        <option value="{{@$role->id}}"
                                                            {{old('role_id') == $role->id ? "selected" : ""}}>{{@$role->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('common.gender')}}
                                                </label>

                                                <select class="primary_select"
                                                        data-course_id="{{@$course->id}}" name="gender">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('common.gender')}}"
                                                        value="">{{__('common.Select')}} {{__('common.gender')}} </option>

                                                    <option value="male" {{old('gender') == 'male' ? "selected" : ""}}>Male</option>
                                                    <option value="female" {{old('gender') == 'female' ? "selected" : ""}} >Female</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Password')}}
                                                    <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i style="cursor:pointer;"
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
                                                       for="">{{__('common.Confirm Password')}} <strong
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
                                                {{--                                                    <input class="primary_input_field"  name="password_confirmation" placeholder="-" type="text">--}}
                                            </div>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} {{__('student.Admin')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <div class="modal fade admin-query" id="editAdmin">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('student.Update Admin')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('permission.admin.update')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{old('id')}}" id="adminId">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       value="{{old('name')}}" name="name"
                                                       placeholder="-" id="adminName"
                                                       type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Role')}}</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                <select class="primary_select"
                                                    name="role_id" required id="role_id_edit">
                                                     @if(isset($roles))
                                                    @foreach ($roles as $role)
                                                        <option value="{{@$role->id}}"
                                                            {{old('role_id') == $role->id ? "selected" : ""}}>{{@$role->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Date of Birth')}}  </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="adminDob"
                                                                       {{$errors->first('dob') ? 'autofocus' : ''}}
                                                                       type="text" name="dob"
                                                                       value="{{old('dob')}}"
                                                                       autocomplete="off" data-date-format="dd/mm/yyyy">
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
                                                <input class="primary_input_field input-phoneedit" id="adminPhone"
                                                       {{$errors->first('phone') ? 'autofocus' : ''}}
                                                       value="{{old('phone')}}" name="phone"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>
                                        <input type="hidden" class="country_codeedit" name="country_code" id="country_codeedit" value="{{ old('country_code') }}"/>
                                    <script type="text/javascript">
                                        $('.input-phoneedit').keyup(function(){
                                            var country_codeedit = $('.iti__selected-flag').slice(0).attr('title');
                                            var country_codeedit = country_codeedit.replace(/[^0-9]/g,'');
                                            $('.country_codeedit').val("");
                                            $('.country_codeedit').val("+"+country_codeedit);
                                        });
                                    </script>
<?php $version = 'v=' . config('app.version'); ?>
<script src="{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js')}}?{{ $version }}"></script>
<link rel="stylesheet" href="{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css')}}?{{ $version }}"/>
<?php
$countryc= old('country_code');
if($countryc!=''){
$countryc = old('country_code');
$countrycode = str_replace('+','',$countryc);
$countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
$countryiso = $countryname->iso2;
?>
<script>
    const phoneInputFieldedit = document.querySelector(".input-phoneedit");
    const phoneInputedit = window.intlTelInput(phoneInputFieldedit,{
        initialCountry:"<?php echo $countryiso; ?>",
        utilsScript:"{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,
   });
</script>
<?php
}else{?>
    <script>
    const phoneInputFieldedit = document.querySelector(".input-phoneedit");
    const phoneInputedit = window.intlTelInput(phoneInputFieldedit,{
        initialCountry:"my",
        utilsScript:"{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,
   });
</script>
<?php } ?>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Email')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       {{$errors->first('email') ? 'autofocus' : ''}}
                                                       value="{{old('email')}}" name="email" id="adminEmail"
                                                       placeholder="-" type="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('common.gender')}}
                                                </label>
                                                <select class="primary_select" name="gender"
                                                        id="adminGender">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('common.gender')}}"
                                                        value="">{{__('common.Select')}} {{__('common.gender')}} </option>

                                                    <option value="male" {{old('gender') == 'male' ? "selected" : ""}}>Male</option>
                                                    <option value="female" {{old('gender') == 'female' ? "selected" : ""}} >Female</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

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
                                                           {{$errors->first('password') ? 'autofocus' : ''}}
                                                           class="form-control primary_input_field"
                                                           id="password" name="password"
                                                           placeholder="{{__('common.Minimum 8 characters')}}">
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
                                                           id="passwordc"
                                                           {{$errors->first('password_confirmation') ? 'autofocus' : ''}}
                                                           name="password_confirmation"
                                                           placeholder="{{__('common.Minimum 8 characters')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="update_button_parent" type="submit"><i
                                                    class="ti-check"></i> {{__('student.Update Admin')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <div class="modal fade admin-query" id="deleteAdmin">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Delete')}} {{__('student.Admin')}} </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('permission.admin.delete')}}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="adminDeleteId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>

                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>

                                    </div>
                                </form>
                            </div>

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
            $('#add_admin').modal('show');
            @else
            $('#editAdmin').modal('show');
            @endif
            @endif
        </script>
    @endif


    @php
        $url = route('permission.admin.getAllAdminData');
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
                    @if(isModuleActive('OrgInstructorPolicy'))
                {
                    data: 'group_policy', name: 'group_policy'
                },
                    @endif
                {
                    data: 'status', name: 'status', orderable: false
                },
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

    <script src="{{asset('backend/js/admin_list.js')}}"></script>

 <script>
  function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }
</script>

@endpush

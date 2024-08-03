@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}" />
    <style>
        #lms_table_wrapper .dt-button-collection {
            max-height: 230px;
            overflow-y: scroll;
        }
    </style>
@endpush
@php
    $table_name = 'users';
@endphp
@section('table')
    {{ $table_name }}
@endsection

@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('student.Students') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('dashboard.Dashboard') }}</a>
                    <a href="#">{{ __('student.Students') }}</a>
                    <a href="#">{{ __('student.Students List') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-md-12 col-xs-12" id="filter_main_div">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('Filter Learners History') }}</h4>
                        </div>

                        <form id="filter-form" method="post" action="{{ route('learner_list_excel_download') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Sign up date from</label>
                                        <input class="primary_input_field" type="date" name="start_date" id="start_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Sign up date to</label>
                                        <input class="primary_input_field" type="date" name="end_date" id="end_date">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Name</label>
                                        <input class="primary_input_field" type="text" name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="primary_input form-group">
                                        <label class="primary_input_label">Email</label>
                                        <input class="primary_input_field" type="text" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Birth Date</label>
                                        <input class="primary_input_field" type="date" name="dob" id="dob">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Gender</label>
                                        <select class="primary_select" name="gender" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Phone Number</label>
                                        <input class="primary_input_field" type="text" name="phone" id="phone">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="primary_input_label">Highest Academic Qualification</label>
                                        <select class="primary_select" name="highest_academic" id="highest_academic_div">
                                            <option value="">Select Highest Academic Qualification</option>
                                            <option value="Primary School">Primary School</option>
                                            <option value="Secondary School">Secondary School</option>
                                            <option value="SPM/O-Level/SVM/equivalent">SPM/O-Level/SVM/equivalent</option>
                                            <option value="Bachelor's Degree/equivalent">Bachelor's Degree/equivalent
                                            </option>
                                            <option value="Master's Degree/equivalent">Master's Degree/equivalent</option>
                                            <option value="Doctoral Degree">Doctoral Degree</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            {{-- <hr> --}}
                            <div class="col-md-12 col-xl-12 mt-30">
                                <div class="search_course_btn">
                                    <button type="button" id="apply-filters"
                                        class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('common.Filter History') }}</button>
                                    <button type="button" id="reset-filters" class="btn btn-default"
                                        style="background:white;color:#1b191f;boder:1 px solid black;"
                                        data-dismiss="modal">Reset</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('student.Students List') }}</h3>

                            <ul class="d-flex">
                                @if (permissionCheck('student.store'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                            id="add_student_btn" data-target="#add_student" href="#"><i
                                                class="ti-plus"></i>{{ __('student.Add Student') }}</a>
                                    </li>
                                @endif
                                @if (isModuleActive('TeachOffline'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                            href="{{ route('student_import') }}"><i
                                                class="ti-plus"></i>{{ __('student.Import Student') }}</a></li>
                                @endif
                                <li>
                                    <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_import_table_data"
                                        href="javascript:void(0)">
                                        Export
                                    </a>
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
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('common.Email') }}</th>
                                            <th scope="col">{{ __('student.Phone') }}</th>
                                            <th scope="col">{{ __('courses.Courses') }}</th>
                                            <th scope="col">{{ __('Created At') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('Citizenship') }}</th>
                                            <th scope="col">{{ __('NRIC Number') }}</th>
                                            <th scope="col">{{ __('Job Designation') }}</th>
                                            <th scope="col">{{ __('Sector') }}</th>
                                            <th scope="col">{{ __('Not working status') }}</th>
                                            <th scope="col">{{ __('Business Nature/Activity') }}</th>
                                            <th scope="col">{{ __('Business Nature Others') }}</th>
                                            <th scope="col">{{ __('Postcode') }}</th>
                                            <th scope="col">{{ __('common.gender') }}</th>
                                            <th scope="col">{{ __('common.Date of Birth') }}</th>
                                            <th scope="col">{{ __('common.Country') }}</th>
                                            <th scope="col">{{ __('common.Race') }}</th>
                                            <th scope="col">{{ __('common.employment_status') }}</th>
                                            <th scope="col">{{ __('common.highest_academic') }}</th>
                                            <th scope="col">{{ __('common.current_residing') }}</th>
                                            {{-- <th scope="col">{{__('POSTCODE')}}</th> --}}
                                            <th scope="col">{{ __('common.Action') }}</th>
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
                <div class="modal fade admin-query" id="add_student">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('student.Add New Student') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data"
                                    id="student_store">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Name') }}
                                                    <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" placeholder="-"
                                                    type="text" id="addName" value="{{ old('name') }}"
                                                    {{ $errors->first('name') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Date of Birth') }}
                                                </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date"
                                                                    class="primary_input_field primary-input date form-control"
                                                                    id="startDate" type="text" name="dob"
                                                                    value="{{ old('dob') }}" autocomplete="off"
                                                                    {{ $errors->first('dob') ? 'autofocus' : '' }}
                                                                    data-date-format="dd/mm/yyyy">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Phone') }} </label>
                                                <input class="primary_input_field input-phone"
                                                    value="{{ old('phone') }}" name="phone" id="addPhone"
                                                    placeholder="-" style="width:100%" type="text"
                                                    {{ $errors->first('phone') ? 'autofocus' : '' }}
                                                    onkeypress="javascript:return isNumber(event)">
                                            </div>
                                        </div>
                                    {{-- </div> --}}
                                    <input type="hidden" class="country_code" name="country_code" id="country_code"
                                        value="{{ old('country_code') }}" />
                                    <script type="text/javascript">
                                        $('.input-phone').keyup(function() {
                                            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                            var countryCode = countryCode.replace(/[^0-9]/g, '');
                                            $('.country_code').val("");
                                            $('.country_code').val("+" + countryCode);
                                        });
                                    </script>
                                    <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}"></script>
                                    <link rel="stylesheet"
                                        href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />

                                    <?php
                                    $countryc= old('country_code');
                                    if($countryc!=''){
                                    $countryc = old('country_code');
                                    $countrycode = str_replace('+','',$countryc);
                                    $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                                    $countryiso = $countryname->iso2;
                                    ?>
                                    <script>
                                        const phoneInputField = document.querySelector(".input-phone");
                                        const phoneInput = window.intlTelInput(phoneInputField, {
                                            initialCountry: "in",
                                            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                            separateDialCode: false,
                                            formatOnDisplay: false,
                                        });
                                    </script>
                                    <?php
                                        }else{?>
                                    <script>
                                        const phoneInputField = document.querySelector(".input-phone");
                                        const phoneInput = window.intlTelInput(phoneInputField, {
                                            initialCountry: "in",
                                            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                            separateDialCode: false,
                                            formatOnDisplay: false,
                                        });
                                    </script>
                                    <?php } ?>

                                    {{-- <div class="row"> --}}
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Email') }} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" placeholder="-"
                                                    value="{{ old('email') }}" id="addEmail"
                                                    {{ $errors->first('email') ? 'autofocus' : '' }} type="email">
                                            </div>
                                        </div>

                                        {{-- <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.gender') }}
                                                </label>

                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="gender">
                                                    <option
                                                        data-display="{{ __('common.Select') }} {{ __('common.gender') }}"
                                                        value="">{{ __('common.Select') }}
                                                        {{ __('common.gender') }} </option>

                                                    <option value="male"
                                                        {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female"
                                                        {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>

                                                </select>
                                            </div>
                                        </div> --}}


                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Password') }}
                                                    <strong class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                        id="addPassword" name="password"
                                                        placeholder="{{ __('common.Minimum 8 characters') }}"
                                                        {{ $errors->first('password') ? 'autofocus' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Confirm Password') }} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                        {{ $errors->first('password_confirmation') ? 'autofocus' : '' }}
                                                        id="addCpassword" name="password_confirmation"
                                                        placeholder="{{ __('common.Minimum 8 characters') }}">
                                                </div>
                                                {{--                                                    <input class="primary_input_field"  name="password_confirmation" placeholder="-" type="text"> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Working Status
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="employment_status" id="employment_status">
                                                    <option value="working"
                                                        {{ old('employment_status') == 'working' ? 'selected' : '' }}>
                                                        Working</option>
                                                    <option value="not-working"
                                                        {{ old('employment_status') == 'not-working' ? 'selected' : '' }}>
                                                        Not Working</option>
                                                    <option value="self-employed"
                                                        {{ old('employment_status') == 'self-employed' ? 'selected' : '' }}>
                                                        Self Employed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label>Highest Academic Qualification</label>
                                                <select class="primary_select" name="highest_academic" required>
                                                    <option value="Primary School"
                                                        {{ old('highest_academic') == 'Primary School' ? 'selected' : '' }}>
                                                        Primary School</option>
                                                    <option value="Secondary School"
                                                        {{ old('highest_academic') == 'Secondary School' ? 'selected' : '' }}>
                                                        Secondary School</option>
                                                    <option value="SPM/O-Level/SVM/equivalent"
                                                        {{ old('highest_academic') == 'SPM/O-Level/SVM/equivalent' ? 'selected' : '' }}>
                                                        SPM/O-Level/SVM/equivalent</option>
                                                    <option value="Bachelor's Degree/equivalent"
                                                        {{ old('highest_academic') == 'Bachelor\'s Degree/equivalent' ? 'selected' : '' }}>
                                                        Bachelor's Degree/equivalent</option>
                                                    <option value="Master's Degree/equivalent"
                                                        {{ old('highest_academic') == 'Master\'s Degree/equivalent' ? 'selected' : '' }}>
                                                        Master's Degree/equivalent</option>
                                                    <option value="Doctoral Degree"
                                                        {{ old('highest_academic') == 'Doctoral Degree' ? 'selected' : '' }}>
                                                        Doctoral Degree</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Current Residing City
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="current_residing">
                                                    <option value="Bhubaneswar"
                                                        @if (old('current_residing') == 'Bhubaneswar') {{ 'selected' }} @endif>Bhubaneswar
                                                    </option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Postcode
                                                </label>
                                                <input type="text" class="form-control primary_input_field"
                                                    value="{{ old('zip') }}" name="zip"
                                                    onkeypress="javascript:return isNumber(event)" placeholder="Postcode"
                                                    {{ $errors->first('zip') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="btn_save_student"
                                                type="submit"><i class="ti-check"></i> {{ __('common.Save') }}
                                                {{ __('student.Student') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editStudent">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            @if (isAdmin() || isHRDCorp() || isMyLL())
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('student.Update Student') }}</h4>
                                    <button type="button" class="close " data-dismiss="modal">
                                        <i class="ti-close "></i>
                                    </button>
                                </div>
                            @else
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('student.View Learner Profile') }}</h4>
                                    <button type="button" class="close " data-dismiss="modal">
                                        <i class="ti-close "></i>
                                    </button>
                                </div>
                            @endif

                            <div class="modal-body">
                                <form action="{{ route('student.update') }}" method="POST"
                                    enctype="multipart/form-data" id="student_update">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ old('id') }}" id="studentId">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Name') }} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" value="{{ old('name') }}"
                                                    name="name" placeholder="-" id="studentName" type="text"
                                                    {{ $errors->first('name') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        {{-- <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Date of Birth') }} </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date"
                                                                    class="primary_input_field primary-input date form-control"
                                                                    id="studentDob"
                                                                    {{ $errors->first('dob') ? 'autofocus' : '' }}
                                                                    type="text" name="dob"
                                                                    value="{{ old('dob') }}" autocomplete="off"
                                                                    data-date-format="dd/mm/yyyy">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Phone') }} </label>
                                                <input class="primary_input_field input-phoneedit" id="studentPhone"
                                                    {{ $errors->first('phone') ? 'autofocus' : '' }}
                                                    value="{{ old('phone') }}" name="phone" placeholder="-"
                                                    type="text" onkeypress="javascript:return isNumber(event)">
                                            </div>
                                        </div>
                                        <input type="hidden" class="country_codeedit" name="country_code"
                                            id="country_codeedit" value="{{ old('country_code') }}" />
                                        <script type="text/javascript">
                                            $('.input-phoneedit').keyup(function() {
                                                var country_codeedit = $('.iti__selected-flag').slice(0).attr('title');
                                                var country_codeedit = country_codeedit.replace(/[^0-9]/g, '');
                                                $('.country_codeedit').val("");
                                                $('.country_codeedit').val("+" + country_codeedit);
                                            });
                                        </script>
                                        <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}"></script>
                                        <link rel="stylesheet"
                                            href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />
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
                                            const phoneInputedit = window.intlTelInput(phoneInputFieldedit, {
                                                initialCountry: "<?php echo $countryiso; ?>",
                                                utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                                separateDialCode: false,
                                                formatOnDisplay: false,
                                            });
                                        </script>
                                        <?php
                                        }else{?>
                                        <script>
                                            const phoneInputFieldedit = document.querySelector(".input-phoneedit");
                                            const phoneInputedit = window.intlTelInput(phoneInputFieldedit, {
                                                initialCountry: "my",
                                                utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                                separateDialCode: false,
                                                formatOnDisplay: false,
                                            });
                                        </script>
                                        <?php } ?>
                                    {{-- </div>
                                    <div class="row"> --}}

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Email') }} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                    {{ $errors->first('email') ? 'autofocus' : '' }}
                                                    value="{{ old('email') }}" name="email" id="studentEmail"
                                                    placeholder="-" type="email">
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.gender') }}
                                                </label>
                                                <select class="primary_select" name="gender" id="studentGender">
                                                    <option
                                                        data-display="{{ __('common.Select') }} {{ __('common.gender') }}"
                                                        value="">{{ __('common.Select') }}
                                                        {{ __('common.gender') }} </option>

                                                    <option value="male"
                                                        {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female"
                                                        {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>

                                                </select>
                                            </div>
                                        </div> --}}

                                        
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Password') }} </label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password"
                                                        {{ $errors->first('password') ? 'autofocus' : '' }}
                                                        class="form-control primary_input_field" id="password"
                                                        name="password"
                                                        placeholder="{{ __('common.Minimum 8 characters') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Confirm Password') }}
                                                </label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                        id="password"
                                                        {{ $errors->first('password_confirmation') ? 'autofocus' : '' }}
                                                        name="password_confirmation"
                                                        placeholder="{{ __('common.Minimum 8 characters') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">Citizenship</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <select class="primary_select citizenshipedit" id="studentCitizenship"
                                                        name="citizenship" required>
                                                        <option value="Malaysian"
                                                            {{ old('citizenship') == 'Malaysian' ? 'selected' : '' }}>
                                                            Malaysian</option>
                                                        <option value="Non-Malaysian"
                                                            {{ old('citizenship') == 'Non-Malaysian' ? 'selected' : '' }}>
                                                            Non-Malaysian</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 nationalityeditdiv" <?php if(old('citizenship') == 'Non-Malaysian'){ ?>
                                            style="display:block" <?php }else{ ?> style="display:none"
                                            <?php
                                                    } ?>>
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">Nationality</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <select class="primary_select" id="studentnationality"
                                                        name="nationality">
                                                        @if (isset($countries))
                                                            @foreach ($countries as $country)
                                                                <option value="{{ @$country->id }}"
                                                                    @if ($country->id == '132') selected @endif>
                                                                    {{ @$country->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 raceeditdiv" <?php if(old('citizenship') == 'Malaysian'){ ?> style="display:block"
                                            <?php }else{ ?> style="display:none" <?php
                                                    } ?>>
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Race') }}
                                                </label>
                                                <select class="primary_select" name="race" id="studentRaceedit">

                                                    <option value="Malay"
                                                        {{ old('race') == 'Malay' ? 'selected' : '' }}>Malay</option>
                                                    <option value="Chinese"
                                                        {{ old('race') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                    <option value="Indian"
                                                        {{ old('race') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="Others"
                                                        {{ old('race') == 'Others' ? 'selected' : '' }}>Others</option>
                                                </select>
                                                <br />
                                                <div id="race_otheredit" <?php if(old('race') == 'Others'){ ?> style="display:block"
                                                    <?php }else{ ?> style="display:none" <?php
                                                    } ?>>
                                                    <label class="primary_input_label" for="">Race Others
                                                        <strong class="text-danger">*</strong></label>
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <input type="text" class="form-control primary_input_field"
                                                            value="{{ old('race_other') }}" id="race_other_input"
                                                            name="race_other" placeholder="Race Others"
                                                            {{ $errors->first('race_other') ? 'autofocus' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 raceeditdiv">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">NRIC Number
                                                </label>
                                                <input type="text" class="form-control primary_input_field"
                                                    id="nricnumber" value="{{ old('identification_number') }}"
                                                    onkeypress="javascript:return isNumber(event)"
                                                    name="identification_number" placeholder="NRIC Number"
                                                    {{ $errors->first('identification_number') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Working Status
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="employment_status" id="employment_statusedit">
                                                    <option value="working"
                                                        {{ old('employment_status') == 'working' ? 'selected' : '' }}>
                                                        Working</option>
                                                    <option value="not-working"
                                                        {{ old('employment_status') == 'not-working' ? 'selected' : '' }}>
                                                        Not Working</option>
                                                    <option value="self-employed"
                                                        {{ old('employment_status') == 'self-employed' ? 'selected' : '' }}>
                                                        Self Employed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6" <?php if(old('employment_status') == 'working'){ ?> style="display:block"
                                            <?php }else{ ?> style="display:none" <?php
                                                    } ?>
                                            id="job_designationedit">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Job Designation
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="job_designation" id="job_designationinput">
                                                    <option value="Manager"
                                                        {{ old('job_designation') == 'Manager' ? 'selected' : '' }}>
                                                        Manager</option>
                                                    <option value="Professional"
                                                        {{ old('job_designation') == 'Professional' ? 'selected' : '' }}>
                                                        Professional</option>
                                                    <option value="Technician and Associate Professional"
                                                        {{ old('job_designation') == 'Technician and Associate Professional' ? 'selected' : '' }}>
                                                        Technician and Associate Professional</option>
                                                    <option value="Clerical Support Worker"
                                                        {{ old('job_designation') == 'Clerical Support Worker' ? 'selected' : '' }}>
                                                        Clerical Support Worker</option>
                                                    <option value="Service and Sale Worker"
                                                        {{ old('job_designation') == 'Service and Sale Worker' ? 'selected' : '' }}>
                                                        Service and Sale Worker</option>
                                                    <option value="Skilled Agricultural,Forestry and Fishery Worker"
                                                        {{ old('job_designation') == 'Skilled Agricultural,Forestry and Fishery Worker' ? 'selected' : '' }}>
                                                        Skilled Agricultural,Forestry and Fishery Worker</option>
                                                    <option value="Craft and Related Trade Worker"
                                                        {{ old('job_designation') == 'Craft and Related Trade Worker' ? 'selected' : '' }}>
                                                        Craft and Related Trade Worker</option>
                                                    <option value="Elementary Worker"
                                                        {{ old('job_designation') == 'Elementary Worker' ? 'selected' : '' }}>
                                                        Elementary Worker</option>
                                                    <option value="Plant and Machine Operator and Assembler Worker"
                                                        {{ old('job_designation') == 'Plant and Machine Operator and Assembler Worker' ? 'selected' : '' }}>
                                                        Plant and Machine Operator and Assembler Worker</option>
                                                    <option value="Armed Forced Worker"
                                                        {{ old('job_designation') == 'Armed Forced Worker' ? 'selected' : '' }}>
                                                        Armed Forced Worker</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6" <?php if(old('employment_status') == 'self-employed'){ ?> style="display:block"
                                            <?php }else{ ?> style="display:none" <?php
                                                    } ?>
                                            id="business_natureedit">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Business Nature/Activity
                                                </label>
                                                <select class="primary_select business_natureedit"
                                                    data-course_id="{{ @$course->id }}" name="business_nature">
                                                    <option value="Accomodation/Food Beverage service Activities"
                                                        {{ old('business_nature') == 'Accomodation/Food Beverage service Activities' ? 'selected' : '' }}>
                                                        Accomodation/Food Beverage service Activities</option>
                                                    <option value="Agriculture/Forestry/Fishing"
                                                        {{ old('business_nature') == 'Agriculture/Forestry/Fishing' ? 'selected' : '' }}>
                                                        Agriculture/Forestry/Fishing</option>
                                                    <option value="Arts/Entertainment/Recreation/Construction"
                                                        {{ old('business_nature') == 'Arts/Entertainment/Recreation/Construction' ? 'selected' : '' }}>
                                                        Arts/Entertainment/Recreation/Construction</option>
                                                    <option value="Education"
                                                        {{ old('business_nature') == 'Education' ? 'selected' : '' }}>
                                                        Education</option>
                                                    <option value="Electricity/Gas/Steam/Air conditioning Supply"
                                                        {{ old('business_nature') == 'Electricity/Gas/Steam/Air conditioning Supply' ? 'selected' : '' }}>
                                                        Electricity/Gas/Steam/Air conditioning Supply</option>
                                                    <option value="Financial/Insurance/Takaful activities"
                                                        {{ old('business_nature') == 'Financial/Insurance/Takaful activities' ? 'selected' : '' }}>
                                                        Financial/Insurance/Takaful activities</option>
                                                    <option value="Human Health/Social Work Activities"
                                                        {{ old('business_nature') == 'Human Health/Social Work Activities' ? 'selected' : '' }}>
                                                        Human Health/Social Work Activities</option>
                                                    <option value="Information/Communication"
                                                        {{ old('business_nature') == 'Information/Communication' ? 'selected' : '' }}>
                                                        Information/Communication</option>
                                                    <option value="Manufacturing"
                                                        {{ old('business_nature') == 'Manufacturing' ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="Mining/Quarrying"
                                                        {{ old('business_nature') == 'Mining/Quarrying' ? 'selected' : '' }}>
                                                        Mining/Quarrying</option>
                                                    <option value="Professional/Scientific/Technical Activities"
                                                        {{ old('business_nature') == 'Professional/Scientific/Technical Activities' ? 'selected' : '' }}>
                                                        Professional/Scientific/Technical Activities</option>
                                                    <option
                                                        value="Public Administration/Defence/Compulsory Social Security"
                                                        {{ old('business_nature') == 'Public Administration/Defence/Compulsory Social Security' ? 'selected' : '' }}>
                                                        Public Administration/Defence/Compulsory Social Security</option>
                                                    <option value="Real Estate Activities"
                                                        {{ old('business_nature') == 'Real Estate Activities' ? 'selected' : '' }}>
                                                        Real Estate Activities</option>
                                                    <option value="Transportation/Storage"
                                                        {{ old('business_nature') == 'Transportation/Storage' ? 'selected' : '' }}>
                                                        Transportation/Storage</option>
                                                    <option
                                                        value="Water Supply/Sewage/Waste Management/Remediation Activities"
                                                        {{ old('business_nature') == 'Water Supply/Sewage/Waste Management/Remediation Activities' ? 'selected' : '' }}>
                                                        Water Supply/Sewage/Waste Management/Remediation Activities</option>
                                                    <option
                                                        value="Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles"
                                                        {{ old('business_nature') == 'Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles' ? 'selected' : '' }}>
                                                        Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles</option>
                                                    <option value="Others"
                                                        {{ old('business_nature') == 'Others' ? 'selected' : '' }}>Others
                                                    </option>
                                                </select>
                                                <br />
                                                <div class="col-12 mt_20" id="business_nature_otheredit"
                                                    <?php if(old('business_nature') == 'Others'){ ?> style="display:block" <?php }else{ ?>
                                                    style="display:none" <?php
                                                    } ?>>
                                                    <br />
                                                    <div class="input-group custom_group_field">
                                                        <input type="text" class="form-control primary_input_field"
                                                            placeholder="Business Nature Other"
                                                            aria-label="business_nature_other"
                                                            name="business_nature_other"
                                                            value="{{ old('business_nature_other') }}"
                                                            id="business_nature_otherinput">
                                                    </div>
                                                    <span class="text-danger"
                                                        role="alert">{{ $errors->first('business_nature_other') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6" <?php if(old('employment_status') == 'not-working'){ ?> style="display:block"
                                            <?php }else{ ?> style="display:none" <?php
                                                    } ?>
                                            id="not_workingedit">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Not Working Status
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="not_working" id="not_working">
                                                    <option value="Student"
                                                        {{ old('not_working') == 'Student' ? 'selected' : '' }}>Student
                                                    </option>
                                                    <option value="Fresh Graduate"
                                                        {{ old('not_working') == 'Fresh Graduate' ? 'selected' : '' }}>
                                                        Fresh Graduate</option>
                                                    <option value="Retrenched"
                                                        {{ old('not_working') == 'Retrenched' ? 'selected' : '' }}>
                                                        Retrenched</option>
                                                    <option value="Retired"
                                                        {{ old('not_working') == 'Retired' ? 'selected' : '' }}>Retired
                                                    </option>
                                                    <option value="Home Worker/House Wife"
                                                        {{ old('not_working') == 'Home Worker/House Wife' ? 'selected' : '' }}>
                                                        Home Worker/House Wife</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" <?php if(old('employment_status') == 'working'){ ?> style="display:block" <?php }else{ ?>
                                        style="display:none" <?php
                                                    } ?> id="sectoredit">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Sector
                                                </label>
                                                <select class="primary_select sectoredit" name="sector">
                                                    <option value="Manufacturing"
                                                        {{ old('sector') == 'Manufacturing' ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="Mining and quarrying"
                                                        {{ old('sector') == 'Mining and quarrying' ? 'selected' : '' }}>
                                                        Mining and quarrying</option>
                                                    <option value="Construction"
                                                        {{ old('sector') == 'Construction' ? 'selected' : '' }}>
                                                        Construction</option>
                                                    <option value="Agriculture"
                                                        {{ old('sector') == 'Agriculture' ? 'selected' : '' }}>Agriculture
                                                    </option>
                                                    <option value="Government"
                                                        {{ old('sector') == 'Government' ? 'selected' : '' }}>Government
                                                    </option>
                                                    <option value="NGO"
                                                        {{ old('sector') == 'NGO' ? 'selected' : '' }}>NGO</option>
                                                    <option value="Services(eg: Financial Institution, Hospitality, F&B)"
                                                        {{ old('sector') == 'Services(eg: Financial Institution, Hospitality, F&B)' ? 'selected' : '' }}>
                                                        Services(eg: Financial Institution, Hospitality, F&B)</option>
                                                    <option value="Others"
                                                        {{ old('sector') == 'Others' ? 'selected' : '' }}>Others</option>
                                                </select>
                                                <br />
                                                <div id="sector_otheredit" <?php if(old('sector') == 'Others'){ ?> style="display:block"
                                                    <?php }else{ ?> style="display:none" <?php
                                                    } ?>>
                                                    <label class="primary_input_label" for="">Sector Others
                                                        <strong class="text-danger">*</strong></label>
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <input type="text" class="form-control primary_input_field"
                                                            id="sector_otherinput" value="{{ old('sector_other') }}"
                                                            name="sector_other" placeholder="Sector Others"
                                                            {{ $errors->first('sector_other') ? 'autofocus' : '' }}>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label>Highest Academic Qualification</label>
                                                <select class="primary_select" name="highest_academic"
                                                    id="highest_academic" required>
                                                    <option value="Primary School"
                                                        {{ old('highest_academic') == 'Primary School' ? 'selected' : '' }}>
                                                        Primary School</option>
                                                    <option value="Secondary School"
                                                        {{ old('highest_academic') == 'Secondary School' ? 'selected' : '' }}>
                                                        Secondary School</option>
                                                    <option value="SPM/O-Level/SVM/equivalent"
                                                        {{ old('highest_academic') == 'SPM/O-Level/SVM/equivalent' ? 'selected' : '' }}>
                                                        SPM/O-Level/SVM/equivalent</option>
                                                    <option value="Bachelor's Degree/equivalent"
                                                        {{ old('highest_academic') == 'Bachelor\'s Degree/equivalent' ? 'selected' : '' }}>
                                                        Bachelor's Degree/equivalent</option>
                                                    <option value="Master's Degree/equivalent"
                                                        {{ old('highest_academic') == 'Master\'s Degree/equivalent' ? 'selected' : '' }}>
                                                        Master's Degree/equivalent</option>
                                                    <option value="Doctoral Degree"
                                                        {{ old('highest_academic') == 'Doctoral Degree' ? 'selected' : '' }}>
                                                        Doctoral Degree</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Current Residing State
                                                </label>
                                                <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                    name="current_residing" id="current_residing">
                                                    <option value="Kuala Lumpur"
                                                        {{ old('current_residing') == 'Kuala Lumpur' ? 'selected' : '' }}>
                                                        Kuala Lumpur</option>
                                                    <option value="Selangor"
                                                        {{ old('current_residing') == 'Selangor' ? 'selected' : '' }}>
                                                        Selangor</option>
                                                    <option value="Putrajaya"
                                                        {{ old('current_residing') == 'Putrajaya' ? 'selected' : '' }}>
                                                        Putrajaya</option>
                                                    <option value="Labuan"
                                                        {{ old('current_residing') == 'Labuan' ? 'selected' : '' }}>Labuan
                                                    </option>
                                                    <option
                                                        value="Sabah"{{ old('current_residing') == 'Sabah' ? 'selected' : '' }}>
                                                        Sabah</option>
                                                    <option value="Sarawak"
                                                        {{ old('current_residing') == 'Sarawak' ? 'selected' : '' }}>
                                                        Sarawak</option>
                                                    <option value="Melaka"
                                                        {{ old('current_residing') == 'Melaka' ? 'selected' : '' }}>Melaka
                                                    </option>
                                                    <option value="Kelantan"
                                                        {{ old('current_residing') == 'Kelantan' ? 'selected' : '' }}>
                                                        Kelantan</option>
                                                    <option value="Pahang"
                                                        {{ old('current_residing') == 'Pahang' ? 'selected' : '' }}>Pahang
                                                    </option>
                                                    <option value="Perak"
                                                        {{ old('current_residing') == 'Perak' ? 'selected' : '' }}>Perak
                                                    </option>
                                                    <option value="Pulau Pinang"
                                                        {{ old('current_residing') == 'Pulau Pinang' ? 'selected' : '' }}>
                                                        Pulau Pinang</option>
                                                    <option value="Negeri Sembilan"
                                                        {{ old('current_residing') == 'Negeri Sembilan' ? 'selected' : '' }}>
                                                        Negeri Sembilan</option>
                                                    <option value="Kedah"
                                                        {{ old('current_residing') == 'Kedah' ? 'selected' : '' }}>Kedah
                                                    </option>
                                                    <option value="Perlis"
                                                        {{ old('current_residing') == 'Perlis' ? 'selected' : '' }}>Perlis
                                                    </option>
                                                    <option value="Johor"
                                                        {{ old('current_residing') == 'Johor' ? 'selected' : '' }}>Johor
                                                    </option>
                                                    <option value="Terengganu"
                                                        {{ old('current_residing') == 'Terengganu' ? 'selected' : '' }}>
                                                        Terengganu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 ">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">Postcode
                                                </label>
                                                <input type="text" class="form-control primary_input_field"
                                                    id="zipedit" value="{{ old('zip') }}" name="zip"
                                                    onkeypress="javascript:return isNumber(event)" placeholder="Postcode"
                                                    {{ $errors->first('zip') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    @if (isAdmin() || isHRDCorp() || isMyLL())
                                        <div class="col-lg-12 text-center pt_15">
                                            <div class="d-flex justify-content-center">
                                                <button class="primary-btn semi_large2  fix-gr-bg" id="btn_update_student"
                                                    type="submit"><i class="ti-check"></i>
                                                    {{ __('student.Update Student') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="viewLearnerProfile">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('student.View Learner Profile') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ old('id') }}" id="studentId">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.Name') }}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field" value="{{ old('name') }}"
                                                name="name" placeholder="-" id="studentName" type="text"
                                                {{ $errors->first('name') ? 'autofocus' : '' }}>
                                        </div>
                                    </div>

                                </div>
                               
                                <div class="row">
                                    {{-- <div class="col-xl-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                for="">{{ __('common.Date of Birth') }} </label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                class="primary_input_field primary-input date form-control"
                                                                id="studentDob"
                                                                {{ $errors->first('dob') ? 'autofocus' : '' }}
                                                                type="text" name="dob"
                                                                value="{{ old('dob') }}" autocomplete="off"
                                                                data-date-format="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.Phone') }}
                                            </label>
                                            <input class="primary_input_field input-phoneedit" id="studentPhone"
                                                {{ $errors->first('phone') ? 'autofocus' : '' }}
                                                value="{{ old('phone') }}" name="phone" placeholder="-"
                                                type="text" onkeypress="javascript:return isNumber(event)">
                                        </div>
                                    </div>
                                    <input type="hidden" class="country_codeedit" name="country_code"
                                        id="country_codeedit" value="{{ old('country_code') }}" />
                                    <script type="text/javascript">
                                        $('.input-phoneedit').keyup(function() {
                                            var country_codeedit = $('.iti__selected-flag').slice(0).attr('title');
                                            var country_codeedit = country_codeedit.replace(/[^0-9]/g, '');
                                            $('.country_codeedit').val("");
                                            $('.country_codeedit').val("+" + country_codeedit);
                                        });
                                    </script>
                                    <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}"></script>
                                    <link rel="stylesheet"
                                        href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />
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
                                        const phoneInputedit = window.intlTelInput(phoneInputFieldedit, {
                                            initialCountry: "<?php echo $countryiso; ?>",
                                            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                            separateDialCode: false,
                                            formatOnDisplay: false,
                                        });
                                    </script>
                                    <?php
                                        }else{?>
                                    <script>
                                        const phoneInputFieldedit = document.querySelector(".input-phoneedit");
                                        const phoneInputedit = window.intlTelInput(phoneInputFieldedit, {
                                            initialCountry: "my",
                                            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                                            separateDialCode: false,
                                            formatOnDisplay: false,
                                        });
                                    </script>
                                    <?php } ?>
                                {{-- </div>
                                <div class="row"> --}}

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.Email') }}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field"
                                                {{ $errors->first('email') ? 'autofocus' : '' }}
                                                value="{{ old('email') }}" name="email" id="studentEmail"
                                                placeholder="-" type="email">
                                        </div>
                                    </div>
                                    {{-- <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('common.gender') }}
                                            </label>
                                            <select class="primary_select" name="gender" id="studentGender">
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('common.gender') }}"
                                                    value="">{{ __('common.Select') }} {{ __('common.gender') }}
                                                </option>

                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                    Female</option>

                                            </select>
                                        </div>
                                    </div> --}}

                                    
                                </div>
                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="">{{ __('common.Password') }} </label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i style="cursor:pointer;"
                                                            class="fas fa-eye-slash eye toggle-password"></i>
                                                    </div>
                                                </div>
                                                <input type="password"
                                                    {{ $errors->first('password') ? 'autofocus' : '' }}
                                                    class="form-control primary_input_field" id="password"
                                                    name="password"
                                                    placeholder="{{ __('common.Minimum 8 characters') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="">{{ __('common.Confirm Password') }}
                                            </label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i style="cursor:pointer;"
                                                            class="fas fa-eye-slash eye toggle-password"></i>
                                                    </div>
                                                </div>
                                                <input type="password" class="form-control primary_input_field"
                                                    id="password"
                                                    {{ $errors->first('password_confirmation') ? 'autofocus' : '' }}
                                                    name="password_confirmation"
                                                    placeholder="{{ __('common.Minimum 8 characters') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">Citizenship</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <select class="primary_select citizenshipedit" id="studentCitizenship"
                                                    name="citizenship" required>
                                                    <option value="Malaysian"
                                                        {{ old('citizenship') == 'Malaysian' ? 'selected' : '' }}>
                                                        Malaysian</option>
                                                    <option value="Non-Malaysian"
                                                        {{ old('citizenship') == 'Non-Malaysian' ? 'selected' : '' }}>
                                                        Non-Malaysian</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 nationalityeditdiv" <?php if(old('citizenship') == 'Non-Malaysian'){ ?> style="display:block"
                                        <?php }else{ ?> style="display:none" <?php
                                            } ?>>
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">Nationality</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <select class="primary_select" id="studentnationality"
                                                    name="nationality">
                                                    @if (isset($countries))
                                                        @foreach ($countries as $country)
                                                            <option value="{{ @$country->id }}"
                                                                @if ($country->id == '132') selected @endif>
                                                                {{ @$country->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 raceeditdiv" <?php if(old('citizenship') == 'Malaysian'){ ?> style="display:block"
                                        <?php }else{ ?> style="display:none" <?php
                                            } ?>>
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('common.Race') }}
                                            </label>
                                            <select class="primary_select" name="race" id="studentRaceedit">

                                                <option value="Malay" {{ old('race') == 'Malay' ? 'selected' : '' }}>
                                                    Malay</option>
                                                <option value="Chinese" {{ old('race') == 'Chinese' ? 'selected' : '' }}>
                                                    Chinese</option>
                                                <option value="Indian" {{ old('race') == 'Indian' ? 'selected' : '' }}>
                                                    Indian</option>
                                                <option value="Others" {{ old('race') == 'Others' ? 'selected' : '' }}>
                                                    Others</option>
                                            </select>
                                            <br />
                                            <div id="race_otheredit" <?php if(old('race') == 'Others'){ ?> style="display:block"
                                                <?php }else{ ?> style="display:none" <?php
                                                    } ?>>
                                                <label class="primary_input_label" for="">Race Others
                                                    <strong class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <input type="text" class="form-control primary_input_field"
                                                        value="{{ old('race_other') }}" id="race_other_input"
                                                        name="race_other" placeholder="Race Others"
                                                        {{ $errors->first('race_other') ? 'autofocus' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 raceeditdiv">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">NRIC Number
                                            </label>
                                            <input type="text" class="form-control primary_input_field"
                                                id="nricnumber" value="{{ old('identification_number') }}"
                                                onkeypress="javascript:return isNumber(event)"
                                                name="identification_number" placeholder="NRIC Number"
                                                {{ $errors->first('identification_number') ? 'autofocus' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Working Status
                                            </label>
                                            <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                name="employment_status" id="employment_statusedit">
                                                <option value="working"
                                                    {{ old('employment_status') == 'working' ? 'selected' : '' }}>Working
                                                </option>
                                                <option value="not-working"
                                                    {{ old('employment_status') == 'not-working' ? 'selected' : '' }}>Not
                                                    Working</option>
                                                <option value="self-employed"
                                                    {{ old('employment_status') == 'self-employed' ? 'selected' : '' }}>
                                                    Self Employed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" <?php if(old('employment_status') == 'working'){ ?> style="display:block" <?php }else{ ?>
                                        style="display:none" <?php
                                             } ?> id="job_designationedit">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Job Designation
                                            </label>
                                            <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                name="job_designation" id="job_designationinput">
                                                <option value="Manager"
                                                    {{ old('job_designation') == 'Manager' ? 'selected' : '' }}>Manager
                                                </option>
                                                <option value="Professional"
                                                    {{ old('job_designation') == 'Professional' ? 'selected' : '' }}>
                                                    Professional</option>
                                                <option value="Technician and Associate Professional"
                                                    {{ old('job_designation') == 'Technician and Associate Professional' ? 'selected' : '' }}>
                                                    Technician and Associate Professional</option>
                                                <option value="Clerical Support Worker"
                                                    {{ old('job_designation') == 'Clerical Support Worker' ? 'selected' : '' }}>
                                                    Clerical Support Worker</option>
                                                <option value="Service and Sale Worker"
                                                    {{ old('job_designation') == 'Service and Sale Worker' ? 'selected' : '' }}>
                                                    Service and Sale Worker</option>
                                                <option value="Skilled Agricultural,Forestry and Fishery Worker"
                                                    {{ old('job_designation') == 'Skilled Agricultural,Forestry and Fishery Worker' ? 'selected' : '' }}>
                                                    Skilled Agricultural,Forestry and Fishery Worker</option>
                                                <option value="Craft and Related Trade Worker"
                                                    {{ old('job_designation') == 'Craft and Related Trade Worker' ? 'selected' : '' }}>
                                                    Craft and Related Trade Worker</option>
                                                <option value="Elementary Worker"
                                                    {{ old('job_designation') == 'Elementary Worker' ? 'selected' : '' }}>
                                                    Elementary Worker</option>
                                                <option value="Plant and Machine Operator and Assembler Worker"
                                                    {{ old('job_designation') == 'Plant and Machine Operator and Assembler Worker' ? 'selected' : '' }}>
                                                    Plant and Machine Operator and Assembler Worker</option>
                                                <option value="Armed Forced Worker"
                                                    {{ old('job_designation') == 'Armed Forced Worker' ? 'selected' : '' }}>
                                                    Armed Forced Worker</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" <?php if(old('employment_status') == 'self-employed'){ ?> style="display:block"
                                        <?php }else{ ?> style="display:none" <?php
                                             } ?>
                                        id="business_natureedit">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Business Nature/Activity
                                            </label>
                                            <select class="primary_select business_natureedit"
                                                data-course_id="{{ @$course->id }}" name="business_nature">
                                                <option value="Accomodation/Food Beverage service Activities"
                                                    {{ old('business_nature') == 'Accomodation/Food Beverage service Activities' ? 'selected' : '' }}>
                                                    Accomodation/Food Beverage service Activities</option>
                                                <option value="Agriculture/Forestry/Fishing"
                                                    {{ old('business_nature') == 'Agriculture/Forestry/Fishing' ? 'selected' : '' }}>
                                                    Agriculture/Forestry/Fishing</option>
                                                <option value="Arts/Entertainment/Recreation/Construction"
                                                    {{ old('business_nature') == 'Arts/Entertainment/Recreation/Construction' ? 'selected' : '' }}>
                                                    Arts/Entertainment/Recreation/Construction</option>
                                                <option value="Education"
                                                    {{ old('business_nature') == 'Education' ? 'selected' : '' }}>
                                                    Education</option>
                                                <option value="Electricity/Gas/Steam/Air conditioning Supply"
                                                    {{ old('business_nature') == 'Electricity/Gas/Steam/Air conditioning Supply' ? 'selected' : '' }}>
                                                    Electricity/Gas/Steam/Air conditioning Supply</option>
                                                <option value="Financial/Insurance/Takaful activities"
                                                    {{ old('business_nature') == 'Financial/Insurance/Takaful activities' ? 'selected' : '' }}>
                                                    Financial/Insurance/Takaful activities</option>
                                                <option value="Human Health/Social Work Activities"
                                                    {{ old('business_nature') == 'Human Health/Social Work Activities' ? 'selected' : '' }}>
                                                    Human Health/Social Work Activities</option>
                                                <option value="Information/Communication"
                                                    {{ old('business_nature') == 'Information/Communication' ? 'selected' : '' }}>
                                                    Information/Communication</option>
                                                <option value="Manufacturing"
                                                    {{ old('business_nature') == 'Manufacturing' ? 'selected' : '' }}>
                                                    Manufacturing</option>
                                                <option value="Mining/Quarrying"
                                                    {{ old('business_nature') == 'Mining/Quarrying' ? 'selected' : '' }}>
                                                    Mining/Quarrying</option>
                                                <option value="Professional/Scientific/Technical Activities"
                                                    {{ old('business_nature') == 'Professional/Scientific/Technical Activities' ? 'selected' : '' }}>
                                                    Professional/Scientific/Technical Activities</option>
                                                <option value="Public Administration/Defence/Compulsory Social Security"
                                                    {{ old('business_nature') == 'Public Administration/Defence/Compulsory Social Security' ? 'selected' : '' }}>
                                                    Public Administration/Defence/Compulsory Social Security</option>
                                                <option value="Real Estate Activities"
                                                    {{ old('business_nature') == 'Real Estate Activities' ? 'selected' : '' }}>
                                                    Real Estate Activities</option>
                                                <option value="Transportation/Storage"
                                                    {{ old('business_nature') == 'Transportation/Storage' ? 'selected' : '' }}>
                                                    Transportation/Storage</option>
                                                <option
                                                    value="Water Supply/Sewage/Waste Management/Remediation Activities"
                                                    {{ old('business_nature') == 'Water Supply/Sewage/Waste Management/Remediation Activities' ? 'selected' : '' }}>
                                                    Water Supply/Sewage/Waste Management/Remediation Activities</option>
                                                <option
                                                    value="Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles"
                                                    {{ old('business_nature') == 'Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles' ? 'selected' : '' }}>
                                                    Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles</option>
                                                <option value="Others"
                                                    {{ old('business_nature') == 'Others' ? 'selected' : '' }}>Others
                                                </option>
                                            </select>
                                            <br />
                                            <div class="col-12 mt_20" id="business_nature_otheredit"
                                                <?php if(old('business_nature') == 'Others'){ ?> style="display:block" <?php }else{ ?>
                                                style="display:none" <?php
                                                    } ?>>
                                                <br />
                                                <div class="input-group custom_group_field">
                                                    <input type="text" class="form-control primary_input_field"
                                                        placeholder="Business Nature Other"
                                                        aria-label="business_nature_other" name="business_nature_other"
                                                        value="{{ old('business_nature_other') }}"
                                                        id="business_nature_otherinput">
                                                </div>
                                                <span class="text-danger"
                                                    role="alert">{{ $errors->first('business_nature_other') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" <?php if(old('employment_status') == 'not-working'){ ?> style="display:block"
                                        <?php }else{ ?> style="display:none" <?php
                                             } ?>
                                        id="not_workingedit">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Not Working Status
                                            </label>
                                            <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                name="not_working" id="not_working">
                                                <option value="Student"
                                                    {{ old('not_working') == 'Student' ? 'selected' : '' }}>Student
                                                </option>
                                                <option value="Fresh Graduate"
                                                    {{ old('not_working') == 'Fresh Graduate' ? 'selected' : '' }}>Fresh
                                                    Graduate</option>
                                                <option value="Retrenched"
                                                    {{ old('not_working') == 'Retrenched' ? 'selected' : '' }}>Retrenched
                                                </option>
                                                <option value="Retired"
                                                    {{ old('not_working') == 'Retired' ? 'selected' : '' }}>Retired
                                                </option>
                                                <option value="Home Worker/House Wife"
                                                    {{ old('not_working') == 'Home Worker/House Wife' ? 'selected' : '' }}>
                                                    Home Worker/House Wife</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" <?php if(old('employment_status') == 'working'){ ?> style="display:block" <?php }else{ ?>
                                    style="display:none" <?php
                                         } ?> id="sectoredit">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Sector
                                            </label>
                                            <select class="primary_select sectoredit" name="sector">
                                                <option value="Manufacturing"
                                                    {{ old('sector') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                                                </option>
                                                <option value="Mining and quarrying"
                                                    {{ old('sector') == 'Mining and quarrying' ? 'selected' : '' }}>Mining
                                                    and quarrying</option>
                                                <option value="Construction"
                                                    {{ old('sector') == 'Construction' ? 'selected' : '' }}>Construction
                                                </option>
                                                <option value="Agriculture"
                                                    {{ old('sector') == 'Agriculture' ? 'selected' : '' }}>Agriculture
                                                </option>
                                                <option value="Government"
                                                    {{ old('sector') == 'Government' ? 'selected' : '' }}>Government
                                                </option>
                                                <option value="NGO" {{ old('sector') == 'NGO' ? 'selected' : '' }}>
                                                    NGO</option>
                                                <option value="Services(eg: Financial Institution, Hospitality, F&B)"
                                                    {{ old('sector') == 'Services(eg: Financial Institution, Hospitality, F&B)' ? 'selected' : '' }}>
                                                    Services(eg: Financial Institution, Hospitality, F&B)</option>
                                                <option value="Others"
                                                    {{ old('sector') == 'Others' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            <br />
                                            <div id="sector_otheredit" <?php if(old('sector') == 'Others'){ ?> style="display:block"
                                                <?php }else{ ?> style="display:none" <?php
                                                    } ?>>
                                                <label class="primary_input_label" for="">Sector Others
                                                    <strong class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <input type="text" class="form-control primary_input_field"
                                                        id="sector_otherinput" value="{{ old('sector_other') }}"
                                                        name="sector_other" placeholder="Sector Others"
                                                        {{ $errors->first('sector_other') ? 'autofocus' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <label>Highest Academic Qualification</label>
                                            <select class="primary_select" name="highest_academic"
                                                id="highest_academic" required>
                                                <option value="Primary School"
                                                    {{ old('highest_academic') == 'Primary School' ? 'selected' : '' }}>
                                                    Primary School</option>
                                                <option value="Secondary School"
                                                    {{ old('highest_academic') == 'Secondary School' ? 'selected' : '' }}>
                                                    Secondary School</option>
                                                <option value="SPM/O-Level/SVM/equivalent"
                                                    {{ old('highest_academic') == 'SPM/O-Level/SVM/equivalent' ? 'selected' : '' }}>
                                                    SPM/O-Level/SVM/equivalent</option>
                                                <option value="Bachelor's Degree/equivalent"
                                                    {{ old('highest_academic') == 'Bachelor\'s Degree/equivalent' ? 'selected' : '' }}>
                                                    Bachelor's Degree/equivalent</option>
                                                <option value="Master's Degree/equivalent"
                                                    {{ old('highest_academic') == 'Master\'s Degree/equivalent' ? 'selected' : '' }}>
                                                    Master's Degree/equivalent</option>
                                                <option value="Doctoral Degree"
                                                    {{ old('highest_academic') == 'Doctoral Degree' ? 'selected' : '' }}>
                                                    Doctoral Degree</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Current Residing State
                                            </label>
                                            <select class="primary_select" data-course_id="{{ @$course->id }}"
                                                name="current_residing" id="current_residing">
                                                <option value="Kuala Lumpur"
                                                    {{ old('current_residing') == 'Kuala Lumpur' ? 'selected' : '' }}>
                                                    Kuala Lumpur</option>
                                                <option value="Selangor"
                                                    {{ old('current_residing') == 'Selangor' ? 'selected' : '' }}>Selangor
                                                </option>
                                                <option value="Putrajaya"
                                                    {{ old('current_residing') == 'Putrajaya' ? 'selected' : '' }}>
                                                    Putrajaya</option>
                                                <option value="Labuan"
                                                    {{ old('current_residing') == 'Labuan' ? 'selected' : '' }}>Labuan
                                                </option>
                                                <option
                                                    value="Sabah"{{ old('current_residing') == 'Sabah' ? 'selected' : '' }}>
                                                    Sabah</option>
                                                <option value="Sarawak"
                                                    {{ old('current_residing') == 'Sarawak' ? 'selected' : '' }}>Sarawak
                                                </option>
                                                <option value="Melaka"
                                                    {{ old('current_residing') == 'Melaka' ? 'selected' : '' }}>Melaka
                                                </option>
                                                <option value="Kelantan"
                                                    {{ old('current_residing') == 'Kelantan' ? 'selected' : '' }}>Kelantan
                                                </option>
                                                <option value="Pahang"
                                                    {{ old('current_residing') == 'Pahang' ? 'selected' : '' }}>Pahang
                                                </option>
                                                <option value="Perak"
                                                    {{ old('current_residing') == 'Perak' ? 'selected' : '' }}>Perak
                                                </option>
                                                <option value="Pulau Pinang"
                                                    {{ old('current_residing') == 'Pulau Pinang' ? 'selected' : '' }}>
                                                    Pulau Pinang</option>
                                                <option value="Negeri Sembilan"
                                                    {{ old('current_residing') == 'Negeri Sembilan' ? 'selected' : '' }}>
                                                    Negeri Sembilan</option>
                                                <option value="Kedah"
                                                    {{ old('current_residing') == 'Kedah' ? 'selected' : '' }}>Kedah
                                                </option>
                                                <option value="Perlis"
                                                    {{ old('current_residing') == 'Perlis' ? 'selected' : '' }}>Perlis
                                                </option>
                                                <option value="Johor"
                                                    {{ old('current_residing') == 'Johor' ? 'selected' : '' }}>Johor
                                                </option>
                                                <option value="Terengganu"
                                                    {{ old('current_residing') == 'Terengganu' ? 'selected' : '' }}>
                                                    Terengganu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 ">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">Postcode
                                            </label>
                                            <input type="text" class="form-control primary_input_field"
                                                id="zipedit" value="{{ old('zip') }}" name="zip"
                                                onkeypress="javascript:return isNumber(event)" placeholder="Postcode"
                                                {{ $errors->first('zip') ? 'autofocus' : '' }}>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="deleteStudent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Delete') }} {{ __('student.Student') }} </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.delete') }}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{ __('common.Are you sure to delete ?') }} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="studentDeleteId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                        <button class="primary-btn fix-gr-bg"
                                            type="submit">{{ __('common.Delete') }}</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="impersonateStudent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Impersonate') }} {{ __('student.Student') }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.impersonate') }}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{ __('common.Are you sure to login this learner ?') }} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="studentImpersonateId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                        <button class="primary-btn fix-gr-bg"
                                            type="submit">{{ __('common.Submit') }}</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="sendEmailStudent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Send Reminder Email') }}
                                    {{ __('student.Student') }} </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.send_mail') }}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{ __('common.Are you want to send reminder email this learner ?') }} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="studentSendEmailId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                        <button class="primary-btn fix-gr-bg"
                                            type="submit">{{ __('common.Submit') }}</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="resetPasswordStudent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Reset Password') }} {{ __('student.Student') }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.reset_password') }}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{ __('common.Are you sure to reset password ?') }} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="studentResetPasswordId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                        <button class="primary-btn fix-gr-bg"
                                            type="submit">{{ __('common.Reset Password') }}</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade admin-query" id="notificationstudent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Send Notification To {{ __('student.Student') }} </h4>
                                <button type="button" class="close" data-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('student.notify') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="" id="learner_id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_checkbox d-flex mr-12 w-100">
                                                    <input name="type[]" value="email" type="checkbox" checked>
                                                    <span class="checkmark"></span>
                                                    <p class="ml-2">Email</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_checkbox d-flex mr-12 w-100">
                                                    <input name="type[]" value="portal" type="checkbox" checked>
                                                    <span class="checkmark"></span>
                                                    <p class="ml-2">In Portal</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="primary_input_field form-control" name="notification" placeholder="Add Content"
                                                style="min-height: 150px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                        <button class="primary-btn fix-gr-bg"
                                            type="submit">{{ __('common.Submit') }}</button>

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
            @if (Session::has('type'))
                @if (Session::get('type') == 'store')
                    $('#add_student').modal('show');
                @else
                    @if (isAdmin() || isHRDCorp() || isMyLL())
                        $('#editStudent').modal('show');
                    @else
                        $('#viewLearnerProfile').modal('show');
                    @endif
                @endif
            @endif
        </script>
    @endif


    @php
        $url = route('student.getAllStudentData');
    @endphp

    <script>
        $(function() {
            $("#start_date").change(function() {
                var start_date = $(this).val();
                $("#end_date").attr("min", start_date);
                var d = new Date(start_date);
                d.setMonth(d.getMonth() + 3);
                $("#end_date").attr("max", d.toISOString().substring(0, 10));
            })
            $("#end_date").change(function() {
                var start_date = $(this).val();
                $("#start_date").attr("max", start_date);
                var d = new Date(start_date);
                d.setMonth(d.getMonth() - 3);
                $("#start_date").attr("min", d.toISOString().substring(0, 10));
            })

            $('#not_working_col_div').hide();
            $('#business_nature_col_div').hide();
            $('#business_nature_other_col_div').hide();

            tableLoad();

            $('#btn_save_student').prop('disabled', false);
            $('#btn_update_student').prop('disabled', false);
        });

        $(document).on('click', '#btn_save_student', function() {
            $('#student_store').submit();
            $(this).prop('disabled', true);
        });

        $(document).on('click', '#btn_update_student', function() {
            $('#student_update').submit();
            $(this).prop('disabled', true);
        });

        tableLoad = () => {
            let table = $('#lms_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    data: function() {
                        //pass variable
                    },
                    pages: 5 // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'course_count',
                        name: 'course_count'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'citizenship',
                        name: 'citizenship',
                        'visible': false
                    },

                    {
                        data: 'identification_number',
                        name: 'identification_number',
                        'visible': false
                    },
                    {
                        data: 'job_designation',
                        name: 'job_designation',
                        'visible': false
                    },
                    {
                        data: 'sector',
                        name: 'sector',
                        'visible': false
                    },
                    {
                        data: 'not_working',
                        name: 'not_working',
                        'visible': false
                    },
                    {
                        data: 'business_nature',
                        name: 'business_nature',
                        'visible': false
                    },
                    {
                        data: 'business_nature_other',
                        name: 'business_nature_other',
                        'visible': false
                    },
                    {
                        data: 'zip',
                        name: 'zip',
                        'visible': false
                    },

                    {
                        data: 'gender',
                        name: 'gender',
                        'visible': false
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        'visible': false
                    },
                    {
                        data: 'country',
                        name: 'country',
                        'visible': false
                    },
                    {
                        data: 'race',
                        name: 'race',
                        'visible': false
                    },
                    {
                        data: 'employment_status',
                        name: 'employment_status',
                        'visible': false
                    },
                    {
                        data: 'highest_academic',
                        name: 'highest_academic',
                        'visible': false
                    },
                    {
                        data: 'current_residing',
                        name: 'current_residing',
                        'visible': false
                    },
                    // {data: 'zip', name: 'zip', 'visible' : false},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
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
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.Copy') }}',
                        exportOptions: {
                            // columns: ':visible',
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
                            // columns: ':visible',
                            columns: ':not(:last-child)',
                        },

                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="far fa-file-alt"></i>',
                        titleAttr: '{{ __('common.CSV') }}',
                        exportOptions: {
                            // columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.PDF') }}',
                        exportOptions: {
                            // columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        // customize: function (doc) {
                        //     doc.content[1].table.widths =
                        //         Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        // }

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
            // var created_at = $('#created_at').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var citizenship = $('#citizenship').val();
            var country = $('#country').val();
            var race = $('#race').val();
            var identification_number = $('#identification_number').val();
            var dob = $('#dob').val();
            var gender = $('#gender').val();
            var phone = $('#phone').val();
            var employment_status = $('#filter_employment_status').val();
            var job_designation = $('#job_designation_div').val();
            var sector = $('#sector_div').val();
            var not_working = $('#not_working_div').val();
            var business_nature = $('#business_nature_div').val();
            var business_nature_other = $('#business_nature_other_div').val();
            var highest_academic = $('#highest_academic_div').val();
            var current_residing = $('#current_residing_div').val();
            var zip = $('#zip').val();

            // data['created_at'] = created_at;
            data['start_date'] = start_date;
            data['end_date'] = end_date;
            data['name'] = name;
            data['email'] = email;
            data['citizenship'] = citizenship;
            data['country'] = country;
            data['race'] = race;
            data['identification_number'] = identification_number;
            data['dob'] = dob;
            data['gender'] = gender;
            data['phone'] = phone;
            data['employment_status'] = employment_status;
            data['job_designation'] = job_designation;
            data['sector'] = sector;
            data['not_working'] = not_working;
            data['business_nature'] = business_nature;
            data['business_nature_other'] = business_nature_other;
            data['highest_academic'] = highest_academic;
            data['current_residing'] = current_residing;
            data['zip'] = zip;
        });

        $('#apply-filters').click(function() {
            tableLoad();
        });

        $('#filter_employment_status').change(function() {
            if ($(this).val() == 'working') {
                $('#job_designation_col_div').show();
                $('#sector_col_div').show();

                $('#not_working_col_div').hide();
                $('#business_nature_col_div').hide();
                $('#business_nature_other_col_div').hide();

                $('#not_working_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#business_nature_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#business_nature_other_div').val("");

            } else if ($(this).val() == 'not-working') {
                $('#not_working_col_div').show();

                $('#job_designation_col_div').hide();
                $('#sector_col_div').hide();
                $('#business_nature_col_div').hide();
                $('#business_nature_other_col_div').hide();

                $('#job_designation_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#sector_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#business_nature_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#business_nature_other_div').val("");

            } else if ($(this).val() == 'self-employed') {
                $('#business_nature_col_div').show();

                $('#job_designation_col_div').hide();
                $('#sector_col_div').hide();
                $('#not_working_col_div').hide();
                // $('#business_nature_other_col_div').hide();

                $('#job_designation_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#sector_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#not_working_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#business_nature_other_div').val("");

            } else {
                $('#job_designation_col_div').hide();
                $('#sector_col_div').hide();
                $('#not_working_col_div').hide();
                $('#business_nature_col_div').hide();
                $('#business_nature_other_col_div').hide();

                $('#job_designation_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#sector_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#not_working_div').attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                $('#business_nature_div').attr('selectedIndex', '-1').find("option:selected").removeAttr(
                "selected");
                $('#business_nature_other_div').val("");
            }
        });

        $('#business_nature_div').change(function() {
            if ($(this).val() == 'Others') {
                $('#business_nature_other_col_div').show();
            } else {
                $("#business_nature_other_div").val('');
                $('#business_nature_other_col_div').hide();
            }
        });

        // RESET FILTER BUTTTON
        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            // $('.select2').val('all');
            // $('#filter-form').find('select').select2();
            $('#reportrange span').html('');
            tableLoad();
        });
        // console.log(table.columns().visible());
        // table.column([8, 9, 10, 11, 12, 13, 14, 15]).visible(false);

        // let table = $('#allData').DataTable() ;
        // table.clearPipeline();
        // table.ajax.reload();

        $('#employment_status').change(function() {
            if ($(this).val() == 'working') {
                $('#job_designation').show();
                $('#sector').show();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else if ($(this).val() == 'not-working') {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').show();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else if ($(this).val() == 'self-employed') {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').show();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            } else {
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            }
        });
        $('.business_nature').change(function() {

            if ($(this).val() == 'Others') {
                $('#business_nature_other').show();
            } else {
                $('#business_nature_other').hide();
            }
        });
        $('.race').change(function() {
            if ($(this).val() == 'Others') {
                $('#race_other').show();
            } else {
                $('#race_other').hide();
            }
        });
        $('.sectoredit').change(function() {
            if ($(this).val() == 'Others') {
                $('#sector_otheredit').show();
            } else {
                $('#sector_otheredit').hide();
            }
        });

        $('#employment_statusedit').change(function() {
            if ($(this).val() == 'working') {
                $('#job_designationedit').show();
                $('#sectoredit').show();
                $('#not_workingedit').hide();
                $('#business_natureedit').hide();
                $('#business_nature_otheredit').hide();
                $('#sector_otheredit').hide();
            } else if ($(this).val() == 'not-working') {
                $('#job_designationedit').hide();
                $('#sectoredit').hide();
                $('#not_workingedit').show();
                $('#business_natureedit').hide();
                $('#business_nature_otheredit').hide();
                $('#sector_otheredit').hide();
            } else if ($(this).val() == 'self-employed') {
                $('#job_designationedit').hide();
                $('#sectoredit').hide();
                $('#not_workingedit').hide();
                $('#business_natureedit').show();
                $('#business_nature_otheredit').hide();
                $('#sector_otheredit').hide();
            } else {
                $('#job_designationedit').hide();
                $('#sectoredit').hide();
                $('#not_workingedit').hide();
                $('#business_natureedit').hide();
                $('#business_nature_otheredit').hide();
                $('#sector_otheredit').hide();
            }
        });
        $('.business_natureedit').change(function() {

            if ($(this).val() == 'Others') {
                $('#business_nature_otheredit').show();
            } else {
                $('#business_nature_otheredit').hide();
            }
        });
        $('#studentRaceedit').change(function() {
            if ($(this).val() == 'Others') {
                $('#race_otheredit').show();
            } else {
                $('#race_otheredit').hide();
            }
        });
        $('.sector').change(function() {
            if ($(this).val() == 'Others') {
                $('#sector_other').show();
            } else {
                $('#sector_other').hide();
            }
        });
        $('.citizenshipedit').change(function() {
            if ($(this).val() == 'Malaysian') {
                $('.raceeditdiv').show();
                $('.nationalityeditdiv').hide();
            } else {
                $('.raceeditdiv').hide();
                $('.nationalityeditdiv').show();
                $('#race_otheredit').hide();
                $('#identification_number').attr('required', false);
            }
        });
        $('.citizenship').change(function() {
            if ($(this).val() == 'Malaysian') {
                $('.racediv').show();
                $('.nationalitydiv').hide();
                $('#nricnumber').attr('required', true);
            } else {
                $('.racediv').hide();
                $('.nationalitydiv').show();
                $('#race_other').hide();
                $('#nricnumber').attr('required', false);
            }
        });

        $('#excel_import_table_data').click(function() {
            $("#filter-form").submit();
        });
    </script>

    <script src="{{ asset('backend/js/student_list.js') }}?v=1"></script>

    <script>
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;
            return true;
        }
    </script>

@endpush

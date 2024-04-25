@extends('backend.master')
@push('styles')
    <style>
        .hide {
            display: none;
        }

        .iti.iti--allow-dropdown {
            width: 100%;
        }

        input#phone {
            width: 100%;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            width: 100%;
            height: 46px;
            line-height: 46px;
            font-size: 13px;
            padding: 3px 20px;
            padding-left: 20px;
            font-weight: 300;
            border-radius: 30px;
            color: var(--base_color);
            border: 1px solid #ECEEF4
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid #ECEEF4;
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            width: 100%;
            background: var(--bg_white);
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            border: 0;
            box-shadow: 0px 10px 20px rgb(108 39 255 / 30%);
            z-index: 1051;
            min-width: 200px;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
            border-radius: 3px;
            box-shadow: none;
            /* color: #333; */
            color: #415094 !important;
            display: inline-block;
            vertical-align: middle;
            padding: 0px 8px;
            width: 100% !important;
            height: 46px;
            line-height: 46px;
            outline: 0 !important;
        }

        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            /* color: #444; */
            color: #415094 !important;
            line-height: 40px;
            font-size: 14px !important;
            text-transform: uppercase;
            font-weight: 400;
        }

        .cp_login_page_main_wrapper .primary_checkbox .checkmark:after {
            top: 3px !important;
        }

        .primary_select {
            color: #415094 !important;
            font-size: 14px !important;
            text-transform: uppercase;
            font-weight: 400;
        }

        .primary_input_field {
            text-transform: uppercase;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: white !important;
            cursor: default;
        }
    </style>
@endpush
@section('mainContent')
    @include('backend.partials.alertMessage')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('common.My Profile') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="common_grid_wrapper">
                        <!-- white_box -->
                        <div class="white_box_30px">
                            <div class="main-title mb-25">
                                <h3 class="mb-0">{{ __('common.Profile Settings') }}</h3>
                            </div>
                            <form action="{{ route('update_user') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="name">{{ __('common.Name') }}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="name" value="{{ @$user->name }}"
                                                id="name" placeholder="" required type="text"
                                                {{ $errors->first('name') ? 'autofocus' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="role">{{ __('common.Role') }}
                                            </label>
                                            <input class="primary_input_field" name="" readonly id="role"
                                                value="{{ @$user->role->name }}" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="email">{{ __('common.Email') }}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="email" value="{{ @$user->email }}"
                                                id="email" placeholder="-" type="email"
                                                {{ $errors->first('email') ? 'autofocus' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="phone">{{ __('common.Phone') }}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field  flag-with-code input-phone" name="phone"
                                                value="{{ @$user->phone }}" id="phone" placeholder="-" type="text"
                                                onkeypress="javascript:return isNumber(event)" maxlength="10"
                                                minlength="9">
                                        </div>
                                    </div>
                                    <?php
                                    $countrycode = str_replace('+', '', $user->country_code);
                                    ?>
                                    <input type="hidden" class="country_code" name="country_code" id="country_code"
                                        value="{{ $user->country_code }}" />
                                    <script type="text/javascript">
                                        $('.input-phone').keyup(function() {
                                            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                            var countryCode = countryCode.replace(/[^0-9]/g, '')
                                            $('.country_code').val("");
                                            $('.country_code').val("+" + countryCode);
                                        });
                                    </script>

                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label" for="country">{{ __('common.Country') }}
                                        </label>
                                        <select class="primary_select" name="country" id="country">
                                            @foreach ($countries as $country)
                                                <option value="{{ @$country->id }}"
                                                    @if (@$user->country == $country->id) selected @endif>
                                                    {{ @$country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label" for="city">{{ __('common.City') }}
                                        </label>
                                        <select class="select2  cityList" name="city" id="city">
                                            <option data-display=" {{ __('common.Select') }} {{ __('common.City') }}"
                                                value="">{{ __('common.Select') }} {{ __('common.City') }}
                                            </option>
                                            @foreach ($cities as $city)
                                                <option value="{{ @$city->id }}"
                                                    @if (@$user->city == $city->id) selected @endif>
                                                    {{ @$city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="zip">{{ __('common.Zip Code') }}
                                            </label>
                                            <input class="primary_input_field" name="zip" value="{{ @$user->zip }}"
                                                id="zip" placeholder="-" type="text">
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('common.Browse') }}
                                                {{ __('common.Avatar') }} </label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                    placeholder="{{ showPicName($user->image) }}" readonly="">
                                                <button class="primary_btn_2" type="button">
                                                    <label class="primary_btn_2"
                                                        for="document_file_1">{{ __('common.Browse') }} </label>
                                                    <input type="file" class="d-none" name="image"
                                                        id="document_file_1">
                                                </button>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="col-12 mb-10">
                                        <div class="submit_btn text-center">
                                            <button class="primary_btn_large" type="submit"><i class="ti-check"></i>
                                                {{ __('common.Update') }} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!check_whether_cp_or_not())
                            <!-- white_box  -->
                            <div class="white_box_30px">
                                <div class="main-title mb-25">
                                    <h3 class="mb-0">{{ __('common.Change') }} {{ __('common.Password') }} </h3>
                                </div>
                                <form action="{{ route('updatePassword') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="password-field">{{ __('common.Current') }}
                                                    {{ __('common.Password') }}
                                                    <strong class="text-danger">*</strong></label>
                                                <div>

                                                    <input class="primary_input_field" name="current_password"
                                                        {{ $errors->first('current_password') ? 'autofocus' : '' }}
                                                        placeholder="{{ __('common.Current') }} {{ __('common.Password') }}"
                                                        id="password-field" type="password">
                                                    <span toggle="#password-field"
                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="password-field2">{{ __('common.New') }}
                                                    {{ __('common.Password') }}
                                                    <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="new_password"
                                                    placeholder="{{ __('common.New') }}  {{ __('common.Password') }} {{ __('common.Minimum 8 characters') }}"
                                                    id="password-field2" type="password"
                                                    {{ $errors->first('new_password') ? 'autofocus' : '' }}>
                                                <span toggle="#password-field2"
                                                    class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="password-field3">{{ __('common.Re-Type Password') }}
                                                    <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="confirm_password"
                                                    {{ $errors->first('confirm_password') ? 'autofocus' : '' }}
                                                    id="password-field3"
                                                    placeholder="{{ __('common.Re-Type Password') }}" type="password">
                                                <span toggle="#password-field3"
                                                    class="fa fa-fw fa-eye field-icon toggle-password3"></span>
                                            </div>
                                        </div>


                                        <div class="col-12 mb-10">
                                            <div class="submit_btn text-center">
                                                <button class="primary_btn_large" type="submit"><i class="ti-check"></i>
                                                    {{ __('common.Update') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </section>



    @include('backend.partials.delete_modal')
@endsection

@push('scripts')
    <script>
        $(function() {
            stateload();
        });
        let country = $('#country').val();

        $("#country").on("change", function() {
            country = $('#country').val();
            stateload();
        });

        stateload = () => {
            var url = "{{ route('state_data_with_ajax') }}";
            $(".cityList").select2({
                ajax: {
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            country: country || ''
                        }
                    },
                    cache: false
                }
            });
        }
    </script>
    <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />
    <?php if(isset($countrycode) && $countrycode!=''){
    ?>
    <script>
        const phoneInputField = document.querySelector(".input-phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "IN",
            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
            separateDialCode: false,
            formatOnDisplay: false,
        });
    </script>
    <?php }else{ ?>
    <script>
        const phoneInputField = document.querySelector(".input-phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "MY",
            utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
            separateDialCode: false,
            formatOnDisplay: false,


        });
    </script>
    <?php } ?>
    <script>
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;
            return true;
        }
        $("body").on("click", "#sst_registered", function() {
            $(".div_sst_registration_no").toggleClass('hide');
        })
    </script>
@endpush

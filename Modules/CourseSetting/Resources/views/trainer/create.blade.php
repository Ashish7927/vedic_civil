@extends('backend.master')
@push('styles')
    @php $version = 'v=' . config('app.version'); @endphp

    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/select2_custom.css') }}?{{ $version }}" />
    <style>
        .iti.iti--allow-dropdown {
            width: 100%;
        }
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>
                    @if (isset($trainer))
                        {{ __('common.Edit') }}
                    @else
                        {{ __('common.Add New') }}
                    @endif

                    {{ __('common.Trainer') }}
                </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('common.Trainers') }}</a>
                    <a href="#">
                        @if (isset($trainer))
                            {{ __('common.Edit') }}
                        @else
                            {{ __('common.Add New') }}
                        @endif

                        {{ __('common.Trainer') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="white_box mb_30">
            <div class="col-lg-12">
                <form action="{{ route('trainers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @isset($trainer)
                        <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                    @endisset

                    @php
                        if (isAdmin()) {
                            $col = 6;
                        } else {
                            $col = 12;
                        }
                    @endphp

                    <div class="row">
                        @if (isAdmin())
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="content_provider">{{ __('common.Select') }}
                                        {{ __('common.Content Provider') }}/{{ __('common.Partner') }} *</label>
                                    <select class="primary_select" name="content_provider_id" id="content_provider_id">
                                        <option
                                            data-display="{{ __('common.Select') }} {{ __('common.Content Provider') }}/{{ __('common.Partner') }}"
                                            value="">{{ __('common.Select') }}
                                            {{ __('common.Content Provider') }}/{{ __('common.Partner') }}</option>
                                        @if (isset($cps))
                                            @foreach ($cps as $cp)
                                                <option value="{{ $cp->id }}" {{ (old('content_provider_id') == $cp->id || (isset($trainer) && $trainer->corporate_id == $cp->id) ? 'selected' : '') }}>{{ $cp->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('content_provider_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content_provider_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="content_provider_id" value="{{ auth()->user()->id }}">
                        @endif

                        <div class="col-xl-{{ $col }}">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Trainer') }}
                                    {{ __('common.Name') }} *
                                </label>
                                <input class="primary_input_field" name="name" placeholder="-" id="name"
                                    data-toggle="tooltip" title="{{ __('common.Name') }}" type="text"
                                    {{ $errors->has('name') ? 'autofocus' : '' }}
                                    value="{{ old('name', isset($trainer) ? $trainer->name : '') }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Email') }}*</label>
                                <input class="primary_input_field" type="email" name="email"
                                    value="{{ old('email', isset($trainer) ? $trainer->email : '') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Phone') }} </label>
                                <input class="primary_input_field input-phone"
                                    value="{{ old('phone', isset($trainer) ? $trainer->phone : '') }}" name="phone"
                                    id="addPhone" placeholder="-" style="width:100%" type="text"
                                    onkeypress="javascript:return isNumber(event)">
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" class="country_code" name="country_code" id="country_code"
                            value="{{ old('country_code', isset($trainer) ? $trainer->country_code : '') }}" />
                    </div>

                    <div class="row mt-20">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="address">{{ __('common.Address') }}</label>
                                <input class="primary_input_field" placeholder="-" type="text" id="address"
                                    name="address" value="{{ old('address', isset($trainer) ? $trainer->address : '') }}">
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('courses.Image') }}
                                    ({{ __('common.Max Image Size 5MB') }}) (Recommend size: 1170x600) * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Image Description: The maximum image size is 5mb. The recommended size: 1170x600 pixels and file format must be in .jpg."></i>
                                </label>

                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder" type="text" id=""
                                        {{ $errors->has('image') ? 'autofocus' : '' }}
                                        placeholder="{{ __('courses.Browse Image file') }}" readonly=""
                                        data-toggle="tooltip" title="{{ __('courses.Image') }}"
                                        value="{{ isset($trainer) && !empty($trainer->image) ? showPicName($trainer->image) : '' }}">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="image">{{ __('common.Browse') }}</label>
                                        <input type="file" class="d-none fileUpload" name="image" id="image">
                                    </button>
                                </div>

                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="save_package">
                                <span class="ti-check"></span>
                                @if (isset($trainer))
                                    {{ __('common.Update') }}
                                @else
                                    {{ __('common.Save') }}
                                @endif

                                <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="save_loading_spinner"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.input-phone').keyup(function() {
            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
            var countryCode = countryCode.replace(/[^0-9]/g, '');

            $('.country_code').val("");
            $('.country_code').val("+" + countryCode);
        });
    </script>

    <script src="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js') }}">
    </script>
    <link rel="stylesheet"
        href="{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css') }}" />

    @if (isset($user))
        @php
            $countryc = $user->country_code;
        @endphp
    @else
        @php
            $countryc = old('country_code');
        @endphp
    @endif

    @if ($countryc != '')
        @php
            $countrycode = str_replace('+', '', $countryc);
            $countryname = DB::table('countries')
                ->where('phonecode', $countrycode)
                ->first();
            $countryiso = $countryname->iso2;
        @endphp

        <script>
            const phoneInputField = document.querySelector(".input-phone");
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "<?php echo $countryiso; ?>",
                utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                separateDialCode: false,
                formatOnDisplay: false,
            });
        </script>
    @else
        <script>
            const phoneInputField = document.querySelector(".input-phone");
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "my",
                utilsScript: "{{ asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js') }}",
                separateDialCode: false,
                formatOnDisplay: false,
            });
        </script>
    @endif

    <script>
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;
            return true;
        }
    </script>
@endpush

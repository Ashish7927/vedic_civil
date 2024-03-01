@extends('backend.master')
@push('styles')
    <style>
        .hide{
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
            text-transform:uppercase;
            font-weight: 400;
        }

        .cp_login_page_main_wrapper .primary_checkbox .checkmark:after{
            top:  3px!important;
        }

        .primary_select{
            color: #415094 !important;
            font-size: 14px !important;
            text-transform:uppercase;
            font-weight: 400;
        }

        .primary_input_field
        {
            text-transform:uppercase;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: white !important;
            cursor: default;
        }
    </style>
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('common.My Profile')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if(check_whether_cp_or_not())
                        <div class="cp_login_page_main_wrapper col-md-9">
                    @else
                        <div class="common_grid_wrapper">
                    @endif
                        <!-- white_box -->
                        <div class="white_box_30px">
                            <div class="main-title mb-25">
                                <h3 class="mb-0">{{__('common.Profile Settings')}}</h3>
                            </div>
                            @if(check_whether_cp_or_not() || isPartner())
                                <form action="{{route('update_user')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">Company Logo </label>
                                                {{-- <p class="image_size">{{__('courses.Recommended size 200px x 200px')}}</p> --}}
                                                <p class="image_size">Recommended size 167px x 91px</p>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName"
                                                           placeholder="{{showPicName($user->image)}}" readonly="">
                                                           <button class="primary_btn_2" type="button">
                                                               <label class="primary_btn_2"
                                                                      for="document_file_1">{{__('common.Browse')}} </label>
                                                               <input type="file" class="d-none" name="image" id="document_file_1">
                                                           </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="name">Company {{__('common.Name')}} <strong class="text-danger">*</strong></label>
                                                @if(isPartner())
                                                    <input class="primary_input_field" name="name" value="{{@$user->name}}"  id="name" placeholder="" required type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                                                @else
                                                    <input class="primary_input_field" name="name" value="{{@$user->name}}" readonly id="name" placeholder="" required type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                                                @endif
                                                <span class="text-danger" role="alert">{{ $errors->first('name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="company_profile_summary">Company Profile Summary</label>
                                                <textarea id="company_profile_summary" name="company_profile_summary" class="primary_textarea"> {{@$user->company_profile_summary}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">Company Page Banner Title</label>
                                                <input class="primary_input_field"
                                                    placeholder="Content Provider/ Partner's Page Title"
                                                    type="text" name="company_banner_title"
                                                    {{ $errors->first('company_banner_title') ? ' autofocus' : '' }}
                                                    value="{{isset($user->company_banner_title)? $user->company_banner_title : 'Start Learning from the World-Class Providers'}}" maxlength="50" style="text-transform: none;">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">Company Page Banner Sub Title</label>
                                                    <input class="primary_input_field"
                                                        placeholder="Content Provider/ Partner's Page Sub Title"
                                                        type="text" name="company_banner_subtitle"
                                                        {{ $errors->first('company_banner_subtitle') ? ' autofocus' : '' }}
                                                        value="{{isset($user->company_banner_subtitle)? $user->company_banner_subtitle : 'Subscribe now via Corporate Access'}}" maxlength="100" style="text-transform: none;">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="email_address">Email {{__('common.Address')}} </label>
                                                <input class="primary_input_field" name="email" value="{{@$user->email}}" id="email_address" placeholder="" required type="text" {{$errors->first('email') ? 'autofocus' : ''}} style="text-transform:lowercase;">
                                                <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div>
                                        @if(isPartner())
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="role">{{__('common.Role')}} <strong class="text-danger">*</strong> </label>
                                                    <input class="primary_input_field" name="" readonly
                                                           id="role" value="Partner"  placeholder="-" type="text">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="role">{{__('common.Role')}} <strong class="text-danger">*</strong> </label>
                                                    <input class="primary_input_field" name="" readonly
                                                           id="role" value="{{@$user->role->name}}"  placeholder="-" type="text">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="brand_name">Brand {{__('common.Name')}} {{-- <strong class="text-danger">*</strong> --}}</label>
                                                <input class="primary_input_field" name="brand_name" value="{{@$user->brand_name}}" id="brand_name" placeholder="" type="text" {{$errors->first('brand_name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        @if(check_whether_cp_or_not())
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="my_co_id">
                                                    MyCoID
                                                    <strong class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field" name="my_co_id" value="{{@$user->my_co_id}}" readonly id="my_co_id" placeholder="" required type="text" {{$errors->first('my_co_id') ? 'autofocus' : ''}}>
                                                <span class="text-danger" role="alert">{{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @if(isPartner())
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="my_co_id">
                                                        MyCoID
                                                    </label>
                                                    <input class="primary_input_field" name="my_co_id" value="{{@$user->my_co_id}}" id="my_co_id" placeholder=""  type="text" {{$errors->first('my_co_id') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        @endif
                                        @if(isPartner())
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="phone">{{__('common.Phone')}} <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field  flag-with-code input-phone" name="phone" value="{{@$user->phone }}" id="phone" placeholder="-" type="text" onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9">
                                                    <span class="text-danger" role="alert">{{ $errors->first('phone') }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="phone">{{__('common.Phone')}} <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field  flag-with-code input-phone" name="phone" readonly value="{{@$user->phone }}"
                                                           id="phone" placeholder="-" type="text" onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="white_box_tittle list_header">
                                            <div class="col-md-12">
                                                <h5>Company Address</h5>
                                            </div>
                                        </div>
                                        @if(isPartner())
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="address">Address 1 <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="address" value="{{@$user->address}}" id="address" placeholder="" required type="text" {{$errors->first('address') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="address2">Address 2 <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="address2" value="{{@$user->address2}}" id="address2" placeholder="" type="text" {{$errors->first('address2') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="zip">Postcode <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="zip" value="{{@$user->zip }}" id="zip" placeholder="-" type="text">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="address">Address 1 <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="address" value="{{@$user->address}}" readonly id="address" placeholder="" required type="text" {{$errors->first('address') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="address2">Address 2 <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="address2" value="{{@$user->address2}}" readonly id="address2" placeholder="" type="text" {{$errors->first('address2') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="zip">Postcode <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="zip" value="{{@$user->zip }}" readonly id="zip" placeholder="-" type="text">
                                                </div>
                                            </div>
                                        @endif

                                        <?php
                                            $countryiso = '';
                                            $countrycode = str_replace('+','',$user->country_code);
                                            if($countrycode!=''){
                                                $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                                                if($countryname){
                                                    $countryiso = $countryname->iso2;
                                                }
                                            }
                                         ?>
                                         <input type="hidden" class="country_code" name="country_code" id="country_code" readonly value="{{$user->country_code}}" />
                                         <script type="text/javascript">
                                             $('.input-phone').keyup(function(){
                                                var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                                var countryCode = countryCode.replace(/[^0-9]/g,'')
                                                $('.country_code').val("");
                                                 $('.country_code').val("+"+countryCode);
                                             });
                                         </script>
                                        @if(isPartner())
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="city_text">{{__('common.City')}} <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="city_text" value="{{@$user->city_text}}" id="city_text" placeholder="" required type="text" {{$errors->first('city_text') ? 'autofocus' : ''}}>
                                                    <span class="text-danger" role="alert">{{ $errors->first('city_text') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-25">
                                                <label class="primary_input_label"
                                                    for="city">State <strong class="text-danger">*</strong></label>
                                                <input type="hidden" name="city" value="{{@$user->city}}" />
                                                <select class="select2  cityList" name="city" id="city">
                                                    <option
                                                        data-display=" {{__('common.Select')}} {{__('State')}}"
                                                        value="">{{__('common.Select')}} {{__('common.City')}}
                                                    </option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{@$city->id}}"
                                                                @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-25">
                                                <label class="primary_input_label"
                                                    for="country">{{__('common.Country')}} <strong class="text-danger">*</strong></label>
                                                <input type="hidden" name="country" value="{{@$user->country}}" />
                                                <select class="primary_select" name="country" id="country">
                                                    @foreach ($countries as $country)
                                                        <option value="{{@$country->id}}"
                                                                @if (@$user->country==$country->id) selected @endif>{{@$country->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="city_text">{{__('common.City')}} <strong class="text-danger">*</strong></label>
                                                    <input class="primary_input_field" name="city_text" value="{{@$user->city_text}}" id="city_text" placeholder="" required readonly type="text" {{$errors->first('city_text') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-25">
                                                <label class="primary_input_label"
                                                    for="city">State <strong class="text-danger">*</strong></label>
                                                <input type="hidden" name="city" value="{{@$user->city}}" />
                                                <select class="select2  cityList" name="city" id="city" disabled>
                                                    <option
                                                        data-display=" {{__('common.Select')}} {{__('State')}}"
                                                        value="">{{__('common.Select')}} {{__('common.City')}}
                                                    </option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{@$city->id}}"
                                                                @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-25">
                                                <label class="primary_input_label"
                                                    for="country">{{__('common.Country')}} <strong class="text-danger">*</strong></label>
                                                <input type="hidden" name="country" value="{{@$user->country}}" />
                                                <select class="primary_select" name="country" id="country" disabled>
                                                    @foreach ($countries as $country)
                                                        <option value="{{@$country->id}}"
                                                                @if (@$user->country==$country->id) selected @endif>{{@$country->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if(check_whether_cp_or_not() || isPartner())
                                         <div class="white_box_tittle list_header">
                                            <div class="col-md-12">
                                                <h5>SST Information</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-25">
                                            <div class="checkbox_wrap d-flex align-items-center">
                                                <label class="switch_toggle  mr-2">
                                                    <input type="checkbox" class="sst_registered" id="sst_registered" name="sst_registered" value="1" {{(isset($user) && $user->sst_registration_no != null) ? 'checked' : ''}}>
                                                    <i class="slider round"></i>
                                                </label>
                                                <label class="mb-0">SST Registered</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-25 div_sst_registration_no {{(isset($user) && $user->sst_registration_no != null) ? '' : 'hide'}}">
                                            <label class="primary_input_label">SST Registration Number</label>
                                            <input class="primary_input_field" type="text" name="sst_registration_no" id="sst_registration_no" value="{{isset($user->sst_registration_no) ? $user->sst_registration_no : ''}}"
                                            {{-- pattern=".{3}-.{4}-.{8}" placeholder="Eg: STM-YYMM-XXXXXXXX"> --}}
                                            pattern="[a-zA-Z0-9]{3}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{8}" placeholder="Eg: STM-YYMM-XXXXXXXX">
                                            <span class="text-danger" role="alert">{{ $errors->first('sst_registration_no') }}</span>
                                        </div>
                                        @endif

                                        <div class="white_box_tittle list_header">
                                            <div class="col-md-12">
                                                <h5>Bank account details</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="account_holder_name">Payee Name <strong class="text-danger">*</strong> </label>
                                                <input class="primary_input_field" name="account_holder_name" value="{{@$user->account_holder_name}}" id="account_holder_name" placeholder="" required type="text" {{$errors->first('account_holder_name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_account_number">Account number <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="bank_account_number" value="{{@$user->bank_account_number}}" id="bank_account_number" placeholder="" required type="text" {{$errors->first('bank_account_number') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_name">Bank name</label>
                                                <input class="primary_input_field" name="bank_name" value="{{@$user->bank_name}}" id="bank_name" placeholder="" required type="text" {{$errors->first('bank_name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_name">Website</label>
                                                <input class="primary_input_field" name="website" value="{{@$user->website}}" id="website" placeholder="" type="text" {{$errors->first('website') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_name">Facebook</label>
                                                <input class="primary_input_field" name="facebook" value="{{@$user->facebook}}" id="facebook" placeholder="" type="text" {{$errors->first('facebook') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_name">Twitter</label>
                                                <input class="primary_input_field" name="twitter" value="{{@$user->twitter}}" id="twitter" placeholder="" type="text" {{$errors->first('twitter') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="bank_name">Linkedin</label>
                                                <input class="primary_input_field" name="linkedin" value="{{@$user->linkedin}}" id="linkedin" placeholder="" type="text" {{$errors->first('linkedin') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                        @if(check_whether_cp_or_not())
                                        <div class="col-md-12 mt_20">
                                            <div class="remember_forgot_passs d-flex align-items-center">
                                                <label class="primary_checkbox d-flex" for="checkbox" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                                    <input name="checkbox" type="checkbox" id="checkbox" {{ ($user->agreed_to_terms == 1) ? 'checked' : '' }}>


                                                    <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                                    <p>I hereby agree that the information provided is true and accurate.</p>
                                                    {{-- <p>I have read and agree to the <a href="{{asset('pages/privacy-policy-and-cookie-policy')}}" target=_blank>Terms & Conditions</a> for e-LATiH Content Providers before continuing to the course development section</p> --}}
                                                </label>

                                            </div>
                                            <span class="text-danger" role="alert">{{$errors->first('checkbox')}}</span>
                                        </div>

                                        <div class="col-md-12 mt_20">
                                            <div class="remember_forgot_passs d-flex align-items-center">
                                                <label class="primary_checkbox d-flex" for="checkbox1" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                                    <input name="checkbox1" type="checkbox" id="checkbox1" {{ ($user->agreed_to_terms == 1) ? 'checked' : '' }}>


                                                    <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                                    <p>I have read and agree to the <a href="{{route('frontPage', 'cp-terms-and-conditions')}}">terms and condition</a> for e-LATiH Content Providers before continuing to the course development section.</p>
                                                </label>

                                            </div>
                                            <span class="text-danger" role="alert">{{$errors->first('checkbox1')}}</span>
                                        </div>
                                        @endif
                                        @if(isPartner())
                                        <div class="col-md-12 mt_20">
                                            <div class="remember_forgot_passs d-flex align-items-center">
                                                <label class="primary_checkbox d-flex" for="checkbox" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                                    <input name="checkbox" type="checkbox" id="checkbox" {{ ($user->agreed_to_terms == 1) ? 'checked' : '' }}>


                                                    <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                                    <p>I hereby agree that the information provided is true and accurate.</p>
                                                </label>

                                            </div>
                                            <span class="text-danger" role="alert">{{$errors->first('checkbox')}}</span>
                                        </div>
                                        <div class="col-md-12 mt_20">
                                            <div class="remember_forgot_passs d-flex align-items-center">
                                                <label class="primary_checkbox d-flex" for="checkbox1" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                                    <input name="checkbox1" type="checkbox" id="checkbox1" {{ ($user->agreed_to_terms == 1) ? 'checked' : '' }}>


                                                    <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                                    <p>I have read and agree to the <a href="{{route('frontPage', 'cp-terms-and-conditions')}}">terms and condition</a> for e-LATiH Content Providers before continuing to the course development section.</p>
                                                </label>

                                            </div>
                                            <span class="text-danger" role="alert">{{$errors->first('checkbox1')}}</span>
                                        </div>
                                        @endif

                                        <div class="col-12 mb-10">
                                            <div class="submit_btn text-center">
                                                <button class="primary_btn_large" type="submit"><i
                                                        class="ti-check"></i> {{__('common.Update')}} </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form action="{{route('update_user')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="name">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" value="{{@$user->name}}"
                                                       id="name" placeholder="" required
                                                       type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="role">{{__('common.Role')}} </label>
                                                <input class="primary_input_field" name="" readonly
                                                       id="role" value="{{@$user->role->name}}" placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="email">{{__('common.Email')}}
                                                    <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" value="{{@$user->email}}"
                                                       id="email" placeholder="-"
                                                       type="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="phone">{{__('common.Phone')}} <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field  flag-with-code input-phone" name="phone" value="{{@$user->phone }}"
                                                       id="phone" placeholder="-" type="text" onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9">
                                            </div>
                                        </div>

                                        @if(auth()->user()->role_id == 2)
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="phone">{{__('IC Number')}} </label>
                                                <input class="primary_input_field  flag-with-code input-phone" name="ic_no_for_trainer" value="{{@$user->ic_no_for_trainer }}" id="ic_no_for_trainer" placeholder="-" type="text" >
                                            </div>
                                        </div>


                                        <div class="white_box_tittle list_header">
                                            <div class="col-md-12">
                                                <h5>Address</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="address">Address 1 <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="address" value="{{@$user->address}}" id="address" placeholder="" required type="text" {{$errors->first('address') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="address2">Address 2</label>
                                                <input class="primary_input_field" name="address2" value="{{@$user->address2}}" id="address2" placeholder="" type="text" {{$errors->first('address2') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="zip">Postcode</label>
                                                <input class="primary_input_field" name="zip" value="{{@$user->zip }}" id="zip" placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <?php
                                            $countryiso = '';
                                            $countrycode = str_replace('+','',$user->country_code);
                                            if($countrycode!=''){
                                                $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                                                if($countryname){
                                                    $countryiso = $countryname->iso2;
                                                }
                                            }
                                         ?>
                                         <input type="hidden" class="country_code" name="country_code" id="country_code" value="{{$user->country_code}}" />
                                         <script type="text/javascript">
                                             $('.input-phone').keyup(function(){
                                                var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                                var countryCode = countryCode.replace(/[^0-9]/g,'')
                                                $('.country_code').val("");
                                                 $('.country_code').val("+"+countryCode);
                                             });
                                         </script>

                                        <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="country">{{__('common.Country')}} </label>
                                            <select class="primary_select" name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{@$country->id}}"
                                                            @if (@$user->country==$country->id) selected @endif>{{@$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="city">State</label>
                                            <select class="select2  cityList" name="city" id="city">
                                                <option
                                                    data-display=" {{__('common.Select')}} {{__('State')}}"
                                                    value="">{{__('common.Select')}} {{__('common.City')}}
                                                </option>
                                                @foreach ($cities as $city)
                                                    <option value="{{@$city->id}}"
                                                            @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="city_text">{{__('common.City')}} <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="city_text" value="{{@$user->city_text}}" id="city_text" placeholder="" required type="text" {{$errors->first('city_text') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="company_profile_summary">Profile Summary</label>
                                                <textarea id="company_profile_summary" name="company_profile_summary" class="primary_textarea"> {{@$user->company_profile_summary}}</textarea>
                                            </div>
                                        </div>
                                        @else
                                         <?php
                                            $countrycode = str_replace('+','',$user->country_code);
                                            if($countrycode!=''){
                                                $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                                                $countryiso = $countryname->iso2;
                                            }
                                         ?>
                                         <input type="hidden" class="country_code" name="country_code" id="country_code" value="{{$user->country_code}}" />
                                         <script type="text/javascript">
                                             $('.input-phone').keyup(function(){
                                                var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                                var countryCode = countryCode.replace(/[^0-9]/g,'')
                                                $('.country_code').val("");
                                                 $('.country_code').val("+"+countryCode);
                                             });
                                         </script>

                                        <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="country">{{__('common.Country')}} </label>
                                            <select class="primary_select" name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{@$country->id}}"
                                                            @if (@$user->country==$country->id) selected @endif>{{@$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="city">{{__('common.City')}} </label>
                                            <select class="select2  cityList" name="city" id="city">
                                                <option
                                                    data-display=" {{__('common.Select')}} {{__('common.City')}}"
                                                    value="">{{__('common.Select')}} {{__('common.City')}}
                                                </option>
                                                @foreach ($cities as $city)
                                                    <option value="{{@$city->id}}"
                                                            @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="zip">{{__('common.Zip Code')}} </label>
                                                <input class="primary_input_field" name="zip" value="{{@$user->zip }}"
                                                       id="zip" placeholder="-" type="text">
                                            </div>
                                        </div>
                                        @endif
                                       <!--  <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="currency">{{__('common.Currency')}}</label>
                                            <select class="primary_select" name="currency" id="currency">
                                                <option data-display="{{__('common.Select')}} Currency"
                                                        value="">{{__('common.Select')}} Currency
                                                </option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{@$currency->id}}"
                                                            @if (@$user->currency_id==$currency->id) selected @endif>{{@$currency->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-25">
                                            <label class="primary_input_label"
                                                   for="language">{{__('common.Language')}} </label>
                                            <select class="primary_select" name="language" id="language">
                                                <option data-display="{{__('common.Select')}} Language"
                                                        value="">{{__('common.Select')}}
                                                    {{__('passwords.Language')}}</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{@$language->id}}"
                                                            @if (@$user->language_id==$language->id) selected @endif>{{@$language->native}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="facebook">{{__('common.Facebook URL')}} </label>
                                                <input class="primary_input_field" name="facebook" id="facebook"
                                                       value="{{@$user->facebook}}" placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="twitter">{{__('common.Twitter URL')}} </label>
                                                <input class="primary_input_field" name="twitter" id="twitter"
                                                       value="{{@$user->twitter}}" placeholder="-" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="linkedin">{{__('common.LinkedIn URL')}} </label>
                                                <input class="primary_input_field" name="linkedin" id="linkedin"
                                                       value="{{@$user->linkedin}}" placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="instagram">{{__('common.Instagram URL')}} </label>
                                                <input class="primary_input_field" name="instagram" id="instagram"
                                                       value="{{@$user->instagram}}" placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="shortDetails">{{__('common.Short Description')}} </label>
                                                <input class="primary_input_field" name="short_details"
                                                       id="shortDetails" value="{{@$user->short_details}}" placeholder="-"
                                                       type="text">
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="about">{{__('common.Description')}} </label>
                                                <textarea class="lms_summernote" name="about"

                                                          id="about" cols="30"
                                                          rows="10">{!!@$user->about!!}</textarea>
                                            </div>
                                        </div> -->


                                        <div class="col-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Browse')}}  {{__('common.Avatar')}} </label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName"
                                                           placeholder="{{showPicName($user->image)}}" readonly="">
                                                    <button class="primary_btn_2" type="button">
                                                        <label class="primary_btn_2"
                                                               for="document_file_1">{{__('common.Browse')}} </label>
                                                        <input type="file" class="d-none" name="image" id="document_file_1">
                                                    </button>
                                                </div>
                                            </div>


                                        </div>

                                        @if(auth()->user()->role_id == 2)
                                        <div class="col-md-12 mt_20">
                                            <div class="remember_forgot_passs d-flex align-items-center">
                                                <label class="primary_checkbox d-flex" for="checkbox" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                                    <input name="checkbox" type="checkbox" id="checkbox" {{ ($user->agreed_to_terms == 1) ? 'checked' : '' }}>

                                                    <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                                    <p>I have read and agree to the <a href="{{asset('pages/privacy-policy-and-cookie-policy')}}" target=_blank>Terms & Conditions</a> for e-LATiH Content Providers before continuing to the course development section</p>
                                                </label>
                                            </div>
                                            <span class="text-danger" role="alert">{{$errors->first('checkbox')}}</span>
                                        </div>
                                        @endif

                                        <!-- @auth()
                                            @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                                <div class="col-12">
                                                    <div class="col-md-12 mb-25">
                                                        <label class="primary_input_label"
                                                               for="subscription_method">{{__('common.Subscription Method')}} </label>
                                                        <select class="primary_select" name="subscription_method">
                                                            <option value="">{{__('common.None')}}</option>
                                                            <option
                                                                value="Mailchimp"
                                                                @if($user->subscription_method=="Mailchimp") selected @endif>{{__('newsletter.Mailchimp')}}</option>

                                                            <option
                                                                value="GetResponse"
                                                                @if($user->subscription_method=="GetResponse") selected @endif >{{__('newsletter.GetResponse')}}</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-25" style="    margin-top: 70px;">

                                                        <label class="primary_input_label"
                                                               for="subscription_api_key">{{__('common.Subscription Api Key')}}
                                                            <small>({{$user->subscription_api_status==1?'Connected':'Not Connected'}}
                                                                )</small> </label>
                                                        <input class="primary_input_field" name="subscription_api_key"
                                                               value="{{@$user->subscription_api_key }}"
                                                               id="subscription_api_key" placeholder="-" type="text">

                                                    </div>

                                                    <div class="col-md-12">

                                                    </div>
                                                </div>
                                            @endif
                                        @endauth -->

                                        <div class="col-12 mb-10">
                                            <div class="submit_btn text-center">
                                                <button class="primary_btn_large" type="submit"><i
                                                        class="ti-check"></i> {{__('common.Update')}} </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>

                        @if(!check_whether_cp_or_not())
                        <!-- white_box  -->
                        <div class="white_box_30px">
                            <div class="main-title mb-25">
                                <h3 class="mb-0">{{__('common.Change')}}  {{__('common.Password')}} </h3>
                            </div>
                            <form action="{{route('updatePassword')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field">{{__('common.Current')}} {{__('common.Password')}}
                                                <strong
                                                    class="text-danger">*</strong></label>
                                            <div>

                                                <input class="primary_input_field" name="current_password"
                                                       {{$errors->first('current_password') ? 'autofocus' : ''}}
                                                       placeholder="{{__('common.Current')}} {{__('common.Password')}}"
                                                       id="password-field"
                                                       type="password">
                                                <span toggle="#password-field"
                                                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field2">{{__('common.New')}}  {{__('common.Password')}}
                                                <strong
                                                    class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="new_password"
                                                   placeholder="{{__('common.New')}}  {{__('common.Password')}} {{__('common.Minimum 8 characters')}}"
                                                   id="password-field2"
                                                   type="password" {{$errors->first('new_password') ? 'autofocus' : ''}}>
                                            <span toggle="#password-field2"
                                                  class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field3">{{__('common.Re-Type Password')}}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="confirm_password"
                                                   {{$errors->first('confirm_password') ? 'autofocus' : ''}}
                                                   id="password-field3" placeholder="{{__('common.Re-Type Password')}}"
                                                   type="password">
                                            <span toggle="#password-field3"
                                                  class="fa fa-fw fa-eye field-icon toggle-password3"></span>
                                        </div>
                                    </div>


                                    <div class="col-12 mb-10">
                                        <div class="submit_btn text-center">
                                            <button class="primary_btn_large" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}}</button>
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

        $("#country").on("change", function(){
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

      /*  let city = $('.cityList');
        city.select2({
            ajax: {
                url: '{{route('ajaxCounterCity')}}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        id: $('#country').find(':selected').val(),
                    }
                    return query;
                },
                cache: false
            }
        });*/
    </script>
<script src="{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css')}}"/>
<?php if(isset($countrycode) && $countrycode!=''){
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
<?php }else{ ?>
    <script>
    const phoneInputField = document.querySelector(".input-phone");
    const phoneInput = window.intlTelInput(phoneInputField,{
        initialCountry:"MY",
        utilsScript:"{{asset('frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,


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
    $("body").on("click", "#sst_registered", function () {
        $(".div_sst_registration_no").toggleClass('hide');
    })
</script>
@endpush

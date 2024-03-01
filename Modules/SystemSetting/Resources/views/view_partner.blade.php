<div class="modal-dialog modal_1000px modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('common.View Partner')}}</h4>
            <button type="button" class="close " data-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                   for="">Company Logo </label>
                            <p class="image_size">{{__('courses.Recommended size 200px x 200px')}}</p>
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                       placeholder="{{showPicName($partners->image)}}" readonly="">
                                <button class="primary_btn_2" type="button">
                                    <label class="primary_btn_2"
                                           for="document_file_1">{{__('common.Browse')}} </label>
                                    <input type="file" class="d-none" name="image" id="document_file_1" readonly>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="name">Company {{__('common.Name')}} <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="name" value="{{@$partners->name}}"  id="name" placeholder="" required readonly type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="email_address">Email {{__('common.Address')}} </label>
                            <input class="primary_input_field" name="email" value="{{@$partners->email}}" id="email_address" placeholder="" readonly required type="text" {{$errors->first('email') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="role">{{__('common.Role')}} <strong class="text-danger">*</strong> </label>
                            <input class="primary_input_field" name="" readonly
                                   id="role" value="Partner"  placeholder="-" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="brand_name">Brand {{__('common.Name')}} {{-- <strong class="text-danger">*</strong> --}}</label>
                            <input class="primary_input_field" name="brand_name" value="{{@$partners->brand_name}}" id="brand_name" placeholder="" readonly type="text" {{$errors->first('brand_name') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="phone">{{__('common.Phone')}} <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field  flag-with-code input-phone" name="phone" value="{{@$partners->phone }}"
                                   id="phone" placeholder="-" type="text" onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9" readonly>
                        </div>
                    </div>

                    <div class="white_box_tittle list_header">
                        <div class="col-md-12">
                            <h5>Company Address</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="address">Address 1 <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="address" value="{{@$partners->address}}" id="address" placeholder="" required readonly type="text" {{$errors->first('address') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="address2">Address 2 <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="address2" value="{{@$partners->address2}}" id="address2" placeholder="" readonly type="text" {{$errors->first('address2') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="zip">Postcode <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="zip" value="{{@$partners->zip }}" readonly id="zip" placeholder="-" type="text">
                        </div>
                    </div>

                    <?php
                    $countryiso = '';
                    $countrycode = str_replace('+','',$partners->country_code);
                    if($countrycode!=''){
                        $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                        if($countryname){
                            $countryiso = $countryname->iso2;
                        }
                    }
                    ?>
                    <input type="hidden" class="country_code" name="country_code" id="country_code" readonly value="{{$partners->country_code}}" />
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
                               for="country">{{__('common.Country')}} <strong class="text-danger">*</strong></label>
                        <select class="primary_select" name="country" id="country" disabled>
                            @foreach ($countries as $country)
                                @if (@$partners->country==$country->id)
                                <option value="{{@$country->id}}" selected>{{@$country->name}}</option>
                                @else
                                    @if($country->id == 132)
                                        <option value="{{@$country->id}}" selected>{{@$country->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-25">
                        <label class="primary_input_label"
                               for="city">State <strong class="text-danger">*</strong></label>
                        <select class="select2 primary_select  cityList" name="city" id="city" disabled>
                            @foreach ($cities as $city)
                                @if (@$partners->city==$city->id)
                                    <option value="{{@$city->id}}" selected>{{@$city->name}}</option>
                                @else
                                    @if($city->id == 47953)
                                        <option value="{{@$city->id}}" selected>{{@$city->name}}</option>
                                    @else
                                        <option value="{{@$city->id}}">{{@$city->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="city_text">{{__('common.City')}} <strong class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="city_text" value="{{@$partners->city_text}}" id="city_text" placeholder="" readonly required type="text" {{$errors->first('city_text') ? 'autofocus' : ''}}>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="company_profile_summary">Company Profile Summary</label>
                            <textarea id="company_profile_summary" name="company_profile_summary" class="primary_textarea" readonly> {{@$partners->company_profile_summary}}</textarea>
                        </div>
                    </div>

                    <div class="white_box_tittle list_header">
                        <div class="col-md-12">
                            <h5>Bank account details</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="account_holder_name">Payee Name </label>
                            <input class="primary_input_field" name="account_holder_name" readonly value="{{@$partners->account_holder_name}}" id="account_holder_name" placeholder="" required type="text" {{$errors->first('account_holder_name') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="bank_account_number">Account number </label>
                            <input class="primary_input_field" name="bank_account_number" readonly value="{{@$partners->bank_account_number}}" id="bank_account_number" placeholder="" required type="text" {{$errors->first('bank_account_number') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="bank_name">Bank name </label>
                            <input class="primary_input_field" name="bank_name" readonly value="{{@$partners->bank_name}}" id="bank_name" placeholder="" required type="text" {{$errors->first('bank_name') ? 'autofocus' : ''}}>
                        </div>
                    </div>

                    <div class="col-md-12 mt_20">
                        <div class="remember_forgot_passs d-flex align-items-center">
                            <label class="primary_checkbox d-flex" for="checkbox" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                <input name="checkbox" type="checkbox" id="checkbox" readonly {{ ($partners->agreed_to_terms == 1) ? 'checked' : '' }}>


                                <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                <p>I hereby agree that the information provided is true and accurate.</p>
                            </label>

                        </div>
                        <span class="text-danger" role="alert">{{$errors->first('checkbox')}}</span>
                    </div>
                    <div class="col-md-12 mt_20">
                        <div class="remember_forgot_passs d-flex align-items-center">
                            <label class="primary_checkbox d-flex" for="checkbox1" style="flex: none; width: 100%; height: auto; margin-bottom: 0.5rem;">
                                <input name="checkbox1" type="checkbox" id="checkbox1" readonly {{ ($partners->agreed_to_terms == 1) ? 'checked' : '' }}>


                                <span class="checkmark mr_15" style="margin-right: 10px;"></span>
                                <p>I have read and agree to the terms and condition for e-LATiH Partner before continuing to the course development section.</p>
                            </label>

                        </div>
                        <span class="text-danger" role="alert">{{$errors->first('checkbox1')}}</span>
                    </div>
                </div>
        </div>
    </div>
</div>

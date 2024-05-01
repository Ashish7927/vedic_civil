<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/elatihlmstheme/css/register/assets/font-awesome.css')}}">
<link href="{{asset('public/frontend/elatihlmstheme/css/register/assets/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/frontend/elatihlmstheme/css/register/assets/datepicker.css')}}" rel="stylesheet" type="text/css" />
<div>
    <div class="main_content_iner account_main_content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <!-- account_profile_wrapper  -->
                    <div class="account_profile_wrapper">
                        <div class="account_profile_thumb text-center mb_30">
                            {{-- <div class="thumb">
                                <img src="{{getProfileImage($profile->image)}}" alt="">
                            </div> --}}
                            <x-student-profile-image-update :profile="$profile"/>
                            <h4>{{$profile->name}}</h4>
                            <p>{{$profile->headline}}</p>
                        </div>
                        <div class="account_profile_form">
                            <h3 class="font_22 f_w_700 mb_30">{{__('frontendmanage.My Profile')}}</h3>

                            <form action="{{route('myProfileUpdate')}}" method="POST"
                                  enctype="multipart/form-data">@csrf
                                <div class="row">
                                    <input type="hidden" name="username" value="{{$profile->email}}">
                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Full Name')}}
                                            <span>*</span></label>
                                        <input name="name" placeholder="{{__('frontend.Enter First Name')}}"
                                               onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('frontend.Enter First Name')}}'"
                                               class="primary_input4" {{$errors->first('name') ? 'autofocus' : ''}}
                                               {{ !$custom_field->editable_name ? 'readonly' : '' }}
                                               value="{{$profile->name !=""? @$profile->name:old('name')}}" type="text">
                                        <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('student.Phone Number')}} </span>
                                            <input type="text" placeholder="{{__('student.Phone Number')}}"
                                                   class="primary_input4 flag-with-code input-phone  {{ @$errors->has('phone') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->phone !=""? @$profile->phone:old('phone')}}"
                                                   name="phone" {{$errors->first('phone') ? 'autofocus' : ''}} onkeypress="javascript:return isNumber(event)" maxlength="10" minlength="9" autocomplete="off">
                                            <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>
                                        </div>
                                    </div>
                                    <?php
                                    $countrycode = str_replace('+','',$profile->country_code);
                                    if($countrycode!=''){
                                    $countryname = DB::table('countries')->where('phonecode',$countrycode)->first();
                                    $countryiso = $countryname->iso2??'MY';

                                    }
                                     ?>
                                     <input type="hidden" class="country_code" name="country_code" id="country_code" value="{{$profile->country_code}}" />
                                     <script type="text/javascript">
                                         $('.input-phone').keyup(function(){
                                            var countryCode = $('.iti__selected-flag').slice(0).attr('title');
                                            var countryCode = countryCode.replace(/[^0-9]/g,'')
                                            $('.country_code').val("");
                                             $('.country_code').val("+"+countryCode);
                                         });
                                     </script>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Email')}} <span
                                                    class=""> *</span></span>
                                            <input type="email" placeholder="{{__('common.Email')}}"
                                                   class="primary_input4 {{ @$errors->has('email') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->email !=""? @$profile->email:old('email')}}"
                                                   name="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                                        </div>

                                    </div>
                                        <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input">
                                            <span class="primary_label2">Citizenship<span
                                                    class=""> *</span></span>
                                            <select class="theme_select wide w-100 citizenship" name="citizenship"
                                            id="citizenship" {{$errors->first('citizenship') ? 'autofocus' : ''}}>
                                                 <option value="Malaysian" @if ($profile->citizenship == 'Malaysian') {{ 'selected' }} @endif>Malaysian</option>
                                                <option value="Non-Malaysian"  @if ($profile->citizenship == 'Non-Malaysian') {{ 'selected' }} @endif>Non-Malaysian</option>
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('country')}}</span>
                                        </div>
                                    </div>
                                     <div class="col-lg-6 col-md-6 mt_20 nationalitydiv" <?php if ($profile->citizenship!='Non-Malaysian'){ ?>style="display:none" <?php } ?>>
                                        <div class="single_input">
                                            <span class="primary_label2">Nationality<span
                                                    class=""> *</span></span>
                                            <select class="theme_select wide w-100" name="nationality"
                                            id="nationality" {{$errors->first('citizenship') ? 'autofocus' : ''}}>
                                                <option data-display="{{__('common.Country')}}" value="">{{__('common.Select')}}</option>
                                                @if(isset($countries))
                                                    @foreach ($countries as $country)
                                                        <option value="{{@$country->id}}"
                                                                @if ($profile->nationality==$country->id) selected @endif>{{@$country->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('country')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20 racediv" <?php if ($profile->citizenship!='Malaysian'){ ?> style="display:none" <?php } ?>>
                                        <div class="single_input ">
                                            <span class="primary_label2">Race<span
                                                    class=""> *</span></span>
                                            <select class="theme_select wide w-100 race" name="race" {{$errors->first('country') ? 'autofocus' : ''}}>
                                                <option value="Malay" @if ($profile->race == 'Malay') {{ 'selected' }} @endif>Malay</option>
                                                <option value="Chinese" @if ($profile->race == 'Chinese') {{ 'selected' }} @endif>Chinese</option>
                                                <option value="Indian" @if ($profile->race == 'Indian') {{ 'selected' }} @endif>Indian</option>
                                                <option value="Others" @if ($profile->race == 'Others') {{ 'selected' }} @endif>Others</option>
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('country')}}</span>
                                        </div>

                                    </div>
                                     <div class="col-lg-6 col-md-6 mt_20" id="race_other" <?php if ($profile->race!='Others'){ ?> style="display:none" <?php } ?>>
                                <span class="primary_label2">Race Other</span>
                                    <input type="text" class="primary_input4"
                                           placeholder="Race Other"
                                           aria-label="race_other" name="race_other" value="{{$profile->race_other}}">
                                <span class="text-danger" role="alert">{{$errors->first('race_other')}}</span>
                            </div>

                                    <div class="col-lg-6 col-md-6 mt_20 racediv" <?php if ($profile->citizenship!='Malaysian'){ ?> style="display:none" <?php } ?>>
                                            <div class="single_input ">
                                                <span class="primary_label2">{{__('common.identification_number')}} <span>{{ $custom_field->required_identification_number ? '*' : ''}}</span> </span>
                                                <input type="text" placeholder="{{__('common.identification_number')}}"
                                                       class="primary_input4  {{ @$errors->has('identification_number') ? ' is-invalid' : '' }}" onkeypress="javascript:return isNumber(event)"
                                                       value="{{$profile->identification_number !=""? @$profile->identification_number:old('identification_number')}}"
                                                       name="identification_number" {{$errors->first('identification_number') ? 'autofocus' : ''}}
                                                    {{ $custom_field->required_identification_number ? 'required' : ''}} {{$custom_field->editable_identification_number ? '' : 'readonly'}}>
                                                <span class="text-danger" role="alert">{{$errors->first('identification_number')}}</span>
                                            </div>
                                        </div>

                                    <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span class="primary_label2">{{__('common.Date of Birth')}} <span>{{ $custom_field->required_dob ? '*' : ''}}</span> </span>
                                               <div id="datepickernn" class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input id="dob" type="text" class="primary_input4 datepicker"  autocomplete="off"
                                           placeholder="Birth Date" data-date-format="dd/mm/yyyy"
                                           {{ $custom_field->required_dob ? 'required' : ''}} aria-label="Username"
                                           name="dob" value="{{ $profile->dob }}" required>
                                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                       </div>
                                                <span class="text-danger" role="alert">{{$errors->first('dob')}}</span>
                                            </div>
                                        </div>
                                          <script src="{{asset('public/frontend/elatihlmstheme/css/register/assets/bootstrap.min.js')}}"></script>
<script src="{{asset('public/frontend/elatihlmstheme/css/register/assets/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $("#datepickernn").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update');
});

                                   </script>
                                        <style type="text/css">
                                            label{margin-left: 20px;}

#dob > span:hover{cursor: pointer;}

#datepickernn > span:hover{cursor: pointer;}
input#dob {
    float: left;
    width: 100%;
    margin: 0;
    border-radius: 5px 0px 0px 5px;
    border: 1px solid #e9e7f7!important;
}
.iti{
    width: 100%;
    margin: 0;
    border-radius: 5px;
    border: 1px solid #e9e7f7!important;}
    input.form-control.flag-with-code.input-phone{    border-top: none!important;
    box-shadow: none;
    border: none!important;}
                                        </style>
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span class="primary_label2">{{__('common.gender')}} <span>{{ $custom_field->required_gender ? '*' : ''}}</span> </span>

                                                <select class="theme_select wide mb_20"
                                                        name="gender" {{$errors->first('gender') ? 'autofocus' : ''}}  {{$custom_field->editable_gender ? '' : 'readonly'}}>
                                                    {{$errors->first('gender') ? 'autofocus' : ''}}>
                                                    <option value="male" @if ($profile->gender=='male') selected @endif>Male</option>
                                                    <option value="female" @if ($profile->gender=='female') selected @endif>Female</option>
                                                </select>
                                                <span class="text-danger" role="alert">{{$errors->first('gender')}}</span>
                                            </div>
                                        </div>

                                       <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span class="primary_label2">Employment Status<span></span> </span>
                                            <select class="theme_select wide mb_20"
                                                    name="employment_status" id="employment_status" required>
                                                <option value="working"  @if ($profile->employment_status=='working') selected @endif>Working</option>
                                                <option value="not-working"  @if ($profile->employment_status=='not-working') selected @endif>Not Working</option>
                                                <option value="self-employed"  @if ($profile->employment_status=='self-employed') selected @endif >Self Employed</option>
                                            </select>

                                    <span class="text-danger" role="alert">{{$errors->first('employment_status')}}</span>
                                        </div>
                                    </div>

                            <div class="col-lg-6 col-md-6 mt_20" <?php if ($profile->employment_status!='working'){ ?> style="display:none" <?php } ?>  id="job_designation">
                                            <span class="primary_label2">Job Designation</span>
                                            <select class="theme_select wide mb_20"
                                                    name="job_designation">
                                                <option value="Manager"  @if ($profile->job_designation=='Manager') selected @endif>Manager</option>
                                                <option value="Professional"  @if ($profile->job_designation=='Professional') selected @endif>Professional</option>
                                                <option value="Technician and Associate Professional"  @if ($profile->job_designation=='Technician and Associate Professional') selected @endif>Technician and Associate Professional</option>
                                                <option value="Clerical Support Worker"  @if ($profile->job_designation=='Clerical Support Worker') selected @endif>Clerical Support Worker</option>
                                                <option value="Service and Sale Worker"  @if ($profile->job_designation=='Service and Sale Worker') selected @endif>Service and Sale Worker</option>
                                                <option value="Skilled Agricultural,Forestry and Fishery Worker"  @if ($profile->job_designation=='Skilled Agricultural,Forestry and Fishery Worker') selected @endif>Skilled Agricultural,Forestry and Fishery Worker</option>
                                                <option value="Craft and Related Trade Worker"  @if ($profile->job_designation=='Craft and Related Trade Worker') selected @endif>Craft and Related Trade Worker</option>
                                                <option value="Elementary Worker"  @if ($profile->job_designation=='Elementary Worker') selected @endif>Elementary Worker</option>
                                                <option value="Plant and Machine Operator and Assembler Worker"  @if ($profile->job_designation=='Plant and Machine Operator and Assembler Worker') selected @endif>Plant and Machine Operator and Assembler Worker</option>
                                                <option value="Armed Forced Worker"  @if ($profile->job_designation=='Armed Forced Worker') selected @endif>Armed Forced Worker</option>
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('job_designation')}}</span>
                                        </div>

                            <div class="col-lg-6 col-md-6 mt_20" <?php if ($profile->employment_status!='working'){ ?> style="display:none" <?php } ?>  id="sector"><span class="primary_label2">Sector</span>
                                            <select class="theme_select wide mb_20 sector"
                                            name="sector">
                                                <option value="Manufacturing" @if ($profile->sector=='Manufacturing') selected @endif>Manufacturing</option>
                                                <option value="Mining and quarrying" @if ($profile->sector=='Mining and quarrying') selected @endif>Mining and quarrying</option>
                                                <option value="Construction" @if ($profile->sector=='Construction') selected @endif>Construction</option>
                                                <option value="Agriculture" @if ($profile->sector=='Agriculture') selected @endif>Agriculture</option>
                                                <option value="Government" @if ($profile->sector=='Government') selected @endif>Government</option>
                                                <option value="NGO" @if ($profile->sector=='NGO') selected @endif>NGO</option>
                                                <option value="Services(eg: Financial Institution, Hospitality, F&B)" @if ($profile->sector=='Services(eg: Financial Institution, Hospitality, F&B)') selected @endif>Services(eg: Financial Institution, Hospitality, F&B)</option>
                                                <option value="Others" @if ($profile->sector=='Others') selected @endif>Others</option>
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('sector')}}</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mt_20" id="sector_other" <?php if ($profile->sector!='Others'){ ?> style="display:none" <?php } ?>>
                                <span class="primary_label2">Sector Other</span>
                                    <input type="text" class="primary_input4"
                                           placeholder="Sector Other"
                                           aria-label="sector_other" name="sector_other" value="{{$profile->sector_other}}">
                                <span class="text-danger" role="alert">{{$errors->first('sector_other')}}</span>
                            </div>
                            <div class="col-lg-6 col-md-6 mt_20" <?php if ($profile->employment_status!='self-employed'){ ?> style="display:none" <?php } ?> id="business_nature">
                                <span class="primary_label2">Business Nature/Activity</span>
                                            <select class="theme_select wide mb_20 business_nature" name="business_nature">
                                                <option value="Accomodation/Food Beverage service Activities" @if ($profile->business_nature=='Accomodation/Food Beverage service Activities') selected @endif>Accomodation/Food Beverage service Activities</option>
                                                <option value="Agriculture/Forestry/Fishing" @if ($profile->business_nature=='Agriculture/Forestry/Fishing') selected @endif>Agriculture/Forestry/Fishing</option>
                                                <option value="Arts/Entertainment/Recreation/Construction" @if ($profile->business_nature=='Arts/Entertainment/Recreation/Construction') selected @endif>Arts/Entertainment/Recreation/Construction</option>
                                                <option value="Education" @if ($profile->business_nature=='Education') selected @endif>Education</option>
                                                <option value="Electricity/Gas/Steam/Air conditioning Supply" @if ($profile->business_nature=='Electricity/Gas/Steam/Air conditioning Supply') selected @endif>Electricity/Gas/Steam/Air conditioning Supply</option>
                                                <option value="Financial/Insurance/Takaful activities" @if ($profile->business_nature=='Financial/Insurance/Takaful activities') selected @endif>Financial/Insurance/Takaful activities</option>
                                                <option value="Human Health/Social Work Activities" @if ($profile->business_nature=='Human Health/Social Work Activities') selected @endif>Human Health/Social Work Activities</option>
                                                <option value="Information/Communication" @if ($profile->business_nature=='Information/Communication') selected @endif>Information/Communication</option>
                                                <option value="Manufacturing" @if ($profile->business_nature=='Manufacturing') selected @endif>Manufacturing</option>
                                                <option value="Mining/Quarrying" @if ($profile->business_nature=='Mining/Quarrying') selected @endif>Mining/Quarrying</option>
                                                <option value="Professional/Scientific/Technical Activities" @if ($profile->business_nature=='Professional/Scientific/Technical Activities') selected @endif>Professional/Scientific/Technical Activities</option>
                                                <option value="Public Administration/Defence/Compulsory Social Security" @if ($profile->business_nature=='Public Administration/Defence/Compulsory Social Security') selected @endif>Public Administration/Defence/Compulsory Social Security</option>
                                                <option value="Real Estate Activities" @if ($profile->business_nature=='Real Estate Activities') selected @endif>Real Estate Activities</option>
                                                <option value="Transportation/Storage" @if ($profile->business_nature=='Transportation/Storage') selected @endif>Transportation/Storage</option>
                                                <option value="Water Supply/Sewage/Waste Management/Remediation Activities" @if ($profile->business_nature=='Water Supply/Sewage/Waste Management/Remediation Activities') selected @endif>Water Supply/Sewage/Waste Management/Remediation Activities</option>
                                                <option value="Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles" @if ($profile->business_nature=='Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles') selected @endif>Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles</option>
                                                <option value="Others" @if ($profile->business_nature=='Others') selected @endif>Others</option>
                                            </select>

                                    <span class="text-danger" role="alert">{{$errors->first('business_nature')}}</span>
                                        </div>

                            <div class="col-lg-6 col-md-6 mt_20" id="business_nature_other" <?php if ($profile->business_nature!='Others'){ ?> style="display:none" <?php } ?>>
                                <span class="primary_label2">Business Nature Other</span>
                                    <input type="text" class="primary_input4"
                                           placeholder="Business Nature Other"
                                           aria-label="business_nature_other" name="business_nature_other" value="{{$profile->business_nature_other}}">
                                <span class="text-danger" role="alert">{{$errors->first('business_nature_other')}}</span>
                            </div>

                            <div class="col-lg-6 col-md-6 mt_20" <?php if ($profile->employment_status!='not-working'){ ?> style="display:none" <?php } ?> id="not_working">
                               <span class="primary_label2"> Not Working Status</span>
                                <select class="theme_select wide mb_20" name="not_working">
                                    <option value="Student" @if ($profile->not_working == 'Student') {{ 'selected' }} @endif>Student</option>
                                    <option value="Fresh Graduate" @if ($profile->not_working == 'Fresh Graduate') {{ 'selected' }} @endif>Fresh Graduate</option>
                                    <option value="Retrenched" @if ($profile->not_working == 'Retrenched') {{ 'selected' }} @endif>Retrenched</option>
                                    <option value="Retired" @if ($profile->not_working == 'Retired') selected @endif>Retired</option>
                                    <option value="Home Worker/House Wife" @if ($profile->not_working == 'Home Worker/House Wife') selected @endif>Home Worker/House Wife</option>
                                </select>
                                <span class="text-danger" role="alert">{{$errors->first('not_working')}}</span>
                            </div>
                            <div class="col-lg-6 col-md-6 mt_20">
                                <span class="primary_label2">Highest Academic Qualification </span>
                                            <select class="theme_select wide mb_20"
                                                    name="highest_academic" required>
                                                <option value="Primary School" @if ($profile->highest_academic == 'Primary School') selected @endif>Primary School</option>
                                                <option value="Secondary School"  @if ($profile->highest_academic == 'Secondry School') selected @endif>Secondary School</option>
                                                <option value="SPM/O-Level/SVM/equivalent"  @if ($profile->highest_academic == 'SPM/O-Level/SVM/equivalent') selected @endif>SPM/O-Level/SVM/equivalent</option>
                                                <option value="Bachelor's Degree/equivalent"  @if ($profile->highest_academic == 'Bachelor\'s Degree/equivalent') selected  @endif>Bachelor's Degree/equivalent</option>
                                                <option value="Master's Degree/equivalent"  @if ($profile->highest_academic == 'Master\'s Degree/equivalent') selected @endif>Master's Degree/equivalent</option>
                                                <option value="Doctoral Degree"  @if ($profile->highest_academic == 'Doctoral Degree')  selected  @endif>Doctoral Degree</option>
                                            </select>

                                    <span class="text-danger" role="alert">{{$errors->first('highest_academic')}}</span>
                                </div>

                            <div class="col-lg-6 col-md-6 mt_20">
                                <span class="primary_label2">Current Residing State</span>
                                <select class="theme_select wide mb_20"
                                                    name="current_residing" required>
                                                <option value="Kuala Lumpur" @if ($profile->current_residing == 'Kuala Lumpur') {{ 'selected' }} @endif>Kuala Lumpur</option>
                                                <option value="Selangor" @if ($profile->current_residing == 'Selangor') {{ 'selected' }} @endif>Selangor</option>
                                                <option value="Putrajaya" @if ($profile->current_residing == 'Putrajaya') {{ 'selected' }} @endif>Putrajaya</option>
                                                <option value="Labuan" @if ($profile->current_residing == 'Labuan') {{ 'selected' }} @endif>Labuan</option>
                                                <option value="Sabah" @if ($profile->current_residing == 'Sabah') {{ 'selected' }} @endif>Sabah</option>
                                                <option value="Sarawak" @if ($profile->current_residing == 'Sarawak') {{ 'selected' }} @endif>Sarawak</option>
                                                <option value="Melaka" @if ($profile->current_residing == 'Melaka') {{ 'selected' }} @endif>Melaka</option>
                                                <option value="Kelantan" @if ($profile->current_residing == 'Kelantan') {{ 'selected' }} @endif>Kelantan</option>
                                                <option value="Pahang" @if ($profile->current_residing == 'Pahang') {{ 'selected' }} @endif>Pahang</option>
                                                <option value="Perak" @if ($profile->current_residing == 'Perak') {{ 'selected' }} @endif>Perak</option>
                                                <option value="Pulau Pinang" @if ($profile->current_residing == 'Pulau Pinang') {{ 'selected' }} @endif>Pulau Pinang</option>
                                                <option value="Negeri Sembilan" @if ($profile->current_residing == 'Negeri Sembilan') {{ 'selected' }} @endif>Negeri Sembilan</option>
                                                <option value="Kedah" @if ($profile->current_residing == 'Kedah') {{ 'selected' }} @endif>Kedah</option>
                                                <option value="Perlis" @if ($profile->current_residing == 'Perlis') {{ 'selected' }} @endif>Perlis</option>
                                                <option value="Johor" @if ($profile->current_residing == 'Johor') {{ 'selected' }} @endif>Johor</option>
                                                <option value="Terengganu" @if ($profile->current_residing == 'Terengganu') {{ 'selected' }} @endif>Terengganu</option>
                                            </select>

                                    <span class="text-danger" role="alert">{{$errors->first('current_residing')}}</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mt_20">
                                <span class="primary_label2">Postcode</span>
                                    <input type="text" class="primary_input4"
                                           placeholder="Postcode" name="zip" value="{{$profile->zip}}" onkeypress="javascript:return isNumber(event)">
                                <span class="text-danger" role="alert">{{$errors->first('zip')}}</span>
                            </div>

                                    <div class="col-12">
                                        <button
                                            class="theme_btn w-100 text-center mt_40">{{__('student.Save')}}</button>
                                    </div>
                                    <!-- <div class="col-6" style="text-align: center">
                                        <button
                                            class="theme_btn w-100 text-center mt_40" type="button"
                                            onclick=" window.open('{{ route('myProfile.download') }}','_blank')">{{__('student.Download')}} {{__('student.Transcript')}}</button>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script>
        $('#employment_status').change(function(){
            if($(this).val() == 'working'){
                $('#job_designation').show();
                $('#sector').show();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            }else if($(this).val() == 'not-working'){
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').show();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            }else if($(this).val() == 'self-employed'){
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').show();
                 $('#business_nature_other').hide();
                 $('#sector_other').hide();
            }else{
                $('#job_designation').hide();
                $('#sector').hide();
                $('#not_working').hide();
                $('#business_nature').hide();
                $('#business_nature_other').hide();
                $('#sector_other').hide();
            }
        });
        $('.business_nature').change(function(){
            if($(this).val() == 'Others'){
            $('#business_nature_other').show();
        }else{
            $('#business_nature_other').hide();
        }
        });
        $('.sector').change(function(){
            if($(this).val() == 'Others'){
            $('#sector_other').show();
        }else{
            $('#sector_other').hide();
        }
        });
       $('.citizenship').change(function(){
            if($(this).val() == 'Malaysian'){
                $('.racediv').show();
                $('.race').attr('required',true);
                $('.nationalitydiv').hide();
                $('#identification_number').attr('required',true);
            }else{
                $('.racediv').hide();
                 $('.nationalitydiv').show();
                 $('#race_other').hide();
                 $('.race').attr('required',false);
                 $('#identification_number').attr('required',false);
            }
        });
    </script>
<script>
  function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)){
            return false;
        }
        return true;
    }
</script>
<script src="{{asset('public/frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/intlTelInput.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/frontend/elatihlmstheme/css/register/lib/intl-tel-input/css/intlTelInput.css')}}"/>
<?php if($countrycode!=''){
    ?>
    <script>
    const phoneInputField = document.querySelector(".input-phone");
    const phoneInput = window.intlTelInput(phoneInputField,{
        initialCountry:"<?php echo $countryiso; ?>",
        utilsScript:"{{asset('public/frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,
   });
</script>
<?php }else{ ?>
    <script>
    const phoneInputField = document.querySelector(".input-phone");
    const phoneInput = window.intlTelInput(phoneInputField,{
        initialCountry:"MY",
        utilsScript:"{{asset('public/frontend/elatihlmstheme/css/register/lib/intl-tel-input/js/utils.js')}}",
        separateDialCode:false,
        formatOnDisplay:false,


   });
</script>
<?php } ?>

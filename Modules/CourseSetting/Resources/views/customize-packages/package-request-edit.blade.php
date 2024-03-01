@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>
                    {{ __('Package Request') }}
                </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('courses.Packages') }}</a>
                    <a href="#">
                       
                        {{ __('Request Edit') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="white_box mb_30">
            <div class="col-lg-12">
                <form action="{{ route('updatePackageRequest') }}" method="POST" enctype="multipart/form-data" id="addPackageForm">
                    @csrf

                    <div class="row">
                        <input type="hidden" name="package_request_id" value="{{ $requestPackage->id }}">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">
                                    {{ __('common.Full Name') }} *
                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Name Description: The Full name inserted . "></i>
                                </label>
                                <input class="primary_input_field" name="name" placeholder="-" id="name"
                                    data-toggle="tooltip" title="{{ __('common.Full Name') }}" type="text"
                                    {{ $errors->has('name') ? 'autofocus' : '' }}
                                    value="{{ $requestPackage->full_name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.email') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Email Description: Insert Email Address."></i>
                                </label>
                                <input class="primary_input_field" name="email_address" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('common.email') }}" type="text"
                                    value="{{ $requestPackage->email_address }}">
                                @if ($errors->has('email_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         @if (isAdmin())
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="user_id">{{__('common.Content Provider')}} </label>
                                    <select class="primary_select category_id" name="user_id" title="{{__('common.Content Provider')}}" id="user_id">
                                        <option title="" data-display="{{__('common.Select')}} {{__('common.Content Provider')}}"
                                        value="">{{__('common.Select')}} {{__('common.Content Provider')}} </option>
                                        @foreach ($content_providers as $content_provider)
                                            <option value="{{ $content_provider->id }}" {{ (isset($requestPackage) && $requestPackage->assign_to == $content_provider->id) ? 'selected' : '' }}> {{ $content_provider->name }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                      
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Phone Number') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Phone Number Description: Insert Phone Number."></i>
                                </label>
                                <input class="primary_input_field" name="phone_number" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('common.Phone Number') }}" type="text"
                                    value="{{ $requestPackage->phone_number }}">
                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Company Name') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Company Name Description: Insert Company Name."></i>
                                </label>
                                <input class="primary_input_field" name="company_name" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('common.Company Name') }}" type="text"
                                    value="{{ $requestPackage->company_name }}">
                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Company Registration') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Company Registration Description: Insert Company Registration Number."></i>
                                </label>
                                <input class="primary_input_field" name="company_registration" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('common.Company Registration') }}" type="text"
                                    value="{{ $requestPackage->company_registration }}">
                                @if ($errors->has('company_registration'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_registration') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    
                    <div class="col-xl-6">

                                        <label class="primary_input_label" for="question-type">Status</label>
                                            <select class="primary_select" name="request_status" id="question-type">
                                                <option data-display="Select Status" value="">Select Status
                                                </option>

                                                <option value="New" @if($requestPackage->request_status == "New") {{ 'selected' }}  @endif> New</option>
                                                    }
                                                
                                                <option value="In-Progress" @if($requestPackage->request_status == "In-Progress") {{ 'selected' }}  @endif> In-Progress </option>
                                                <option value="Completed" @if($requestPackage->request_status == "Completed") {{ 'selected' }}  @endif> Completed</option>
                                                <option value="Closed" @if($requestPackage->request_status == "Closed") {{ 'selected' }}  @endif>Closed</option>
                                            </select>
                        </div>
                    </div>                                                    
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="save_package">
                                <span class="ti-check"></span>
                                {{ __('Request') }} {{ __('courses.Packages') }}  {{ __('Edit') }}
                                <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="save_loading_spinner"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


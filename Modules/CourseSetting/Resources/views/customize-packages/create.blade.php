@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>
                    @if (isset($package))
                         {{ __('common.Edit') }}
                    @else
                         {{ __('common.Add New') }}
                    @endif
                    {{ __('courses.Custom Package') }}
                </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('courses.Packages') }}</a>
                    <a href="#">
                        @if (isset($package))
                             {{ __('common.Edit') }}
                        @else
                            {{ __('common.Add New') }}
                        @endif
                        {{ __('courses.Custom Package') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="white_box mb_30">
            <div class="col-lg-12">
                <form action="{{ route('saveCustomizePackage') }}" method="POST" enctype="multipart/form-data" id="addPackageForm">
                    @csrf

                    @isset($package)
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                    @endisset

                    <input type="hidden" name="status" id="status" value="{{ old('name', isset($package) ? $package->status : '') }}">

                    <div class="row">
                        @php $col = (isAdmin()) ? 6 : 12; @endphp

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Packages') }}
                                    {{ __('common.Name') }} *
                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Name Description: The package name should be a brief, general statement of the subject matter and reflect the package content. The package name should not exceed 100 characters, including spaces. "></i>
                                </label>
                                <input class="primary_input_field" name="name" placeholder="-" id="name"
                                    data-toggle="tooltip" title="{{ __('common.Name') }}" type="text"
                                    {{ $errors->has('name') ? 'autofocus' : '' }}
                                    value="{{ old('name', isset($package) ? $package->name : '') }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="user_id">{{__('common.Corporate Admin')}} </label>
                                    <select class="primary_select category_id" name="user_id" title="{{__('common.Corporate Admin')}}" id="user_id">
                                        <option title="" data-display="{{__('common.Select')}} {{__('common.Corporate Admin')}}"
                                        value="">{{__('common.Select')}} {{__('common.Corporate Admin')}} </option>
                                        @foreach ($corporates as $corporate)
                                            <option value="{{ $corporate->cpa_id }}" {{ (isset($package) && $package->corporate_id == $corporate->cpa_id) ? 'selected' : '' }}> {{ $corporate->user->name }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @if(check_whether_cp_or_not() || isPartner() || isAdmin())
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Select') }}
                                    {{ __('courses.Course') }} * </label>
                                <select class="select2" name="package_courses[]" id="package_courses" multiple>
                                    @if(isset($package) && !empty($package_courses))

                                        @foreach ($package_courses as $key =>$package_course)
                    
                                            <option value="{{ $package_course['id'] }}" selected>
                                                {{ $package_course['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('package_courses'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('package_courses') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                     
                        @endif
                    </div>
                   
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Price') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Price Description: Insert course price without RM/MYR. Price is inclusive of SST (if applicable)."></i>
                                </label>
                                <input class="primary_input_field" name="price" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('courses.Price') }}" type="number"
                                    value="{{ old('price', isset($package) ? $package->price : '') }}">
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Expiry Period') }} *</label>
                                <select class="primary_select" name="expiry_period" id="expiry_period">
                                    <option value="">{{ __('common.Select') }} {{ __('courses.Expiry Period') }}</option>
                                    <option value="6" {{ (isset($package) && $package->expiry_period == 6) ? 'selected' : '' }}>6 Months</option>
                                    <option value="12" {{ (isset($package) && $package->expiry_period == 12) ? 'selected' : '' }}>12 Months</option>
                                    <option value="18" {{ (isset($package) && $package->expiry_period == 18) ? 'selected' : '' }}>18 Months</option>
                                    <option value="24" {{ (isset($package) && $package->expiry_period == 24) ? 'selected' : '' }}>24 Months</option>
                                </select>
                                @if ($errors->has('expiry_period'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('expiry_period') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('courses.Packages') }}
                                    {{ __('courses.Description') }} * <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="•    Package Description: A summary of the significant learning experiences for the package."></i>
                                </label>
                                <textarea class="lms_summernote tooltip_class" name="description" data-toggle="tooltip"
                                    title="{{ __('courses.Description') }}" cols="30" rows="10">{{ old('description', isset($package) ? $package->description : '') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
           
                    <div class="row mt-20">
                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('Image') }}
                                    ({{ __('common.Max Image Size 5MB') }}) (Recommend size: 1170x600) * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Image Description: The maximum image size is 5mb. The recommended size: 1170x600 pixels and file format must be in .jpg."></i>
                                </label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder" type="text" id=""
                                        {{ $errors->has('image') ? 'autofocus' : '' }}
                                        placeholder="{{ __('Browse Image file') }}" readonly=""
                                        data-toggle="tooltip" title="{{ __('courses.Image') }}"
                                        value="{{ isset($package) && !empty($package->image) ? showPicName($package->image) : '' }}">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="image">{{ __('Browse') }}</label>
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
                        @if(isAdmin())
                        <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="aprove_status">{{__('common.Approved Status')}}</label>
                                    <select class="primary_select category_id" name="aprove_status" title="{{__('common.Approved Status')}}" id="aprove_status">
                                        <option title="" data-display="{{__('common.Select')}} {{__('common.Approved Status')}}"
                                        value="">{{__('common.Select')}} {{__('common.Approved Status')}}</option>
                                            <option value="0" {{ (isset($package) && $package->aprove_status == 0) ? 'selected' : '' }}>Not Approved</option>
                                            <option value="1" {{ (isset($package) && $package->aprove_status == 1) ? 'selected' : '' }}>Approved</option>
                                    </select>
                                </div>
                        </div>
                        @endif
                    </div>

                  <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="save_package">
                                <span class="ti-check"></span>
                                {{ __('Save') }} {{ __('courses.Packages') }}
                                <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="save_loading_spinner"></i>
                            </button>
                            @if(isAdmin())
                             @if (isset($package) && $package->status == 1)
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="unpublish_package">
                                    <span class="ti-check"></span>
                                    {{ __('UnPublish') }} {{ __('courses.Packages') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="unpublish_loading_spinner"></i>
                                </button>
                            @else
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="publish_package">
                                    <span class="ti-check"></span>
                                    {{ __('Publish') }} {{ __('courses.Packages') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="publish_loading_spinner"></i>
                                </button>
                            @endif 
                            @endif 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>   
@endsection
@if(isAdmin())
<div class="modal fade admin-query" id="confirm-unpublish">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.UnPublish') }} {{ __('courses.Packages') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">{{ __('Are you sure to UnPublish Package ?') }}</h3>

                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <a id="btn_unpublish" class="primary-btn semi_large2 fix-gr-bg">{{ __('UnPublish') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@push('scripts')
    <script>
        $('.lms_summernote').summernote({
            placeholder: '',
            tabsize: 2,
            height: 150,
            tooltip: true,
            callbacks: {
                onImageUpload: function(files) {
                    sendFile(files, '.lms_summernote')
                }
            }
        });

        // $("#category_ids").select2({
        //     allowClear: true,
        //     ajax: {
        //         url: "{{ route('get_categories') }}",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 term: params.term || '',
        //                 page: params.page || 1
        //             }
        //         },
        //         cache: true
        //     }
        // });

        $("#package_courses").select2({
            allowClear: true,
            ajax: {
                url: "{{ route('get-courses-data') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
        });

        $(document).on('click', '#save_package', function() {
            $('#publish_package').prop('disabled', true);
            loaderstart('save_package', 'save_loading_spinner');
            $('#addPackageForm').submit();
        });

        $(document).on('click', '#publish_package', function() {
            $('#save_package').prop('disabled', true);
            loaderstart('publish_package', 'publish_loading_spinner');
            $('#status').val(1);
            $('#addPackageForm').submit();
        });

        $(document).on('click', '#unpublish_package', function() {
            $('#confirm-unpublish').modal('show', { backdrop: 'static' });
            return false;
        });

        $(document).on('click', '#btn_unpublish', function() {
            $('#confirm-unpublish').modal('hide');
            $('#save_package').prop('disabled', true);
            loaderstart('unpublish_package', 'unpublish_loading_spinner');
            $('#status').val(0);
            $('#addPackageForm').submit();
        });

        function loaderstart(button, spinner) {
            $('#' + button).prop('disabled', true);
            $('#' + spinner).removeClass('d-none');
        }
    </script>
@endpush

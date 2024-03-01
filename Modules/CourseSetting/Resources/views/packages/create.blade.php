@extends('backend.master')
@push('styles')
    <style>
        .select2-search__field {
            padding-left: 10px !important;
        }
    </style>
@endpush
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
                    {{ __('courses.Package') }}
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
                        {{ __('courses.Package') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="white_box mb_30">
            <div class="col-lg-12">
                <form action="{{ route('savePackage') }}" method="POST" enctype="multipart/form-data" id="addPackageForm">
                    @csrf

                    @isset($package)
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                    @endisset

                    <input type="hidden" name="status" id="status" value="">

                    <div class="row">
                        @php $col = (isAdmin() || isHRDCorp() || isMyLL()) ? 6 : 12; @endphp

                        <div class="col-xl-{{ $col }}">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Package') }}
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

                        @if (isAdmin() || isHRDCorp() || isMyLL())
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="user_id">{{ __('common.Select') }} {{ __('common.Partner') }}/{{__('common.Content Provider')}} </label>
                                    <select class="primary_select category_id" name="user_id" title="{{ __('common.Select') }} {{ __('common.Partner') }}/{{ __('common.Content Provider') }}" id="user_id">
                                        <option title="" data-display="{{__('common.Select')}} {{ __('common.Partner') }}/{{ __('common.Content Provider') }}"
                                        value="">{{__('common.Select')}} {{ __('common.Partner') }}/{{ __('common.Content Provider') }} </option>
                                        @foreach ($content_providers as $content_provider)
                                            <option value="{{ $content_provider->id }}" {{ (old('user_id') == $content_provider->id) || (isset($package) && $package->user_id == $content_provider->id) ? 'selected' : '' }}> {{ $content_provider->name }} </option>
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
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Select') }} {{ __('courses.Category') }} * <i class="fas fa-info-circle" data-toggle="tooltip" title="• Skill Area Description: Refer Package Creation Guide for Skill Area."> </i> </label>
                                <select class="select2" name="category_ids[]" id="category_ids" multiple>
                                    @if(isset($package) && !empty($package_categories))
                                        @foreach ($package_categories as $package_category)
                                            <option value="{{ $package_category['id'] }}" selected> {{ $package_category['title'] }}</option>
                                        @endforeach
                                    @endif
                                    @if (!isset($package) && old('category_ids'))
                                        @php
                                            $category = Modules\CourseSetting\Entities\Category::select('id', 'name')->whereIn('id', old('category_ids'))->get();
                                        @endphp

                                        @foreach ($category as $item)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('category_ids'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('category_ids') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6 courseBox">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('Upload Method') }} *
                                    <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course URL: Insert a valid URL."></i>
                                </label>
                                <div class="row pt-2">
                                    <div class="col-md-3 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="upload_method" id="upload_method1" name="upload_method" value="1" checked>
                                            <span data-toggle="tooltip" title="{{ __('URL') }}" class="checkmark mr-2"></span>
                                            {{ __('URL') }}
                                        </label>
                                    </div>
                                    <div class="col-md-3 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="upload_method" id="upload_method2" name="upload_method" value="2" {{ (old('upload_method') == 2 || (isset($package) && $package->upload_method == 2)) ? 'checked' : '' }}>
                                            <span  data-toggle="tooltip" title="{{ __('Course Binding') }}" class="checkmark mr-2"></span>
                                            {{ __('Course Binding') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $course_dropdown_style = 'display: none;';
                        $url_type_style = '';

                        if (old('upload_method') == 2 || (isset($package) && $package->upload_method == 2)) {
                            $url_type_style = 'display: none;';
                            $course_dropdown_style = '';
                        }
                    @endphp

                    <div class="row">
                        <div class="col-xl-6" id="div_course_url" style="{{ $url_type_style }}">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Package') }} {{ __('Url') }} *
                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Package URL: Insert a valid URL."></i>
                                </label>
                                <input class="primary_input_field" name="course_url" placeholder="-" id="course_url" data-toggle="tooltip" title="{{ __('courses.Package') }} {{ __('Url') }}" type="url" {{ $errors->has('course_url') ? 'autofocus' : '' }} value="{{ old('course_url', isset($package) ? $package->course_url : '') }}">
                                @if ($errors->has('course_url'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('course_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6" id="div_course_count" style="{{ $url_type_style }}">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Total number of course') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Total number of course Description: Insert total number of course."></i>
                                </label>
                                <input class="primary_input_field" name="total_course" placeholder="-" id="addTotalCourse"
                                    data-toggle="tooltip" title="{{ __('courses.Total number of course') }}" type="text"
                                    value="{{ old('total_course', isset($package) ? $package->total_course : '') }}">
                                @if ($errors->has('total_course'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('total_course') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6" id="div_course_dropdown" style="{{ $course_dropdown_style }}">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Select') }}
                                    {{ __('courses.Course') }} * </label>
                                <select class="select2" name="package_courses[]" id="package_courses" multiple>
                                    @if(isset($package) && !empty($package_courses))
                                        @foreach ($package_courses as $package_course)
                                            <option value="{{ $package_course['id'] }}" selected>
                                                {{ $package_course['title'] }}</option>
                                        @endforeach
                                    @endif

                                    @if (!isset($package) && old('package_courses'))
                                        @php
                                            $courses = Modules\CourseSetting\Entities\Course::withoutGlobalScope('withoutsubscription')->select('id', 'title')->whereIn('id', old('package_courses'))->get();
                                        @endphp

                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}" selected>{{ $course->title }}</option>
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
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Price') }} * <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Price Description: Insert course price without RM/MYR. Price is inclusive of SST (if applicable)."></i>
                                </label>
                                <input class="primary_input_field" name="price" placeholder="-" id="addPrice"
                                    data-toggle="tooltip" title="{{ __('courses.Price') }}" type="text"
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
                                    <option value="6" {{ old('expiry_period') == 6 || ((isset($package) && $package->expiry_period == 6)) ? 'selected' : '' }}>6 Months</option>
                                    <option value="12" {{ old('expiry_period') == 12 || ((isset($package) && $package->expiry_period == 12)) ? 'selected' : '' }}>12 Months</option>
                                    <option value="18" {{ old('expiry_period') == 18 || ((isset($package) && $package->expiry_period == 18)) ? 'selected' : '' }}>18 Months</option>
                                    <option value="24" {{ old('expiry_period') == 24 || ((isset($package) && $package->expiry_period == 24)) ? 'selected' : '' }}>24 Months</option>
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
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Minimum number of license') }} <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Minimum number of license Description: Insert minimum number of license."></i>
                                </label>
                                <input class="primary_input_field" name="min_license_no" placeholder="-" id="addMinLicenseNo"
                                data-toggle="tooltip" title="{{ __('courses.Minimum number of license') }}" type="text" value="{{ old('min_license_no', isset($package) ? ($package->min_license_no == 0 ) ? "N/A" : $package->min_license_no : '') }}">
                                @if ($errors->has('min_license_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('min_license_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('courses.Maximum number of license') }} <i
                                        class="fas fa-info-circle" data-toggle="tooltip"
                                        title="• Maximum number of license Description: Insert maximum number of license."></i>
                                </label>
                                <input class="primary_input_field" name="max_license_no" placeholder="-" id="addMaxLicenseNo"
                                    data-toggle="tooltip" title="{{ __('courses.Maximum number of license') }}" type="text"
                                    value="{{ old('max_license_no', isset($package) ? $package->max_license_no : '') }}">
                                @if ($errors->has('max_license_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('max_license_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('courses.Package') }}
                                    {{ __('courses.Description') }} * <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="•	Package Description: A summary of the significant learning experiences for the package."></i>
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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('courses.Package') }}
                                    {{ __('courses.Overview') }} * <i class="fas fa-info-circle" data-toggle="tooltip"
                                        title="•	Package Overview: A summary of the significant learning experiences for the package."></i>
                                </label>
                                <textarea class="lms_summernote tooltip_class" name="overview" data-toggle="tooltip"
                                    title="{{ __('courses.Overview') }}" cols="30" rows="10">{{ old('overview', isset($package) ? $package->overview : '') }}</textarea>
                                @if ($errors->has('overview'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('overview') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-20">
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
                                        value="{{ isset($package) && !empty($package->image) ? showPicName($package->image) : '' }}" name="image_field">
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
                    <div class="row">
                        <div class="col-xl-12">
                            <label class="primary_checkbox d-flex mr-12" for="checkbox" style="margin-bottom: 40px; width: 100%;">
                                @php
                                    $checked = (old('terms') == 'on' || isset($package)) ? 'checked' : '';
                                @endphp

                                <input name="terms" type="checkbox" id="checkbox" {{ $checked }}>
                                <span class="checkmark mr-2"></span>
                                {{-- <p style="line-height: 18px;">I have read and agree to the <a href="{{ route('frontPage', 'terms-of-use') }}" target="_blank">e-LATiH Terms of Use</a>.</p> --}}
                                <p style="line-height: 18px;">I hereby declare that all of the above information is correct, accurate and not plagiarized from any party.</p>
                            </label>
                        </div>
                    </div>


                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="save_package">
                                <span class="ti-check"></span>
                                {{ __('common.Save') }} {{ __('courses.Package') }}
                                <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="save_loading_spinner"></i>
                            </button>

                            {{-- @if (isset($package) && $package->status == 1)
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="unpublish_package">
                                    <span class="ti-check"></span>
                                    {{ __('common.UnPublish') }} {{ __('courses.Package') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="unpublish_loading_spinner"></i>
                                </button>
                            @else
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="publish_package">
                                    <span class="ti-check"></span>
                                    {{ __('common.Submit') }} {{ __('courses.Package') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="publish_loading_spinner"></i>
                                </button>
                            @endif --}}

                            @if(isset($package) && !(check_whether_cp_or_not() || isPartner()))
                            {{-- @isset($package) --}}
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="update_package">
                                    <span class="ti-check"></span>
                                    {{ __('Update') }} {{ __('courses.Package') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="update_loading_spinner"></i>
                                </button>
                            {{-- @endisset --}}
                            @else
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" id="publish_package">
                                    <span class="ti-check"></span>
                                    {{ __('common.Submit') }} {{ __('courses.Package') }}
                                    <i class="d-none fa fa-lg fas fa-spinner fa-spin" id="publish_loading_spinner"></i>
                                </button>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

<div class="modal fade admin-query" id="confirm-unpublish">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.UnPublish') }} {{ __('courses.Package') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">{{ __('courses.Are you sure to UnPublish Package ?') }}</h3>

                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{ __('common.Cancel') }}</button>
                        <a id="btn_unpublish" class="primary-btn semi_large2 fix-gr-bg">{{ __('common.UnPublish') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

        $("#category_ids").select2({
            allowClear: true,
            ajax: {
                url: "{{ route('get_categories') }}",
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

        $("#package_courses").select2({
            allowClear: true,
            ajax: {
                url: "{{ route('course_data_with_ajax_select2') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        category_ids: $('#category_ids').val()
                    }
                },
                cache: true
            }
        });

        $(document).on('click', '#save_package', function() {
            $('#publish_package').prop('disabled', true);
            var addMinLicenseNoVal = $('#addMinLicenseNo').val();
            if(addMinLicenseNoVal == "N/A"){
                $('#addMinLicenseNo').val(0);
            }
            loaderstart('save_package', 'save_loading_spinner');
            $('#status').val(0);
            $('#addPackageForm').submit();
        });

        $(document).on('click', '#publish_package', function() {
            $('#save_package').prop('disabled', true);
            loaderstart('publish_package', 'publish_loading_spinner');
            $('#status').val(2);
            $('#addPackageForm').submit();
        });

        $(document).on('click', '#update_package', function() {
            $('#save_package').prop('disabled', true);
            loaderstart('update_package', 'update_loading_spinner');
            $('#status').val('');
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

        $(document).on('change', '.upload_method', function() {
            let upload_method = $(this).val();

            if (upload_method == 1) {
                $('#div_course_dropdown').hide();
                $('#div_course_count').show();
                $('#div_course_url').show();
            } else {
                $('#div_course_url').hide();
                $('#div_course_count').hide();
                $('#div_course_dropdown').show();
            }
        });

        function loaderstart(button, spinner) {
            $('#' + button).prop('disabled', true);
            $('#' + spinner).removeClass('d-none');
        }
    </script>
@endpush

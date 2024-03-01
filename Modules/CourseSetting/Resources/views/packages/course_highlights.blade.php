@extends('backend.master')
@push('styles')
    <link href="{{asset('backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
    <style>
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
            color: #333;
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
            color: #444;
            line-height: 40px;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e7edfb!important;
            border-radius: 30px!important;
        }
        .select2-selection__choice {
            background-color: #87CEEB!important;
            width: -moz-fit-content;
            width: fit-content;
        }

        .select2-selection__clear {
            visibility: hidden;
        }
        .add_option_box{
            font-family: sans-serif;
        }

        .loading-spinner {
            display: none;
        }

        .loading-spinner.active {
            display: inline-block;
        }
            .dd {
                position: relative;
                display: block;
                margin: 0;
                padding: 0;
                max-width: 100%;
                list-style: none;
                font-size: 13px;
                line-height: 20px;
            }

            .dd-list {
                display: block;
                position: relative;
                margin: 0;
                padding: 0;
                list-style: none;
            }


            .dd-list .dd-list {
                padding-left: 30px;
            }


            .dd-collapsed .dd-list {
                display: none;
            }


            .dd-item,
            .dd-empty,
            .dd-placeholder {
                display: block;
                position: relative;
                margin: 0;
                padding: 0;
                min-height: 20px;
                font-size: 13px;
                line-height: 20px;
                margin-bottom: 5px;
            }


            .item_header {
                display: block;
                margin: 0px;
                text-decoration: none;
                border: 1px solid #ebebeb;
                background: rgba(0, 0, 0, .03);
                -webkit-border-radius: 3px;
                border-radius: 0px;
                background: #F5F7FB;
                padding: 2px 10px;
                border: 0;
                height: 50px;
                line-height: 46px;
                font-size: 14px;
                font-weight: 400;
                color: #415094;
                padding-left: 30px;
            }


            .dd-item > button {
                display: none;
                position: relative;
                cursor: pointer;
                float: left;
                width: 60px;
                height: 46px;
                padding: 0;
                text-indent: 100%;
                white-space: nowrap;
                overflow: hidden;
                border: 0;
                background: transparent;
                font-size: 12px;
                line-height: 1;
                text-align: center;
                font-weight: bold;
                line-height: 46px;
                margin-left: 0px;
                z-index: 99;
                width: 38px;
            }


            .dd-item > button:before {
                content: "\e61a";
                position: absolute;
                left: 0;
                top: 0;
                font-family: 'themify';
                font-size: 14px;
                color: #415094;
                top: 0px;
                left: 0px;
                font-size: 14px;
            }


            .dd-placeholder,
            .dd-empty {
                margin: 5px 0;
                padding: 0;
                min-height: 46px;
                background: #f2fbff;
                border: 1px dashed #415094;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                border-radius: 10px;
            }


            .dd-empty {
                border: 1px dashed #415094;
                min-height: 100px;
                background-color: #e5e5e5;
                background-size: 60px 60px;
                background-position: 0 0, 30px 30px;
            }


            @media only screen and (min-width: 700px) {

                .dd + .dd , .dd_1 + .dd_1 {
                    margin-left: 2%;
                }
            }

            .btn_zindex {
                z-index: 1000;
            }

            .btn_div {
                margin-top: -43px;
                max-height: 10px;
            }


            .card-header {
                padding: 5px;
            }

            .card {
                margin-top: 5px;
            }

            .button {
                border: none;
                color: white;
                padding: 10px 14px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                margin-right: 0!important;
                border-radius: 50%;
                height: 40px;
                width: 40px;
                line-height:22px!important;
            }
    </style>
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")
    @php
        $currentTheme=currentTheme();
    @endphp
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('courses.Course Highlights')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('courses.Packages')}}</a>
                    <a class="active" href="{{ route('getAllCourseHighlights') }}">{{__('courses.Course Highlights')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="col-md-12 ">
                            <div class="row mb-30">
                                @if (isPartner() || check_whether_cp_or_not()) 
                                <div class="col-xl-6 mb-25">
                                    <div class="row">
                                        <form enctype="multipart/form-data">
                                            <div class="row">
                                                <input type="hidden" name="id" class="id"
                                                    value="">
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <img class="imagePreview"
                                                                style="max-width: 100%"
                                                                src=""
                                                                alt="">
                                                        </div> 
                                                    </div>
                                                    <div class="col-xl-8">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                for="">{{ __('courses.Thumbnail Image') }}
                                                                <small>({{__('common.Recommended Size')}} 167X91) 
                                                                </small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input class="primary-input  filePlaceholder {{ @$errors->has('thumbnail_file') ? ' is-invalid' : '' }}" type="text" id="" 
                                                                        placeholder="Browse file" 
                                                                        readonly="" {{ $errors->has('thumbnail_file' ) ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                            for="thumbnail_file">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                        class="d-none fileUpload imgInput1"
                                                                        name="thumbnail_file" id="thumbnail_file">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                for="">Course Title
                                                            </label>
                                                            <input class="primary_input_field"
                                                                placeholder="Course Title"
                                                                type="text" name="course_title"
                                                                {{ $errors->first('course_title') ? ' autofocus' : '' }}
                                                                value="" maxlength="30" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                for="">Description
                                                            </label>
                                                            <input class="primary_input_field"
                                                                placeholder="Description"
                                                                type="text" name="description"
                                                                {{ $errors->first('description') ? ' autofocus' : '' }}
                                                                value="" maxlength="30" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="package_select_input">Package</label>
                                                            <select name="package_select_input" id="package_select_input" class="select2 mb-15" required>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="button"
                                                                    class="primary-btn fix-gr-bg mt-3" id="add_course_highlight_btn">
                                                            <span class="ti-plus"></span>
                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i> 
                                                                ADD COURSE HIGHLIGHT
                                                            </button>
                                                        </div>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="col-xl-6" id="course_highlights_list">
                                    <div class="col-xl-12 mb-25">
                                    @if (!isPartner() && !check_whether_cp_or_not()) 
                                        @if(!empty($group_course_highlights) && count($group_course_highlights)>0)
                                            @foreach($group_course_highlights as $key => $course_highlights)
                                            <?php $user = \App\User::find($key); ?>
                                            <br><label>{{ $user->name }} </label>
                                            <div class="card"> 
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div id="accordion" class="dd course_highlights_dd">
                                                                <ol class="dd-list">
                                                                    @foreach($course_highlights as $course_highlight)
                                                                        <?php 
                                                                        $package = \Modules\CourseSetting\Entities\Package::find($course_highlight->package_id);
                                                                        ?>
                                                                        <li class="dd-item" data-id="{{ $course_highlight->id }}">
                                                                            <div class="card accordion_card" id="accordion_{{$course_highlight->id}}">
                                                                                <div class="card-header " id="heading_{{$course_highlight->id}}">
                                                                                    <div class="item_header">
                                                                                        <div class="float-left">
                                                                                        {{ $package->name }} - {{ $course_highlight->course_title }}
                                                                                        </div>
                                                                                    </div>
                                                                                    {{-- <div class="float-right btn_div">
                                                                                        <a href="javascript:void(0);" onclick="elementDelete({{$course_highlight->id}})"
                                                                                            class="primary-btn small fix-gr-bg text-center button">
                                                                                            <i class="ti-close"></i>
                                                                                        </a>
                                                                                    </div> --}}
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="card d-none">
                                            </div>
                                        @endif
                                    @else
                                        @if(!empty($course_highlights) && count($course_highlights)>0)
                                            <div class="card"> 
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div id="accordion" class="dd course_highlights_dd">
                                                                <ol class="dd-list">
                                                                    @foreach($course_highlights as $course_highlight)
                                                                        <?php
                                                                        $package = \Modules\CourseSetting\Entities\Package::find($course_highlight->package_id);
                                                                        ?>
                                                                        <li class="dd-item" data-id="{{ $course_highlight->id }}">
                                                                            <div class="card accordion_card" id="accordion_{{$course_highlight->id}}">
                                                                                <div class="card-header " id="heading_{{$course_highlight->id}}">
                                                                                    <div class="item_header">
                                                                                        <div class="float-left">
                                                                                        {{ $package->name }} - {{ $course_highlight->course_title }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-right btn_div">
                                                                                        <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                                                                            data-target="#collapse_{{$course_highlight->id}}" aria-expanded="false"
                                                                                            aria-controls="collapse_{{$course_highlight->id}}"
                                                                                            class="primary-btn small fix-gr-bg text-center button panel-title">
                                                                                            <i class="ti-settings settingBtn"></i>
                                                                                            <span class="collapge_arrow_normal"></span>
                                                                                        </a>
                                                                                        <a href="javascript:void(0);" onclick="elementDelete({{$course_highlight->id}})"
                                                                                            class="primary-btn small fix-gr-bg text-center button">
                                                                                            <i class="ti-close"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div id="collapse_{{$course_highlight->id}}" class="collapse"
                                                                                aria-labelledby="heading_{{$course_highlight->id}}"
                                                                                data-parent="#accordion_{{$course_highlight->id}}">
                                                                                    <div class="card-body">
                                                                                        <form enctype="multipart/form-data" class="elementEditForm">
                                                                                            <div class="row">
                                                                                                <input type="hidden" name="id" class="id"
                                                                                                    value="{{$course_highlight->id}}">
                                                                                                    <div class="col-xl-4">
                                                                                                        <div class="primary_input mb-25">
                                                                                                            <img class="imagePreview_{{ $course_highlight->id }}"
                                                                                                                style="max-width: 100%"
                                                                                                                src="{{ file_exists($course_highlight->thumbnail) ? asset('/'.$course_highlight->thumbnail) : '' }}"
                                                                                                                alt="">
                                                                                                        </div> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-8">
                                                                                                        <div class="primary_input mb-25">
                                                                                                            <label class="primary_input_label"
                                                                                                                for="">{{ __('courses.Thumbnail Image') }}
                                                                                                                <small>({{__('common.Recommended Size')}} 167X91) 
                                                                                                                </small>
                                                                                                            </label>
                                                                                                            <div class="primary_file_uploader">
                                                                                                                <input class="primary-input  filePlaceholder {{ @$errors->has('thumbnail_file_' . $course_highlight->id ) ? ' is-invalid' : '' }}" type="text" id="" 
                                                                                                                        placeholder="Browse file" 
                                                                                                                        readonly="" {{ $errors->has('thumbnail_file_' . $course_highlight->id ) ? ' autofocus' : '' }}>
                                                                                                                <button class="" type="button">
                                                                                                                    <label class="primary-btn small fix-gr-bg"
                                                                                                                            for="thumbnail_file_{{ $course_highlight->id }}">{{ __('common.Browse') }}</label>
                                                                                                                    <input type="file"
                                                                                                                        class="d-none fileUpload imgInput2"
                                                                                                                        name="thumbnail_file_{{ $course_highlight->id }}" id="thumbnail_file_{{ $course_highlight->id }}">
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="col-xl-12">
                                                                                                        <div class="primary_input mb-25">
                                                                                                            <label class="primary_input_label"
                                                                                                                for="">Course Title
                                                                                                            </label>
                                                                                                            <input class="primary_input_field"
                                                                                                                placeholder="Course Title"
                                                                                                                type="text" name="course_title"
                                                                                                                {{ $errors->first('course_title') ? ' autofocus' : '' }}
                                                                                                                value="{{isset($course_highlight->course_title)? $course_highlight->course_title : ''}}" maxlength="30">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12">
                                                                                                        <div class="primary_input mb-25">
                                                                                                            <label class="primary_input_label"
                                                                                                                for="">Description
                                                                                                            </label>
                                                                                                            <input class="primary_input_field"
                                                                                                                placeholder="Description"
                                                                                                                type="text" name="description"
                                                                                                                {{ $errors->first('description') ? ' autofocus' : '' }}
                                                                                                                value="{{isset($course_highlight->description)? $course_highlight->description : ''}}" maxlength="30">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12">
                                                                                                        <div class="primary_input mb-25">
                                                                                                            <label class="primary_input_label" for="package_select_input">Package</label>
                                                                                                            <select name="package_select_input" class="primary_select package_select_input" required>
                                                                                                                @foreach($packages as $package)
                                                                                                                    <option
                                                                                                                        value="{{$package->id}}" {{$course_highlight->package_id == $package->id ? 'selected':''}}>
                                                                                                                        {{$package->name}}
                                                                                                                    </option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="col-lg-12 text-center">
                                                                                                        <div class="d-flex justify-content-center pt_20">
                                                                                                            <button type="button"
                                                                                                                    class="editBtn_{{ $course_highlight->id  }} primary-btn fix-gr-bg"><i
                                                                                                                        class="ti-check"></i>
                                                                                                                {{ __('update') }}
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card d-none">
                                            </div>
                                        @endif
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Course Element Module -->
    <div class="modal fade admin-query" id="deleteItem">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('common.Delete') Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.Are you sure to delete ?')</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">@lang('common.Cancel')</button>
                        <input type="hidden" name="id" id="item-delete" value="">
                        <a class="primary-btn fix-gr-bg" id="delete_course_highlight_item" href="">@lang('common.Delete')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{asset('backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
    <script>

        function readURLCourseThumbnail(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURLCourseThumbnail(this);
        });

        function readURLCourseThumbnail1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    imgId = '.imagePreview_'+$(input).attr('id');
                    $(imgId).attr('src', e.target.result);
                    console.log(input);
                    console.log($(input).attr('id'));
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("input[id^=thumbnail_file_]").change(function () {
            readURLCourseThumbnail1(this);
        });

        $(document).ready(function() {
            $('#package_select_input').select2({
                width: "100%",
                placeholder: "Select Package",
                allowClear: true,
                ajax: {
                    url: "{{  route('packages_which_not_added_with_ajax') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1 ,     
                        }
                    },
                    cache: true
                }
            });
        });

        function loaderstop() {
            $('#add_course_highlight_btn').prop('disabled', false);
            $('.loading-spinner').removeClass('active');
            $('.ti-plus').show();
        }
        function loaderstart() {
            $('#add_course_highlight_btn').prop('disabled', true);
            $('.loading-spinner').addClass('active');
            $('.ti-plus').hide();
        }
        function blankSelectionInputValue() {
            $('#package_select_input').val('').trigger('change');
        }
        function reloadWithData(response) {
            $('#course_highlights_list').empty();
            $('#course_highlights_list').html(response);
        }

        $('#add_course_highlight_btn').on('click', function (event) {
            
            let url = "{{ route('addCourseHighlights') }}";
            let thumbnail = $(this).closest("form").find("input[id=thumbnail_file]")[0].files;
            let course_title = $(this).closest("form").find("input[name=course_title]").val();
            let description = $(this).closest("form").find("input[name=description]").val();
            let package_id = $('#package_select_input').val();

            let fd = new FormData();
                fd.append('thumbnail', thumbnail.length > 0  ? thumbnail[0] : '');
                fd.append('_token', "{{ csrf_token() }}");
                fd.append('package_id', package_id);
                fd.append('course_title', course_title);
                fd.append('description', description);
            
            let courseHighlightItems = $('.course_highlights_dd > ol').children('li').length;

                if (courseHighlightItems >= 5) {
                    event.preventDefault();
                    toastr.error('The maximum length for this list is 5 items.', 'Failed');
                } else {
                    loaderstart();
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            if (response.success == true) {
                                loaderstop();
                                toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                                location.reload();
                            } else {
                                loaderstop();
                                toastr.error("Operation failed", "Error", { timeOut: 5000, });
                                toastr.error(response.message);
                                location.reload();
                            }
                        },
                    });
                }
        });

        $(document).on('click', "button[class^='editBtn_']", function (event) {
            let url = "{{ route('editCourseHighlights') }}";
            let id = $(this).closest("form").find('.id').val();
            let thumbnail = $(this).closest("form").find("input[id^=thumbnail_file_]")[0].files;
            let course_title = $(this).closest("form").find("input[name=course_title]").val();
            let description = $(this).closest("form").find("input[name=description]").val();
            let package_id = $('.package_select_input').val();

            let fd = new FormData();
                fd.append('thumbnail', thumbnail.length > 0  ? thumbnail[0] : '');
                fd.append('_token', "{{ csrf_token() }}");
                fd.append('package_id', package_id);
                fd.append('course_title', course_title);
                fd.append('description', description);
                fd.append('id', id);
                
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            if (response.success == true) {
                                toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                                location.reload();
                            } else {
                                toastr.error("Operation failed", "Error", { timeOut: 5000, });
                                location.reload();
                            }
                        },
                    });
            });

        function elementDelete(id) {
            $('#deleteItem').modal('show');
            $('#item-delete').val(id);
        }

        $(document).on('click', '#delete_course_highlight_item', function (event) {
        event.preventDefault();
        let url = "{{ route('deleteCourseHighlights') }}";
        $('#deleteItem').modal('hide');
        let id = $('#item-delete').val();
        let data = {
            'id': id,
            '_token': '{{ csrf_token() }}',
        }
        
        $.post(url, data,
            function (response) {
                console.log(response);
                if (response.success == true)
                {
                    toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                    location.reload();
                } else {
                    toastr.error("Operation failed", "Error", { timeOut: 5000, });
                }
                
            });
    });
        
    </script>
@endpush

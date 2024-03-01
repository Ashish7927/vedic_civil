@extends('backend.master')
@push('styles')
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
    </style>
    <style type="text/css">
        .loading-spinner, .add-loading-spinner {
            display: none;
        }

        .loading-spinner.active, .add-loading-spinner.active {
            display: inline-block;
        }
        .select2-selection__choice {
            background-color: #87CEEB!important;
            width: -moz-fit-content;
            width: fit-content;
        }
    </style>
@endpush
@php
    $table_name='courses';
@endphp
@section('table'){{$table_name}}@stop
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                {{-- <h1>{{__('common.Add New')}} {{__('courses.Course')}}</h1> --}}
                <h1>{{__('courses.Course')}} {{__('common.Details')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('courses.Courses')}}</a>
                    <a href="#">{{__('common.Add New')}} {{__('courses.Course')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="white_box mb_30">
        <a class="primary-btn small fix-gr-bg" target="_blank" href="../../../public/elatih_premium_guide_cp.pdf">{{__('courses.Course')}} {{__('courses.creation guide')}}</a><br><br>
            {{-- <div class="white_box_tittle list_header">

                <h4>{{__('common.Add New')}} {{__('courses.Course')}}</h4>
            </div> --}}
            <div class="col-lg-12">


                <input type="hidden" id="url" value="{{url('/')}}">

                <form action="{{route('AdminSaveCourse')}}" method="POST" enctype="multipart/form-data" id="addCourseForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="type1" name="type" value="1" @if(empty(old('type')))checked @else {{old('type')==1?"checked":""}} @endif>
                        {{-- <div class="col-xl-6 ">
                            <div class="primary_input ">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label class="primary_input_label"
                                               for="" > {{__('Type')}} * </label>
                                    </div>
                                    <div class="col-md-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" id="type1"
                                                   name="type"
                                                   value="1"

                                                   @if(empty(old('type')))checked @else {{old('type')==1?"checked":""}} @endif>
                                            <span data-toggle="tooltip"
                                                title="1" class="checkmark mr-2"></span>{{__('courses.Course')}}
                                        </label>
                                    </div> --}}
                                    <!-- <div class="col-md-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" id="type2"
                                                   name="type"
                                                   value="2" {{old('type')==2?"checked":""}}>
                                            <span data-toggle="tooltip"
                                                title="2" class="checkmark mr-2"></span> {{__('quiz.Quiz')}}</label>
                                    </div> -->
                                {{-- </div>
                            </div>
                        </div> --}}
                        @if(check_whether_cp_or_not())
                        <input type="hidden" class=" drip1" id="drip1" name="drip" value="1" {{1==old('drip')?'checked':''}}>
                        @else
                       <!--  <div class="col-xl-6 " id="dripCheck">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label mt-1"
                                       for=""> {{__('common.Drip Content')}}</label>
                                <div class="row">
                                    <div class="col-md-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="drip0"
                                                   id="drip0" name="drip"
                                                   value="0" {{0==old('drip')?'checked':(old('drip') == ''?'checked':'')}}>
                                            <span  data-toggle="tooltip"
                                                title="0" class="checkmark mr-2"></span> {{__('common.No')}}
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-25  ">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class=" drip1"
                                                   id="drip1" name="drip"
                                                   value="1"
                                                   {{1==old('drip')?'checked':''}}>
                                            <span  data-toggle="tooltip"
                                                title="1" class="checkmark mr-2"></span> {{__('common.Yes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        @endif
                        <div
                            class=" @if(\Illuminate\Support\Facades\Auth::user()->role_id==1) col-xl-8 @else col-xl-12  @endif">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Course')}} {{__('common.Title')}} * <i class="fas fa-info-circle" data-toggle="tooltip" title="• Title
                                       Description: The course title should be a brief, general statement of the subject matter and reflect the course content. The course title should not exceed 100 characters, including spaces.
                                       "></i>
                                    </label>
                                <input class="primary_input_field" name="title" placeholder="-"
                                       id="addTitle" data-toggle="tooltip" title="{{__('common.Title')}}"
                                       type="text" {{$errors->has('title') ? 'autofocus' : ''}}
                                       value="{{old('title')}}">
                            </div>
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="assign_instructor">{{__('courses.Assign Instructor')}} </label>
                                    <select class="primary_select category_id" name="assign_instructor"
                                    title="{{__('courses.Assign Instructor')}}"
                                    id="assign_instructor" {{$errors->has('assign_instructor') ? 'autofocus' : ''}}>
                                        <option title="" data-display="{{__('common.Select')}} {{__('courses.Trainer')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Trainer')}} </option>
                                        @foreach($instructors as $instructor)
                                            <option title="{{@$instructor->name}}"  {{$instructor->id==old('assign_instructor')?'selected':''}} value="{{$instructor->id}}">{{@$instructor->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        {{-- @if(auth()->user()->role_id==7) --}}
                        {{-- @if(isAdmin()) --}}
                        <div class="col-xl-6 mb-25">
                            <div class="primary_input">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Type')}}</label>
                                {{-- <input class="primary_input_field" name="course_type" placeholder="-"
                                       id="course_type"
                                       type="text" {{$errors->has('course_type') ? 'autofocus' : ''}}
                                       value="{{old('course_type')}}"> --}}
                                <select class="primary_select course_type" name="course_type"
                                    title="{{__('courses.Type')}}"
                                    id="course_type" {{$errors->has('course_type') ? 'autofocus' : ''}}>
                                    <option data-display="{{__('common.Select')}} {{__('courses.Type')}}"
                                            value="0">{{__('common.Select')}} {{__('courses.Type')}} </option>
                                    {{-- <option value="1" {{old('course_type')==1?'selected':''}}>Micro-credential</option> --}}
                                    {{-- <option value="2" {{old('course_type')==2?'selected':''}}>Non-Micro credential</option> --}}
                                    {{-- <option value="3" {{old('course_type')==3?'selected':''}}>Other</option> --}}
                                    <option value="4" {{old('course_type')==4?'selected':''}}>e-learning</option>
                                </select>
                            </div>
                        </div>
                        {{-- @endif --}}

                        <div class="col-xl-6 mb-25">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">Trainer <span>*</span></label>
                                <input class="primary_input_field" name="trainer" data-toggle="tooltip"
                                title="Trainer" placeholder="-" id="trainer" type="text" {{$errors->has('trainer') ? 'autofocus' : ''}} value="{{old('trainer')}}">
                            </div>
                        </div>
                        {{-- @endif --}}

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Course')}} {{__('courses.Requirements')}} * <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course requirements
                                       Description:
                                       Course prerequisite that the learner must have prior enrolling to the course (if any). The course requirement to be stated in standard bullet format.
                                       "></i>
                                </label>
                                <textarea class="lms_summernote_course_details_1 tooltip_class" name="requirements"
                                          id="addRequirements" data-toggle="tooltip"
                                title="{{__('courses.Requirements')}}" cols="30"
                                          rows="10">{{old('requirements')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Course')}} {{__('courses.Description')}} * <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Course Description:
                                       A summary of the significant learning experiences for the course.
                                       "></i>
                                </label>
                                <textarea class="lms_summernote_course_details_2 tooltip_class" name="about" id="addAbout" data-toggle="tooltip"
                                title="{{__('courses.Description')}}" cols="30"
                                          rows="10">{{old('about')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Course')}} {{__('courses.Outcomes')}} * <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course Outcome
                                       Description: Insert your course outcome which the learner will acquire in this course.
                                       "></i>
                                </label>
                                <textarea class="lms_summernote_course_details_3 tooltip_class" name="outcomes" id="addOutcomes"
                                          cols="30" data-toggle="tooltip" title="{{__('courses.Outcomes')}}"
                                          rows="10">{{old('outcomes')}}</textarea>
                            </div>
                        </div>
                    </div>
                    @php
                        if(courseSetting()->show_mode_of_delivery==1){
                            $col_size=4;
                        }else{
                            $col_size=6;

                        }
                    @endphp
                    <div class="row">
                        <div class="col-xl-{{$col_size}} courseBox mb_30">
                            <label class="primary_input_label" for="">{{__('courses.Category')}} *<i class="fas fa-info-circle" data-toggle="tooltip" title="• Skill Area
                                Description: Refer Course Creation Guide for Skill Area.
                                "></i>
                            </label>
                            <select class="primary_select category_id" name="category"
                                    title="{{__('courses.Category')}}"
                                    id="category_id" {{$errors->has('category') ? 'autofocus' : ''}} >
                                <option data-display="{{__('common.Select')}} {{__('courses.Category')}} *"
                                        value="">{{__('common.Select')}} {{__('courses.Category')}} </option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id==old('category')?'selected':''}}>{{@$category->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-xl-{{$col_size}} courseBox mb_30" id="subCategoryDiv">
                            <label class="primary_input_label" for="">{{ __('courses.Sub Category') }}</label>
                            <select class="primary_select" name="sub_category"
                                    title="{{ __('courses.Sub Category') }}"
                                    id="subcategory_id" {{$errors->has('sub_category') ? 'autofocus' : ''}}>
                                <option
                                    data-display="{{ __('common.Select') }} {{ __('courses.Sub Category') }}  "
                                    value="">{{ __('common.Select') }} {{ __('courses.Sub Category') }}
                                </option>
                            </select>
                            <input type="hidden" name="sub_category_id" id="sub_category_id" value="{{ old('sub_category') }}">
                        </div> --}}
                      {{--  @if (courseSetting()->show_mode_of_delivery==1)
                            <div class="col-xl-{{$col_size}}  courseBox mb_30">
                                <label class="primary_input_label" for="">{{ __('courses.Mode of Delivery') }}</label>
                                <select class="primary_select" name="mode_of_delivery"
                                title="{{ __('courses.Mode of Delivery') }}">
                                    <option
                                        data-display="{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}"
                                        value="">{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}</option>
                                    <option value="1" {{1==old('mode_of_delivery')?'selected':(old('mode_of_delivery') == ''?'selected':'')}} selected>{{__('courses.Online')}}</option>
                                     <option value="2" {{2==old('mode_of_delivery')?'selected':''}}>{{__('courses.Distance Learning')}}</option>
                                     <option value="3"{{3==old('mode_of_delivery')?'selected':''}}>{{__('courses.Face-to-Face')}}</option>

                                </select>
                            </div>
                        @endif --}}
                        <div class="col-xl-6 mt-30 quizBox" style="display: none">
                            <label class="primary_input_label" for="">{{__('quiz.Quiz')}}</label>
                            <select class="primary_select" name="quiz" title="{{__('quiz.Quiz')}}"
                                    id="quiz_id" {{$errors->has('quiz') ? 'autofocus' : ''}}>
                                <option data-display="{{__('common.Select')}} {{__('quiz.Quiz')}} *"
                                        value="">{{__('common.Select')}} {{__('quiz.Quiz')}} </option>
                                @foreach($quizzes as $quiz)
                                    <option value="{{$quiz->id}}" {{$quiz->id==old('quiz')?'selected':''}}>{{@$quiz->title}} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-xl-4 makeResize">
                            <label class="primary_input_label" for="">{{ __('courses.Level') }} *</label>
                            <select class="primary_select" name="level" title="{{ __('courses.Level') }}">
                                <option
                                    data-display="{{ __('common.Select') }} {{ __('courses.Level') }} *"
                                    value="">{{ __('common.Select') }} {{ __('courses.Level') }}
                                </option>
                                @foreach($levels as $level)
                                    <option
                                        value="{{$level->id}}" {{old('level')==$level->id?"selected":""}} >{{$level->title}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-xl-4 makeResize" id="">
                            <label class="primary_input_label" for="">{{__('common.Language')}} *</label>
                            <select class="primary_select mb-25" name="language" title="{{ __('common.Language') }}"
                                    id="" {{$errors->has('language') ? 'autofocus' : ''}}>
                                <option
                                    data-display="{{ __('common.Select') }} {{ __('common.Language') }} *"
                                    value="">{{ __('common.Select') }} {{ __('common.Language') }}</option>
                                @foreach ($languages as $language)
                                    <option
                                        value="{{$language->id}}" {{old('language')==$language->id?"selected":""}}>{{$language->native}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 makeResize" id="durationBox">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('common.Duration')}} ({{__('common.In Minute')}}) * <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Duration
                                       Description: Minimum duration should not be less than 30 minutes.
                                       "></i>
                                    </label>
                                <input class="primary_input_field" name="duration" placeholder="-"
                                       id="addDuration" data-toggle="tooltip" title="({{__('common.In Minute')}})"
                                       min="0" step="any" type="number"
                                       value="{{old('duration')}}" {{$errors->has('duration') ? 'autofocus' : ''}}>
                            </div>
                        </div>
                        <div class="col-xl-{{$col_size}} courseBox mb_30">
                            <label class="primary_input_label"
                                   for="">{{__('courses.Skill Area 2')}}</label>
                            <select multiple="multiple" class="category_ids select2-multiple form-control" name="category_ids[]"
                                    title="{{__('courses.Skill Area 2')}}"
                                    id="category_ids" {{$errors->has('category_ids') ? 'autofocus' : ''}} >
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id==old('category')?'selected':''}}>{{@$category->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12 courseBox">
                        <div class="primary_input mb-25">

                            <div class="row pt-2">
                                <div class="col-md-12 mb-25">
                                    <label class="primary_input_label mt-1"
                                           for=""> {{__('common.Complete course sequence')}}</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                        <input type="radio" class="  complete_order0"
                                               id="is_subscription0" name="complete_order"
                                               value="0" {{0==old('complete_order')?'checked':(old('complete_order') == ''?'checked':'')}}>
                                        <span data-toggle="tooltip" title="0" class="checkmark mr-2"></span> {{__('common.No')}}</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                    <input type="radio" class="complete_order1"
                                           id="is_subscription1" name="complete_order"
                                           value="1"
                                           {{1==old('complete_order')?'checked':''}}>
                                          <span  data-toggle="tooltip" title="1" class="checkmark mr-2"></span>{{__('common.Yes')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 courseBox">
                        <div class="primary_input mb-25">

                            <div class="row pt-2">
                                <div class="col-md-12 mb-25">
                                    <label class="primary_input_label mt-1"
                                           for=""> {{__('Is Subscription')}}</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                        <input  type="radio" class="  complete_order0"
                                               id="complete_order0" name="is_subscription"
                                               value="0" {{0==old('is_subscription')?'checked':(old('is_subscription') == ''?'checked':'')}}>
                                        <span data-toggle="tooltip" title="0" class="checkmark mr-2"></span> {{__('common.No')}}</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                    <input  type="radio" class="complete_order1"
                                           id="complete_order1" name="is_subscription"
                                           value="1"
                                           {{1==old('is_subscription')?'checked':''}}>
                                          <span  data-toggle="tooltip" title="1" class="checkmark mr-2"></span>{{__('common.Yes')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-12 courseBox">
                        <div class="primary_input mb-25">

                            <div class="row pt-2">
                                <div class="col-md-12 mb-25">
                                    <label class="primary_input_label mt-1"
                                           for=""> Featured Course</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                        <input type="radio" class="  feature0"
                                               id="feature0" name="feature"
                                               value="0" {{0==old('feature')?'checked':(old('feature') == ''?'checked':'')}}>
                                        <span data-toggle="tooltip" title="0" class="checkmark mr-2"></span> {{__('common.No')}}</label>
                                </div>
                                <div class="col-md-3 mb-25">
                                    <label class="primary_checkbox d-flex mr-12">
                                    <input type="radio" class="feature1"
                                           id="feature1" name="feature"
                                           value="1"
                                           {{1==old('feature')?'checked':''}}>
                                          <span  data-toggle="tooltip" title="1" class="checkmark mr-2"></span>{{__('common.Yes')}}</label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row d-none">
                        <div class="col-lg-6 ">
                            <div class="checkbox_wrap d-flex align-items-center ">
                                <label for="course_1" class="switch_toggle mr-2">
                                    <input type="checkbox" id="course_1" data-toggle="tooltip" title="0">
                                    <i class="slider round"></i>
                                </label>
                                <label
                                    class="mb-0">{{ __('courses.This course is a top course') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-20">
                        <div class="col-lg-6 mb-25">
                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                <label for="course_2" class="switch_toggle mr-2">
                                    <input type="checkbox" id="course_2" value="1" name="is_free" data-toggle="tooltip" title="1" {{old('is_free') == '1'?'checked':''}}>
                                    <i class="slider round"></i>
                                </label>
                                <label
                                    class="mb-0">{{ __('courses.This course is a free course') }}</label>
                            </div>
                        </div>

                        <div class="col-xl-6" id="price_div" style="display: {{(old('is_free') != '' && old('is_free') == '1')?'none':'block'}};">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{ __('courses.Price') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="• Price
                                       Description:
                                       Insert course price without RM/MYR. Price is inclusive of SST (if applicable).
                                       "></i>
                                </label>
                                <input class="primary_input_field" name="price" placeholder="-"
                                       id="addPrice" data-toggle="tooltip" title="{{ __('courses.Price') }}"
                                       type="text" value="{{old('price')}}">
                            </div>
                        </div>

                    </div>
                    <div class="row mt-20" id="discountDiv" style="display: {{(old('is_free') != '' && old('is_free') == '1')?'none':'block'}};">
                        <div class="col-lg-6">
                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                <label for="course_3" class="switch_toggle mr-2">
                                    <input type="checkbox" id="course_3" value="1" name="is_discount" data-toggle="tooltip" title="1" {{old('is_discount') == '1'?'checked':''}}>
                                    <i class="slider round"></i>
                                </label>
                                <label
                                    class="mb-0">{{ __('courses.This course has discounted price') }}</label>
                            </div>
                        </div>
                        <div class="row" id="discount_price_div" style="display: {{(old('is_discount') != '' && old('is_discount') == '1')?'block':'none'}};">
                            <div class="col-xl-4" >
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                        for="">{{ __('courses.Discount') }} {{ __('courses.Price') }}</label>
                                    <input class="primary_input_field" name="discount_price" placeholder="-"
                                        id="addDiscount"  data-toggle="tooltip" title="{{ __('courses.Price') }}"
                                        type="text" value="{{old('discount_price')}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="startDate">{{ __('courses.Discount') }} {{ __('courses.Start Date') }}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field" type="date" name="discount_start_date" id="discount_start_date" min="{{ now()->toDateString('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="startDate">{{ __('courses.Discount') }} {{ __('courses.End Date') }}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input class="primary_input_field" type="date" name="discount_end_date" id="discount_end_date" min="{{ now()->toDateString('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-20 mb-10 videoOption">
                        <div class="col-lg-6">
                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                <label for="show_overview_media" class="switch_toggle mr-2">
                                    <input type="checkbox" id="show_overview_media" value="1"
                                           name="show_overview_media" data-toggle="tooltip" title="1"
                                           {{old('show_overview_media') == '1'?'checked':''}}>
                                    <i class="slider round"></i>
                                </label>
                                <label
                                    class="mb-0">{{ __('courses.Show Overview Video') }}</label>
                            </div>
                        </div>
                    </div>

                    <?php
                        /*if(old('vdocipher')){
                            dd( old('vdocipher') );
                        }*/
                    ?>
                    <div class="row mt-20 videoOption" id="overview_host_section" style="display: {{(old('show_overview_media') == '' && old('show_overview_media') != '1')?'none':''}};">
                        <div class="col-xl-4 mt-25">
                            <select class="primary_select category_id " name="host"
                            title="{{__('courses.Course overview host')}}"
                                    id="" >
                                <option
                                    data-display="{{__('courses.Course overview host')}} *"
                                    value="">{{__('courses.Course overview host')}}
                                </option>
                              {{--  <option data-display="{{__('courses.Image Preview')}}"
                                        value="ImagePreview" {{(@$course->host=="ImagePreview" || old('host')=="ImagePreview")?'selected':''}}>{{__('courses.Image Preview')}}
                                </option> --}}

                                {{-- <option {{(@$course->host=="Youtube" || old('host')=="Youtube" )?'selected':''}} value="Youtube">
                                    {{__('courses.Youtube')}}
                                </option> --}}
                              {{--  <option value="VdoCipher" {{(@$course->host=="VdoCipher" || old('host')=="VdoCipher")?'selected':''}}>
                                    VdoCipher
                                </option> --}}

                                <option value="Vimeo" {{(@$course->host=="Vimeo" || old('host')=="Vimeo")?'selected':''}}>
                                    {{__('courses.Vimeo')}}
                                </option>
                                @if(isModuleActive("AmazonS3"))
                                    <option
                                        value="AmazonS3" {{( @$course->host=="AmazonS3" || old('host')=="AmazonS3")?'selected':''}}>
                                        {{__('courses.Amazon S3')}}
                                    </option>
                                @endif

                                <option value="Self" {{(@$course->host=="Self" || old('host')=="Self")?'selected':''}}>
                                    {{__('courses.Self')}}
                                </option>


                            </select>
                        </div>
                        <div class="col-xl-8" >
                            @if(old('host') == "Youtube")
                                <div class="input-effect videoUrl">
                            @else
                                <div class="input-effect videoUrl"
                                     style="display:@if((isset($course) && (@$course->host!="Youtube")) || !isset($course)) none  @endif">
                            @endif
                                <label>{{__('courses.Video URL')}}
                                    <span>*</span></label>
                                <input
                                    id=""
                                    class="primary_input_field youtubeVideo name{{ $errors->has('trailer_link') ? ' is-invalid' : '' }}"
                                    type="text" name="trailer_link"
                                    placeholder="{{__('courses.Video URL')}}"
                                    autocomplete="off" data-toggle="tooltip" title="{{__('courses.Video URL')}}"
                                    value="{{old('trailer_link')}}" {{$errors->has('trailer_link') ? 'autofocus' : ''}}>
                                <span class="focus-border"></span>
                                @if ($errors->has('trailer_link'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trailer_link') }}</strong>
                                            </span>
                                @endif
                            </div>

                            @if(old('host') == "Vimeo")
                                <div class="row  vimeoUrl" id="">
                            @else
                                <div class="row  vimeoUrl" id=""
                                 style="display: @if((isset($course) && (@$course->host!="Vimeo")) || !isset($course)) none  @endif">
                            @endif

                                <div class="col-lg-12" id="">
                                    <label class="primary_input_label"
                                           for="">{{__('courses.Vimeo Video')}}</label>


                                    @if(config('vimeo.connections.main.upload_type')=="Direct")
                                        <div class="primary_file_uploader">
                                            <input class="primary-input filePlaceholder" type="text"
                                                   id=""
                                                   {{$errors->has('image') ? 'autofocus' : ''}}
                                                   placeholder="{{__('courses.Browse Video file')}}"
                                                   readonly="" data-toggle="tooltip" title="{{__('courses.Vimeo Video')}}">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="document_file_thumb_vimeo_add">{{__('common.Browse') }}</label>
                                                <input type="file" class="d-none fileUpload" name="vimeo"
                                                       id="document_file_thumb_vimeo_add">
                                            </button>
                                        </div>
                                    @else
                                        <select class="primary_select vimeoVideo"
                                                title="{{__('courses.Video')}}"
                                                name="vimeo"
                                                id="" >
                                            <option
                                                data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Video')}}
                                            </option>
                                            @foreach ($video_list as $video)
                                                @if(isset($course))
                                                    <option
                                                        value="{{@$video['uri']}}" {{$video['uri']==$course->trailer_link?'selected':''}}>{{@$video['name']}}</option>
                                                @else
                                                    <option
                                                        value="{{@$video['uri']}}"  {{@$video['uri']==old('vimeo')?'selected':''}}>{{@$video['name']}}</option>
                                                @endif


                                            @endforeach
                                        </select>
                                    @endif
                                    @if ($errors->has('vimeo'))
                                        <span
                                            class="invalid-feedback invalid-select"
                                            role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if(old('host') == "VdoCipher")
                                <div class="row VdoCipherUrl">
                            @else
                                 <div class="row VdoCipherUrl"
                                 style="display: @if((isset($course) && ($course->trailer_link!="VdoCipher")) || !isset($editLesson) ) none  @endif">
                            @endif


                                <div class="input-effect " id=""
                                >
                                    <div class="" id="">
                                        <label class="primary_input_label"
                                               for="">{{__('courses.VdoCipher Video')}}</label>
                                        <select class="select2 vdocipherList " name="vdocipher"
                                                title="video"
                                                id="VdoCipherVideo">
                                            <option
                                                data-display="{{__('common.Select')}} video "
                                                value="">{{__('common.Select')}} video
                                            </option>
                                            @foreach ($vdocipher_list as $vdo)
                                                @if(isset($editLesson))
                                                    <option
                                                        value="{{@$vdo->id}}" {{$vdo->id==$editLesson->video_url?'selected':''}}>{{@$vdo->title}}</option>
                                                @else
                                                    <option
                                                        value="{{@$vdo->id}}" {{@$vdo->id==old('vdocipher')?'selected':''}}>{{@$vdo->title}}</option>
                                                @endif


                                            @endforeach
                                        </select>
                                        @if ($errors->has('vdocipher'))
                                            <span class="invalid-feedback invalid-select"
                                                  role="alert">
                                               <strong>{{ $errors->first('vdocipher') }}</strong>
                                           </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(old('host') == "Self")
                                <div class="row videofileupload" id="">
                            @else
                                <div class="row  videofileupload" id=""
                                 style="display: @if((isset($course) && ((@$course->host=="Vimeo") ||  (@$course->host=="Youtube")) ) || !isset($course)) none  @endif">
                            @endif


                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label"
                                               for="">{{__('courses.Video File')}}</label>
                                        <div class="primary_file_uploader">
                                            <input type="file" class="filepond" name="file" data-toggle="tooltip" title="{{__('courses.Video File')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                            @if(Auth::user()->role_id != 7)
                                                <div class="row" style="display: none">
                                                    <div class="col-xl-6 mt-20">
                                                        <label>{{__('courses.View Scope')}} </label>
                                                        <select class="primary_select " name="scope"
                                                                id=""
                                                                data-toggle="tooltip"
                                                                title="{{__('courses.Public')}}">
                                                            <option
                                                                value="1" {{@$course->scope=="1"?'selected':''}}>{{__('courses.Public')}}
                                                            </option>

                                                            <option
                                                                {{@$course->scope=="0"?'selected':''}} value="0">
                                                                {{__('courses.Private')}}
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row" style="display: none">
                                                    <div class="col-xl-6 mt-20">
                                                        <label>{{__('courses.View Scope')}} </label>
                                                        <select class="primary_select " name="scope"
                                                                id=""
                                                                data-toggle="tooltip"
                                                                title="{{__('courses.Public')}}">
                                                            <option
                                                                value="1" selected>{{__('courses.Public')}}
                                                            </option>

                                                            <option
                                                                {{@$course->scope=="0"?'selected':''}} value="0">
                                                                {{__('courses.Private')}}
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                    <div class="row mt-20">
                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Course Thumbnail') }}
                                    ({{__('common.Max Image Size 5MB')}}) (Recommend size: 1170x600) * <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course thumbnail
                                    Description: The maximum image size is 5mb. The recommended size: 1170x600 pixels and file format must be in .jpg.
                                    "></i>
                                </label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder" type="text"
                                           id=""
                                           {{$errors->has('image') ? 'autofocus' : ''}}
                                           placeholder="{{__('courses.Browse Image file')}}"
                                           readonly="" data-toggle="tooltip" title="{{__('courses.Course Thumbnail') }}">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                               for="document_file_thumb_2">{{__('common.Browse') }}</label>
                                        <input type="file" class="d-none fileUpload" name="image"
                                               id="document_file_thumb_2">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">Trainer's Image
                                    (Recommended size: 200x200)</label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder" type="text"
                                           id=""
                                           {{$errors->has('image') ? 'autofocus' : ''}}
                                           placeholder="{{__('courses.Browse Image file')}}"
                                           readonly="" data-toggle="tooltip" title="Trainer's Image">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                               for="trainer_img_1">{{__('common.Browse') }}</label>
                                        <input type="file" class="d-none fileUpload" name="trainer_image"
                                               id="trainer_img_1">
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->subscription_api_status==1)
                            <div class="col-xl-6">
                                <label class="primary_input_label"
                                       for="">{{__('newsletter.Subscription List')}}
                                </label>
                                <select class="primary_select" title="{{__('newsletter.Subscription List')}}"
                                        name="subscription_list" {{$errors->has('subscription_list') ? 'autofocus' : ''}}>
                                    <option
                                        data-display="{{__('common.Select')}} {{__('newsletter.Subscription List')}}"
                                        value="">{{__('common.Select')}} {{__('newsletter.Subscription List')}}

                                    </option>
                                    @foreach($sub_lists as $list)
                                        <option value="{{$list['id']}}" {{$list['id']==old('subscription_list')?'selected':''}}>
                                            {{$list['name']}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        @endif
                    </div>

                    @if(Settings('frontend_active_theme')=="edume")
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('courses.Key Point') }} (1)</label>
                                    <input class="primary_input_field" name="what_learn1" placeholder="-"
                                           type="text" value="{{old('what_learn1')}}" data-toggle="tooltip"
                                           title="{{__('courses.Key Point') }} (1)">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('courses.Key Point') }} (2) </label>
                                    <input class="primary_input_field" name="what_learn2" placeholder="-"
                                           type="text" value="{{old('what_learn2')}}" data-toggle="tooltip"
                                           title="{{__('courses.Key Point') }} (2)">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Meta keywords') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Meta Keywords
                                       Description: Insert a minimum of 5 specific keywords separated with comma that reflects the course.
                                       Eg: Excel, Beginner, Microsoft,
                                       "></i>
                                    </label>
                                <input class="primary_input_field" name="meta_keywords" placeholder="-"
                                       id="addMeta"
                                       type="text" value="{{old('meta_keywords')}}" data-toggle="tooltip"
                                       title="{{__('courses.Meta keywords') }}">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('courses.Meta description') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Meta Description
                                       Description: Meta description is displayed in a search engine result. Insert a brief two-line summary or description of the course.
                                       "></i>
                                    </label>
                                <textarea id="my-textarea" class="primary_input_field tooltip_class" id
                                        data-toggle="tooltip" title="{{__('courses.Meta description') }}" name="meta_description" style="height: 200px"
                                          rows="3">{{old('meta_keywords')}}</textarea>
                            </div>

                        </div>

                    </div>

                    {{-- @if(auth()->user()->role_id==7) --}}
                    <div class="row">
                        <div class="col-xl-12">
                          <!--  <div class="form-group">
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 " style="width: 100%">
                                    <input name="declaration" type="checkbox" {{old('declaration') == 'on'?'checked':''}}>
                                    <span class="checkmark"></span>
                                    <span class="ml-2"><b>I hereby declare that all the above information is correct, accurate and not plagiarized from any party.</b></span>
                                </label>
                            </div> -->
                            @if(Auth::user()->role_id == 7 || isPartner())
                            {{-- <div class="form-group">
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 " style="width: 100%">
                                    <span class="ml-2"><b>This is a familiarization stage for Course Provider to familiar with the platform feature.</b></span>
                                </label>
                            </div> --}}
                            @endif
                        </div>
                    </div>
                    {{-- @endif --}}
                    <input type="hidden" name="status_code" id="statusCode" value="1" />
                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">

                          @if(Auth::user()->role_id == 7 || isPartner())
                              <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg"
                                      id="save_button_parent"
                                      type="button"><i
                                      class="ti-check save_check"></i>
                                      <span class="btn_text">{{__('common.Save') }} {{__('courses.Course') }}</span>
                                      <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                              </button>
                              <!-- <button style="margin-left: 18px;" class="btn btn-secondary semi_large2  fix-gr-bg"
                                      id="add_button_parent"
                                      type="button" disabled><i
                                      class="ti-check add_check"></i>
                                      <span class="btn_text_add" >{{__('common.Add') }} {{__('courses.Course') }}</span>
                                      <i class="add-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                              </button> -->
                          @else
                              <button style="margin-left: 18px;" class="btn primary-btn semi_large2  fix-gr-bg"
                                      id="add_button_parent"
                                      type="button"><i
                                      class="ti-check add_check"></i>
                                      <span class="btn_text_add">{{__('common.Add') }} {{__('courses.Course') }}</span>
                                      <i class="add-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                              </button>
                          @endif

                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section>
    @include('backend.partials.delete_modal')
@endsection
@push('js')
    <script>
        let show_overview_media = $('#show_overview_media');
        let overview_host_section = $('#overview_host_section');
        show_overview_media.change(function () {
            if (show_overview_media.is(':checked')) {
                overview_host_section.show();
            } else {
                overview_host_section.hide();
            }
        });
    </script>
    <script>
        let show_mode_of_delivery = $('#show_mode_of_delivery');
        let mode_of_delivery_options = $('#mode_of_delivery_options');
        show_mode_of_delivery.change(function () {
            if (show_mode_of_delivery.is(':checked')) {
                mode_of_delivery_options.show();
            } else {
                mode_of_delivery_options.hide();
            }
        });
    </script>
@endpush
@push('scripts')

    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>



    <script>
        let vdocipherList = $('.vdocipherList');
        $('[data-toggle="tooltip"]').tooltip();
        vdocipherList.select2({
            ajax: {
                url: '{{route('getAllVdocipherData')}}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        // id: $('#country').find(':selected').val(),
                    }
                    return query;
                },
                cache: false
            }
        });
    </script>


    <script>
        $('.lms_summernote_course_details_1').summernote({
            placeholder: '&#9679 Course Requirements 1<br> &#9679 Course Requirements 2<br> &#9679 Course Requirements 3',
            tabsize: 2,
            height: 150,
                tooltip: true,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files, '.lms_summernote_course_details_1')
                }
            }
        });

        $('.lms_summernote_course_details_2').summernote({
            placeholder: '',
            tabsize: 2,
            height: 150,
            tooltip: true,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files, '.lms_summernote_course_details_2')
                }
            }
        });

        $('.lms_summernote_course_details_3').summernote({
            placeholder: '&#9679 Course outcomes 1<br> &#9679 Course outcomes 2<br> &#9679 Course outcomes 3',
            tabsize: 2,
            height: 150,
            tooltip: true,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files, '.lms_summernote_course_details_3')
                }
            }
        });
    </script>
    <script>
        $('select').each(function(){
            var tooltip_text = $(this).attr('title');
            $(this).next('div').attr('title',tooltip_text)
        });
        $('textarea.tooltip_class').each(function(){
            var tooltip_text = $(this).attr('title');
            $(this).next('div.note-editor').find('.note-editing-area').find('.note-editable').attr('title',tooltip_text)
        });
    </script>
    <script>
        $(document).ready(function(){
            var start_date = $("#discount_start_date").val();
            if(start_date!=""){
                $("#discount_end_date").attr("min", start_date);
            }

            $("#discount_start_date").change(function(){
                $("#discount_end_date").attr("min", $(this).val());
            });

            $("#save_button_parent").click(function(){
                $('#statusCode').attr('value','2');
                // $("#addCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
            $("#add_button_parent").click(function(){
                $('#statusCode').attr('value','1');
                // $("#addCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
        });

        function loaderstop(){
            // $('.btn_text').text('Save Course');
            // $('.save_check').addClass('ti-check');
            $('#save_button_parent').prop('disabled', false);
            $('.loading-spinner').removeClass('active');
        }
        function loaderstart(){
            // $('.btn_text').text('');
            // $('.save_check').removeClass('ti-check');
            $('#save_button_parent').prop('disabled', true);
            $('.loading-spinner').addClass('active');
        }

        function submitloaderstop(){
            // $('.btn_text_add').text('Add Course');
            // $('.add_check').addClass('ti-check');
            $('#add_button_parent').prop('disabled', false);
            $('.add-loading-spinner').removeClass('active');
        }
        function submitloaderstart(){
            // $('.btn_text_add').text('');
            // $('.add_check').removeClass('ti-check');
            $('#add_button_parent').prop('disabled', true);
            $('.add-loading-spinner').addClass('active');
        }

        function ajaxforcoursevalidation() {
            var formData = new FormData(document.getElementById("addCourseForm"));
            var btn = $('#statusCode').val();
            var addPrice = $('#addPrice').val();
            var addDiscount = $('#addDiscount').val();
            if ($('#course_3').is(':checked')) {
                if(addPrice!="" && addDiscount!=""){
                    if(parseInt(addDiscount)>parseInt(addPrice)){
                        toastr.error("The Discount price more that original price!");
                        return false;
                    }
                }
            }

            if(btn == 2)
                loaderstart();
            if(btn == 1)
                submitloaderstart();
            $.ajax({
                type: "POST",
                url: "{{route('AdminSaveCourseValidation')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.status == 0)
                    {
                        if(typeof(data.errors) != "undefined" && data.errors !== null)
                        {
                            $.each(data.errors, function (i, item) {
                                toastr.error(item);
                            })
                        }
                    }
                    if(data.status == 1)
                    {
                        $("#addCourseForm").submit();
                    }
                }
            }).done( function( data ) {
                if(btn == 2)
                    loaderstop();
                if(btn == 1)
                    submitloaderstop();
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                width: "100%",
                placeholder: "Select Skill Area 2:",
                allowClear: true
            });

        });

    </script>
@endpush

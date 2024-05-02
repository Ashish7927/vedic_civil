@extends('backend.master')

@php
    $table_name='courses';
@endphp
@section('table'){{$table_name}}@stop
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/select2_custom.css') }}?{{ $version }}"/>
    <style type="text/css">
        .loading-spinner, .submit-loading-spinner {
            display: none;
        }
        .loading-spinner.active, .submit-loading-spinner.active {
            display: inline-block;
        }
    </style>

@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>Featured {{__('courses.Courses')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('courses.Courses')}}</a>
                    <a href="#">{{__('courses.Courses List')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <input type="hidden" name="role_id" id="current_user_role_id" value="{{ auth()->user()->role_id }}">
                        {{-- action="{{route('courseSortBy')}}" --}}
                        <form method="POST" id="filter_form" action="{{ route('course_list_excel_download') }}">
                            @csrf

                            <input type="hidden" name="previous_route" value="{{ \Route::current()->getName() }}">

                            <div class="row">

                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="category">{{__('courses.Category')}}</label>
                                    <select class="primary_select" name="category" id="category">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->id}}" {{isset($category_search)?$category_search==$category->id?'selected':'':''}}>{{@$category->name}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-lg-3 mt-30 d-none">
                                    <label class="primary_input_label" for="course">{{__('courses.Statistics')}}</label>
                                    <select class="primary_select" name="course" id="course">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Statistics')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Statistics')}}</option>
                                        <option value="statistics">{{__('courses.Statistics')}}</option>
                                        <option value="topSell">Top Sells</option>
                                        <option value="mostReview">Most Review</option>
                                        <option value="mostComment">Most Comment</option>
                                        <option value="topReview">Top Review</option>
                                    </select>

                                </div>
                                @if(\Route::current()->getName() != 'getActiveCourse' && \Route::current()->getName() != 'getPendingCourse')
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="search_status" id="status">

                                        <option
                                            value="1" {{isset($category_status)?$category_status=="1"?'selected':'':''}}>{{__('courses.Active')}} </option>

                                    </select>

                                </div>
                                @endif
                                @if(\Route::current()->getName() == 'getPendingCourse')
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="search_status" id="status">
                                        <option data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                value="">{{__('common.Select')}} {{__('common.Status')}}</option>
                                        <option
                                            value="0" {{isset($category_status)?$category_status=="0"?'selected':'':''}}>{{__('courses.Pending')}} </option>
                                        <option
                                            value="4" {{isset($category_status)?$category_status=="4"?'selected':'':''}}>{{__('courses.Rejected')}} </option>
                                    </select>
                                </div>
                                @endif
                                @if(\Route::current()->getName() == 'getActiveCourse')
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="search_status" id="status">
                                        <option data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                value="">{{__('common.Select')}} {{__('common.Status')}}</option>
                                        <option
                                            value="1" {{isset($category_status)?$category_status=="1"?'selected':'':''}}>{{__('courses.Active')}} </option>
                                        <option
                                            value="3" {{isset($category_status)?$category_status=="3"?'selected':'':''}}>{{__('courses.Approved')}} </option>
                                    </select>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 mt-30">
                                        <label class="primary_input_label" for="from_duration">Min Duration</label>
                                        <input type="text" name="from_duration" id="from_duration"
                                               class="primary_input_field form-control" placeholder="Min Duration"/>
                                    </div>
                                    <div class="col-lg-6 mt-30">
                                        <label class="primary_input_label" for="from_duration">Max Duration</label>
                                        <input type="text" name="to_duration" id="to_duration"
                                               class="primary_input_field form-control" placeholder="Max Duration"/>
                                    </div>
                                </div>

                                @if(check_whether_cp_or_not() || isPartner())

                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="start_price">Start Price</label>
                                    <input type="text" name="start_price" class="primary_input_field" id="start_price">
                                </div>

                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="end_price">End Price</label>
                                    <input type="text" name="end_price" class="primary_input_field" id="end_price">
                                </div>

                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="total_rating">Rating</label>
                                    <!--  <input type="text" name="total_rating" class="primary_input_field" id="total_rating"> -->

                                    <select class="primary_select" name="total_rating" id="total_rating">
                                        <option value="">Select Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Star</option>
                                        <option value="3">3 Star</option>
                                        <option value="4">4 Star</option>
                                        <option value="5">5 Star</option>
                                    </select>
                                </div>
                                @endif

                                @if(Route::current()->getName() == 'getPendingCourse')
                                    <div class="col-lg-3 mt-30">
                                        <label class="primary_input_label" for="fromSubmissionDate">Submission Date From</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="from_submission_date" id="from_submission_date">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-30">
                                        <label class="primary_input_label" for="toSubmissionDate">Submission Date To</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="to_submission_date" id="to_submission_date">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <button type="button" id="apply-filters" class="primary-btn radius_30px mr-10 fix-gr-bg">Filter</button>
                                        <button type="button" id="reset-filters"   class="btn btn-default" style="background:white;color:#1b191f;boder:1 px solid black;" data-dismiss="modal">Reset</button>
                                        {{-- <button type="submit" class="primary-btn radius_30px mr-10 fix-gr-bg">{{__('courses.Filter')}} </button> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- @if(\Route::current()->getName() != 'getActiveCourse' && \Route::current()->getName() != 'getPendingCourse')
                <div class="col-12 mb-30">
                    @if (permissionCheck('course.store'))
                        <ul class="d-flex">
                            <li>
                                <a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('addNewCourse')}}"><i class="ti-plus"></i>{{__('common.Add')}} {{__('courses.Course')}} </a>
                            </li>
                        </ul>
                    @endif
                </div>
                @endif --}}
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$title??""}} {{__('courses.Course')}}
                                 {{__('courses.List')}}</h3>

                            <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_import_table_data" href="javascript:void(0)">
                                Export
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table classList">
                                    <thead>
                                    <tr>
                                        <th scope="col"> {{__('common.SL')}}</th>
                                        {{-- <th scope="col"> {{__('coupons.Type')}}</th> --}}
                                        <th scope="col">{{__('courses.Course')}}
                                            {{__('coupons.Title')}}</th>
                                        <th scope="col">{{__('courses.Category')}}</th>
                                       <!-- <th scope="col">{{__('quiz.Quiz')}}</th> -->
                                        {{-- <th scope="col">{{__('courses.Trainer')}}</th> --}}
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">Featured</th>
                                        <th scope="col">{{__('courses.Lesson')}}</th>
                                        @if(!(isCourseReviewer() && Route::current()->getName() == 'getPendingCourse'))
                                        <th scope="col">{{__('courses.Enrolled')}}</th>
                                        @endif
                                        {{-- <th scope="col">Published Date</th> --}}
                                        <th scope="col">{{__('courses.Price')}}</th>
                                        <th scope="col">{{__('courses.Duration')}} ({{__('frontend.minutes')}})</th>
                                        @if(!(isCourseReviewer()))
                                        <th scope="col">{{__('courses.Rating')}}</th>
                                        @endif
                                        @if(\Route::current()->getName() == 'getActiveCourse' || \Route::current()->getName() == 'getPendingCourse')
                                        <th scope="col">Submission Date</th>
                                        @endif
                                        {{-- @if(\Route::current()->getName() == 'getActiveCourse') --}}
                                        <th scope="col">Published Date</th>
                                        {{-- @endif --}}
                                        <th scope="col">Approval/Rejected Date</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- @dd(\Route::current()->getName()) --}}



                <div class="modal fade admin-query" id="editCourse">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Edit')}} {{__('quiz.Topic')}} </h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('AdminUpdateCourse')}}" method="POST"
                                      enctype="multipart/form-data" id="courseEditForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 ">
                                            <div class="primary_input mb-25">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="primary_input_label"
                                                               for="    "> {{__('courses.Type')}}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio"
                                                               class="common-radio type1"
                                                               id="type_edit_1"
                                                               name="type"
                                                               value="1">
                                                        <label
                                                            for="type_edit_1">{{__('courses.Course')}}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio"
                                                               class="common-radio type2"
                                                               id="type_edit_2"
                                                               name="type"
                                                               value="2">
                                                        <label
                                                            for="type_edit_2">{{__('quiz.Quiz')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-6 dripCheck">
                                            <div class="primary_input mb-25">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="primary_input_label"
                                                               for="    "> {{__('common.Drip Content')}}</label>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <input type="radio"
                                                               class="common-radio drip0"
                                                               id="drip_edit_0"
                                                               name="drip"
                                                               value="0" {{@$course->drip==0?"checked":""}}>
                                                        <label
                                                            for="drip_edit_0">{{__('common.No')}}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio"
                                                               class="common-radio drip1"
                                                               id="drip_edit_1"
                                                               name="drip"
                                                               value="1" {{@$course->drip==1?"checked":""}}>
                                                        <label
                                                            for="drip_edit_1">{{__('common.Yes')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="title">{{__('quiz.Topic')}} {{__('common.Title')}}
                                                    *</label>
                                                <input class="primary_input_field" name="title"
                                                       id="title"
                                                       placeholder="-"
                                                       type="text" {{$errors->has('title') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" class="course_id" id="editCourseId"
                                           value="">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="about">{{__('courses.Course')}} {{__('courses.Requirements')}} </label>
                                                <textarea class="lms_summernote"
                                                          name="requirements"

                                                          id="requirementsEdit" cols="30"
                                                          rows="10"> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="about">{{__('courses.Course')}} {{__('courses.Description')}}</label>
                                                <textarea class="lms_summernote" name="about"

                                                          id="aboutEdit" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="about">{{__('courses.Course')}} {{__('courses.Outcomes')}}  </label>
                                                <textarea class="lms_summernote" name="outcomes"

                                                          id="outcomesEdit" cols="30"
                                                          rows="10"> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xl-6 courseBox">
                                            <select class="primary_select edit_category_id"
                                                    name="category"
                                                {{$errors->has('category') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('quiz.Category')}}"
                                                    value="">{{__('common.Select')}} {{__('quiz.Category')}}
                                                    *
                                                </option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{@$category->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-6 courseBox"
                                             id="edit_subCategoryDiv{{@$course->id}}">
                                            <select class="primary_select " name="sub_category"
                                                    id="edit_subcategory_id" {{$errors->has('sub_category') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('courses.Sub Category')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Sub Category')}}

                                                </option>


                                            </select>
                                        </div>
                                        <div class="col-xl-6 mt-30 quizBox"
                                             style="display: none">
                                            <select class="primary_select" name="quiz"
                                                    id="quiz_edit_id" {{$errors->has('quiz') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('quiz.Quiz')}}"
                                                    value="">{{__('common.Select')}} {{__('quiz.Quiz')}}
                                                    *
                                                </option>
                                                @foreach($quizzes as $quiz)
                                                    <option value="{{$quiz->id}}"
                                                    >{{@$quiz->title}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 mt-30 makeResize">
                                            <select class="primary_select" id="levelEdit"
                                                    name="level" {{$errors->has('level') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('courses.Level')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Level')}}
                                                    *
                                                </option>
                                                @foreach($levels as $level)
                                                    <option value="{{$level->id}}"
                                                    >
                                                        {{$level->title}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-xl-4 mt-30 makeResize" id="">
                                            <select class="primary_select mb_30" name="language"
                                                    id="languageEdit" {{$errors->has('language') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('courses.Language')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Language')}}
                                                    *
                                                </option>

                                                @foreach ($languages as $language)
                                                    <option value="{{$language->id}}"
                                                    >{{$language->native}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-4 makeResize">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Duration')}} ({{__('common.In Minute')}})
                                                    *</label>
                                                <input class="primary_input_field" id="durationEdit"
                                                       name="duration" placeholder="-"

                                                       min="0" step="any" type="number" {{$errors->has('duration') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row d-none">
                                        <div class="col-lg-6">
                                            <div
                                                class="checkbox_wrap d-flex align-items-center">
                                                <label for="course_1" class="switch_toggle">
                                                    <input type="checkbox" id="edit_course_1">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{__('courses.This course is a top course')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-20">
                                        <div class="col-lg-6">
                                            <div
                                                class="checkbox_wrap d-flex align-items-center mt-40">
                                                <label for="editCourseFree"
                                                       class="switch_toggle">
                                                    <input type="checkbox" class="edit_course_2" name="is_free"
                                                           value="1"
                                                           id="editCourseFree"
                                                    >
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{__('courses.This course is a free course')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4"
                                             id="edit_price_div">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Price')}}</label>
                                                <input class="primary_input_field" name="price" id="priceEdit"
                                                       placeholder="-"
                                                       value="" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-20 editDiscountDiv">
                                        <div class="col-lg-6">
                                            <div
                                                class="checkbox_wrap d-flex align-items-center mt-40">
                                                <label for="editCourseDiscount"
                                                       class="switch_toggle">
                                                    <input type="checkbox" class="edit_course_3"
                                                           name="is_discount" value="1"
                                                           id="editCourseDiscount">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{__('courses.This course has discounted price')}}</label>
                                            </div>
                                        </div>

                                        <div class="col-xl-4"
                                             id="edit_discount_price_div" >
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Discount')}} {{__('courses.Price')}}</label>
                                                <input class="primary_input_field editDiscount"
                                                       name="discount_price" id="editDiscountPrice"

                                                       placeholder="-" type="text">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-20 videoOption">
                                        <div class="col-xl-4 mt-25">
                                            <select class="primary_select category_id "
                                                    name="host"
                                                    id="editCourseHost">
                                                <option
                                                    data-display="{{__('courses.Course overview host')}} *"
                                                    value="">{{__('courses.Course overview host')}}
                                                </option>

                                                {{-- <option value="Youtube"
                                                >
                                                    {{__('courses.Youtube')}}
                                                </option> --}}
                                                <option value="Vimeo"
                                                >
                                                    {{__('courses.Vimeo')}}
                                                </option>
                                                @if(isModuleActive("AmazonS3"))
                                                    <option value="AmazonS3"
                                                    >
                                                        {{__('courses.Amazon S3')}}
                                                    </option>
                                                @endif

                                                <option value="Self"
                                                >
                                                    {{__('courses.Self Host')}}
                                                </option>


                                            </select>
                                        </div>
                                        <div class="col-xl-8 ">
                                            <div class="input-effect videoUrl"
                                                 style="display:@if((isset($course) && (@$course->host!="Youtube")) || !isset($course)) none  @endif">
                                                <label>{{__('courses.Video URL')}}
                                                    <span>*</span></label>
                                                <input
                                                    id="couseEditViewUrl"
                                                    class="primary_input_field youtubeVideo name{{ $errors->has('trailer_link') ? ' is-invalid' : '' }}"
                                                    type="text" name="trailer_link"
                                                    placeholder="{{__('courses.Video URL')}}"
                                                    autocomplete="off"
                                                    value=" " {{$errors->has('trailer_link') ? 'autofocus' : ''}}>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('trailer_link'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trailer_link') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="row  vimeoUrl" id=""
                                                 style="display: @if((isset($course) && (@$course->host!="Vimeo")) || !isset($course)) none  @endif">
                                                <div class="col-lg-12" id="">
                                                    <label class="primary_input_label"
                                                           for="">{{__('courses.Vimeo Video')}}</label>
                                                    <select class="primary_select vimeoVideo"
                                                            name="vimeo"
                                                            id="viemoEditCourse">
                                                        <option
                                                            data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                            value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                        </option>
                                                        @foreach ($video_list as $video)
                                                            <option
                                                                value="{{@$video['uri']}}">{{@$video['name']}}</option>


                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('vimeo'))
                                                        <span
                                                            class="invalid-feedback invalid-select"
                                                            role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row  videofileupload" id=""
                                                 style="display: @if((isset($course) && ((@$course->host=="Vimeo") ||  (@$course->host=="Youtube")) ) || !isset($course)) none  @endif">

                                                <div class="col-xl-12">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label"
                                                               for="">{{__('courses.Video File')}}</label>
                                                        <div class="primary_file_uploader">
                                                           {{-- <input
                                                                class="primary-input filePlaceholder"
                                                                type="text"

                                                                placeholder="{{__('courses.Browse Video file')}}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label
                                                                    class="primary-btn small fix-gr-bg"
                                                                    for="document_file_edit">{{__('common.Browse') }}</label>
                                                                <input type="file"
                                                                       class="d-none fileUpload"
                                                                       name="file"
                                                                       id="document_file_edit">
                                                            </button>

                                                            @if ($errors->has('file'))
                                                                <span
                                                                    class="invalid-feedback invalid-select"
                                                                    role="alert">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                                            @endif--}}
                                                            <input type="file" class="filepond"  name="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">


                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Course Thumbnail')}} ({{__('common.Max Image Size 1MB')}})
                                                    *</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder"
                                                           type="text"
                                                           id=""

                                                           placeholder="{{__('courses.Browse Image file')}}"
                                                           readonly="" {{$errors->has('image') ? 'autofocus' : ''}}>
                                                    <button class="" type="button">
                                                        <label
                                                            class="primary-btn small fix-gr-bg"
                                                            for="document_file_1_edit_">{{__('common.Browse')}}</label>
                                                        <input type="file"
                                                               class="d-none fileUpload"
                                                               name="image"
                                                               id="document_file_1_edit_">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @if(\Illuminate\Support\Facades\Auth::user()->subscription_api_status==1)
                                            <div class="col-xl-6">
                                                <label class="primary_input_label"
                                                       for="">{{__('newsletter.Subscription List')}}
                                                </label>
                                                <select class="primary_select" id="subscriptionEdit"
                                                        name="subscription_list" {{$errors->has('subscription_list') ? 'autofocus' : ''}}>
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('newsletter.Subscription List')}}"
                                                        value="">{{__('common.Select')}} {{__('newsletter.Subscription List')}}

                                                    </option>
                                                    @foreach($sub_lists as $list)
                                                        <option value="{{$list['id']}}">
                                                            {{$list['name']}}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Meta keywords')}}</label>
                                                <input class="primary_input_field"
                                                       name="meta_keywords" id="editMetaKey"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Meta description')}}</label>
                                                <textarea id="editMetaDetails"
                                                          class="primary_input_field"
                                                          name="meta_description"
                                                          style="height: 200px"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}}  {{__('courses.Course')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </section>
    @include('backend.partials.delete_modal')

    <div class="modal fade admin-query" id="feedback_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Course Feedback For Content Provider</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="feedback_course_id">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="feedback" id="feedback_text" class="primary_input_field tooltip_class" style="width: 100%; min-height: 155px" required>{{@$feedback->feedback}}</textarea>
                            </div>
                        </div>
                    </form>

                    <div class="col-lg-12 text-center">
                        <div class="mt-40 d-flex justify-content-between">
                            {{-- <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button> --}}
                            <a id="feedback_btn" class="primary-btn semi_large2 fix-gr-bg">Send Feedback</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="approve_course_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Approve/Reject Course</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="approve_course_id">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center" style="font-size: 16px">Are you sure you want to approve the course ?</p>
                            </div>
                        </div>
                    </form>
                    <div class="col-lg-12 text-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button id="approve_course_btn" type="submit" class="btn btn-success">Approve <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i></button>

                            <button id="reject_course_btn" type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')

    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>

    @php

            $url = route('getAllFeaturedCourseData');


    @endphp

    <script>
        var dom_data = '';
        var current_user_role_id = 0;
        $(function() {
            current_user_role_id = $("#current_user_role_id").val();

            if(current_user_role_id == 7 || current_user_role_id == 8){
                dom_data = 'frtip';
            }
            else{
                dom_data = 'Bfrtip';
            }
            tableLoad();
            userload();
        });
        tableLoad = () => {
            let table = $('.classList').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
    			stateSave: true,
                order: [[0, "desc"]],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 1 // number of pages to cache
                }),
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    // {data: 'type', name: 'type'},
                    {data: 'title', name: 'title'},
                    {data: 'category', name: 'category.name'},
                   // {data: 'quiz', name: 'quiz.title'},
                    {data: 'user', name: 'user.name'},
                    {data: 'status', name: 'search_status',orderable:false,searchable:false},
                    {data: 'feature', name: 'feature'},
                    {data: 'lessons', name: 'lessons'},
                    @if(!(isCourseReviewer() && \Route::current()->getName() == 'getPendingCourse'))
                    {data: 'enrolled_users', name: 'enrolled_users'},
                    @endif
                    // {data: 'publishedDate', name: 'publishedDate', orderable:false,searchable:false},
                    {data: 'price', name: 'price'},
                    {data: 'duration', name: 'duration'},
                    @if(!(isCourseReviewer()))
                    {data: 'total_rating', name: 'total_rating'},
                    @endif
                    @if(\Route::current()->getName() == 'getActiveCourse' || \Route::current()->getName() == 'getPendingCourse')
                    {data: 'submitted_at', name: 'submitted_at'},
                    @endif
                    {data: 'published_at', name: 'published_at'},
                    {data: 'approval_at', name: 'approval_at',orderable:false,searchable:false},
                    {data: 'action', name: 'action',orderable:false},

                ],
                language: {
                    emptyTable: "{{ __("common.No data available in the table") }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __("common.Quick Search") }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: dom_data,
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __("common.Copy") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __("common.Excel") }}',
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },

                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="far fa-file-alt"></i>',
                        titleAttr: '{{ __("common.CSV") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __("common.PDF") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __("common.Print") }}',
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ['colvisRestore']
                    }
                ],
                columnDefs: [{
                    visible: false
                }],
                responsive: true,
            });
        }

        $('#lms_table').on('preXhr.dt', function (e, settings, data) {
            var category = $('#category').val();
            var type = $('#type').val();
            var instructor = $('#instructor').val();
            var course = $('#course').val();
            var status = $('#status').val();
            var fromDuration = $('#from_duration').val();
            var toDuration = $('#to_duration').val();
            var start_price = $('#start_price').val();
            var end_price = $('#end_price').val();
            var total_rating = $('#total_rating').val();
            var content_provider = $('#content_provider').val();
            var fromSubmissionDate = $('#from_submission_date').val();
            var toSubmissionDate = $('#to_submission_date').val();

            console.log(content_provider, start_price, end_price);

            data['category'] = category;
            data['type'] = type;
            data['instructor'] = instructor;
            data['course'] = course;
            data['status'] = status;
            data['from_duration'] = fromDuration;
            data['to_duration'] = toDuration;
            data['start_price'] = start_price;
            data['end_price'] = end_price;
            data['total_rating'] = total_rating;
            data["content_provider"] = content_provider;
            data['from_submission_date'] = fromSubmissionDate;
            data['to_submission_date'] = toSubmissionDate;
        });

        $('#apply-filters').click(function () {
            tableLoad();
        });

        $('#reset-filters').click(function () {
            $('#filter_form')[0].reset();
            $('#instructor').val('').trigger('change');
            $('#content_provider, #status, #category').val( $('#content_provider, #status, #category').data('display'));
            $('#content_provider, #status, #category').niceSelect('update')
            tableLoad();
        });

        $('#excel_import_table_data').click(function () {
            if (confirm("The export will take some time and it will consume the server usage!") == true) {
                $("#filter_form").submit();
            }

        });

        $('#lms_table_info').append('<span id="add_here"> new-dynamic-text</span>');

        userload = () => {
            var url = "{{ route('user_data_with_ajax_in_course') }}";
            $("#instructor").select2({
                allowClear: true,
                ajax: {
                    url: url,
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
        }

        $('body').on('click', '.feedback_option_click', function () {
            var id = $(this).data('id');
            console.log(id);
            $("#feedback_course_id").val(id);
            $('#feedback_modal').modal({backdrop: 'static', keyboard: false});
            $("#feedback_modal").modal("show");

        });

        $('body').on('click', '.approve_course_click', function () {
            var id = $(this).data('id');
            console.log(id);
            $("#approve_course_id").val(id);
            $('#approve_course_modal').modal({backdrop: 'static', keyboard: false});
            $("#approve_course_modal").modal("show");
        });

        $('body').on('click', '#feedback_btn', function (e) {
            // if ($.trim($("#feedback_text").val()) === "") {
            //     e.preventDefault();
            //     alert('Please enter your feedback.');
            // }else {
                $.ajax({
                    type: "POST",
                    // url: "{{route('send_course_feedback')}}",
                    url: "{{route('reject_feedback')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: $("#feedback_course_id").val(),
                        feedback: $("#feedback_text").val(),
                    },
                    success: function (data) {
                        //console.log(data);
                        if(data.vstatus == 0)
                        {
                            if(typeof(data.errors) != "undefined" && data.errors !== null)
                            {
                                $.each(data.errors, function (i, item) {
                                    toastr.error(item);
                                })
                            }
                        }
                        if(data.vstatus == 1)
                        {
                            $("#feedback_modal").modal("hide");
                            $("#feedback_text").val('');
                            if(data.status == 1){
                                toastr.success(data.message);
                                location.reload();
                            }
                            if(data.status == 0){
                                toastr.error(data.message);
                            }
                        }
                    }
                });
            // }

        });

        $('body').on('click', '#approve_course_btn', function () {
            $('.submit-loading-spinner').addClass('active');
            $(this).attr("disabled", "disabled");
            $('#reject_course_btn').attr("disabled", "disabled");
            $('.close').attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "{{route('approve_course')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $("#approve_course_id").val(),
                },
                success: function (data) {
                    $('.submit-loading-spinner').removeClass('active');
                    $("#approve_course_modal").modal("hide");
                    if(data.status == 1){
                        toastr.success(data.message);
                        location.reload();
                        //$('.classList').DataTable().ajax.reload();
                    }
                    if(data.status == 0){
                        toastr.error(data.message);
                    }
                }
            });
        });

        $('body').on('click', '#reject_course_btn', function () {
            $.ajax({
                type: "POST",
                url: "{{route('reject_course')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $("#approve_course_id").val(),
                },
                success: function (data) {
                    $("#approve_course_modal").modal("hide");
                    if(data.status == 1){
                        toastr.success(data.message);
                        //console.log(data.id);
                        $("#feedback_course_id").val(data.id);
                        $('#feedback_modal').modal({backdrop: 'static', keyboard: false});
                        $("#feedback_modal").modal("show");
                    }
                    if(data.status == 0){
                        toastr.error(data.message);
                    }
                    // console.log('refresh');
                    //location.reload();
                    //$('.classList').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endpush

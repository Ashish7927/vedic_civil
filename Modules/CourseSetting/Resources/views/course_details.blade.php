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
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e7edfb!important;
            border-radius: 30px!important;
        }
        .select2-selection__choice {
            background-color: #87CEEB!important;
            width: -moz-fit-content;
            width: fit-content;
        }

        .add_option_box{
            font-family: sans-serif;
        }
    </style>
    <style type="text/css">
        .loading-spinner, .submit-loading-spinner {
            display: none;
        }
        .loading-spinner.active, .submit-loading-spinner.active {
            display: inline-block;
        }
        .multiple-options .current {
            background-color: #87CEEB!important;
            width: -moz-fit-content;
            width: fit-content;
        }
    </style>
@endpush
@section('mainContent')


    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('courses.Course')}} </h1>
                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('courses.Course')}} </a>
                    <a href="#">{{__('courses.Course')}} {{__('common.Details')}} </a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                @if($course->type==1)
                    <div class="col-lg-12">

                    </div>
                @endif
                <div class="@if($course->type==1)col-md-12 @else col-md-12  @endif ">
                    {{-- <div class="main-title">
                        <h3 class="">

                            {{__('courses.Course')}}
                        </h3>
                    </div> --}}

                    @if(Session::has('type'))
                        @php
                            $type=Session::get('type');
                        @endphp
                    @elseif (request()->get('type'))
                        @php
                            $type=request()->get('type');
                        @endphp


                    @else
                        @php
                            if($course->type==1){
                                $type ='courseDetails';
                            }else{
                                $type ='courseDetails';
                            }
                        @endphp
                    @endif
                    <div class="row pt-0">
                        <ul class="nav nav-tabs no-bottom-border ul_tab_list  mt-sm-md-20 mb-10 ml-3" role="tablist">
                            @if($course->type==1)


                                <li class="nav-item course-details">
                                    <a class="nav-link  @if($type=="courseDetails") active @endif details_tab"
                                       href="#indivitual_email_sms" role="tab"
                                       data-toggle="tab"><b>1</b> &nbsp{{__('courses.Course')}} {{__('common.Details')}}</a>
                                </li>

                                <li class="nav-item curriculum-course">
                                @if(check_whether_cp_or_not() || isPartner())
                                      @if(isset($course->detail_tab))
                                          @if($course->detail_tab == 1)
                                              <a class="nav-link @if($type=="courses") active @endif  curriculum_tab" href="#group_email_sms" role="tab" data-toggle="tab"><b>2</b> &nbsp{{__('courses.Course')}} {{__('courses.Curriculum')}}  </a>
                                              <input type="hidden" id="curriculum_hidden" value="1">
                                          @else
                                              <a class="nav-link curriculum_tab" href="" role="tab" onclick="tabchange(2)" data-toggle="tab"><b>2</b> &nbsp{{__('courses.Course')}} {{__('courses.Curriculum')}}  </a>
                                              <input type="hidden" id="curriculum_hidden" value="0">
                                          @endif
                                      @else
                                          <a class="nav-link curriculum_tab" href="" role="tab" data-toggle="tab"><b>2</b> &nbsp{{__('courses.Course')}} {{__('courses.Curriculum')}}  </a>
                                          <input type="hidden" id="curriculum_hidden" value="0">
                                      @endif
                                  @else
                                      <a class="nav-link @if($type=="courses") active @endif  curriculum_tab" href="#group_email_sms" role="tab" data-toggle="tab"><b>2</b> &nbsp{{__('courses.Course')}} {{__('courses.Curriculum')}}  </a>
                                      <input type="hidden" id="curriculum_hidden" value="1">
                                  @endif
                                </li>

                                <li class="nav-item excerise-tab-file">
                                @if(check_whether_cp_or_not() || isPartner())
                                      @if(isset($course->curriculum_tab))
                                          @if($course->curriculum_tab == 1)
                                              <a class="nav-link  @if($type=="files") active @endif exercise_tab" href="#file_list" role="tab" data-toggle="tab"><b>3</b> &nbsp{{__('courses.Additional resources')}}</a>
                                              <input type="hidden" id="exercise_hidden" value="1">
                                          @else
                                              <a class="nav-link  exercise_tab" href="" role="tab" onclick="tabchange(3)" data-toggle="tab"><b>3</b> &nbsp{{__('courses.Additional resources')}}</a>
                                              <input type="hidden" id="exercise_hidden" value="0">
                                          @endif
                                      @else
                                          <a class="nav-link exercise_tab" href="" role="tab" data-toggle="tab"><b>3</b> &nbsp{{__('courses.Additional resources')}}</a>
                                          <input type="hidden" id="exercise_hidden" value="0">
                                      @endif
                                  @else
                                      <a class="nav-link  @if($type=="files") active @endif exercise_tab" href="#file_list" role="tab" data-toggle="tab"><b>3</b> &nbsp{{__('courses.Additional resources')}}</a>
                                      <input type="hidden" id="exercise_hidden" value="1">
                                  @endif
                                </li>
                                <li class="nav-item certificate-tab">
                                  @if(check_whether_cp_or_not() || isPartner())
                                      @if(isset($course->curriculum_tab))
                                          @if($course->curriculum_tab == 1)
                                              <a class="nav-link  @if($type=="files") active @endif certificate_tab" href="#certificate" role="tab" data-toggle="tab"><b>4</b> &nbsp{{__('certificate.Certificate')}}</a>
                                              <input type="hidden" id="certificate_hidden" value="1">
                                          @else
                                              <a class="nav-link certificate_tab" href="" role="tab" onclick="tabchange(3)" data-toggle="tab"><b>4</b> &nbsp{{__('certificate.Certificate')}}</a>
                                              <input type="hidden" id="certificate_hidden" value="0">
                                          @endif
                                      @else
                                          <a class="nav-link certificate_tab" href="" role="tab" data-toggle="tab"><b>4</b> &nbsp{{__('certificate.Certificate')}}</a>
                                          <input type="hidden" id="certificate_hidden" value="0">
                                      @endif
                                  @else
                                      <a class="nav-link  @if($type=="files") active @endif certificate_tab" href="#certificate" role="tab" data-toggle="tab"><b>4</b> &nbsp{{__('certificate.Certificate')}}</a>
                                      <input type="hidden" id="certificate_hidden" value="1">
                                  @endif
                                </li>
                                {{-- @if($course->drip==1)
                                    <li class="nav-item">
                                        <a class="nav-link @if($type=="drip") active @endif" href="#drip" role="tab"
                                           data-toggle="tab"> {{__('common.Drip Content')}}</a>
                                    </li>
                                @endif --}}
                            @endif

                        </ul>
                    </div>
                    <div class="white_box_30px">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel"
                                         class="tab-pane fade  @if( ($type=="courses")) show active  @endif "
                                         id="group_email_sms">

                                        <div class="QA_section QA_section_heading_custom check_box_table   ">
                                            <div class="QA_table ">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="nastable">

                                                            {{-- Start Udemy Design --}}
                                                            <style>
                                                                .add-item-forms--inline-menu--1OTdc {
                                                                    margin-bottom: -25px;
                                                                    padding: 10px;
                                                                    border: 1px solid #9b34ef;
                                                                    background: #fff;
                                                                    height: 55px;
                                                                    display: flex;
                                                                    border-radius: 50px;
                                                                }

                                                                .section_content {
                                                                    margin-bottom: 0px;
                                                                    padding: 10px;
                                                                    border: 1px solid #9b34ef;
                                                                    background: #fff;
                                                                    border-radius: 50px;
                                                                }

                                                                .col-lg-10.section_content {
                                                                    margin-top: 50px;
                                                                }

                                                                .lms_option_box {
                                                                    box-sizing: border-box;
                                                                }

                                                                .lms_option_list {
                                                                    width: 650px;
                                                                }

                                                                .lms_option_list_inside {
                                                                    width: 650px;
                                                                }

                                                                .btn-block + .btn-block {
                                                                    margin-top: 0;
                                                                }

                                                                .section-white-box {
                                                                    background: #ffffff;
                                                                    padding: 40px 30px;
                                                                    border-radius: 50px;
                                                                    box-shadow: 0px 10px 15px rgb(236 208 244 / 30%);
                                                                    border-radius: 50px;
                                                                }

                                                            </style>
                                                            <hr>



                                                            <div class="row d-flex">

                                                                {{-- OLD BUTTON --}}
                                                                {{-- <div class="col-lg-2">
                                                                    <button
                                                                        class="primary-btn  mr-10 fix-gr-bg  align-items-center justify-content-center"
                                                                        id="add_option_box" style="display: d-flex"><i
                                                                            class="ti-plus mr-0"> ADD COURSE CURRICULUM</i></button>
                                                                    <button
                                                                        class="primary-btn icon-only mr-10 fix-gr-bg"
                                                                        id="minus_option_box" style="display: none">X
                                                                    </button>
                                                                </div> --}}
                                                                <div class="col-lg-5">
                                                                        <button
                                                                               class="primary-btn radius_30px  fix-gr-bg"
                                                                               id="add_option_box" style="display: d-flex"><i
                                                                                    class="ti-plus"></i>ADD COURSE CURRICULUM
                                                                        </button>
                                                                        <button
                                                                        class="primary-btn icon-only mr-10 fix-gr-bg"
                                                                        id="minus_option_box" style="display: none">X
                                                                    </button>

                                                                </div>

                                                                <div class="col-lg-10">
                                                                    <div class="lms_option_box d-flex">
                                                                        <div class="pt-20 pb-30 lms_option_list"
                                                                             style="display: none">
                                                                            <div
                                                                                class="add-item-forms--inline-menu--1OTdc">
                                                                                <button data-purpose="add-chapter-btn"
                                                                                        aria-label="Add Chapter"
                                                                                        type="button"
                                                                                        id="show_chapter_section"
                                                                                        class="ellipsis btn btn-tertiary btn-block">
                                                                                    <i class="ti-plus"></i> {{__('courses.Chapter')}}
                                                                                </button>
                                                                                <button data-purpose="add-lesson-btn"
                                                                                        aria-label="Add Lesson"
                                                                                        type="button"
                                                                                        id="show_lesson_section"
                                                                                        class="ellipsis btn btn-tertiary btn-block">
                                                                                    <i class="ti-plus"></i>
                                                                                    {{__('courses.Lesson')}}
                                                                                </button>
                                                                                <button data-purpose="add-quiz-btn"
                                                                                        aria-label="Add Quiz"
                                                                                        type="button"
                                                                                        id="show_quiz_section"
                                                                                        class="ellipsis btn btn-tertiary btn-block">
                                                                                    <i class="ti-plus"></i> {{__('quiz.Quiz')}}
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <!-- table-responsive -->


                                                             @if(count($chapters)==0)
                                                                <div class="text-center">
                                                                  {{__('courses.No Data Found')}}
                                                                </div>

                                                             @endif

                                                            <div class="row" id="chapter_section" style="display: none">
                                                                <div class="col-lg-1"></div>
                                                                <div class="col-lg-10 section_content">
                                                                    @include('coursesetting::parts_of_course_details.chapter_section_add')
                                                                </div>
                                                                <div class="col-lg-1"></div>

                                                            </div>
                                                            <div class="row" id="lesson_section" style="display: none">
                                                                <div class="col-lg-1"></div>
                                                                <div class="col-lg-10 section_content">
                                                                    @include('coursesetting::parts_of_course_details.lesson_section')
                                                                </div>
                                                                <div class="col-lg-1"></div>

                                                            </div>
                                                            <div class="row" id="quiz_section" style="display: none">
                                                                <div class="col-lg-1"></div>
                                                                <div class="col-lg-10 section_content">
                                                                    @include('coursesetting::parts_of_course_details.quiz_section')
                                                                </div>
                                                                <div class="col-lg-1"></div>

                                                            </div>
                                                            <div class="row" style="display: none">
                                                                <div class="col-lg-1"></div>
                                                                <div class="col-lg-10 section_content">

                                                                </div>
                                                                <div class="col-lg-1"></div>

                                                            </div>

                                                            {{-- START CHAPTER --}}

                                                            @include('coursesetting::parts_of_course_details.chapter_list')

                                                            {{-- END CHAPTER --}}
                                                            {{-- End Udemy Design --}}
                                                        </div>

                                                    </div>
                                                </div>

                                                @push('js')
                                                    <script>
                                                        var lms_option_list = $('.lms_option_list');
                                                        var minus_option_box = $('#minus_option_box');
                                                        var add_option_box = $('#add_option_box');
                                                        var chapter_section = $('#chapter_section');
                                                        var lesson_section = $('#lesson_section');
                                                        var quiz_section = $('#quiz_section');
                                                        $(document).ready(function () {
                                                            let lms_option_list = $('#lms_option_list').hide();
                                                        })
                                                        $('#add_option_box').click(function () {
                                                            lms_option_list.show();
                                                            minus_option_box.show();
                                                            add_option_box.hide();
                                                        })
                                                        $('#minus_option_box').click(function () {
                                                            lms_option_list.hide();
                                                            minus_option_box.hide();
                                                            lesson_section.hide();
                                                            quiz_section.hide();
                                                            chapter_section.hide();
                                                            add_option_box.show();
                                                        })
                                                        $('#show_chapter_section').click(function () {
                                                            lms_option_list.hide();
                                                            lesson_section.hide();
                                                            quiz_section.hide();
                                                            chapter_section.show();
                                                        })
                                                        $('#show_lesson_section').click(function () {
                                                            lms_option_list.hide();
                                                            lesson_section.show();
                                                            quiz_section.hide();
                                                            chapter_section.hide();
                                                        })
                                                        $('#show_quiz_section').click(function () {
                                                            lms_option_list.hide();
                                                            lesson_section.hide();
                                                            quiz_section.show();
                                                            chapter_section.hide();
                                                        })
                                                    </script>
                                                @endpush

                                            </div>
                                            <div class="col-lg-12 text-center pt_15">
                                                <div class="d-flex justify-content-center">
                                                    @if(isset($course) && $course->status == 1)
                                                        @if(isAdmin() || isHRDCorp() || isMyLL())
                                                            <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_curriculum_tab_status_1"  type="button"><i class="ti-check update_check"></i>
                                                                <span class="btn_text">{{__('common.Next')}}</span>
                                                                <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                            </button>
                                                        @else
                                                            <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" type="button" disabled>
                                                                <i class="ti-check update_check" ></i>
                                                                <span class="btn_text">{{__('common.Next')}}</span>
                                                                <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if(check_whether_cp_or_not() || isPartner() || isAdmin() || isHRDCorp() || isMyLL())
                                                            @if(isset($course) && $course->status == 2)
                                                                <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_curriculum_tab"  type="button"><i class="ti-check update_check"></i>
                                                                    <span class="btn_text">{{__('common.Next')}}</span>
                                                                    <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                </button>
                                                            @elseif(isset($course) && $course->status == 4)
                                                                <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_curriculum_tab_status_4"  type="button"><i class="ti-check update_check"></i>
                                                                    <span class="btn_text">{{__('common.Next')}}</span>
                                                                    <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                </button>
                                                            @else
                                                                <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_curriculum_tab_status_0"  type="button"><i class="ti-check update_check"></i>
                                                                    <span class="btn_text">{{__('common.Next')}}</span>
                                                                    <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                </button>
                                                            @endif
                                                        @else
                                                            <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="submit"><i
                                                                    class="ti-check update_check"></i>
                                                                <span class="btn_text_submit">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                                <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div role="tabpanel"
                                         class="tab-pane fade
                                            @if($type=="courseDetails") show active @endif
                                             "
                                         id="indivitual_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <form action="{{route('AdminUpdateCourse'). '?typeUpdateCourse='. $type}}" method="POST" id="updateCourseForm"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                {{-- <input type="hidden" name="status_code" id="statusCodeUpdate" value="1" /> --}}
                                                <div class="row">
                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id!=1 && \Illuminate\Support\Facades\Auth::user()->role_id!=7 )
                                                    <!-- <div class="col-xl-6  ">
                                                        <label class="primary_input_label mt-1"
                                                               for=""> {{__('Type')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-25">
                                                                <label class="primary_checkbox d-flex mr-12"
                                                                       for="type{{@$course->id}}1">
                                                                    <input type="radio"
                                                                           class="common-radio type1"
                                                                           id="type{{@$course->id}}1" name="type"
                                                                           value="1" {{@$course->type==1?"checked":""}}>

                                                                    <span data-toggle="tooltip" title="1"
                                                                        class="checkmark mr-2"></span> {{__('courses.Course')}}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-6 mb-25">
                                                                <label class="primary_checkbox d-flex mr-12"
                                                                       for="type{{@$course->id}}2">
                                                                    <input type="radio" class="common-radio type2"
                                                                           id="type{{@$course->id}}2" name="type"
                                                                           value="2" {{@$course->type==2?"checked":""}}>

                                                                    <span data-toggle="tooltip" title="2"
                                                                        class="checkmark mr-2"></span>{{__('quiz.Quiz')}}
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div> -->


                                                        <!-- <div class="col-xl-6 dripCheck"
                                                             @if($course->type!=1)style="display: none" @endif>
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label mt-1"
                                                                       for=""> {{__('common.Drip Content')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="drip{{@$course->id}}0">
                                                                            <input type="radio" class="common-radio drip0"
                                                                                   id="drip{{@$course->id}}0" name="drip"
                                                                                   value="0" {{@$course->drip==0?"checked":""}}>

                                                                            <span data-toggle="tooltip" title="0"
                                                                                class="checkmark mr-2"></span> {{__('common.No')}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-6 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="drip{{@$course->id}}1">
                                                                            <input type="radio" class="   drip1"
                                                                                   id="drip{{@$course->id}}1" name="drip"
                                                                                   value="1" {{@$course->drip==1?"checked":""}}>
                                                                            <span data-toggle="tooltip" title="1"
                                                                                class="checkmark mr-2"></span> {{__('common.Yes')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    @endif
                                                    <div
                                                        class=" @if(\Illuminate\Support\Facades\Auth::user()->role_id==1) col-xl-8 @else col-xl-12  @endif">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label mt-1"
                                                                   for="">{{__('courses.Course Title')}} <i class="fas fa-info-circle" data-toggle="tooltip" title="• Title
                                                                   Description: The course title should be a brief, general statement of the subject matter and reflect the course content. The course title should not exceed 100 characters, including spaces.
                                                                   "></i></label>
                                                            <input class="primary_input_field" name="title"
                                                                   value="{{@$course->title}}" placeholder="-"
                                                                   type="text"  data-toggle="tooltip"
                                                                   title="{{@$course->title}}">
                                                        </div>
                                                    </div>

                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="assign_instructor">{{__('courses.Assign Instructor')}} </label>
                                                                <select class="primary_select category_id"
                                                                        title="{{__('courses.Assign Instructor')}}"
                                                                        name="assign_instructor"
                                                                        id="assign_instructor" {{$errors->has('assign_instructor') ? 'autofocus' : ''}}>
                                                                    <option
                                                                        data-display="{{__('common.Select')}} {{__('courses.Trainer')}}"
                                                                        value="">{{__('common.Select')}} {{__('courses.Trainer')}} </option>
                                                                    @foreach($instructors as $instructor)

                                                                        <option
                                                                            value="{{$instructor->id}}" {{$instructor->id==$course->user_id?'selected':''}}>{{@$instructor->name}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- @if((\Illuminate\Support\Facades\Auth::user()->role_id==isPIC()) && $course->status == 0)
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="assign_reviewer">Assign Course Reviewer </label>
                                                                <select class="primary_select category_id"
                                                                        title="Assign Course Reviewer"
                                                                        name="assign_reviewer"
                                                                        id="assign_reviewer" {{$errors->has('assign_reviewer') ? 'autofocus' : ''}}>
                                                                    <option
                                                                        data-display="{{__('common.Select')}} Course Reviewer"
                                                                        value="">{{__('common.Select')}} Course Reviewer </option>
                                                                    @foreach($reviewers as $reviewer)
                                                                        <option
                                                                            value="{{$reviewer->id}}" {{$reviewer->id==$course->user_id?'selected':''}}>{{@$reviewer->name}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif --}}
                        {{-- @if(auth()->user()->role_id==7) --}}
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
                                    {{-- <option value="1" {{$course->course_type==1?'selected':''}}>Micro-credential</option> --}}
                                    {{-- <option value="2" {{$course->course_type==2?'selected':''}}>Claimable</option> --}}
                                    {{-- <option value="3" {{$course->course_type==3?'selected':''}}>Other</option> --}}
                                    <option value="4" {{$course->course_type==4?'selected':''}}>e-learning</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-25">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">Trainer <span>*</span></label>
                                <input class="primary_input_field" name="trainer"  data-toggle="tooltip"
                                title="{{old('trainer')}}" placeholder="-" id="trainer" type="text" {{$errors->has('trainer') ? 'autofocus' : ''}} value="{{@$course->trainer}}" >
                            </div>
                        </div>
                        {{-- @endif --}}

                                                </div>
                                                <input type="hidden" name="id" class="course_id"
                                                       value="{{@$course->id}}">
                                                <div class="col-xl-12 p-0">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-35">
                                                                <label class="primary_input_label"
                                                                       for="about">{{__('courses.Course')}} {{__('courses.Requirements')}} <span>*</span> <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course requirements
                                                                       Description:
                                                                       Course prerequisite that the learner must have prior enrolling to the course (if any). The course requirement to be stated in standard bullet format.
                                                                       "></i></label>
                                                                <textarea class="lms_summernote_course_details_1 tooltip_class"
                                                                          name="requirements"
                                                                          data-toggle="tooltip"
                                                                          title="{{__('courses.Requirements')}}"
                                                                          id="about" cols="30"
                                                                          rows="10">{!!@$course->requirements!!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="primary_input mb-35">
                                                        <label class="primary_input_label mt-1"
                                                               for="">{{__('courses.Course')}} {{__('courses.Description')}} <span>*</span> <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course Description:
                                                               A summary of the significant learning experiences for the course.
                                                               "></i></label>
                                                        <textarea class="lms_summernote_course_details_2  tooltip_class" name="about"
                                                                  name="" id=""
                                                                   data-toggle="tooltip" title="{{__('courses.Description')}}"
                                                                  cols="30" rows="10">{!!@$course->about!!}</textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-35">
                                                                <label class="primary_input_label"
                                                                       for="about">{{__('courses.Course')}} {{__('courses.Outcomes')}}  *
                                                                       <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Course Outcome
                                       Description: Insert your course outcome which the learner will acquire in this course.
                                       "></i>
                                                                     </label>
                                                                <textarea class="lms_summernote_course_details_3 tooltip_class"
                                                                          name="outcomes"
                                                                            data-toggle="tooltip"
                                                                            title="{{__('courses.Outcomes')}}"
                                                                          id="about" cols="30"
                                                                          rows="10">{!!@$course->outcomes!!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        @php
                                                            if(courseSetting()->show_mode_of_delivery==1){
                                                                $col_size=4;
                                                            }else{
                                                                $col_size=6;

                                                            }
                                                        @endphp
                                                        <div class="col-xl-{{$col_size}} courseBox mb-25">
                                                           <label class="primary_input_label" for="">{{__('courses.Category')}} *
                                                             <i class="fas fa-info-circle" data-toggle="tooltip" title="• Skill Area
                                Description: Refer Course Creation Guide for Skill Area
                                "></i>
                                                           </label>
                                                            <select class="primary_select edit_category_id"
                                                                    data-course_id="{{@$course->id}}"
                                                                    name="category" id="course"
                                                                    title="{{__('courses.Category')}}">
                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                                                    value="">{{__('common.Select')}} {{__('courses.Category')}} </option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category->id}}"
                                                                            @if ($category->id==$course->category_id) selected @endif>{{@$category->name}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <div class="col-xl-{{$col_size}} courseBox mb-25"
                                                             id="edit_subCategoryDiv{{@$course->id}}">
                                                             <label class="primary_input_label" for="">{{ __('courses.Sub Category') }}</label>
                                                            <select class="primary_select " name="sub_category"
                                                                    id="edit_subcategory_id{{@$course->id}}"
                                                                    title="{{__('courses.Sub Category')}}">
                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('courses.Sub Category')}}"
                                                                    value="">{{__('common.Select')}} {{__('courses.Sub Category')}}
                                                                </option>
                                                                <option value="{{@$course->subcategory_id}}"
                                                                        selected>{{@$course->subCategory->name}}</option>
                                                                @if(isset($course->category->subcategories))
                                                                    @foreach($course->category->subcategories as $sub)
                                                                        @if($course->subcategory_id !=$sub->id)
                                                                            <option
                                                                                value="{{@$sub->id}}"
                                                                            >{{@$sub->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div> --}}
                                                        <div class="col-xl-{{$col_size}} courseBox mb_30">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('courses.Skill Area 2')}} </label>
                                                            <select multiple="multiple" class="category_ids select2-multiple form-control" name="category_ids[]"
                                                                    title="{{__('courses.Skill Area 2')}}"
                                                                    id="category_ids" {{$errors->has('category_ids') ? 'autofocus' : ''}} >
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category->id}}"
                                                                            @foreach($taggingData as $one)
                                                                                @if ($category->id==$one['key']) selected @endif
                                                                            @endforeach
                                                                    >{{@$category->name}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                      {{--  @if (courseSetting()->show_mode_of_delivery==1)
                                                            <div class="col-xl-{{$col_size}}  courseBox mb-25">
                                                              <label class="primary_input_label" for="">{{ __('courses.Mode of Delivery') }}</label>
                                                                <select class="primary_select" name="mode_of_delivery"
                                                                 title="{{ __('courses.Mode of Delivery') }}">
                                                                    <option
                                                                        data-display="{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}"
                                                                        value="">{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}</option>
                                                                    <option
                                                                        value="1" {{$course->mode_of_delivery==1?'selected':''}}>{{__('courses.Online')}}</option>
                                                                   <option
                                                                        value="2" {{$course->mode_of_delivery==2?'selected':''}}>{{__('courses.Distance Learning')}}</option>
                                                                    <option
                                                                        value="3" {{$course->mode_of_delivery==3?'selected':''}}>{{__('courses.Face-to-Face')}}</option>

                                                                </select>
                                                            </div>
                                                        @endif --}}

                                                        <div class="col-xl-6  quizBox mb-25" style=" display: none">
                                                           <label class="primary_input_label" for="">{{__('quiz.Quiz')}}</label>
                                                            <select class="primary_select" name="quiz" id="quiz_id"
                                                             data-toggle="tooltip"
                                                             title="{{__('quiz.Quiz')}}">
                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('quiz.Quiz')}}"
                                                                    value="">{{__('common.Select')}} {{__('quiz.Quiz')}} </option>
                                                                @foreach($quizzes as $quiz)
                                                                    <option value="{{$quiz->id}}"
                                                                            @if($quiz->id==$course->quiz_id) selected @endif>{{@$quiz->title}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-xl-4   mb-25 makeResize">
                                                          <label class="primary_input_label" for="">{{ __('courses.Level') }} *</label>
                                                            <select class="primary_select" name="level"
                                                             data-toggle="tooltip" title="{{__('courses.Level')}}">
                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('courses.Level')}}"
                                                                    value="">{{__('common.Select')}} {{__('courses.Level')}}</option>
                                                                @foreach($levels as $level)
                                                                    <option value="{{$level->id}}"
                                                                            @if (@$course->level==$level->id) selected @endif>
                                                                        {{$level->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-xl-4 mb-25 makeResize" id="">
                                                          <label class="primary_input_label" for="">{{__('common.Language')}} *</label>
                                                            <select class="primary_select" name="language"
                                                                    id="" data-toggle="tooltip"
                                                                    title="{{__('courses.Language')}}">
                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('courses.Language')}}"
                                                                    value="">{{__('common.Select')}} {{__('courses.Language')}}</option>
                                                                @foreach ($languages as $language)
                                                                    <option value="{{$language->id}}"
                                                                            @if ($language->id==$course->lang_id) selected @endif>{{$language->native}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-xl-4 makeResize mb-25">
                                                            <div class="primary_input ">
                                                                <label
                                                                    class="primary_input_label mt-1 primary_input_label"
                                                                    for="">{{__('common.Duration')}}
                                                                    ({{__('common.In Minute')}}) *
                                                                    <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Duration
                                       Description: Minimum duration should not be less than 30 minutes.
                                       "></i>
                                                                  </label>
                                                                <input class="primary_input_field"
                                                                       name="duration" placeholder="-" min="0"
                                                                       step="any" type="number"
                                                                       value="{{@$course->duration}}"
                                                                       data-toggle="tooltip" title="{{@$course->duration}}"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 courseBox mb-25">
                                                        <div class="primary_input  ">

                                                            <div class="row  ">
                                                                <div class="col-md-12">
                                                                    <label class="primary_input_label mt-1"
                                                                           for=""> {{__('common.Complete course sequence')}}</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="complete_order0">
                                                                    <input type="radio"
                                                                           class="common-radio complete_order0"
                                                                           id="complete_order0"
                                                                           name="complete_order"
                                                                           value="0" {{@$course->complete_order==0?"checked":""}}>
                                                                        <span class="checkmark mr-2" data-toggle="tooltip" title="0"></span>      {{__('common.No')}}</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">

                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="complete_order1">
                                                                    <input type="radio"
                                                                           class="common-radio complete_order1"
                                                                           id="complete_order1"
                                                                           name="complete_order"
                                                                           value="1" {{@$course->complete_order==1?"checked":""}}>


                                                                        <span
                                                                         data-toggle="tooltip" title="1"
                                                                         class="checkmark mr-2"></span> {{__('common.Yes')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 courseBox">
                                                        <div class="primary_input mb-25">

                                                            <div class="row ">
                                                                <div class="col-md-12 mb-25">
                                                                    <label class="primary_input_label mt-1"
                                                                           for=""> {{__('Is Subscription')}}</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <label class="primary_checkbox d-flex mr-12">
                                                                        <input type="radio" class="  complete_order0"
                                                                               id="complete_order0" name="is_subscription"
                                                                               value="0" {{@$course->is_subscription==0?"checked":""}}>
                                                                        <span data-toggle="tooltip" title="0" class="checkmark mr-2"></span> {{__('common.No')}}</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <label class="primary_checkbox d-flex mr-12">
                                                                    <input type="radio" class="complete_order1"
                                                                           id="complete_order1" name="is_subscription"
                                                                           value="1"{{@$course->is_subscription==1?"checked":""}}>
                                                                          <span  data-toggle="tooltip" title="1" class="checkmark mr-2"></span>{{__('common.Yes')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row d-none">
                                                        <div class="col-lg-6">
                                                            <div class="checkbox_wrap d-flex align-items-center">
                                                                <label for="course_1" class="switch_toggle mr-2">
                                                                    <input type="checkbox" name="isFree" value="1"
                                                                           id="edit_course_1"  data-toggle="tooltip" title="1">
                                                                    <i class="slider round"></i>
                                                                </label>
                                                                <label
                                                                    class="mb-0">{{__('courses.This course is a top course')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-20">
                                                        <div class="col-lg-6">
                                                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                                                <label for="edit_course_2{{$course->id}}"
                                                                       class="switch_toggle  mr-2">
                                                                    <input type="checkbox" class="edit_course_2"
                                                                           id="edit_course_2{{$course->id}}"
                                                                           name="is_free"
                                                                            data-toggle="tooltip" title="1"
                                                                           @if ($course->price==0) checked
                                                                           @endif value="1">
                                                                    {{-- <input type="checkbox" class="edit_course_2" id="edit_course_2" name="is_free" @if ($course->price==0) checked @endif value="1"> --}}
                                                                    <i class="slider round"></i>
                                                                </label>
                                                                <label
                                                                    class="mb-0">{{__('courses.This course is a free course')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6" id="edit_price_div">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label mt-1"
                                                                       for="">{{__('courses.Price')}} <i class="fas fa-info-circle" data-toggle="tooltip" title="• Price
                                                                       Description:
                                                                       Insert course price without RM/MYR. Price is inclusive of SST (if applicable).
                                                                       "></i></label>
                                                                <input class="primary_input_field" name="price"
                                                                       placeholder="-" value="{{@$course->price}}"
                                                                       type="text" data-toggle="tooltip"
                                                                       title="{{__('courses.Price')}}" id="addPrice">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-20 editDiscountDiv">
                                                        <div class="col-xl-12">
                                                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                                                <label for="edit_course_3"
                                                                       class="switch_toggle  mr-2">
                                                                    <input type="checkbox" class="edit_course_3"
                                                                           name="is_discount"
                                                                           @if ($course->discount_price>0) checked

                                                                           @endif id="edit_course_3"
                                                                           value="1"
                                                                           data-toggle="tooltip" title="1">
                                                                    <i class="slider round"></i>
                                                                </label>
                                                                <label
                                                                    class="mb-0">{{__('courses.This course has discounted price')}}</label>
                                                            </div>
                                                        </div>
                                                        @php
                                                            if ($course->discount_price>0){
                                                                $d_price='block';
                                                            }else{
                                                                 $d_price='none';
                                                            }
                                                        @endphp
                                                        <div class="col-xl-12"
                                                             id="edit_discount_price_div"
                                                             style="display: {{$d_price}}">
                                                             <div class="row" >
                                                                <div class="col-xl-4" >
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label mt-1"
                                                                            for="">{{__('courses.Discount')}} {{__('courses.Price')}}</label>
                                                                        <input class="primary_input_field editDiscount"
                                                                            name="discount_price" id="addDiscount"
                                                                            value="{{@$course->discount_price}}"
                                                                            placeholder="-" type="text" data-toggle="tooltip"
                                                                            title="{{__('courses.Discount')}} {{__('courses.Price')}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="startDate">{{ __('courses.Discount') }} {{ __('courses.Start Date') }}</label>
                                                                        <div class="primary_datepicker_input">
                                                                            <div class="no-gutters input-right-icon">
                                                                                <div class="col">
                                                                                    <div class="">
                                                                                        <input class="primary_input_field" type="date" name="discount_start_date" id="discount_start_date" value="{{@$course->discount_start_date}}" min="{{ now()->toDateString('Y-m-d') }}">
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
                                                                                        <input class="primary_input_field" type="date" name="discount_end_date" id="discount_end_date" value="{{@$course->discount_end_date}}" min="{{ now()->toDateString('Y-m-d') }}">
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
                                                    </div>
                                                    <div class="videoOption">
                                                        <div class="row mt-20 mb-10 ">
                                                            <div class="col-lg-6">
                                                                <div
                                                                    class="checkbox_wrap d-flex align-items-center mt-40">
                                                                    <label for="show_overview_media"
                                                                           class="switch_toggle mr-2">
                                                                        <input type="checkbox" id="show_overview_media"
                                                                               value="1"
                                                                               data-toggle="tooltip" title="1"
                                                                               {{$course->show_overview_media==1 ? "checked" : ""}} name="show_overview_media">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                    <label
                                                                        class="mb-0">{{ __('courses.Show Overview Video') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
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

                                                        @endpush
                                                        <div class="row mt-20 " id="overview_host_section"
                                                             style="display: {{$course->type==2 || $course->show_overview_media==0 ?"none":""}}">

                                                            <div class="col-xl-6  mb-25">

                                                                <select class="primary_select category_id" data-key="12"
                                                                        name="host" id="category_id12" title="{{__('courses.Host')}}">
                                                                    <option value=""
                                                                            data-display="{{__('common.Select')}} {{__('courses.Host')}}">{{__('common.Select')}} {{__('courses.Host')}}</option>

                                                                {{--    <option
                                                                        data-display="{{__('courses.Image Preview')}}"
                                                                        value="ImagePreview" {{@$course->host=="ImagePreview"?'selected':''}}>{{__('courses.Image Preview')}}
                                                                    </option> --}}

                                                                <!--    <option value="Youtube"
                                                                            @if (@$course->host=='Youtube') Selected
                                                                            @endif
                                                                            @if(empty(@$course) && @$course->host=="Youtube") selected @endif
                                                                    >
                                                                        Youtube
                                                                    </option> -->
                                                                    <option value="Vimeo"
                                                                            @if (@$course->host=='Vimeo') Selected
                                                                            @endif
                                                                            @if(empty(@$course) && @$course->host=="Vimeo") selected @endif
                                                                    >
                                                                        Vimeo
                                                                    </option>
                                                                  <!--  <option value="VdoCipher"
                                                                            @if (@$course->host=='VdoCipher') Selected
                                                                            @endif
                                                                            @if(empty(@$course) && @$course->host=="VdoCipher") selected @endif>
                                                                        VdoCipher
                                                                    </option> -->
                                                                    <option value="Self"
                                                                            @if (@$course->host=='Self') Selected
                                                                            @endif
                                                                            @if(empty(@$course) && @$course->host=="Self") selected @endif
                                                                    >
                                                                        Self
                                                                    </option>


                                                                    @if(isModuleActive("AmazonS3"))
                                                                        <option value="AmazonS3"
                                                                                @if (@$course->host=='AmazonS3') Selected
                                                                                @endif
                                                                                @if(empty(@$course) && @$course->host=="AmazonS3") selected @endif
                                                                        >
                                                                            Amazon S3
                                                                        </option>
                                                                    @endif
                                                                    @if(isModuleActive("SCORM"))
                                                                    {{--    <option value="SCORM"
                                                                                @if(empty(@$course) && @$course->host=="SCORM") selected @endif
                                                                        >
                                                                            SCORM Self
                                                                        </option> --}}
                                                                    @endif

                                                                    @if(isModuleActive("AmazonS3") && isModuleActive("SCORM"))
                                                                        <option value="SCORM-AwsS3"
                                                                                @if(empty(@$course) && @$course->host=="SCORM-AwsS3") selected @endif
                                                                        >
                                                                            SCORM AWS S3
                                                                        </option>
                                                                    @endif
                                                                </select>

                                                            </div>
                                                            @push('js')
                                                                <script>
                                                                    $('.category_id').change(function () {
                                                                        var key = $(this).data('key');
                                                                        let category_id = $('#category_id' + key).find(":selected").val();

                                                                        if (category_id === 'Youtube' || category_id === 'URL') {
                                                                            $("#iframeBox" + key).hide();
                                                                            $("#videoUrl" + key).show();
                                                                            $("#vimeoUrl" + key).hide();
                                                                            $("#VdoCipherUrl" + key).hide();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#fileupload" + key).hide();

                                                                        } else if ((category_id === 'Self') || (category_id === 'Zip') || (category_id === 'PowerPoint') || (category_id === 'Excel') || (category_id === 'Text') || (category_id === 'Word') || (category_id === 'PDF') || (category_id === 'Image') || (category_id === 'AmazonS3') || (category_id === 'SCORM') || (category_id === 'SCORM-AwsS3')) {

                                                                            $("#iframeBox" + key).hide();
                                                                            $("#fileupload" + key).show();
                                                                            $("#videoUrl" + key).hide();
                                                                            $("#vimeoUrl" + key).hide();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#VdoCipherUrl" + key).hide();

                                                                        } else if (category_id === 'Vimeo') {
                                                                            $("#iframeBox" + key).hide();
                                                                            $("#videoUrl" + key).hide();
                                                                            $("#vimeoUrl" + key).show();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#fileupload" + key).hide();
                                                                            $("#VdoCipherUrl" + key).hide();
                                                                        } else if (category_id === 'VdoCipher') {
                                                                            $("#iframeBox" + key).hide();
                                                                            $("#videoUrl" + key).hide();
                                                                            $("#vimeoUrl" + key).hide();
                                                                            $("#VdoCipherUrl" + key).show();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#fileupload" + key).hide();
                                                                        } else if (category_id === 'Iframe') {
                                                                            $("#iframeBox" + key).show();
                                                                            $("#videoUrl" + key).hide();
                                                                            $("#vimeoUrl" + key).hide();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#fileupload" + key).hide();
                                                                            $("#VdoCipherUrl" + key).hide();
                                                                        } else {
                                                                            $("#iframeBox" + key).hide();
                                                                            $("#videoUrl" + key).hide();
                                                                            $("#vimeoUrl" + key).hide();
                                                                            $("#vimeoVideo" + key).val('');
                                                                            $("#youtubeVideo" + key).val('');
                                                                            $("#fileupload" + key).hide();
                                                                            $("#VdoCipherUrl" + key).hide();
                                                                        }

                                                                    });
                                                                </script>
                                                            @endpush
                                                            <div class="col-xl-6">
                                                                <div class="input-effect  " id="videoUrl12"
                                                                     style="display:@if((isset($course) && ($course->host!="Youtube")) || !isset($course)) none  @endif">
                                                                    <input class="primary_input_field"
                                                                           name="trailer_link"
                                                                           id="youtubeVideo1"
                                                                           data-toggle="tooltip"
                                                                           title="{{__('courses.Video URL')}}"
                                                                           placeholder="{{__('courses.Video URL')}} *"
                                                                           value="@if(isset($course) && $course->host=="Youtube"){{$course->trailer_link}}@endif"
                                                                           type="text">
                                                                    <span class="focus-border"></span>
                                                                    @if ($errors->has('video_url'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('video_url') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div class="input-effect " id="vimeoUrl12"
                                                                     style="display: @if((isset($course) && ($course->host!="Vimeo")) || !isset($course)) none  @endif">
                                                                    <div class="" id="">
                                                                        @if(config('vimeo.connections.main.upload_type')=="Direct")
                                                                            <div class="primary_file_uploader">
                                                                                <input
                                                                                    class="primary-input filePlaceholder"
                                                                                    type="text"
                                                                                    id=""
                                                                                    data-toggle="tooltip"
                                                                                    title="{{__('courses.Browse Video file')}}"
                                                                                    {{$errors->has('image') ? 'autofocus' : ''}}
                                                                                    placeholder="{{__('courses.Browse Video file')}}"
                                                                                    readonly="">
                                                                                <button class="" type="button">
                                                                                    <label
                                                                                        class="primary-btn small fix-gr-bg"
                                                                                        for="document_file_thumb_vimeo_add">{{__('common.Browse') }}</label>
                                                                                    <input type="file"
                                                                                           class="d-none fileUpload"
                                                                                           name="vimeo"
                                                                                           id="document_file_thumb_vimeo_add">
                                                                                </button>
                                                                            </div>
                                                                        @else
                                                                            <select class="primary_select" name="vimeo"
                                                                                    id="vimeoVideo1"
                                                                                    title="Video">
                                                                                <option
                                                                                    data-display="{{__('common.Select')}} video "
                                                                                    value="">{{__('common.Select')}}
                                                                                    video
                                                                                </option>
                                                                                @foreach ($video_list as $video)
                                                                                    @if(isset($course))
                                                                                        <option
                                                                                            value="{{@$video['uri']}}" {{$video['uri']==$course->trailer_link?'selected':''}}>{{@$video['name']}}</option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{@$video['uri']}}">{{@$video['name']}}</option>
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

                                                                <div class="input-effect" id="VdoCipherUrl12"
                                                                     style="display: @if((isset($editLesson) && ($editLesson->host!="VdoCipher")) || !isset($editLesson)) none  @endif">
                                                                    <div class="" id="">

                                                                        <select
                                                                            class="select2  vdocipherList vdocipherListForCourse"
                                                                            title="Video"
                                                                            name="vdocipher"
                                                                            id=" ">
                                                                            <option
                                                                                data-display="{{__('common.Select')}} video "
                                                                                value="">{{__('common.Select')}} video
                                                                            </option>
                                                                            <option value="{{$course->trailer_link}}"
                                                                                    selected></option>
                                                                            {{--                                                                            @foreach ($vdocipher_list as $vdo)--}}
                                                                            {{--                                                                                @if(isset($editLesson))--}}
                                                                            {{--                                                                                    <option--}}
                                                                            {{--                                                                                        value="{{@$vdo->id}}" {{$vdo->id==$editLesson->video_url?'selected':''}}>{{@$vdo->title}}</option>--}}
                                                                            {{--                                                                                @else--}}
                                                                            {{--                                                                                    <option--}}
                                                                            {{--                                                                                        value="{{@$vdo->id}}">{{@$vdo->title}}</option>--}}
                                                                            {{--                                                                                @endif--}}


                                                                            {{--                                                                            @endforeach--}}
                                                                        </select>
                                                                        @if ($errors->has('vdocipher'))
                                                                            <span
                                                                                class="invalid-feedback invalid-select"
                                                                                role="alert">
                                                                        <strong>{{ $errors->first('vdocipher') }}</strong>
                                                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="input-effect " id="fileupload12"
                                                                     style="display: @if((isset($course) && (($course->host=="Vimeo") ||  ($course->host=="Youtube")) ) || !isset($course)) none  @endif">


                                                                    <div class="primary_input">

                                                                        <div class="primary_file_uploader">

                                                                            <input type="file" class="filepond"
                                                                                   name="file">
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
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-35">
                                                                <label class="primary_input_label mt-1"
                                                                       for="">{{__('courses.Course Thumbnail')}} {{__('common.Max Image Size 5MB')}} *
                                                                       <i class="fas fa-info-circle" data-toggle="tooltip" title="• Course thumbnail
                                    Description: The maximum image size is 5mb. The recommended size: 1170x600 pixels and file format must be in .jpg.
                                    "></i>
                                                                       </label>
                                                                <div class="primary_file_uploader">
                                                                    <input class="primary-input filePlaceholder"
                                                                           type="text"
                                                                           id=""
                                                                           data-toggle="tooltip"
                                                                           title="{{__('courses.Course Thumbnail')}}"
                                                                           value="{{showPicName(@$course->thumbnail)}}"
                                                                           placeholder="Browse Image file" readonly="">
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                               for="3_document_file_33">{{__('common.Browse')}}</label>
                                                                        <input type="file" class="d-none fileUpload"
                                                                               name="image"
                                                                               id="3_document_file_33">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-20">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-35">
                                                                <label class="primary_input_label mt-1"
                                                                       for="">Trainer's Image (Recommended size: 200x200)</label>
                                                                <div class="primary_file_uploader">
                                                                    <input class="primary-input filePlaceholder" type="text" id="input_trainer_img"
                                                                    data-toggle="tooltip" title="Trainer's Image" value="{{showPicName(@$course->trainer_image)}}" placeholder="Browse Image file" readonly="" name="trainer_image_placeholder">
                                                                    <button class="" type="button">
                                                                        @if(!empty($course->trainer_image))
                                                                            <label class="primary-btn small remove_btn"><i class="fa fa-times"></i></label>
                                                                        @else
                                                                            <label class="primary-btn small remove_btn" style="display: none"><i class="fa fa-times"></i></label>
                                                                        @endif
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                               for="trainer_img">{{__('common.Browse')}}</label>
                                                                        <input type="file" class="d-none fileUpload"
                                                                               name="trainer_image"
                                                                               id="trainer_img">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label mt-1"
                                                                       for="">{{__('courses.Meta keywords')}}
                                                                       <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Meta Keywords
                                       Description: Insert a minimum of 5 specific keywords separated with comma that reflects the course.
                                       Eg: Excel, Beginner, Microsoft,
                                       "></i>
                                                                       </label>
                                                                <input class="primary_input_field" name="meta_keywords"
                                                                       value="{{@$course->meta_keywords}}"
                                                                       placeholder="-" type="text"
                                                                       data-toggle="tooltip"
                                                                       title="{{__('courses.Meta keywords')}}">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @if(Settings('frontend_active_theme')=="edume")
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{__('courses.Key Point') }}
                                                                        (1)</label>
                                                                    <input class="primary_input_field"
                                                                           name="what_learn1" placeholder="-"
                                                                           type="text"
                                                                           data-toggle="tooltip"
                                                                           title="{{__('courses.Key Point') }}(1)"
                                                                           value="{{old('what_learn1',@$course->what_learn1)}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{__('courses.Key Point') }}
                                                                        (2) </label>
                                                                    <input class="primary_input_field"
                                                                           name="what_learn2" placeholder="-"
                                                                           type="text"
                                                                           data-toggle="tooltip"
                                                                           title="{{__('courses.Key Point') }} (2)"
                                                                           value="{{old('what_learn2',@$course->what_learn2)}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row">

                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label mt-1"
                                                                       for="">{{__('courses.Meta description')}}
                                                                       <i class="fas fa-info-circle" data-toggle="tooltip" title="•	Meta Description
                                      Description: Meta description is displayed in a search engine result. Insert a brief two-line summary or description of the course.
                                      "></i>
                                                                       </label>
                                                                <textarea id="my-textarea" class="primary_input_field tooltip_class"
                                                                          name="meta_description" style="height: 200px"
                                                                          rows="3"
                                                                           data-toggle="tooltip"
                                                                           title="{{__('courses.Meta description')}}">{!!@$course->meta_description!!}</textarea>
                                                            </div>

                                                        </div>

                                                    </div>
                    {{-- @if(auth()->user()->role_id==7)  --}}
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- <div class="form-group">
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 " style="width: 100%">
                                    <input name="declaration" type="checkbox" {{($course->declaration == 1)? 'checked' : ''}}>
                                    <span class="checkmark" data-toggle="tooltip" title="{{$course->declaration}}"></span>
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
                                                    <input type="hidden" name="update_course_status" id="updateCourseStatus" value="1" />
                                                    <input type="hidden" name="status_code" id="statusCodeUpdate" value="{{ isset($course->status) && $course->status == 2 ? 2 : 1}}" />

                                                    <div class="col-lg-12 text-center pt_15">
                                                        <div class="d-flex justify-content-center">
                                                            @if(isset($course) && $course->status == 1)
                                                                @if(isAdmin() || isHRDCorp() || isMyLL() || check_whether_cp_or_not() || isPartner())
                                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_course_details_status_1"  type="button"><i class="ti-check update_check"></i>
                                                                        <span class="btn_text">{{__('common.Next')}}</span>
                                                                        <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                    </button>
                                                                @else
                                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" type="button" disabled>
                                                                        <i class="ti-check update_check" ></i>
                                                                        <span class="btn_text">{{__('common.Next')}}</span>
                                                                        <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                    </button>
                                                                @endif
                                                            @else
                                                                @if(check_whether_cp_or_not() || isPartner() || isAdmin() || isHRDCorp() || isMyLL())
                                                                    @if(isset($course) && $course->status == 2)
                                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_course_details"  type="button"><i class="ti-check update_check"></i>
                                                                            <span class="btn_text">{{__('common.Next')}}</span>
                                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                        </button>
                                                                    @elseif(isset($course) && $course->status == 4)
                                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_course_details_status_4"  type="button"><i class="ti-check update_check"></i>
                                                                            <span class="btn_text">{{__('common.Next')}}</span>
                                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                        </button>
                                                                    @else
                                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent_course_details_status_0"  type="button"><i class="ti-check update_check"></i>
                                                                            <span class="btn_text">{{__('common.Next')}}</span>
                                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="submit"><i
                                                                            class="ti-check update_check"></i>
                                                                        <span class="btn_text_submit">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                                        <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                    <!-- End Individual Tab -->
                                    <div role="tabpanel" class="tab-pane fade  @if($type=="files") show active @endif "
                                         id="file_list">

                                        <div class="">
                                            <div class="row mb_20 mt-20">
                                                <div class="col-lg-2">

                                                    <ul class="d-flex">
                                                        <li><a data-toggle="modal" data-target="#addFile"
                                                               class="primary-btn radius_30px  fix-gr-bg" href="#"><i
                                                                    class="ti-plus"></i>{{__('common.Add')}} {{__('courses.Additional resources')}}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="modal fade admin-query" id="addFile">
                                                <div class="modal-dialog  modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('common.Add')}} {{__('courses.additional resources')}}</h4>
                                                            <button type="button" class="close" data-dismiss="modal"><i
                                                                    class="ti-close "></i></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="{{route('saveFile'). '?typeUpdateCourse='. $type}}" method="post"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{@$course->id}}">
                                                                <div class="primary_file_uploader">
                                                                    <input type="file" class="filepond"
                                                                           name="file"
                                                                           id=""
                                                                           required>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12 mt-20">
                                                                        <div class="primary_input">
                                                                            {{-- <label class="primary_input_label mt-1" for=""> {{__('common.Name')}} </label> --}}
                                                                            <input class="primary_input_field"
                                                                                   name="fileName" value="" required
                                                                                   placeholder="{{__('common.File')}} {{__('common.Name')}} *"
                                                                                   type="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12" style="display:none;">
                                                                        <select class="primary_select  mt-20"
                                                                                name="status"
                                                                                id="">
                                                                            <option
                                                                                data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                                                value="">{{__('common.Select')}} {{__('common.Status')}} </option>
                                                                            <option
                                                                                value="1"
                                                                                selected>{{__('courses.Active')}}</option>
                                                                            <option
                                                                                value="0">{{__('courses.Pending')}}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <select
                                                                            class="primary_select"
                                                                            name="lock" id="">
                                                                            <option
                                                                                data-display="{{__('common.Select')}} {{__('courses.Privacy')}}"
                                                                                value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                                                            <option value="0"
                                                                            >{{__('courses.Unlock')}}</option>
                                                                            <option value="1"
                                                                                    selected>{{__('courses.Locked')}}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div
                                                                            class="mt-40 d-flex justify-content-between">
                                                                            <button type="button"
                                                                                    class="primary-btn tr-bg"
                                                                                    data-dismiss="modal"> {{__('common.Cancel')}} </button>
                                                                            {{-- TODO: disable Add button when file uploading--}}
                                                                            <button class="primary-btn fix-gr-bg"
                                                                                    type="submit">{{__('common.Add')}}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="QA_section QA_section_heading_custom check_box_table hide_btn_tab">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table id="lms_table" class="table ">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.SL') }}</th>
                                                                <th scope="col">{{__('common.Name')}}</th>
                                                                <th scope="col">{{ __('common.Download') }}</th>
                                                                <th scope="col">{{ __('common.Action') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(count($course_exercises)==0)
                                                                <tr>
                                                                    <td colspan="4"
                                                                        class="text-center">{{__('courses.No Data Found')}}</td>
                                                                </tr>
                                                            @endif
                                                            @foreach($course_exercises as $key => $exercise_file)
                                                                <tr>
                                                                    <th>{{ $key+1 }}</th>

                                                                    <td>{{@$exercise_file->fileName }}</td>
                                                                    <td>

                                                                        @if (file_exists($exercise_file->file))


                                                                            <a style="font-weight: 460"
                                                                               href="{{route('download_course_file',[$exercise_file->id])}}">{{ __('common.Click To Download') }}</a>

                                                                        @else
                                                                            {{__('common.File Not Found')}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <!-- shortby  -->
                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button
                                                                                class="btn btn-secondary dropdown-toggle"
                                                                                type="button"
                                                                                id="dropdownMenu2"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                {{ __('common.Select') }}
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                aria-labelledby="dropdownMenu2">
                                                                                <a class="dropdown-item fileEditFrom"
                                                                                   data-toggle="modal"
                                                                                   data-item="{{$exercise_file}}"
                                                                                   data-target="#editFile"
                                                                                   href="#">{{__('common.Edit')}}</a>
                                                                                <a class="dropdown-item"
                                                                                   data-toggle="modal"
                                                                                   data-target="#deleteQuestionGroupModal{{$exercise_file->id}}"
                                                                                   href="#">{{__('common.Delete')}}</a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- shortby  -->
                                                                    </td>
                                                                </tr>


                                                                <div class="modal fade admin-query"
                                                                     id="deleteQuestionGroupModal{{$exercise_file->id}}">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">{{__('common.Delete')}} {{ __('courses.Additional resources') }}</h4>
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"><i
                                                                                        class="ti-close "></i></button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <div class="text-center">
                                                                                    <h4> {{__('common.Are you sure to delete ?')}}</h4>
                                                                                </div>

                                                                                <div
                                                                                    class="mt-40 d-flex justify-content-between">
                                                                                    <button type="button"
                                                                                            class="primary-btn tr-bg"
                                                                                            data-dismiss="modal">{{__('common.Cancel')}}</button>
                                                                                    {{ Form::open(['route' => 'deleteFile', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                                                                                    <input type="hidden" name="id"
                                                                                           value="{{$exercise_file->id}}">
                                                                                    <button
                                                                                        class="primary-btn fix-gr-bg"
                                                                                        type="submit">{{__('common.Delete')}}</button>
                                                                                    {{ Form::close() }}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center pt_15">
                                            @if(auth()->user()->role_id==7 || auth()->user()->role_id==8)
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12 " style="width: 100%">
                                                                <!-- <input name="declaration" id="cbxdeclaration" type="checkbox" {{old('declaration') == 'on'?'checked':''}} > -->
                                                                <input name="declaration" id="cbxdeclaration" type="checkbox" {{@$course->declaration == 1 ? 'checked':''}} >
                                                                <span class="checkmark"></span>
                                                                <span class="ml-2"><b>I hereby declare that all the above information is correct, accurate and not plagiarized from any party.</b></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-center">
                                                <a href="{{courseDetailsUrl($course->id, $course->type, $course->slug)}}" target="_blank" style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="preview_button"> {{__('Preview')}} {{__('courses.Course')}}
                                                </a>
                                                @if(check_whether_cp_or_not() || isPartner() || isAdmin() || isHRDCorp() || isMyLL())
                                                    @if((isAdmin() || isHRDCorp() || isMyLL()) && (isset($course) && $course->status ==1))
                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent"  type="button"><i class="ti-check update_check"></i>
                                                            <span class="btn_text">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                        </button>
                                                    @elseif(isset($course) && $course->status != 2 && $course->status != 4)
                                                        <button style="margin-right: 18px;background: grey" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent"  type="button" disabled>
                                                            <i class="ti-check update_check" ></i>
                                                            <span class="btn_text">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                        </button>
                                                    @else
                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="update_button_parent"  type="button"><i class="ti-check update_check"></i>
                                                            <span class="btn_text">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                            <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                        </button>
                                                    @endif
                                                    {{-- @php dd(isset($course), $course->detail_tab == 1, $course->curriculum_tab == 1, $course->certificate_tab == 1, $course->status == 2) @endphp --}}
                                                    @if(isset($course) && $course->detail_tab == 1 && $course->curriculum_tab == 1 && $course->certificate_tab == 1 && $course->status == 2 || $course->status == 4)
                                                        @if(isset($course) && !empty($course->lang_id) && !empty($course->title) && !empty($course->outcomes) && !empty($course->image) && !empty($course->requirements) && !empty($course->about) && !empty($course->trainer))
                                                        <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="button">
                                                            <i class="ti-check update_check"></i>
                                                            <span class="btn_text_submit">{{__('common.Submit')}} {{__('courses.Course')}}</span>
                                                            <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                        </button>
                                                        @else

                                                                <button style="margin-right: 18px;background:grey;pointer-events: none;" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="button" disabled>
                                                                    <i class="ti-check update_check"></i>
                                                                    <span class="btn_text_submit">{{__('common.Submit')}} {{__('courses.Course')}}</span>
                                                                    <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                </button>


                                                        @endif
                                                    @endif
                                                @else
                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="submit"><i
                                                            class="ti-check update_check"></i>
                                                        <span class="btn_text_submit">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                        <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel"
                                         class="tab-pane fade  @if($type=="certificate") show active @endif "
                                         id="certificate">

                                        <h2>{{__('subscription.Assign')}} {{__('certificate.Certificate')}}</h2>
                                        <div class="">

                                            <div class="white_box_30px">

                                                <form action="{{route('AdminUpdateCourseCertificate'). '?typeUpdateCourse='. $type}}" method="post" id="update_course_form">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{@$course->id}}">
                                                    <div class="row">
                                                        <div class="col-xl-6 courseBox">
                                                            <input type="hidden" name="certificate_tab" id="certificate_tab" value="{{$course->certificate_tab}}">
                                                            <select class="primary_select edit_category_id certificate_tab"
                                                                    data-course_id="{{@$course->id}}"
                                                                    name="certificate" id="course">

                                                                <option
                                                                    data-display="{{__('common.Select')}} {{__('certificate.Certificate')}}"
                                                                    value="">{{__('common.Select')}} {{__('certificate.Certificate')}} </option>
                                                                @foreach($certificates as $certificate)
                                                                    <option value="{{$certificate->id}}"
                                                                            @if ($certificate->id==$course->certificate_id) selected @endif>{{@$certificate->title}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                  {{--  <div class="col-lg-12 text-center pt_15">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                                    id="save_button_parent" type="submit">
                                                                <i class="ti-check"></i>{{__('common.Save')}} {{__('certificate.Certificate')}}
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                                </form>
                                            </div>

                                        </div>

                                    </div>

                                    <div role="tabpanel" class="tab-pane fade  @if($type=="drip") show active @endif "
                                         id="drip">

                                        <div class="QA_section QA_section_heading_custom check_box_table  pt-20">
                                            <div class="QA_table ">
                                                <form action="{{route('setCourseDripContent'). '?typeUpdateCourse='. $type}}" method="post">
                                                    <input type="hidden" name="course_id" value="{{$course->id}}">
                                                    @csrf
                                                    <table class="table  pt-0">
                                                        <thead>
                                                        <tr>
                                                            <th>{{__('common.Name')}}</th>
                                                            <th>{{__('common.Specific Date')}}</th>
                                                            <th></th>
                                                            <th>{{__('common.Days After Enrollment')}}</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @if(count($chapters)==0)
                                                            <tr>
                                                                <td colspan="3"
                                                                    class="text-center">{{__('courses.No Data Found')}}</td>
                                                            </tr>
                                                        @endif
                                                        @php
                                                            $i=0;
                                                        @endphp
                                                        @foreach($chapters as $key1 => $chapter)
                                                            @foreach ($chapter->lessons as $key => $lesson)
                                                                <input type="hidden" name="lesson_id[]"
                                                                       value="{{@$lesson->id}}">
                                                                <tr>
                                                                    <td>
                                                                        @if ($lesson->is_quiz==1)
                                                                            <span> <i class="ti-check-box"></i>   {{$key+1}}. {{@$lesson['quiz'][0]['title']}} </span>
                                                                        @else
                                                                            <span> <i class="ti-control-play"></i>  {{$key+1}}. {{$lesson['name']}} [{{MinuteFormat($lesson['duration'])}}] </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"
                                                                               class="primary_input_field primary-input date form-control"
                                                                               placeholder="{{__('common.Select Date')}}"
                                                                               readonly
                                                                               name="lesson_date[]"
                                                                               value="{{@$lesson->unlock_date!=""?date('m/d/Y',strtotime($lesson->unlock_date)):""}}">
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">


                                                                            <div class="form-check p-1">
                                                                                <input
                                                                                    class="form-check-input  common-radio"
                                                                                    type="radio"
                                                                                    name="drip_type[{{$i}}]"
                                                                                    id="select_drip_{{$i}}1"
                                                                                    value="1"
                                                                                    @if(!empty($lesson->unlock_date))checked @endif>
                                                                                <label class="form-check-label"
                                                                                       for="select_drip_{{$i}}1">
                                                                                    {{__('common.Date')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check  p-1">
                                                                                <input
                                                                                    class="form-check-input common-radio"
                                                                                    type="radio"
                                                                                    name="drip_type[{{$i}}]"
                                                                                    id="select_drip_{{$i}}2"
                                                                                    @if(empty($lesson->unlock_date))checked
                                                                                    @endif
                                                                                    value="2">
                                                                                <label class="form-check-label"
                                                                                       for="select_drip_{{$i}}2">
                                                                                    {{__('common.Days')}}
                                                                                </label>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" max="365"
                                                                               class="form-control"
                                                                               placeholder="{{__('common.Days')}}"
                                                                               name="lesson_day[]"
                                                                               value="{{@$lesson['unlock_days']}}">
                                                                    </td>

                                                                </tr>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endforeach



                                                        @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        @if(count($chapters)!=0)
                                                            <tr>
                                                                <td colspan="3">
                                                                    <button class="primary-btn fix-gr-bg" type="submit"
                                                                            data-toggle="tooltip">
                                                                        <span class="ti-check"></span>
                                                                        {{__('common.Save')}}
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        </tfoot>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade admin-query"
         id="editFile">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Edit') }} {{ __('courses.Additional resources') }}</h4>
                    <button type="button" class="close"
                            data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('updateFile'). '?typeUpdateCourse='. $type}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id"
                               value="" class="editFileId">

                        <div class="">
                            <input type="file"
                                   class="filepond"
                                   name="file">


                        </div>
                        <div class="row">

                            <div class="col-xl-12 mt-20">
                                <div class="primary_input">
                                    <input
                                        class="primary_input_field editFileName"
                                        name="fileName"
                                        required
                                        value=""

                                        placeholder="{{__('common.File')}} {{__('common.Name')}}"
                                        type="text">
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12 mt-20 ">
                                <select
                                    class="primary_select editFilePrivacy"
                                    name="lock" id="">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('courses.Privacy')}}"
                                        value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                    <option value="0"
                                    >{{__('courses.Unlock')}}</option>
                                    <option value="1"
                                    >{{__('courses.Locked')}}</option>

                                </select>
                            </div>
                            <div class="col-12 mt-25">
                                <select
                                    class="primary_select editFileStatus"
                                    name="status" id="">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                        value="">{{__('common.Select')}} {{__('common.Status')}} </option>
                                    <option value="1"
                                    >{{__('courses.Active')}}</option>
                                    <option value="0"
                                    >{{__('courses.Pending')}}</option>
                                </select>
                            </div>

                        </div>

                        <div
                            class="mt-40 d-flex justify-content-between">
                            <button type="button"
                                    class="primary-btn tr-bg"
                                    data-dismiss="modal"> {{__('common.Cancel')}} </button>
                            <button
                                class="primary-btn fix-gr-bg"
                                type="submit">{{__('common.Update')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if(isModuleActive('Org'))
        <div class="modal fade admin-query" id="orgExistingFileSelect">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('org.Select Material')}}</h4>
                        <button type="button" class="close " data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data" id="materialSourceInsertForm">
                            <input type="hidden" id="addCategory" name="category">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-effect mt-2 pt-1">
                                        <select class="primary_select AddSelectCateogry"
                                                name="category">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.Category')}}"
                                                value="">{{__('common.Select')}} {{__('org.Category')}} </option>
                                            @foreach($categories as $category)
                                                @if($category->parent_id==0)
                                                    @include('org::category._single_select_option',['category'=>$category,'level'=>1])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="input-effect mt-2 pt-1">
                                        <select class="primary_select "
                                                name="file"
                                                id="AddSelectFile">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.File')}}"
                                                value="">{{__('common.Select')}} {{__('org.File')}} </option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center pt_15">


                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{__('common.Cancel')}}</button>
                                    <button class="primary-btn semi_large2  fix-gr-bg" id="MaterialFileInsert"
                                            type="button"><i
                                            class="ti-check"></i> {{__('common.Add')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade admin-query" id="orgNewFileSelect">
            <div class="modal-dialog modal_700px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('org.Add New Material')}}</h4>
                        <button type="button" class="close " data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data" id="materialSourceAddForm">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('common.Type')}} <strong
                                                class="text-danger">*</strong></label>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typeVideo"
                                                       name="type"
                                                       checked
                                                       value="Video">
                                                <label
                                                    for="typeVideo">{{__('org.Video')}}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typeExcel"
                                                       name="type"
                                                       value="Excel">
                                                <label
                                                    for="typeExcel">{{__('org.Excel')}}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typePPT"
                                                       name="type"
                                                       value="PPT">
                                                <label
                                                    for="typePPT">{{__('org.PPT')}}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typeDoc"
                                                       name="type"
                                                       value="Doc">
                                                <label
                                                    for="typeDoc">{{__('org.Doc')}}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typePDF"
                                                       name="type"

                                                       value="PDF">
                                                <label
                                                    for="typePDF">{{__('org.PDF')}}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio"
                                                       class="common-radio "
                                                       id="typeSCORM"
                                                       name="type"
                                                       value="SCORM">
                                                <label
                                                    for="typeSCORM">{{__('org.SCORM')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-25">
                                        <div class="col-md-12">
                                            <div class="primary_file_uploader">
                                                <input type="file" class="filepond"
                                                       name="file"
                                                       id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('org.Category')}} <strong
                                                class="text-danger">*</strong></label>
                                        <select class="primary_select AddSelectCateogry"
                                                name="category">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.Category')}}"
                                                value="">{{__('common.Select')}} {{__('org.Category')}} </option>
                                            @foreach($categories as $category)
                                                @if($category->parent_id==0)
                                                    @include('org::category._single_select_option',['category'=>$category,'level'=>1])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center pt_15">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">{{__('common.Cancel')}}</button>
                                    <button class="primary-btn semi_large2  fix-gr-bg" id="MaterialFileSave"
                                            type="button"><i
                                            class="ti-check"></i> {{__('common.Add')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                $(document).on('change click', '.fileType', function (e) {

                    var type = $(this).val();
                    if (type == 1) {
                        $('#orgExistingFileSelect').modal('show');
                        $('.selectOrgFile').show();
                        $('.defaultHost').addClass('d-none');
                    } else if (type == 2) {
                        $('.selectOrgFile').hide();
                        $('.defaultHost').removeClass('d-none');
                        $('.host_select').trigger('change');
                    } else {
                        $('.selectOrgFile').show();
                        $('#orgNewFileSelect').modal('show');
                        $('.defaultHost').addClass('d-none');
                    }
                });

                $(document).on('change click', '#MaterialFileInsert', function (e) {
                    // e.preventDefault();
                    var category = $('.AddSelectCateogry  option:selected').val();
                    var file = $('#AddSelectFile option:selected').val();
                    if (category == "") {
                        toastr.error('Please select category', 'Error');
                        return false;

                    }

                    if (file == "") {
                        toastr.error('Please select file', 'Error');
                        return false;

                    }
                    var formData = {
                        id: file,
                    };
                    $.ajax({
                        type: "GET",
                        url: "{{route('org.ajaxMaterialSourceGet')}}",
                        data: formData,
                        success: function (data) {
                            $('.FilePath').val(data.link);
                            $('.FileType').val(data.type);

                            $('#orgExistingFileSelect').modal('hide');
                        }
                    });
                });

                $(document).on('change click', '#MaterialFileSave', function (e) {
                    // e.preventDefault();
                    var category = $('.AddNewSelectCateogry  option:selected').val();

                    if (category == "") {
                        toastr.error('Please select category', 'Error');
                        return false;
                    }


                    $.ajax({
                        type: "POST",
                        url: "{{route('org.ajaxMaterialSourceSave')}}",
                        data: $('#materialSourceAddForm').serialize(),
                        success: function (data) {

                            $('.FilePath').val(data.link);
                            $('.FileType').val(data.type);
                            $('#orgNewFileSelect').modal('hide');


                        }
                    });
                });

                $(document).on('change', '.AddSelectCateogry', function (e) {
                    var category = $(".AddSelectCateogry option:selected").val();


                    var url = "{{route('org.getFilesByCategory')}}";

                    var formData = {
                        category: category,
                    };
                    // get section for student
                    $.ajax({
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        url: url,
                        success: function (data) {
                            $('#AddSelectFile').empty();
                            $('#AddSelectFile').append($('<option>', {
                                value: '',
                                text: 'Select File',
                            }));
                            $.each(data, function (i, item) {
                                $('#AddSelectFile').append($('<option>', {
                                    value: item.id,
                                    text: item.title,
                                }));
                            });
                            $('#AddSelectFile').niceSelect('update');


                        },
                        error: function (data) {
                            console.log("Error:", data);
                            $('#AddSelectFile').niceSelect('update');
                        },
                    });

                });

            </script>
        @endpush
    @endif

    <input type="hidden" id="branchSelectType">
    <input type="hidden" id="branchName">
@endsection



@push('scripts')
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/advance_search.js"></script>

    <script>
        $('select').each(function(){
            var tooltip_text = $(this).attr('title');
            $(this).next('div').attr('title',tooltip_text)
        });

    </script>

    <script>
        $('.nastable').sortable({
            cursor: "move",
            connectWith: [".nastable", ".nastable2"],

            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {attribute: 'data-id'});

                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.get("{{route('changeChapterPosition')}}", data, function (data) {

                    });
                }
            }
        });

        $('.nastable2').sortable({
            cursor: "move",
            connectWith: ".nastable2",
            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {attribute: 'data-id'});
                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{route('changeLessonPosition')}}", data, function (data) {

                    });
                }
                ordering();
            }, receive: function (event, ui) {
                var chapter_id = event.target.attributes[1].value;
                var lesson = ui.item[0].attributes[1].value;


                let data = {
                    'chapter_id': chapter_id,
                    'lesson_id': lesson,
                    '_token': '{{ csrf_token() }}'
                }
                $.post("{{route('changeLessonChapter')}}", data, function (data) {

                });
            }
        });

        function ordering() {
            var chepters = $('.nastable2');
            chepters.each(function () {
                var childs = $(this).find(".serial");
                childs.each(function (k, v) {
                    $(this).html(k + 1);
                });
            });
        }
    </script>



    <script>
        @if($course->type==2)
        $(".courseBox").hide();
        $(".quizBox").show();
        $(".makeResize").addClass("col-xl-6");
        $(".makeResize").removeClass("col-xl-4");
        @endif

        $(".type1").on("click", function () {
            if ($('.type1').is(':checked')) {
                $(".courseBox").show();
                $(".quizBox").hide();
                $(".dripCheck").show();
                $("#quiz_id").val('');
                $(".makeResize").addClass("col-xl-4");
                $(".makeResize").removeClass("col-xl-6");
            }
        });

        $(".type2").on("click", function () {
            if ($('.type2').is(':checked')) {
                $(".courseBox").hide();
                $(".quizBox").show();
                $(".dripCheck").hide();

                $(".makeResize").addClass("col-xl-6");
                $(".makeResize").removeClass("col-xl-4");
            }
        });
        //
        // durationBox


        $(document).ready(function () {

            var start_date = $("#discount_start_date").val();
            if(start_date!=""){
                $("#discount_end_date").attr("min", start_date);
            }

            $("#discount_start_date").change(function(){
                $("#discount_end_date").attr("min", $(this).val());
            });

            $('#select_input_type').change(function () {
                console.log('selected');
                if ($(this).val() === '1') {

                    $(".chapter_div").css("display", "block");
                    $(".lesson_div").css("display", "none");
                    $(".quiz_div").css("display", "none");

                } else if ($(this).val() === '2') {

                    $(".chapter_div").css("display", "none");
                    $(".lesson_div").css("display", "none");
                    $(".quiz_div").css("display", "block");

                } else {
                    $(".chapter_div").css("display", "none");
                    $(".lesson_div").css("display", "block");
                    $(".quiz_div").css("display", "none");
                }
            });


            $('#category_id').change(function () {
                let category_id = $('#category_id').find(":selected").val();
                console.log("Host : " + category_id);
                if (category_id === 'Youtube' || category_id === 'URL') {
                    $("#iframeBox").hide();
                    $("#videoUrl").show();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();

                } else if ((category_id === 'Self') || (category_id === 'Zip') || (category_id === 'PowerPoint') || (category_id === 'Excel') || (category_id === 'Text') || (category_id === 'Word') || (category_id === 'PDF') || (category_id === 'Image') || (category_id === 'AmazonS3') || (category_id === 'SCORM') || (category_id === 'SCORM-AwsS3')) {

                    $("#iframeBox").hide();
                    $("#fileupload").show();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#VdoCipherUrl").hide();

                } else if (category_id === 'Vimeo') {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").show();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                } else if (category_id === 'VdoCipher') {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").show();
                } else if (category_id === 'Iframe') {
                    $("#iframeBox").show();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                } else {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                }

            });


            $('#category_id1').change(function () {

                let category_id1 = $('#category_id1').find(":selected").val();
                console.log("Host : " + category_id1);
                if (category_id1 === 'Youtube') {
                    $("#videoUrl1").show();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();

                } else if ((category_id1 === 'Self') || (category_id === 'Document') || (category_id === 'Image') || (category_id1 === 'AmazonS3') || (category_id1 === 'SCORM') || (category_id1 === 'SCORM-AwsS3')) {
                    $("#fileupload1").show();
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');

                } else if (category_id1 === 'Vimeo') {
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").show();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                } else {
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                }
            });


            @if(empty(@$editLesson))
            $('.category_id').trigger('change');
            @endif
            // $('#category_id1').trigger('change');

        });


        $(document).on('click', '.fileEditFrom', function () {

            let file = $(this).data('item');
            var IdElement = $('.editFileId');
            var NameFileElement = $('.editFileName');
            var PrivacyElement = $('.editFilePrivacy');
            var StatusElement = $('.editFileStatus');
            IdElement.val(file.id);
            NameFileElement.val(file.fileName);
            PrivacyElement.val(file.lock);
            StatusElement.val(file.status);

            PrivacyElement.niceSelect('update');
            StatusElement.niceSelect('update');


        })

    </script>

    <script>
        $('.lms_summernote_course_details_1').summernote({
            placeholder: '',
            tabsize: 2,
            height: 150,
            tooltip: true,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files, '.lms_summernote_course_details_1')
                }
            },
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
            placeholder: '',
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
        $('textarea.tooltip_class').each(function(){
            var tooltip_text = $(this).attr('title');
            $(this).next('div.note-editor').find('.note-editing-area').find('.note-editable').attr('title',tooltip_text)
        });
    </script>
    <script>
        getVdoCipherIist();
        getVdoCipherIistForLesson();

        function getVdoCipherIist() {
            let vdocipherList = $('.vdocipherList');

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
        }

        function getVdoCipherIistForLesson() {
            let vdocipherList = $('.lessonVdocipher');

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
        }


        $(document).ready(function () {

            var certificate_tab = $("#certificate_tab").val();

            if(certificate_tab == 1){
                $(".certificate_tab").attr('disabled', true);
                $(".certificate_tab").niceSelect('update');
            }

            var id = $(".vdocipherListForCourse option:selected").val();
            if (id != "") {
                $.ajax({
                    url: "{{url('admin/course/vdocipher/video')}}/" + id,
                    success: function (data) {
                        $(".vdocipherListForCourse option:selected").text(data.title)
                        getVdoCipherIist();
                    },
                    error: function () {
                        console.log('failed')
                    }
                });
            }


            $('.VdoCipherVideoLesson').each(function (i, obj) {

                var lessonId = $(this).find('option:selected').val();
                if (lessonId != "") {
                    $.ajax({
                        url: "{{url('admin/course/vdocipher/video')}}/" + lessonId,
                        success: function (data) {
                            $(".lessonVdocipher option:selected").text(data.title)
                            getVdoCipherIistForLesson();
                        },
                        error: function () {
                            console.log('failed')
                        }
                    });
                }
            });
            /*    var lessonId = $("#VdoCipherVideoLesson option:selected").val();
                if (lessonId != "") {
                    $.ajax({
                        url: "{{url('admin/course/vdocipher/video')}}/" + lessonId,
                    success: function (data) {
                        $(".lessonVdocipher option:selected").text(data.title)
                        getVdoCipherIistForLesson();
                    },
                    error: function () {
                        console.log('failed')
                    }
                });
            }*/


        });
        @if(isset($editLesson))
        var editLesson = $('#category_id_edit_{{$editLesson->id}}');
        editLesson.trigger('change');

        //   $('.fileType').find()
        var type = $('.fileType:checked').val();
        if (type == 2) {
            $('.fileType:checked').trigger('click');
        }
        @endif

    </script>
    @php
        if(isset($_GET["type"])){
            Session::put('typeCourse',$_GET["type"]);
        }
    @endphp
    <script>
        $(document).ready(function(){
            var type = '<?= !empty(Session::get('typeCourse')) ? Session::get('typeCourse') : (isset($_GET["type"]) && !empty($_GET["type"]) ? $_GET["type"] : $type); ?>';
            $('a[href="#indivitual_email_sms"]').click(function () {
                let nextURL = new URL(window.location.href);
                if (window.location.href.indexOf("type") > -1) {
                    nextURL.searchParams.set('type', 'courseDetails');
                    window.history.replaceState(null, null, nextURL);
                } else {
                    let nextURL = window.location.href + "?type=courseDetails";
                    window.history.pushState(null, null, nextURL);
                }

                setTypeCourseSession('courseDetails');
            });
            $('a[href="#group_email_sms"]').click(function () {
                let nextURL = new URL(window.location.href);
                if (window.location.href.indexOf("type") > -1) {
                    nextURL.searchParams.set('type', 'courses');
                    window.history.replaceState(null, null, nextURL);
                } else {
                    let nextURL = window.location.href + "?type=courses";
                    window.history.pushState(null, null, nextURL);
                }
                setTypeCourseSession('courses');
            });
            $('a[href="#file_list"]').click(function () {
                let nextURL = new URL(window.location.href);
                if (window.location.href.indexOf("type") > -1) {
                    nextURL.searchParams.set('type', 'files');
                    window.history.replaceState(null, null, nextURL);
                } else {
                    let nextURL = window.location.href + "?type=files";
                    window.history.pushState(null, null, nextURL);
                }
                setTypeCourseSession('files');
            });
            $('a[href="#certificate"]').click(function () {
                let nextURL = new URL(window.location.href);
                if (window.location.href.indexOf("type") > -1) {
                    nextURL.searchParams.set('type', 'certificates');
                    window.history.replaceState(null, null, nextURL);
                } else {
                    let nextURL = window.location.href + "?type=certificates";
                    window.history.pushState(null, null, nextURL);
                }
                setTypeCourseSession('certificates');
            });
            if (type == 'courseDetails') {
                $("#indivitual_email_sms").addClass("active").addClass("show");
                $(".details_tab").addClass('active');
                $("#group_email_sms").removeClass("active").removeClass("show");
                $('.curriculum_tab').removeClass("active");
                $("#file_list").removeClass("active").removeClass("show");
                $('.exercise_tab').removeClass("active");
                $("#certificate").removeClass("active").removeClass("show");
                $('.certificate_tab').removeClass("active");
            }
            if (type == 'courses') {
                $("#indivitual_email_sms").removeClass("active").removeClass("show");
                $(".details_tab").removeClass('active');
                $("#group_email_sms").addClass("active").addClass("show");
                $('.curriculum_tab').addClass("active");
                $("#file_list").removeClass("active").removeClass("show");
                $('.exercise_tab').removeClass("active");
                $("#certificate").removeClass("active").removeClass("show");
                $('.certificate_tab').removeClass("active");
            }
            if (type == 'files') {
                $("#indivitual_email_sms").removeClass("active").removeClass("show");
                $(".details_tab").removeClass('active');
                $("#group_email_sms").removeClass("active").removeClass("show");
                $('.curriculum_tab').removeClass("active");
                $("#file_list").addClass("active").addClass("show");
                $('.exercise_tab').addClass("active");
                $("#certificate").removeClass("active").removeClass("show");
                $('.certificate_tab').removeClass("active");
            }
            if (type == 'certificates') {
                $("#indivitual_email_sms").removeClass("active").removeClass("show");
                $(".details_tab").removeClass('active');
                $("#group_email_sms").removeClass("active").removeClass("show");
                $('.curriculum_tab').removeClass("active");
                $("#file_list").removeClass("active").removeClass("show");
                $('.exercise_tab').removeClass("active");
                $("#certificate").addClass("active").addClass("show");
                $('.certificate_tab').addClass("active");
            }

            function setTypeCourseSession(type) {
                $.ajax({
                    url: "{{ route('courseDetailsSetSession') }}",
                    type: "GET",
                    data: {
                        type: type,
                    },
                    success: function (response) {
                    },
                    error: function (response) {
                    }
                });
            }


            $("#update_button_parent").click(function(){
                @if(isset($course) && $course->status == 2)
                    $('#statusCodeUpdate').attr('value','2');
                    $('#updateCourseStatus').attr('value',2);
                @elseif(isset($course) && $course->status == 4)
                    $('#statusCodeUpdate').attr('value','4');
                    $('#updateCourseStatus').attr('value',4);
                @elseif(isset($course) && $course->status == 1)
                    $('#statusCodeUpdate').attr('value','1');
                    $('#updateCourseStatus').attr('value',2);
                @endif
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });

            $("#update_button_parent_course_details").click(function(){
                $('#statusCodeUpdate').attr('value','2');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_course_details_status_0").click(function(){
                $('#statusCodeUpdate').attr('value','0');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_course_details_status_4").click(function(){
                $('#statusCodeUpdate').attr('value','4');
                $('input[name="status_code"]').attr('value','4');
                var cal = $('input[name="status_code"]').val();
                console.log(cal)
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_course_details_status_1").click(function(){
                $('#statusCodeUpdate').attr('value','1');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });

            $("#update_button_parent_curriculum_tab").click(function(){
                $('#statusCodeUpdate').attr('value','2');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_curriculum_tab_status_0").click(function(){
                $('#statusCodeUpdate').attr('value','0');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_curriculum_tab_status_4").click(function(){
                $('#statusCodeUpdate').attr('value','4');
                ajaxforcoursevalidation();
            });
            $("#update_button_parent_curriculum_tab_status_1").click(function(){
                $('#statusCodeUpdate').attr('value','1');
                // $("#updateCourseForm").submit(); // Submit the form
                ajaxforcoursevalidation();
            });

            $("#submit_button_parent").click(function(){
                if($("#cbxdeclaration").prop('checked') == true || !$("#cbxdeclaration").length){
                    $('#statusCodeUpdate').attr('value','1');
                    $('#updateCourseStatus').attr('value',2);
                    // $("#addCourseForm").submit(); // Submit the form
                    ajaxforcoursevalidation();
                }else{
                    toastr.error("Please agree to the terms & conditions");
                }
            });
            $('.select2-multiple').select2({
                width: "100%",
                allowClear: false,
            });

            $("#trainer_img").change(function(){
                if (!$(this).val() || !$("#input_trainer_img").val()) {
                    $(".remove_btn").show();
                } else {
                    $(".remove_btn").hide();
                }
            });

            $('.remove_btn').click(function() {
                $("#input_trainer_img").val('');
                $("#trainer_img").val('');
                $(".remove_btn").hide();

            });
        });

        function loaderstop(){
            // $('.btn_text').text('Update Course');
            // $('.update_check').addClass('ti-check');
            $('#update_button_parent').prop('disabled', false);
            $("#update_button_parent_course_details_status_4").prop("disabled", false);
            $("#update_button_parent_curriculum_tab_status_4").prop("disabled", false);
            $("#update_button_parent_course_details_status_1").prop("disabled", false);
            $("#update_button_parent_curriculum_tab_status_1").prop("disabled", false);
            $('.loading-spinner').removeClass('active');
        }
        function loaderstart(){
            // $('.btn_text').text('');
            // $('.update_check').removeClass('ti-check');
            $('#update_button_parent').prop('disabled', true);
            $("#update_button_parent_course_details_status_4").prop("disabled", true);
            $("#update_button_parent_curriculum_tab_status_4").prop("disabled", true);
            $("#update_button_parent_course_details_status_1").prop("disabled", true);
            $("#update_button_parent_curriculum_tab_status_1").prop("disabled", true);
            $('.loading-spinner').addClass('active');
        }
        function submitloaderstop(){
            // $('.btn_text_submit').text('Submit Course');
            // $('.submit_check').addClass('ti-check');
            //$('#submit_button_parent').prop('disabled', false);
            $('.submit-loading-spinner').removeClass('active');
        }
        function submitloaderstart(){
            // $('.btn_text_submit').text('');
            // $('.submit_check').removeClass('ti-check');
            //$('#submit_button_parent').prop('disabled', true);
            $('.submit-loading-spinner').addClass('active');
        }

        function ajaxforcoursevalidation() {
          var formData = new FormData(document.getElementById("updateCourseForm"));
          var btn = $('#statusCodeUpdate').val();

            var addPrice = $('#addPrice').val();
            var addDiscount = $('#addDiscount').val();
            if ($('#edit_course_3').is(':checked')) {
                if(addPrice!="" && addDiscount!=""){
                    if(parseInt(addDiscount)>parseInt(addPrice)){
                        toastr.error("The Discount price more that original price!");
                        return false;
                    }
                }
            }
            
          if(btn == 2 || btn == 4 || btn == 1)
              loaderstart();
          if(btn == 1)
              submitloaderstart();
            $.ajax({
                type: "POST",
                url: "{{route('AdminUpdateCourseValidation')}}",
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
                            if(btn == 2 || btn == 4 || btn == 1)
                                loaderstop();
                            if(btn == 1)
                                submitloaderstop();
                        }
                    }
                    if(data.status == 1)
                    {
                      $("#updateCourseForm").submit();
                      setInterval(function () {
                          if(btn == 2 || btn == 4 || btn == 1)
                              loaderstop();
                          if(btn == 1)
                              submitloaderstop();
                      }, 20000);
                    }
                }
              }).done( function( data ) {

            });
        }
        function tabchange(index) {
            if(index == 2){
                toastr.error('Please update course details first', 'Error');
                setInterval(function () {
                    // $('.curriculum_tab').removeClass("active");
                    $('.ul_tab_list .nav-item .nav-link').removeClass("active");
                    activePanel();
                    // $('.details_tab').addClass("active");
                }, 2000);
            }
            if(index == 3){
                toastr.error('Please update course curriculum first', 'Error');
                setInterval(function () {
                    // $('.exercise_tab').removeClass("active");
                    $('.ul_tab_list .nav-item .nav-link').removeClass("active");
                    activePanel();
                    // var data = $('#curriculum_hidden').val();
                    // if(data == 1){
                    //     $('.curriculum_tab').addClass("active");
                    // }
                    // else{
                    //     $('.details_tab').addClass("active");
                    // }
                }, 2000);
            }
            if(index == 4){
                toastr.error('Please update additional resources first', 'Error');
                setInterval(function () {
                    // $('.certificate_tab').removeClass("active");
                    $('.ul_tab_list .nav-item .nav-link').removeClass("active");
                    activePanel();
                    // var data = $('#exercise_hidden').val();
                    // if(data == 1){
                    //     $('.exercise_tab').addClass("active");
                    // }
                    // else{
                    //     $('.details_tab').addClass("active");
                    // }
                }, 2000);
            }
        }
        function activePanel() {
            var tab1 = $("#indivitual_email_sms").hasClass("active");
            if(tab1){
                $('.details_tab').addClass("active");
            }
            var tab2 = $("#group_email_sms").hasClass("active");
            if(tab2){
                $('.curriculum_tab').addClass("active");
            }
            var tab3 = $("#file_list").hasClass("active");
            if(tab3){
                $('.exercise_tab').addClass("active");
            }
            var tab4 = $("#certificate").hasClass("active");
            if(tab4){
                $('.certificate_tab').addClass("active");
            }
        }
    </script>
@endpush

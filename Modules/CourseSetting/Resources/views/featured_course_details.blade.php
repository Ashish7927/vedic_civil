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
                                           
                                        </div>

                                    </div>

                                    <div role="tabpanel"
                                         class="tab-pane fade
                                            @if($type=="courseDetails") show active @endif
                                             "
                                         id="indivitual_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <form action="{{route('AdminUpdateFeaturedCourse'). '?typeUpdateCourse='. $type}}" method="POST" id="updateCourseForm"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                {{-- <input type="hidden" name="status_code" id="statusCodeUpdate" value="1" /> --}}
                                                <div class="row">
                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id!=1 && \Illuminate\Support\Facades\Auth::user()->role_id!=7 )
                                                    
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

                                                
                      

                                                </div>
                                                <input type="hidden" name="id" class="course_id"
                                                       value="{{@$course->id}}">
                                                <div class="col-xl-12 p-0">
                                                    
                                                    



                                                    <div class="col-xl-12 courseBox mb-25">
                                                        <div class="primary_input  ">

                                                            <div class="row  ">
                                                                <div class="col-md-12">
                                                                    <label class="primary_input_label mt-1"
                                                                           for=""> Featured Course</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="feature0">
                                                                    <input type="radio"
                                                                           class="common-radio feature0"
                                                                           id="feature0"
                                                                           name="feature"
                                                                           value="0" {{@$course->feature==0?"checked":""}}>
                                                                        <span class="checkmark mr-2" data-toggle="tooltip" title="0"></span>      {{__('common.No')}}</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">

                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="feature1">
                                                                    <input type="radio"
                                                                           class="common-radio feature1"
                                                                           id="feature1"
                                                                           name="feature"
                                                                           value="1" {{@$course->feature==1?"checked":""}}>


                                                                        <span
                                                                         data-toggle="tooltip" title="1"
                                                                         class="checkmark mr-2"></span> {{__('common.Yes')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                  
                                                    <input type="hidden" name="update_course_status" id="updateCourseStatus" value="1" />
                                                    <input type="hidden" name="status_code" id="statusCodeUpdate" value="{{ isset($course->status) && $course->status == 2 ? 2 : 1}}" />

                                                    <div class="col-lg-12 text-center pt_15">
                                                        <div class="d-flex justify-content-center">
                                                            
                                                                @if(check_whether_cp_or_not() || isPartner() || isAdmin() || isHRDCorp() || isMyLL())
                                                                   
                                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="submit"><i
                                                                            class="ti-check update_check"></i>
                                                                        <span class="btn_text_submit">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                                        <i class="submit-loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                                                    </button>
                                                                @endif
                                                        
                                                        </div>
                                                    </div>
                                                </div>
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
    </section>

    <input type="hidden" id="branchSelectType">
    <input type="hidden" id="branchName">
@endsection



@push('scripts')
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/advance_search.js"></script>

    <script>
        $('textarea.tooltip_class').each(function(){
            var tooltip_text = $(this).attr('title');
            $(this).next('div.note-editor').find('.note-editing-area').find('.note-editable').attr('title',tooltip_text)
        });
    </script>
  
    @php
        if(isset($_GET["type"])){
            Session::put('typeCourse',$_GET["type"]);
        }
    @endphp
    <script>
        $(document).ready(function(){
            
            $("#submit_button_parent").click(function(){
                $("#updateCourseForm").submit();
                // if($("#cbxdeclaration").prop('checked') == true || !$("#cbxdeclaration").length){
                //     $('#statusCodeUpdate').attr('value','1');
                //     $('#updateCourseStatus').attr('value',2);
                //     // $("#addCourseForm").submit(); // Submit the form
                //   //  ajaxforcoursevalidation();
                // }else{
                //     toastr.error("Required Field!");
                // }
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

    </script>
@endpush

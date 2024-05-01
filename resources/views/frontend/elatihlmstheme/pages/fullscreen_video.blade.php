@extends(theme('layouts.full_screen_master'))
@section('title')
    {{ Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS' }} | {{ $course->title }}
@endsection
@section('css')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme/css/full_screen.css') }}?{{ $version }}"/>
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme/css/class_details.css') }}?{{ $version }}"/>
    <link rel="stylesheet" href="{{ asset('public/backend/css/summernote-bs4.min.css') }}?{{ $version }}">
    <style>
        body {
            overflow-y: hidden;
        }

        .default-font {
            font-family: "Jost", sans-serif;
            font-weight: normal;
            font-style: normal;
            font-weight: 400;
        }

        .primary_checkbox {
            z-index: 99;
        }

        .success_text {
            color: #20e007 !important;
        }

        .error_text {
            color: var(--system_primery_color) !important;
        }

        @media (max-width: 767.98px) {
            .contact_btn {
                margin: 0 !important;
                justify-content: space-between;
            }

            .mobile_progress {
                margin: 0 !important;
            }

            #video-placeholder {
                height: 300px;
            }

            body {
                overflow-y: scroll;
            }

            .card-body {
                margin: 40px
            }
        }

        .matching_question li label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .matching_question li label span {
            max-width: 107px;
            overflow-wrap: break-word;
        }

        .matching_question li label .quizAns {
            width: 61%;
            margin-left: 10px;
        }

        .matching_question li .option_lable_mt {
            justify-content: end;
        }
    </style>
@endsection

@section('mainContent')
    @push('js')
        <script>
            var completeRequest = false;
        </script>
    @endpush

    @php
        if ($lesson->lessonQuiz->random_question == 1) {
            $questions = $lesson->lessonQuiz->assignRand;
        } else {
            $questions = $lesson->lessonQuiz->assign;
       }
    @endphp
    <header>
        <div id="sticky-header" class="header_area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="header__wrapper flex-wrap">
                            <!-- header__left__start  -->
                            <div class="header__left d-flex align-items-center">
                                <div class="logo_img">
                                    <a href="{{url('/')}}">
                                        <img class="p-2" style="width: 200px"
                                             src="{{getCourseImage(Settings('logo') )}}"
                                             alt="{{ Settings('site_name')  }}">
                                    </a>
                                </div>

                                <div class="category_search d-flex category_box_iner">
                                    <div class="input-group-prepend2 pl-3 ">
                                        <a class="headerTitle"
                                           href="{{ courseDetailsUrl($course->id,$course->type,$course->slug) }}"
                                           style="padding-top: 3px;">
                                            <h4 class="headerTitle">{{$course->title}}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="header__right">
                                <div class="contact_wrap d-flex align-items-center flex-wrap">
                                    <div class="contact_btn d-flex align-items-center flex-wrap">
                                        @if (isset($lessons))
                                            <label class="lmsSwitch_toggle  pr-2" for="autoNext">
                                                <input type="checkbox" id="autoNext" checked>
                                                <div class="slider round"></div>
                                            </label>
                                            <span class="pl-2 text-nowrap">Auto Next</span>

                                            <div class="pl-20 text-right ml-3 d-flex align-items-center">
                                                @php
                                                    $last_key=array_key_last($lesson_ids);
                                                    $last_previous_one=array_key_last($lesson_ids)-1;
                                                    $current_page=(int)showPicName(Request::url());
                                                    $current_index=array_search(showPicName(Request::url()), $lesson_ids);
                                                @endphp
                                                @if (0==array_search($current_page,$lesson_ids))
                                                    <a href="#" disabled="disabled"
                                                       class="theme_btn theme_button_disabled small_btn2 p-2 m-1 disabled">Previous</a>
                                                @else
                                                    <a href="#"
                                                       onclick="goFullScreen({{$course->id}},{{$lesson_ids[$current_index-1]}})"
                                                       class="theme_btn small_btn2 p-2 m-1">Previous</a>
                                                @endif

                                                @if (array_search($current_page,$lesson_ids) < array_search(end($lesson_ids),$lesson_ids) )
                                                    <a href="#" id="next_lesson_btn"
                                                       onclick="goFullScreen({{$course->id}},{{$lesson_ids[$current_index+1]}})"
                                                       class="theme_btn small_btn2 p-2 m-1">Next</a>
                                                @else
                                                    <a href="#" disabled
                                                       class="theme_btn theme_button_disabled small_btn2 p-2 m-1 disabled"
                                                       style="opacity: 1">Next</a>
                                                @endif
                                            </div>
                                        @endif

                                        @if (Auth::check())
                                            @if (Auth::user()->role_id==3)
                                                @if (!in_array(Auth::user()->id,$reviewer_user_ids))
                                                    <a href="" data-toggle="modal"
                                                       data-target="#courseRating"
                                                       class="  headerSub p-2 mr-3 text-nowrap">
                                                        <i class="fa fa-star pr-2"></i>
                                                        {{__('frontend.Leave a rating')}}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif

                                        <a href="" class="mr-3 ml-3 mobile_progress">
                                            <div class="progress p-2" data-percentage="{{$percentage}}">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div class="headerSubProcess">
                                                        {{$percentage}}%
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="#" data-toggle="modal"
                                           data-target="#ShareLink"
                                           class="theme_btn small_btn2 p-2 m-1">
                                            <i class="fa fa-share"></i>
                                            Share
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- header__right_end  -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <div class="mobile_display_content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="mobile_text">
                        {{$course->title}}
                    </h4>
                </div>
                <div class="col-12">
                    <div class="next_prev_button">
                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                           class="theme_btn d-inline-flex align-items-center">
                            <i class="ti-angle-left mr-1"></i>
                            {{__('frontend.Course Details')}}
                        </a>
                        <a href="{{route('myCourses')}}" class="theme_btn d-inline-flex align-items-center">
                            {{__('frontend.My Course')}}
                            <i class="ti-angle-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="course_fullview_wrapper">

        @php
            //  'Youtube','Vimeo','Self','URL'
                  $video_lesson_hosts=['Iframe','Image','PDF','Word','Excel','PowerPoint','Text','Zip','SCORM','SCORM-AwsS3'];
        @endphp
        @if (in_array($lesson->host,$video_lesson_hosts))
            <button
                class="theme_btn small_btn2 p-2 m-1 top_right_btn completeAndPlayNext"> {{__('frontend.Mark as Complete')}}</button>
        @endif
        <input type="hidden" name="" id="host_type" value="{{ $lesson->host }}">

        @if ($lesson->is_quiz==1)
            @if(count($result)!=0)
                <div class="quiz_score_wrapper w-100 mt_70">
                    @if(!isset($_GET['done']))
                        <!-- quiz_test_header  -->
                        <div class="quiz_test_header">
                            <h3>{{__('student.Your Exam Score')}}</h3>
                        </div>

                        <div class="quiz_test_body">
                            @if( isset($lesson->lessonQuiz->display_result_message) && $lesson->lessonQuiz->display_result_message == 0)
                                @if($result['status'] == 'Failed')
                                    <h3 style="color: red">{{$lesson->lessonQuiz->fail_message}}</h3>
                                @else
                                    <h3 style="color: green">{{$lesson->lessonQuiz->pass_message}}</h3>
                                @endif
                            @elseif($result['status'] == 'Failed')
                                <h3>Sorry! Please try again.</h3>
                            @else
                                <h3>Congratulations! You passed the quiz.</h3>
                            @endif
                            @if ($result['publish']==1)
                                <div class="">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="score_view_wrapper">
                                                <div class="single_score_view">
                                                    <p>{{__('student.Exam Score')}}:</p>
                                                    <ul>
                                                        <li class="mb_15">
                                                            <label class="primary_checkbox2 d-flex">
                                                                <input checked="" type="checkbox" disabled>
                                                                <span class="checkmark mr_10"></span>
                                                                <span
                                                                    class="label_name">{{$result['totalCorrect']}} {{__('student.Correct Answer')}}</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="primary_checkbox2 error_ans d-flex">
                                                                <input checked="" name="qus" type="checkbox"
                                                                       disabled>
                                                                <span class="checkmark mr_10"></span>
                                                                <span
                                                                    class="label_name">{{$result['totalWrong']}} {{__('student.Wrong Answer')}}</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="single_score_view d-flex">
                                                    <div class="row">
                                                        <div class="col md">
                                                            <p>{{__('frontend.Start')}}</p>
                                                            <span> {{$result['start_at']}} </span>
                                                        </div>

                                                        <div class="col md">
                                                            <p>{{__('frontend.Finish')}}</p>
                                                            <span> {{$result['end_at']}}      </span>
                                                        </div>

                                                        <div class="col md">
                                                            <p class="nowrap">{{__('frontend.Duration')}}
                                                                ({{__('frontend.Minute')}})</p>
                                                            <h4 class="f_w_700 "> {{$result['duration']}} </h4>
                                                        </div>

                                                        <div class="col md">
                                                            <p>{{__('frontend.Mark')}}</p>
                                                            <h4 class="f_w_700 "> {{$result['score']}}
                                                                /{{$result['totalScore']}} </h4>
                                                        </div>

                                                        <div class="col md">
                                                            <p>{{__('frontend.Percentage')}}</p>
                                                            <h4 class="f_w_700 "> {{$result['mark']}}% </h4>
                                                        </div>

                                                        <div class="col md">
                                                            <p>{{__('frontend.Rating')}}</p>
                                                            <h4 class="f_w_700 theme_text {{$result['text_color']}}"> {{$result['status']}} </h4>
                                                        </div>
                                                        @if($result['enable_quiz_feedback']==1)
                                                            <div class="col md">
                                                                <p>{{__('frontend.Quiz Feedback')}}</p>
                                                                <span> {{$result['quiz_feedback']}}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="questionFeedback" class="pb-5">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Question</th>
                                                        <th>Feedback</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $no_question=1;
                                                    @endphp
                                                    @if(isset($questions))
                                                        @foreach($questions as $key=>$assign)
                                                            @if($assign->questionBank->enable_question_feedback ==1)
                                                                <tr>
                                                                    <td>{{$no_question++}}</td>
                                                                    <td>{!! @$assign->questionBank->question !!}</td>
                                                                    <td>{!! @$assign->questionBank->question_feedback !!}</td>

                                                                </tr>
                                                            @endif
                                                            {{-- @php
                                                                $no_question++;
                                                            @endphp --}}
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sumit_skip_btns d-flex align-items-center">
                                    @if (isset($result) && $result['status']!='Failed')

                                        <form action="{{route('lesson.complete')}}" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$course->id}}" name="course_id">
                                            <input type="hidden" value="{{$lesson->id}}" name="lesson_id">
                                            <input type="hidden" value="1" name="status">
                                            <button type="submit"
                                                    class="theme_btn    mr_20">{{__('student.Done')}}</button>
                                        </form>
                                    @endif

                                    @if(count($preResult)!=0)
                                        <button type="button"
                                                class="theme_line_btn  showHistory  mr_20">{{__('frontend.View History')}}</button>
                                    @endif

                                    @if($lesson->lessonQuiz->show_result_each_submit==1)
                                        <a href="{{route('quizResultPreview',$_GET['quiz_result_id']??0)}}"
                                           target="_blank"
                                           class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn">{{__('student.See Answer Sheet')}}</a>
                                    @endif

                                    {{-- <button type="button" class="theme_line_btn mr_20">{{__('frontend.View Feedback')}}
                                    <a href="{{route('getCertificate',[$course->id,$course->title]):'#'}}"
                                                   class="theme_line_btn mr_15 m-auto mt-4  text-center">
                                                    {{__('frontend.Get Certificate')}}
                                                </a>
                                                </button> --}}
                                </div>
                            @else
                                <span>{{__('quiz.Please wait till completion marking process')}}</span>
                            @endif

                            @if(count($preResult)!=0)
                                <div id="historyDiv" class="pt-5 " style="display:none;">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Date</th>
                                            <th>Mark</th>
                                            <th>Percentage</th>
                                            <th>Rating</th>
                                            @if($lesson->lessonQuiz->show_result_each_submit==1)
                                                <th>Details</th>
                                            @endif
                                        </tr>
                                        @foreach($preResult as $pre)
                                            <tr>
                                                <td>{{$pre['date']}}</td>
                                                <td>{{$pre['score']}}/{{$pre['totalScore']}}</td>
                                                <td>{{$pre['mark']}}%</td>
                                                <td class="{{$pre['text_color']}}">{{$pre['status']}}</td>
                                                @if($lesson->lessonQuiz->show_result_each_submit==1)
                                                    <td>
                                                        <a href="{{route('quizResultPreview',$pre['quiz_test_id'])}}"
                                                           class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn">{{__('student.See Answer Sheet')}}</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif

                        </div>
                    @else
                        @if( isset($lesson->lessonQuiz->display_result_message) && $lesson->lessonQuiz->display_result_message == 0)
                            @if($result['status'] == 'Failed')
                                <h3 style="color: red">{{$lesson->lessonQuiz->fail_message}}</h3>
                            @else
                                <h3 style="color: green">{{$lesson->lessonQuiz->pass_message}}</h3>
                            @endif
                        @elseif($result['status'] == 'Failed')
                            <h3>Sorry! Please try again.</h3>
                        @else
                            <h3>Congratulations! You passed the quiz.</h3>
                        @endif
                    @endif
                </div>
            @else
                <div class="quiz_questions_wrapper w-100 mt_70 ml-5 mr-5">
                    <!-- quiz_test_header  -->

                    @if($alreadyJoin!=0 && $lesson->lessonQuiz->multiple_attend==0)
                        <div class="quiz_test_header d-flex justify-content-between align-items-center">
                            <div class="quiz_header_left text-center">
                                <h3>{{__('frontend.Sorry! You already attempted this quiz')}}</h3>
                            </div>


                        </div>
                    @else
                        <div class="quiz_test_header d-flex justify-content-between align-items-center">
                            <div class="quiz_header_left">
                                <h3>{{$lesson->lessonQuiz->title}}
                                </h3>
                            </div>

                            <div class="quiz_header_right">

                                            <span class="question_time">
                                @php
                                    $timer =0;

                                        if(!empty($lesson->lessonQuiz->question_time_type==1)){
                                            $timer=$lesson->lessonQuiz->question_time;
                                        }else{
                                           $timer= $lesson->lessonQuiz->question_time*count($questions);
                                        }


                                @endphp

                                <span id="timer">{{$timer}}:00</span> min</span>
                                <p>{{__('student.Left of this Section')}}</p>
                            </div>
                        </div>
                        <!-- quiz_test_body  -->
                        <form action="{{route('quizSubmit')}}" method="POST" id="quizForm">
                            <input type='hidden' name="from" value="course">
                            <input type="hidden" name="courseId" value="{{$course->id}}">
                            <input type="hidden" name="quizType" value="1">
                            <input type="hidden" name="quizId" value="{{$lesson->lessonQuiz->id}}">
                            <input type="hidden" name="question_review" id="question_review"
                                   value="{{$lesson->lessonQuiz->question_review}}">
                            <input type="hidden" name="start_at" value="">
                            <input type="hidden" name="quiz_test_id" value="">
                            <input type="hidden" name="quiz_start_url" value="{{route('quizTestStart')}}">
                            <input type="hidden" name="single_quiz_submit_url" value="{{route('singleQuizSubmit')}}">
                            @csrf

                            <div class="quiz_test_body d-none">
                                <div class="tabControl">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="tab-content" id="pills-tabContent">
                                                @php
                                                    $count =1;
                                                @endphp
                                                @if(isset($questions))
                                                    @foreach($questions as $key=>$assign)
                                                        <div
                                                            class="tab-pane fade  {{$key==0?'active show':''}} singleQuestion"
                                                            data-qus-id="{{$assign->id}}"
                                                            data-qus-type="{{$assign->questionBank->type}}"
                                                            id="pills-{{$assign->id}}" role="tabpanel"
                                                            aria-labelledby="pills-home-tab{{$assign->id}}">
                                                            <!-- content  -->
                                                            <div class="question_list_header">


                                                            </div>
                                                            <div class="multypol_qustion mb_30">
                                                                <h4 class="font_18 f_w_700 mb-0">
                                                                    @if($assign->questionBank->type=="F")
                                                                        @php
                                                                            $question = $assign->questionBank->question;
                                                                            // dd($assign->question_bank_id);
                                                                            $dropdown = '';
                                                                            $dropdown .= '<select class="quizAns form-control" name="ans['.$assign->question_bank_id.']" id="'.$assign->question_bank_id.'_'.Auth::user()->id.'_'.$course->id.'" style="display: unset; width: 45%" onchange="saveValue(this)">';
                                                                            if(isset($assign->questionBank->questionMuInSerial))
                                                                            {
                                                                                 $dropdown .= '<option value=""> '.__('common.Select').' </option>';
                                                                                foreach($assign->questionBank->questionMuInSerial as $option)
                                                                                {

                                                                                    $dropdown .= '<option value="'.$option->id.'"> '.$option->title.' </option>';
                                                                                }
                                                                            }
                                                                            $dropdown .='</select>';

                                                                            $question = str_replace('[]', $dropdown, $question);
                                                                            // dd($question);
                                                                        @endphp
                                                                        <div>{!! @$question !!}</div>
                                                                        <div>{!! @$dropdown !!}</div>
                                                                    @else
                                                                        {!! @$assign->questionBank->question !!}
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                            <input type="hidden" class="question_type"
                                                                   name="type[{{$assign->questionBank->id}}]"
                                                                   value="{{ @$assign->questionBank->type}}">
                                                            <input type="hidden" class="question_id"
                                                                   name="question[{{$assign->questionBank->id}}]"
                                                                   value="{{ @$assign->questionBank->id}}">

                                                            @if($assign->questionBank->type=="M")
                                                                <ul class="quiz_select">
                                                                    @if(isset($assign->questionBank->questionMu))
                                                                        @foreach(@$assign->questionBank->questionMu as $option)

                                                                            <li>
                                                                                <label
                                                                                    class="primary_bulet_checkbox d-flex">
                                                                                    <input class="quizAns"
                                                                                           name="ans[{{$option->question_bank_id}}][]"
                                                                                           type="checkbox"
                                                                                           value="{{$option->id}}"
                                                                                           id="{{$option->question_bank_id}}_{{$option->id}}_{{Auth::user()->id}}_{{$course->id}}"
                                                                                           onchange='saveValueCheckBox(this);'>


                                                                                    <span
                                                                                        class="checkmark mr_10"></span>
                                                                                    <span
                                                                                        class="label_name">{{$option->title}} </span>
                                                                                </label>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            @endif

                                                            <div class="row">
                                                                @if($assign->questionBank->type=="Mt")
                                                                    @if(isset($assign->questionBank->questionMu))
                                                                        @php
                                                                            $question_data = $assign->questionBank->questionMuInSerial->where('match_type', 1);
                                                                            $answer_data = $assign->questionBank->questionMu->where('match_type', 2);
                                                                        @endphp
                                                                    @endif
                                                                    <div class="col-lg-8">
                                                                        <ul class="quiz_select matching_question">
                                                                            @if(isset($assign->questionBank->questionMu))
                                                                                @php $i=0; @endphp
                                                                                @foreach(@$question_data as $option)
                                                                                    <li>
                                                                                        <label class="">
                                                                                            <span
                                                                                                class="label_name">{{$option->title}} </span>
                                                                                            <select
                                                                                                class="quizAns form-control"
                                                                                                name="ans[{{$option->id}}]"
                                                                                                id="{{$option->question_bank_id}}_{{Auth::user()->id}}_{{$course->id}}"
                                                                                                onchange="saveValue(this)">
                                                                                                <option
                                                                                                    value="">{{__('common.Select')}}</option>
                                                                                                @foreach(@$answer_data as $ans)
                                                                                                    <option
                                                                                                        value="{{$ans->id}}"> {{$ans->title}} </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </label>
                                                                                    </li>
                                                                                    @php $i++ @endphp
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        {{-- <div><u>Answers</u></div> --}}
                                                                        <ul class="quiz_select">
                                                                            @if(isset($assign->questionBank->questionMu))
                                                                                @foreach(@$answer_data as $option)
                                                                                    <li>
                                                                                        <label
                                                                                            class="d-flex option_lable_mt">
                                                                                            <span class="label_name"
                                                                                                  style="padding: 10px;">{{$option->title}} </span>
                                                                                        </label>
                                                                                    </li>
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            @if($assign->questionBank->type=="S" || $assign->questionBank->type=="L" || $assign->questionBank->type=="")
                                                                <div style="margin-bottom: 20px;">
                                                                    <textarea class="textArea lms_summernote quizAns"
                                                                              id="editor{{$assign->id}}{{$course->id}}"
                                                                              cols="30" rows="10"
                                                                              name="ans[{{$assign->questionBank->id}}]"
                                                                              onchange="saveValue(this)">
                                                                    </textarea>
                                                                </div>
                                                            @endif
                                                            @if(!empty($assign->questionBank->image))
                                                                <div class="ques_thumb mb_50">
                                                                    <img
                                                                        src="{{asset($assign->questionBank->image)}}"
                                                                        class="img-fluid" alt="">
                                                                </div>
                                                            @endif
                                                            <div
                                                                class="sumit_skip_btns d-flex align-items-center mb_50">
                                                                @if(count($questions)!=$count)
                                                                    <span
                                                                        class="theme_btn small_btn  mr_20 next"
                                                                        data-question_id="{{$assign->questionBank->id}}"
                                                                        data-assign_id="{{$assign->id}}"
                                                                        data-question_type="{{$assign->questionBank->type}}"
                                                                        id="next">{{__('student.Continue')}}</span>
                                                                    <span
                                                                        class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn skip"
                                                                        id="skip">{{__('student.Skip')}}
                                                                        {{__('frontend.Question')}}</span>
                                                                @else
                                                                    <button type="button"
                                                                            data-question_id="{{$assign->questionBank->id}}"
                                                                            data-assign_id="{{$assign->id}}"
                                                                            data-question_type="{{$assign->questionBank->type}}"
                                                                            class="submitBtn theme_btn small_btn  mr_20">
                                                                        {{__('student.Submit')}}
                                                                    </button>
                                                                @endif
                                                            </div>


                                                            <!-- content::end  -->
                                                        </div>
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-6">

                                            @php
                                                $count2=1;
                                            @endphp

                                            <div class="question_list_header">
                                                <div class="question_list_top">
                                                    <p>Question <span id="currentNumber">{{$count2}}</span>
                                                        out
                                                        of {{count($questions)}}</p>
                                                </div>
                                            </div>
                                            <div class="nav question_number_lists" id="nav-tab"
                                                 role="tablist">
                                                @if(isset($questions))
                                                    @foreach($questions as $key2=>$assign)
                                                        <a class="nav-link questionLink link_{{$assign->id}} {{$key2==0?'skip_qus':'pouse_qus'}}"
                                                           id="link_{{$assign->id}}"
                                                           data-toggle="tab" href="#pills-{{$assign->id}}"
                                                           role="tab" aria-controls="nav-home"
                                                           data-qus="{{$assign->id}}"
                                                           aria-selected="true">{{$count2}}</a>
                                                        @php
                                                            $count2++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>



                @include(theme('partials._quiz_submit_confirm_modal'))
                @include(theme('partials._quiz_start_confirm_modal'))
            @endif
        @elseif($lesson->is_assignment==1)
            @if(isModuleActive('Assignment'))

                @php

                    $assignment_info=$lesson->assignmentInfo;
                    if (Auth::check()) {
                        $submit_info=Modules\Assignment\Entities\InfixSubmitAssignment::assignmentLastSubmitted($assignment_info->id,Auth::user()->id);

                            if (Auth::user()->role_id==1) {
                                $sty="-150px";
                            } else {
                               if ($submit_info!=null) {
                                    $sty="50px";
                                } else {
                                    $sty="280px";
                                }
                            }

                    }else{
                        $submit_info=null;
                        if ($submit_info!=null) {
                           $sty="50px";
                        } else {
                            $sty="280px";
                        }
                    }
                @endphp
                <div class="col-lg-12 pl-5" style="margin-top: {{@$sty}};">
                    <div class="row" style="visibility: hidden">
                        <div class="col-12">
                            <div class="section__title3 mb_40">
                                <h3 class="mb-0 mt-5">{{__('assignment.Assignment')}} {{__('common.Details')}}</h3>
                                <h4></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3 mb_40">
                                <h3 class="mb-0 mt-5"></h3>
                                <h4></h4>
                            </div>
                        </div>
                    </div>
                    <style>
                        .assignment_info {
                            margin-top: 10px;
                        }
                    </style>
                    <div class="table-responsive-md table-responsive-sm assignment-info-table">
                        <table class="table">
                            <thead><h3 class="mb-0 mt-5">{{__('assignment.Assignment')}} {{__('common.Details')}}</h3>
                            </thead>
                            <tr class="nowrap">
                                <td>
                                    {{__('common.Title')}}
                                </td>
                                <td>
                                    : {{@$assignment_info->title}}
                                </td>
                                <td>
                                    {{__('courses.Course')}}
                                </td>
                                <td>
                                    @if ($assignment_info->course->title)
                                        : {{@$assignment_info->course->title}}
                                    @else
                                        : Not Assigned
                                    @endif
                                </td>
                            </tr>
                            <tr class="nowrap">
                                <td>
                                    {{ __('assignment.Marks') }}
                                </td>
                                <td>
                                    : {{@$assignment_info->marks}}
                                </td>
                                <td>
                                    {{ __('assignment.Min Percentage') }}
                                </td>
                                <td>
                                    : {{@$assignment_info->min_parcentage}}%
                                </td>
                            </tr>
                            @if ($submit_info!=null)
                                <tr class="nowrap">
                                    <td>
                                        {{ __('assignment.Obtain Marks') }}
                                    </td>
                                    <td>
                                        : {{@$submit_info->marks}}
                                    </td>
                                    <td>
                                        {{ __('common.Status') }}
                                    </td>
                                    <td>
                                        :

                                        @if ($submit_info->assigned->pass_status==1)
                                            Pass
                                        @elseif($submit_info->assigned->pass_status==2)
                                            Fail
                                        @else
                                            Not Marked
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>
                                    {{ __('assignment.Submit Date') }}
                                </td>
                                <td>
                                    : {{showDate(@$assignment_info->last_date_submission)}}
                                </td>
                                <td>
                                    {{__('assignment.Attachment')}}
                                </td>
                                <td>
                                    @if (file_exists($assignment_info->attachment))
                                        : <a href="{{asset(@$assignment_info->attachment)}}"
                                             download="{{@$assignment_info->title}}_attachment">{{__('common.Download')}}</a>
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>


                    <div class="row assignment_info">
                        <div class="col-lg-2">
                            {{__('assignment.Description')}}
                        </div>
                        <div class="col-lg-12">
                            {!! @$assignment_info->description !!}
                        </div>
                    </div>

                    <hr>
                    @php
                        $todate = today()->format('Y-m-d')
                    @endphp
                    @if (isset($assignment_info->last_date_submission) && Auth::user()->role_id==3)
                        @if ($todate <= $assignment_info->last_date_submission || isset($submit_info) && $submit_info->assigned->pass_status==0)
                            @include(theme('partials._assignment_submit_section'))
                        @endif
                    @else
                        @if (isset($submit_info) && $submit_info->assigned->pass_status==0 && Auth::user()->role_id==3)
                            @include(theme('partials._assignment_submit_section'))
                        @endif
                    @endif


                </div>
            @endif
        @else

            <input type="hidden" id="course_id" value="{{$lesson->course_id}}">
            <script>
                var course_id = document.getElementById('course_id').value;
                var is_completed_vimeo = false;
                var is_completed_yt = false;
            </script>
            @if ($lesson->host=='Youtube')
                @php
                    if (Str::contains( $lesson->video_url, '&')) {
                        $video_id = explode("=", $lesson->video_url);
                        $youtube_url= youtubeVideo($video_id[1]);
                    } else {
                       $youtube_url=getVideoId(showPicName(@$lesson->video_url));

                    }
                @endphp


                <div style="" id="video-placeholder"></div>
                <input class="d-none" type="text" id="progress-bar">
                <input type="hidden" name="" id="youtube_video_id" value="{{$youtube_url}}">

                @push('js')

                    <script src="https://www.youtube.com/iframe_api"></script>
                    <script>

                        var source_video_id = $('#youtube_video_id').val();
                        var player;

                        // val youtube_video_id=$('#youtube_video_id').val();
                        function onYouTubeIframeAPIReady() {
                            console.log('yt api');
                            player = new YT.Player('video-placeholder', {
                                videoId: source_video_id,
                                height: '100%',
                                width: '100%',
                                playerVars: {
                                    color: 'white',
                                    controls: {{Settings('show_seek_bar')?1:0}},
                                    showinfo: 0,
                                    rel: 0,
                                },
                                events: {
                                    onReady: initialize

                                }
                            });
                        }

                        function initialize() {
                            // Update the controls on load
                            updateTimerDisplay();
                            updateProgressBar();

                            // player.playVideo();
                            //  console.log('play');
                            time_update_interval = setInterval(function () {
                                updateTimerDisplay();
                                updateProgressBar();
                            }, 1000)


                        }

                        // player.addEventListener("onStateChange", function(state){
                        //     if(state === 0){
                        //         console.log('video complete');
                        //         lessonAutoComplete(course_id,{{showPicName(Request::url())}});
                        //     }
                        // });
                        function updateProgressBar() {
                            $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
                        }

                        // This function is called by initialize()
                        function updateTimerDisplay() {
                            $('#currentTime').text(formatTime(player.getCurrentTime()));
                            $('#totalTime').text(formatTime(player.getDuration()));

                            // console.log('Current time : '+player.getCurrentTime());
                            // console.log('Duration : '+player.getDuration());
                            // console.log(player.getDuration()-1);
                            var seconds_remaining = Math.ceil(player.getDuration() - player.getCurrentTime());

                            if (player.getCurrentTime() >= (player.getDuration() - 1)) {
                                // console.log('video done');
                                if (!completeRequest) {
                                    is_completed_yt = false;
                                    // alert(is_completed_yt);
                                    lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                    completeRequest = true;
                                }

                            } else if (!is_completed_yt) {
                                // console.log(seconds_remaining);
                                // if((complete_percentage >= 98) || (seconds_remaining <= 20)){
                                if (seconds_remaining <= 30) {
                                    is_completed_yt = true;
                                    lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                }
                            }

                        }


                        function formatTime(time) {
                            time = Math.round(time);

                            var minutes = Math.floor(time / 60),
                                seconds = time - minutes * 60;

                            seconds = seconds < 10 ? '0' + seconds : seconds;

                            return minutes + ":" + seconds;
                        }

                        $('#progress-bar').on('mouseup touchend', function (e) {

                            // Calculate the new time for the video.
                            // new time in seconds = total duration in seconds * ( value of range input / 100 )
                            var newTime = player.getDuration() * (e.target.value / 100);

                            // Skip video to new time.
                            player.seekTo(newTime);

                        });

                        // This function is called by initialize()
                        function updateProgressBar() {
                            // Update the value of our progress bar accordingly.
                            $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
                        }


                    </script>

                @endpush

            @endif
            {{-- End Youtube --}}

            @if ($lesson->host=='URL1')
                <video class="" id="video-id" controls autoplay
                       onended="lessonAutoComplete(course_id, {{showPicName(Request::url())}})">
                    <source src="{{$lesson->video_url}}" type="video/mp4">
                    <source src="{{$lesson->video_url}}" type="video/ogg">
                    Your browser does not support the video.
                </video>

            @endif

            @if ($lesson->host=='Vimeo' || $lesson->host=='URL')
                @php
                    if($lesson->host=='URL'){
                        if (Str::contains( $lesson->video_url, '&')) {
                            $video_id = explode("https://player.vimeo.com/", $lesson->video_url);
                            $video_id= $video_id[1];
                        }
                    }
                @endphp

                <iframe class="video_iframe" id="video-id"
                        src="https://player.vimeo.com/video/{{getVideoId(showPicName(@$lesson->video_url))}}?autoplay=1&"
                        frameborder="0" controls=0 allowfullscreen="allowfullscreen"
                        mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen"
                        oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe>
                <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

                @push('js')
                    <script src='https://player.vimeo.com/api/player.js'></script>
                    <script>
                        $(function () {
                            var iframe = $('#video-id')[0];
                            var player = new Vimeo.Player(iframe);
                            var status = $('.status');
                            var total_time = 0;


                            player.on('pause', function () {
                                console.log('paused');
                            });

                            player.on('ended', function () {
                                console.log('ended');
                                console.log(completeRequest);
                                if (!completeRequest) {
                                    is_completed_vimeo = false;
                                    lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                    completeRequest = true;
                                }
                                status.text('End');


                            });
                            // console.log(player.getDuration());
                            player.getDuration().then(function (duration) {
                                total_time = duration;
                            }).catch(function (error) {
                                console.log(error + 'error');
                            });

                            player.on('timeupdate', function (data) {
                                // console.log(data.seconds + 's played');
                                var video_played = data.seconds;
                                // var complete_percentage = Math.ceil((video_played * 100) / total_time);
                                var seconds_remaining = Math.ceil(total_time - video_played);
                                if (is_completed_vimeo == false) {
                                    // if((complete_percentage >= 98) || (seconds_remaining <= 20)){
                                    if (seconds_remaining <= 30) {
                                        is_completed_vimeo = true;
                                        lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                    }
                                }
                            });

                        });
                    </script>
                @endpush

            @endif
            @push('js')
                <script>

                    $("#autoNext").change(function () {
                        if ($(this).is(':checked')) {
                            localStorage.setItem('autoNext', 1);
                        } else {
                            localStorage.setItem('autoNext', 0);

                        }

                    });
                    if (localStorage.getItem('autoNext') == 0) {
                        $("#autoNext").prop('checked', false);
                    }
                    $("#autoNext").trigger('change');

                    function lessonAutoComplete(course_id, lesson_id) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });


                        $.ajax({
                            type: 'GET',
                            "_token": "{{ csrf_token() }}",
                            url: '{{route('lesson.complete.ajax')}}',
                            data: {course_id: course_id, lesson_id: lesson_id},
                            success: function (data) {
                                if ($('#autoNext').is(':checked')) {
                                    console.log('complete');
                                    var is_false = false;

                                    if ($("#host_type").val() == "URL" || $("#host_type").val() == "Vimeo") {
                                        // if(is_completed_vimeo == false){
                                        is_false = is_completed_vimeo;
                                        // }
                                    }
                                    // if($("#host_type").val() == "Youtube" && !is_completed_yt){
                                    if ($("#host_type").val() == "Youtube") {
                                        is_false = is_completed_yt;
                                    }
                                    // console.log(is_false+' adsffd  ' +is_completed_yt);
                                    if (is_false == false) {
                                        if ($('#next_lesson_btn').length) {
                                            jQuery('#next_lesson_btn').click();
                                        } else {
                                            location.reload();
                                        }
                                    }
                                }

                            }
                        });

                        if (window.outerWidth < 425) {
                            $('.courseListPlayer').toggleClass("active");
                            $('.course_fullview_wrapper').toggleClass("active");
                        }
                    }


                </script>
            @endpush
            @if ($lesson->host=='VdoCipher')
                <div id="embedBox" class="video_iframe"></div>

                <script>
                    (function (v, i, d, e, o) {
                        v[o] = v[o] || {
                            add: function V(a) {
                                (v[o].d = v[o].d || []).push(a);
                            }
                        };
                        if (!v[o].l) {
                            v[o].l = 1 * new Date();
                            a = i.createElement(d);
                            m = i.getElementsByTagName(d)[0];
                            a.async = 1;
                            a.src = e;
                            m.parentNode.insertBefore(a, m);
                        }
                    })(
                        window,
                        document,
                        "script",
                        "https://cdn-gce.vdocipher.com/playerAssets/1.6.10/vdo.js",
                        "vdo"
                    );
                    vdo.add({
                        otp: "{{$lesson->otp}}",
                        playbackInfo: "{{$lesson->playbackInfo}}",
                        theme: "9ae8bbe8dd964ddc9bdb932cca1cb59a",
                        container: document.querySelector("#embedBox"),
                        autoplay: true
                    });
                </script>

                <script>
                    var isRedirect = false;

                    function onVdoCipherAPIReady() {


                        let video = vdo.getObjects()[0];


                        setInterval(function () {
                            if (video.ended) {
                                if (!isRedirect) {
                                    if (!completeRequest) {
                                        lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                        completeRequest = true;
                                    }
                                    isRedirect = true;
                                }
                            }
                        }, 1000);
                    }
                </script>
            @endif

            @if ($lesson->host=='Self')
                <video class="" id="video-id" controls autoplay
                       onended="lessonAutoComplete(course_id, {{showPicName(Request::url())}})">
                    <source src="{{asset($lesson->video_url)}}" type="video/mp4"/>
                    <source src="{{asset($lesson->video_url)}}" type="video/ogg">
                </video>

            @endif

            @if ($lesson->host=='AmazonS3')
                <video class=" " id="video-id" controls
                       onended="lessonAutoComplete(course_id, {{showPicName(Request::url())}})">
                    <source src="{{$lesson->video_url}}" type="video/mp4"/>

                </video>

            @endif

            @if ($lesson->host=='SCORM')
                @if(!empty($lesson->video_url))
                    <iframe class="video_iframe" id="video-id" src="{{asset($lesson->video_url)}}?StandAlone=true&ShowDebug=false"></iframe>
                @endif
            @endif

            @if ($lesson->host=='SCORM-AwsS3')
                @if(!empty($lesson->video_url))
                    <iframe class="video_iframe" id="video-id"
                            src="{{$lesson->video_url}}"
                    ></iframe>
                @endif
            @endif

            @if ($lesson->host=='SCORM')
            <script>
                let video_element = $('#video-id');
                let url = "{{asset($lesson->video_url)}}?StandAlone=true&ShowDebug=false";
                var API = {};

                (function ($) {
                    $(document).ready(function () {
                        setupScormApi()
                        video_element.attr('src', url)
                    });

                    function setupScormApi() {
                        API.LMSInitialize = LMSInitialize;
                        API.LMSGetValue = LMSGetValue;
                        API.LMSSetValue = LMSSetValue;
                        API.LMSCommit = LMSCommit;
                        API.LMSFinish = LMSFinish;
                        API.LMSGetLastError = LMSGetLastError;
                        API.LMSGetDiagnostic = LMSGetDiagnostic;
                        API.LMSGetErrorString = LMSGetErrorString;
                    }

                    function LMSInitialize(initializeInput) {
                        displayLog("LMSInitialize: " + initializeInput);
                       
                        var studentId = "{{ Auth::user()->id }}";
                        API.LMSSetValue("cmi.core.student_id", studentId);

                        var studentName = "{{ Auth::user()->name }}";
                        API.LMSSetValue("cmi.core.student_name", studentName);

                        API.LMSSetValue("cmiFromExternalLMS.core.student_id", studentId);
                        API.LMSSetValue("cmiFromExternalLMS.core.student_name", studentName);

                        API.LMSSetValue("cmiFromExternalLMS.learner_id", studentId);
                        API.LMSSetValue("cmiFromExternalLMS.learner_name", studentName);

                        API.LMSSetValue("cmi.core.learner_id", studentId);
                        API.LMSSetValue("cmi.core.learner_name", studentName);

                        return true;
                    }

                    function LMSGetValue(varname) {
                        displayLog("LMSGetValue: " + varname);

                        switch (varname) {
                            case "cmi.core.student_id":
                                var studentId = "{{ Auth::user()->id }}";
                                return studentId;
                            case "cmi.core.student_name":
                                var studentName = "{{ Auth::user()->name }}";
                                return studentName;
                            default:
                                return "";
                        }
                        return "";
                    }

                    function LMSSetValue(varname, varvalue) {
                        displayLog("LMSSetValue: " + varname + "=" + varvalue);
                        return "";
                    }

                    function LMSCommit(commitInput) {
                        displayLog("LMSCommit: " + commitInput);
                        return true;
                    }

                    function LMSFinish(finishInput) {
                        displayLog("LMSFinish: " + finishInput);
                        return true;
                    }

                    function LMSGetLastError() {
                        displayLog("LMSGetLastError: ");
                        return 0;
                    }

                    function LMSGetDiagnostic(errorCode) {
                        displayLog("LMSGetDiagnostic: " + errorCode);
                        return "";
                    }

                    function LMSGetErrorString(errorCode) {
                        displayLog("LMSGetErrorString: " + errorCode);
                        return "";
                    }

                })(jQuery);


                function displayLog(textToDisplay) {
                    console.log(textToDisplay);
                }
            </script>
            @endif

            @if ($lesson->host=='Iframe')
                @if(!empty($lesson->video_url))
                    <iframe class="video_iframe" id="video-id"
                            src="{{asset($lesson->video_url)}}"
                            allowfullscreen="allowfullscreen"
                        mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen"
                        oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe>
                @endif

            @endif


            @if ($lesson->host=='Image')
                <img src="{{asset($lesson->video_url)}}" alt="" class="w-100  h-100">
            @endif

            @if ($lesson->host=='PDF')

                <style>
                    .topBlackBanner {
                        z-index: 90;
                        width: 100%;
                        top: 0;
                        height: 60px;
                        position: absolute;
                        background: #34393c;
                        color: #34393c;
                    }
                </style>
                <div class="topBlackBanner"></div>
                <div id="pdfShow" class="w-100  h-100"></div>
                <script src="{{asset('public/js/pdfobject.js')}}"></script>
                <script>
                    var options = {
                        pdfOpenParams: {
                            view: 'FitV',
                        }
                    };

                    {{--var posicion_x;--}}
                    {{--var posicion_y;--}}
                    {{--posicion_x = (screen.width / 2) - (1200 / 2);--}}
                    {{--posicion_y = (screen.height / 2) - (700 / 2);--}}
                    {{--window.open("{{asset($lesson->video_url)}}", "documento", "width=" + 1200 + ",height=" + 700 + ",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left=" + posicion_x + ",top=" + posicion_y + "");--}}

                    PDFObject.embed("{{asset($lesson->video_url)}}", "#pdfShow", options);

                    // window.frames["#pdfShow"].document.oncontextmenu = function () {
                    //     alert("No way!");
                    //     return false;
                    // };
                </script>


                <script type="text/javascript">
                    $(function () {
                        document.addEventListener("pagerendered", function (e) {
                            $('#downloads').hide();
                            // $('#viewBookmark').hide();
                            // $('#openFile').hide();
                        });
                    });
                </script>

            @endif
            @if ($lesson->host=='Word' || $lesson->host=='Excel' || $lesson->host=='PowerPoint' )

                <iframe class="w-100  h-100"
                        src="https://view.officeapps.live.com/op/view.aspx?src={{asset($lesson->video_url)}}"></iframe>

            @endif

            @if ($lesson->host=='Text')
                <div class="w-100  h-100 textViewer">

                </div>
                <script>
                    $(".textViewer").load("{{asset($lesson->video_url)}}");

                </script>
            @endif


            {{-- Iframe video --}}
            @push('js')
                <script>
                    $(document).ready(function (e) {
                        if ($('#video-id').length) {
                            var iframe = document.getElementById("video-id");
                            var video = iframe.contentDocument.body.getElementsByTagName("video")[0];
                            var supposedCurrentTime = 0;

                            // iframe.contentWindow.postMessage('message', 'https://corporateuat.hrdcorp.gov.my');

                            // window.addEventListener('message', event => {
                            //     console.log(event.origin);
                            //     if (event.origin.startsWith('https://corporateuat.hrdcorp.gov.my')) { //check the origin of the data!
                            //         // The data was sent from your site. It sent with postMessage is stored in event.data:
                            //         console.log(event.data);
                            //         console.log('loaded');
                            //     } else {
                            //         // The data was NOT sent from your site!
                            //         console.log('not loaded');
                            //         return;
                            //     }
                            // });

                            // // Receive the message from the parent window
                            // window.addEventListener('message', function(event) {
                            //     // Check the origin of the message
                            //     if (event.origin === 'https://corporateuat.hrdcorp.gov.my' && event.source === parent) {
                            //         // Process the received message
                            //         console.log('Received message from parent:', event.data);

                            //         // Send the iframe content back to the parent window
                            //         parent.postMessage('Iframe content', 'https://corporateuat.hrdcorp.gov.my');
                            //     }
                            // });

                            if (video) {
                                video.addEventListener('timeupdate', function () {
                                    if (!video.seeking) {
                                        supposedCurrentTime = video.currentTime;
                                    }
                                });
                                // prevent user from seeking
                                video.addEventListener('seeking', function () {
                                    // guard agains infinite recursion:
                                    // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
                                    var delta = video.currentTime - supposedCurrentTime;
                                    if (Math.abs(delta) > 0.01) {
                                        console.log("Seeking is disabled");
                                        video.currentTime = supposedCurrentTime;
                                    }
                                });
                                // delete the following event handler if rewind is not required
                                video.addEventListener('ended', function () {
                                    if (!completeRequest) {
                                        lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                        completeRequest = true;
                                    }
    
                                    // reset state in order to allow for rewind
                                    console.log('video end');
                                    supposedCurrentTime = 0;
                                });
                            }
                        }
                    });
                </script>
            @endpush
            @if ($lesson->host=='Zip')
                <style>
                    .parent {
                        position: fixed;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .child {
                        position: relative;
                        font-size: 10vw;
                    }
                </style>
                <div class="w-100 parent  h-100 ">
                    <div class="">
                        <div class="row">
                            <div class="col  text-center">
                                <div class="child">
                                    <a class="theme_btn " href="{{asset($lesson->video_url)}}"
                                       download="">{{__('frontend.Download File')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        @endif
        {{-- </div> --}}


        <input type="hidden" id="url" value="{{url('/')}}">
        <div class="course__play_warp courseListPlayer ">
            <div class="play_toggle_btn">
                <i class="ti-menu-alt"></i>
            </div>

            <div class="play_warp_header d-flex justify-content-between">
                <h3 class="font_16  mb-0 lesson_count default-font">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}" class="theme_btn_mini">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    {{@$total}} {{__('common.Lessons')}}</h3>
            </div>
            <div class="course__play_list">
                @php
                    $i=1;
                @endphp
                <div class="theme_according mb_30" id="accordion1">
                    @foreach($chapters as $k=>$chapter)

                        <div class="card">
                            <div class="card-header pink_bg" id="heading{{$chapter->id}}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text_white collapsed "
                                            data-toggle="collapse"
                                            data-target="#collapse{{$chapter->id}}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{$chapter->id}}">
                                        {{$chapter->name}} <br>
                                        <span
                                            class="course_length nowrap"> {{count($chapter->lessons)}} {{__('frontend.Lectures')}}</span>
                                    </button>
                                </h5>
                            </div>
                            <div class="collapse" id="collapse{{$chapter->id}}"
                                 aria-labelledby="heading{{$chapter->id}}"
                                 data-parent="#accordion1">
                                <div class="card-body">
                                    <div class="curriculam_list">
                                        @if(isset($lessons))
                                            @php
                                                // $video_lesson_hosts=['Youtube','Vimeo','Self','URL'];
                                            @endphp
                                            @foreach ($lessons as $key => $singleLesson)
                                                @if($singleLesson->chapter_id==$chapter->id)
                                                    <div class="single_play_list">
                                                        <a class="@if(showPicName(Request::url())==$singleLesson->id) active @endif"
                                                           href="#">

                                                            @if ($singleLesson->is_quiz==1)
                                                                <div class="course_play_name">

                                                                    <label class="primary_checkbox d-flex mb-0">
                                                                        {{-- <input
                                                                            id="lesson_complete_check_{{$singleLesson->id}}"
                                                                            type="checkbox"
                                                                            data-lesson="{{$singleLesson->id}}"
                                                                            data-course="{{$course->id}}"
                                                                            class="course_name"
                                                                            {{$singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : ''}}  name="billing_address"
                                                                            value="1"> --}}
                                                                        <input type="checkbox"
                                                                               {{$singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : ''}} disabled>
                                                                        <span class="checkmark mr_15"
                                                                              style="cursor: not-allowed"></span>

                                                                        <i class="ti-check-box"></i>
                                                                    </label>
                                                                    @foreach ($singleLesson->quiz as $quiz)

                                                                        <span class="quizLink"
                                                                              onclick="goFullScreen({{$course->id}},{{$singleLesson->id}})">
                                                     <span class="quiz_name">{{$i}}. {{@$quiz->title}}</span>
                                                                </span>
                                                                </div>
                                                                @endforeach
                                                            @else

                                                                <div class="course_play_name">
                                                                    @if(request()->route('lesson_id') == $singleLesson->id)

                                                                        <div
                                                                            class="remember_forgot_pass d-flex justify-content-between">
                                                                            <label class="primary_checkbox d-flex mb-0">
                                                                                @if($isEnrolled)
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        {{$singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : ''}} disabled>
                                                                                    <span style="cursor: not-allowed"
                                                                                          class="checkmark mr_15"></span>
                                                                                    <i class="ti-control-play"></i>
                                                                                @else
                                                                                    <i class="ti-control-play"></i>
                                                                                @endif
                                                                            </label>
                                                                        </div>

                                                                    @else

                                                                        <label class="primary_checkbox d-flex mb-0">
                                                                            <input
                                                                                type="checkbox" {{$singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : ''}} >
                                                                            <span style="cursor: not-allowed"
                                                                                  class="checkmark mr_15"></span>

                                                                            <i class="ti-control-play"></i>
                                                                        </label>

                                                                    @endif

                                                                    <span
                                                                        onclick="goFullScreen({{$course->id}},{{$singleLesson->id}})">{{$i}}. {{$singleLesson->name}} </span>
                                                                </div>
                                                                <span
                                                                    class="course_play_duration nowrap">{{MinuteFormat($singleLesson->duration)}}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endif
                                            @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center text-center">
                    @if($certificate)
                        @if($quizPass)
                            @auth()
                                @if($percentage>=100)
                                    @if(isModuleActive('Survey') && $course->survey)

                                        @if(Settings('must_survey_before_certificate'))
                                            @if(auth()->user()->attendSurvey($course->survey))
                                                <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                                   class="theme_btn certificate_btn mt-5">
                                                    {{__('frontend.Get Certificate')}}
                                                </a>
                                            @else
                                                <button type="button"
                                                        data-toggle="modal"
                                                        data-target="#assignSubmit"
                                                        class="theme_btn certificate_btn mt-5">
                                                    {{__('frontend.Survey')}}
                                                </button>
                                                <small>
                                                    {{__('frontend.You must attend servery before getting certificate')}}
                                                </small>
                                            @endif
                                        @else
                                            @if(!auth()->user()->attendSurvey($course->survey))
                                                <button type="button"
                                                        data-toggle="modal"
                                                        data-target="#assignSubmit"
                                                        class="theme_btn certificate_btn mt-5 mr-1">
                                                    {{__('frontend.Survey')}}
                                                </button>
                                            @endif
                                            <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                               class="theme_btn certificate_btn mt-5 ml-1">
                                                {{__('frontend.Get Certificate')}}
                                            </a>
                                        @endif

                                    @else
                                        <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                           class="theme_btn certificate_btn" style="    margin-bottom: 50px;">
                                            {{__('frontend.Get Certificate')}}
                                        </a>
                                    @endif
                                @endif
                            @endauth
                        @endif
                    @endif

                </div>
                <div class="pb-5 mb-5 d-none">
                    <div>{{__('frontend.Current Time')}}: <span id="currentTime">0</span></div>
                    <div>{{__('frontend.Total Time')}} : <span id="totalTime">0</span></div>
                    <div>{{__('frontend.Status')}} : <span class="status"></span></div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade " id="ShareLink"
         tabindex="-1" role="dialog"
         aria-labelledby=" "
         aria-hidden="true">
        <div class="modal-dialog modal-lg "
             role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{__('frontend.Share this course')}}

                    </h5>
                </div>

                <div class="modal-body">


                    <div class="row mb-20">
                        <div class="col-md-12">
                            <input type="text"
                                   required
                                   class="primary_input4 mb_20"
                                   name=""
                                   value="{{URL::current()}}">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="social_btns ">
                                <a target="_blank"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}"
                                   class="social_btn fb_bg"> <i class="fab fa-facebook-f"></i>
                                </a>
                                <a target="_blank"
                                   href="https://twitter.com/intent/tweet?text={{$course->title}}&amp;url={{URL::current()}}"
                                   class="social_btn Twitter_bg"> <i
                                        class="fab fa-twitter"></i> </a>
                                <a target="_blank"
                                   href="https://wa.me/?text=Check%20out%20this%20course%20{{URL::current()}}"
                                   class="social_btn Pinterest_bg" style="background: #28a745;"> <i
                                        class="fab fa-whatsapp"></i> </a>
                                <a target="_blank"
                                   href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{URL::current()}}&amp;title={{$course->title}}&amp;summary={{$course->title}}"
                                   class="social_btn Linkedin_bg"> <i
                                        class="fab fa-linkedin-in"></i> </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade " id="courseRating"
         tabindex="-1" role="dialog"
         aria-labelledby=" "
         aria-hidden="true">
        <div class="modal-dialog modal-lg "
             role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{__('frontend.Rate this course')}}

                    </h5>
                </div>
                <div class="modal-body">


                    <div class="row mb-20">
                        <div class="col-md-12">
                            <div class="rating_star text-right">

                                @php
                                    $PickId=$course->id;
                                @endphp
                                @if (Auth::check())
                                    @if(Auth::user()->role_id==3)
                                        @if (!in_array(Auth::user()->id,$reviewer_user_ids))

                                            <div
                                                class="star_icon d-flex align-items-center justify-content-between">
                                                <a class="rating">
                                                    <input type="radio" id="star5" name="rating"
                                                           value="5"
                                                           class="rating"/><label
                                                        class="full" for="star5" id="star5"
                                                        title="Awesome - 5 stars"
                                                        onclick="Rates(5, {{@$PickId }})"></label>
                                                    <input type="radio" id="star4half"
                                                           name="rating"
                                                           value="4.5"
                                                           class="rating"/><label class="half"
                                                                                  for="star4half"
                                                                                  title="Pretty good - 4.5 stars"
                                                                                  onclick="Rates(4.5, {{@$PickId }})"></label>
                                                    <input type="radio" id="star4" name="rating"
                                                           value="4"
                                                           class="rating"/><label
                                                        class="full" for="star4"
                                                        title="Pretty good - 4 stars"
                                                        onclick="Rates(4, {{@$PickId }})"></label>
                                                    <input type="radio" id="star3half"
                                                           name="rating"
                                                           value="3.5"
                                                           class="rating"/><label class="half"
                                                                                  for="star3half"
                                                                                  title="Meh - 3.5 stars"
                                                                                  onclick="Rates(3.5, {{@$PickId }})"></label>
                                                    <input type="radio" id="star3" name="rating"
                                                           value="3"
                                                           class="rating"/><label
                                                        class="full" for="star3"
                                                        title="Meh - 3 stars"
                                                        onclick="Rates(3, {{@$PickId }})"></label>
                                                    <input type="radio" id="star2half"
                                                           name="rating"
                                                           value="2.5"
                                                           class="rating"/><label class="half"
                                                                                  for="star2half"
                                                                                  title="Kinda bad - 2.5 stars"
                                                                                  onclick="Rates(2.5, {{@$PickId }})"></label>
                                                    <input type="radio" id="star2" name="rating"
                                                           value="2"
                                                           class="rating"/><label
                                                        class="full" for="star2"
                                                        title="Kinda bad - 2 stars"
                                                        onclick="Rates(2, {{@$PickId }})"></label>
                                                    <input type="radio" id="star1half"
                                                           name="rating"
                                                           value="1.5"
                                                           class="rating"/><label class="half"
                                                                                  for="star1half"
                                                                                  title="Meh - 1.5 stars"
                                                                                  onclick="Rates(1.5, {{@$PickId }})"></label>
                                                    <input type="radio" id="star1" name="rating"
                                                           value="1"
                                                           class="rating"/><label
                                                        class="full" for="star1"
                                                        title="Bad  - 1 star"
                                                        onclick="Rates(1,{{@$PickId }})"></label>
                                                    <input type="radio" id="starhalf"
                                                           name="rating"
                                                           value=".5"
                                                           class="rating"/><label class="half"
                                                                                  for="starhalf"
                                                                                  title="So bad  - 0.5 stars"
                                                                                  onclick="Rates(.5,{{@$PickId }})"></label>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @else

                                    <p class="font_14 f_w_400 mt-0"><a href="{{url('login')}}"
                                                                       class="theme_color2">{{__('frontend.Sign In')}}</a>
                                        {{__('frontend.or')}} <a
                                            class="theme_color2"
                                            href="{{url('register')}}">{{__('frontend.Sign Up')}}</a>
                                        {{__('frontend.as student to post a review')}}</p>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="{{route('submitReview')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                                                                <textarea class="lms_summernote" name="review" name=""
                                                                          id=""
                                                                          placeholder="{{__('frontend.Write your review') }}"
                                                                          cols="30"
                                                                          rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn mr-2"
                                    data-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if(isModuleActive('Survey') && $course->survey)
        @include(theme('partials._survey_model'))
    @endif

@endsection
@push('js')
    <script src="{{ asset('public/js/toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/toastr.min.css') }}">
    <script type="text/javascript">
        var course_slug = {!! json_encode($course->slug) !!};
        setInterval(function () {
            $.ajax({
                url: "{{url('interval-auth-check/')}}",
                success: function (data) {
                    if (data == false) {

                        toastr.error("Please Login First To View Video");
                        setInterval(function () {
                            window.location.href = "{{url('courses-details/')}}/" + course_slug;
                        }, 2000);
                    }
                }
            });
        }, 1000 * 60 * 2);
    </script>
    <script>

        $(document).ready(function () {
            if ($('.active').length) {
                let active = $('.active');
                let parent = active.parents('.collapse').first();
                parent.addClass('show');
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            let course = '{{$course->id}}';
            let lesson = '{{$lesson->id}}';

            $("iframe").each(function () {
                //Using closures to capture each one
                var iframe = $(this);
                iframe.on("load", function () { //Make sure it is fully loaded
                    iframe.contents().click(function (event) {
                        iframe.trigger("click");
                    });

                });

                iframe.click(function () {
                    $.ajax({
                        type: 'POST',
                        "_token": "{{ csrf_token() }}",
                        url: '{{route('lesson.complete.ajax')}}',
                        data: {course_id: course, lesson_id: lesson},
                        success: function (data) {

                        }
                    });
                });
            });

            if (window.outerWidth < 425) {
                $('.courseListPlayer').toggleClass("active");
                $('.course_fullview_wrapper').toggleClass("active");
            }


            $(".completeAndPlayNext").click(function () {
                $.ajax({
                    type: 'POST',
                    "_token": "{{ csrf_token() }}",
                    url: '{{route('lesson.complete.ajax')}}',
                    data: {course_id: course, lesson_id: lesson},
                    success: function (data) {
                        if ($('#next_lesson_btn').length) {
                            $('#next_lesson_btn').trigger('click');
                        } else {
                            location.reload();
                        }
                    }
                });
            });
        });


    </script>

    @if ($lesson->host=='Self'|| $lesson->host=='AmazonS3')

        <script>
            let myFP = fluidPlayer(
                'video-id', {
                    "layoutControls": {
                        "controlBar": {
                            "autoHideTimeout": 3,
                            "animated": true,
                            "autoHide": true
                        },
                        "htmlOnPauseBlock": {
                            "html": null,
                            "height": null,
                            "width": null
                        },
                        "autoPlay": true,
                        "mute": false,
                        "hideWithControls": false,
                        "allowTheatre": true,
                        "playPauseAnimation": true,
                        "playbackRateEnabled": false,
                        "allowDownload": false,
                        "playButtonShowing": true,
                        "fillToContainer": true,
                        "posterImage": ""
                    },
                    "vastOptions": {
                        "adList": [],
                        "adCTAText": false,
                        "adCTATextPosition": ""
                    }
                });

        </script>

        @if(!Settings('show_seek_bar'))

            <style>
                div#video-id_fluid_controls_progress_container {
                    display: none;
                }
            </style>
            <script>
                if ($('#video-id').length) {
                    var video = document.getElementById('video-id');
                    var supposedCurrentTime = 0;

                    if (video) {
                        video.addEventListener('timeupdate', function () {
                            if (!video.seeking) {
                                supposedCurrentTime = video.currentTime;
                            }
                        });
                        // prevent user from seeking
                        video.addEventListener('seeking', function () {
                            // guard agains infinite recursion:
                            // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
                            var delta = video.currentTime - supposedCurrentTime;
                            if (Math.abs(delta) > 0.01) {
                                console.log("Seeking is disabled");
                                video.currentTime = supposedCurrentTime;
                            }
                        });
                        // delete the following event handler if rewind is not required
                        video.addEventListener('ended', function () {
                            // reset state in order to allow for rewind
                            console.log('video end');
                            if (!completeRequest) {
                                lessonAutoComplete(course_id, {{showPicName(Request::url())}});
                                completeRequest = true;
                            }
    
                            supposedCurrentTime = 0;
                        });
                    }
                }
            </script>
        @endif

    @endif

    <script src="{{asset('public/frontend/elatihlmstheme/js/class_details.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/full_screen_video.js')}}"></script>
    @if ($lesson->is_quiz==1)
        @if(!$result)
            <script src="{{ asset('public/frontend/elatihlmstheme/js/quiz_start.js') }}"></script>
        @endif
    @endif
    <script src="{{asset('public/backend/js/summernote-bs4.min.js')}}"></script>


    <script>
        if ($('.lms_summernote').length) {
            $('.lms_summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 188,
                tooltip: true
            });
        }

    </script>
    @if($resumption == 1)
        <script type="text/javascript">
            $("#QuizSubmitBtn").click(function () {
                localStorage.clear();
            });

            let assigned_id = "";
            @foreach($questions as $key=>$assign)
            $('a[href="#pills-<?= $assign->id ?>"]').click(function () {
                $(".link_<?= $assign->id ?>").css({
                    'color': '',
                    'background-color': '',
                });
            });
            @endforeach
                @foreach($questions as $key=>$assign)
                assigned_id = <?= $assign->id ?>;
            @foreach(@$assign->questionBank->questionMu as $option)
            if (getSavedValue("<?= $option->question_bank_id . '_' . $option->id . '_' . Auth::user()->id . '_' . $course->id ?>") != "") {
                if (assigned_id != "") {
                    $(".link_" + assigned_id).css({
                        'color': 'white',
                        'background-color': 'red',
                        'border': '2px solidvar red'
                    });
                }
                if (typeof document.getElementById("<?= $option->question_bank_id . '_' . $option->id . '_' . Auth::user()->id . '_' . $course->id ?>").checked != 'undefined') {
                    document.getElementById("<?= $option->question_bank_id . '_' . $option->id . '_' . Auth::user()->id . '_' . $course->id ?>").checked = true;
                } else {
                    document.getElementById("<?= $option->question_bank_id . '_' . $option->id . '_' . Auth::user()->id . '_' . $course->id ?>").value = getSavedValue("<?= $option->question_bank_id . '_' . $option->id . '_' . Auth::user()->id . '_' . $course->id ?>");
                }
            }

            if (getSavedValue("<?= $option->question_bank_id . '_' . Auth::user()->id . '_' . $course->id ?>") != "") {
                if (assigned_id != "") {
                    $("#link_" + assigned_id).css({
                        'color': 'white',
                        'background-color': 'red',
                        'border': '2px solidvar red'
                    });
                }
                document.getElementById("<?= $option->question_bank_id . '_' . Auth::user()->id . '_' . $course->id ?>").value = getSavedValue("<?= $option->question_bank_id . '_' . Auth::user()->id . '_' . $course->id ?>");
            }
            @endforeach
            @endforeach

            /* Here you can add more inputs to set value. if it's saved */

            //Save the value function - save it to localStorage as (ID, VALUE)
            function saveValue(e) {
                var id = e.id;
                var val = e.value;
                localStorage.setItem(id, val);
            }

            function saveValueCheckBox(e) {
                var id = e.id;
                var val = e.value;
                var isChecked = document.getElementById(id).checked;
                if (isChecked) {
                    localStorage.setItem(id, val);
                } else {
                    localStorage.removeItem(id);
                }
            }

            //get the saved value function - return the value of "v" from localStorage.
            function getSavedValue(v) {
                if (!localStorage.getItem(v)) {
                    return "";
                }
                return localStorage.getItem(v);
            }
        </script>
    @endif
@endpush

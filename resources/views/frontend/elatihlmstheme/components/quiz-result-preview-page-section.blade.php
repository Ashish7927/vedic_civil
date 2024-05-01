<div>
    <div class="quiz__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-12">

                            <div class="result_sheet_wrapper mb_30">
                                <!-- quiz_test_header  -->
                                <div class="quiz_test_header">
                                    <h3>{{__('student.Result Sheet')}}</h3>
                                </div>
                                <!-- quiz_test_body  -->
                                {{-- @php dd($quizTest, $course, $questions) @endphp --}}
                                <div class="quiz_test_body">
                                    <div class="result_sheet_view">
                                        @php
                                            $count=1;
                                        @endphp
                                        @if(isset($questions))
                                            @foreach($questions as $question)
                                                <div class="single_result_view">
                                                    <p>{{__('frontend.Question')}}: {{$count}}</p>
                                                    <h4>
                                                        @if($question['type']=="F")
                                                            @php
                                                                $question_data = $question['qus'];
                                                                $quiz_test_all = $quizTest->details;
                                                                // dd($quizTest, $question, $quiz_test_all->toArray());
                                                                if(isset($quiz_test_all)){
                                                                    foreach ($quiz_test_all as $key => $value)
                                                                    {
                                                                        if($value->options){
                                                                            if(isset($value->options->question->type) && $value->options->question->type == 'F' && $question['qus_id'] == $value->options->question->id)
                                                                            {
                                                                                $quiz_test_details = $value;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                
                                                                $option_title = isset($quiz_test_details->options->title) ? $quiz_test_details->options->title : '';
                                                                
                                                                $html = '';
                                                                if($question['isWrong']){
                                                                    $html = '<span style="color: red;"> '.$option_title.' </span>';
                                                                }
                                                                else{
                                                                    $html = '<span style="color: #20e007;"> '.$option_title.' </span>';
                                                                }

                                                                $question_data = str_replace('[]', $html, $question_data);
                                                            @endphp
                                                            {!! @$question_data !!}
                                                        @else
                                                            {!! @$question['qus'] !!}
                                                        @endif
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-lg-6">

                                                            @if($question['type']=="M")
                                                                <ul>
                                                                    @if(!empty($question['option']))
                                                                        @foreach($question['option'] as $option)
                                                                            @if($option['right'])
                                                                                <li>
                                                                                    <label
                                                                                        class="primary_checkbox2 d-flex">
                                                                                        <input checked=""
                                                                                               type="checkbox"
                                                                                               disabled>
                                                                                        <span
                                                                                            class="checkmark mr_10"></span>
                                                                                        <span
                                                                                            class="label_name ">{{$option['title']}}</span>
                                                                                    </label>
                                                                                </li>

                                                                            @else

                                                                                @if(isset($option['wrong']) && $option['wrong'])
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 error_ans  d-flex">
                                                                                            <input checked=""
                                                                                                   type="checkbox"
                                                                                                   disabled>
                                                                                            <span
                                                                                                class="checkmark mr_10"></span>
                                                                                            <span
                                                                                                class="label_name ">{{$option['title']}} </span>
                                                                                        </label>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 d-flex">
                                                                                            <input type="checkbox"
                                                                                                   disabled>
                                                                                            <span
                                                                                                class="checkmark mr_10"></span>
                                                                                            <span
                                                                                                class="label_name ">{{$option['title']}}</span>
                                                                                        </label>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            @elseif($question['type']=="F")
                                                                <ul>
                                                                    @if(!empty($question['option']))
                                                                        @foreach($question['option'] as $option)
                                                            
                                                                            @if(isset($option['right']) && $option['right'])
                                                                                <li>
                                                                                    <label
                                                                                        class="primary_checkbox2 d-flex">
                                                                                        <input checked=""
                                                                                               type="checkbox"
                                                                                               disabled>
                                                                                        <span
                                                                                            class="checkmark mr_10"></span>
                                                                                        <span
                                                                                            class="label_name ">{{$option['title']}}</span>
                                                                                    </label>
                                                                                </li>

                                                                            @else

                                                                                @if(isset($option['wrong']) && $option['wrong'])
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 error_ans  d-flex">
                                                                                            <input checked=""
                                                                                                   type="checkbox"
                                                                                                   disabled>
                                                                                            <span
                                                                                                class="checkmark mr_10"></span>
                                                                                            <span
                                                                                                class="label_name ">{{$option['title']}} </span>
                                                                                        </label>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 d-flex">
                                                                                            <input type="checkbox"
                                                                                                   disabled>
                                                                                            <span
                                                                                                class="checkmark mr_10"></span>
                                                                                            <span
                                                                                                class="label_name ">{{$option['title']}}</span>
                                                                                        </label>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    {{-- @if(isset($question['option']) && count($question['option']) > 0)
                                                                    @foreach($question['option'] as $que_opts)
                                                                        <li style="color: {{ $que_opts['right'] ? '#20e007' : 'red' }}">{{$que_opts['title']}}</li>
                                                                    @endforeach
                                                                    @endif --}}
                                                                </ul>
                                                            @elseif($question['type']=="Mt")
                                                                <ul>
                                                                    @if(!empty($question['option']))
                                                                        @foreach($question['option'] as $option)
                                                                            @if($option['right'])
                                                                                <li>
                                                                                    <label
                                                                                        class="primary_checkbox2 d-flex">
                                                                                        <input checked="" type="checkbox" disabled>
                                                                                        <span class="checkmark mr_10"></span>

                                                                                        <span class="label_name ">{{$option['que_title']}}&nbsp;&nbsp;-&nbsp;&nbsp;</span>

                                                                                        <span class="label_name " style="color: #20e007;">{{$option['ans_title']}}</span>
                                                                                    </label>
                                                                                </li>

                                                                            @else

                                                                                @if(isset($option['wrong']) && $option['wrong'])
                                                                                {{-- @php dd($option) @endphp --}}
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 error_ans  d-flex">
                                                                                            <input checked="" type="checkbox" disabled>
                                                                                            <span class="checkmark mr_10"></span>
                                                                                            <span class="label_name ">{{$option['que_title']}}&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                                                                                            <span class="label_name " style="color: #ff1414">{{$option['wrong_ans_title']}}</span>
                                                                                            <span class="label_name " style="color: #20e007;">&nbsp;&nbsp;{{$option['ans_title']}}</span>
                                                                                        </label>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <label
                                                                                            class="primary_checkbox2 d-flex">
                                                                                            <input type="checkbox" disabled>
                                                                                            <span class="checkmark mr_10"></span>
                                                                                            <span class="label_name ">{{$option['que_title']}}&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                                                                                            <span class="label_name ">&nbsp;&nbsp;{{$option['ans_title']}}</span>
                                                                                        </label>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            @else
                                                                {!! $question['answer'] !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="marking_img">
                                                                @if(isset($question['isSubmit']))
                                                                    @if(isset($question['isWrong']) &&  $question['isWrong'])
                                                                        <img
                                                                            src="{{asset('public/frontend/elatihlmstheme')}}/img/course_details/wrong.png"
                                                                            alt="">
                                                                    @else
                                                                        <img
                                                                            src="{{asset('public/frontend/elatihlmstheme')}}/img/course_details/correct.png"
                                                                            alt="">
                                                                    @endif
                                                                @else
                                                                    <img
                                                                        src="{{asset('public/frontend/elatihlmstheme')}}/img/course_details/wrong.png"
                                                                        alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @endif
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

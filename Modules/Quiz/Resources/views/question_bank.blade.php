@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> {{__('quiz.Quiz')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#"> {{__('quiz.Quiz')}}</a>
                    <a href="#"> {{__('quiz.Question Bank')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($bank))
                @if (permissionCheck('question-bank.store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">

                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                {{-- @dd($bank) --}}
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-20">
                                    @if(isset($bank))
                                        {{__('common.Edit')}}

                                    @else
                                        {{__('common.Add')}}
                                    @endif
                                    {{__('quiz.Question Bank')}}
                                </h3>
                            </div>

                            @if(isset($bank))

                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('question-bank-update',$bank->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'question_bank']) }}

                            @else
                                @if (permissionCheck('question-bank.store'))

                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'question-bank.store',
                                    'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'question_bank']) }}

                                @endif
                            @endif
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            @if(session()->has('message-success'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('message-success') }}
                                                </div>
                                            @elseif(session()->has('message-danger'))
                                                <div class="alert alert-danger">
                                                    {{ session()->get('message-danger') }}
                                                </div>
                                            @endif
                                            <label class="primary_input_label"
                                                   for="groupInput">{{__('quiz.Group')}} *</label>
                                            <select {{ $errors->has('group') ? ' autofocus' : '' }}
                                                    class="primary_select{{ $errors->has('group') ? ' is-invalid' : '' }}"
                                                    name="group" id="groupInput">
                                                <option data-display="{{__('common.Select')}} {{__('quiz.Group')}} *"
                                                        value="">{{__('common.Select')}} {{__('quiz.Group')}}
                                                </option>
                                                @foreach($groups as $group)
                                                    @if(isset($bank))
                                                        <option
                                                            value="{{$group->id}}" {{$group->id == $bank->q_group_id? 'selected': ''}}>{{$group->title}}</option>
                                                    @else
                                                        <option
                                                            value="{{$group->id}}" {{old('group')!=''? (old('group') == $group->id? 'selected':''):''}} >{{$group->title}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                            @if ($errors->has('group'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('group') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="primary_input_label"
                                                   for="category_id">{{__('quiz.Category')}} *</label>
                                            <select {{ $errors->has('category') ? ' autofocus' : '' }}
                                                    class="primary_select {{ $errors->has('category') ? ' is-invalid' : '' }}"
                                                    id="category_id" name="category">
                                                <option data-display=" {{__('quiz.Category')}} *"
                                                        value=""> {{__('quiz.Category')}}
                                                </option>
                                                @foreach($categories as $category)
                                                    @if(isset($bank))
                                                        <option
                                                            value="{{$category->id}}" {{$bank->category_id == $category->id? 'selected': ''}}>{{$category->name}}</option>
                                                    @else
                                                        <option
                                                            value="{{$category->id}}" {{old('category')!=''? (old('category') == $category->id? 'selected':''):''}}>{{$category->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        {{-- <div class="col-lg-4 mt-30-md" id="subCategoryDiv">
                                            <label class="primary_input_label"
                                                   for="subcategory_id">{{__('quiz.Sub Category')}}</label>
                                            <select {{ $errors->has('sub_category') ? ' autofocus' : '' }}
                                                    class="primary_select{{ $errors->has('sub_category') ? ' is-invalid' : '' }} select_section"
                                                    id="subcategory_id" name="sub_category">
                                                <option
                                                    data-display=" {{__('common.Select')}} {{__('quiz.Sub Category')}}"
                                                    value="">{{__('common.Select')}} {{__('quiz.Sub Category')}}
                                                </option>

                                                @if(isset($bank))
                                                    <option value="{{@$bank->subcategory_id}}"
                                                            selected>{{@$bank->subCategory->name}}</option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="sub_category_id" name="sub_category_id" value="{{old('sub_category')}}">
                                            @if ($errors->has('sub_category'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('sub_category') }}</strong>
                                        </span>
                                            @endif
                                        </div> --}}
                                    </div>
                                    {{-- <input type="hidden" name="question_type" value="M"> --}}
                                    <div class="row mt-25">
                                        <div class="col-lg-4">
                                            <label class="primary_input_label"
                                                   for="question-type">{{__('quiz.Question Type')}}</label>
                                            <select {{ $errors->has('question_type') ? ' autofocus' : '' }}
                                                    class="primary_select{{ $errors->has('question_type') ? ' is-invalid' : '' }}"
                                                    name="question_type" id="question-type">
                                                <option data-display="{{__('quiz.Question Type')}} *"
                                                        value="">{{__('quiz.Question Type')}} *
                                                </option>

                                                <option value="M" {{isset($bank)? $bank->type == "M"? 'selected': '' : ''}}
                                                    {{ old('question_type') == "M" ? 'selected':'' }}
                                                    > {{__('Multiple Choice')}}</option>
                                                    }
                                                {{-- <option value="S" {{isset($bank)? $bank->type == "S"? 'selected': '' : ''}}
                                                    {{ old('question_type') == "S" ? 'selected':'' }}> {{__('Short Answer')}} </option>
                                                <option value="L" {{isset($bank)? $bank->type == "L"? 'selected': '' : ''}}
                                                    {{ old('question_type') == "L" ? 'selected':'' }}> {{__('Long Answer')}} </option> --}}
                                                <option value="F" {{isset($bank)? $bank->type == "F"? 'selected': '' : ''}}
                                                    {{ old('question_type') == "F" ? 'selected':'' }}> {{__('Fill In The Blanks')}} </option>
                                                <option value="Mt" {{isset($bank)? $bank->type == "Mt"? 'selected': '' : ''}}
                                                    {{ old('question_type') == "Mt" ? 'selected':'' }}> {{__('Matching Question')}} </option>
                                            </select>
                                            @if ($errors->has('question_type'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('question_type') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-effect">
                                                {{-- <label class="primary_input_label"> {{__('quiz.Marks')}} <span id="marks_required">*</span> </label> --}}
                                                <label class="primary_input_label"> Marks for this question <span id="marks_required">*</span><i class="fas fa-info-circle" data-toggle="tooltip" title="• Marks per Question
                                                    Description: Identify the passing marks for each question which is created for the course
                                                    "></i>
                                                </label>
                                                <input {{ $errors->has('marks') ? ' autofocus' : '' }}
                                                       class="primary_input_field name{{ $errors->has('marks') ? ' is-invalid' : '' }}"
                                                       type="number" name="marks"
                                                       value="{{isset($bank)? $bank->marks:(old('marks')!=''?(old('marks')):'')}}" min="0" max="100" >
                                                <span class="focus-border"></span>
                                                @if ($errors->has('marks'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('marks') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="input-effect">
                                                <label class="primary_input_label"
                                                       for="">{{__('quiz.Image') }}
                                                    ({{__('common.Optional')}})</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder" type="text"
                                                           id=""
                                                           value="{{showPicName(@$bank->image)}}"
                                                           {{$errors->has('image') ? 'autofocus' : ''}}
                                                           placeholder="{{__('courses.Browse Image file')}}"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file_thumb_2">{{__('common.Browse') }}</label>
                                                        <input type="file" class="d-none fileUpload" name="image"
                                                               id="document_file_thumb_2">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-25">
                                        <div class="col-lg-4">
                                                <label>{{__('quiz.Enable Question Feedback')}}</label>
                                                <div class="d-flex radio-btn-flex">
                                                    <div class="mr-30 row mb-25">
                                                        <div class="col-md-12">
                                                            <label
                                                                   class="primary_checkbox d-flex mr-12">
                                                                <input type="radio" name="enable_question_feedback"
                                                                       value="1" {{isset($bank) && $bank->enable_question_feedback == 1 ? "checked" : ""}}
                                                                       class="common-radio relationButton" id="enableQueF">
                                                                <span class="checkmark mr-2"></span> {{__('quiz.Yes')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mr-30 row mb-25">
                                                        <div class="col-md-12">
                                                            <label
                                                                   class="primary_checkbox d-flex mr-12">
                                                                <input type="radio" name="enable_question_feedback"
                                                                       value="0" {{isset($bank) ? $bank->enable_question_feedback == 0 || $bank->enable_question_feedback == null ? "checked" : "" : "checked"}}
                                                                       class="common-radio relationButton">
                                            
                                                                <span class="checkmark mr-2"></span> {{__('quiz.No')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        @if(isset($bank) && $bank->enable_question_feedback == 1)
                                        <div id="questionFeedback" class="col-lg-4">
                                            <div class="input-effect">
                                                <label class="primary_input_label" for="question_feedback">{{__('quiz.Question Feedback')}}</label>
                                                 <textarea {{ $errors->has('question_feedback') ? ' autofocus' : '' }} class="primary_input_field name{{ $errors->has('question_feedback') ? ' is-invalid' : '' }}"
                                                          cols="0" rows="4"
                                                          name="question_feedback">{{isset($bank)? $bank->question_feedback: old('question_feedback')}}</textarea>
                                                <span class="focus-border textarea"></span>
                                                @if($errors->has('question_feedback'))
                                                    <span class="error text-danger"><strong>{{ $errors->first('question_feedback') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <div id="questionFeedback" class="col-lg-4" style="display:none">
                                            <div class="input-effect">
                                                <label class="primary_input_label" for="question_feedback">{{__('quiz.Question Feedback')}}</label>
                                                 <textarea {{ $errors->has('question_feedback') ? ' autofocus' : '' }} class="primary_input_field name{{ $errors->has('question_feedback') ? ' is-invalid' : '' }}"
                                                          cols="0" rows="4"
                                                          name="question_feedback">{{isset($bank)? $bank->question_feedback: old('question_feedback')}}</textarea>
                                                <span class="focus-border textarea"></span>
                                                @if($errors->has('question_feedback'))
                                                    <span class="error text-danger"><strong>{{ $errors->first('question_feedback') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-25 example_question_for_blanks" style="display: none">
                                        <div class="col-lg-12">
                                            Example: The sun rises from [].
                                        </div>
                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <label class="primary_input_label"> {{__('quiz.Question')}} *</label>
                                                <textarea class="textArea lms_summernote {{ @$errors->has('details') ? ' is-invalid' : '' }}"
                                                          cols="30" rows="10" name="question">{{isset($bank)? $bank->question:(old('question')!=''?(old('question')):'')}}</textarea>

                                                <span class="focus-border textarea"></span>
                                                @if ($errors->has('question'))
                                                    <span
                                                        class="error text-danger"><strong>{{ $errors->first('question') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        if(!isset($bank)){
                                            if(old('question_type') == "M"){
                                                $multiple_choice = "";
                                            }
                                        }else{
                                            if($bank->type == "M" || old('question_type') == "M"){
                                                $multiple_choice = "";
                                            }
                                        }
                                    @endphp
                                    <div class="multiple-choice"
                                         id="{{isset($multiple_choice)? $multiple_choice: 'multiple-choice'}}">
                                        <div class="row  mt-25">
                                            <div class="col-lg-8">
                                                <div class="input-effect">
                                                    <label> {{__('quiz.Number Of Options')}}* <i class="fas fa-info-circle" data-toggle="tooltip" title="• Number of Options
                                                        Description: Include how many numbers of options you would like to create for the question.
                                                        "></i>
                                                    </label>
                                                    <input {{ $errors->has('number_of_option') ? ' autofocus' : '' }}
                                                           class="primary_input_field name{{ $errors->has('number_of_option') ? ' is-invalid' : '' }}"
                                                           type="number" name="number_of_option" autocomplete="off"
                                                           id="number_of_option"
                                                           value="{{isset($bank)? $bank->number_of_option: old('number_of_option')}}">
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('number_of_option'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('number_of_option') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2 mt-40">
                                                <button type="button" class="primary-btn small fix-gr-bg"
                                                        id="create-option">{{__('quiz.Create')}} </button>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        if(!isset($bank)){
                                            if(old('question_type') == "M"){
                                                $multiple_options = "";
                                            }
                                        }else{
                                            if($bank->type == "M" || old('question_type') == "M"){
                                                $multiple_options = "";
                                            }
                                        }
                                    @endphp
                                    <div class="multiple-options"
                                         id="{{isset($multiple_options)? "": 'multiple-options'}}">
                                        @php
                                            $i=0;
                                            $multiple_is_old = 0;
                                            $multiple_options = [];

                                            if(isset($bank)){
                                                if($bank->type == "M"){
                                                    $multiple_options = $bank->questionMu;
                                                }
                                            } else {
                                                if(old('option')){
                                                    $multiple_options = old('option');
                                                    $multiple_is_old = 1;
                                                }
                                            }
                                        @endphp
                                        {{-- @php dd($multiple_options); @endphp --}}
                                        @foreach($multiple_options as $multiple_option)
                                            @php $i++; @endphp
                                            <div class='row  mt-25'>
                                                <div class='col-lg-10'>
                                                    <div class='input-effect'>
                                                        <label> {{__('quiz.Option')}} {{$i}}</label>
                                                        @if($multiple_is_old == 1)
                                                        <input class='primary_input_field name' type='text'
                                                               name='option[]' autocomplete='off' required
                                                               {{-- value="{{$multiple_option->title}}"> --}}
                                                               value="{{$multiple_option}}">
                                                        @else
                                                        <input class='primary_input_field name' type='text'
                                                               name='option[]' autocomplete='off' required
                                                               value="{{$multiple_option->title}}">
                                                        @endif
                                                        <span class='focus-border'></span>
                                                    </div>
                                                </div>
                                                <div class='col-lg-2 mt-40'>
                                                    <label class="primary_checkbox d-flex mr-12 "
                                                           for="option_check_{{$i}}" {{__('quiz.Yes')}}>
                                                           @if($multiple_is_old == 1)
                                                           <input type="checkbox"
                                                                  @if (old('option_check_'.$i)==1) checked @endif
                                                                  {{-- @if ($multiple_option->status==1) checked @endif --}}
                                                                  id="option_check_{{$i}}"
                                                               name="option_check_{{$i}}" value="1">
                                                            @else
                                                            <input type="checkbox"
                                                                  @if ($multiple_option->status==1) checked @endif
                                                                  id="option_check_{{$i}}"
                                                               name="option_check_{{$i}}" value="1">
                                                            @endif
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="multiple-choice-fill"
                                         id="multiple-choice-fill">
                                        <div class="row  mt-25">
                                            <div class="col-lg-8">
                                                <div class="input-effect">
                                                    <label> {{__('quiz.Number Of Options')}}* <i class="fas fa-info-circle" data-toggle="tooltip" title="• Number of Options
                                                        Description: Include how many numbers of options you would like to create for the question.
                                                        "></i>
                                                    </label>
                                                    <input {{ $errors->has('number_of_option_fill') ? ' autofocus' : '' }}
                                                           class="primary_input_field name{{ $errors->has('number_of_option_fill') ? ' is-invalid' : '' }}"
                                                           type="number" name="number_of_option_fill" autocomplete="off"
                                                           id="number_of_option_fill"
                                                           value="{{isset($bank)? $bank->number_of_option: old('number_of_option_fill')}}">
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('number_of_option_fill'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('number_of_option_fill') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2 mt-40">
                                                <button type="button" class="primary-btn small fix-gr-bg"
                                                        id="create-option-fill">{{__('quiz.Create')}} </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fill_in_the_blank_opts"
                                         id="fill_in_the_blank_opts"
                                         style="display: {{ (isset($bank) && $bank->type == 'F') ? "block": 'none'}}">

                                        @php
                                            $j=0;
                                            $multiple_is_old_fill = 0;
                                            $fill_options = [];

                                            if(isset($bank)){
                                                if($bank->type == "F"){
                                                    $fill_options = $bank->questionMuInSerial;
                                                }
                                            } else {
                                                if(old('option_fill')){
                                                    $fill_options = old('option_fill');
                                                    $multiple_is_old_fill = 1;
                                                }
                                            }
                                        @endphp
                                        @foreach($fill_options as $key => $fill_option)
                                            @php $j++; @endphp
                                            <div class='row  mt-25'>
                                                <div class='col-lg-10'>
                                                    <div class='input-effect'>
                                                        <label> {{__('quiz.Option')}} {{$j}}</label>
                                                        {{-- <input class='primary_input_field name' type='text'
                                                               name='option_fill[]' autocomplete='off' required
                                                               value=""> --}}
                                                        @if($multiple_is_old_fill == 1)
                                                        <input class='primary_input_field name' type='text'
                                                               name='option_fill[]' autocomplete='off' required
                                                               value="{{$fill_option}}">
                                                        @else
                                                        <input class='primary_input_field name' type='text'
                                                               name='option_fill[]' autocomplete='off' required
                                                               value="{{$fill_option->title}}">
                                                        @endif
                                                        <span class='focus-border'></span>
                                                    </div>
                                                </div>
                                                <div class='col-lg-2 mt-40'>
                                                    <label class="primary_checkbox d-flex mr-12 " {{__('quiz.Yes')}}>
                                                        {{-- <input type="radio" id="option_check_{{$j}}"
                                                               name="option_check_fill" value="{{$key}}"> --}}
                                                        @if($multiple_is_old_fill == 1)
                                                        <input type="radio"
                                                              @if (old('option_check_fill')==$key) checked @endif
                                                              id="option_check_fill_{{$j}}"
                                                              name="option_check_fill" value="{{$key}}">
                                                        @else
                                                        <input type="radio"
                                                              @if ($fill_option->status==1) checked @endif
                                                              id="option_check_fill_{{$j}}"
                                                              name="option_check_fill" value="{{$key}}">
                                                        @endif
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- <div class='row  mt-25'>
                                            <div class='col-lg-10'>
                                                <div class='input-effect'>
                                                    <label> {{__('quiz.Option')}} 2</label>
                                                    <input class='primary_input_field name' type='text'
                                                           name='option_fill[]' autocomplete='off' required>
                                                    <span class='focus-border'></span>
                                                </div>
                                            </div>
                                            <div class='col-lg-2 mt-40'>
                                                <label class="primary_checkbox d-flex mr-12 " {{__('quiz.Yes')}}>
                                                       <input type="radio" id="option_check_2"
                                                           name="option_check_fill" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div> --}}
                                    </div>

                                    {{-- Matching Mt --}}
                                    <div class="multiple-choice-matching" id="multiple-choice-matching">
                                        <div class="row  mt-25">
                                            <div class="col-lg-8">
                                                <div class="input-effect">
                                                    <label> {{__('quiz.Number Of Options')}}* <i class="fas fa-info-circle" data-toggle="tooltip" title="• Number of Options
                                                        Description: Include how many numbers of options you would like to create for the question.
                                                        "></i>
                                                    </label>
                                                    <input {{ $errors->has('number_of_option_for_matching') ? ' autofocus' : '' }}
                                                           class="primary_input_field name{{ $errors->has('number_of_option_for_matching') ? ' is-invalid' : '' }}"
                                                           type="number" name="number_of_option_for_matching" autocomplete="off"
                                                           id="number_of_option_for_matching"
                                                           value="{{isset($bank)? $bank->number_of_option: old('number_of_option_for_matching')}}">
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('number_of_option_for_matching'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('number_of_option_for_matching') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2 mt-40">
                                                <button type="button" class="primary-btn small fix-gr-bg"
                                                        id="create-option-matching">{{__('quiz.Create')}} </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="matching_opts"
                                         id="matching_opts"
                                         style="display: {{ (isset($bank) && $bank->type == 'Mt') ? "block": 'none'}}">

                                        @php
                                            $j=0;
                                            $multiple_is_old_matching = 0;
                                            $matching_options = [];

                                            if(isset($bank)){
                                                if($bank->type == "Mt"){
                                                    $matching_options = $bank->questionMuInSerial->where('match_type', 1);
                                                    $matching_ans_options = $bank->questionMuInSerial->where('match_type', 2);

                                                    // dd($matching_options->count());
                                                }
                                            } else {
                                                if(old('matching_que_opts')){
                                                    $matching_options = old('matching_que_opts');
                                                    if(old('matching_ans_opts')){
                                                        $matching_ans_options = old('matching_ans_opts');
                                                    }
                                                    $multiple_is_old_matching = 1;
                                                }
                                            }
                                            // dd($matching_options);
                                        @endphp
                                        @foreach($matching_options as $key => $option)
                                            @php $j++;
                                            while(!isset($matching_ans_options[$j-1])){
                                                $i = $j++;
                                            }

                                            @endphp
                                            <div class='row  mt-25'>
                                                <div class='col-lg-6'>
                                                    <div class='input-effect'>
                                                        <label> {{__('Question')}} {{$j}}</label>
                                                        @if($multiple_is_old_matching == 1)
                                                        <input class='primary_input_field name' type='text'
                                                               name='matching_que_opts[]' autocomplete='off' required
                                                               value="{{$option}}">
                                                        @else
                                                        <input class='primary_input_field name' type='text'
                                                               name='matching_que_opts[]' autocomplete='off' required
                                                               value="{{$option->title}}">
                                                        @endif
                                                        <span class='focus-border'></span>
                                                    </div>
                                                </div>
                                                <div class='col-lg-6'>
                                                    <div class='input-effect'>
                                                        <label> {{__('Answer')}} {{$j}}</label>
                                                        @if($multiple_is_old_matching == 1)
                                                        <input class='primary_input_field name' type='text'
                                                               name='matching_ans_opts[]' autocomplete='off' required
                                                               value="{{$matching_ans_options[$key]}}">
                                                        @else
                                                        <input class='primary_input_field name' type='text'
                                                               name='matching_ans_opts[]' autocomplete='off' required
                                                               value="{{isset($matching_ans_options[$j-1]) ? $matching_ans_options[$j-1]->title : $matching_ans_options[$i-1]}}">
                                                        @endif
                                                        <span class='focus-border'></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- End : Matching Mt --}}

                                    @php
                                        if(!isset($bank)){
                                            if(old('question_type') == "T"){
                                                $true_false = "";
                                            }
                                        }else{
                                            if($bank->type == "T" || old('question_type') == "T"){
                                                $true_false = "";
                                            }
                                        }
                                    @endphp
                                    <div class="true-false" id="{{isset($true_false)? $true_false: 'true-false'}}">
                                        <div class="row  mt-25">
                                            <div class="col-lg-12 d-flex">
                                                <p class="text-uppercase fw-500 mb-10"></p>
                                                <div class="d-flex radio-btn-flex">
                                                    <div class="mr-30">
                                                        <input type="radio" name="trueOrFalse" id="relationFather"
                                                               value="T"
                                                               class="common-radio relationButton" {{isset($bank)? $bank->trueFalse == "T"? 'checked': '' : 'checked'}}>
                                                        <label for="relationFather"> {{__('quiz.True')}} </label>
                                                    </div>
                                                    <div class="mr-30">
                                                        <input type="radio" name="trueOrFalse" id="relationMother"
                                                               value="F"
                                                               class="common-radio relationButton" {{isset($bank)? $bank->trueFalse == "F"? 'checked': '' : ''}}>
                                                        <label for="relationMother">{{__('quiz.False')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        if(!isset($bank)){
                                            if(old('question_type') == "F"){
                                                $fill_in = "";
                                            }
                                        }else{
                                            if($bank->type == "F" || old('question_type') == "F"){
                                                $fill_in = "";
                                            }
                                        }
                                    @endphp

                                    @php
                                        $tooltip = "";
                                          if (permissionCheck('question-bank.store')){
                                              $tooltip = "";
                                          }else{
                                              $tooltip = "You have no permission to add";
                                          }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                    title="{{$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($bank))
                                                    {{__('common.Update')}}
                                                @else
                                                    {{__('common.Save')}}
                                                @endif
                                                {{__('quiz.Question')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="modal fade admin-query" id="deleteBank">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('question-bank-delete')}}" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>
                        <input type="hidden" name="id" value="" id="classQusId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Delete')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#question-type').change(function(e) {
            var type=$('#question-type').val();

            if (type=="M"){
                $('.multiple-choice').show();
                $('.multiple-options').show();
            }else{
                $('.multiple-choice').hide();
                $('.multiple-options').hide();

            }

            if (type=="S") {
                $('#marks_required').hide();
            }else{
                $('#marks_required').show();
            }

            if (type=="F"){
                $('.multiple-choice-fill').show();
                $('.fill_in_the_blank_opts').show();
                $('.example_question_for_blanks').show();
            }else{
                $('.multiple-choice-fill').hide();
                $('.fill_in_the_blank_opts').hide();
                $('.example_question_for_blanks').hide();
            }

            if (type=="Mt"){
                $('.multiple-choice-matching').show();
                $('.matching_opts').show();
            }else{
                $('.multiple-choice-matching').hide();
                $('.matching_opts').hide();
            }
        });
        $('#question-type').trigger('change');

        $(document).on("click", "#create-option-fill", function(A) {
            $("#question_bank div.fill_in_the_blank_opts").html("");
            for (var t = $("#number_of_option_fill").val(), e = 1; e <= t; e++) {
                var n = "";
                n += "<div class='row  mt-25'>",
                n += "<div class='col-lg-10'>",
                n += "<div class='input-effect'>",
                n += "<input class='primary_input_field name' placeholder='option " + e + "' type='text' name='option_fill[]' autocomplete='off' required>",
                n += "</div>",
                n += "</div>",
                n += "<div class='col-lg-2 mt-15'>",
                n += "<label class='primary_checkbox d-flex mr-12 ' for='option_check_fill_" + e + "'>",
                n += "<input type='radio'  id='option_check_fill_" + e + "' name='option_check_fill' value='" + (e-1) + "'> <span class='checkmark'></span>",
                n += "</label>",
                n += "</div>",
                n += "</div>", $(".fill_in_the_blank_opts").append(n)
            }
        });

        $(document).on("click", "#create-option-matching", function(A) {
            $("#question_bank div.matching_opts").html("");
            for (var t = $("#number_of_option_for_matching").val(), e = 1; e <= t; e++) {
                var n = "";
                n += "<div class='row  mt-25'>",
                n += "<div class='col-lg-6'>",
                n += "<div class='input-effect'>",
                n += "<input class='primary_input_field name' placeholder='question " + e + "' type='text' name='matching_que_opts[]' autocomplete='off' required> <span class='focus-border'></span>",
                n += "</div>",
                n += "</div>",
                n += "<div class='col-lg-6'>",
                n += "<input class='primary_input_field name' placeholder='answer " + e + "' type='text' name='matching_ans_opts[]' autocomplete='off' required> <span class='focus-border'></span>",
                n += "</div>",
                n += "</div>", $(".matching_opts").append(n)
            }
        });

            // 29-06-2022
            $("input[name=enable_question_feedback]").click(function() {
                if(this.id == 'enableQueF') {
                    $('#questionFeedback').show('slow');           
                }
                else {
                    $('#questionFeedback').hide('slow');   
                }
            });

    </script>
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
@endpush

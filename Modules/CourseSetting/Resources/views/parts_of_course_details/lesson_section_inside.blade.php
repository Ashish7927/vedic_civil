@if(isset($editChapter) || isset($editLesson))
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'updateChapter', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
@else
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'saveChapter',
    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
@endif
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/select2.min.css') }}?{{ $version }}"/>
    <style type="text/css">
        .select2.select2-container.select2-container--default{
            width: 100%!important;
            /*border: 1px solid #eceef4!important;*/
            border-radius: 30px!important;
            /*height: 46px!important;*/
            line-height: 44px;
            font-size: 13px;
            color: #415094;
            /*padding: 0 25px 0 20px!important;*/
            font-weight: 300;
        }
        .select2 .select2-selection.select2-selection--single{
            padding-left: 0px;
            border: 1px solid #fff!important;

        }
        .select2-container .select2-selection--single{
            height: 41px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 37px!important;
            height: 40px!important;
            color: #415094!important;
            padding-left: 0px!important;
        }
        .select2 .select2-selection__arrow{
            display: none!important;
        }
        /*.select2.select2-container:after {
            content: "\E62A";
            font-family: themify;
            border: 0;
            transform: rotate(0deg);
            margin-top: -5px;
            font-size: 12px;
            font-weight: 500;
            right: 18px;
            transform-origin: none;
            transition: all .1s ease-in-out;
        }*/

        /*#vimeoVideo:after {
            content: "";
            display: block;
            height: 10px;
            margin-top: 0;
            pointer-events: none;
            position: absolute;
            right: 14px;
            top: 10%;
            transition: all .15s ease-in-out;
            width: auto;
            right: 25px;
            content: "\F0D7";
            border: 0;
            font-family: Font Awesome\ 5 Free;
            font-weight: 900;
            color: #828bb2;
            font-size: 14px;
            transform: translateY(-58%) rotate(0deg);
        }*/
        .self_image_border_none{
            border: none;
        }
    </style>
@endpush
@php
    $key =$key+100;
@endphp
{{-- @dd($editLesson) --}}
<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="chapter_id" value="{{@$chapter->id}}">
<div class="section-white-box">
    <div class="add-visitor">

        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="input_type" value="0" id="">
                <div class="lesson_div">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="input-effect mt-2 pt-1">
                                <label>{{__('courses.Lesson')}} {{__('common.Name')}}
                                    <span>*</span>
                                    <i class="fas fa-info-circle" data-toggle="tooltip" title="• The Lesson names
                                    Description: Maximum 100 characters including spaces.
                                    "></i></label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    type="text" name="name"
                                    placeholder="{{__('courses.Lesson')}} {{__('common.Name')}}"
                                    autocomplete="off"
                                    value="{{isset($editLesson)? $editLesson->name:''}}">
                                <input type="hidden" name="lesson_id"
                                       value="{{isset($editLesson)? $editLesson->id: ''}}">
                                <span class="focus-border"></span>
                                @if ($errors->has('chapter_name'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('chapter_name') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">

                            <div class="input-effect mt-2 pt-1">
                                <label>{{__('common.Duration')}} ({{__('common.In Minute')}}) </label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    min="0" step="any" type="number" name="duration"
                                    placeholder="{{__('courses.Duration')}}"
                                    autocomplete="off"
                                    value="{{isset($editLesson)? $editLesson->duration:''}}">

                                <span class="focus-border"></span>
                                @if ($errors->has('chapter_name'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('chapter_name') }}</strong>
                                            </span>
                                @endif
                            </div>

                            @if(isModuleActive('Org'))
                                @include('coursesetting::parts_of_course_details._org_host_select')
                            @endif


                            <div class="defaultHost {{isModuleActive('Org')?'d-none':''}}">
                                <div class="input-effect mt-2 pt-1">
                                    <label class="primary_input_label mt-1"
                                           for=""> {{__('courses.Host')}}
                                        <span>*</span></label>


                                    <select class="primary_select category_id host_select" name="host"
                                            data-key="{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                            id="category_id{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Host')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Host')}} </option>

                                        <option
                                            value="Self" {{isset($editLesson) ? $editLesson->host=='Self'? 'selected':'':'' }} >
                                            Video
                                        </option>
                                          <option
                                            value="VdoCipher" {{isset($editLesson) ? $editLesson->host=='VdoCipher'? 'selected':'':'' }} >
                                            VdoCipher
                                        </option>

                                        <option
                                            value="Image" {{isset($editLesson) ? $editLesson->host=='Image'? 'selected':'':'' }} >
                                            Image
                                        </option>
                                        <option
                                            value="PDF" {{isset($editLesson) ? $editLesson->host=='PDF'? 'selected':'':'' }} >
                                            PDF File
                                        </option>
                                        <option
                                            value="Word" {{isset($editLesson) ? $editLesson->host=='Word'? 'selected':'':'' }} >
                                            Word File
                                        </option>
                                        <option
                                            value="Excel" {{isset($editLesson) ? $editLesson->host=='Excel'? 'selected':'':'' }} >
                                            Excel File
                                        </option>
                                        <option
                                            value="Text" {{isset($editLesson) ? $editLesson->host=='Text'? 'selected':'':'' }} >
                                            Text File
                                        </option>
                                      {{--  <option
                                            value="Zip" {{isset($editLesson) ? $editLesson->host=='Zip'? 'selected':'':'' }} >
                                            Zip File
                                        </option> --}}
                                        <option
                                            value="PowerPoint" {{isset($editLesson) ? $editLesson->host=='PowerPoint'? 'selected':'':'' }} >
                                            Power Point File
                                        </option>

                                    </select>
                                    @if ($errors->has('host'))
                                        <span class="invalid-feedback invalid-select"
                                              role="alert">
                                                                        <strong>{{ $errors->first('host') }}</strong>
                                                                    </span>
                                    @endif
                                </div>
                            {{--    @if(isModuleActive('SCORM'))
                                    <div
                                        class="input-effect mt-2 pt-1 {{ isset($editLesson) && $editLesson->host != 'SCORM' ? 'd-none' : '' }}"
                                        id="scorm_vendor_type">
                                        <div class="" id="">
                                            <label class="primary_input_label mt-1"
                                                   for="">{{__('courses.scorm_vendor_type')}}
                                                <span>*</span> </label>
                                            <select class="primary_select" name="scorm_vendor_type">
                                                @if(!isset($editLesson))
                                                    <option
                                                        data-display="{{__('common.Select')}} Vendor Type "
                                                        value="">{{__('common.Select')}} {{__('courses.SCORM Vendor')}}
                                                    </option>
                                                @endif
                                                <option
                                                    {{isset($editLesson) ? $editLesson->scorm_vendor_type=='ispring'? 'selected':'':'' }}
                                                    value="ispring">{{__('courses.Ispring')}} </option>

                                                <option
                                                    {{isset($editLesson) ? $editLesson->scorm_vendor_type=='storyline'? 'selected':'':'' }}
                                                    value="storyline">{{__('courses.Story Line')}} </option>

                                                <option
                                                    {{isset($editLesson) ? $editLesson->scorm_vendor_type=='other'? 'selected':'':'' }}
                                                    value="other">{{__('courses.Other')}} </option>

                                            </select>
                                            @if ($errors->has('scorm_vendor_type'))
                                                <span class="invalid-feedback invalid-select"
                                                      role="alert">
                                            <strong>{{ $errors->first('scorm_vendor_type') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif --}}

                                <div class="input-effect mt-2 pt-1"
                                     id="videoUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display:@if((isset($editLesson) && ($editLesson->host!="Youtube"  && $editLesson->host!="URL")) || !isset($editLesson)) none  @endif">
                                    <label>{{__('courses.Video URL')}}
                                        <span>*</span></label>
                                    <input
                                        id="youtubeVideo"
                                        class="primary_input_field name{{ $errors->has('video_url') ? ' is-invalid' : '' }}"
                                        type="text" name="video_url"
                                        placeholder="{{__('courses.Video URL')}}"
                                        autocomplete="off"
                                        value="@if(isset($editLesson)) @if($editLesson->host=="Youtube" || $editLesson->host=="URL"){{$editLesson->video_url}} @endif @endif">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('video_url'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="iframeBox{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="Iframe")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">

                                        <label>{{__('courses.Iframe URL')}}
                                            <span>*</span></label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('iframe_url') ? ' is-invalid' : '' }}"
                                            type="text" name="iframe_url"
                                            placeholder="{{__('courses.Iframe (Provide the source only)')}}"
                                            autocomplete="off"
                                            value="@if(isset($editLesson)) @if($editLesson->host=="Iframe"){{$editLesson->video_url}} @endif @endif">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('video_url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="vimeoUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="Vimeo")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">
                                        @if(config('vimeo.connections.main.upload_type')=="Direct")
                                            <div class="primary_file_uploader">
                                                <input
                                                    class="primary-input filePlaceholder"
                                                    type="text"
                                                    id=""
                                                    {{$errors->has('image') ? 'autofocus' : ''}}
                                                    placeholder="{{__('courses.Browse Video file')}}"
                                                    readonly="">
                                                <button class="" type="button">
                                                    <label
                                                        class="primary-btn small fix-gr-bg"
                                                        for="document_file_thumb_vimeo_lesson_section_insider{{$key}}">{{__('common.Browse') }}</label>
                                                    <input type="file"
                                                           class="d-none fileUpload"
                                                           name="vimeo"
                                                           id="document_file_thumb_vimeo_lesson_section_insider{{$key}}">
                                                </button>
                                            </div>
                                        @else
                                            <select class="select2" name="vimeo" id="vimeoVideo">
                                                <option
                                                    data-display="{{__('common.Select')}} video "
                                                    value="">{{__('common.Select')}} video
                                                </option>
                                            </select>
                                        @endif
                                        @if ($errors->has('vimeo'))
                                            <span class="invalid-feedback invalid-select"
                                                  role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-effect mt-2 pt-1"
                                     id="VdoCipherUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="VdoCipher")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">

                                        <select class=" lessonVdocipher VdoCipherVideoLesson" name="vdocipher"
                                                {{--id="VdoCipherVideoLesson{{$key}}"--}}

                                        >
                                            <option
                                                data-display="{{__('common.Select')}} video "
                                                value="">{{__('common.Select')}} video
                                            </option>
                                            @if(isset($editLesson))
                                                <option
                                                    value="{{$editLesson->video_url}}" selected>
                                                </option>
                                            @endif
                                        </select>
                                        @if ($errors->has('vdocipher'))
                                            <span class="invalid-feedback invalid-select"
                                                  role="alert">
                                                                            <strong>{{ $errors->first('vdocipher') }}</strong>
                                                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="fileupload{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && (($editLesson->host=="Vimeo") ||  ($editLesson->host=="Youtube")|| ($editLesson->host=="VdoCipher")|| ($editLesson->host=="Iframe")||  ($editLesson->host=="URL")) ) || !isset($editLesson)) none  @endif">
                                    <input type="file" class="filepond"
                                           name="file"
                                           id="">

                                    <input class="primary_input_field self_image_border_none" type="text" name="self_image" id=""
                                                                               value="{{ isset($editLesson->video_url) ? showPicName(@$editLesson->video_url):'91b6470cc44910da5fe62058c0b7cb13.jpg' }}" readonly>

                                </div>

                            </div>


                            <div class="input-effect mt-2 pt-1">
                                <div class="" id="">
                                    <label class="primary_input_label mt-1"
                                           for="">{{__('courses.Privacy')}}
                                        <span>*</span> </label>
                                    <select class="primary_select" name="is_lock">
                                        <option
                                            data-display="{{__('common.Select')}} {{__('courses.Privacy')}} "
                                            value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                        @if(isset($editLesson))
                                            <option value="0"
                                                    @if ( @$editLesson->is_lock==0) selected @endif >{{__('courses.Unlock')}}</option>
                                            <option value="1"
                                                    @if (@$editLesson->is_lock==1) selected @endif >{{__('courses.Locked')}}</option>
                                        @else
                                            <option
                                                value="0">{{__('courses.Unlock')}}</option>
                                            <option value="1"
                                                    selected>{{__('courses.Locked')}}</option>
                                        @endif


                                    </select>
                                    @if ($errors->has('is_lock'))
                                        <span class="invalid-feedback invalid-select"
                                              role="alert">
                                                                            <strong>{{ $errors->first('is_lock') }}</strong>
                                                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-effect mt-2 pt-1">
                                <label>{{__('common.Description')}}
                                  <i class="fas fa-info-circle" data-toggle="tooltip" title="• Lesson Description
                                   Description: Summary of the lesson on what learners will gain from the lesson.
                                   "></i>
                                </label>

                                <textarea class="primary_textarea height_128" name="description"

                                          id="description" cols="30"
                                          rows="10">{{isset($editLesson)? $editLesson->description:''}}</textarea>


                                <span class="focus-border"></span>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row mt-40">
            <div class="col-lg-12 text-center">
                <button type="submit" class="primary-btn fix-gr-bg"
                        data-toggle="tooltip">
                    <span class="ti-check"></span>
                    {{__('common.Save')}}
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

@push('js')
    <script src="{{asset('frontend/elatihlmstheme/js/select2.min.js')}}"></script>
    <script>
        var scorm_vendor_type = $('#scorm_vendor_type');
        var host_e = $('.host_select').val();
        scorm_vendor_type.hide();
        if (host_e == 'SCORM') {
            scorm_vendor_type.show();
        }

        $('.host_select').change(function () {

            var host_e = $('.host_select').val();
            scorm_vendor_type.hide();
            if (host_e == 'SCORM') {
                scorm_vendor_type.show();
            }
        });
        $(".select2").select2({
            ajax: {
                url: "{{ route('select2.vimeo.video.list') }}",
                dataType: 'json',
                delay: 250,
                data: function(params){
                    return {
                        term: params.term,
                        _type: "query",
                        q: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        // $(document).on('keydown', '.select2-search__field', function(e){

        //     var value = $(this).val().length;
        //     console.log(value);
        //     if(value > 2){
        //         // alert('a');
        //         console.log('log');
        //         $(".select2").select2({
        //             ajax: {
        //                 url: "{{ route('select2.vimeo.video.list') }}",
        //                 dataType: 'json',
        //                 delay: 250,
        //                 data: function(params){
        //                     return {
        //                         term: params.term,
        //                         _type: "query",
        //                         q: params.term,
        //                     };
        //                 },
        //                 processResults: function (data) {
        //                     return {
        //                         results:  $.map(data, function (item) {
        //                             return {
        //                                 text: item.name,
        //                                 id: item.id
        //                             }
        //                         })
        //                     };
        //                 }
        //             }
        //         })
        //     }
        // });

    </script>
@endpush

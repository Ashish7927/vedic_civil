@push('styles')
<style>
        .loading-spinner {
            display: none;
        }

        .loading-spinner.active {
            display: inline-block;
        }
            .dd , .dd_1{
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


            .dd-handle {
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
                cursor: grab;

            }


            .dd-handle .menu_icon {
                float: left;
                padding: 0px 16px;
                font-size: 14px;
                font-weight: 400;
                border: 0;
                border: 1px solid #F5F7FB;
                box-sizing: border-box;
                border-radius: 23px 0px 0px 23px;
                color: #415094;
                background: #fff;
                height: 46px;
                margin-right: 12px;
                position: absolute;
                left: 0;
                top: 0;
            }


            .edit_icon {
                float: right;
                cursor: pointer;
                font-size: 16px;
                color: #707DB7;
                font-weight: 400;
                padding-right: 20px;
                height: 46px;
                line-height: 46px;
                position: absolute;
                right: 0;
                top: 0;
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


            .dd-item > button[data-action="collapse"]:before {
                content: '\e622';
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


            .dd-dragel {
                position: absolute;
                pointer-events: none;
                z-index: 9999;
            }


            .dd-dragel > .dd-item .dd-handle {
                margin-top: 0;
            }


            .dd-dragel .dd-handle {
                -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
                box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
            }

            /**
            * Nestable Extras
            */

            /* .nestable-lists {
                display: block;
                clear: both;
                padding: 30px 0;
                width: 100%;
                border: 0;
                border-top: 2px solid #ddd;
                border-bottom: 2px solid #ddd;
            } */

            @media only screen and (min-width: 700px) {

                .dd + .dd , .dd_1 + .dd_1 {
                    margin-left: 2%;
                }
            }


            .dd-hover > .dd-handle {
                background: #2ea8e5 !important;
            }


            .dd-dragel > .dd3-item > .dd3-content {
                margin: 0;
            }

            .collapge_arrow_normal::after {
                content: "\f107";
                color: #ffffff;
                top: 4px;
                right: 4px;
                padding-top: 5px;
                position: absolute;
                font-family: "Font Awesome\ 5 Free";
            }

            .panel-title[aria-expanded="true"] .collapge_arrow_normal::after {
                content: "\f106";
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

            .settingBtn{
                position: absolute;
                left: 11px;
                top: 14px;;
            }

        </style>
@endpush

<!-- FREE FEATURED COURSE LIST start-->
<div class="col-xl-6 free_featured_courses mb-25">
    <label class="primary_input_label" for="">Free Featured Courses</label>
    @if(isset($free_featured_courses) && count(@$free_featured_courses)>0)
       <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="dd_2 dd">
                            <ol class="dd-list" id="multi_free_course_list">
                                @foreach($free_featured_courses as $key => $f_course)
                                <?php $course = \Modules\CourseSetting\Entities\Course::find($f_course->course_id); 
                                ?>
                                    @if(isset($course))
                                    <li class="dd-item" data-id="{{ $f_course->id }}" data-type="{{ $f_course->type }}">
                                        <div class="card accordion_card" id="accordion_{{$f_course->id}}">
                                            <div class="card-header item_header" id="heading_{{$f_course->id}}">
                                                <div class="dd-handle">
                                                    <div class="float-left">
                                                        {{$f_course->course_title}}
                                                    </div>
                                                </div>
                                                <div class="float-right btn_div">
                                                    <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                                        data-target="#collapse_{{$f_course->id}}" aria-expanded="false"
                                                        aria-controls="collapse_{{$f_course->id}}"
                                                        class="primary-btn small fix-gr-bg text-center button panel-title">
                                                        <i class="ti-settings settingBtn"></i>
                                                        <span class="collapge_arrow_normal"></span>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="elementDelete({{$f_course->id}})"
                                                       class="primary-btn small fix-gr-bg text-center button">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div id="collapse_{{$f_course->id}}" class="collapse"
                                             aria-labelledby="heading_{{$f_course->id}}"
                                             data-parent="#accordion_{{$f_course->id}}">
                                                <div class="card-body">
                                                    <form enctype="multipart/form-data" class="elementEditForm">
                                                        <div class="row">
                                                            <input type="hidden" name="id" class="id"
                                                                value="{{$f_course->id}}">
                                                            <input type="hidden" name="type" class="type"
                                                                value="{{$f_course->type}}">
                                                            
                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <img class="imagePreview_course_thumbnail_{{ $f_course->id }}"
                                                                             style="max-width: 100%"
                                                                             src="{{ file_exists($f_course->thumbnail) ? asset('/'.$f_course->thumbnail) : asset('/'.$course->thumbnail) }}"
                                                                             alt="">
                                                                    </div> 
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('courses.Thumbnail Image') }}
                                                                            <small>({{__('common.Recommended Size')}} )
                                                                            </small>
                                                                        </label>
                                                                        <div class="primary_file_uploader">
                                                                            <input class="primary-input  filePlaceholder {{ @$errors->has('course_thumbnail_' . $f_course->id ) ? ' is-invalid' : '' }}" type="text" id="" 
                                                                                    placeholder="Browse file" 
                                                                                    readonly="" {{ $errors->has('course_thumbnail_' . $f_course->id ) ? ' autofocus' : '' }}>
                                                                            <button class="" type="button">
                                                                                <label class="primary-btn small fix-gr-bg"
                                                                                        for="course_thumbnail_{{ $f_course->id }}">{{ __('common.Browse') }}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload imgInput_1"
                                                                                       name="course_thumbnail_{{ $f_course->id }}" id="course_thumbnail_{{ $f_course->id }}">
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 text-center">
                                                                    <div class="d-flex justify-content-center pt_20">
                                                                        <button type="button"
                                                                                class="editBtn{{ $f_course->id  }} primary-btn fix-gr-bg"><i
                                                                                    class="ti-check"></i>
                                                                                    <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
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
                                    @endif
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
</div>
<!-- FREE FEATURED COURSE LIST end-->

<!-- PREMIUM FEATURED COURSE LIST strat-->
<div class="col-xl-6 premium_featured_courses mb-25">
    <label class="primary_input_label" for="">Premium Featured Courses</label>
    @if(isset($premium_featured_courses) && count(@$premium_featured_courses)>0)
       <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="dd">
                            <ol class="dd-list" id="multi_premium_course_list">
                                @foreach($premium_featured_courses as $key => $p_course)
                                <?php $course = \Modules\CourseSetting\Entities\Course::find($p_course->course_id);
                                ?>
                                    @if(isset($course))
                                    <li class="dd-item" data-id="{{$p_course->id}}">
                                        <div class="card accordion_card" id="accordion_{{$p_course->id}}">
                                            <div class="card-header item_header" id="heading_{{$p_course->id}}">
                                                <div class="dd-handle">
                                                    <div class="float-left">
                                                        {{$p_course->course_title}}
                                                    </div>
                                                </div>
                                                <div class="float-right btn_div">
                                                    <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                                        data-target="#collapse_{{$p_course->id}}" aria-expanded="false"
                                                        aria-controls="collapse_{{$p_course->id}}"
                                                        class="primary-btn small fix-gr-bg text-center button panel-title">
                                                        <i class="ti-settings settingBtn"></i>
                                                        <span class="collapge_arrow_normal"></span>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="elementDelete({{$p_course->id}})"
                                                       class="primary-btn small fix-gr-bg text-center button">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="collapse_{{$p_course->id}}" class="collapse"
                                             aria-labelledby="heading_{{$p_course->id}}"
                                             data-parent="#accordion_{{$p_course->id}}">
                                                <div class="card-body">
                                                    <form enctype="multipart/form-data" class="elementEditForm">
                                                        <div class="row">
                                                            <input type="hidden" name="id" class="id"
                                                                value="{{$p_course->id}}">
                                                            <input type="hidden" name="type" class="type"
                                                                value="{{$p_course->type}}">

                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <img class=" imagePreview_course_thumbnail_{{ $p_course->id }}"
                                                                             style="max-width: 100%"
                                                                             src="{{ file_exists($p_course->thumbnail) ? asset('/'.$p_course->thumbnail) : asset('/'.$course->thumbnail) }}"
                                                                             alt="">
                                                                    </div> 
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('courses.Thumbnail Image') }}
                                                                            <small>({{__('common.Recommended Size')}} )
                                                                            </small>
                                                                        </label>
                                                                        <div class="primary_file_uploader">
                                                                            <input class="primary-input  filePlaceholder {{ @$errors->has('course_thumbnail_' . $p_course->id) ? ' is-invalid' : '' }}" type="text" id=""
                                                                                    placeholder="Browse file" 
                                                                                    readonly="" {{ $errors->has('course_thumbnail_' . $p_course->id) ? ' autofocus' : '' }}>
                                                                            <button class="" type="button">
                                                                                <label class="primary-btn small fix-gr-bg"
                                                                                        for="course_thumbnail_{{ $p_course->id }}">{{ __('common.Browse') }}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload imgInput_2"
                                                                                       name="course_thumbnail_{{ $p_course->id }}" id="course_thumbnail_{{ $p_course->id }}">
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="col-lg-12 text-center">
                                                                <div class="d-flex justify-content-center pt_20">
                                                                    <button type="button"
                                                                            class="editBtn{{ $p_course->id }} primary-btn fix-gr-bg"><i
                                                                                class="ti-check"></i>
                                                                                <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
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
                                    @endif
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
</div>
<!-- PREMIUM FEATURED COURSE LIST end-->

<!-- Delete Course Element Module -->
        <div class="modal fade admin-query" id="deleteCourseItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.Delete') Course Item</h4>
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
                            <a class="primary-btn fix-gr-bg" id="delete-item" href="#">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
        function readURLCourseThumbnail(input) {
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

        $("input[id^='course_thumbnail_']").change(function () {
            readURLCourseThumbnail(this);
        });

        function loaderstop() {
            $('#add_courses_btn').prop('disabled', false);
            $('.loading-spinner').removeClass('active');
            $('.ti-plus').show();
            $('.ti-check').hide();
        }
        function loaderstart() {
            $('#add_courses_btn').prop('disabled', true);
            $('.loading-spinner').addClass('active');
            $('.ti-plus').hide();
            $('.ti-check').hide();
        }
        function blankData() {
            $('#premimum_multi_course_input').val('').trigger('change');
            $('#free_multi_course_input').val('').trigger('change');
        }
        function reloadWithData(response) {
            $('#courseList').empty();
            $('#courseList').html(response);
        }

    $(document).on('click', "button[class^='editBtn']", function (event) {
        var id = $(this).closest("form").find('.id').val();
        // var course_thumbnail = $(this).closest("form").find(".imgInput_2")[0].files;
        var course_thumbnail = $(this).closest("form").find("input[id^=course_thumbnail_]")[0].files;
        var fd = new FormData();
        
        // Check file selected or not
        if(course_thumbnail.length > 0 ){
            fd.append('course_thumbnail',course_thumbnail[0]);
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('id', id);
        
            $(this).prop('disabled', true);
            $(this).find('.loading-spinner').addClass('active');
            $(this).find('.ti-check').hide();
            $.ajax({
                url: "{{ route('frontend.editFeaturedCourseElement') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if (response) {
                        toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                        $(this).prop('disabled', false);
                        $(this).find('.loading-spinner').removeClass('active');
                        $(this).find('.ti-check').show();
                        reloadWithData(response);
                    } else {
                        toastr.error("Operation failed", "Error", { timeOut: 5000, });
                        $(this).prop('disabled', false);
                        $(this).find('.loading-spinner').removeClass('active');
                        $(this).find('.ti-check').show();
                    }
                },
            });
        }else{
           alert("Please select a file.");
        }
    
    });

$('#add_courses_btn').on('click', function (event) {
    let free_courses = $('#free_multi_course_input').val();
    let premium_courses = $('#premimum_multi_course_input').val();
    let url = "{{ route('frontend.addFeaturedCourse') }}";

    let numOfInputItemFreeCourses = free_courses.length;
    let numOfInputItemPreCourses = premium_courses.length;
    let itemLimit = 20;
    let freeCourseItems = $('#multi_free_course_list').children('li').length;
    let premiumCourseItems = $('#multi_premium_course_list').children('li').length;

    if ((numOfInputItemFreeCourses + freeCourseItems) <= itemLimit && (numOfInputItemPreCourses + premiumCourseItems) <= itemLimit) {
        
        let data = {
            'free_courses': free_courses,
            'premium_courses': premium_courses,
            '_token': '{{ csrf_token() }}'
        }
        loaderstart();
        $.post(url, data, function (data) {
            if (data) {
                blankData();
                toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                reloadWithData(data);
                loaderstop();
            } else {
                toastr.error("Operation failed", "Error", { timeOut: 5000, });
                loaderstop();
            }
        });
    } else {
        event.preventDefault();
        let itemRemove1 = 0;
        let itemRemove2 = 0;
        itemRemove1 = (numOfInputItemFreeCourses + freeCourseItems) - itemLimit;
        itemRemove2 = (numOfInputItemPreCourses + premiumCourseItems) - itemLimit;
        if ((numOfInputItemFreeCourses + freeCourseItems) > itemLimit) {
            toastr.error('The maximum length for Free Featured Course list is 20 items. <br/>Please remove ' + itemRemove1 + ' items.', 'Failed', { timeOut: 5000, });
        } else if ((numOfInputItemPreCourses + premiumCourseItems) > itemLimit) {
            toastr.error('The maximum length for Premium Featured Course list is 20 items. <br/>Please remove ' + itemRemove2 + ' items.', 'Failed', { timeOut: 5000, });
        } else {
            toastr.error('The maximum length for these two Featured Course list is 20 items', 'Failed');
        }
    }

});


$(document).ready(function () {
    let url = "{{ route('frontend.reorderingFeaturedCourse') }}";
    $(document).on('mouseover', 'body', function (e) {
 
        // free_courses list
        $('.dd_2').nestable({
            maxDepth: 3,
            callback: function (l, e) {
                let order = JSON.stringify($('.dd_2').nestable('serialize'));
                
                let data = {
                    'order': order,
                    '_token': '{{ csrf_token() }}'
                }
                $.post(url, data, function (data) {
                    if (data != 1) {
                        toastr.error("Element is Not Moved. Error ocurred", "Error", { timeOut: 5000, });
                    }
                });
            }
        });

        // premium_course list
        $('.dd').nestable({
            maxDepth: 3,
            callback: function (l, e) {
                let order = JSON.stringify($('.dd').nestable('serialize'));
                
                let data = {
                    'order': order,
                    '_token': '{{ csrf_token() }}'
                }
                $.post(url, data, function (data) {
                    if (data != 1) {
                        toastr.error("Element is Not Moved. Error ocurred", "Error", { timeOut: 5000, });
                    }
                });
            }
        });
    });
});

function elementDelete(id) {

    $('#deleteCourseItem').modal('show');
    $('#item-delete').val(id);
}

$(document).on('click', '#delete-item', function (event) {
    event.preventDefault();
    let url = "{{ route('frontend.deleteFeaturedCourse') }}";
    $('#deleteCourseItem').modal('hide');
    let id = $('#item-delete').val();
    let data = {
        'id': id,
        '_token': '{{ csrf_token() }}',
    }
    $.post(url, data,
        function (data) {
            reloadWithData(data);
        });
});

</script>
@endpush
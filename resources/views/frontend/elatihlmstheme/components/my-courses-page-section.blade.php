<style>.theme_select .list .option{ padding-top: 17px;line-height: 19px;}</style>
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/elatihlmstheme/css/elatih-frontend-css.css') }}" />
<div>
    <div class="main_content_iner main_content_padding">
        <div class="container">
            <div class="my_courses_wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 margin-50">
                            <h3>
                                @if( routeIs('myClasses'))
                                    {{__('courses.Live Class')}}
                                @elseif( routeIs('myQuizzes'))
                                    {{__('courses.My Quizzes')}}
                                @else
                                    {{__('courses.My Courses')}}
                                @endif
                            </h3>
                        </div>
                    </div>

                    @php
                        if (routeIs('myClasses')){
                            $search_text = trans('frontend.Search My Classes');
                            $search_route ='';
                        }elseif (routeIs('myQuizzes')){
                            $search_text = trans('frontend.Search My Quizzes');
                            $search_route ='';
                        }else{
                            $search_text = trans('frontend.Search My Courses');
                            $search_route ='';
                        }
                    @endphp
                    <div class="col-xl-8 col-md-8">
                        <div class="short_select d-flex align-items-center pt-0 pb-3">
                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Filter By')}}:</h5>
                            <input type="hidden" id="siteUrl" value="{{route(\Request::route()->getName())}}">
                            <select class="theme_select my-course-select w-100" id="categoryFilter">
                                <option value=""
                                        data-display="{{__('frontend.All Categories')}}">{{__('frontend.All Categories')}}</option>
                                @foreach($categories  as $category)
                                    <option
                                        value="{{$category->id}}" {{@$category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            &nbsp;
                            <select class="theme_select my-course-select w-100" id="courceFilter">
                                <option value="" data-display="">{{__('common.Select')}}</option>
                                <option value="enrolled" <?php if(isset($_GET['cource'])){ if($_GET['cource']=='enrolled'){ echo 'selected'; } } ?>>{{__('frontend.Course Purchased')}}
                                </option>
                                <option value="progress" <?php if(isset($_GET['cource'])){ if($_GET['cource']=='progress'){ echo 'selected'; } } ?>>{{__('frontend.Course In Progress')}}
                                </option>
                                <option value="complete" <?php if(isset($_GET['cource'])){ if($_GET['cource']=='complete'){ echo 'selected'; } } ?>>{{__('frontend.Completed Courses')}}
                                </option>
                            </select>
                            &nbsp;
                            <select class="theme_select my-course-select w-100" id="versionFilter">
                                <option value="" data-display="{{__('setting.Version')}}">{{__('common.Select')}} {{__('setting.Version')}}</option>
                                <option value="free" <?php if(isset($_GET['version'])){ if($_GET['version']=='free'){ echo 'selected'; } } ?>>Free</option>
                                <option value="paid" <?php if(isset($_GET['version'])){ if($_GET['version']=='paid'){ echo 'selected'; } } ?>>Premium</option>
                            </select>

                        </div>
                    </div>
                    <div class=" col-xl-4 col-md-4">
                        <form action="{{route(\Request::route()->getName())}}">
                            <div class="input-group theme_search_field pt-0 pb-3 float-right" style="width: 95%;">
                                <div class="input-group-prepend">
                                    <button class="btn" type="button" id="button-addon1"><i
                                            class="ti-search"></i>
                                    </button>
                                </div>

                                <input type="text" class="form-control" name="search"
                                       placeholder="{{$search_text}}" value="{{$search}}"
                                       onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = '{{$search_text}}'">

                            </div>
                        </form>
                    </div>

                    @if(isset($courses))
                        @foreach ($courses as $SingleCourse)
                            @php
                                $course=$SingleCourse->course;
                            @endphp
                                @if($course->type==1)
                                @if($courcefilter=='' || $courcefilter=='enrolled')
                            <div class="col-xl-4 col-md-6">
                                    <div class="couse_wizged">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">

                                                <x-price-tag :price="$course->price"
                                                             :discount="$course->discount_price"
                                                             :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>

                                            </div>

                                        </div>
                                        <div class="course_content">
                                            <input type="hidden" value="{{$SingleCourse->id}}" id="get_single_course_id"/>

                                            @if($SingleCourse->status == 1)
                                                <a href="{{route('continueCourse',[$course->slug])}}">
                                                    <h4 class="noBrake" title="{{$course->title}}">
                                                        {{$course->title}}
                                                    </h4>
                                                </a>
                                            @else
                                                <a href="#activation-courses">
                                                    <h4 class="noBrake" title="{{$course->title}}">
                                                        {{$course->title}}
                                                    </h4>
                                                </a>
                                            @endif

                                            <div class="modal" tabindex="-1" id="learnerActivationCourses_{{$SingleCourse->id}}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content modal-content-activate-courses">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('common.Activate Course')}}</h4>
                                                            <button type="button" class="close" data-dismiss="modal"><i
                                                                    class="ti-close "></i></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="{{route('learnerActivationCourse')}}" method="POST">
                                                                @csrf
                                                                <div class="text-center">

                                                                    <h4>{{__('common.Are you sure want to activate this course ?')}}</h4>
                                                                    <span>{{__('common.Course')}} {{__('common.Name')}}: {{$course->title}}</span>
                                                                </div>
                                                                <input type="hidden" name="id" value="" id="learnerActivationCoursesId_{{$SingleCourse->id}}">

                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                            data-dismiss="modal">{{__('common.No')}}</button>
                                                                    <button class="primary-btn fix-gr-bg"
                                                                            type="submit">{{__('common.Yes')}}</button>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap_15">
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{$course->totalReview}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>

                                                <div class="progress_percent flex-fill text-right">
                                                    <div class="progress theme_progressBar ">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{round($course->loginUserTotalPercentage)}}%"
                                                             aria-valuenow="25"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="font_14 f_w_400">{{round($course->loginUserTotalPercentage)}}
                                                        % {{__('student.Complete')}}</p>
                                                </div>
                                            </div>
                                            <div class="course_less_students">
                                                <a>
                                                    <i class="ti-agenda"></i> {{count($course->lessons)}} {{__('student.Lessons')}}
                                                </a>
                                                <a>
                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @elseif($courcefilter=='progress')
                                    @if(round($course->loginUserTotalPercentage) < 100)
                                    <div class="col-xl-4 col-md-6">
                                    <div class="couse_wizged">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">

                                                <x-price-tag :price="$course->price"
                                                             :discount="$course->discount_price"
                                                             :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>

                                            </div>

                                        </div>
                                        <div class="course_content">
                                            <a href="{{route('continueCourse',[$course->slug])}}">
                                                <h4 class="noBrake" title="{{$course->title}}">
                                                    {{$course->title}}
                                                </h4>
                                            </a>
                                            <div class="d-flex align-items-center gap_15">
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{$course->totalReview}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>

                                                <div class="progress_percent flex-fill text-right">
                                                    <div class="progress theme_progressBar ">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{round($course->loginUserTotalPercentage)}}%"
                                                             aria-valuenow="25"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="font_14 f_w_400">{{round($course->loginUserTotalPercentage)}}
                                                        % {{__('student.Complete')}}</p>
                                                </div>
                                            </div>
                                            <div class="course_less_students">
                                                <a>
                                                    <i class="ti-agenda"></i> {{count($course->lessons)}} {{__('student.Lessons')}}
                                                </a>
                                                <a>
                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                    @elseif($courcefilter=='complete')
                                    @if(round($course->loginUserTotalPercentage) == 100)
                                    <div class="col-xl-4 col-md-6">
                                    <div class="couse_wizged">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">

                                                <x-price-tag :price="$course->price"
                                                             :discount="$course->discount_price"
                                                             :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>

                                            </div>

                                        </div>
                                        <div class="course_content">
                                            <a href="{{route('continueCourse',[$course->slug])}}">
                                                <h4 class="noBrake" title="{{$course->title}}">
                                                    {{$course->title}}
                                                </h4>
                                            </a>
                                            <div class="d-flex align-items-center gap_15">
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{$course->totalReview}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>

                                                <div class="progress_percent flex-fill text-right">
                                                    <div class="progress theme_progressBar ">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{round($course->loginUserTotalPercentage)}}%"
                                                             aria-valuenow="25"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="font_14 f_w_400">{{round($course->loginUserTotalPercentage)}}
                                                        % {{__('student.Complete')}}</p>
                                                </div>
                                            </div>
                                            <div class="course_less_students">
                                                <a>
                                                    <i class="ti-agenda"></i> {{count($course->lessons)}} {{__('student.Lessons')}}
                                                </a>
                                                <a>
                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                    @endif
                                @elseif($course->type==2)
                                <div class="col-xl-4 col-md-6">
                                    <div class="quiz_wizged">
                                        <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                     data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">

                                                    <x-price-tag :price="$course->price"
                                                                 :discount="$course->discount_price"
                                                                 :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>


                                                </div>
                                                <span class="quiz_tag">{{__('quiz.Quiz')}}</span>
                                            </div>
                                        </a>
                                        <div class="course_content">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <h4 class="noBrake" title="{{$course->title}}"> {{$course->title}}</h4>
                                            </a>
                                            <div class="rating_cart">
                                                <div class="rateing">
                                                    <span>{{$course->totalReview}}/5</span>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="course_less_students">

                                                <a> <i class="ti-agenda"></i>{{count($course->quiz->assign)}}
                                                    {{__('student.Question')}}</a>
                                                <a>
                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @elseif($course->type==3)
                                <div class="col-xl-4 col-md-6">
                                    <div class="quiz_wizged">
                                        <div class="thumb">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <div class="thumb">
                                                    <div class="thumb_inner lazy"
                                                         data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                                        <x-class-close-tag :class="$course->class" />

                                                        <x-price-tag :price="$course->price"
                                                                     :discount="$course->discount_price"
                                                                     :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>


                                                    </div>
                                                    <span class="live_tag">{{__('student.Live')}}</span>
                                                </div>
                                            </a>


                                        </div>
                                        <div class="course_content">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <h4 class="noBrake" title="{{$course->title}}"> {{$course->title}}</h4>
                                            </a>
                                            <div class="rating_cart">
                                                <div class="rateing">
                                                    <span>{{$course->totalReview}}/5</span>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="course_less_students">
                                                <a> <i
                                                        class="ti-agenda"></i> {{$course->class->total_class}}
                                                    {{__('student.Classes')}}</a>
                                                <a>
                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                        @endforeach
                    @endif

                    @if(count($courses)==0)
                        <div class="col-12">
                            <div class="section__title3 margin_50">
                                @if( routeIs('myClasses'))
                                    <p class="text-center">{{__('student.No Class Purchased Yet')}}!</p>
                                @elseif( routeIs('myQuizzes'))
                                    <p class="text-center">{{__('student.No Quiz Purchased Yet')}}!</p>
                                @else
                                    <p class="text-center">{{__('student.No Course Purchased Yet')}}!</p>
                                @endif

                            </div>
                        </div>
                    @endif
                    <div class="col-12">
                        {{ $courses->appends(Request::all())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('a[href="#activation-courses"]').click(function(){
            let id = $(this).closest("div.course_content").find("#get_single_course_id").val();
            $('#learnerActivationCoursesId_'+id).val(id);
            $("#learnerActivationCourses_"+id).modal('show');
        });
    });
</script>

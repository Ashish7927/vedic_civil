{{-- <div>
    <div class="course_area section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->course_title}}


                        </h3>
                        <p>
                            {{@$homeContent->course_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                 <div class="package_carousel_active owl-carousel">
                @if(isset($top_courses))
                    @foreach($top_courses as $course)
                        <div class="col-lg-12 col-xl-12 col-md-12">
                            <div class="couse_wizged">
                                <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                    <div class="thumb">

                                        <div class="thumb_inner lazy"
                                             data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                        </div>

                                        <x-price-tag :price="$course->price"
                                                     :discount="$course->discount_price"
                                                     :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>
                                    </div>
                                </a>
                                <div class="course_content">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                        <h4 class="noBrake" title=" {{$course->title}}">
                                            {{$course->title}}
                                        </h4>
                                    </a>

                                    <div class="rating_cart">
                                        <div class="rateing">
                                            <span>{{$course->totalReview}}/5</span>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        @auth()
                                            @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                                <a href="#" class="cart_store"
                                                   data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            @endif
                                        @endauth
                                        @guest()
                                            @if(!$course->isGuestUserCart)
                                                <a href="#" class="cart_store"
                                                   data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            @endif
                                        @endguest

                                    </div>
                                    <div class="course_less_students">
                                        <a> <i class="ti-agenda"></i> {{count($course->lessons)}}
                                            {{__('frontend.Lessons')}}</a>
                                        <a>
                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        </div>
            <div class="row">
                <div class="col-12 text-center pt_70">
                    <a href="{{route('courses')}}"
                       class="theme_btn mb_30">{{__('frontend.View All Courses')}}</a>
                </div>
            </div>
        </div>
<div> --}}
    <style type="text/css">
    .category a.active {
    color: #ef4d23;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}
      .category a {
    cursor: pointer;
    text-decoration: none;
    color: #384550;
    padding: 0px 10px;
    font-size: 21px;
}

.nav-tabs {
    font-size: "Open Sans";
    margin-left: 0;
    border-bottom: 0 solid #dee2e6;
    text-align: center!important;
}
.banner_area input::placeholder{font-size: 20px; color: #ed4e26; text-align: left;}
i.search-large {
    font-size: 30px;
}
@media (min-width:991.98px){
        .section__title h3 {
    font-size: 50px;
    font-weight: 900;
    line-height: 64px;
    color: var(--system_secendory_color);
    margin-bottom: 17px;
    display: block;
    float: left;
    width: 100%;
}
}
@media (max-width:768px){
.banner_area input::placeholder{font-size: 16px;}
i.search-large {
    font-size: 25px;
}
}
    </style>
    {{-- <div class="course_area section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section__title text-center mb_50 category nav nav-tabs" style="display: block;" role="tablist">
                        <h3>
                          {{__('frontend.Recommended Courses')}}
                      </h3>
                    <?php if(isset($homecat)){
                     $i=1; foreach($homecat as $cate){ ?>
                    <a class="@if($i=='1') active @endif" href="#{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ','',$cate->name)) }}" data-toggle="tab">{{$cate->name}}</a> |
                   <?php $i++; } } ?>

                    <a href="{{route('courses')}}"> {{__('frontend.View All Courses')}} </a>
                    </div>
                </div>
            </div>
            <div class="tab-content">

            <?php if(isset($homecat)){
                     $j=1; foreach($homecat as $cate){ ?>
                <div class="tab-pane <?php if($j=="1"){ echo "show active"; } ?>" id="{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ','',$cate->name))}}" >
                     <?php $top_cou = Modules\CourseSetting\Entities\Course::orderBy('total_enrolled', 'desc')->where('status', 1)->where('type', 1)->where('category_id',$cate->id)->take(12)->with('lessons')->get();
                ?>
                 <div class="<?php if(count($top_cou) > 5){ echo 'package_carousel_active owl-carousel'; }else{ echo 'row'; } ?>">

                @if(isset($top_cou))
                    @foreach($top_cou as $course)
                    <?php if(count($top_cou) > 5){ ?>
                        <div class="col-lg-12 col-xl-12 col-md-12">
                    <?php }else{ ?>
                        <div class="col-lg-2 col-xl-2 col-md-2">
                        <?php } ?>
                            <div class="couse_wizged">
                                <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                    <div class="thumb">

                                        <div class="thumb_inner lazy"
                                             data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                        </div>

                                        <x-price-tag :price="$course->price"
                                                     :discount="$course->discount_price"
                                                     :discount_start_date="$course->discount_start_date"
                                                                 :discount_end_date="$course->discount_end_date"/>
                                    </div>
                                </a>
                                <div class="course_content">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                        <h4 class="noBrake" title=" {{$course->title}}">
                                            {{$course->title}}
                                        </h4>
                                    </a>

                                    <div class="rating_cart">
                                        <div class="rateing">
                                            <span>{{$course->totalReview}}/5</span>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        @auth()
                                            @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                                <a href="#" class="cart_store"
                                                   data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            @endif
                                        @endauth
                                        @guest()
                                            @if(!$course->isGuestUserCart)
                                                <a href="#" class="cart_store"
                                                   data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            @endif
                                        @endguest

                                    </div>
                                    <div class="course_less_students">
                                        <a> <i class="ti-agenda"></i> {{count($course->lessons)}}
                                            {{__('frontend.Lessons')}}</a>
                                        <a>
                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    <?php $j++; } } ?>

        </div>
        </div>
    </div>
</div> --}}

<style>
    .line_course_tab {
        border-bottom: 2px solid #eae6e5 !important;
        gap: 50px;
        width: 100%;
    }

     .category a{
        border-bottom: 3px solid transparent;
        text-decoration: none;
        padding: 15px !important;
    }

    .category > a.active {
        border-bottom: 3px solid #ef4d23;
        padding-bottom: 10px;
    } 

    .view_btn {
        background: var(--system_primery_color);
        border-radius: 5px;
        font-family: Open Sans;
        font-size: 16px;
        color: #fff !important;
        font-weight: 600;
        padding: 11px 22px;
        border: 1px solid transparent;
        text-transform: capitalize;
        display: inline-block;
        line-height: 1;
    }

    .couse_wizged .thumb .prise_tag {
        color: #FFFFFF !important;
        background: #FFB11B !important;
        width: 0% !important; 
        min-width: 83px !important;
        min-height: 83px !important;
        font-size: 12px !important;
    }

    @media screen and (max-width: 550px ) {
        .nav {
            flex-wrap: unset;
        }

        .category a{
            font-size: 18px;
        }
    }

    @media screen and (max-width: 500px ) {
        .line_course_tab {
            gap:unset;
        }
        .nav {
            flex-wrap: unset;
        }

        .category a{
            font-size: 16px;
        }

        .view_btn {
            font-size: 14px;
            padding: 9px 20px;
            margin-top: 10px;
        }
    }

    @media screen and (max-width: 420px ) {
        
        .category a{
            font-size: 14px;
        }

        .view_btn {
            padding: 7px 18px;
        }

        .courseSlidder .owl-dots {
            margin: auto;
            
        }
    }

    .courseSlidder .owl-dots {
        margin-top: 50px;
        
    }
</style>
<script type="text/javascript">
    $( document ).ready(function() {
        $(".courseSlidder").owlCarousel({
            loop: !0, 
            margin: 30, 
            items: 1, 
            autoplay: !0, 
            nav: !1, 
            dots: !0, 
            autoplayHoverPause: !0, 
            autoplaySpeed: 800, 
            responsive: { 
                0: { items: 1, dotsEach: 5 }, 
                767: { items: 3 }, 
                992: { items: 4 }, 
                1400: { items: 5 }
            } 
        });

        var premium_url = "{{ route('courses'). '?version=paid' }}";
        var free_url = "{{ route('courses'). '?version=free' }}";

        $('.nav a').click(function(){
            $(this).tab('show');
        });
         // The on tab shown event
        $('.nav a').on('shown.bs.tab', function (e) {
            var current_tab_id = e.target.id;
            if (current_tab_id == 'premium') {
                $('.view_btn').attr('href',premium_url);
            } else {
                $('.view_btn').attr('href',free_url);
            }
        });
    });

</script>
<!-- Whats New on elatih Section Start-->
 <div>
    <div class="course_area section_spacing5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_40">
                        <h3>
                            What's New on e-LATiH?
                        </h3>
                    </div>
                </div>
            </div>
            <div class="d-flex line_course_tab mb-5">
                <div class="nav category" role="tablist">
                    <a id="premium" class="active" href="#premium_courses1" role="tab" data-toggle="tab">Premium Courses</a>
                    <a id="free" role="tab" href="#free_courses1" data-toggle="tab">Free Courses</a>
                </div>
                <div class="ml-auto">
                    {{-- <a href="{{route('courses')}}" class="view_btn">View All</a> --}}
                    <a href="{{route('courses'). '?version=paid'}}" class="view_btn">View All</a>
                </div>
            </div>
            <div class="tab-content">
                <!-- PREMIUM COURSE TAB START --> 
                <div role="tabpanel" class="tab-pane fade active show " id="premium_courses1">
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
                    <div class="owl-carousel courseSlidder">
                    @if(isset($premium_courses))
                        @foreach($premium_courses as $course)
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="course_title" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
                <!-- PREMUM COURSE TAB END --> 
                <!-- FREE COURSE TAB START --> 
                <div role="tabpanel" class="tab-pane fade" id="free_courses1"> 
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
                    <div class="owl-carousel courseSlidder">
                    @if(isset($free_courses))
                        @foreach($free_courses as $course)
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="course_title" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
                <!-- FREE COURSE TAB END --> 
            </div>
        </div>
    </div>
</div> 
<!-- Whats New on elatih Section End-->

<!-- Top Online Course Section Start-->
<div>
    <div class="course_area section_spacing5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_40">
                        <h3>
                            {{@$homeContent->course_title}}
                        </h3>
                        <p>
                            {{@$homeContent->course_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex line_course_tab mb-5">
                <div class="nav category" role="tablist">
                    <a id="premium" class="active" href="#premium_courses2" role="tab" data-toggle="tab">Premium Courses</a> 
                    <a id="free" role="tab" href="#free_courses2" data-toggle="tab">Free Courses</a>
                </div>
                <div class="ml-auto">
                    {{-- <a href="{{route('courses')}}" class="view_btn">View All</a> --}}
                    <a href="{{route('courses'). '?version=paid'}}" class="view_btn">View All</a>
                </div>
            </div>
            <div class="tab-content">
                <!-- PREMIUM COURSE TAB START --> 
                <div role="tabpanel" class="tab-pane fade active show " id="premium_courses2">
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
                    <div class="owl-carousel courseSlidder">
                    @if(isset($top_premium_courses))
                        @foreach($top_premium_courses as $course)
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="course_title" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div> 
                <!-- PREMUM COURSE TAB END --> 
                <!-- FREE COURSE TAB START --> 
                <div role="tabpanel" class="tab-pane fade" id="free_courses2"> 
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
                    <div class="owl-carousel courseSlidder">
                    @if(isset($top_free_courses))
                        @foreach($top_free_courses as $course)
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="course_title" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
                <!-- FREE COURSE TAB END --> 
            </div>
        </div>
    </div>
</div>
<!-- Top Online Course Section End-->

<!-- Featured Course Section Start-->
@if((@$homeContent->show_featured_course_section == 1) && count($premium_featured_courses) && count($free_featured_courses))
<div>
    <div class="course_area section_spacing5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_40">
                        <h3>
                            {{@$homeContent->course_title_1}}
                        </h3>
                        <p>
                            {{@$homeContent->course_sub_title_1}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex line_course_tab mb-5">
                <div class="nav category" role="tablist">
{{--                    <a id="premium" class="active" href="#premium_courses3" role="tab" data-toggle="tab">Premium Courses</a> 
--}}
                    <a id="free" role="tab" class="active" href="#free_courses3" data-toggle="tab">Free Courses</a>
                </div>
                <div class="ml-auto">
                    {{-- <a href="{{route('courses')}}" class="view_btn">View All</a> --}}
                    <a href="{{route('courses'). '?version=paid'}}" class="view_btn">View All</a>
                </div>
            </div>
            <div class="tab-content">
                <!-- PREMIUM COURSE TAB START --> 
{{--                <div role="tabpanel" class="tab-pane fade active show " id="premium_courses3">
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
{{--                    <div class="owl-carousel courseSlidder">
                    @if(isset($premium_featured_courses))
                        @foreach($premium_featured_courses as $cou)
                            <?php $course = Modules\CourseSetting\Entities\Course::where('status', 1)->where('type', 1)->where('id', $cou->course_id)->first();
                            ?>
                            @if(isset($course))
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="noBrake" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                    </div>
                </div> 
--}}
                <!-- PREMUM COURSE TAB END --> 
                <!-- FREE COURSE TAB START --> 
                <div role="tabpanel" class="tab-pane fade active show" id="free_courses3"> 
                    {{-- <div class="package_carousel_active owl-carousel"> --}}
                    <div class="owl-carousel courseSlidder">
                    @if(isset($free_featured_courses))
                        @foreach($free_featured_courses as $cou)
                            <?php $course = Modules\CourseSetting\Entities\Course::where('status', 1)->where('type', 1)->where('id', $cou->course_id)->first();
                            ?>
                            @if(isset($course))
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <div class="couse_wizged">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>

                                            <x-price-tag :price="$course->price"
                                                        :discount="$course->discount_price"
                                                        :discount_start_date="$course->discount_start_date"
                                                                    :discount_end_date="$course->discount_end_date"/>
                                        </div>
                                    </a>
                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="course_title" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="course_less_students">
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                    </div>
                </div>
                <!-- FREE COURSE TAB END --> 
            </div>
        </div>
    </div>
</div>
@else
<div>
    <div class="course_area d-none">
    </div>
</div>
@endif


<!-- Featured Course Section End-->
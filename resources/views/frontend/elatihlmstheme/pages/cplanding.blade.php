@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')

<div>
    <div class="breadcrumb_area bradcam_bg_2" style="background-image: url('/public/frontend/elatihlmstheme/img/banner/banner_cplanding.png');background-size:100% 100%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="breadcam_wrap">
                        {{-- <h3>
                        Online Training <br>at Harvard
                        </h3>
                        <span>
                        Upskill and reskill your employees with a personalized pathway regardless of your company size and budget.
                        </span> --}}
                        <h3>
                            {{ isset($user->company_banner_title)? $user->company_banner_title : 'Start Learning from the World-Class Providers'  }}
                        </h3>
                        <span>
                            {{ isset($user->company_banner_subtitle)? $user->company_banner_subtitle : 'Subscribe now via Corporate Access' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container-fluid" style="background-color:#E0E5F580;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mt_40 mb_40">
                <div class="mb_10">
                    <h1 class="h1">
                    About Us
                    </h1>
                </div>

                <p class="mb-3">{{@$user->company_profile_summary}}</p>
                @if(isset($user->website))
                    <a target="_blank" href="{{@$user->website}}">
                        <img class="img-responsive" src="/public/frontend/elatihlmstheme/img/banner/web_icon.png">
                    </a>
                @endif
                @if(isset($user->facebook))
                    <a target="_blank" href="{{@$user->facebook}}">
                        <img class="img-responsive" src="/public/frontend/elatihlmstheme/img/banner/fb_icon.png">
                    </a>
                @endif
                @if(isset($user->twitter))
                    <a target="_blank" href="{{@$user->twitter}}">
                        <img class="img-responsive" src="/public/frontend/elatihlmstheme/img/banner/twiter_icon.png">
                    </a>
                @endif
                @if(isset($user->linkedin))
                    <a target="_blank" href="{{@$user->linkedin}}">
                        <img class="img-responsive" src="/public/frontend/elatihlmstheme/img/banner/linkedin_icon.png">
                    </a>
                @endif

            </div>
            <div class="col-lg-4 mt_50 mb_40">
                <div class="row align-items-center ml-5 mb-4">
                    <!-- /public/frontend/elatihlmstheme/img/banner/harvard.png -->
                    <img class="img-responsive" style="width: 270px; max-height: 270px;" src="/{{@$user->image}}">
                </div>
                <div class="row align-items-center ml-5" style="width:270px">
                    <div class="" style="text-align: center; width:50%;">
                        <strong style="color:#B50330; font-weight: bold;font-size: 60px;">{{@$course_count}}</strong>
                        <p style="font-weight: bold;font-size: 20px;">Courses</p>
                    </div>
                    <div class="" style="text-align: center; width:50%;">
                        <strong style="color:#B50330; font-weight: bold;font-size: 60px;">{{@$enrolleds}}</strong>
                        <p style="font-weight: bold;font-size: 20px;">Enrollment</p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
<section class="container-fluid">
    <div class="container mb_40">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt_40" style="    text-align: center;">
                    <h1 class="h1 mb_30">
                    Featured Online Courses
                    </h1>
                    <a type="button" class="btn mb_30" href="/courses" style="background: #EF4D23;color:white;">View All Course</a>
                </div>

            </div>
            <div class="row pb-4" style="width:100%">
            @if(isset($featured_courses))
                            @foreach ($featured_courses as $course)
                                <div class="" style="width:20%; margin:5px;">
                                    <div class="couse_wizged">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                            <div class="thumb">

                                                <div class="thumb_inner lazy"
                                                     data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                                </div>
                                                {{$course->price}}
                                                <x-price-tag :price="$course->price"
                                                             :discount="$course->discount_price"
                                                             :discountstartdate="$course->discount_start_date"
                                                             :discountenddate="$course->discount_end_date"/>
                                            </div>
                                        </a>
                                        <div class="course_content">
                                            <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                                <h4 class="course_title" title=" {{$course->title}}">
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

                                                    <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                <!-- <div class="col-lg-12 ml-5 mb_40">
                    <img class="img" src="/public/frontend/elatihlmstheme/img/banner/image 21.png">
                </div>
                 -->
            </div>



            </div>

        </div>

    </div>
</section>

<!-- <section class="container-fluid">
    <div class="container mb_40">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt_40" style="    text-align: center;">
                    <h1 class="h1 mb_30">
                    Package Selection
                    </h1>
                    <button type="button" class="btn mb_30" style="background: #EF4D23;
 color:white;">View All Packages</button>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <img class="img" style="width: 100%;" src="/public/frontend/elatihlmstheme/img/banner/featured_online_courses.jpg">
                </div>

            </div>

        </div>

    </div>
</section> -->

<x-home-page-corporate-access-promo-section :homeContent="$homeContent"/>

{{-- <section class="container-fluid">
    <div class="container mb_40">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt_40" style="    text-align: center;">
                    <h1 class="h1 mb_10">
                    Corporate Access
                    </h1>
                    <p class="btn mb_30">A seamless management system for organisations.</p>

                </div>

            </div>

            <div class="row">
                <div class="col-lg-5 offset-sm-1">
                    <img class="img" style="width:100%" src="/public/frontend/elatihlmstheme/img/banner/corporate.png">
                </div>
                <div class="col-lg-5 mt_40">
                    <ul class="ml-5 mb_30">
                        <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> All are available via Corporate Access</li>
                        <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Upskill and reskill your employees with a personalized pathway regardless of your</li>
                    </ul>
                    <div style="text-align: center;">
                        <a type="button" class="btn" href="#" style="border: 1px solid #EF4D23;color:#EF4D23">Learn More</a>
                        <a type="button" class="btn" href="#" style="background: #EF4D23; color:white;">Get Corporate Access</a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section> --}}

@endsection

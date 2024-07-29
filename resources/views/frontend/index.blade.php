@extends('frontend.master')
@section('mainContent')
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <div id="edublink-preloader">
        <div class="loading-spinner">
            <div class="preloader-spin-1"></div>
            <div class="preloader-spin-2"></div>
        </div>
        <div class="preloader-close-btn-wraper">
            <span class="btn btn-primary preloader-close-btn">
                Cancel Preloader</span>
        </div>
    </div>

    <div id="main-wrapper" class="main-wrapper">
        <div class="hero-banner hero-style-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Unlock
                                <span class="color-secondary">Your</span> <br> Potential
                                As A Civil Engineer
                            </h1>
                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">Excepteur sint occaecat
                                cupidatat non proident sunt in culpa qui officia deserunt mollit.</p>
                            <div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                <a href="{{ route('courseOne') }}" class="edu-btn">Find courses <i class="icon-4"></i></a>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade"
                                    data-sal-duration="1000">
                                    <img data-depth="2" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-thumbnail">
                            <div class="thumbnail" data-sal-delay="500" data-sal="slide-left" data-sal-duration="1000">
                                <img src="{{ asset('frontend') }}/assets/images/banner/girl-1.webp" alt="Girl Image">
                            </div>
                            <!--<div class="instructor-info" data-sal-delay="600" data-sal="slide-up"-->
                            <!--    data-sal-duration="1000">-->
                            <!--    <div class="inner">-->
                            <!--        <h5 class="title">Instrunctor</h5>-->
                            <!--        <div class="media">-->
                            <!--            <div class="thumb">-->
                            <!--                <img src="{{ asset('frontend') }}/assets/images/banner/author-1.png" alt="Images">-->
                            <!--            </div>-->
                            <!--            <div class="content">-->
                            <!--                <span>200+</span> Instactors-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<ul class="shape-group">-->
                            <!--    <li class="shape-1" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">-->
                            <!--        <img data-depth="1.5" src="{{ asset('frontend') }}/assets/images/about/shape-15.png" alt="Shape">-->
                            <!--    </li>-->
                            <!--    <li class="shape-2 scene" data-sal-delay="1000" data-sal="fade"-->
                            <!--        data-sal-duration="1000">-->
                            <!--        <img data-depth="-1.5" src="{{ asset('frontend') }}/assets/images/about/shape-16.png" alt="Shape">-->
                            <!--    </li>-->
                            <!--    <li class="shape-3 scene" data-sal-delay="1000" data-sal="fade"-->
                            <!--        data-sal-duration="1000">-->
                            <!--        <span data-depth="3" class="circle-shape"></span>-->
                            <!--    </li>-->
                            <!--    <li class="shape-4" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">-->
                            <!--        <img data-depth="-1" src="{{ asset('frontend') }}/assets/images/counterup/shape-02.png" alt="Shape">-->
                            <!--    </li>-->
                            <!--    <li class="shape-5 scene" data-sal-delay="1000" data-sal="fade"-->
                            <!--        data-sal-duration="1000">-->
                            <!--        <img data-depth="1.5" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="Shape">-->
                            <!--    </li>-->
                            <!--    <li class="shape-6 scene" data-sal-delay="1000" data-sal="fade"-->
                            <!--        data-sal-duration="1000">-->
                            <!--        <img data-depth="-2" src="{{ asset('frontend') }}/assets/images/about/shape-18.png" alt="Shape">-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-7">
                <img src="{{ asset('frontend') }}/assets/images/about/h-1-shape-01.png" alt="Shape">
            </div>
        </div>
        <!--=====================================-->
        <!--=       Features Area Start      =-->
        <!--=====================================-->
        <!-- Start Categories Area  -->
        <div class="features-area-2">
            <div class="container">
                <div class="features-grid-wrap">
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="{{ asset('frontend') }}/assets/images/animated-svg-icons/online-class.svg"
                                alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>3020</span> Online Courses</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="{{ asset('frontend') }}/assets/images/animated-svg-icons/instructor.svg"
                                alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>Top</span>Instructors</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon certificate">
                            <img class="svgInject" src="{{ asset('frontend') }}/assets/images/animated-svg-icons/certificate.svg"
                                alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>Online</span>Certifications</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="{{ asset('frontend') }}/assets/images/animated-svg-icons/user.svg"
                                alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>6000</span>Members</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Categories Area  -->
        <!--=====================================-->

        <!--=====================================-->
        <!--=       About Us Area Start      	=-->
        <!--=====================================-->
        <div class="gap-bottom-equal edu-about-area about-style-1">
            <div class="container edublink-animated-shape">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-image-gallery">
                            <img class="main-img-1" src="{{ asset('frontend') }}/assets/images/about/about-01.webp" alt="About Image">
                            <div class="video-box" data-sal-delay="150" data-sal="slide-down"
                                data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumb">
                                        <img src="{{ asset('frontend') }}/assets/images/about/about-02.webp" alt="About Image">
                                        <a href="https://www.youtube.com/watch?v=PICj5tr9hcc"
                                            class="popup-icon video-popup-activation">
                                            <i class="icon-18"></i>
                                        </a>
                                    </div>
                                    <div class="loading-bar">
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="award-status bounce-slide">
                                <div class="inner">
                                    <div class="icon">
                                        <i class="icon-21"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title">29+</h6>
                                        <span class="subtitle">Wonderful Awards</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="500" data-sal="fade"
                                    data-sal-duration="200">
                                    <img data-depth="1" src="{{ asset('frontend') }}/assets/images/about/shape-36.png" alt="Shape">
                                </li>
                                <li class="shape-2 scene" data-sal-delay="500" data-sal="fade"
                                    data-sal-duration="200">
                                    <img data-depth="-1" src="{{ asset('frontend') }}/assets/images/about/shape-37.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene" data-sal-delay="500" data-sal="fade"
                                    data-sal-duration="200">
                                    <img data-depth="1" src="{{ asset('frontend') }}/assets/images/about/shape-02.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6" data-sal-delay="150" data-sal="slide-left" data-sal-duration="800">
                        <div class="about-content">
                            <div class="section-title section-left">
                                <span class="pre-title">About Us</span>
                                <h2 class="title">Learn & Grow Your Skills From <span
                                        class="color-secondary">Anywhere</span></h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Parents of Civil Engineering students spent lakhs of rupees in their study. But after
                                    passout they are become unwanted for construction industry due to least practical
                                    knowledge. Employer doors are closed for them unless and untill they are practically
                                    sound. We help them in their struggling period by giving all sorts of practical
                                    knowledge equivalent to 8yr experience and provide them platform to appear interview
                                    till getting job.</p>
                            </div>
                            <ul class="features-list">
                                <li>Expert Trainers</li>
                                <li>Online Remote Learning</li>
                                <li>Lifetime Access</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="shape-group">
                    <li class="shape-1 circle scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                        <span data-depth="-2.3"></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--=====================================-->
        <!--=       Course Area Start      		=-->
        <!--=====================================-->
        <!--=       Categories Area Start      =-->
        <!--=====================================-->
        <!-- Start Categories Area  -->

        <div id="cards_landscape_wrap-2" style="text-align: center; background: #F7F7F7;">
            <div class="container" style="padding-top: 40px; padding-bottom: 20px;">
                <div class="row">
                    <h2 class="title">OUR UNIQUE <span style="color:#ee4a62;">COURSES</span></h2>
                    <span class="shape-line"><i class="icon-19" style="color: #1ab69d;"></i></span>


                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10001.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Planning through AUTOCAD</h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Without having conceptual clarity in drawing, training in AUTOCAD is meaning
                                            less. For which most of the trained candidates failed to draw a site
                                            specific VAASTU PLAN , Drawing section and elevation as per GOVT. norms. We
                                            produce efficient Planning Engineers</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10002.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Revit architecture,3Ds Max,GIS,Civil 3D,MX Road,E Survey,Road Estimator</h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Designed for budding entrepreneurs, this course focuses on consultancy firm
                                            establishment. Not recommended for job seekers due to low salaries. Expert
                                            faculty ensure comprehensive training.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10003.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Primavera,MS project,Project planning and management</h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Ideal for current employees aiming for managerial roles. Not suitable for
                                            freshers. Hands-on training ensures project management skills are retained.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10004.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Staad Pro,Tekla,E tab</h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Our structural design courses require an MTech in Structural Design and
                                            strong theoretical background for success. Reserved for deserving
                                            candidates, instructed by experienced designers engaged in live projects.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="cards_landscape_wrap-2" style="text-align: center; background: #F7F7F7;">
            <div class="container" style="padding-top: 20px; padding-bottom: 40px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10005.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Quantity Surveying (Estimating) and Contract Managemen</h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Most vital knowledge for any Civil Engineer to achieve highly paid job. Even
                                            10 year experienced candidates not able to do unless and until learned from
                                            senior. But most seniors never train juniors at site.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10006.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Training to crack Govt.& Pvt. jobs.
                                        </h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Our course blends theory with interactive site work videos to engage
                                            students in Civil Engineering. Upon completion, graduates are equipped to
                                            excel in both government job exams and private company interviews.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10007.png" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Survey Training
                                        </h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Our module ensures candidates master survey instruments like Total Station,
                                            Auto level, Digital theodolite, and GPS, fostering theoretical strength and
                                            practical proficiency. Graduates are ready to tackle any site challenge.



                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="margin-top: 50px;">
                        <a href="" style="text-decoration: none; outline: none;">
                            <div class="card-flyer"
                                style="background: #FFFFFF; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; transition: all 0.2s ease-in; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);">
                                <div class="text-box" style="text-align: center;">
                                    <div class="image-box"
                                        style="background: #ffffff; overflow: hidden; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50); border-radius: 5px;">
                                        <img src="{{ asset('frontend') }}/assets/images/animated-svg-icons\10008.jpg" alt=""
                                            style="-webkit-transition: all .9s ease; -moz-transition: all .9s ease; -o-transition: all .9s ease; -ms-transition: all .9s ease; width: 100%; height: 200px;">
                                    </div>
                                    <div class="text-container" style="padding: 30px 18px;">
                                        <h6
                                            style="margin-top: 0px; margin-bottom: 4px; font-size: 18px; font-weight: bold; text-transform: uppercase; font-family: 'Roboto Black', sans-serif; letter-spacing: 1px; color: #1ab69d;">
                                            Practical site work Training
                                        </h6>
                                        <p
                                            style="margin-top: 10px; margin-bottom: 0px; padding-bottom: 0px; font-size: 14px; letter-spacing: 1px; color: #000000;">
                                            Our exclusive training offers unparalleled practical expertise across all
                                            construction phases. Candidates emerge adept from start to finish, highly
                                            sought by construction firms. Even freshers outperform seasoned applicants
                                            nationwide.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--Download page-->

        <div class="banner"
            style="color: white; background: url('assets/img.jpg') top center no-repeat; min-height: 601px; width: 100%; justify-content: center; align-items: center;margin-top:59px;">
            <div class="container ">
                <div class="row g-lg-5">
                    <div class="col-lg-5">
                        <div class="testimonial-heading-area">
                            <div class="section-title section-left" data-sal-delay="50" data-sal="slide-up"
                                data-sal-duration="800">
                                <span class="pre-title" style="color: white; padding-top:44px;">Your Path to
                                    Success</span>
                                <h2 class="title" style="color: white !important;">What Our Students Have To Say</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p style="color: white;">Vedic Civil offers comprehensive training, expert guidance,
                                    and practical knowledge to aspiring civil engineers, empowering them to excel in
                                    their careers and contribute to the world of engineering.</p>
                                <a href="#" class="edu-btn btn-large">Download App<i class="icon-4"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Categories Area  -->
        <!-- Start Course Area  -->
        <div class="edu-course-area course-area-1 edu-section-gap bg-lighten01">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <span class="pre-title">Popular Courses</span>
                    <h2 class="title">Pick A Course To Get Started</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="{{ route('courseOne') }}">
                                        <img src="{{ asset('frontend') }}/assets/images/course/course-07.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>4 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="#">Quantity Surveying</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.9 /8 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 999.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="{{ route('courseOne') }}">Quantity Surveying(Estimating)</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.9 /8 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 999.00</div>
                                    <p>Estimating knowledge is crucial for civil engineers, with high demand and
                                        salaries for roles like Estimator,
                                        Quantity Surveyor, and Project Manager. Our training surpasses 10-year site
                                        experience, preparing students
                                        for these roles, especially valuable for women in official positions.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="{{ route('courseOne') }}" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="{{ route('courseOne') }}">
                                        <img src="{{ asset('frontend') }}/assets/images/course/course-04.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>3 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Beginner</span>
                                    <h6 class="title">
                                        <a href="#">MODERATE ESSENTIAL</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(5.0 /7 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 5999.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Beginner</span>
                                    <h6 class="title">
                                        <a href="{{ route('courseOne') }}">MODERATE ESSENTIAL
                                            Developers</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(5.0 /7 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 5999.00</div>
                                    <p>Survey training (Total Station training, Auto level training,Digital
                                        Theodolite,GPS Training Trng.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="{{ route('courseOne') }}" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="{{ route('courseOne') }}">
                                        <img src="{{ asset('frontend') }}/assets/images/course/course-05.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>8 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="#">LEAST ESSENTIAL</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.8 /9 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 19999.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>32 Lessons</li>
                                        <li><i class="icon-25"></i>18 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="{{ route('courseOne') }}">LEAST ESSENTIAL</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.8 /9 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 19999.00</div>
                                    <p>Structural designing through Staad Pro, Tekla, E Tab, MX Road</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>35 Lessons</li>
                                        <li><i class="icon-25"></i>18 Students</li>
                                    </ul>
                                    <a href="{{ route('courseOne') }}" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="{{ route('courseOne') }}">
                                        <img src="{{ asset('frontend') }}/assets/images/course/course-06.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>6 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Intermediate</span>
                                    <h6 class="title">
                                        <a href="#">MODERATE ESSENTIAL</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.7 /5 Rating)</span>
                                    </div>
                                    <div class="course-price">₹ 19999.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>15 Lessons</li>
                                        <li><i class="icon-25"></i>12 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Intermediate</span>
                                    <h6 class="title">
                                        <a href="{{ route('courseOne') }}">LEAST ESSENTIAL</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.7 /5 Rating)</span>
                                    </div>
                                    <div class="course-price">$49.00</div>
                                    <p>Structural designing through Staad Pro, Tekla, E Tab, MX Road</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>15 Lessons</li>
                                        <li><i class="icon-25"></i>12 Students</li>
                                    </ul>
                                    <a href="{{ route('courseOne') }}" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div>
                <div class="course-view-all" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                    <a href="{{ route('courseOne') }}" class="edu-btn">Browse more courses <i class="icon-4"></i></a>
                </div>
            </div>
        </div>
        <!-- End Course Area -->
        <!--=====================================-->
        <!--=       CounterUp Area Start      	=-->
        <!--=====================================-->
        <div class="counterup-area-2">
            <div class="container">
                <div class="row g-5 justify-content-center">
                    <div class="col-lg-8">
                        <div class="counterup-box-wrap">
                            <div class="counterup-box counterup-box-1">
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number primary-color">
                                        <span class="odometer" data-odometer-final="45.2">.</span><span>K</span>
                                    </h2>
                                    <h6 class="title">Student Enrolled</h6>
                                </div>
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number secondary-color">
                                        <span class="odometer" data-odometer-final="32.4">.</span><span>K</span>
                                    </h2>
                                    <h6 class="title">Class Completed</h6>
                                </div>
                            </div>
                            <div class="counterup-box counterup-box-2">
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number extra05-color">
                                        <span class="odometer" data-odometer-final="354">.</span><span>+</span>
                                    </h2>
                                    <h6 class="title">Top Instructors</h6>
                                </div>
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number extra02-color">
                                        <span class="odometer" data-odometer-final="99.9">.</span><span>%</span>
                                    </h2>
                                    <h6 class="title">Satisfaction Rate</h6>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene">
                                    <img data-depth="-2" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="Shape">
                                </li>
                                <li class="shape-2">
                                    <img class="rotateit" src="{{ asset('frontend') }}/assets/images/counterup/shape-02.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene">
                                    <img data-depth="1.6" src="{{ asset('frontend') }}/assets/images/counterup/shape-04.png" alt="Shape">
                                </li>
                                <li class="shape-4 scene">
                                    <img data-depth="-1.6" src="{{ asset('frontend') }}/assets/images/counterup/shape-05.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <!-- --}}
        {{-- <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" style="height: 500px;" data-src="{{ asset('frontend') }}/assets/img.jpg" uk-img="loading: eager">

 <button class="uk-button uk-button-primary uk-button-large">Download App Now</button>         --}}
        <!--=====================================-->
        <!--=       Testimonial Area Start      =-->
        <!--=====================================-->
        <!-- Start Testimonial Area  -->
        <div class="testimonial-area-1 section-gap-equal">
            <div class="container">
                <div class="row g-lg-5">
                    <div class="col-lg-5">
                        <div class="testimonial-heading-area">
                            <div class="section-title section-left" data-sal-delay="50" data-sal="slide-up"
                                data-sal-duration="800">
                                <span class="pre-title">Testimonials</span>
                                <h2 class="title">What Our Students Have To Say</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Hear how Vedic Civil's practical training and expert guidance transformed careers,
                                    bridging academic knowledge with industry demands, and unlocking new opportunities
                                    in civil engineering.</p>
                                <a href="#" class="edu-btn btn-large">View All<i class="icon-4"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="home-one-testimonial-activator swiper ">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="{{ asset('frontend') }}/assets/images/testimonial/testimonial-01.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>The practical training at Vedic Civil transformed my career. I went from
                                                having theoretical knowledge to being industry-ready. I secured a job as
                                                a Quantity Surveyor within weeks of completing the course</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Anjali P.</h5>
                                            <span class="subtitle">Student</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="{{ asset('frontend') }}/assets/images/testimonial/testimonial-02.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>The comprehensive estimating and surveying courses filled the gaps left
                                                by my B Tech degree. The mentors were exceptional, and the support I
                                                received was invaluable. I'm now working as a Project Manager, thanks to
                                                Vedic Civil.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Rajesh k.</h5>
                                            <span class="subtitle">Designer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="{{ asset('frontend') }}/assets/images/testimonial/testimonial-03.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>As a woman in civil engineering, finding the right role was challenging.
                                                Vedic Civil’s training not only gave me the necessary skills but also
                                                boosted my confidence. I'm now happily employed as a Billing Engineer.
                                            </p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Priya S.</h5>
                                            <span class="subtitle">Developer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="{{ asset('frontend') }}/assets/images/testimonial/testimonial-04.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>The hands-on experience and real-world projects at Vedic Civil set me
                                                apart from my peers. I felt prepared and confident during interviews,
                                                and landed a job as a Tender Engineer shortly after graduating.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Kumar S.</h5>
                                            <span class="subtitle">Content Creator</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonial Area  -->
        <!--=====================================-->
        <!--=      Call To Action Area Start   	=-->
        <!--=====================================-->
        <!-- Start CTA Area  -->
        <div class="home-one-cta-two cta-area-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="home-one-cta edu-cta-box bg-image">
                            <div class="inner">
                                <div class="content text-md-end">
                                    <span class="subtitle">Get In Touch:</span>
                                    <h3 class="title"><a href="mailto:vediccivil@gmail.com">vediccivil@gmail.com</a>
                                    </h3>
                                </div>
                                <div class="sparator">
                                    <span>or</span>
                                </div>
                                <div class="content">
                                    <span class="subtitle">Call Us Via:</span>
                                    <h3 class="title"><a href="tel:+91 6371834256">+91 6371834256</a></h3>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-01 scene">
                                    <img data-depth="2" src="{{ asset('frontend') }}/assets/images/cta/shape-06.png" alt="shape">
                                </li>
                                <li class="shape-02 scene">
                                    <img data-depth="-2" src="{{ asset('frontend') }}/assets/images/cta/shape-12.png" alt="shape">
                                </li>
                                <li class="shape-03 scene">
                                    <img data-depth="-3" src="{{ asset('frontend') }}/assets/images/cta/shape-04.png" alt="shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="edu-cta-banner-area home-one-cta-wrapper bg-image">
            <div class="container">
                <div class="edu-cta-banner">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up"
                                data-sal-duration="800">
                                <h2 class="title">Get Your Quality Skills <span
                                        class="color-secondary">Certificate</span> Through VedicCivil</h2>
                                <a href="{{ route('contactUs') }}" class="edu-btn">Get started now <i class="icon-4"></i></a>
                            </div>
                        </div>
                    </div>
                    <ul class="shape-group">
                        <li class="shape-01 scene">
                            <img data-depth="2.5" src="{{ asset('frontend') }}/assets/images/cta/shape-10.png" alt="shape">
                        </li>
                        <li class="shape-02 scene">
                            <img data-depth="-2.5" src="{{ asset('frontend') }}/assets/images/cta/shape-09.png" alt="shape">
                        </li>
                        <li class="shape-03 scene">
                            <img data-depth="-2" src="{{ asset('frontend') }}/assets/images/cta/shape-08.png" alt="shape">
                        </li>
                        <li class="shape-04 scene">
                            <img data-depth="2" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="shape">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Ad Banner Area  -->
        <!--=====================================-->
        <!--=      		Brand Area Start   		=-->
        <!--=====================================-->
        <!-- Start Brand Area  -->
        <!-- <div class="edu-brand-area brand-area-1 gap-top-equal">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="brand-section-heading">
                            <div class="section-title section-left" data-sal-delay="150" data-sal="slide-up"
                                data-sal-duration="800">
                                <span class="pre-title">Our Partners</span>
                                <h2 class="title">Learn with Our Partners</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incididunt.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="brand-grid-wrap">
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-01.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-02.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-03.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-04.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-05.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-06.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-07.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="{{ asset('frontend') }}/assets/images/brand/brand-08.png" alt="Brand Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End Brand Area  -->
        <!--=====================================-->
        <!--=      		Blog Area Start   		=-->
        <!--=====================================-->
        <!-- Start Blog Area  -->
        <div class="edu-blog-area blog-area-1 edu-section-gap">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="100" data-sal="slide-up"
                    data-sal-duration="800">
                    <span class="pre-title">Latest Articles</span>
                    <h2 class="title">Get News with Vedic Civil</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="100" data-sal="slide-up"
                        data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.php">
                                        <img src="{{ asset('frontend') }}/assets/images/blog/blog-01.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.php"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">ONLINE</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.php">Become a Better Blogger: Content
                                            Planning</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2024</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="200" data-sal="slide-up"
                        data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.php">
                                        <img src="{{ asset('frontend') }}/assets/images/blog/blog-02.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.php"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">LECTURE</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.php">How to Keep Workouts Fresh in the
                                            Morning</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2024</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed do eiusmod ux tempor incid
                                        idunt labore dol oremagna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="300" data-sal="slide-up"
                        data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.php">
                                        <img src="{{ asset('frontend') }}/assets/images/blog/blog-03.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.php"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">BUSINESS</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.php">Four Ways to Keep Your Workout
                                            Routine
                                            Fresh</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2024</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed do eiusmod ux tempor incid
                                        idunt.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1 scene">
                    <img data-depth="-1.4" src="{{ asset('frontend') }}/assets/images/about/shape-02.png" alt="Shape">
                </li>
                <li class="shape-2 scene">
                    <span data-depth="2.5"></span>
                </li>
                <li class="shape-3 scene">
                    <img data-depth="-2.3" src="{{ asset('frontend') }}/assets/images/counterup/shape-05.png" alt="Shape">
                </li>
            </ul>
        </div>

    </div>
    @endsection
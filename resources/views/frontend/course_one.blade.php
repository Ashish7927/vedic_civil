@extends('frontend.master')
@section('mainContent')

        <div class="edu-breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title">Course</h1>
                    </div>
                    <ul class="edu-breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="#">Courses</a></li>
                    </ul>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <span></span>
                </li>
                <li class="shape-2 scene"><img data-depth="2" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="shape"></li>
                <li class="shape-3 scene"><img data-depth="-2" src="{{ asset('frontend') }}/assets/images/about/shape-15.png" alt="shape"></li>
                <li class="shape-4">
                    <span></span>
                </li>
                <li class="shape-5 scene"><img data-depth="2" src="{{ asset('frontend') }}/assets/images/about/shape-07.png" alt="shape"></li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=        Courses Area Start         =-->
        <!--=====================================-->
        <div class="edu-course-area course-area-1 gap-tb-text">
            <div class="container">

                <div class="edu-sorting-area">
                    <div class="sorting-left">
                        <h6 class="showing-text">We found <span>71</span> courses available for you</h6>
                    </div>
                    <div class="sorting-right">
                        <div class="layout-switcher">
                            <label>Grid</label>
                            <ul class="switcher-btn">
                                <li><a href="course-one.php" class="active"><i class="icon-53"></i></a></li>
                                <!-- <li><a href="course-four.php" class=""><i class="icon-54"></i></a></li> -->
                            </ul>
                        </div>
                        <!-- <div class="edu-sorting">
                            <div class="icon"><i class="icon-55"></i></div>
                            <select class="edu-select">
                                <option>Filters</option>
                                <option>Low To High</option>
                                <option>High Low To</option>
                                <option>Last Viewed</option>
                            </select>
                        </div> -->
                    </div>
                </div>

                <div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">Quantity Surveying(Estimating)</a>
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
                                    <p>Estimating knowledge is crucial for civil engineers, with high demand and salaries for roles like Estimator, 
                                        Quantity Surveyor, and Project Manager. Our training surpasses 10-year site experience, preparing students 
                                        for these roles, especially valuable for women in official positions.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">MODERATE ESSENTIAL
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
                                    <p>Survey training (Total Station training, Auto level training,Digital Theodolite,GPS Training Trng.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div><div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">Quantity Surveying(Estimating)</a>
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
                                    <p>Estimating knowledge is crucial for civil engineers, with high demand and salaries for roles like Estimator, 
                                        Quantity Surveyor, and Project Manager. Our training surpasses 10-year site experience, preparing students 
                                        for these roles, especially valuable for women in official positions.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">MODERATE ESSENTIAL
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
                                    <p>Survey training (Total Station training, Auto level training,Digital Theodolite,GPS Training Trng.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div><div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">Quantity Surveying(Estimating)</a>
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
                                    <p>Estimating knowledge is crucial for civil engineers, with high demand and salaries for roles like Estimator, 
                                        Quantity Surveyor, and Project Manager. Our training surpasses 10-year site experience, preparing students 
                                        for these roles, especially valuable for women in official positions.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">MODERATE ESSENTIAL
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
                                    <p>Survey training (Total Station training, Auto level training,Digital Theodolite,GPS Training Trng.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div><div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">Quantity Surveying(Estimating)</a>
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
                                    <p>Estimating knowledge is crucial for civil engineers, with high demand and salaries for roles like Estimator, 
                                        Quantity Surveyor, and Project Manager. Our training surpasses 10-year site experience, preparing students 
                                        for these roles, especially valuable for women in official positions.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">MODERATE ESSENTIAL
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
                                    <p>Survey training (Total Station training, Auto level training,Digital Theodolite,GPS Training Trng.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
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
                                    <a href="course-details.php">
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
                                        <a href="course-details.php">LEAST ESSENTIAL</a>
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
                                    <a href="course-details.php" class="edu-btn btn-secondary btn-small">Enrolled <i
                                            class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div>
                <div class="load-more-btn" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1200">
                    <a href="course-one.php" class="edu-btn">Load More <i class="icon-56"></i></a>
                </div>
            </div>
        </div>
        <!-- End Course Area -->
        <!--=====================================-->
        <!--=        Footer Area Start          =-->
        <!--=====================================-->
        <!-- Start Footer Area  -->
        @endsection


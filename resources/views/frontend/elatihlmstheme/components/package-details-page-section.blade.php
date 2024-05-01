<style type="text/css">
    .price_main_div .prise_tag {
        font-weight: 700;
        color: var(--system_primery_color);
    }

    .price_main_div .prise_tag .prev_prise {
        text-decoration: line-through;
        color: var(--system_secendory_color);
        font-size: 22px;
        font-weight: 600;
        padding-bottom: 5px;
    }

    .details_div_1 {
        margin-right: 15px;
    }

    .table-responsive li{
        list-style: revert;
    }
    .table-responsive ul{
        margin: revert;
        margin-top: 0;
        padding: revert;
    }
    

    @media screen and (max-width:767px) {
        .section_1 {
            width: 100% !important;
        }

        .section_2 {
            width: 100% !important;
        }

        .section_3 {
            width: 100% !important;
        }

        .course__details .course__details_title .single__details .details_content span {
            font-size: 12px !important;
        }

        .single__details h4 {
            font-size: 15px !important;
        }

        .thumb_div_background_img {
            margin-top: -50px !important;
        }
    }

    @media screen and (min-width:768px) {
        .section_1 {
            width: 50% !important;
        }

        .section_2 {
            width: 25% !important;
        }

        .section_3 {
            width: 25% !important;
        }

        .details_div_1 {
            margin-right: 25px !important;
        }

        .div_details_content {
            display: flex !important;
        }
    }

    .sidebar__widget .sidebar__title {
        justify-content: space-between;
    }
    .sidebar__widget .sidebar__title p a, .sidebar__widget .sidebar__title p,
    .sidebar__widget .sidebar__title p i {
        font-size: 12px;
    }

    .sidebar__widget .sidebar__title h3 {
        font-size: 28px;
    }
</style>
<div>
    <input type="hidden" value="{{ asset('/') }}" id="baseUrl">
    <div class="course__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-10">
                    <div class="course__details_title">
                        <div class="single__details section_1">
                            @php
                                $content_provider   = '';
                                $cp_image           = url('public/demo/user/instructor.jpg');

                                if (isset($package->user)) {
                                    $content_provider   = $package->user->name;
                                    $cp_img             = \Config::get('app.public_url').$package->user->image;

                                    if (checkExternalFile($cp_img)) {
                                        $cp_image = $cp_img;
                                    }
                                }
                            @endphp

                            @if (isset($package->user) && ($package->user->role_id == 7 || is_partner($package->user)))
                                <div class="thumb thumb_div_background_img" style="background-image: url('{{ $cp_image }}');"> </div>
                            @else
                                <div class="thumb" style="background-image: url('{{ $cp_image }}')"> </div>
                            @endif

                            <div class="details_content div_details_content">
                                <div class="details_div_1">
                                    <span>{{ __('frontend.Content Provider') }} {{ __('frontend.Name') }}</span>
                                    <h4 class="f_w_700">{{ $content_provider }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mt_40 mb_40">
                        <div class="mb_10">
                            <span><b>{{ __('frontend.Category') }}</b></span>
                        </div>

                        <div class="social_btns">
                            @foreach ($package->categories as $package_category)
                                @if (isset($package_category->category))
                                    <a class="social_btn" style="background: #f8f8fe; color: black; margin-top: 5px;">{{ $package_category->category->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="video_screen mb_60"> </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <div class="course_tabs text-center">
                                <ul class="w-100 nav lms_tabmenu mb_55" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Overview-tab" data-toggle="tab" href="#Overview" role="tab" aria-controls="Overview" aria-selected="true">
                                            {{ __('frontend.Overview') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Instructor-tab" data-toggle="tab" href="#Instructor" role="tab" aria-controls="Instructor" aria-selected="false">
                                            {{ __('frontend.Package Details') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content lms_tab_content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Overview" role="tabpanel" aria-labelledby="Overview-tab">
                                    <div class="course_overview_description">
                                        <div class="single_overview">
                                            @if (!empty($package->overview))
                                                <h4 class="font_22 f_w_700 mb_20"> {{ __('frontend.Package Overview') }} </h4>
                                                <div class="theme_border"></div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            {!! $package->overview !!}
                                                        </div>
                                                    </div>

                                                </div>
                                                <p class="mb_20"> </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Instructor" role="tabpanel" aria-labelledby="Instructor-tab">
                                    {{-- <div class="instractor_details_wrapper">
                                        <div class="instractor_title">
                                            <h4 class="font_22 f_w_700">{{ __('frontend.Package Details') }}</h4>
                                        </div>
                                        <div class="instractor_details_inner">
                                            <div class="thumb">
                                                <img class="w-100" src="{{ $cp_image }}" alt="">
                                            </div>
                                            <div class="instractor_details_info">
                                                <span>{{ __('frontend.Package Details') }}</span>
                                                @if (isset($package->user) && ($package->user->role_id == 7 || is_partner($package->user)))
                                                    <h4 class="f_w_700"> {{ $content_provider }} </h4>
                                                @else
                                                    @if (isset($package->user) && isset($package->user->id))
                                                        <a href="{{ route('instructorDetails', [$package->user->id, $package->user->name]) }}">
                                                            <h4 class="font_22 f_w_700"> {{ $content_provider }} </h4>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="course_overview_description">
                                        <div class="single_overview">
                                            @if (!empty($package->description))
                                                <h4 class="font_22 f_w_700">{{ __('frontend.Package Details') }}</h4>
                                                <div class="theme_border"></div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            {!! $package->description !!}
                                                        </div>
                                                    </div>

                                                </div>
                                                <p class="mb_20"> </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="author_courses">
                                        <div class="section__title mb_80">
                                            <h3>{{ __('frontend.More Packages by Content Provider') }}</h3>
                                        </div>
                                        <div class="row">
                                            @foreach ($more_packages_by_author as $package_by_author)
                                                @php
                                                    $package_img    = \Config::get('app.public_url').$package_by_author->image;
                                                    $image          = asset('public/uploads/course_sample.png');

                                                    if (checkExternalFile($package_img)) {
                                                        $image = $package_img;
                                                    }
                                                @endphp

                                                <div class="col-xl-6">
                                                    <div class="couse_wizged mb_30">
                                                        <div class="thumb">
                                                            <a href="{{ route('packageDetailsView', $package_by_author->slug) }}">
                                                                <img class="w-100" src="{{ $image }}" alt="">
                                                                <x-price-tag :price="$package_by_author->price" :discount="0" />
                                                            </a>
                                                        </div>
                                                        <div class="course_content">
                                                            <a href="{{ route('packageDetailsView', $package_by_author->slug) }}">
                                                                <h4>{{ $package_by_author->name }}</h4>
                                                            </a>
                                                            <div class="rating_cart">
                                                                <div class="rateing">
                                                                    <span>{{ $package_by_author->totalReview }}/5</span>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                                @auth()
                                                                    @if (!$package_by_author->isLoginUserEnrolled && !$package_by_author->isLoginUserCart)
                                                                        <a href="#" class="cart_store" data-id="{{ $package_by_author->id }}">
                                                                            <i class="fas fa-shopping-cart"></i>
                                                                        </a>
                                                                    @endif
                                                                @endauth
                                                                @guest()
                                                                    @if (!$package_by_author->isGuestUserCart)
                                                                        <a href="#" class="cart_store" data-id="{{ $package_by_author->id }}">
                                                                            <i class="fas fa-shopping-cart"></i>
                                                                        </a>
                                                                    @endif
                                                                @endguest
                                                            </div>
                                                            <div class="course_less_students">
                                                                <a href="#">
                                                                    <i class="ti-agenda"></i>
                                                                    {{ count($package_by_author->package_courses) }}
                                                                    {{ __('frontend.Courses') }}
                                                                </a>
                                                                <a href="#">
                                                                    <i class="ti-user"></i>
                                                                    {{ $package_by_author->total_enrolled }}
                                                                    {{ __('frontend.Students') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="sidebar__widget mb_30">
                                <div class="sidebar__title" style="margin-bottom: 0px;">
                                    @if (isset($package->status) && $package->status == 1)
                                        <p>
                                            @if (Auth::check() && $isBookmarked)
                                                <i class="fas fa-heart"></i>
                                                <a href="{{ route('packageBookmarkSave', [$package->id]) }}" class="">{{ __('frontend.Already Bookmarked') }} </a>
                                            @elseif (Auth::check() && !$isBookmarked)
                                                <a href="{{ route('packageBookmarkSave', [$package->id]) }}" class="">
                                                    <i class="far fa-heart"></i>
                                                    {{ __('frontend.Add To Bookmark') }}
                                                </a>
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <div class="sidebar__title">
                                    <div class="price_main_div">
                                        @php
                                            $price_detail = $package->price;
                                            $discount_detail = 0;
                                        @endphp
                                        <span class="prise_tag" style="font-size: 23px;">
                                            <span>
                                                @if (@$discount_detail != null)
                                                    {{ getPriceFormat($discount_detail) }}/pax/{{ $package->expiry_period }} {{ __('Months') }}
                                                @else
                                                    @if (@$price_detail != 0)
                                                        {{ getPriceFormat($price_detail) }}/pax/{{ $package->expiry_period }} {{ __('Months') }}
                                                    @else
                                                        Free
                                                    @endif
                                                @endif
                                            </span>
                                            @if (@$discount_detail != null)
                                                @if (@$price_detail != 0)
                                                    <span class="prev_prise">
                                                        {{ getPriceFormat($price_detail) }}/pax/{{ $package->expiry_period }} {{ __('Months') }}
                                                    </span>
                                                @else
                                                    Free
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if (Auth::check() && (isAdmin() || isHRDCorp() || isMyLL()))
                                    <a href="{{ route('continuePackage', [$package->slug]) }}" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Continue Watch') }}</a>
                                @endif
                                {{-- @if (Auth::check())
                                    @if (isStudent())
                                        <a href="{{ @$package->course_url }}" target="_blank" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Continue Watch') }}</a>
                                    @else
                                        @if ($isEnrolled)
                                            <a href="{{ route('continuePackage', [$package->slug]) }}" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Continue Watch') }}</a>

                                            @if (isCorporateAdmin())
                                                <a href=" {{ route('packageAddToCart', [@$package->id]) }}" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Add To Cart') }}</a>
                                            @endif
                                        @else
                                            @if ($isFree)
                                                @if ($is_cart == 1)
                                                    <a href="javascript:void(0)" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Added To Cart') }}</a>
                                                @else
                                                    <a href="{{ route('packageEnrolFree', [@$package->id]) }}" class="theme_btn d-block text-center height_50 mb_10"> Enrol Now </a>
                                                @endif
                                            @else
                                                @if ($is_cart == 1)
                                                    <a href="javascript:void(0)" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Added To Cart') }}</a>
                                                @else
                                                    <a href=" {{ route('packageAddToCart', [@$package->id]) }}" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Add To Cart') }}</a>
                                                @endif
                                                <a href="{{ route('packageBuyNow', [@$package->id]) }}" class="theme_line_btn d-block text-center height_50 mb_20">{{ __('common.Buy Now') }}</a>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if ($isFree)
                                        @if ($is_cart == 1)
                                            <a href="javascript:void(0)" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Added To Cart') }}</a>
                                        @else
                                            <a href="{{ route('login') }}" class="theme_btn d-block text-center height_50 mb_10">Enrol Now</a>
                                        @endif
                                    @else
                                        @if ($is_cart == 1)
                                            <a href="javascript:void(0)" class="theme_btn d-block text-center height_50 mb_10">{{ __('common.Added To Cart') }}</a>
                                        @else
                                            <a href="javascript:void(0)" class="theme_btn d-block text-center height_50 mb_10" id="add_to_cart_without_login">{{ __('common.Add To Cart') }}</a>

                                            <a href="javascript:void(0)" class="theme_line_btn d-block text-center height_50 mb_20" id="buy_now_without_login">{{ __('common.Buy Now') }}</a>
                                        @endif
                                    @endif
                                @endif --}}
                                <p class="font_14 f_w_500 text-center mb_30"></p>
                                <h4 class="f_w_700 mb_10">{{ __('frontend.This package includes') }}:</h4>
                                <ul class="course_includes">
                                    <li>
                                        <i class="ti-alarm-clock"></i>
                                        <p class="nowrap">
                                            {{ __('frontend.Duration') }}: {{ $package->expiry_period }} {{ __('Months') }}
                                        </p>
                                    </li>
                                    <li>
                                        <i class="ti-agenda"></i>
                                        <p>
                                            {{ __('frontend.Courses') }}: {{ $package->total_course }} {{ __('frontend.Courses') }}
                                        </p>
                                    </li>
                                    {{-- <li>
                                        <i class="ti-user"></i>
                                        <p>
                                            {{ __('frontend.Enrolled') }}: {{ $package->total_enrolled }} {{ __('frontend.students') }}
                                        </p>
                                    </li> --}}
                                    <li>
                                        <i class="ti-blackboard"></i>
                                        <p>
                                            {{ __('frontend.Minimum License') }}: {{ ($package->min_license_no == 0) ? 'N/A' : $package->min_license_no }}
                                        </p>
                                    </li>
                                    <li>
                                        <i class="ti-blackboard"></i>
                                        <p>
                                            {{ __('frontend.Maximum License') }}: {{ ($package->max_license_no == 0) ? 'N/A' : $package->max_license_no }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#add_to_cart_without_login").click(function() {
            toastr.error("Please Login To Continue!!");
        });

        $("#buy_now_without_login").click(function() {
            toastr.error("Please Login To Continue!!");
        });
    });
</script>

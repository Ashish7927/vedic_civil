@if (isset($courses) && $courses->count() > 0)
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-lg-6 col-xl-4">
                <div class="couse_wizged">
                    <a href="{{ courseDetailsUrl(@$course->id, @$course->type, @$course->slug) }}">
                        <div class="thumb">
                            @php
                                $image_path = file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/uploads/course_sample.png');
                            @endphp

                            <div class="thumb_inner lazy" data-src="{{ $image_path }}" style="background-image: url({{ $image_path }})"> </div>
                            {{ $course->price }}
                            <x-price-tag :price="$course->price" :discount="$course->discount_price" />
                        </div>
                    </a>
                    <div class="course_content">
                        <a href="{{ courseDetailsUrl(@$course->id, @$course->type, @$course->slug) }}">
                            <h4 class="course_title" title=" {{ $course->title }}">
                                {{ $course->title }}
                            </h4>
                        </a>

                        <div class="rating_cart">
                            <div class="rateing">
                                <span>{{ $course->totalReview }}/5</span>
                                <i class="fas fa-star"></i>
                            </div>

                            {{-- <div id="badge_e_learning_div">
                                <span class="badge" id="e_learning_badge">e-Learning</span>
                            </div> --}}

                            @auth()
                                @if (!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                    <a href="#" class="cart_store" data-id="{{ $course->id }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                @endif
                            @endauth
                            @guest()
                                @if (!$course->isGuestUserCart)
                                    <a href="#" class="cart_store" data-id="{{ $course->id }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                @endif
                            @endguest
                        </div>

                        <div class="course_less_students">
                            <a> <i class="ti-agenda"></i> {{ count($course->lessons) }}
                                {{ __('frontend.Lessons') }}</a>
                            <a>
                                <i class="ti-user"></i> {{ $course->total_enrolled }}
                                {{ __('frontend.Students') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row pagination_row">
        <nav>
            {{ $courses->links(theme('pages.custom_pagination')) }}
        </nav>
    </div>
@else
    <div class="col-lg-12">
        <div class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
            <div class="thumb">
                <img style="width: 50px" src="{{ asset('public/frontend/elatihlmstheme') }}/img/not-found.png"
                    alt="">
            </div>
            <h1>
                {{ __('frontend.No Course Found') }}
            </h1>
        </div>
    </div>
@endif


<div>
<style>
.slider_btn_text{background:#212F64!important;}
.banner_area{background-size: cover!important;
    background-position: center center!important; background-repeat:no-repeat;}

    @media screen and (max-width: 1020px) {
        .banner_area {
            height: 550px !important;
        }
    }

    @media screen and (max-width: 767.98px) {
        .banner_area {
            height: 350px !important;
        }
    }
</style>
    <link href="{{ asset('public/css/banner.css') }}" rel="stylesheet">
    @if($homeContent->show_banner_section==1)
        <form action="{{route('search')}}">
            <div class="banner_area"
                 @if(isset($homeContent->slider_banner) && !empty($homeContent->slider_banner))
                 style="background-image: url('{{asset(@$homeContent->slider_banner)}}')"
                @endif>
                <div class="container">
                    <div class="row d-flex align-items-center banner-items">
                        <div class="col-lg-9 offset-lg-1">
                            <div class="banner_text">
                                <h3 class="header_title">{{@$homeContent->slider_title}}</h3>
                                <p class="header_text">{{@$homeContent->slider_text}}</p>
                                @if(@$homeContent->show_banner_search_box==1)
                                    <div class="input-group theme_search_field large_search_field">
                                        <div class="input-group-prepend">
                                            <button class="btn" type="submit" id="button-addon2">
                                                <i class="ti-search search-large"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="query" class="form-control"
                                               placeholder="{{__('frontend.Search for course, skills and Videos')}}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else

        <div class="owl-carousel" id="bannerSlider">
            @if($sliders)
                @foreach($sliders as $key=>$slider)
                    @if($slider->image_as_link == 1)
                        <a href="{{ $slider->link }}" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">
                    @endif
                    @if ($agent->isMobile())
                                <div class="banner_area_mobile banner_area" style="background-image: url({{asset(@$slider->mobile_image)}})">
                                    <div class="container">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-lg-9 offset-lg-1">
                                                <div class="banner_text">
                                                    @if($slider->show_title==1)
                                                        <h3 class="header_title">{{@$slider->title}}</h3>
                                                    @endif
                                                    @if($slider->show_subtitle==1)
                                                        <p class="header_text">{{@$slider->sub_title}}</p>
                                                    @endif

                                                    <div class="row d-flex align-items-center">
                                                        @if($slider->btn_type1==1)
                                                            @if(!empty($slider->btn_title1))
                                                                <div class="single_slider">
                                                                    <a href="{{$slider->btn_link1}}"
                                                                       class="slider_btn_text text-center" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">{{$slider->btn_title1}}</a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="single_slider">
                                                                <a href="{{$slider->btn_link1}}" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">
                                                                    <img
                                                                        src="{{asset($slider->btn_image1)}}"
                                                                        alt="">

                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if($slider->btn_type2==1)
                                                            @if(!empty($slider->btn_title2))
                                                                <div class="single_slider">
                                                                    <a href="{{$slider->btn_link2}}"
                                                                       class="slider_btn_text text-center" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">{{$slider->btn_title2}}</a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="single_slider">
                                                                <a href="{{$slider->btn_link2}}" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">
                                                                    <img
                                                                        src="{{asset($slider->btn_image2)}}"
                                                                        alt="">

                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($slider->show_searchbar == 1)
                                                        <form action="{{route('search')}}">
                                                            <div class="input-group theme_search_field large_search_field">
                                                                <div class="input-group-prepend">
                                                                    <button class="btn" type="submit" id="button-addon2"><i
                                                                            class="ti-search search-large"></i>
                                                                    </button>
                                                                </div>
                                                                <input type="text" name="query" class="form-control"
                                                                       placeholder="{{__('frontend.Search for course, skills and Videos')}}">
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @else
                                <div class="banner_area" style="background-image: url({{asset(@$slider->image)}})">
                                    <div class="container">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-lg-9 offset-lg-1">
                                                <div class="banner_text">
                                                    @if($slider->show_title==1)
                                                        <h3 class="header_title">{{@$slider->title}}</h3>
                                                    @endif
                                                    @if($slider->show_subtitle==1)
                                                        <p class="header_text">{{@$slider->sub_title}}</p>
                                                    @endif

                                                    <div class="row d-flex align-items-center">
                                                        @if($slider->btn_type1==1)
                                                            @if(!empty($slider->btn_title1))
                                                                <div class="single_slider">
                                                                    <a href="{{$slider->btn_link1}}"
                                                                       class="slider_btn_text text-center" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">{{$slider->btn_title1}}</a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="single_slider">
                                                                <a href="{{$slider->btn_link1}}" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">
                                                                    <img
                                                                        src="{{asset($slider->btn_image1)}}"
                                                                        alt="">

                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if($slider->btn_type2==1)
                                                            @if(!empty($slider->btn_title2))
                                                                <div class="single_slider">
                                                                    <a href="{{$slider->btn_link2}}"
                                                                       class="slider_btn_text text-center" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">{{$slider->btn_title2}}</a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="single_slider">
                                                                <a href="{{$slider->btn_link2}}" target="{{ $slider->open_in_new == 1 ? '_blank' : '' }}">
                                                                    <img
                                                                        src="{{asset($slider->btn_image2)}}"
                                                                        alt="">

                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($slider->show_searchbar == 1)
                                                        <form action="{{route('search')}}">
                                                            <div class="input-group theme_search_field large_search_field">
                                                                <div class="input-group-prepend">
                                                                    <button class="btn" type="submit" id="button-addon2"><i
                                                                            class="ti-search search-large"></i>
                                                                    </button>
                                                                </div>
                                                                <input type="text" name="query" class="form-control"
                                                                       placeholder="{{__('frontend.Search for course, skills and Videos')}}">
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endif

                    @if($slider->image_as_link == 1)
                        </a>
                    @endif

                @endforeach
            @endif
        </div>
    @endif

</div>

<script type="text/javascript">
    $( document ).ready(function() {
        var block = false;
        var block_focus = false;
        var owl = $("#bannerSlider");

        owl.owlCarousel({
            stagePadding: 0,
            items: 1,
            loop: true,
            margin: 0,
            singleItem: true,
        });

        $('body').on('mouseleave', '#bannerSlider', function(){
            if(!block) {
                block = true;
                console.log(block);
                owl.trigger('play.owl.autoplay',[1000]);
                block = false;
            }
        });
        $('body').on('focus', '#bannerSlider', function(){
            if(!block_focus) {
                block_focus = true;
                console.log('focus');
                console.log(block_focus);
                owl.trigger('stop.owl.autoplay');
                block_focus = false;
            }
        });

        // $('.large_search_field').on("blur", function () {
        // $("body").on("focusout", "#bannerSlider", function(){
        //     if(!block_focus) {
        //         block_focus = true;
        //         console.log('focus');
        //         console.log(block_focus);
        //         owl.trigger('play.owl.autoplay',[1000]);
        //         block_focus = false;
        //     }
        // });

    });



</script>

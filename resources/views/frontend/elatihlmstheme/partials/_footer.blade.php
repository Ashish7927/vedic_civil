<!-- FOOTER::START  -->
<x-popup-content/>
 <style type="text/css">


    footer{background-color: white;}
        .footer_logo img {
    width: 100%!important;
    max-width: 275px;
}
footer .copyright_area .footer_widget p {
    font-size: 16px;
    color: #3C3D5D;
    margin-bottom: 0;
    line-height: 30px;
    font-weight: 500;
}
footer .copyright_area .footer_widget .footer_title h3 {

    font-size: 22px;
    font-weight: bolder;
    color: #F04D21;

}

footer .copyright_area .footer_widget .footer_links li a {
    font-size: 18px;
    font-weight: 400;
    color: #f04d21;
    line-height: 35px;
    font-family: Jost,sans-serif;
}
    </style>
<footer class="{{Settings('footer_show')==0?'d-none d-sm-none d-md-block d-lg-block d-xl-block':''}}">
    @if($homeContent->show_subscribe_section==1)
        <x-footer-news-letter/>
    @endif
    <div class="copyright_area">
        <div class="container">
            <div class="row">
                {{--                @if(!isset($sectionWidgets) || (count($sectionWidgets['one'])==0 && count($sectionWidgets['two'])==0 && count($sectionWidgets['three'])==0 ) )--}}

                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                                <img src="{{getCourseImage(Settings('logo2'))}}" alt=""
                                     style="width: 220px">
                            </a>
                        </div>
                        <p>{{ Settings('footer_about_description')  }}</p>
                        <div class="copyright_text">
                            <p>{!! Settings('footer_copy_right')  !!}</p>
                        </div>

                        <style>


                        </style>
                        <div class="">
                            <ul class="pt-3 ">
                                <ul class="social-network social-circle col-lg-12 ">
                                    <x-footer-social-links/>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-5">

                        <x-footer-section-widgets/>

                </div>
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="footer_widget">
                        <div class="copyright_text">
                            <p><a href="https://hrdcorp.gov.my/" target="_blank"><img src="{{asset('/public/uploads/editor-image/')}}/HRDCorpLogo-01-p619t8tdt51ghw3vbeulbvu7i3z9blja41poix5khs.png1643334555.png" style="width: 275px;"></a></p><p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER::END  -->
<!-- shoping_cart::start  -->
<div class="shoping_wrapper">
    <div class="dark_overlay"></div>
    <div class="shoping_cart">
        <div class="shoping_cart_inner">
            <div class="cart_header d-flex justify-content-between">
                <h4>{{__('frontend.Shopping Cart')}}</h4>
                <div class="chart_close">
                    <i class="ti-close"></i>
                </div>
            </div>
            <div id="cartView">
                <div class="single_cart">
                    Loading...
                </div>
            </div>


        </div>
        <div class="view_checkout_btn d-flex justify-content-end gap_10 flex-wrap" style="display: none!important;">
            <a href="{{url('my-cart')}}"
               class="theme_btn small_btn3 flex-fill text-center">{{__('frontend.View cart')}}</a>
            <a href="{{route('myCart',['checkout'=>true])}}"
               class="theme_btn small_btn3 flex-fill text-center">{{__('frontend.Checkout')}}</a>
        </div>
    </div>
</div>
<!-- shoping_cart::end  -->

<!-- UP_ICON  -->
<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="fa fa-angle-up"></i>
    </a>
</div>

<input type="hidden" name="item_list" class="item_list" value="{{url('getItemList')}}">
<input type="hidden" name="enroll_cart" class="enroll_cart" value="{{url('enrollOrCart')}}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
<!--/ UP_ICON -->

<x-footer-cookie/>

<!--ALL JS SCRIPTS -->


<script src="{{asset('public/frontend/elatihlmstheme/js/app.js')}}?v=1"></script>




{!! Toastr::message() !!}

@if($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', 'Error', {
            closeButton: true,
            progressBar: true,
        });
        @endforeach
    </script>
@endif
@yield('js')

<script>
    setTimeout(function () {
        $('.preloader').fadeOut('slow', function () {
            // $(this).remove();

        });
    }, 0);


    $('#cartView').on('click', '.remove_cart', function () {
        let id = $(this).data('id');
        let total = $('#cart_count').html();

        $(this).closest(".single_cart").hide();
        let url = "{{url(('/home/removeItemAjax'))}}" + '/' + id;

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {

                $('#cart_count').html(total - 1);
            }
        });
    });

    $(function () {
        $('.lazy').Lazy();
    });


</script>
@auth
    @if(Settings('device_limit_time')!=0)
        @if(\Illuminate\Support\Facades\Auth::user()->role_id==3)
            <script>
                function update() {
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/')}}" + "/update-activity",
                        success: function (data) {


                        }
                    });
                }

                var intervel = "{{Settings('device_limit_time')}}"
                var time = (intervel * 60) - 20;

                setInterval(function () {
                    update();
                }, time * 1000);

            </script>
        @endif
    @endif
@endauth
<script>
    $(document).on('click', '.show_notify', function (e) {
        e.preventDefault();

        console.log('notify');
    });
    if ($('#main-nav-for-chat').length) {
    } else {
        $('#main-content').append('<div id="main-nav-for-chat" style="visibility: hidden;"></div>');
    }

    if ($('#admin-visitor-area').length) {
    } else {
        $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
    }
</script>

<script src="{{asset('public/frontend/elatihlmstheme/js/nice-select.min.js')}}"></script>
<script src="{{asset('public/frontend/elatihlmstheme/js/owl.carousel.min.js')}}"></script>
<script>
    if ($(".fourm_select").length > 0) {
        $(".fourm_select").niceSelect();
    }
</script>

@if(str_contains(request()->url(), 'chat'))
    <script src="{{asset('public/backend/js/jquery-ui.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/select2.min.js')}}"></script>
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/chat/js/custom.js') }}"></script>
@endif

@if(auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
    <script src="{{ asset('public/js/app.js') }}"></script>
@endif


@if(isModuleActive("WhatsappSupport"))
    <script src="{{ asset('public/whatsapp-support/scripts.js') }}"></script>

    @include('whatsappsupport::partials._popup')

    @endif


    </body>

    </html>

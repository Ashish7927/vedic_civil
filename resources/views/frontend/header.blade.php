<!DOCTYPE html>
<html class="no-js" lang="zxx">


<!-- Mirrored from edublink.html.devsblink.com/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 31 May 2024 07:58:49 GMT -->

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vedic Civil</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/images/logo/logo-dark.png">
    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/icomoon.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/remixicon.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/magnifypopup.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/odometer.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/lightbox.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/animation.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/jqueru-ui-min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vendor/tipped.min.css">
    <!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.4/dist/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.21.4/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.21.4/dist/js/uikit-icons.min.js"></script>

    <!-- Site Stylesheet -->
      <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/app.css">
</head>
<header class="edu-header header-style-1 header-fullwidth">
            <div class="header-top-bar">
                <div class="container-fluid">
                    <div class="header-top">
                        <div class="header-top-left">
                           
                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                
                                <li><a href="tel:+011235641231"><i class="icon-phone"></i>Call:  63718-34-256</a></li>
                                <li><a href="mailto:info@edublink.com" target="_blank"><i
                                            class="icon-envelope"></i>Email:  vediccivil@gmail.com</a></li>
                                <li class="social-icon">
                                    <a href="https://www.facebook.com/vediccivil/" target="_blank"><i class="icon-facebook"></i></a>
                                    <a href="#"><i class="icon-instagram"></i></a>
                                    <a href="https://x.com/i/flow/login?redirect_after_login=%2Fvediccivil"><i class="icon-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edu-sticky-placeholder"></div>
            <div class="header-mainmenu">
                <div class="container-fluid">
                    <div class="header-navbar">
                        <div class="header-brand">
                            <div class="logo">
                                <a href="{{ route('indexPage') }}">
                                    <img class="logo-light" src="{{ asset('frontend') }}/assets/images/logo/logo-dark.png" alt="Corporate Logo">
                                    <img class="logo-dark" src="{{ asset('frontend') }}/assets/images/logo/logo-white.png" alt="Corporate Logo">
                                </a>
                            </div>

                        </div>
                        <div class="header-mainnav">
                            <nav class="mainmenu-nav">
                                <ul class="mainmenu">
                                    <li class="menu"><a href="{{ route('indexPage') }}">Home</a>
                                        <ul class="mega-menu mega-menu-one">
                                            <li>
                                                
                                        </ul>
                                    </li>
                                    <li class="menu"><a href="{{ route('aboutOne') }}">About</a>
                                    </li>
                                    <li class="menu"><a href="{{ route('courseOne') }}">Course</a>
                                    </li>

                                    <li class="menu"><a href="{{ route('galleryGrid') }}">Gallery</a>
                                        <ul class="submenu">
                                          
                                        </ul>
                                    </li>
                                    
                                    <li class="menu"><a href="{{ route('contactUs') }}">Contact</a>
                                       
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-right">
                            <ul class="header-action">
                               
                                <li class="header-btn">
                                    <a href="contact-us.php" class="edu-btn btn-medium">Downlaod App <i class="icon-4"></i></a>
                                </li>
                                <li class="mobile-menu-bar d-block d-xl-none">
                                    <button class="hamberger-button">
                                        <i class="icon-54"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-mobile-menu">
                <div class="inner">
                    <div class="header-top">
                        <div class="logo">
                            <a href="{{ route('indexPage') }}">
                                <img class="logo-light" src="{{ asset('frontend') }}/assets/images/logo/logo-dark.png" alt="Corporate Logo">
                                <img class="logo-dark" src="{{ asset('frontend') }}/assets/images/logo/logo-white.png" alt="Corporate Logo">
                            </a>
                        </div>
                        <div class="close-menu">
                            <button class="close-button">
                                <i class="icon-73"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="mainmenu">
                        <li class="has-droupdown"><a href="{{ route('indexPage') }}">Home</a>
                           
                        </li>
                        <li class="has-droupdown"><a href="{{ route('aboutOne') }}">About</a>
                            <ul class="mega-menu">
                                <li>
                                    <h6 class="menu-title">Gallery</h6>
                                   
                                </li>
                        <li class="has-droupdown"><a href="#">Contact</a>
                           
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Start Search Popup  -->
            <div class="edu-search-popup">
                <div class="content-wrap">
                    <div class="site-logo">
                        <img class="logo-light" src="{{ asset('frontend') }}/assets/images/logo/logo-dark.png" alt="Corporate Logo">
                        <img class="logo-dark" src="{{ asset('frontend') }}/assets/images/logo/logo-white.png" alt="Corporate Logo">
                    </div>
                    <div class="close-button">
                        <button class="close-trigger"><i class="icon-73"></i></button>
                    </div>
                    <div class="inner">
                        <form class="search-form" action="#">
                            <input type="text" class="edublink-search-popup-field" placeholder="Search Here...">
                            <button class="submit-button"><i class="icon-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Search Popup  -->
        </header>
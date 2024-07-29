
@extends('frontend.master')
@section('mainContent')
      <div class="edu-breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title">Gallery</h1>
                    </div>
                    <ul class="edu-breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery Grid</li>
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
        <!--=        Gallery Area Start        	=-->
        <!--=====================================-->
        <div class="edu-gallery-area edu-section-gap">
            <div class="container">
                <div class="isotope-wrapper">
                    <div class="isotop-button button-transparent isotop-filter">
                        <button data-filter="*" class="is-checked">
                            <span class="filter-text">All</span>
                        </button>
                        <button data-filter=".education">
                            <span class="filter-text">Education</span>
                        </button>
                        <button data-filter=".marketing">
                            <span class="filter-text">Marketing</span>
                        </button>
                        <button data-filter=".development">
                            <span class="filter-text">Development</span>
                        </button>
                        <button data-filter=".health">
                            <span class="filter-text">Health</span>
                        </button>
                    </div>
                    <div class="isotope-list gallery-grid-wrap">
                        <div id="animated-thumbnials">


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-01.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item education">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10001.jpeg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-02.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item marketing">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10002.jpeg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-03.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item education health">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10003.jpeg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-04.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item marketing">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10004.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-05.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item education">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10005.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-06.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item health">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10006.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-07.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item development">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10007.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-08.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item marketing health">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10008.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>


                            <a href="{{ asset('frontend') }}/assets/images/gallery/gallery-09.webp" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item development">
                                <div class="thumbnail">
                                    <img src="{{ asset('frontend') }}/assets/images/gallery/10010.jpg" alt="Gallery Image">
                                </div>
                                <div class="zoom-icon">
                                    <i class="icon-69"></i>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        <!--=====================================-->
        <!--=        CTA  Area Start            =-->
        <!--=====================================-->
        <!-- Start Ad Banner Area  -->
      
    
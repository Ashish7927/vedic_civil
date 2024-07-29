@extends('frontend.master')
@section('mainContent')
       
        <div class="edu-breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title">Contact Us</h1>
                    </div>
                    <ul class="edu-breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
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
        <!--=       Contact Me Area Start       =-->
        <!--=====================================-->
        <section class="contact-us-area">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xl-4 col-lg-6">
                        <div class="contact-us-info">
                            <h3 class="heading-title">We're Always Eager to Hear From You!</h3>
                            <ul class="address-list">
                                <li>
                                    <h5 class="title">Address</h5>
                                    <p>Flat no-403,Shanti Niwas(SBI ATM),Near Esplanade Mall, Rasulgarh, Bhubaneswar-751010</p>
                                </li>
                                <li>
                                    <h5 class="title">Email</h5>
                                    <p><a href="mailto:edublink@example.com">vediccivil@gmail.com</a></p>
                                </li>
                                <li>
                                    <h5 class="title">Phone</h5>
                                    <p><a href="tel:+0914135548598">(+91)6371834256</a></p>
                                </li>
                            </ul>
                            <ul class="social-share">
                                <li><a href="#"><i class="icon-share-alt"></i></a></li>
                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="offset-xl-2 col-lg-6">
                        <div class="contact-form form-style-2">
                            <div class="section-title">
                                <h4 class="title">Get In Touch</h4>
                                <p>Fill out this form for booking a consultant advising session.</p>
                            </div>
                            <form class="rnt-contact-form rwt-dynamic-form" id="contact-form" method="POST" action="https://edublink.html.devsblink.com/mail.php">
                                <div class="row row--10">
                                    <div class="form-group col-12">
                                        <input type="text" name="contact-name" id="contact-name" placeholder="Your name">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="email" name="contact-email" id="contact-email" placeholder="Enter your email">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="tel" name="contact-phone" id="contact-phone" placeholder="Phone number">
                                    </div>
                                    <div class="form-group col-12">
                                        <textarea name="contact-message" id="contact-message" cols="30" rows="4" placeholder="Your message"></textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="rn-btn edu-btn btn-medium submit-btn" name="submit" type="submit">Submit Message <i class="icon-4"></i></button>
                                    </div>
                                </div>
                            </form>
                            <ul class="shape-group">
                                <li class="shape-1 scene"><img data-depth="1" src="{{ asset('frontend') }}/assets/images/about/shape-13.png" alt="Shape"></li>
                                <li class="shape-2 scene"><img data-depth="-1" src="{{ asset('frontend') }}/assets/images/counterup/shape-02.png" alt="Shape"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=====================================-->
        <!--=      Google Map Area Start        =-->
        <!--=====================================-->
        <div class="google-map-area">
            <div class="mapouter">
                <div class="gmap_canvas">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10584.545897249423!2d85.84991850307877!3d20.29190060513981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a190a05a52fae33%3A0x338855df201994ec!2sShanti%20Niwas!5e0!3m2!1sen!2sin!4v1717395851195!5m2!1sen!2sin" width="1920" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                </div>
            </div>
        </div>

        <!--=====================================-->
        <!--=        Footer Area Start          =-->
        <!--=====================================-->
        @endsection
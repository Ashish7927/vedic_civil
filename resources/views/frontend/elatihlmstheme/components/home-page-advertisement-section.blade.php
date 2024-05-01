<!--Advertisement Start-->
<style>
    .adv_area {
        position: relative;
    }
    img {
        width: 100%;
        height: auto;
    }
    
    .adv_text {
        position: absolute;
        bottom: 0px;
        padding: 20px;
        color: #FFFFFF;
        /* max-width: 95%; */
    }

    .adv_text h2 {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 800;
        line-height: 42px;
        color: #FFFFFF;
    }

    .adv_contact_subtitle {
        font-family: 'Jost';
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 23px;
    }

    .section_spacing {
        padding: 100px 0 120px 0 !important;
    }

    @media screen and (max-width:1200px) {

        .section_spacing {
            padding: 0 0 60px 0 !important;
        }
    }

    @media screen and (max-width:990px) {
        .adv_text h2 {
            font-size: 22px;
            line-height: 26px;
        }
        .adv_area .theme_btn_white {
            font-size: 16px;
            font-weight: 600;
            padding: 11px 18px;
        }

        .section_spacing {
            padding: 0 0 60px 0 !important;
        }
    }
    @media screen and (max-width:760px) {
        .adv_text {
            padding: 10px;
        }
        .adv_text h2 {
            font-size: 16px;
            line-height: 20px;
        }

        .adv_contact_subtitle {
            font-size: 13px;
            line-height: 14px;
        }
        .adv_area .theme_btn_white {
            font-size: 13px;
            font-weight: 600;
            padding: 9px 15px;
        }

        .section_spacing {
            margin-bottom: 0 !important;
        }
    }

    @media screen and (max-width: 440px) {
        .adv_text h2 {
            font-size: 14px;
            line-height: 18px;
        }

        .section_spacing {
            padding: 50px  0 !important;
        }
    }

    @media screen and (max-width: 380px) {
        .adv_area .theme_btn_white {
            font-weight: 400;
            padding: 7px 14px;
        }

        .section_spacing {
            padding: 100px  0 !important;
        }
    }
</style>
<div>
    <div class="section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center">
                    <div class="adv_area mx-auto">
                        {{-- <img src = "{{asset('public/\uploads/shutterstock_1020878011 1.png')}}" width= "1216px" height="586px"> --}}
                        <img src = "{{asset($homeContent->hp_advertisement_banner)}}" width= "1216px" height="586px">
                        <div class="col-12 adv_text" style="background: #EF4D23;">
                            <div class="row">
                                <div class="col-lg-9 col-sm-8 text-left">
                                   {{-- <h3>Learn from industry experts,and connect with a global network of experience</h3> --}}
                                   <h2>{{ @$homeContent->hp_advertisement_title }}</h2>
                                </div>
                                <div class="col-lg-3 col-sm-4 ml-auto " style="margin: auto">
                                    {{-- <div class="adv_contact_subtitle">
                                        On your own time, How and When you want it.
                                    </div> 
                                    <div class="mt-3"> --}}
                                    <div class="text-center">
                                        <a href="{{ route('contact') }}" class="theme_btn_white">Contact Us Now !</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Advertisement End -->
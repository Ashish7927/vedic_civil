<style>
    .promo_details_card {
        position: absolute;
        bottom: 0px;
        background: #EF4D23;
    }

    .promo_details h3 {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 800;
        /* line-height: 42px; */
        color: #FFFFFF;
    }

    .promo_details p {
        font-family: 'Jost';
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 23px;
        color: #FFFFFF;
    }
    
    @media screen  and (max-width: 1400px) { 
        .promo_details h3 {
            font-size: 26px;
            /* line-height: 30px; */
        }

    }
    @media screen and (max-width:1320px) {
        .promo_details h3 {
            font-size: 22px;
        }

        .promo_details p {
            font-size: 14px;
            line-height: 18px;
        }
    }
    @media screen and (max-width:1190px) {
        .promo_details h3 {
            font-size: 20px;
        }

        .promo_details_card {
            min-height: 45%;
        }
    }

    @media screen and (max-width:990px) {
        .promo_details h3 {
            font-size: 16px;
        }

        .promo_details p {
            font-size: 12px;
        }

        .p-3 {
            padding: 10px !important;
        }
    }

    @media (min-width:770px){
    .promo_area{margin-top:180px;}
    }
    @media (max-width:767.98px){
        .promo_area{margin-top:150px;}
        .promo_details h3 {
            font-size: 28px;
        }

        .promo_details p {
            font-size: 16px;
            line-height: 23px;
        }

        .promo_details_card {
            min-height: unset;
        }

    }

    .promo_box {
        padding: 0 10px;
    }

    .promo_card {
        position: relative;
    }
</style>
<div class="promo_area">
    <div class="container">
        <div class="row">
            @if($homeContent->show_promo1_section==1)
            <div class="col-lg-4 col-md-4 mb-5 promo_box">
                <div class="promo_card">
                    <img src = "{{asset($homeContent->promo_image_1)}}" width="392px" height="451px" style="max-width: 100%; height:auto">
                        <div class="col-lg-12 col-sm-12 promo_details_card">
                            <div class="row p-3">
                                <div class="promo_details text-left">
                                    <h3>{{ @$homeContent->promo_title_1 }}</h3>
                                    <p>{{ @$homeContent->promo_sub_title_1 }}</p>
                                </div>
                            </div>
                        </div>
                </div>   
            </div>
            @endif
            @if($homeContent->show_promo2_section==1)
            <div class="col-lg-4 col-md-4 mb-5 promo_box">
                <div class="promo_card">
                    <img src = "{{asset($homeContent->promo_image_2)}}" width="392px" height="451px" style="max-width: 100%; height:auto">
                    <div class="col-lg-12 col-sm-12 promo_details_card">
                        <div class="row p-3">
                            <div class="promo_details text-left">
                                <h3>{{ @$homeContent->promo_title_2 }}</h3>
                                <p>{{ @$homeContent->promo_sub_title_2 }}</p>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            @endif
            @if($homeContent->show_promo3_section==1)
            <div class="col-lg-4 col-md-4 mb-5 promo_box">
                <div class="promo_card">
                    <img src = "{{asset($homeContent->promo_image_3)}}" width="392px" height="451px" style="max-width: 100%; height:auto">
                        <div class="col-lg-12 col-sm-12 promo_details_card">
                            <div class="row p-3">
                                <div class="promo_details text-left">
                                    <h3>{{ @$homeContent->promo_title_3 }}</h3>
                                    <p>{{ @$homeContent->promo_sub_title_3 }}</p>
                                </div>
                            </div>
                        </div> 
                </div> 
            </div>
            @endif
        </div>
    </div>
</div>
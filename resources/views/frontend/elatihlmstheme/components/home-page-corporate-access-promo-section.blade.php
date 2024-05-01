<!-- Corporate Access Promo Section Start-->
<style>
    .ca-description {
        margin: 20px 50px;
        max-width: 610px;
        height: 300px;
        position: relative;
    }
    .ca-description li {
        font-family: 'Jost';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 10px;
    }
    .ca-description li i{
        color: #F04D24;
        margin-right: 15px ;
        margin-top: 5px;
        font-size: 24px;
    }
    .ca-button{
        position: absolute; 
        bottom: 0; 
        right:0;
    } 
        .theme_btn_white {
            background: #fff;
            border-radius: 5px;
            font-family: Open Sans;
            font-size: 16px;
            color: var(--system_primery_color);
            font-weight: 600;
            padding: 21px 28px;
            border: 1px solid transparent;
            text-transform: capitalize;
            display: inline-block;
            line-height: 1;
            border: 1px solid var(--system_primery_color);
        }

        .theme_btn_white:hover {
            background: var(--system_primery_color);
            color: #fff;
        }

    @media screen and (max-width:1300px) and (min-width:1200px) {
        .ca-description {
            margin: 10px 50px;
        }

        .ca-description li {
            font-size: 18px;
        }
        .ca-description li i{
            font-size: 22px;
        }
    }

    @media screen and (max-width:1200px) {

        .ca-button-mobile {
            /* position: absolute;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;  */
            display: block !important;
        }
        .ca-button {
            display: none;
        }
    }

     @media (max-width: 575.98px) {
        .theme_btn_white {
            padding: 15px 16px;
        }
    }
    @media screen and (max-width:530px) {
        /* .section_spacing {
            margin-bottom: 300px;
        } */
        .ca-button-mobile {
            /* position: absolute;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;  */
            display: block !important;
        }
        .ca-button {
            display: none;
        }
    }

    @media screen and (max-width:500px) {
        .ca-description {
            margin: 20px 10px;
        }
        .section_spacing {
            margin-bottom: 150px;
        }


    }
    @media screen and (max-width:400px) {
        .section_spacing {
            margin-bottom: 100px;
        }

        .ca-button-mobile .theme_btn_white {
            margin: 20px 0px;
        }

        .ca-description li {
            font-size: 18px;
        }
        .ca-description li i{
            font-size: 20px;
        }

    }
</style>
<div>
    <div class="section_spacing5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_40">
                        <h3>
                            {{ @$homeContent->corporate_access_promo_title }}
                        </h3>
                        <p>
                            {{ @$homeContent->corporate_access_promo_sub_title }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-xl-5 text-center">
                           <div class="ca-image">
                             <img class="img-fluid" src="{{ asset('public/frontend/elatihlmstheme/img/promo/shutterstock_1935739078.png') }}" style="max-width: 100%"/>
                           </div>
                        </div>
                        <div class="col-xl-7">
                            <div class="row ca-description">
                                <div class="col-xl-12">
                                    <ul>
                                        <li class="d-flex">
                                            <i class="fas fa-check-circle"></i>
                                            Accelerate your talent development and business transformation with an integrated levy system
                                        </li>
                                        <li class="d-flex"><i class="fas fa-check-circle"></i>Upskill and reskill your employees with a personalized pathway regardless of your company size and budget
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xl-12 text-right pr-3 ca-button">
                                    <a href="{{ route('corporate_access_page') }}" class="theme_btn_white mx-3">Learn More</a>
                                    <a href="{{ route('interestform') }}" class="theme_btn">Get Corporate Access</a>
                                </div>
                                <div class="col-xl-12 ca-button-mobile d-none mb-5" >
                                    <div class="row d-flex justify-content-center">
                                        <a href="{{ route('corporate_access_page') }}" class="theme_btn_white mx-3">Learn More</a>
                                        <a href="{{ route('interestform') }}" class="theme_btn">Get Corporate Access</a>
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
<!-- Corporate Access Promo Section End-->


<style>
    .interested_area {
        background-color: #1D3067;
        padding-top: 80px;
    }

    .interested_title > h3 {
        font-family: Open Sans;
        font-size: 50px;
        font-weight: 700;
        line-height: 70px;
        letter-spacing: 0em;
        color: #FFFFFF;
    }

    .interested_area .px-100 {
        padding-right: 100px;
        padding-left: 100px;
    }

    .interested_area .theme_btn.px-100 {
        font-family: Jost;
        font-size: 22px;
        font-weight: 600;
        line-height: 40px;
        letter-spacing: 0em;
    }

    @media screen and (max-width:990px) {
       .interested_title > h3 {
            font-size: 42px;
        }

        .interested_area .px-100 {
            padding-right: 80px;
            padding-left: 80px;
        }

        .interested_area .theme_btn.px-100 {
            font-size: 20px;
        }
    }
</style>
<div>
    <div class="interested_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="interested_title text-center mb_80">
                        <h3>
                           Interested ?
                        </h3>
                        <a href="{{ route('interestform') }}" class="theme_btn px-100">Get Corporate Access</a>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

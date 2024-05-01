
<style>
    .trusted_by_area {
        background: #F2F2F2;
    }

    .section__title > h2 {
        font-family: Open Sans;
        font-size: 32px;
        font-weight: 800;
        line-height: 58px;
        letter-spacing: 0em;
        color: #202E3B;

    }

   .box-wrapper {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin-left: -5px;
        margin-right: -5px;
    }

    .box {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: calc(16.66% - 10px);
        min-height: 50px;
        min-width: 85px;
        max-width: 194px;
        max-height: 91px;
        overflow: hidden;
        margin: 40px 15px;
    }

    .box .corporate_logo {
        filter: gray; 
        -webkit-filter: grayscale(1); 
        filter: grayscale(1); 
    }

    @media screen and (max-width: 990px) {
        .box {
            max-height: 51px;
        }
    }
</style>

    <?php 
        $corporate_data = !empty($homeContent->corporate_list) ? $homeContent->corporate_list : '';
        $corporate_arr = json_decode($corporate_data);
         $corporates = collect($corporate_arr)->sortBy('order');
    ?>
<div>
    @if(!empty($corporates) && count($corporates)>0) 
    <div class="trusted_by_area section_spacing6">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="section__title text-left mb_25 pl-3">
                        <h2>
                            Trusted By
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="box-wrapper justify-content-center">
                        @foreach($corporates as $corporate)
                        <?php $company = DB::table('companies')->where('id', $corporate->id)->first(); ?>
                            @if(isset($company))
                            <div class="box">
                                <img class="img-fluid corporate_logo" src="{{ file_exists($company->logo) ? asset($company->logo) : '' }}" style="max-width: 100%"/>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    </div>
    @else
        <div class="trusted_by_area d-none">
        </div>
    @endif
</div>

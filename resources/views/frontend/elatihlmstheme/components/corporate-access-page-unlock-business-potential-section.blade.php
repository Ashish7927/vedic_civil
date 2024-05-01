
<style>
   .box-wrapper {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin-left: -5px;
        margin-right: -5px;
    }

    .box-cp {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: calc(16.66% - 30px);
        min-height: 50px;
        min-width: 85px;
        max-width: 194px;
        max-height: 91px;
        overflow: hidden;
        /* background-color:  #ccc; */
        background: #F9F9F9;
        margin: 10px 15px;
    }

    @media screen and (max-width: 990px) {
        .box-cp {
            max-height: 51px;
        }
    }
</style>
    <?php 
        $cp_data = !empty($homeContent->content_provider_list) ? $homeContent->content_provider_list : '';
        $content_providers_arr = json_decode($cp_data);
        $content_providers = collect($content_providers_arr)->sortBy('order');
    ?>
<div>
   @if(!empty($content_providers) && count($content_providers)>0) 
    <div class="section_spacing6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>
                           Unlock your business potential
                        </h3>
                        <p>
                            Explore 30,000+ courses from our world's leading content providers
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="box-wrapper justify-content-center">
                        @foreach($content_providers as $cp)
                        <?php $user = \App\User::find($cp->id); ?>
                            @if(isset($user))
                            <div class="box-cp">
                                <a href="{{ route('cplanding', @$user->id) }}" target="blank">
                                    <img class="img-fluid" src="{{ file_exists($user->image) ? asset($user->image) : '' }}" style="max-width: 100%"/>
                                </a>
                                
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    </div>
    @else
        <div class="d-none">
        </div>
    @endif
</div>

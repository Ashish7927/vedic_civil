<div>
    {{-- <div class="breadcrumb_area bradcam_bg_2"
         style="background-image: url('{{asset(@$banner)}}');background-size: auto;"> --}}
    <div class="breadcrumb_area bradcam_bg_2"
         style="background-image: url('{{asset(@$banner)}}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="breadcam_wrap">
                        <?php $title_renamed = str_replace("-", html_entity_decode("&#x2011;"), $title); ?>
                        <h3>
                            {{@$title_renamed}}
                        </h3>
                        <span>
                            {{@$sub_title}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
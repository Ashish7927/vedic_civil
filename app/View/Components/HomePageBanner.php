<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\Slider;
use Jenssegers\Agent\Agent;

class HomePageBanner extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $sliders = null;
        $agent   = new Agent();
        if ($this->homeContent->show_banner_section == 0) {
            //$sliders = Slider::where('status', 1)->orderBy('order', 'asc')->get();
            $sliders = Slider::where('status', 1)->where('is_corporate', 0)->orderBy('order', 'asc')->get();
        }

        if (isset($sliders)) {
            foreach ($sliders as $slider) {
                if (!$slider->mobile_image) {
                    $slider->mobile_image = $slider->image;
                }
            }
        }



        return view(theme('components.home-page-banner'), compact('sliders', 'agent'));
    }
}

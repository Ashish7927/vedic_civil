<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PriceTag extends Component
{
    public $price, $discount, $discountstartdate, $discountenddate;

    public function __construct($price, $discount = null, $discountstartdate = null, $discountenddate = null)
    {
        $this->price = $price;
        $this->discount = $discount;
        $this->discountstartdate = $discountstartdate;
        $this->discountenddate = $discountenddate;
    }

    public function render()
    {
        return view(theme('components.price-tag'));
    }
}

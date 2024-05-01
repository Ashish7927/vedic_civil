<div>
    @php
        $current_date = date('Y-m-d');
    @endphp

    <span class="prise_tag">
        <span>
            @if (@strtotime($discountstartdate) <= @strtotime($current_date) && @strtotime($discountenddate) >= @strtotime($current_date) && @$discount != null)
                {{ getPriceFormat($discount) }}
            @else
                @if (@$price != 0)
                    {{ getPriceFormat($price) }}
                @else
                    Free
                @endif
            @endif
        </span>
        @if (@strtotime($discountstartdate) <= @strtotime($current_date) && @strtotime($discountenddate) >= @strtotime($current_date) && @$discount != null)
            @if (@$price != 0)
                <span class="prev_prise">
                    {{ getPriceFormat($price) }}
                </span>
            @else
                Free
            @endif
        @endif
    </span>
</div>

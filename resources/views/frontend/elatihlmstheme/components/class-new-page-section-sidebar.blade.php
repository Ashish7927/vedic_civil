<div class="course_category_chose mb_30 mt_10">
    <div class="course_title mb_30 d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13" viewBox="0 0 19.5 13">
            <g id="filter-icon" transform="translate(28)">
                <rect id="Rectangle_1" data-name="Rectangle 1" width="19.5" height="2" rx="1" transform="translate(-28)" fill="var(--system_primery_color)" />
                <rect id="Rectangle_2" data-name="Rectangle 2" width="15.5" height="2" rx="1" transform="translate(-26 5.5)" fill="var(--system_primery_color)" />
                <rect id="Rectangle_3" data-name="Rectangle 3" width="5" height="2" rx="1" transform="translate(-20.75 11)" fill="var(--system_primery_color)" />
            </g>
        </svg>
        <h5 class="font_16 f_w_500 mb-0">{{ __('frontend.Filter Category') }}</h5>
    </div>

    <div class="course_category_inner">
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{ __('frontend.Class Category') }}
            </h4>
            <ul class="Check_sidebar">
                @if (isset($categories))
                    @foreach ($categories as $cat)
                        <li>
                            <label class="primary_checkbox d-flex">
                                <input type="checkbox" value="{{ $cat->id }}" class="category">
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{ $cat->name }}</span>
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{ __('frontend.Level') }}
            </h4>
            <ul class="Check_sidebar">
                @if (isset($levels))
                    @foreach ($levels as $l)
                        <li>
                            <label class="primary_checkbox d-flex">
                                <input name="level" type="checkbox" value="{{ $l->id }}" class="level">
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{ $l->title }}</span>
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{ __('frontend.Language') }}
            </h4>
            <ul class="Check_sidebar">
                @if (isset($languages))
                    @foreach ($languages as $lang)
                        <li>
                            <label class="primary_checkbox d-flex">
                                <input type="checkbox" class="language" value="{{ $lang->code }}">
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{ $lang->name }}</span>
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Duration </h4>
            <select class="primary_input_field duration_range" name="duration_range" id="duration_range">
                <option data-display="Select Duration" value="">Select Duration</option>
                <option value="30-60">30 - 60 minutes</option>
                <option value="60-90">60 - 90 minutes</option>
                <option value="90-120">90 - 120 minutes</option>
                <option value="120-150">120 - 150 minutes</option>
                <option value="150-180">150 - 180 minutes</option>
                <option value="180-210">180 - 210 minutes</option>
                <option value="210-240">210 - 240 minutes</option>
                <option value="240-">240 minutes or more</option>
            </select>

            <input type="hidden" class="start_duration" name="start_duration" id="start_duration" value="" />
            <input type="hidden" class="end_duration" name="end_duration" id="end_duration" value="" />
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Content Provider </h4>
            <select class="select2" name="contentprovider" id="contentprovider" style="width: 80%;">
                <option data-display=" {{ __('common.Select') }} {{ __('Content Provider') }}" value="">
                    {{ __('common.Select') }} {{ __('Content Provider') }}
                </option>
                @foreach ($cpdata as $cp)
                    <option value="{{ $cp->id }}">{{ @$cp->name }} </option>
                @endforeach
            </select>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Rating </h4>
            <ul class="Check_sidebar">
                @for ($i = 1; $i <= 5; $i++)
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" class="rating" value="{{ $i }}">
                            <span class="checkmark mr_15"></span>
                            @for ($k = 0; $k < $i; $k++)
                                <i class="fa fa-star"></i>
                            @endfor
                        </label>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Version </h4>
            <ul class="Check_sidebar">
                <li>
                    <label class="primary_checkbox d-flex">
                        <input type="radio" class="common-radio version" name="version" value="free">
                        <span class="checkmark mr_15"></span>
                        <span class="label_name">Free</span>
                    </label>
                </li>
                <li>
                    <label class="primary_checkbox d-flex">
                        <input type="radio" class="common-radio version" name="version" value="paid">
                        <span class="checkmark mr_15"></span>
                        <span class="label_name">Premium</span>
                    </label>
                </li>
            </ul>
        </div>

        <div class="single_course_categry price_div">
            <h4 class="font_18 f_w_700"> Price </h4>
        </div>
        <div>
            <input type="text" name="start_price" id="start_price" class="primary_input_field start_price" value="" />
            <input type="text" name="end_price" id="end_price" class="primary_input_field end_price" value="" />

            <div class="row">
                <div class="col-md-3">
                    <button class="btn price_range apply_button" id="apply_button">Apply</button>
                </div>
                <div class="col-md-3">
                    <button class="btn price_range apply_button" id="reset_button">Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>

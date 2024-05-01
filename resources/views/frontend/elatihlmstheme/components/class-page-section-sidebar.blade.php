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

    @php
        if (isset($_GET['categories'])) {
            $selected_categories = explode(',', $_GET['categories']);
        }

        if (isset($_GET['levels'])) {
            $selected_levels = explode(',', $_GET['levels']);
        }

        if (isset($_GET['languages'])) {
            $selected_languages = explode(',', $_GET['languages']);
        }

        if (isset($_GET['start_duration'])) {
            $selected_start_duration = $_GET['start_duration'];
        }

        if (isset($_GET['end_duration'])) {
            $selected_end_duration = $_GET['end_duration'];
        }

        if (isset($_GET['content_provider'])) {
            $selected_content_provider = $_GET['content_provider'];
        }

        if (isset($_GET['ratings'])) {
            $selected_ratings = explode(',', $_GET['ratings']);
        }

        if (isset($_GET['version'])) {
            $selected_version = $_GET['version'];
        }

        if (isset($_GET['start_price'])) {
            $selected_start_price = $_GET['start_price'];
        }

        if (isset($_GET['end_price'])) {
            $selected_end_price = $_GET['end_price'];
        }
    @endphp

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
                                <input type="checkbox" value="{{ $cat->id }}" class="category" {{ (isset($selected_categories) && in_array($cat->id, $selected_categories)) ? 'checked' : '' }}>
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
                    @foreach ($levels as $level)
                        <li>
                            <label class="primary_checkbox d-flex">
                                <input name="level" type="checkbox" value="{{ $level->id }}" class="level" {{ (isset($selected_levels) && in_array($level->id, $selected_levels)) ? 'checked' : '' }}>
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{ $level->title }}</span>
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
                                <input type="checkbox" class="language" value="{{ $lang->code }}" {{ (isset($selected_languages) && in_array($lang->code, $selected_languages)) ? 'checked' : '' }}>
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
                <option value="30-60" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 30 && $selected_end_duration == 60)) ? 'selected' : '' }}>30 - 60 minutes</option>
                <option value="60-90" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 60 && $selected_end_duration == 90)) ? 'selected' : '' }}>60 - 90 minutes</option>
                <option value="90-120" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 90 && $selected_end_duration == 120)) ? 'selected' : '' }}>90 - 120 minutes</option>
                <option value="120-150" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 120 && $selected_end_duration == 150)) ? 'selected' : '' }}>120 - 150 minutes</option>
                <option value="150-180" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 150 && $selected_end_duration == 180)) ? 'selected' : '' }}>150 - 180 minutes</option>
                <option value="180-210" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 180 && $selected_end_duration == 210)) ? 'selected' : '' }}>180 - 210 minutes</option>
                <option value="210-240" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 210 && $selected_end_duration == 240)) ? 'selected' : '' }}>210 - 240 minutes</option>
                <option value="240-" {{ ((isset($selected_start_duration) && isset($selected_end_duration)) && ($selected_start_duration == 240 && $selected_end_duration == '')) ? 'selected' : '' }}>240 minutes or more</option>
            </select>

            <input type="hidden" class="start_duration" name="start_duration" id="start_duration" value="{{ isset($selected_start_duration) ? $selected_start_duration : '' }}" />
            <input type="hidden" class="end_duration" name="end_duration" id="end_duration" value="{{ isset($selected_end_duration) ? $selected_end_duration : '' }}" />
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Content Provider </h4>
            <select class="select2" name="contentprovider" id="contentprovider" style="width: 80%;">
                <option data-display=" {{ __('common.Select') }} {{ __('Content Provider') }}" value="">
                    {{ __('common.Select') }} {{ __('Content Provider') }}
                </option>
                @foreach ($cpdata as $cp)
                    <option value="{{ $cp->id }}" {{ (isset($selected_content_provider) && $selected_content_provider == $cp->id) ? 'selected' : '' }}>{{ @$cp->name }} </option>
                @endforeach
            </select>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700"> Rating </h4>
            <ul class="Check_sidebar">
                @for ($i = 1; $i <= 5; $i++)
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" class="rating" value="{{ $i }}" {{ (isset($selected_ratings) && in_array($i, $selected_ratings)) ? 'checked' : '' }}>
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
                        <input type="radio" class="common-radio version" name="version" value="free" {{ (isset($selected_version) && $selected_version == 'free') ? 'checked' : '' }}>
                        <span class="checkmark mr_15"></span>
                        <span class="label_name">Free</span>
                    </label>
                </li>
                <li>
                    <label class="primary_checkbox d-flex">
                        <input type="radio" class="common-radio version" name="version" value="paid" {{ (isset($selected_version) && $selected_version == 'paid') ? 'checked' : '' }}>
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
            <input type="text" name="start_price" id="start_price" class="primary_input_field start_price" value="{{ isset($selected_start_price) ? $selected_start_price : '' }}" />
            <input type="text" name="end_price" id="end_price" class="primary_input_field end_price" value="{{ isset($selected_end_price) ? $selected_end_price : '' }}" />

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

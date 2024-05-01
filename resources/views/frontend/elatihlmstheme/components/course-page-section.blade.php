<div class="courses_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <x-class-page-section-sidebar :categories="$categories" :languages="$languages" />
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="row">
                    <div class="col-12">
                        <div class="box_header d-flex flex-wrap align-items-center justify-content-between">
                            <h5 class="font_16 f_w_500 mb_30" id="total_course_count"></h5>
                            <form action="{{route('search')}}">
                                <div class="input-group theme_search_field mb_30">
                                    <div class="input-group-prepend">
                                        <button class="btn" type="submit" id="button-addon1"><i class="ti-search"></i>
                                        </button>
                                    </div>

                                    <input type="text" class="form-control search" name="query" placeholder="Search for courses, skills and videos" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search for courses'" >
                                </div>
                            </form>

                            <div class="box_header_right mb_30">
                                <div class="short_select d-flex align-items-center">
                                    <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Order By')}}:</h5>
                                    <select class="small_select" id="order">
                                        <option data-display="None" {{ (isset($_GET['order']) && $_GET['order'] == 'None') ? 'selected' : '' }}>{{__('frontend.None')}}</option>
                                        <option value="popularity" {{ (isset($_GET['order']) && $_GET['order'] == 'popularity') ? 'selected' : '' }}> {{__('frontend.Popularity')}} </option>
                                        <option value="date" {{ (isset($_GET['order']) && $_GET['order'] == 'date') ? 'selected' : '' }}>{{__('frontend.Date')}}</option>
                                        <option value="alphabet" {{ (isset($_GET['order']) && $_GET['order'] == 'alphabet') ? 'selected' : '' }}>{{__('frontend.Alphabet')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div id="div_content">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

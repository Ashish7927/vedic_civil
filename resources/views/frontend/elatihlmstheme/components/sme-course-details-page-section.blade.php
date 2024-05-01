<style type="text/css">
    .price_main_div .prise_tag{
        /*font-size: 14px;*/
        font-weight: 700;
        color: var(--system_primery_color);
    }
    .price_main_div .prise_tag .prev_prise{
        text-decoration: line-through;
        color: var(--system_secendory_color);
        font-size: 22px;
        font-weight: 600;
        padding-bottom: 5px;
    }
    .details_div_1{
        margin-right: 15px;
    }
    @media screen and (max-width:767px){
        .section_1{
            width: 100%!important;
        }
        .section_2{
            width: 100%!important;
        }
        .section_3{
            width: 100%!important;
        }
        .course__details .course__details_title .single__details .details_content span{
            font-size: 12px!important;
        }
        .single__details h4{
            font-size: 15px!important;
        }
        .thumb_div_background_img{
            margin-top: -50px!important;
        }
    }
    @media screen and (min-width:768px){
        .section_1{
            width: 50%!important;
        }
        .section_2{
            width: 25%!important;
        }
        .section_3{
            width: 25%!important;
        }
        .details_div_1{
            margin-right: 25px!important;
        }
        .div_details_content{
            display: flex!important;
        }
    }

    .single_overview_ul  {
        margin: 5px;
        padding: 15px;
    }

    .single_overview_ul li {
        list-style: unset;
    }

    <?php if(\Illuminate\Support\Facades\Session::get('CourseType') == 'Strategic'): ?>

    .course__details .video_screen {
        background-image: url("images/StrategicSkills.jpg")!important;
    }

    <?php elseif (\Illuminate\Support\Facades\Session::get('CourseType') == 'Functional'): ?>

    .course__details .video_screen {
        background-image: url("images/FunctionalSkills.jpg")!important;
    }

    <?php endif; ?>
</style>
<div>
    <input type="hidden" value="{{asset('/')}}" id="baseUrl">
    <!-- course_details::start  -->
    <div class="course__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-10">
                    <div class="video_screen mb_60"></div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <div class="course_tabs text-center">
                                <ul class="w-100 nav lms_tabmenu justify-content-between  mb_55" id="myTab"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Overview-tab" data-toggle="tab" href="#Overview"
                                           role="tab" aria-controls="Overview"
                                           aria-selected="true">{{__('frontend.Overview')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="single_overview">
                                Description:
                                <ul class="single_overview_ul">
                                    <li>The SME Development programme aims to support the aspirations of the
                                        Government in the developing and increasing SME productivity levels by
                                        enhancing the skills and capabilities of the exsting SME
                                        workforce.Through this programme, the SME management and employees shall
                                        be given a designated laerning pathway
                                        consisting of 16 to 36 hours of on-demand online training modules
                                        focusing on strategic and functional skills:
                                        <ul class="single_overview_ul">
                                            <li>Strategic - For the middle and upper management to develop their
                                                management skills to drive the businesses to be more
                                                competitive.
                                            </li>
                                            <li>Functional - For the employees to develop their skills and
                                                productivity.
                                            </li>
                                        </ul>
                                    </li>
                                    <?php if(\Illuminate\Support\Facades\Session::get('CourseType') == 'Functional'): ?>
                                        <li>In Functional Skills, participants will acquire essential and relevant
                                            skills to increase their level of competency and productivity to remain
                                            competitive in the global markets.
                                            Courses available in the Functional Skills module includes Networking
                                            and Building Relationships, Mobile Working. Digial Margeting just to
                                            name a few.
                                        </li>
                                    <?php elseif (\Illuminate\Support\Facades\Session::get('CourseType') == 'Strategic'): ?>
                                        <li>In Strategic Skills, participants will acquire essential management skills ranging from Team Management,
                                            Organizational Behaviour, Digital Transformation For Digital Leaders, just to name a few. These courses
                                            are designed to provide the skills needed for SME leaders to compete with global competitors.
                                        </li>
                                    <?php endif; ?>
                                    <li>The premium training modules provided by globally recognized partners
                                        such as Harvard, Skillsoft, Cegos Training, Talent Quest and many more.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="sidebar__widget mb_30">
                                @if (Auth::check())
                                        <a href="{{route('getSmeCourse')}}"
                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Continue Watch')}}</a>
                                @endif
                                <p class="font_14 f_w_500 text-center mb_30"></p>
                                <h4 class="f_w_700 mb_10">{{__('frontend.This course includes')}}:</h4>
                                    <ul class="course_includes">
                                        <?php if(\Illuminate\Support\Facades\Session::get('CourseType') == 'Functional'): ?>
                                        <li><i class="ti-alarm-clock"></i>
                                            <p class="nowrap"> {{ __('frontend.Duration') }}: 36 hours
                                            </p></li>
                                        <?php elseif (\Illuminate\Support\Facades\Session::get('CourseType') == 'Strategic'): ?>
                                        <li><i class="ti-alarm-clock"></i>
                                            <p class="nowrap"> {{ __('frontend.Duration') }}: 16 hours
                                            </p></li>
                                        <?php endif; ?>
                                        <li><i class="ti-thumb-up"></i>
                                            <p>{{__('frontend.Skill Level')}}: {{__('frontend.All Level')}}
                                            </p></li>
                                        <li><i class="ti-user"></i>
                                            <p>{{__('frontend.Certificate of Completion')}}</p></li>
                                        <li><i class="ti-blackboard"></i>
                                            <p>Due Date: 31st August 2023</p></li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include(theme('partials._delete_model'))


</div>

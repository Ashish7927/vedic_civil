<style>
    .header_area .main_menu ul li ul.leftcontrol_submenu {
        left: auto !important;
        right: 100% !important;
    }
	.bluecolor{background: #212f64;}
    .yellow_btn{margin: 5px}

    /* .contact_nhcce{
         margin-top: 15px !important;
    }
    .nhcce_btn{
        color: white !important;
        white-space: normal !important;
        max-width: 150px !important;
        text-align: center !important;
        font-size: 14px !important;
        line-height: 1 !important;
        padding: 10px 9px !important;
       
    }
    .nhcce_btn:hover{
        color: var(--system_primery_color) !important;
    }

    @media (max-width:991px){
        .nhcce_btn{
            max-width: 100% !important;
        }
    } */
</style>
<!-- HEADER::START -->

<header>
    <div id="sticky-header" class="header_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="header__wrapper">
                        <!-- header__left__start  -->
                        <div class="header__left d-flex align-items-center">
                            <div class="logo_img">
                                <a href="{{url('/')}}">
                                    <img class="p-2" style="width: 190px" src="{{getCourseImage(Settings('logo') )}}"
                                         alt="{{ Settings('site_name')  }}">
                                </a>
                            </div>
                            <div class="logo_img translator-switch">

                                @if(Settings('frontend_language_translation') == 1)

                                    <select name="code" id="language_code" class="nice_Select "
                                            onchange="location = this.value;">
                                        @php
                                            if (auth()->check()){
                                                $currentLang =auth()->user()->language_code;
                                            }else{
                                                $currentLang =app()->getLocale();
                                            }
                                        @endphp
                                        @foreach (getLanguageList() as $key => $language)
                                            <option value="{{route('changeLanguage',$language->code)}}"
                                                    @if ($currentLang == $language->code) selected @endif>{{$currentLang== $language->code?ucfirst($language->code): $language->name }}</option>

                                        @endforeach
                                    </select>

                                @endif
                            </div>

                            <div class="category_search d-flex category_box_iner">
                                @if(Settings('category_show'))
                                    <div class="input-group-prepend2">
                                        <a href="#" class="categories_menu">
                                            <i class="fas fa-th"></i>
                                            {{__('courses.Category')}}
                                        </a>
                                        <div class="menu_dropdown">
                                            <ul>
                                                @if(isset($categories))
                                                    @foreach($categories as $category)

                                                        @include(theme('partials._category'),['category'=>$category,'level'=>1])

                                                    @endforeach
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                @endif
                                @if(@$homeContent->show_menu_search_box==1)
                                    <form action="{{route('search')}}">
                                        <div class="input-group theme_search_field">
                                            <div class="input-group-prepend">
                                                <button class="btn" type="button" id="button-addon1"><i
                                                        class="ti-search"></i>
                                                </button>
                                            </div>

                                            <input type="text" class="form-control" name="query"
                                                   placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <!-- header__left__start  -->

                        <!-- main_menu_start  -->
                        <div class="main_menu text-right d-none d-lg-block category_box_iner">
                            <nav>
                                <div class="menu_dropdown">
                                    <ul>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <li class="mega_menu_dropdown active_menu_item">
                                                    <a href="{{route('courses')}}?category={{$category->id}}">{{$category->name}}</a>
                                                    @if(isset($category->activeSubcategories))
                                                        @if(count($category->activeSubcategories)!=0)
                                                            <ul>
                                                                <li>
                                                                    <div class="menu_dropdown_iner d-flex">
                                                                        <div class="single_menu_dropdown">
                                                                            <h4>{{__('courses.Sub Category')}}</h4>
                                                                            <ul>
                                                                                @if(isset($category->activeSubcategories))
                                                                                    @foreach( $category->activeSubcategories as $subcategory)
                                                                                        <li>
                                                                                            <a href="{{route('courses')}}?category={{$category->id}}">{{$subcategory->name}}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>


                                <ul id="mobile-menu">


                                    @if(isset($menus))
                                        @foreach($menus->where('parent_id',null) as $menu)
                                            {{-- @if ($loop->first)
                                                <li>
                                                    @guest
                                                        <div class="contact_btn contact_nhcce">
                                                            <a href="{{url('login')}}" class="nhcce_btn theme_btn small_btn2">NHCCE</a>
                                                        </div>
                                                    @else
                                                        <div class="contact_btn contact_nhcce">
                                                            <a href="https://www.elatihnhcce2023.com/" target="_blank" class="theme_btn small_btn2 nhcce_btn">NHCCE</a>
                                                        </div>
                                                    @endguest     
                                                </li>               
                                            @endif --}}

                                            @php
                                                if($menu->title=='Forum' && !isModuleActive('Forum')){
                                                    continue;
                                                }

                                                if ($menu->title == 'Partners') {
                                                    continue;
                                                }
                                            @endphp
                                            <li class="@if($menu->show==1) right_control_submenu @endif">
                                                <a @if($menu->is_newtab==1) target="_blank"
                                                   @endif href="{{getMenuLink($menu)}}">{{$menu->title}}</a>
                                                @if(isset($menu->childs))
                                                    @if(count($menu->childs)!=0)
                                                        @if(isset($menu->childs))
                                                            <ul class="submenu">
                                                                @foreach($menu->childs as $sub)
                                                                    <li class=""><a
                                                                            @if($sub->is_newtab==1) target="_blank"
                                                                            @endif href="{{getMenuLink($sub)}}">{{$sub->title}}</a>
                                                                        @if(isset($sub->childs))
                                                                            @if(count($sub->childs)!=0)
                                                                                <ul class="@if($sub->show==1)  leftcontrol_submenu @endif">
                                                                                    @foreach( $sub->childs as $s)
                                                                                        <li class="@if($sub->show==1)  @endif">
                                                                                            <a @if($s->is_newtab==1) target="_blank"
                                                                                               @endif  href="{{getMenuLink($s)}}">{{$s->title}}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endif
                                            </li>

                                        @endforeach

                                    @else

                                    @endif
                                    @if(isSmeUser() && smeCourseSetup())
                                        @if(!smeCourseCondition())
                                            <li class="right_control_submenu">
                                                <a href="#" style="pointer-events: none; color: grey">{{__('courses.Sme Courses')}}</a>
                                            </li>
                                        @else
                                            <li class="right_control_submenu">
                                                <a href="{{route('smeCoursesPage')}}">{{__('courses.Sme Courses')}}</a>
                                            </li>
                                        @endif
                                    @endif
                                    <li><a href="#"></a></li>


                                </ul>
                            </nav>
                        </div>
                        <!-- main_menu_start  -->

                        <!-- header__right_start  -->
                        @auth()
                            <div class="header__right login_user">
                                <div class="profile_info collaps_part">
                                    <div class="profile_img collaps_icon     d-flex align-items-center">
                                        <div class="studentProfileThumb"
                                             style="background-image: url('{{getProfileImage(Auth::user()->image)}}')"></div>

                                        <span class="">{{Auth::user()->name}}
                    <br style="display: block">
					{{-- <small>
                      @if(Auth::user()->role_id==3)
                          @if(Auth::user()->balance==0)
                              {{Settings('currency_symbol') ??'৳'}} 0
                          @else
                              {{getPriceFormat(Auth::user()->balance)}}
                          @endif
                      @endif
					</small> --}}

                </span>

                                    </div>
                                    <div class="profile_info_iner collaps_part_content">
                                        @if(Auth::user()->role_id==3)
                                            <a href="{{route('studentDashboard')}}">{{__('dashboard.Dashboard')}}</a>
                                            <a href="{{route('myProfile')}}">{{__('frontendmanage.My Profile')}}</a>
                                            <a href="{{route('myAccount')}}">{{__('frontend.Account Settings')}}</a>
                                        @else
                                            <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                                            <a href="{{route('changePassword')}}">{{__('frontendmanage.My Profile')}}</a>
                                        @endif
                                        <a href="{{route('logout')}}">{{__('frontend.Log Out')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endauth
                        @guest()
                            <div class="header__right">
                                <div class="contact_wrap d-flex align-items-center">
                                    <div class="contact_btn">
                                        <a href="{{url('login')}}"
                                           class="theme_btn small_btn2">{{__('common.Login')}} </a>
                                    </div>
                                    &nbsp;
                                    <div class="contact_btn">
                                        <a href="{{route('register')}}"
                                           class="theme_btn small_btn2">{{__('common.Register')}} </a>
                                    </div>

                                </div>
                            </div>
                    @endguest
                    <!-- header__right_end  -->
                    </div>
                </div>
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
</header>


@if(Settings('show_cart')==1)

    <a href="#" class="float notification_wrapper">
        <div class="notify_icon cart_store" style="padding-top: 7px">
            <img style="max-width: 30px;" src="{{asset('/public/frontend/elatihlmstheme/')}}/img/svg/cart_white.svg"
                 alt="">
        </div>
        <span class="notify_count" id="cart_count">{{@cartItem()}}</span>
    </a>

@endif
<!--/ HEADER::END -->

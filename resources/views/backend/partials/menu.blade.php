@php
    $totalMessage = totalUnreadMessages();
@endphp
<div class="container-fluid no-gutters" id="main-nav-for-chat">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                @php
                    $path = asset(Settings('logo'));
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    try {
                        $data = file_get_contents($path);
                    } catch (\Exception $e) {
                        $data = '';
                    }
                @endphp
                <input type="hidden" id="logo_img" value="{{ base64_encode($data) }}">
                <input type="hidden" id="logo_title" value="{{ Settings('company_name') }}">
                <div class="small_logo_crm d-lg-none">
                    <a href="{{ url('/') }}"> <img src="{{ asset(Settings('logo')) }}" alt=""></a>
                </div>
                <div id="sidebarCollapse" class="sidebar_icon  d-lg-none">
                    <i class="ti-menu"></i>
                </div>

                <div class="collaspe_icon open_miniSide">
                    <i class="ti-menu"></i>
                </div>
                <div class="serach_field-area ml-40">
                    <div class="search_inner">
                        
                    </div>
                    <div id="livesearch" style="display: none;"></div>
                </div>

                <div class="header_middle d-none d-md-block">
                    <ul class="nav navbar-nav mr-auto nav-buttons flex-sm-row">

                        <li class="nav-item">
                            <a target="_blank" class="primary-btn white mr-10"
                               href="#">{{__('common.Website')}}</a>
                        </li>


                    </ul>
                </div>

                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="profile_info">
                        <div class="profileThumb"
                            style="background-image: url('{{ getProfileImage(Auth::user()->image) }}')"></div>

                        <div class="profile_info_iner">
                            <div class="use_info d-flex align-items-center">
                                <div class="thumb"
                                    style="background-image: url('{{ getProfileImage(Auth::user()->image) }}')">

                                </div>
                                <div class="user_text">
                                    <p>{{ __('common.Welcome') }}</p>
                                    <span>{{ @Auth::user()->name }} </span>
                                </div>
                            </div>

                            <div class="profile_info_details">
                                <a href="{{ route('updatePassword') }}">
                                    <i class="ti-settings"></i> <span>{{ __('common.View Profile') }} </span>
                                </a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <i class="ti-shift-left"></i> <span>{{ __('dashboard.Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

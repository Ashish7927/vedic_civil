@php
    $totalMessage = totalUnreadMessages();
@endphp
<div class="container-fluid no-gutters" id="main-nav-for-chat">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                @php
                    $LanguageList = getLanguageList();
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
                        <form action="#">
                            <div class="search_field">
                                <input type="text" class="form-control primary-input input-left-icon"
                                    placeholder="Search" id="search" onkeyup="showResult(this.value)">
                            </div>
                            <button type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                    <div id="livesearch" style="display: none;"></div>
                </div>

                <div class="header_right d-flex justify-content-between align-items-center">
                    <ul class="header_notification_warp d-flex align-items-center">
                        {{-- Start Notification --}}
                        <li class="scroll_notification_list" style="display:none;">
                            <a class="pulse theme_color bell_notification_clicker show_notifications" href="#">
                                <!-- bell   -->
                                <i class="fa fa-bell"></i>

                                <!--/ bell   -->
                                <span class="notification_count">{{ Auth::user()->unreadNotifications->count() }}</span>
                                <span class="pulse-ring notification_count_pulse"></span>
                            </a>
                            <!-- Menu_NOtification_Wrap  -->
                            <div class="Menu_NOtification_Wrap notifications_wrap">
                                <div class="notification_Header">
                                    <h4>{{ __('common.Notifications') }}</h4>
                                </div>
                                <div class="Notification_body">
                                    <!-- single_notify  -->
                                    @forelse (Auth::user()->unreadNotifications as $notification)
                                        <div class="single_notify d-flex align-items-center"
                                            id="menu_notification_show_{{ $notification->id }}">
                                            <div class="notify_thumb">
                                                <i class="fa fa-bell"></i>
                                            </div>
                                            <a href="#" class="unread_notification" title="Mark As Read"
                                                data-notification_id="{{ $notification->id }}">
                                                <div class="notify_content">
                                                    <h5>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->data['title'], 30, $end = '...')) !!}</h5>
                                                    <p>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->data['body'], 70, $end = '...')) !!}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <span class="text-center">{{ __('common.No Unread Notification') }}</span>
                                    @endforelse

                                </div>
                                <div class="nofity_footer">
                                    <div class="submit_button text-center pt_20">
                                        <a href="{{ route('MyNotification') }}"
                                            class="primary-btn radius_30px text_white  fix-gr-bg">{{ __('common.See More') }}</a>
                                        <a href="{{ route('NotificationMakeAllRead') }}" id="mark_all_as_read"
                                            class="primary-btn radius_30px text_white  fix-gr-bg">{{ __('common.Mark As Read') }}</a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Menu_NOtification_Wrap  -->
                        </li>
                        {{-- End Notification --}}
                        @if (permissionCheck('communication.PrivateMessage'))
                            <li class="scroll_notification_list">
                                <a class="pulse theme_color" href="{{ route('communication.PrivateMessage') }}">
                                    <!-- bell   -->
                                    <i class="far fa-comment"></i>
                                    <span class="notification_count">{{ $totalMessage }} </span>
                                    @if ($totalMessage > 0)
                                        <span class="pulse-ring notification_count_pulse"></span>
                                    @endif
                                </a>
                            </li>
                        @endif

                    </ul>
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

<style>
    @media screen and (max-width: 767px) {
        .footer_widget {
            text-align: center;
        }
    }
    .registernow{
        color:white!important;
    }
    .registernow:hover{
        color:red!important;
    }
</style>
<div class="row">
    @if(isset($sectionWidgets))
        @if(count($sectionWidgets['one'])!=0)
            <div class="col-lg-6 col-md-6">
                <div class="footer_widget">

                    <div class="footer_title">
                        <h3>{{ Settings('footer_section_one_title')  }}</h3>
                    </div>
                    <ul class="footer_links">
                        @foreach($sectionWidgets['one'] as $page)
                            @if(isset($page->frontpage->id))
                                @php
                                    $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                @endphp
                                <li><a href="{{ $route }}">{{$page->name}} </a></li>
                            @else
                                <li><a href="">{{$page->name}} </a></li>
                            @endif
                        @endforeach
                    </ul>

                </div>
            </div>
        @endif
            @if(count($sectionWidgets['four'])!=0)
                <div class="col-lg-6 col-md-6">
                    <div class="footer_widget">
                        <div class="footer_title">
                            <h3>{{ Settings('footer_section_four_title')  }}</h3>
                        </div>
                        <ul class="footer_links">
                            @foreach($sectionWidgets['four'] as $page)
                                @if(isset($page->frontpage->id))
                                    @php
                                        $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                    @endphp
                                    <li class="footer-cp-style"><a href="{{ $route }}">{{$page->name}} </a></li>
                                @else
                                    <li class="footer-cp-style"><a href="">{{$page->name}} </a></li>
                                @endif

                            @endforeach
                            <li><a href="/partner-login">Partner Log In</a></li>
                        </ul>
                    </div>

                </div>

            @endif
        @if(count($sectionWidgets['two'])!=0)
            <div class="col-lg-6 col-md-6">
                <div class="footer_widget">
                    <div class="footer_title">
                        <h3>{{ Settings('footer_section_two_title')  }}</h3>
                    </div>
                    <ul class="footer_links">

                        @foreach($sectionWidgets['two'] as $key=> $page)
                            @if(isset($page->frontpage->id))
                                @php
                                    $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                @endphp
                                <li><a href="{{ $route }}">{{$page->name}} </a></li>
                            @else
                                <li><a href="">{{$page->name}} </a></li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="footer_widget">
                    <div class="footer_title">
                        <h3>Events</h3>
                    </div>
                    <ul class="footer_links">
                    <li><a target="_blank" href="https://hrdcorp.gov.my/list-of-events/#elatih">CP Briefing Sessions</a></li>
                    
                    </ul>
                </div>
            </div>
        @endif
        @if(count($sectionWidgets['three'])!=0)
            <div class="col-lg-6 col-md-6">
                <div class="footer_widget">
                    <div class="footer_title">
                        <h3>{{ Settings('footer_section_three_title')  }}</h3>
                    </div>
                    <ul class="footer_links">
                        @foreach($sectionWidgets['three'] as $page)
                            @if(isset($page->frontpage->id))
                                @php
                                    $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                @endphp
                                <li><a href="{{ $route }}">{{$page->name}} </a></li>
                            @else
                                <li><a href="">{{$page->name}} </a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif
    @endif
</div>

<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <i class="fas fa-vr-cardboard"></i>
        </div>
        <div class="nav_title">
            <span>{{__('bbb.BigBlueButton')}}</span>
            @if(env('APP_SYNC'))
                <span class="demo_addons">Addon</span>
            @endif
        </div>
    </a>
    <ul>

        @if (permissionCheck('bbb.settings'))
            <li>
                <a href="{{ route('bbb.meetings') }}">  {{__('bbb.BigBlueButton Class')}}</a>
                {{-- <a href="{{ route('bbb.settings') }}">  {{__('bbb.BigBlueButton Setting')}}</a> --}}
            </li>
        @endif
    </ul>
</li>

<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-users"></span>
        </div>
        <div class="nav_title">
            <span>{{__('Content Providers')}}</span>
        </div>
    </a>
    <ul>
        @if (permissionCheck('admin.cp.list'))
            <li>
                <a href="{{ route('allCp') }}">{{ __('courses.All') }} {{__('Content Providers')}}</a>
            </li>
        @endif
    </ul>
</li>

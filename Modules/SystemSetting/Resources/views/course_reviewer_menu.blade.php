<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-users"></span>
        </div>
        <div class="nav_title">
            <span>Course Reviewer</span>
        </div>
    </a>
    <ul>
        @if (permissionCheck('admin.course_reviewer.list'))
            <li>
                <a href="{{ route('allReviewer') }}">{{ __('courses.All') }} Course Reviewer</a>
            </li>
        @endif
    </ul>
</li>

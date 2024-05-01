<!-- sidebar part here -->
<nav id="sidebar" class="sidebar ">

    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{ url('/') }}">
            <img src="{{ getCourseImage(Settings('logo')) }}" alt="">
        </a>
        <a class="mini_logo" href="{{ url('/') }}">
            <img src="{{ getCourseImage(Settings('logo')) }}" alt="">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>
    <ul id="sidebar_menu">
        @if (permissionCheck('dashboard'))
            <li>
                <a class="active" href="{{ url('/dashboard') }}" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-th"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('common.Dashboard') }}</span>
                    </div>
                </a>
            </li>
        @endif

        <li>
            <a href="javascript:;" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="fas fa-user"></span>
                </div>
                <div class="nav_title">
                    <span>User Management</span>
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ url('role-permission/rolemanage') }}">Role</a>
                </li>
                <li>
                    <a href="{{ url('role-permission/adminuser') }}">User</a>
                </li>
            </ul>
        </li>


        @if (permissionCheck('students'))
            @include('studentsetting::menu')
        @endif


        @if (permissionCheck('courses'))
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-cubes"></span>
                    </div>
                    <div class="nav_title">
                        <span> {{ __('courses.Courses') }}</span>
                    </div>
                </a>
                <ul>
                    @if (permissionCheck('course.category'))
                        <li><a href="{{ route('course.category') }}">{{ __('courses.Categories') }}</a></li>
                    @endif

                    @if (permissionCheck('course.store'))
                        <li>
                            <a href="{{ route('addNewCourse') }}">{{ __('common.Add') }} {{ __('courses.Course') }}
                            </a>
                        </li>
                    @endif

                    @if (permissionCheck('getAllCourse'))
                        <li>
                            <a href="{{ route('getAllCourse') }}">{{ __('courses.All') }}
                                {{ __('courses.Courses') }}</a>
                        </li>
                    @endif
                    @if (permissionCheck('getActiveCourse'))
                        <li>
                            <a href="{{ route('getActiveCourse') }}">{{ __('common.Published') }}
                                {{ __('courses.Courses') }}</a>
                        </li>
                    @endif
                    @if (permissionCheck('getPendingCourse'))
                        <li>
                            <a href="{{ route('getPendingCourse') }}">Draft
                                {{ __('courses.Courses') }}</a>
                        </li>
                    @endif
                    @if (!isHRDCorp() && !isPartner() && !check_whether_cp_or_not() && permissionCheck('getActiveCourse'))
                        <li>
                            <a href="{{ route('getAllFeaturedCourse') }}">Featured {{ __('courses.Courses') }}</a>
                        </li>
                    @endif
                    @if (isModuleActive('Assignment'))
                        <li>
                            <a href="{{ route('courseAssignmentList') }}">{{ __('assignment.Assignment') }}</a>
                        </li>
                    @endif

                    @if (isModuleActive('CourseOffer') && permissionCheck('CourseOffer'))
                        <li>
                            <a href="{{ route('courseOffer') }}">{{ __('frontendmanage.Course Offer') }}</a>
                        </li>
                    @endif
                    @if (Settings('frontend_active_theme') == 'compact')
                        <li>
                            <a href="{{ route('frontend.showCourseSettings') }}">
                                {{ __('frontendmanage.Course Setting') }}</a>
                        </li>
                    @endif

                    @if (permissionCheck('course.courseStatistics'))
                        <li>
                            <a href="{{ route('course.courseStatistics') }}">
                                {{ __('courses.Course Statistics') }}</a>
                        </li>
                    @endif

                    @if (permissionCheck('getCourseBulk'))
                        <li>
                            <a href="{{ route('course.courseBulkAction') }}"> {{ __('courses.Course Bulk') }}</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (permissionCheck('quiz'))
            @include('quiz::menu')
        @endif

        @if (permissionCheck('reports'))
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-calculator"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('setting.Reports') }}</span>
                    </div>
                </a>
                <ul>
                    @if (permissionCheck('admin.cp.monthly.statement.reports'))
                        <li>
                            <a
                                href="{{ route('admin.cp.monthly.statement.reports') }}">Statement Reports</a>
                        </li>
                    @endif


                    @if (permissionCheck('admin.auditTrailLearnerProfile'))
                        <li>
                            <a href="{{ route('admin.auditTrailLearnerProfile') }}">{{ __('common.Learner Profile') }}
                                {{ __('common.Audit Trail') }}</a>
                        </li>
                    @endif


                </ul>
            </li>
        @endif

        @if (permissionCheck('certificate.index'))
            @include('certificate::menu')
        @endif

        @if (permissionCheck('frontend_CMS'))
            @include('frontendmanage::menu')
        @endif

        @if (permissionCheck('settings'))
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-cogs"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('setting.System Setting') }}</span>
                    </div>
                </a>

                <ul>


                    @if (permissionCheck('setting.general_settings'))
                        <li>
                            <a href="{{ route('setting.general_settings') }}">{{ __('setting.General Settings') }}</a>
                        </li>
                    @endif
                    @if (permissionCheck('setting.email_setup'))
                        <li>
                            <a href="{{ route('setting.email_setup') }}">{{ __('setting.Email Setup') }}</a>
                        </li>
                    @endif

                    @if (permissionCheck('setting.error_log'))
                        <li>
                            <a href="{{ route('setting.error_log') }}">{{ __('setting.Error Log') }}</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>

</nav>

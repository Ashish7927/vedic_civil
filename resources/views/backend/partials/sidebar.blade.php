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


        @if (permissionCheck('students'))
            @include('studentsetting::menu')
        @endif


        {{-- @if (permissionCheck('content_provider'))
            @include('systemsetting::cp_menu')
        @endif --}}

        {{-- @if (permissionCheck('partner'))
        <li>
            <a href="#" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="fas fa-users"></span>
                </div>
                <div class="nav_title">
                    <span>Partner</span>
                </div>
            </a>
            <ul>
                @if (permissionCheck('admin.partner.list'))
                    <li>
                        <a href="{{ route('all_partner') }}">{{ __('courses.All') }} Partners</a>
                    </li>

                    <li>
                        <a href="{{ route('not_verified_partner') }}">Not Verified Partners</a>
                    </li>

                    <li>
                        <a href="{{ route('allow_using_course_api_partners') }}">Partners Using Courses Api</a>
                    </li>
                @endif
            </ul>
        </li>
        @endif --}}

        {{-- @if (isAdmin())
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-users"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('common.Trainers') }}</span>
                    </div>
                </a>

                <ul>
                    <li>
                        <a href="{{ route('trainers.create') }}"> {{ __('courses.Add') }} {{ __('common.Trainer') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('trainers.index') }}"> {{ __('courses.All') }} {{ __('common.Trainers') }} </a>
                    </li>
                </ul>
            </li>
        @endif --}}

        {{-- @if (permissionCheck('course_reviewer'))
            @include('systemsetting::course_reviewer_menu')
        @endif --}}


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

                    @if (isModuleActive('Org'))
                        <li><a href="{{ route('org.material') }}">{{ __('org.Material Source') }}</a></li>
                    @endif

                    @if (permissionCheck('course-level.index'))
                        <li><a href="{{ route('course-level.index') }}">{{ __('courses.Course Level') }}</a></li>
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
                            <a href="{{ route('getPendingCourse') }}">In-{{ __('common.Review') }}
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
                    @if (permissionCheck('courseApiKey') &&
                            (isPartner() ? (Auth::user()->is_allow_course_api_key == 1 ? true : false) : isAdmin()))
                        <li>
                            <a href="{{ route('course.courseApiKey') }}"> {{ __('courses.Course Api Key') }}</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        {{-- @if (permissionCheck('package'))
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-cubes"></span>
                    </div>
                    <div class="nav_title">
                        <span> {{ __('courses.Packages') }}</span>
                    </div>
                </a>
                <ul>
                    @if (permissionCheck('package.store'))
                        <li><a href="{{ route('addPackage') }}">{{ __('courses.Add') }} {{ __('courses.Package') }}</a></li>
                    @endif
                    @if (permissionCheck('admin.package.list'))
                        <li><a href="{{ route('getAllPackages') }}">{{ __('courses.All Packages') }}</a></li>
                    @endif
                     @if (permissionCheck('getAllCourseHighlights'))
                        <li><a href="{{ route('getAllCourseHighlights') }}">{{ __('courses.Course Highlights') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif --}}
        {{-- @if (permissionCheck('customize_packages'))
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-cubes"></span>
                    </div>
                    <div class="nav_title">
                        <span> {{ __('custom Packages') }}</span>
                    </div>
                </a>
                <ul>
                        @if (permissionCheck('package.request'))
                        <li><a href="{{ route('packageRequest') }}">{{ __('common.Package Request') }} {{ _('Lists') }}</a></li>
                        @endif
                        @if (check_whether_cp_or_not() || isPartner())
                        @if (permissionCheck('customize.packages.store'))
                        <li><a href="{{ route('addCustomPackage') }}">{{ __('courses.Add') }} {{ __('custom Package') }}</a></li>
                        @endif
                        @endif
                        @if (permissionCheck('customize.packages.list'))
                        <li><a href="{{ route('getAllCustomizePackages') }}">{{ __('custom Packages Lists') }}</a></li>
                        @endif
                </ul>
            </li>
        @endif --}}



        @if (permissionCheck('coupons'))
            @include('coupons::menu')
        @endif


        @if (permissionCheck('quiz'))
            @include('quiz::menu')
        @endif

        @if (permissionCheck('payments'))
            @include('payment::menu')
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
                                href="{{ route('admin.cp.monthly.statement.reports') }}">{{ __('Public Monthly Statement Reports') }}</a>
                        </li>
                    @endif
                    @if (permissionCheck('admin.reveune_list_cp'))
                        <li>
                            <a href="{{ route('admin.reveune_list_cp') }}">{{ __('Content Provider') }}
                                {{ __('payment.Revenue') }}</a>
                        </li>
                    @endif
                    @if (permissionCheck('admin.cp.payout'))
                        <li>
                            <a href="{{ route('admin.cp.payout') }}">{{ __('Content Provider Payment') }}</a>
                        </li>
                    @endif


                    @if (permissionCheck('admin.auditTrailLearnerProfile'))
                        <li>
                            <a href="{{ route('admin.auditTrailLearnerProfile') }}">{{ __('common.Learner Profile') }}
                                {{ __('common.Audit Trail') }}</a>
                        </li>
                    @endif

                    @if (permissionCheck('admin.interest.form'))
                        <li>
                            <a href="{{ route('admin.interest.form') }}">Interest Form</a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        @if (permissionCheck('certificate.index'))
            @include('certificate::menu')
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
                    @if (permissionCheck('setting.setCommission'))
                        <li>
                            <a href="{{ route('setting.setCommission') }}">{{ __('setting.Commission') }}</a>
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

                    <li>
                        <a href="{{ route('setting.tax_setting') }}">{{ __('tax.Tax') }} {{ __('tax.Settings') }}</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>

</nav>

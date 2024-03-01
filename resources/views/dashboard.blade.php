@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('backend/css/daterangepicker.css')}}">
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include("backend.partials.alertMessage")

    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-title">
                    <h3 class="mb-0">@lang('common.Welcome') @lang('common.to') e-LATiH for {{@Auth::user()->role->name}}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @if (permissionCheck('dashboard.number_of_subject'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>{{__('payment.Total')}} {{__('dashboard.Courses')}}</h3>
                                  <p class="mb-0">Total Published and In-review courses</p>
                                </div>
                                <h1 class="gradient-color2" id="totalCourses"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_published_courses'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>Published {{__('dashboard.Courses')}}</h3>
                                  <p class="mb-0">Number of Published Courses</p>
                                </div>
                                <h1 class="gradient-color2" id="published_course"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_inreview_courses'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>In-review {{__('dashboard.Courses')}}</h3>
                                  <p class="mb-0">Number of In-review Courses</p>
                                </div>
                                <h1 class="gradient-color2" id="inreview_course"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_student'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{__('student.Students')}}</h3>
                                    <p class="mb-0">{{__('payment.Total')}} {{__('student.Students')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalStudent"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.total_amount_from_enrolled'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>{{__('payment.Income')}} {{__('payment.Amount')}}</h3>
                                    <p class="mb-0">{{__('payment.Total')}} {{__('payment.Income')}} {{__('payment.Amount')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalSell"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_enrolled'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{__('dashboard.Enrolment')}}</h3>
                                    <p class="mb-0">{{__('dashboard.Number of enrolled learners')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalEnroll"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_instructor'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{__('quiz.Instructor')}}</h3>
                                    <p class="mb-0">{{__('quiz.Number of Instructor')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalInstructor"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.total_enrolled_this_month'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>{{__('dashboard.Revenue this month')}}</h3>
                                  <p class="mb-0">{{__('payment.Total Revenue')}} {{__('dashboard.This Month')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalThisMonth"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.total_revenue'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{__('courses.Total Revenue')}}</h3>
                                    <p class="mb-0">{{__('courses.Total Revenue')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalRevenue"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @if( check_whether_cp_or_not() )
        </div>
            @if (permissionCheck('dashboard.daily_wise_enroll'))
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box chart_box mt_30">
                        <div class="white_box_tittle list_header">
                            @if( check_whether_cp_or_not() )
                                <h4>{{__('dashboard.Daily enrolment for')}} <span class="enroll_month_name">{{\Carbon\Carbon::now()->format('F')}}</span></h4>
                            @else
                                <h4>{{__('dashboard.Daily Wise Enroll Status for')}} <span class="enroll_month_name">{{\Carbon\Carbon::now()->format('F')}}</span></h4>
                            @endif
                            <div style="float: right;">
                                <select class="enroll_month_dropdown mb-15 theme" name="month">
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div id="div_enroll_overview">
                                <canvas id="enroll_overview" width="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
        @endif
            <div class="container-fluid">
                <div class="row justify-content-center">
                    @if (permissionCheck('dashboard.monthly_income'))
                        <div class="col-lg-12">
                            <div class="white_box chart_box mt_30">
                                <h4>{{__('dashboard.Monthly Revenue')}}</h4>
                                <div class="">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="myChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (permissionCheck('dashboard.payment_statistic'))
                        <div class="col-lg-6">
                            <div class="white_box chart_box mt_30">
                                <h4>{{__('dashboard.Payment Statistics for')}} {{\Carbon\Carbon::now()->format('F')}}</h4>
                                <div class="">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <canvas id="payment_statistics" width="400" height="400"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                @if (permissionCheck('dashboard.overview_status_of_courses'))
                    <div class="white_box chart_box mt_30">
                        <h4>{{__('dashboard.Status Overview of Topics')}}</h4>
                        <div class="">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                        </div>
                        <canvas id="course_overview" width="400" height="400"></canvas>
                    </div>
                @endif
                @if (permissionCheck('dashboard.overview_of_courses'))
                    <div class="white_box chart_box mt_30">
                        <h4>{{__('dashboard.Overview of Topics')}}</h4>
                        <div class="">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                        </div>
                        <canvas id="course_overview2" width="400" height="400"></canvas>
                    </div>
                @endif
            </div>
        </div>
        @if (permissionCheck('dashboard.daily_wise_enroll') && !check_whether_cp_or_not() )
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box chart_box mt_30">
                        <div class="white_box_tittle list_header">
                            @if( check_whether_cp_or_not() )
                                <h4>{{__('dashboard.Daily enrolment for')}} <span class="enroll_month_name">{{\Carbon\Carbon::now()->format('F')}}</span></h4>
                            @else
                                <h4>{{__('dashboard.Daily Wise Enroll Status for')}} <span class="enroll_month_name">{{\Carbon\Carbon::now()->format('F')}}</span></h4>
                            @endif
                            <div style="float: right;">
                                <select class="enroll_month_dropdown mb-15 theme" name="month">
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div id="div_enroll_overview">
                                <canvas id="enroll_overview" width="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--  24-2-2022 : New  --}}
        @if (permissionCheck('dashboard.daily_wise_registered_user'))
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box chart_box mt_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('Daily Wise Registered User For')}} <span class="reg_month_name">{{\Carbon\Carbon::now()->format('F')}}</span></h4>
                            <div style="float: right;">
                                <select class="reg_month_dropdown mb-15 theme" name="month">
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div id="div_reg_overview">
                                <canvas id="reg_overview" width="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- 24-2-2022 --}}
    </div>

    <div class="row justify-content-center">
        @if (permissionCheck('userLoginChartByDays'))
            <div class="col-lg-12">
                <div class="white_box chart_box mt_30">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('dashboard.User Login Chart')}} ({{__('dashboard.By Date')}})</h4>
                    </div>
                    <div class="row  justify-content-center">
                        <div class="col-md-3">
                            <input type="radio" checked
                                   class="common-radio userLoginChartByDays "
                                   id="userLoginChartByDays7"
                                   name="userLoginChartByDays"
                                   value="7">
                            <label for="userLoginChartByDays7">
                                {{__('dashboard.Last 7 Days')}}
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio userLoginChartByDays "
                                   id="userLoginChartByDays14"
                                   name="userLoginChartByDays"
                                   value="14">
                            <label for="userLoginChartByDays14">
                                {{__('dashboard.Last 14 Days')}}
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio userLoginChartByDays"
                                   id="userLoginChartByDays30"
                                   name="userLoginChartByDays"
                                   value="30">
                            <label for="userLoginChartByDays30">
                                {{__('dashboard.Last 30 Days')}}
                            </label>
                        </div>

                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio "
                                   id="userLoginChartByDaysCustom"
                                   name="userLoginChartByDays"
                                   value="custom">
                            <label for="userLoginChartByDaysCustom">
                                {{__('dashboard.Others')}}
                            </label>

                            <input type="text" class="form-control userLoginChartDateRange"
                                   name="userLoginChartByDaysDateRange" id="userLoginDayChartDateRange"
                                   value="{{date('m/d/Y')}} - {{date('m/d/Y')}}"/>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="userLoginChartByDays" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        @endif
        @if (permissionCheck('userLoginChartByTime'))
            <div class="col-lg-12">
                <div class="white_box chart_box mt_30">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('dashboard.User Login Chart')}} ({{__('dashboard.By Time')}})</h4>
                    </div>
                    <div class="row  justify-content-center">
                        <div class="col-md-3">
                            <input type="radio" checked
                                   class="common-radio userLoginChartByTime "
                                   id="userLoginChartByTime7"
                                   name="userLoginChartByTime"
                                   value="7">
                            <label for="userLoginChartByTime7">
                                {{__('dashboard.Last 7 Days')}}
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio userLoginChartByTime "
                                   id="userLoginChartByTime14"
                                   name="userLoginChartByTime"
                                   value="14">
                            <label for="userLoginChartByTime14">
                                {{__('dashboard.Last 14 Days')}}
                            </label>
                        </div>

                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio userLoginChartByTime"
                                   id="userLoginChartByTime30"
                                   name="userLoginChartByTime"
                                   value="30">
                            <label for="userLoginChartByTime30">
                                {{__('dashboard.Last 30 Days')}}
                            </label>
                        </div>

                        <div class="col-md-3">
                            <input type="radio"
                                   class="common-radio "
                                   id="userLoginChartByTimeCustom"
                                   name="userLoginChartByTime"
                                   value="custom">
                            <label for="userLoginChartByTimeCustom">
                                {{__('dashboard.Others')}}
                            </label>

                            <input type="text" class="form-control userLoginChartDateRange"
                                   name="userLoginTimeChartDateRange" id="userLoginTimeChartDateRange"
                                   value="{{date('m/d/Y')}} - {{date('m/d/Y')}}"/>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="userLoginChartByTime" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="{{asset('backend/vendors/chartlist/Chart.min.js')}}"></script>
    <script src="{{asset('backend/js/daterangepicker.min.js')}}"></script>

    <script>
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        var month_now               = '{{ \Carbon\Carbon::now()->format('F') }}';
        var select_current_month    = 0;
        const final_months          = [];

        $('.enroll_month_dropdown').text('');
        $('.reg_month_dropdown').text('');

        monthNames.forEach(function(item, index) {
            final_months.push(item);
            if (month_now == item) {
                select_current_month = item + 1;
            }
        });

        $('.enroll_month_dropdown').val(select_current_month);
        $('.reg_month_dropdown').val(select_current_month);

        for (let index = 0; index < final_months.length; index++) {
            var item = final_months[index];
            if(month_now == item){
                $(".enroll_month_dropdown").append('<option value="'+ (index+1).toString() +'" selected>' +item.toString() +'</option>');
                $(".reg_month_dropdown").append('<option value="'+ (index+1).toString() +'" selected>' +item.toString() +'</option>');
                break;
            }
            if(month_now != item){
                $(".enroll_month_dropdown").append('<option value="'+ (index+1).toString() +'">' +item.toString() +'</option>');
                $(".reg_month_dropdown").append('<option value="'+ (index+1).toString() +'">' +item.toString() +'</option>');
            }
        }

        $('.enroll_month_dropdown').addClass("primary_select");
        $('.reg_month_dropdown').addClass("primary_select");

        $('.enroll_month_dropdown').niceSelect();
        $('.reg_month_dropdown').niceSelect();

        var month = '{{ \Carbon\Carbon::now()->format('F') }}';

        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: "{!! route('getDashboardData') !!}",
                success: function (data) {
                    $('#totalStudent').html(data.student);
                    $('#totalInstructor').html(data.instructor);
                    $('#totalCourses').html(data.allCourse);
                    $('#published_course').html(data.published_course);
                    $('#inreview_course').html(data.inreview_course);
                    $('#totalEnroll').html(data.totalEnroll);
                    $('#totalSell').html(getPriceFormet(data.totalSell));
                    $('#totalRevenue').html(getPriceFormet(data.adminRev));
                    $('#totalToday').html(getPriceFormet(data.today));
                    $('#totalThisMonth').html(getPriceFormet(data.thisMonthEnroll));
                }
            });

            $.ajax({
                type: "GET",
                url: "{!! route('get_monthly_revenue_data') !!}",
                success: function (response) {
                    var month_name      = [];
                    var monthly_earn    = [];

                    $.each(response.courseEarningMonthName, function (index, value) {
                        month_name.push(value);
                    });

                    $.each(response.courseEarningMonthly, function (index, value) {
                        monthly_earn.push(value);
                    });

                    monthly_revenue_chart(month_name, monthly_earn);
                }
            });

            $.ajax({
                type: "GET",
                url: "{!! route('get_payment_stats_data') !!}",
                success: function (response) {
                    payment_stat_chart(response.payment_stats.month, response.payment_stats.paid, response.payment_stats.unpaid);
                }
            });

            $.ajax({
                type: "GET",
                url: "{!! route('get_status_overview_data') !!}",
                success: function (response) {
                    status_overview_chart(response.course_overview.active, response.course_overview.pending);
                    topic_overview_chart(response.course_overview.courses, response.course_overview.quizzes, response.course_overview.classes);
                }
            });

            $.ajax({
                type: "GET",
                url: "{!! route('get_reg_overview_chart_data') !!}",
                success: function (response) {
                    var reg_day         = [];
                    var reg_count       = [];

                    $.each(response.reg_day, function (index, value) {
                        reg_day.push(value);
                    });

                    $.each(response.reg_count, function (index, value) {
                        reg_count.push(value);
                    });

                    reg_chart_load(reg_day, reg_count, month);
                }
            });

            $.ajax({
                type: "GET",
                url: "{!! route('get_enroll_chart_data') !!}",
                success: function (response) {
                    var enroll_day      = [];
                    var enroll_count    = [];

                    $.each(response.enroll_day, function (index, value) {
                        enroll_day.push(value);
                    });

                    $.each(response.enroll_count, function (index, value) {
                        enroll_count.push(value);
                    });

                    enroll_chart_load(enroll_day, enroll_count, month);
                }
            });
        });

        function getPriceFormet(price) {
            let currency_symbol = $('.currency_symbol').val();
            let currency_show = $('.currency_show').val();
            let res;

            if (currency_show == 1) {
                res = currency_symbol + price;
            } else if (currency_show == 2) {
                res = currency_symbol + ' ' + price;
            } else if (currency_show == 3) {
                res = price + currency_symbol;
            } else if (currency_show == 4) {
                res = price + ' ' + currency_symbol;
            } else {
                res = price;
            }
            return res;
        }

        function enroll_chart_load(enroll_day, enroll_count, month) {
            @if (permissionCheck('dashboard.daily_wise_enroll'))
                var ctx = document.getElementById('enroll_overview').getContext('2d');
                var chartlabel = "";
                var xlabel = "";
                var ylabel = "";

                @if(check_whether_cp_or_not())
                    chartlabel = '{{__('dashboard.Daily enrolment for')}} '+month;
                    xlabel = '{{__('dashboard.Daily enrolment X label')}} ';
                    ylabel = '{{__('dashboard.Daily enrolment Y label')}} ';
                @else
                    chartlabel = '{{__('dashboard.Daily Wise Enroll Status for')}} '+month;
                    xlabel = '';
                    ylabel = '';
                @endif

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: enroll_day,
                        datasets: [{
                            label: chartlabel,
                            data: enroll_count,
                            backgroundColor: 'rgba(124, 50, 255, 0.5)',
                            borderColor: 'rgba(124, 50, 255, 0.5)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: xlabel
                            }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: ylabel
                                }
                            }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });
            @endif
        }

        function monthly_revenue_chart(month_name, monthly_earn) {
            @if (permissionCheck('dashboard.monthly_income'))
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: month_name,
                        datasets: [{
                            label: '{{__('dashboard.Monthly Revenue')}}',
                            data: monthly_earn,
                            backgroundColor: 'rgba(124, 50, 255, 0.5)',
                            borderColor: 'rgba(124, 50, 255, 0.5)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });
            @endif
        }

        function payment_stat_chart(month, paid, unpaid) {
            @if (permissionCheck('dashboard.payment_statistic'))
                var ctx = document.getElementById('payment_statistics').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['{{__('dashboard.Completed')}}', '{{__('dashboard.Pending')}}'],
                        datasets: [{
                            label: '{{ __('dashboard.Payment Statistics for') }} '+month,
                            data: [paid, unpaid],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            @endif
        }

        function status_overview_chart(active, pending) {
            @if (permissionCheck('dashboard.overview_status_of_courses'))
                var ctx = document.getElementById('course_overview').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['{{__('dashboard.Active')}}', '{{__('dashboard.Pending')}}'],
                        datasets: [{
                            label: '{{__('Status Overview of Topics')}}',
                            data: [active, pending],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 99, 132, 0.2)'

                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            @endif
        }

        function topic_overview_chart(courses, quizzes, classes) {
            @if (permissionCheck('dashboard.overview_of_courses'))
                var ctx = document.getElementById('course_overview2').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['{{__('dashboard.Courses')}}', '{{__('dashboard.Quizzes')}}', '{{__('dashboard.Classes')}}'],
                        datasets: [{
                            label: '{{__('Overview of Topics')}}',
                            data: [courses, quizzes, classes],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            @endif
        }

        function reg_chart_load(reg_day, reg_count, month) {
            var ctx_2 = document.getElementById('reg_overview').getContext('2d');

            var myChart = new Chart(ctx_2, {
                type: 'bar',
                data: {
                    labels: reg_day,
                    datasets: [{
                        label: '{{__('Daily Wise Registered User For')}} '+month,
                        data: reg_count,
                        backgroundColor: 'rgba(124, 50, 255, 0.5)',
                        borderColor: 'rgba(124, 50, 255, 0.5)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        $('.userLoginChartDateRange').daterangepicker();
        @if (permissionCheck('userLoginChartByDays'))
            var userLoginChartByDaysElement = $('input[name="userLoginChartByDays"]');
            var userLoginChartByDaysDateRangeElement = $('input[name="userLoginChartByDaysDateRange"]');


            userLoginChartByDaysDateRangeElement.change(function () {
                getLoginUserDataFromDays('custom', this.value);
            });
            userLoginChartByDaysElement.change(function () {
                if (this.value === 'custom') {
                    $('#userLoginDayChartDateRange').show();
                } else {
                    $('#userLoginDayChartDateRange').hide();
                    getLoginUserDataFromDays('days', this.value);
                }
            });

            var userLoginChartByDaysCanvas = $('#userLoginChartByDays').get(0).getContext('2d');

            function getLoginUserDataFromDays(type, days) {
                $.ajax({
                    url: '{{ url('userLoginChartByDays') }}',
                    type: 'GET',
                    data: { type: type, days: days },
                    success: function (result) {
                        var userLoginChartByDaysData = {
                            labels: result.date,
                            datasets: [
                                {
                                    label: '{{__('dashboard.User Login Attempt')}}',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 0.5)',
                                    pointRadius: true,
                                    pointColor: '#3b8bba',
                                    borderWidth: 3,
                                    pointDot: true,
                                    pointDotRadius: 10,
                                    pointHoverRadius: 15,
                                    pointStrokeColor: 'rgba(54, 162, 235, 1)',
                                    pointHighlightFill: '#fff',
                                    pointHighlightStroke: 'rgba(54, 162, 235, 1)',
                                    data: result.data
                                },
                            ]
                        }

                        var userLoginChartByDaysOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false,
                                    }
                                }]
                            }
                        }

                        new Chart(userLoginChartByDaysCanvas, {
                            type: 'line',
                            data: userLoginChartByDaysData,
                            options: userLoginChartByDaysOptions
                        })
                    }, error: function (result, statut, error) { // Handle errors
                        console.log(error);
                    }
                });
            }
            getLoginUserDataFromDays('days', 7);
        @endif

        @if (permissionCheck('userLoginChartByTime'))
            var userLoginChartByTimeElement = $('input[name="userLoginChartByTime"]');
            var userLoginTimeChartDateRange = $('input[name="userLoginTimeChartDateRange"]');

            userLoginTimeChartDateRange.change(function () {
                getLoginUserDataFromTime('custom', this.value);
            });
            userLoginChartByTimeElement.change(function () {
                if (this.value === 'custom') {
                    $('#userLoginTimeChartDateRange').show();
                } else {
                    $('#userLoginTimeChartDateRange').hide();
                    getLoginUserDataFromTime('days', this.value);
                }
            });

            var userLoginChartByTimeCanvas = $('#userLoginChartByTime').get(0).getContext('2d');

            function getLoginUserDataFromTime(type, days) {
                $.ajax({
                    url: '{{url('userLoginChartByTime')}}',
                    type: 'GET',
                    data: {type: type, days: days},
                    success: function (result) {
                        var userLoginChartByTimeData = {
                            labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                            datasets: [
                                {
                                    label: '{{__('dashboard.User Login Attempt')}}',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 0.5)',
                                    pointRadius: true,
                                    pointColor: '#3b8bba',
                                    borderWidth: 3,
                                    pointDot: true,
                                    pointDotRadius: 10,
                                    pointHoverRadius: 15,
                                    pointStrokeColor: 'rgba(54, 162, 235, 1)',
                                    pointHighlightFill: '#fff',
                                    pointHighlightStroke: 'rgba(54, 162, 235, 1)',
                                    data: result
                                },
                            ]
                        }

                        var userLoginChartByTimeOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false,
                                    }
                                }]
                            }
                        }

                        new Chart(userLoginChartByTimeCanvas, {
                            type: 'line',
                            data: userLoginChartByTimeData,
                            options: userLoginChartByTimeOptions
                        })
                    }, error: function (result, statut, error) { // Handle errors
                        console.log(error);
                    }
                });
            }

            getLoginUserDataFromTime('days', 7);
        @endif

        $(document).on('change', '.enroll_month_dropdown', function () {
            var value = $(this).val();

            $.ajax({
                url: "{{ route('enroll_month_change') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "month": value,
                    "month_name": final_months[value-1]
                },
                success: function (response) {
                    if(response.success == 1){
                        toastr.success('Updated successfully!');

                        $('#enroll_overview').remove();
                        $('#div_enroll_overview').append('<canvas id="enroll_overview"></canvas>');

                        var month = final_months[value-1];
                        $('.enroll_month_name').text('');
                        $('.enroll_month_name').text(month);
                        var enroll_day = [];
                        $.each(response.enroll_day,function(key,value){
                            enroll_day.push(value.toString());
                        });

                        var enroll_count = [];
                        $.each(response.enroll_count,function(key,value){
                            enroll_count.push(value.toString());
                        });

                        @if (permissionCheck('dashboard.daily_wise_enroll'))
                            enroll_chart_load(enroll_day, enroll_count, month);
                        @endif
                    } else {
                        toastr.error('Something wrong !');
                    }
                },
                error: function (response) {
                    toastr.error('Something wrong !')
                }
            });
        })

        $(document).on('change', '.reg_month_dropdown', function () {
            var value = $(this).val();

            $.ajax({
                url: "{{ route('reg_month_change') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "month": value,
                    "month_name": final_months[value-1]
                },
                success: function (response) {
                    if(response.success == 1) {
                        toastr.success('Updated successfully!');

                        $('#reg_overview').remove();
                        $('#div_reg_overview').append('<canvas id="reg_overview"></canvas>');

                        var month = final_months[value-1];
                        $('.reg_month_name').text('');
                        $('.reg_month_name').text(month);
                        var reg_day = [];
                        $.each(response.reg_day,function(key,value){
                            reg_day.push(value.toString());
                        });

                        var reg_count = [];
                        $.each(response.reg_count,function(key,value){
                            reg_count.push(value.toString());
                        });

                        reg_chart_load(reg_day, reg_count, month);
                    } else {
                        toastr.error('Something wrong !');
                    }
                },
                error: function (response) {
                    toastr.error('Something wrong !')
                }
            });
        })
    </script>
@endpush

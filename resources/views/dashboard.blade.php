@extends('backend.master')
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
                    <h3 class="mb-0">@lang('common.Welcome') @lang('common.to') Vedic-Civil for {{@Auth::user()->role->name}}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            @if (permissionCheck('dashboard.number_of_published_courses'))
                <div class="col-lg-4">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                  <h3>Total {{__('dashboard.Courses')}}</h3>
                                  <p class="mb-0">Number of Courses</p>
                                </div>
                                <h1 class="gradient-color2" id="published_course"> ...
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
                                    <h3>Total Students</h3>
                                    <p class="mb-0">Number of Registered Students</p>
                                </div>
                                <h1 class="gradient-color2" id="totalStudent"> ...
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
                                    <p class="mb-0">Number of Enrolled Students</p>
                                </div>
                                <h1 class="gradient-color2" id="totalEnroll"> ...
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
                                    <h3>Today's Revenue</h3>
                                    <p class="mb-0">Total Today's Revenue</p>
                                </div>
                                <h1 class="gradient-color2" id="totalThisToday"> ...
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
                                    <h3>Revenue this week</h3>
                                    <p class="mb-0">Total Revenue This Week</p>
                                </div>
                                <h1 class="gradient-color2" id="totalThisWeek"> ...
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
                                  <h3>Revenue this month</h3>
                                  <p class="mb-0">Total Revenue This Month</p>
                                </div>
                                <h1 class="gradient-color2" id="totalThisMonth"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
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

            $.ajax({
                type: 'GET',
                url: "{!! route('getDashboardData') !!}",
                success: function (data) {
                    $('#published_course').html(data.published_course);
                    $('#totalStudent').html(data.student);
                    $('#totalEnroll').html(data.totalEnroll);
                    $('#totalThisMonth').html(getPriceFormet(data.thisMonthEnroll));
                    $('#totalThisWeek').html(getPriceFormet(data.thisMonthEnroll));
                    $('#totalThisToday').html(getPriceFormet(data.thisMonthEnroll));
                }
            });  
        });     
    </script>
@endpush

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ Settings('site_title') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ getCourseImage(Settings('favicon')) }}">

    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme') }}/css/app.css?{{ $version }}">
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme') }}/css/frontend_style.css?{{ $version }}">
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme') }}/css/gijgo.min.css?{{ $version }}">
    <link rel="stylesheet" href="{{ asset('backend/css/themify-icons.css') }}?{{ $version }}" />
    <script src="{{ asset('js/common.js') }}?{{ $version }}"></script>
    <script src="{{ asset('frontend/elatihlmstheme/js/app.js') }}?{{ $version }}"></script>
    <script src="{{ asset('frontend/elatihlmstheme') }}/js/gijgo.min.js?{{ $version }}"></script>
</head>

<body>
    @yield('content')

    {!! \Brian2694\Toastr\Facades\Toastr::message() !!}
    {!! NoCaptcha::renderJs() !!}

    <script>
        if ($('.small_select').length > 0) {
            $('.small_select').niceSelect();
        }

        if ($('.datepicker').length > 0) {
            $('.datepicker').datepicker();
        }
    </script>

</body>


</html>

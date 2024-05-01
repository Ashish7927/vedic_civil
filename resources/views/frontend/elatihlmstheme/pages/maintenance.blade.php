<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ env('APP_NAME') }} | {{ $maintain->maintenance_title }}</title>

    <x-frontend-dynamic-style-color/>

    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme') }}/css/app.css?{{ $version }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme') }}/css/frontend_style.css?{{ $version }}">
    <link rel="stylesheet" href="{{ asset('public/css/preloader.css') }}?{{ $version }}"/>
</head>

<body>

@include('preloader')


<div class="error_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="error_wrapper_info text-center">
                    <div class="thumb">
                        <img src="{{asset($maintain->maintenance_banner)}}" alt="">
                    </div>
                    <h3>{{$maintain->maintenance_title}}</h3>
                    <p>{!! $maintain->maintenance_sub_title !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('public/js/common.js')}}"></script>

<script src="{{asset('public/frontend/elatihlmstheme/js/app.js')}}"></script>


<script>
    setTimeout(function () {
        $('.preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    }, 0);
</script>

</body>

</html>

<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : '' }}" class="{{ isRtl() ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ getCourseImage(Settings('favicon')) }}" type="image/png" />
    <title>
        {{ Settings('site_title') ? Settings('site_title') : 'e-Latih LMS' }}
    </title>
    <meta name="_token" content="{!! csrf_token() !!}" />

    <style>
        .sidebar #sidebar_menu li ul li a {
            white-space: normal !important;
            display: block;
        }
    </style>

    @include('backend.partials.style')
    <script src="{{ asset('js/common.js') }}"></script>


    <script>
        window.Laravel = {
            "baseUrl": '{{ url('/') }}' + '/',
            "current_path_without_domain": '{{ request()->path() }}',
            "csrfToken": '{{ csrf_token() }}',
        }
    </script>

    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! json_encode(cache('translations'), JSON_INVALID_UTF8_IGNORE) !!}
    </script>


    <script>
        window.jsLang = function(key, replace) {
            let translation = true

            let json_file = $.parseJSON(window._translations[window._locale]['json'])
            translation = json_file[key] ?
                json_file[key] :
                key
            $.each(replace, (value, key) => {
                translation = translation.replace(':' + key, value)
            })
            return translation
        }
    </script>


    <script>
        const RTL = "{{ isRtl() }}";
        const LANG = "{{ app()->getLocale() }}";
    </script>

    @livewireStyles


</head>

<body class="admin">
    @include('preloader')
    <input type="hidden" name="demoMode" id="demoMode" value="{{ appMode() }}">
    <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
    <input type="hidden" name="table_name" id="table_name" value="@yield('table')">
    <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
    <input type="hidden" name="currency_symbol" class="currency_symbol" value="{{ Settings('currency_symbol') }}">
    <input type="hidden" name="currency_show" class="currency_show" value="{{ Settings('currency_show') }}">
    <div class="main-wrapper" style="min-height: 600px">
        <!-- Sidebar  -->

        @include('backend.partials.sidebar')

        <!-- Page Content  -->
        <div id="main-content">

            @include('backend.partials.menu')

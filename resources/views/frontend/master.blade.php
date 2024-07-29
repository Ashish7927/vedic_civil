@include('frontend.header')
<input type="hidden" name="base_url" class="base_url" value="{{url('/')}}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
<body class="sticky-header">
@yield('mainContent')
@include('frontend.footer')

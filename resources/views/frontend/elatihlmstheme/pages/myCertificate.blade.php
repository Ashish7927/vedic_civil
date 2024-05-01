@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('certificate.My Certificates')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/my_course.js')}}?v=1"></script>
@endsection

@section('mainContent')
    <x-my-certificate-page-section :request="$request"/>
@endsection
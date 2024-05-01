@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('certificate.My History')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-my-history-page-section/>
@endsection
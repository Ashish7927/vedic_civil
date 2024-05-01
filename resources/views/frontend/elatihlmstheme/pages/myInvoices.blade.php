@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | Invoice @endsection
@section('css')
    <link href="{{asset('public/frontend/elatihlmstheme/css/my_invoice.css')}}" rel="stylesheet"/>
@endsection
@section('mainContent')
    <x-my-invoice-page-section :id="$id"/>

@endsection
@section('js')
    <script src="{{ asset('public/frontend/elatihlmstheme') }}/js/html2pdf.bundle.js"></script>
    <script src="{{ asset('public/frontend/elatihlmstheme/js/my_invoice.js') }}"></script>
@endsection

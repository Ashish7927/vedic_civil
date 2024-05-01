@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('common.Checkout')}} @endsection
@section('css')
    <link href="{{asset('public/frontend/elatihlmstheme/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/elatihlmstheme/css/checkout.css')}}" rel="stylesheet"/>
@endsection
@section('mainContent')

    <x-subscription-checkout-page-section :request="$request" :plan="$s_plan" :price="$price"/>


@endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/checkout.js')}}"></script>
@endsection

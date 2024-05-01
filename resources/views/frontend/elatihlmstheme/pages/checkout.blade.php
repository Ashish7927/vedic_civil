@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('common.Checkout')}} @endsection
@section('css')
    <link href="{{asset('public/frontend/elatihlmstheme/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/elatihlmstheme/css/checkout.css')}}" rel="stylesheet"/>
    <style type="text/css">
        .primary_checkbox_for_checkout .checkmark{
            top: -66px;
        }
        @media (min-width: 991px) and (max-width: 1112px){
            .primary_checkbox_for_checkout .checkmark{
                top: -80px!important;
            }
        }
        @media (min-width: 652px) and (max-width: 992px){
            .primary_checkbox_for_checkout .checkmark{
                top: -43px!important;
            }
        }
        @media (min-width: 521px) and (max-width: 651px){
            .primary_checkbox_for_checkout .checkmark{
                top: -54px!important;
            }
        }
        @media (min-width: 380px) and (max-width: 441px){
            .primary_checkbox_for_checkout .checkmark{
                top: -80px!important;
            }
        }
        @media (min-width: 300px) and (max-width: 380px){
            .primary_checkbox_for_checkout .checkmark{
                top: -93px!important;
            }
        }
    </style>
@endsection
@section('mainContent')

    <x-checkout-page-section :request="$request"/>


@endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/checkout.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/city.js')}}"></script>
@endsection

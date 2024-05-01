@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | @lang('frontendmanage.Payment Method') @endsection
@section('css')
@endsection
@section('mainContent')

    <x-payment-page-section/>

@endsection
@section('js')
@endsection

@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('payment.Purchase history')}} @endsection
@section('css')

 @endsection
@section('js') 
  
@endsection

@section('mainContent')
    <x-my-homework />
@endsection

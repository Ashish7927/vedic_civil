@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} |
{{__('org-subscription.My Plan')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/elatihlmstheme/css/org-subscription.css')}}" rel="stylesheet"/>
@endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')
    <x-my-org-subscription-plan-section :request="$request"/>
@endsection

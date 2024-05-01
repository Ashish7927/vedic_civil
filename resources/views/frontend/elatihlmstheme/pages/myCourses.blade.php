@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} |
@if( routeIs('myClasses'))
    {{__('courses.Live Class')}}
@elseif( routeIs('myQuizzes'))
    {{__('courses.My Quizzes')}}
@else
    {{__('courses.My Courses')}}
@endif @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/my_course.js')}}?v=1"></script>
@endsection
<style>
    .nice-select.open .list {
    white-space: pre-line;}
</style>
@section('mainContent')
    <x-my-courses-page-section :request="$request"/>

@endsection

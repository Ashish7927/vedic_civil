@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | @if( routeIs('myClasses'))
    {{__('courses.Live Class')}}
@elseif( routeIs('myQuizzes'))
    {{__('courses.My Quizzes')}}
@else
    {{__('courses.My Courses')}}
@endif @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')

    <x-subscription-my-course-page-section/>

@endsection

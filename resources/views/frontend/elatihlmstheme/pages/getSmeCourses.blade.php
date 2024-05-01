@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection
<style>
    .error-sme-course {
        margin: 5px;
        width: 100%;
        border: none;
        padding: 10px;
        position: relative;
    }
    .error-sme-course span {
        position: absolute;
        left: 38%;
        top: 22%;
        color: red;
    }
</style>
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')
    @if(\Illuminate\Support\Facades\Session::get('smeExpiredError'))
        <div class="error-sme-course">
            <span>{{ \Illuminate\Support\Facades\Session::get('smeExpiredError') }}</span>
        </div>
    @endif
    <div class="sme-course-content">
        @if(isset($url) && !\Illuminate\Support\Facades\Session::get('smeExpiredError'))
            <iframe src="{{$url}}" width="100%" height="600"></iframe>
        @endif
    </div>
@endsection

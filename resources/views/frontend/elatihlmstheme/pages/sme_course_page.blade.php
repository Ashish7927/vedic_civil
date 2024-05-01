


@extends(theme('layouts.master'))
@section('title'){{'e-Latih LMS'}} @endsection
@section('css')
    <style>
        iframe {
            position: relative !important;
        }
        .error-sme-course {
            margin: 5px;
            width: 100%;
            border: none;
            padding: 10px;
            position: relative;
        }
        .error-sme-course span {
            font-size: 12pt;
            position: absolute;
            left: 38%;
            top: 22%;
            color: red;
        }
    </style>
    <link href="{{asset('public/frontend/elatihlmstheme/css/videopopup.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/elatihlmstheme/css/video.popup.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/elatihlmstheme/css/class_details.css')}}" rel="stylesheet"/>


@endsection


@section('mainContent')
    @if(\Illuminate\Support\Facades\Session::get('smeExpiredError'))
        <div class="error-sme-course">
            <span>{{ \Illuminate\Support\Facades\Session::get('smeExpiredError') }}</span>
        </div>
    @else
        <?php if(\Illuminate\Support\Facades\Session::get('CourseType') == 'Functional'): ?>

        <x-breadcrumb :banner="$frontendContent->course_page_banner"
                      :title="trans('frontend.Course Details')"
                      :subTitle="trans('frontend.Sme Development Functional Skills')"/>
        <?php elseif (\Illuminate\Support\Facades\Session::get('CourseType') == 'Strategic'): ?>

        <x-breadcrumb :banner="$frontendContent->course_page_banner"
                      :title="trans('frontend.Course Details')"
                      :subTitle="trans('frontend.Sme Development Strategic Skills')"/>

        <?php endif; ?>

        <x-sme-course-details-page-section :request="$request" />
    @endif
@endsection

@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/class_details.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/videopopup.js')}}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/video.popup.js')}}"></script>

@endsection

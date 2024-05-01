@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/classes.js')}}"></script>
@endsection

@section('mainContent')

    <style>
        .section_spacing5 {
            padding: 120px 0 10px 0;
        }
    
        @media(max-width:990px){
            .section_spacing5 {
                padding: 60px 0 10px 0;
            }
        }

        .section_spacing6 {
            padding: 120px 0 100px 0;
        }
    
        @media(max-width:990px){
            .section_spacing6 {
                padding: 60px 0 50px 0;
            }
        }
    </style>

    <x-breadcrumb :banner="$frontendContent->corporate_access_page_banner" :title="$frontendContent->corporate_access_page_title"
                  :subTitle="$frontendContent->corporate_access_page_sub_title"/>

    <x-corporate-access-page-learn-more-section />
    <x-corporate-access-page-unlock-business-potential-section :homeContent="$homeContent"/>
    <x-corporate-access-page-trusted-by-section :homeContent="$homeContent"/>
    <x-corporate-access-page-interested-section />
@endsection



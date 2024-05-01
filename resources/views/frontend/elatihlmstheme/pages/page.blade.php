@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{$page->title}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')



    <x-breadcrumb :banner="$page->banner" :title="$page->title"
                  :subTitle="$page->abc"/>

    <x-front-page-section :page="$page"/>

@endsection

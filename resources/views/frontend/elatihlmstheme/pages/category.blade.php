@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('frontend.Courses')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{ asset('public/frontend/elatihlmstheme/js/classes.js') }}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="$frontendContent->course_page_title"
                  :subTitle="$frontendContent->course_page_sub_title"/>
<div>
<style type="text/css">
    
    a.chbtn {
    background-color: #ED4E26;
    padding: 20px 35px;
    border-radius: 5px;
    color: white;
    font-size: 20px;
    font-weight: 400;
}
</style>
    <div class="category_area mt_30">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="row">

                            @if(isset($category))
                                @foreach ($category as $key=>$category)

                        <div class="col-lg-3 col-md-3">
                                        <div class="category_wiz mb_30">
                                            <div class="thumb cat1"
                                                 style="background-image: url('{{asset($category->thumbnail)}}')">
                                                <a href="{{route('courses')}}?category={{$category->id}}"
                                                   class="cat_btn">{{$category->name}}</a>
                                            </div>
                                        </div>
                                
                        </div>
                        @endforeach
                            @endif
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
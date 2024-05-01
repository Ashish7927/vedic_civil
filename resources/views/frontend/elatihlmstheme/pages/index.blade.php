@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('frontendmanage.Home')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <style>
        .section_spacing5 {
            padding: 60px 0 10px 0;
        }
    
        /* @media(max-width:990px){
            .section_spacing5 {
                padding: 60px 0 10px 0;
            }
        } */
    </style>
    @foreach($blocks as $block)
        @if($block->id==1)
                <x-home-page-banner :homeContent="$homeContent"/>
        @elseif($block->id==3)
            @if($homeContent->show_category_section==1)
                <x-home-page-category-section :homeContent="$homeContent" :categories="$categories"/>
            @endif
        @elseif($block->id==4)
            @if($homeContent->show_instructor_section==1)
                <x-home-page-instructor-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==5)
            @if($homeContent->show_course_section==1)
                <x-home-page-course-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==6)
            @if($homeContent->show_best_category_section==1)
                <x-home-page-best-category-section :homeContent="$homeContent" :categories="$categories"/>
            @endif
        @elseif($block->id==7)
            @if($homeContent->show_quiz_section==1)
                <x-home-page-quiz-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==8)
            @if($homeContent->show_testimonial_section==1)
                <x-home-page-testimonial-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==9)
            @if($homeContent->show_sponsor_section==1)
                <x-home-page-brand-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==10)
            @if($homeContent->show_article_section==1)
                <x-home-page-blog-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==11)
            @if($homeContent->show_become_instructor_section==1)
                @if(@Settings('instructor_reg') )
                    <x-home-page-become-instructor-section :homeContent="$homeContent"/>
                @endif
            @endif
        @elseif($block->id==16)
            @if($homeContent->show_how_to_buy==1)
                <x-home-page-how-to-buy :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==17)
            @if($homeContent->show_home_page_faq==1)
                <x-home-page-faq :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==18 || $block->block_name == 'Promo Section')
            @if($homeContent->show_promo_section==1)
                <x-home-page-promo-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==19 || $block->block_name == 'Corporate Access Promo Section')
            @if($homeContent->show_corporate_access_promo_section==1)
                <x-home-page-corporate-access-promo-section :homeContent="$homeContent"/>
            @endif
        @elseif($block->id==20 || $block->block_name == 'Homepage Advertisement')
            @if($homeContent->show_hp_advertisement_section==1)
                <x-home-page-advertisement-section :homeContent="$homeContent"/>
            @endif
        @endif
    @endforeach
@endsection

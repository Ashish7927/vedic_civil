@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'e-Latih LMS' }} | {{ $package->title }}
@endsection
@section('og_image')
    {{ $packageImage }}
@endsection
@section('css')
    <style>
        .course__details .video_screen {
            background-image: url('{{ $packageImage }}');
        }

        iframe {
            position: relative !important;
        }
    </style>

    <link href="{{ asset('public/frontend/elatihlmstheme/css/videopopup.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/frontend/elatihlmstheme/css/video.popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/frontend/elatihlmstheme/css/class_details.css') }}" rel="stylesheet" />
@endsection

@section('mainContent')
    {{-- <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="trans('frontend.Package Details')" :subTitle="$package->name" /> --}}
    <div>
        <div class="breadcrumb_area bradcam_bg_2"
            style="background-image: url('{{asset(@$frontendContent->course_page_banner)}}');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="breadcam_wrap">
                            <h3>
                                {{@$package->name}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-package-details-page-section :package="$package" :request="$request" :isEnrolled="$isEnrolled" />
@endsection

@section('js')
    <script src="{{ asset('public/frontend/elatihlmstheme/js/class_details.js') }}"></script>
    <script src="{{ asset('public/frontend/elatihlmstheme/js/videopopup.js') }}"></script>
    <script src="{{ asset('public/frontend/elatihlmstheme/js/video.popup.js') }}"></script>

    <script>
        $("#formSubmitBtn").on("click", function(e) {
            e.preventDefault();

            var form = $('#deleteCommentForm');
            var url = form.attr('action');
            var element = form.data('element');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {

                }
            });
            var el = '#' + element;
            $(el).hide('slow');
            $('#deleteComment').modal('hide');

        });
    </script>

    <script>
        function deleteCommnet(item, element) {
            let form = $('#deleteCommentForm')
            form.attr('action', item);
            form.attr('data-element', element);
        }
    </script>

    <script>
        var SITEURL = "{{ route('packageDetailsView', $package->slug) }}";
        var page = 1;
        load_more(page);
        $(window).scroll(function() { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more(page);
            }
        });

        function load_more(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                data: {
                    'type': 'comment'
                },
                beforeSend: function() {
                    $('.ajax-loading').show();
                }
            })
            .done(function(data) {
                if (data.length == 0) {
                    //notify user if nothing to load
                    $('.ajax-loading').html("No more records!");
                    return;
                }
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#conversition_box").append(data); //append data into #results element
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });
        }

        load_more_review(page);

        $(window).scroll(function() { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more_review(page);
            }
        });

        function load_more_review(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                data: {
                    'type': 'review'
                },
                beforeSend: function() {
                    $('.ajax-loading').show();
                }
            })
            .done(function(data) {
                if (data.length == 0) {
                    //notify user if nothing to load
                    $('.ajax-loading').html("No more records!");
                    return;
                }
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#customers_reviews").append(data); //append data into #results element
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });
        }
    </script>
@endsection

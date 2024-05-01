@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('courses.Courses')}} @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('public/backend/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/elatihlmstheme/css/select2_custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('Modules/SCORM_package/InfixLMS_SCORM_Doc/vendors/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/elatihlmstheme/css/elatih-frontend-css.css') }}" />
    <link href="{{asset('public/frontend/elatihlmstheme/css/loader.css')}}" rel="stylesheet"/>

    <style type="text/css">
        .nice-select-search-box {
            display: none !important;
        }
        .nice-select.open .list{
            padding: 0!important;
        }
        @media only screen and (max-width: 600px) {
            .course_category_inner{
                display: none;
            }
        }
        .course_title.mb_30.d-flex.align-items-center {
            cursor: pointer;
        }
        .primary_input_field {
            border: 1px solid #eceef4;
            font-size: 14px;
            color: #415094;
            padding-left: 20px;
            height: 46px;
            border-radius: 30px;
            width: 100%;
            padding-right: 15px;
        }
        .ui-widget-header{
            background: #ef4d23;
        }
        .start_end_price_span{
            font-size: 12px;
            font-weight: 700;
        }
        .price_range{
            font-size: 15px; padding: 5px 10px;
            margin-top: 20px;
        }
        .start_price,.start_duration{
            width: 40%;
            margin-bottom: 10px;
        }
        .end_price,.end_duration{
            width: 40%;
            margin-bottom: 10px;
        }
        .price_div{
            margin-bottom: 0px !important;
        }
        .apply_button{
            background-color: #ef4d23;
            color: #fff;
        }
        .clear_content_provider_data{
            padding: 0 5px 3px 5px;
            font-size: 12px;
            width: 19%;
            float: right;

            border: 1px solid #eceef4;
            border-radius: 23px;
            height: 46px;
            font-size: 12px;
            color: #415094;
        }

        .course_title{
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination_row {
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('mainContent')
    <div class="loading" style="display: none"></div>

    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="$frontendContent->course_page_title" :subTitle="$frontendContent->course_page_sub_title"/>
    <x-course-page-section :request="$request" :categories="$categories" :languages="$languages" />

    <script src="{{ asset('assets/library/jquery/jquery.js') }}"></script>
    <script src="{{ asset('public/backend/js/jquery-ui.js') }}"></script>
    <script src="{{asset('public/frontend/elatihlmstheme/js/select2.min.js')}}"></script>

    <script>
        $(function() {
            cpload();
            // getCourseList();
            var currentURL = window.location.href;
            var page = getQueryParamFromUrl(currentURL, 'page');
                page !== null ?  getCourseList(page):  getCourseList();
        });

        $(".course_title").click(function(){
            $(".course_category_inner").fadeToggle();
        });

        $('#duration_range').select2({
            placeholder: "Select Duration",
            allowClear: true,
        });

        $("#duration_range").change(function() {
            var duration = $(this).val().split("-");

            $('#start_duration').val(duration[0]);
            $('#end_duration').val(duration[1]);
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];

            getCourseList(page);
        });

        $(document).on('click', '#apply_button', function(e) {
            e.preventDefault();

            getCourseList();
        });

        $(document).on('change', '#order', function(e) {
            e.preventDefault();
            getCourseList();
        });

        $(document).on('click', '#reset_button', function(e) {
            $('input[type="checkbox"]').each(function() {
                this.checked = false;
            });

            $('.version').prop('checked', false);
            $('#duration_range').val('');
            $('#start_duration').val('');
            $('#end_duration').val('');
            $('#start_price').val('');
            $('#end_price').val('');

            getCourseList();
        });

        cpload = () => {
            var url = "{{ route('cp_data_with_ajax') }}";
            $("#contentprovider").select2({
            placeholder: "Select Content Provider",
            allowClear: true,
                ajax: {
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: false
                }
            });
        }

        function getCourseList(page = 0) {
            $('.loading').show();
            $('#content').html('');

            let filters = '';

            var order = $('#order').find(":selected").val();
            if (page == 0) {
                filters += "?order=" + order;
            } else {
                filters += "&order=" + order;
            }

            var category = [];
            $('.category:checked').each(function (i) {
                category[i] = $(this).val();
            });
            filters += '&categories=' + category.toString();

            var level = [];
            $('.level:checked').each(function (i) {
                level[i] = $(this).val();
            });
            filters += '&levels=' + level.toString();

            var language = [];
            $('.language:checked').each(function (i) {
                language[i] = $(this).val();
            });
            filters += '&languages=' + language.toString();

            var startduration = "";
            startduration = $("#start_duration").val();
            filters += "&start_duration=" + startduration.toString();

            var endduration = "";
            endduration = $("#end_duration").val();
            filters += "&end_duration=" + endduration.toString();

            var content_provider = '';
            content_provider = $('#contentprovider').val();
            filters += '&content_provider=' + content_provider.toString();

            var ratings = [];
            $('.rating:checked').each(function (i) {
                ratings[i] = $(this).val();
            });
            filters += '&ratings=' + ratings.toString();

            var version = [];
            $('.version:checked').each(function (i) {
                version[i] = $(this).val();
            });
            filters += '&version=' + version.toString();

            var start_price = "";
            start_price = $("#start_price").val();
            filters += "&start_price=" + start_price.toString();

            var end_price = "";
            end_price = $("#end_price").val();
            filters += "&end_price=" + end_price.toString();

            if (page != 0) {
                url = '{!! route('get_course_list') !!}?page='+page;
            } else {
                url = '{!! route('get_course_list') !!}';
            }

            url = url + filters;
          
            let redirect_url = '';
            if (page != 0) {
                redirect_url = 'courses?page='+page + filters;
            } else {
                redirect_url = 'courses'+ filters;
            }
            window.history.replaceState(null, null, redirect_url);

            $.ajax({
                url: url,
                dataType: "json",
                timeout: 45000,
                success: function (response) {
                    $('.loading').hide();
                    let total_course_count = response.total_courses + ' {{ __('frontend.Course are found') }}';

                    $('#total_course_count').html(total_course_count);
                    $('#div_content').html(response.course_list);
                }, error: function (response) {
                    $('.loading').hide();
                    toastr.error('Something went wrong', 'Error');
                }
            });
        }

        // Function to extract query parameters from a URL
        function getQueryParamFromUrl(url, param) {
            var queryParams = url.split('?')[1];
            if (queryParams) {
                var paramPairs = queryParams.split('&');
                for (var i = 0; i < paramPairs.length; i++) {
                    var pair = paramPairs[i].split('=');
                    if (pair[0] === param) {
                        return pair[1];
                    }
                }
            }
            return null;
        }
    </script>
@endsection

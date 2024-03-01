@extends('backend.master')

@php $table_name = 'packages'; @endphp
@section('table'){{ $table_name }} @stop

@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('frontend/elatihlmstheme/css/select2_custom.css') }}?{{ $version }}" />
    <style type="text/css">
        .loading-spinner,
        .submit-loading-spinner {
            display: none;
        }

        .loading-spinner.active,
        .submit-loading-spinner.active {
            display: inline-block;
        }
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('courses.Packages') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('courses.Packages') }}</a>
                    <a href="#">{{ __('courses.Packages List') }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <input type="hidden" name="role_id" id="current_user_role_id" value="{{ auth()->user()->role_id }}">
                        {{-- action="{{route('courseSortBy')}}" --}}
                        <form method="POST" id="filter_form" action="{{ route('course_list_excel_download') }}">
                            @csrf

                            <input type="hidden" name="previous_route" value="{{ \Route::current()->getName() }}">

                            <div class="row">

                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="start_price">Title</label>
                                    <input type="text" placeholder="Enter Title" name="title" class="primary_input_field" id="title">
                                </div>

                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="category">{{__('courses.Category')}}</label>
                                    <select class="primary_select" name="category" id="category">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->id}}" {{isset($category_search)?$category_search==$category->id?'selected':'':''}}>{{@$category->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(\Route::current()->getName() != 'getActiveCourse' && \Route::current()->getName() != 'getPendingCourse')
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="search_status" id="status">
                                        <option data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                value="">{{__('common.Select')}} {{__('common.Status')}}</option>
                                        <option
                                            value="2" {{isset($category_status)?$category_status=="2"?'selected':'':''}}>Published</option>
                                        <option
                                            value="1" {{isset($category_status)?$category_status=="1"?'selected':'':''}}>UnPublished</option>
                                        <option
                                            value="0" {{isset($category_status)?$category_status=="0"?'selected':'':''}}>Saved</option>
                                    </select>

                                </div>
                                @endif
                                <div class="col-lg-3 mt-30">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('courses.Expiry Period') }} *</label>
                                        <select class="primary_select" name="expiry_period" id="expiry_period">
                                            <option value="">{{ __('common.Select') }} {{ __('courses.Expiry Period') }}</option>
                                            <option value="6" {{ (isset($package) && $package->expiry_period == 6) ? 'selected' : '' }}>6 Months</option>
                                            <option value="12" {{ (isset($package) && $package->expiry_period == 12) ? 'selected' : '' }}>12 Months</option>
                                            <option value="18" {{ (isset($package) && $package->expiry_period == 18) ? 'selected' : '' }}>18 Months</option>
                                            <option value="24" {{ (isset($package) && $package->expiry_period == 24) ? 'selected' : '' }}>24 Months</option>
                                        </select>
                                        @if ($errors->has('expiry_period'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('expiry_period') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if(!check_whether_cp_or_not() && !isPartner())
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="content_provider">Content Provider</label>
                                    <select class="primary_select" name="content_provider" id="content_provider">
                                        <option data-display="{{__('common.Select')}}"
                                                value="">{{__('common.Select')}}</option>
                                        @if(isset($cps))
                                            @foreach($cps as $cp)
                                                <option value="{{ $cp->id }}">{{ $cp->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                @endif

                                @if(Route::current()->getName() == 'getPendingCourse')
                                    <div class="col-lg-3 mt-30">
                                        <label class="primary_input_label" for="fromSubmissionDate">Submission Date From</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="from_submission_date" id="from_submission_date">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-30">
                                        <label class="primary_input_label" for="toSubmissionDate">Submission Date To</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field" type="date" name="to_submission_date" id="to_submission_date">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <button type="button" id="apply-filters" class="primary-btn radius_30px mr-10 fix-gr-bg">Filter</button>
                                        <button type="button" id="reset-filters"   class="btn btn-default" style="background:white;color:#1b191f;boder:1 px solid black;" data-dismiss="modal">Reset</button>
                                        {{-- <button type="submit" class="primary-btn radius_30px mr-10 fix-gr-bg">{{__('courses.Filter')}} </button> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('courses.Advanced Filter') }} </h4>
                        </div>
                        <input type="hidden" name="role_id" id="current_user_role_id" value="{{ auth()->user()->role_id }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{ __('courses.Packages List') }} </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="table-responsive">
                                <table id="lms_table" class="table classList">
                                    <thead>
                                        <tr>
                                            <th scope="col"> {{ __('common.SL') }}</th>
                                            @if (isAdmin() || isHRDCorp() || isMyLL())
                                                <th scope="col"> {{ __('common.User') }} {{ __('common.Name') }}</th>
                                            @endif
                                            <th scope="col"> {{ __('common.Title') }}</th>
                                            <th scope="col"> {{ __('courses.Courses') }}</th>
                                            <th scope="col"> {{ __('courses.Categories') }}</th>
                                            <th scope="col"> {{ __('courses.Price') }}</th>
                                            <th scope="col"> {{ __('courses.Expiry Period') }}</th>
                                            <th scope="col"> {{ __('courses.Published At') }}</th>
                                            <th scope="col"> {{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('coursesetting::packages.assign_certificate_modal')
@endsection
@push('scripts')
    <script src="{{ asset('/') }}/Modules/CourseSetting/Resources/assets/js/course.js"></script>

    @php $url = route('getAllPackageData'); @endphp

    <script>
        var dom_data = '';
        var current_user_role_id = 0;

        $(function() {
            current_user_role_id = $("#current_user_role_id").val();

            if (current_user_role_id == 7 || current_user_role_id == 8) {
                dom_data = 'frtip';
            } else {
                dom_data = 'Bfrtip';
            }

            tableLoad();
        });

        tableLoad = () => {
            let table = $('.classList').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 1 // number of pages to cache
                }),
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    @if (isAdmin() || isHRDCorp() || isMyLL())
                        { data: 'user', name: 'user' },
                    @endif
                    { data: 'name', name: 'name' },
                    { data: 'courses', name: 'courses' },
                    { data: 'categories', name: 'categories' },
                    { data: 'price', name: 'price' },
                    { data: 'expiry_period', name: 'expiry_period' },
                    { data: 'published_at', name: 'published_at' },
                    { data: 'status', name: 'status', orderable: false, searchable: false},
                    { data: 'action', name: 'action', orderable: false },

                ],
                language: {
                    emptyTable: "{{ __('common.No data available in the table') }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __('common.Quick Search') }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: dom_data,
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.Copy') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __('common.Excel') }}',
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },

                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="far fa-file-alt"></i>',
                        titleAttr: '{{ __('common.CSV') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.PDF') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __('common.Print') }}',
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ['colvisRestore']
                    }
                ],
                columnDefs: [{
                    visible: false
                }],
                responsive: false,
            });
        }

        $('#lms_table').on('preXhr.dt', function(e, settings, data) {
            var category = $('#category').val();
            var status = $('#status').val();
            var content_provider = $('#content_provider').val();
            var title = $('#title').val();
            var expiry_period = $('#expiry_period').val();
            data['category'] = category;
            data["content_provider"] = content_provider;
            data['status'] = status;
            data['title'] = title;
            data['expiry_period'] = expiry_period;
        });

        $('#apply-filters').click(function() {
            tableLoad();
        });

        $('#reset-filters').click(function () {
            $('#filter_form')[0].reset();
            $('#instructor').val('').trigger('change');
            $('#content_provider, #status, #category').val( $('#content_provider, #status, #category').data('display'));
            $('#content_provider, #status, #category').niceSelect('update')
            tableLoad();
        });

        $('#lms_table_info').append('<span id="add_here"> new-dynamic-text</span>');

        $(document).on("change", ".package_status_enable_disable", function () {
            var checked = $(this).is(":checked") ? 1 : 2;
            var id = $(this).val();
            var data = {id:id,status:checked};
            $.ajax({
                type: "GET",
                url: "{!! route('changePackageStatus') !!}",
                data: data,
                dataType: "json",
                success: function (res) {
                    if (res.success) {
                        toastr.success(res.success, "Success")
                    } else {
                        toastr.error(res.error, "Error");
                    }
                },
                error: function (res) {
                    toastr.error("Something went wrong!", "Falied")
                }
            });
        });

    </script>
@endpush

@extends('backend.master')

@php
    $table_name='blogs';
@endphp
@section('table'){{$table_name}}@endsection
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('blog.Blogs')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('blog.Blogs')}}</a>
                    <a href="#">{{__('blog.Blog List')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{__('blog.Blog List')}}</h3>
                            @if (permissionCheck('blog.create'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                           data-target="#add_blog" href="#"><i
                                                class="ti-plus"></i>{{__('common.Add')}} {{__('blog.Blog')}}</a></li>
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">

                                <table id="lms_table" class="table Crm_table_active_blog">
                                    <thead>
                                    <tr>

                                        <th scope="col"> {{__('blog.SL')}}</th>
                                        <th scope="col"> {{__('blog.Title')}}</th>
                                        <th scope="col"> {{__('blog.Authored Date')}}</th>
                                        <th scope="col"> {{__('blog.Viewed')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <td class=""><span class="m-2">{{++$key}}</span></td>
                                            <td>{{@$blog->title}}</td>
                                            <td>
                                                {{ showDate(@$blog->authored_date ) }}
                                            </td>
                                            <td>{{@$blog->viewed}}</td>


                                            <td>
                                                <label class="switch_toggle" for="active_checkbox{{@$blog->id }}">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox{{@$blog->id }}"
                                                           @if (@$blog->status == 1) checked
                                                           @endif value="{{@$blog->id }}">
                                                    <i class="slider round"></i>
                                                </label>

                                            </td>


                                            <td>
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{__('common.Action')}}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        <a target="_blank"
                                                           href="{{route('blogDetails',[$blog->slug])}}?preview=1"
                                                           class="dropdown-item" type="button">{{__('common.View')}}</a>
                                                        @if (permissionCheck('blog.edit'))
                                                            <button data-item="{{$blog}}"
                                                                    class="editBlog dropdown-item"
                                                                    type="button">{{__('common.Edit')}}</button>
                                                        @endif
                                                        @if (permissionCheck('blog.delete'))
                                                            <button data-id="{{$blog->id}}"
                                                                    class="deleteBlog dropdown-item"
                                                                    type="button">{{__('common.Delete')}}</button>

                                                        @endif
                                                    </div>
                                                </div>

                                            </td>


                                        </tr>


                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade admin-query" id="add_blog">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Add New')}} {{__('blog.Blog')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('blogs.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">  {{__('blog.Title')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field addTitle" name="title" placeholder="-"
                                                       type="text"
                                                       value="{{old('title')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">  {{__('blog.Slug')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field addSlug" name="slug" placeholder="-"
                                                       type="text"
                                                       value="{{old('slug')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('blog.Blog')}} {{__('blog.Description')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <textarea class="lms_summernote" name="description" id="" cols="30"
                                                          required
                                                          rows="10">{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-20">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('blog.Thumbnail') }}  (Recommend size: 1170x600)
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder" type="text"
                                                           id=""
                                                           placeholder="{{__('blog.Browse Image File')}}" readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file_2">{{__('common.Browse') }}</label>
                                                        <input type="file" class="d-none fileUpload" name="image"
                                                               id="document_file_2">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('blog.Publish Date') }}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Start Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="start_date" type="text"
                                                                       name="publish_date"
                                                                       value="{{date('m/d/Y')}}"
                                                                       autocomplete="off">

                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Add') }} {{__('blog.Blog') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editBlog">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Edit')}} {{__('quiz.Topic')}} </h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <input type="hidden" id="url" value="{{url('/')}}">

                            <div class="modal-body">
                                <form action="{{route('blogs.update')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="" id="BlogId">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Title')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field editTitle" name="title"
                                                       required
                                                       value="" placeholder="-"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('blog.Slug')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field editSlug" name="slug"
                                                       required
                                                       value="" placeholder="-"
                                                       type="text">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('blog.Blog')}} {{__('blog.Description')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <textarea class="lms_summernote"
                                                          name="description" required
                                                          id="description" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-20">


                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('blog.Thumbnail')}}
                                                    (Recommend size: 1170x600) </label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder" type="text"
                                                           id="image"
                                                           value=""
                                                           placeholder="{{__('blog.Browse Image File')}}"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label
                                                            class="primary-btn small fix-gr-bg"
                                                            for="document_file_1_edit">{{__('common.Browse')}}</label>
                                                        <input type="file" class="d-none fileUpload"
                                                               name="image"
                                                               id="document_file_1_edit">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('blog.Publish Date') }}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Start Date"
                                                                       class="primary_input_field primary-input date form-control editPublishDate"
                                                                       id="" type="text"
                                                                       name="publish_date"
                                                                       value=""
                                                                       autocomplete="off">

                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id=""></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}}  {{__('blog.Blog')}}
                                            </button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade admin-query" id="deleteBlog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('blogs.destroy')}}"
                                  method="post">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('blog.Blog')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">

                                        <input type="hidden" name="id" value="" id="blogDeleteId">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>


                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="{{asset('backend/js/blog_list.js')}}"></script>
    <script src="{{asset('backend/js/blog_list.js')}}"></script>

@endsection

@push('scripts')


    <script>
        let datatable = $('.Crm_table_active_blog').DataTable({
            bLengthChange: true,
            "bDestroy": true,
            columns: [
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: false},
                { orderable: false},

            ],
            language: {
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="far fa-copy"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{__('common.Copy')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: '{{__('common.Excel')}}',
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
                    titleAttr: '{{__('common.CSV')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{__('common.PDF')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    header: true,
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }

                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: '{{__('common.Print')}}',
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
            responsive: true,
            paging:true,
            "lengthChange": true,
            "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]
        });
    </script>
@endpush

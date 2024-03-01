@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}"/>
    <style>
        .progress-bar {
            background-color: #9734f2;
        }
    </style>
@endpush
    @php
        $table_name = 'users';
    @endphp
@section('table'){{$table_name}}@endsection

@section('mainContent')
    {{-- Vimoe upload in folder demo 3-3-2022 --}}
        {{-- <form method="post" action="{{ route('vimeo_upload') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <button type="submit">submit</button>
        </form> --}}
    {{-- End : Vimoe upload in folder demo 3-3-2022 --}}
     <div class="container-fluid p-0 ">
        <section class="sms-breadcrumb white-box" style="margin-bottom: 80px">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <h1>{{__('courses.Course Statistics')}}</h1>
                    <div class="bc-pages">
                        <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                        <a href="#">{{__('courses.Courses')}}</a>
                        <a href="#">{{__('courses.Course Statistics')}}</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('courses.Course Statistics')}}</h3>
                    <ul class="d-flex">
                        @if(isAdmin() || isHRDCorp())
                        <li>
                            <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="excel_import_table_data" href="{{ route('course.export_course_statistics') }}">
                                Export
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>

             <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col"> {{__('common.SL')}}</th>
                                        <th scope="col">{{__('courses.Course')}}</th>
                                        <th scope="col">{{__('courses.Enrolled')}}</th>
                                        <th scope="col">{{__('common.Pass')}}</th>
                                        <th scope="col">{{__('common.Fail')}}</th>
                                        <th scope="col">{{__('common.Result')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($courses as $key => $course)
                                            <tr>
                                                <td>{{@$key+1}}</td>
                                                <td>{{@$course->title}}</td>
                                                <td>{{@$course->enrollUsers->count()}}</td>
                                                <td>{{@$course->result()['complete']}}</td>
                                                <td>{{@$course->result()['incomplete']}}</td>
                                                <td>

                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu1{{@$course->id}}" data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu1{{@$course->id}}">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#view_result{{$course->id}}" href="#">{{__('common.View')}}</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                             <div class="modal fade admin-query" id="view_result{{$course->id}}">

                                            </div>
                                        @endforeach --}}

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
<div class="modal fade admin-query" id="modal_course_details">

</div>
@endsection
@push('scripts')
    @php
        $url = route('course.dataCourseStatistics');
    @endphp
    <script type="text/javascript">
        let table = $('#lms_table').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            responsive: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            order: [[0, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
            }),
            language: {
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'title', name: 'title'},
                {data: 'enrolled', name: 'enrolled'},
                {data: 'pass', name: 'pass'},
                {data: 'fail', name: 'fail'},
                {data: 'action', name: 'action', orderable: false},
            ]
        });

        $("body").on('click', '#view_button', function() {
            // var id = $(this).closest('td').find('.cource_details').html();
            // $("#modal_course_details").html(id);
            // $("#modal_course_details").modal("show");
            var id = $(this).data('id');
            var url = "{{ route('course.courseAjaxData', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $("#modal_course_details").html(data);
                    $("#modal_course_details").modal("show");
                    // console.log(data);
                    // $("#course_title").text(data.title);

                    // var enrolled = data.enrolls;
                    // $.each(enrolled,function(key,value){

                    //     var percentage = round(data.userTotalPercentage(value.user_id,value.course_id));
                    //     alert(percentage);
                    //     $("#enrolled").append(
                    //         '<div class="col-lg-12 mt-2 d-flex">'+

                    //             '<div class="col-lg-2">'+ (key+1) +
                    //             '</div>'+
                    //             '<div class="col-lg-6">'+
                    //                 value.user.name+
                    //             '</div>'+
                    //             '<div class="col-lg-4">'+
                    //                 '<button class="primary-btn radius_30px mr-10 fix-gr-bg" ></button>'+
                    //             '</div>'+
                    //         '</div>'
                    //         );
                    // });
                }
            });
        });
    </script>

    @if ($errors->any())
        <script>
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_student').modal('show');
            @else
            $('#editStudent').modal('show');
            @endif
            @endif
        </script>
    @endif


@endpush

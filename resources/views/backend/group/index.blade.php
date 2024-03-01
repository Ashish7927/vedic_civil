@extends('backend.master')
@php
    $table_name='group';
@endphp
@section('table'){{$table_name}}@stop

@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>Groups</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">Group</a>
                    <a href="#">List</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Group List</h3>
                            <ul class="d-flex">
                                <li>
                                    <a class="primary-btn radius_30px mr-10 fix-gr-bg" id="add_group" href="javascript:void(0)">
                                        + Add
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">

                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}} </th>
                                        <th scope="col">{{__('common.Name')}} </th>
                                        <th scope="col">{{__('Course Type')}} </th>
                                        <th scope="col">{{__('common.Description')}} </th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->
            </div>
        </div>
    </section>
    @include('backend.partials.delete_modal')

    <div class="modal fade admin-query" id="addeditgroup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Edit')}} </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{ route('admin.group_store') }}">
                        @csrf
                        <input type="hidden" name="id" id="group_id">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="startDate">Group Name *</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <input class="primary_input_field" type="text" name="name" id="group_name" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="description">Group description</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <textarea id="group_description" class="primary_input_field" name="description" style="height: 200px" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="course_type">Course Type</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <select class="form-control select2" name="course_type" id="course_type">
                                                    {{-- <option value="1">Micro-credential</option> --}}
                                                    {{-- <option value="2">Claimable</option> --}}
                                                    {{-- <option value="3">Other</option> --}}
                                                    <option value="4">e-Learning</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button class="primary-btn fix-gr-bg" type="submit" id="form_submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')

    @php
           $url =route('admin.getGroupData');
    @endphp


    <script>
        $(function() {
            tableLoad();
        });
        tableLoad = () => {
            let table = $('#lms_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    pages: 1 // number of pages to cache
                }),
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'course_type', name: 'course_type'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action',orderable:false},
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
                // dom: 'Bfrtip',

                // columnDefs: [{
                //     visible: false
                // }],
                // responsive: true,
            });
        }

        $(document).on('click', '#add_group', function () {
            $('#group_id').val('');
            $('#group_name').val('');
            $('#group_description').val('');
            $('.modal-title').text('Add');
            $('#form_submit').text('Submit');
            $("#addeditgroup").modal('show');
        });

        $(document).on('click', '.edit_group', function () {
            let id = $(this).data('id');
            $('#group_id').val(id);

            var url = "{{ route('admin.group_show',':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    if(data.status == 1){
                        $('#group_id').val(data.data.id);
                        $('#group_name').val(data.data.name);
                        $('#group_description').val(data.data.description);
                        $('#course_type').val(data.data.course_type);
                        $('.modal-title').text('Edit');
                        $('#form_submit').text('Edit');
                        $("#addeditgroup").modal('show');
                    }
                },
                error: function(data) {
                    console.log("Error:", data);
                },
            });
        });

        // $(document).on('click', '#form_submit', function () {
        //     var id = $('#group_id').val();
        //     var url = "{{ route('admin.group_store') }}";
        //     $.ajax({
        //             type: "POST",
        //             dataType: "json",
        //             url: url,
        //             data: {
        //                 id: $("#group_id").val(),
        //                 name: $("#group_name").val(),
        //                 description: $("#group_description").val(),
        //             },
        //             success: function (response) {
        //                 if(response.status == 1){
        //                     if(id == '')
        //                         toastr.success('Added successfully!');
        //                     else
        //                         toastr.success('Updated successfully!');
        //                     $("#addeditgroup").modal('hide');
        //                     tableLoad();
        //                 }
        //                 else{
        //                     toastr.error(response.message);
        //                 }
        //             },
        //             error: function (response) {
        //                 console.log(response.responseJSON.errors);
        //                 if(typeof(response.responseJSON) != "undefined" && response.responseJSON !== null) {
        //                     if(typeof(response.responseJSON.errors) != "undefined" && response.responseJSON.errors !== null) {

        //                     }
        //                 }
        //                 toastr.error('Something wrong !')
        //             }
        //         });
        // });
    </script>
@endpush

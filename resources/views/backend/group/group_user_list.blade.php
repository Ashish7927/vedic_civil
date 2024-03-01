@extends('backend.master')
@php
    $table_name='user_group';
@endphp
@section('table'){{$table_name}}@stop
@push('styles')
    <link rel="stylesheet" href="{{asset('frontend/elatihlmstheme/css/select2.min.css')}}"/>
    <style type="text/css">
        .select2-dropdown{
            z-index: 99999999999;
        }
    </style>
@endpush
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>User Groups</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">User Group</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">User Group List</h3>
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
                                        <th scope="col">User </th>
                                        <th scope="col">Group </th>
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
                    <form method="post">
                        @csrf
                        <input type="hidden" name="id" id="user_group_id">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="startDate">User</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <select class="form-control select2" name="user_id" id="user_id">
                                                    <option value="">Select User</option>
                                                    {{-- @if(isset($users))
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    @endif --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="description">Group</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <select class="form-control select2" name="group_id" id="group_id">
                                                    <option value="">Select Group</option>
                                                    {{-- @if(isset($groups))
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->id}}">{{$group->name}}</option>
                                                        @endforeach
                                                    @endif --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button class="primary-btn fix-gr-bg" type="button" id="form_submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('frontend/elatihlmstheme/js/select2.min.js')}}"></script>
    @php
           $url =route('admin.getUserGroupData');
    @endphp


    <script>
        $(function() {
            tableLoad();
            userload();
            groupload();
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
                    {data: 'user', name: 'user',orderable:false},
                    {data: 'group', name: 'group',orderable:false},
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

        userload = () => {
            var url = "{{ route('admin.user_data') }}";
            $("#user_id").select2({
                allowClear: true,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
            // $.ajax({
            //     type: "GET",
            //     dataType: "json",
            //     url: url,
            //     success: function(data) {
            //         if(data.status == 1){
            //             var data = data.data;
            //             $.each(data,function(key,value){
            //                 $("#user_id").append('<option value="'+value.id+'">'+value.name+'</option>');
            //             });
            //         }
            //     },
            //     error: function(data) {
            //         console.log("Error:", data);
            //     },
            // });
        }

        groupload = () => {
            var url = "{{ route('admin.group_data') }}";
            $("#group_id").select2({
                allowClear: true,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
            // $.ajax({
            //     type: "GET",
            //     dataType: "json",
            //     url: url,
            //     success: function(data) {
            //         if(data.status == 1){
            //             var data = data.data;
            //             $.each(data,function(key,value){
            //                 $("#group_id").append('<option value="'+value.id+'">'+value.name+'</option>');
            //             });
            //         }
            //     },
            //     error: function(data) {
            //         console.log("Error:", data);
            //     },
            // });
        }

        $(document).on('click', '#add_group', function () {
            $('#user_group_id').val('');
            // $('#user_id').empty();
            // $('#group_id').empty();
            $('#user_id').val('').trigger('change');
            $('#group_id').val('').trigger('change');
            // $('#user_id').niceSelect('update'); 
            // $('#group_id').niceSelect('update'); 
            $('.modal-title').text('Add');
            $('#form_submit').text('Submit');
            $("#addeditgroup").modal('show');
        });

        $(document).on('click', '.edit_group', function () {
            let id = $(this).data('id');
            $('#user_group_id').val(id);

            var url = "{{ route('admin.user_group_show',':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    if(data.status == 1){
                        // setTimeout(function() {startTime()}, 1000);
                        $("#user_id").append('<option value="'+data.data.user_id+'">'+data.data.user.name+'</option>').trigger('change');
                        $("#group_id").append('<option value="'+data.data.group_id+'">'+data.data.group.name+'</option>').trigger('change');
                        
                        $('#user_group_id').val(data.data.id);
                        $('#user_id').val(data.data.user_id).trigger('change');
                        $('#group_id').val(data.data.group_id).trigger('change');
                        // $('#user_id').niceSelect('update');
                        // $('#group_id').niceSelect('update');
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
        
        $(document).on('click', '#form_submit', function () {
            var id = $('#user_group_id').val();
            var url = "{{ route('admin.user_group_store') }}";

            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    data: {
                        id: $("#user_group_id").val(),
                        user_id: $("#user_id").val(),
                        group_id: $("#group_id").val(),
                    },
                    success: function (response) {
                        if(response.status == 1){
                            if(id == '')
                                toastr.success('Added successfully!');
                            else
                                toastr.success('Updated successfully!');
                            $("#addeditgroup").modal('hide');
                            tableLoad();
                        }
                        else{
                            toastr.error(response.message);
                        }
                    },
                    error: function (response) {
                        toastr.error('Something wrong !')
                    }
                });
        });
    </script>
@endpush
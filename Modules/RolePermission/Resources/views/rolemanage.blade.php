@extends('backend.master')

@php
    $table_name='roles';
@endphp
@section('table'){{$table_name}}@endsection
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('role.Role')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('role.Role')}}</a>
                    <a href="#">{{__('role.Role List')}}</a>
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{__('role.Role List')}}</h3>
                            @if (permissionCheck('role.create'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                           data-target="#add_blog" href="#"><i
                                                class="ti-plus"></i>{{__('common.Add')}} {{__('role.Role')}}</a></li>
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

                                        <th scope="col"> {{__('role.SL')}}</th>
                                        <th scope="col"> {{__('role.Name')}}</th>
                                        <th scope="col"> {{__('role.Authored_Date')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td class=""><span class="m-2">{{++$key}}</span></td>
                                            <td>{{@$role->name}}</td>
                                            <td>
                                                {{ showDate(@$role->created_at ) }}
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
                                                         @if (permissionCheck('role.edit'))
                                                           <form method="get" action="{{ url('role-permission/permissionview') }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$role->id}}">
                                                            <button class="dropdown-item"
                                                                    type="submit">Update Permissions</button>
                                                                </form>
                                                        @endif
                                                        @if (permissionCheck('role.edit'))
                                                            <button data-item="{{$role}}"
                                                                    class="editRole dropdown-item"
                                                                    type="button">{{__('common.Edit')}}</button>
                                                        @endif
                                                        @if (permissionCheck('role.delete'))
                                                            <button data-id="{{$role->id}}"
                                                                    class="deleteRole dropdown-item"
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
                                <h4 class="modal-title">{{__('common.Add New')}} {{__('role.Role')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('roles.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">  {{__('role.Name')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field addTitle" name="name" placeholder="-"
                                                       type="text"
                                                       value="{{old('title')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Add') }} {{__('role.Role') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editRole">
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
                                <form action="{{route('roles.update')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="" id="RoleId">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Title')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field editName" name="name"
                                                       required
                                                       value="" placeholder="-"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}}  {{__('role.Role')}}
                                            </button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade admin-query" id="deleteRole">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('roles.destroy')}}"
                                  method="post">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('role.Role')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">

                                        <input type="hidden" name="id" value="" id="roleDeleteId">
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
    <script src="{{asset('backend/js/role_list.js')}}"></script>

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

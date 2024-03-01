@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('tax.Tax') }} {{ __('tax.Settings') }}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{ __('tax.Tax') }} {{ __('tax.Settings') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex mb-0">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> @if(!isset($edit)) {{__('coupons.Add New Coupons') }} @else {{__('tax.Update Tax')}} @endif</h3>
                                    @if(isset($edit))
                                        <a href="{{ route('setting.tax_setting') }}" class="primary-btn small fix-gr-bg ml-3" style="position: absolute;  right: 0; margin-right: 15px;" title="{{__('tax.Add New Tax')}}">+</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="white-box ">
                        <form action="{{ route('setting.tax_setting.store') }}" method="POST" id="coupon-form" name="coupon-form" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="id" value="{{ isset($edit) ? $edit->id : '' }}">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="name">{{ __('tax.Tax') }} {{ __('tax.Name') }} <strong class="text-danger">*</strong></label>
                                        <input name="name" id="name" class="primary_input_field name {{ @$errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('tax.Tax') }} {{ __('tax.Name') }}" type="text" value="{{ isset($edit)?$edit->name:old('name') }}" {{$errors->has('name') ? 'autofocus' : ''}}>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback d-block mb-10" role="alert">
                                              <strong>{{ @$errors->first('title') }}</strong>
                                          </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="number2">{{ __('tax.Tax') }} {{ __('tax.Value') }}
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input name="value" {{ $errors->has('value') ? 'autofocus' : ''}} class="primary_input_field name {{ @$errors->has('code') ? ' is-invalid' : '' }}" placeholder="{{ __('tax.Tax') }} {{ __('tax.Value') }}" type="number" id="number2" min="0" step="any" value="{{ isset($edit) ? $edit->value : old('value') }}">
                                        @if ($errors->has('value'))
                                            <span class="invalid-feedback d-block mb-10" role="alert">
                                              <strong>{{ @$errors->first('value') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg" data-toggle="tooltip" id="save_button_parent">
                                            <i class="ti-check"></i>
                                            @if(!isset($edit)) {{ __('common.Save') }} @else {{ __('common.Update') }} @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="main-title">
                        <h3 class="mb-20">{{ __('tax.Tax') }} {{ __('tax.Settings') }}</h3>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('tax.Tax')}} {{ __('tax.Name') }}</th>
                                        <th scope="col">{{__('tax.Tax Value')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{__('common.Created At')}}</th>
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

                <div class="modal fade admin-query" id="deleteTaxSetting">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Delete')}} {{ __('tax.Tax') }} {{ __('tax.Settings') }} </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('setting.tax_setting.delete')}}" method="post">
                                    @csrf
                                    <div class="text-center">
                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="taxSettingDeleteId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.Cancel')}}</button>

                                        <button class="primary-btn fix-gr-bg" type="submit">{{__('common.Delete')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let table = $('#lms_table').DataTable({
            bLengthChange: false,
            "bDestroy": true,
            processing: true,
            serverSide: true,
            "ajax": $.fn.dataTable.pipeline({
                url: "{!! route('setting.tax_setting.getAllData') !!}",
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'value', name: 'value'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},
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

            columnDefs: [{
                visible: false
            }],
            responsive: true,
        });

        $(document).on('click', '.deleteTaxSetting', function () {
            let id = $(this).data('id');
            $('#taxSettingDeleteId').val(id);
            $("#deleteTaxSetting").modal('show');
        });

        $(document).on('change', '.tax_setting_switch', function() {
            let id = $(this).data('id');
            let status = $(this).val();
            
            $.ajax({
                type: "POST",
                url: "{!! route('setting.tax_setting.change_status') !!}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    status: status,
                },
                success: function (data) {
                  if (data.status == true) {
                    toastr.success(data.message);
                    
                    if (status == 0) {
                        $('#active_checkbox'+id).val(1);
                    } else {
                        $('#active_checkbox'+id).val(0);
                    }
                  } else {
                    toastr.error(data.message);
                  }
                }
            });
        });
    </script>
@endpush

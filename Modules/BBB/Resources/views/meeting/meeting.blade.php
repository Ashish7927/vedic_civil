@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('bbb.BigBlueButton') }} {{ __('bbb.Classes') }} {{ __('bbb.Manage') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('dashboard.Dashboard') }}</a>
                    <a href="{{ route('virtual-class.index') }}">{{ __('bbb.Classes') }}</a>
                    <a href="#">{{ __('bbb.List') }}</a>
                </div>
            </div>
        </div>
    </section>


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                @if (permissionCheck('bbb.meetings.store'))
                    @include('bbb::meeting.includes.form')
                @endif

                @if (permissionCheck('bbb.meetings.index'))
                    @include('bbb::meeting.includes.list')
                @endif
            </div>
        </div>
    </section>
    <input type="hidden" name="get_user" class="get_user" value="{{ url('get-user-by-role') }}">

    @include('backend.partials.bbb_meeting_approve_reject')
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('backend/js/zoom.js') }}"></script>

    <script>
        $(document).ready(function () {
            tableLoad();
        });

        tableLoad = () => {
            let table = $('#lms_table').DataTable({
                bLengthChange: false,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: "{!! route('bbb.meetings.datatable') !!}",
                    pages: 1 // number of pages to cache
                }),
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'meeting_id', name: 'meeting_id' },
                    { data: 'class_title', name: 'class_title' },
                    @if (!isTrainer(Auth::user()))
                    { data: 'instructor', name: 'instructor' },
                    @endif
                    { data: 'topic', name: 'topic' },
                    { data: 'price', name: 'price' },
                    { data: 'date', name: 'date' },
                    { data: 'time', name: 'time' },
                    { data: 'duration', name: 'duration' },
                    { data: 'join_as_moderator', name: 'join_as_moderator' },
                    { data: 'join_as_attendee', name: 'join_as_attendee' },
                    { data: 'status', name: 'status', orderable: false, searchable: false},
                    { data: 'admin_review', name: 'admin_review' },
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
                responsive: true,
            });
        }

        $(document).on('click', '#btn_submit', function() {
            let today_date = moment().format('MM/DD/YYYY');
            today_date = new Date(today_date);

            let meeting_start_date = moment($('#startDate').val()).format('MM/DD/YYYY');
            meeting_start_date = new Date(meeting_start_date);

            let millisBetween = today_date.getTime() - meeting_start_date.getTime();
            let days = millisBetween / (1000 * 3600 * 24);

            let differenceDays = Math.round(Math.abs(days));

            if (differenceDays < 3) {
                toastr.error('Please select after 3 days date.', 'Validation Error');

                return false;
            }

            $('#bbbMeetingForm').submit();
        });

        $(document).on('click', '#btn_approve_confirm', function() {
            let meeting_id = $('.meeting_id').val();

            $.ajax({
                type: "POST",
                url: "{{ route('bbb.meetings.approve') }}",
                data: { meeting_id: meeting_id },
                dataType: "json",
                success: function (resp) {
                    if (resp.success) {
                        $("#approve_meeting_modal").modal("hide");
                        toastr.success(resp.message, 'Success');
                        tableLoad();
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            });
        });

        $(document).on('click', '#btn_reject_confirm', function() {
            $('#err_review').hide();
            let meeting_id = $('.meeting_id').val();
            let review = $('#review').val();

            if (review == '') {
                $('#err_review').show();
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('bbb.meetings.reject') }}",
                    data: {
                        meeting_id: meeting_id,
                        review: review
                    },
                    dataType: "json",
                    success: function (resp) {
                        if (resp.success) {
                            $("#reject_meeting_modal").modal("hide");
                            toastr.success(resp.message, 'Success');
                            tableLoad();
                        } else {
                            toastr.error(resp.message, 'Error');
                        }
                    }
                });
            }
        });

        $(document).on('change', '#review', function() {
            let review = $(this).val();

            if (review == '') {
                $('#err_review').show();
            } else {
                $('#err_review').hide();
            }
        });
    </script>
@endpush

<head>
    <link rel="icon" href="{{ getCourseImage(Settings('favicon')) }}" type="image/png" />
    <title>
        {{ Settings('site_title') ? Settings('site_title') : 'e-Latih LMS' }}
    </title>
</head>

<div class="modal fade admin-query" id="viewdetails">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('withdraw.Confirm') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" value="" name="type" id="type">
                <input type="hidden" value="{{ auth()->user()->role_id }}" name="auth_role" id="auth_role">

                <table id="list_table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('withdraw.Amount') }}</th>

                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 5)
                                <th scope="col">{{ __('common.Action') }}</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="payout_list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '.viewdetails', function() {
            let instructor_id = $(this).data('instructor_id');
            let id = $(this).data('withdraw_id');
            let type = $(this).data('type');
            let year = $(this).data('year');
            let month = $(this).data('month');
            let is_myll_admin = $(this).data('is_myll_admin');
            let tax = 1 + (is_myll_admin ? (1.0 * $(this).data('tax') / 100) : 0);

            $("#instructor_id").val(instructor_id);
            $("#withdraw_id").val(id);
            $("#type").val(type);
            $("#created_year").val(year);
            $("#created_month").val(month);

            $.ajax({
                url: "{{ route('admin.transaction_list_ajax') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    instructor_id: instructor_id,
                    type: type,
                    month: month,
                    year: year,
                    is_myll_admin: is_myll_admin
                },
                success: function(response) {
                    if (response.status === 1) {
                        $("#payout_list").empty();

                        var auth_role = $("#auth_role").val();

                        if (auth_role != 1 && auth_role != 5) {
                            $("#payout_list").append(
                                '<tr><td>' + (response.data.amount / tax).toFixed(2) + '</td>' +
                                '</tr>'
                            );
                        } else if (response.data.status === 0) {
                            $("#payout_list").append(
                                '<tr><td>' + (response.data.amount / tax).toFixed(2) + '</td>' +
                                '<td>' +
                                '<div class="dropdown CRM_dropdown">' +
                                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action </button>' +
                                '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">' +
                                '<a href="#" class="dropdown-item makeAsPaid" data-instructor_id="' +
                                response.data.instructor_ids + '" data-withdraw_id="' + response.data.id +
                                '" data-year="' + year + '" data-month="' + month + '" type="button">Make Paid</a>' +
                                '</div>' +
                                '</div>' +
                                '</td></tr>'
                            );
                        } else {
                            $("#payout_list").append(
                                '<tr><td>' + (response.data.amount / tax).toFixed(2) + '</td>' +
                                '<td>Paid</td></tr>'
                            );
                        }

                        setTimeout(function() {
                            $("#viewdetails").modal('show');
                        }, 500);
                    }
                },
                error: function(response) {
                    toastr.error('Something went wrong !')
                }
            });
        });
    </script>
@endpush

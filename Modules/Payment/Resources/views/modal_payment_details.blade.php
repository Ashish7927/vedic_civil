<div class="modal fade admin-query" id="viewPayMethod">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('setting.Payment Details')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr class="thead">
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="tbody">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '.viewPayMethod', function () {
            let id = $(this).data('withdraw_id');
            let method = "Bank Payment"; // $(this).data('withdraw_method');

            let header, body;
            if (method === "Bank Payment") {
                let name = $(this).data('bank_name');
                let acc_number = $(this).data('acc_number');
                let acc_holder = $(this).data('acc_holder');

                name = name === "" ? "User never provide bank name" : name;
                acc_number = acc_number === "" ? "User never provide bank account number" : acc_number;
                acc_holder = acc_holder === "" ? "User never provide bank account holder name" : acc_holder;

                header = "<th scope='col'>{{__('setting.Bank Name')}}</th>" +
                         "<th scope='col'>{{__('setting.Account Number')}}</th>" +
                         "<th scope='col'>{{__('setting.Account Holder')}}</th>";
                body = "<td>" + name + "</td>" +
                       "<td>" + acc_number + "</td>" +
                       "<td>" + acc_holder + "</td>";
            } else if (method === "Bkash") {
                let bkash = $(this).data('bkash');

                header = "<th scope='col'>{{__('Payment Method')}}</th>" +
                         "<th scope='col'>{{__('Bkash Number')}}</th>";
                body = "<td>" + method + "</td>" +
                       "<td>" + bkash + "</td>";
            } else {
                let email = $(this).data('email');

                header = "<th scope='col'>{{__('Payment Method')}}</th>" +
                         "<th scope='col'>{{__('Payment Email')}}</th>";
                body = "<td>" + method + "</td>" +
                       "<td>" + email + "</td>";
            }

            $(".thead").empty().append(header);
            $(".tbody").empty().append(body);
            $("#viewPayMethod").modal('show');
        });
    </script>
@endpush

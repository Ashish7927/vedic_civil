<script>
    function assign_certificate(package_id) {
        $("#certificate_list").empty();
        $.ajax({
            type: "POST",
            url: "{{ route('get_selected_certificate') }}",
            data: {
                package_id: package_id,
            },
            success: function (resp) {
                if (resp != "") {
                    $.each(resp, function(i, item) {
                        $("#certificate_list").append('<option value="'+item.id+'" selected>'+item.title+'</option>');
                    })
                }
            }
        });

        jQuery('#package_assign_to_multiple_users').modal('show', {
            backdrop: 'static'
        });

        $('#package_id').val(package_id);
    }
</script>
<style>
    .select2-container {
        z-index: 9999999999;
    }

    .loading-spinner {
        display: none;
    }

    .loading-spinner.active {
        display: inline-block;
    }
</style>
<div class="modal fade admin-query package-assing-multiple" id="package_assign_to_multiple_users">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('certificate.Assign Certificates To Package') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pt-0">
                    <form method="POST" id="assign_form">
                        <input type="hidden" name="package_id" id="package_id">
                        <div class="tab-content">
                            <div class="col-md-12 mt_20">
                                <select class="certificate_list" name="certificate_id" id="certificate_list"></select>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="mt-40 d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{ __('common.Cancel') }}</button>
                                <button type="button" id="certificate_assign_to_package"
                                    class="primary-btn semi_large2 fix-gr-bg" style="margin-left: 25px;">
                                    <span class="submit_btn_text">{{__('certificate.Assign Certificates To Package') }}</span> &nbsp;
                                    <i class="loading-spinner fa fa-lg fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            learners_managers();
        });

        learners_managers = () => {
            $("#certificate_list").select2({
                allowClear: true,
                placeholder: "Select Certificate",
                ajax: {
                    url: "{!! route('get_certificate_list') !!}",
                    type: "GET",
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
        }

        function loaderstop() {
            $('#certificate_assign_to_package').prop('disabled', false);
            $('.loading-spinner').removeClass('active');
        }

        function loaderstart() {
            $('#certificate_assign_to_package').prop('disabled', true);
            $('.loading-spinner').addClass('active');
        }


        $(document).on('click', '#certificate_assign_to_package', function() {
            var package_id = 0;
            package_id = $('#package_id').val();
            certificate_id = $('#certificate_list').val();
            loaderstart();
            $.ajax({
                url: "{!! route('assign_certificate') !!}",
                type: "POST",
                data: {
                    package_id: package_id,
                    certificate_id: certificate_id,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.success == true) {
                        $("#certificate_list").val(null).trigger("change");
                        $('#package_assign_to_multiple_users').modal('hide');
                        loaderstop();
                        toastr.success(data.message);
                    } else {
                        if (typeof(data.errors) != "undefined" && data.errors !== null) {
                            $.each(data.errors, function(i, item) {
                                loaderstop();
                                toastr.error(item);
                            })
                        } else {
                            loaderstop();
                            toastr.success(data.message);
                        }
                    }
                }
            });
        });
    </script>

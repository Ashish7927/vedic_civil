<script>
    function course_assign_to_learners(course_id) {
        jQuery('#course_assign_to_learners').modal('show', {
            backdrop: 'static'
        });

        $('#course_id').val(course_id);
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
<div class="modal fade admin-query course-assing-multiple" id="course_assign_to_learners">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Course to Multiple Learners</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pt-0">
                    <form method="POST" id="assign_form">
                        <input type="hidden" name="course_id" id="course_id">
                        <div class="tab-content">
                            <div class="col-md-12 mt_20">
                                <select class="learners_list" name="user_id[]" id="learners_list" multiple></select>
                            </div>
                        </div>

                        <div class="col-md-12 mt_20">
                            <p>Assignation Expiry Date</p>
                            <input type="date" name="due_date" id="due_date" class="primary_input_field">
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="mt-40 d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{ __('common.Cancel') }}</button>
                                <button type="button" id="assign_course_to_learners"
                                    class="primary-btn semi_large2 fix-gr-bg" style="margin-left: 25px;">
                                    <span class="submit_btn_text">Assign Course to Learner</span> &nbsp;
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
        $(document).ready(function() {
            course_learner_list();
        });

        course_learner_list = () => {
            var url = "{{ route('course_learner_list') }}";
            $("#learners_list").select2({
                allowClear: true,
                placeholder: "Type email to select learner",
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            course_id: $('#course_id').val()
                        }
                    },
                    cache: true
                }
            });
        }

        function loaderstart() {
            $('#assign_course_to_learners').prop('disabled', true);
            $('.loading-spinner').addClass('active');
        }

        function loaderstop() {
            $('#assign_course_to_learners').prop('disabled', false);
            $('.loading-spinner').removeClass('active');
        }

        $(document).on('click', '#assign_course_to_learners', function() {
            let user_id = 0;
            let course_id = 0;
            let due_date = $('#due_date').val();

            user_id = $('#learners_list').val();
            course_id = $('#course_id').val();

            loaderstart();

            $.ajax({
                url: "{!! route('assign_course_to_learners') !!}",
                type: "POST",
                data: {
                    user_id: user_id,
                    course_id: course_id,
                    due_date: due_date,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        $("#learners_list").val(null).trigger("change");
                        $('#course_assign_to_learners').modal('hide');
                        tableLoad();
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

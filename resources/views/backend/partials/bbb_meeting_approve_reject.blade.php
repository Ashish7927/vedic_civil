<script>
    function approve_meeting_modal(meeting_id) {
        $('.meeting_id').val(meeting_id);

        jQuery('#approve_meeting_modal').modal('show', {
            backdrop: 'static'
        });
    }

    function reject_meeting_modal(meeting_id) {
        $('.meeting_id').val(meeting_id);

        jQuery('#reject_meeting_modal').modal('show', {
            backdrop: 'static'
        });
    }
</script>

<div class="modal fade admin-query" id="approve_meeting_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('bbb.Approve Meeting Confirmation') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="meeting_id">
                <h3 class="text-center">{{ __('bbb.Are you sure to approve this meeting ?') }}</h3>

                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.Cancel')}}</button>
                        <a id="btn_approve_confirm" class="primary-btn semi_large2 fix-gr-bg">{{ __('bbb.Approve') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade admin-query" id="reject_meeting_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('bbb.Reject Meeting Confirmation') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="meeting_id">

                <div class="row">
                    <div class="col-md-12">
                        <textarea id="review" class="primary_input_field tooltip_class" style="width: 100%; min-height: 155px" placeholder="Enter Review" required></textarea>
                        <span class="text-danger" id="err_review" style="display: none;">Review field is required.</span>
                    </div>
                </div>

                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.Cancel')}}</button>
                        <a id="btn_reject_confirm" class="primary-btn semi_large2 fix-gr-bg">{{__('bbb.Reject')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

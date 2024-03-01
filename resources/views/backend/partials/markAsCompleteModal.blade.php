<script>
    function confirm_modal_mark_as_complete(mark_as_complete_url) {
        jQuery('#confirm-mark-as-complete').modal('show', {backdrop: 'static'});
        document.getElementById('mark_as_complete_link').setAttribute('href', mark_as_complete_url);
    }
</script>

<div class="modal fade admin-query" id="confirm-mark-as-complete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Mark as complete') }} {{__('common.Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">{{__('common.Are you want to mark as Complete ?')}}</h3>

                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                        <a id="mark_as_complete_link" class="primary-btn semi_large2 fix-gr-bg">{{__('common.Submit')}}</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

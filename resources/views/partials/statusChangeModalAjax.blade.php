<div class="modal fade statusChangeAdvocateItemModal" id="statusChangeAdvocateItemModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.Approve') </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.Are you sure to Approve ?')</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.Cancel')</button>
                    <form id="item_change_form" action="">
                        <input type="hidden" name="status" id="status">
                        <input type="hidden" name="client_id" id="client_id">
                        <button class="primary-btn fix-gr-bg submit" type="submit" >@lang('common.Approve')</button>
                        <button class="primary-btn fix-gr-bg submitting" disabled type="button" style="display: none;" >@lang('common.Approving')</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade changeStatusModal" id="changeStatusModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.Change Status') </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.Are you sure to change status ?')</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.Cancel')</button>
                    <form id="change_status_form" action="">
                        @method('delete')
                        <button class="primary-btn fix-gr-bg submit" type="submit" >@lang('common.Change Status')</button>
                        <button class="primary-btn fix-gr-bg submitting" disabled type="button" style="display: none;" >@lang('common.Changing Status')</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

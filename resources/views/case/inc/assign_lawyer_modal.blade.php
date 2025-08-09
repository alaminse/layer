<div class="modal fade admin-query assignLawyerModal" id="assignLawyerModal">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('case.Assign Staff/Lawyer') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                {!! Form::open(['route' => 'case.assign-staff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <input type="hidden" name="case_id" id="case_id">

                <div class="row">
                    <div class="primary_input col-md-12">

                        <div class="d-flex justify-content-between">

                            <label for="staff_id">
                                <span class="mr-4">{{ __('case.Assign Staff') }}</span>
                            </label>
                        </div>
                        {{ Form::select('staff_ids[]', $staffs, null, ['class' => 'primary_select', 'data-placeholder' => __('case.Select Staff'), 'data-parsley-errors-container' => '#staff_id_error', 'multiple', 'id' => 'staff_id']) }}
                        <span id="staff_id_error"></span>
                    </div>

                </div>

                <div class="col-lg-12 text-center pt_15">
                    <div class="d-flex justify-content-center">
                        <button class="primary-btn semi_large2  fix-gr-bg saveScheduleButton" id="saveScheduleButton"
                            type="submit"><i class="ti-check"></i> {{ __('common.Assign') }}
                        </button>

                        <button class="primary-btn semi_large2  fix-gr-bg d-none" type="button" disabled
                            id="savingButton">
                            {{ __('common.Saving') }}....
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="sr-only"></span>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

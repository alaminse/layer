@extends('layouts.master', ['title' => __('case.Create New Case')])

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{ __('case.Add New Case') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">

                        {!! Form::open(['route' => 'case.store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => false, 'method' => 'POST']) !!}
                        <input type="hidden" id="type" value="{{ isset($clientCaseModel) ? ($clientCaseModel->type=='plaintiff' ? 'petitioner':'respondent') : 'petitioner' }}">
                        <input type="hidden" name="client_case_id" value="{{ isset($clientCaseModel) ? $clientCaseModel->id : null }}">
                        <div class="row">
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">
                                    {{ Form::label('client_id', __('case.Select Client'), ['class' => 'required']) }}
                                    @can('client.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('client.create', ['quick_add' => true, 'client_id' => true]) }}"
                                                class="btn-modal"
                                                data-container="client_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('client_id', $data['clients']->prepend(__('case.Select Client'), ''), isset($clientCaseModel)? $clientCaseModel->created_by:null, ['required' => '', 'id'=>'client_id', 'class' => 'primary_select', 'data-placeholder' => __('case.Select Client'), 'data-parsley-errors-container' => '#client_id_error']) }}
                                <span id="client_id_error"></span>
                            </div>
                            <div class="primary_input col-md-6 mt-45">
                                <div class="row">
                                    <div class="primary_input col-md-6">
                                        <div class="form-check">
                                            <label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" class="complete_order0 PetRes" id="complete_order0"
                                                    name="type" value="petitioner"
                                                    {{isset($clientCaseModel) ? ($clientCaseModel->type=='plaintiff' ? 'checked':''):'checked'}}
                                                    >
                                                <span class="checkmark mr-2"></span> {{ __('case.petitioner') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="primary_input col-md-6">
                                        <div class="form-check">
                                            <label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" class="complete_order0 PetRes" id="complete_order0"
                                                    name="type" value="respondent" {{isset($clientCaseModel) ? ($clientCaseModel->type !='plaintiff' ? 'checked':''):''}}>
                                                <span class="checkmark mr-2"></span> {{ __('case.respondent') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-5">
                                <label for="" class="p_r_name">{{ __('case.Respondent Name') }}</label>
                                {{ Form::text('p_r_name[]', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Name')]) }}
                            </div>
                            <div class="primary_input col-md-5">
                                <label for="" class="p_r_advocate">{{ __('case.Respondent Advocate') }}</label>
                                {{ Form::text('p_r_advocate[]', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Advocate')]) }}
                            </div>
                        </div>
                        <div id="addMoreDiv">

                        </div>
                        <div class="row mt-25 mb-25 ml-0">
                            <button class="primary-btn radius_30px mr-10 fix-gr-bg " type="button" id="addMoreButton">
                                <i class="ti-plus"></i>
                                {{ __('case.Add More') }}
                            </button>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-12">
                                {{ Form::label('title', __('case.Title'),['class' => 'required']) }}
                                {{ Form::text('title', null, ['required'=>true, 'class' => 'primary_input_field', 'placeholder' => __('case.Title')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                <div class="d-flex justify-content-between">
                                    {{ Form::label('case_category_id', __('case.Case Category'), ['class' => 'required']) }}
                                    @can('category.case.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('category.case.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="case_category_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>

                                {{ Form::select('case_category_id', $data['case_categories'], isset($clientCaseModel)?$clientCaseModel->case_category_id : null, ['required' => '', 'class' => 'primary_select', 'data-placeholder' => __('case.Select Case Category'), 'data-parsley-errors-container' => '#case_category_id_error']) }}
                                <span id="case_category_id_error"></span>
                            </div>

                            {{-- Sub Category Start --}}
                            <div class="primary_input col-md-6">
                                <div class="d-flex justify-content-between">
                                    {{ Form::label('case_sub_category_id', 'Case Sub Category') }}
                                    @can('category.subcase.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('category.subcase.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="case_sub_category_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>

                                {{ Form::select('case_sub_category_id', $data['case_sub_categories'], isset($clientCaseModel)?$clientCaseModel->case_sub_category_id : null, ['required' => '', 'class' => 'primary_select', 'data-placeholder' => 'Select Sub Case Category', 'data-parsley-errors-container' => '#case_sub_category_id_error']) }}
                                <span id="case_sub_category_id_error"></span>
                            </div>
                            {{-- Sub Category End --}}

                            <div class="primary_input col-md-6">
                                {{ Form::label('case_no', __('case.Case No')) }}
                                {{ Form::text('case_no', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Case No')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('file_no', __('case.Case File No')) }}
                                {{ Form::text('file_no', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Case File No')]) }}
                            </div>
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">
                                    {{ Form::label('acts', __('case.Case Acts'), ['class' => 'required']) }}
                                    @can('master.act.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('master.act.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="act_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('acts[]', $data['acts'], null, ['required' => '', 'class' => 'primary_select', 'data-placeholder' => __('case.Select Acts'), 'data-parsley-errors-container' => '#act_error', 'multiple' => '', 'id' => 'acts']) }}
                                <span id="act_error"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">
                                    {{ Form::label('court_category_id', __('case.Court Category'), ['class' => 'required']) }}
                                    @can('category.court.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('category.court.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="court_category_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('court_category_id', $data['court_categories'], null, ['required' => '', 'class' => 'primary_select', 'data-placeholder' => __('case.Select Court Category'), 'data-parsley-errors-container' => '#court_category_id_error']) }}
                                <span id="court_category_id_error"></span>
                            </div>
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">
                                    {{ Form::label('court_id', __('case.Court'), ['class' => 'required']) }}
                                    @can('master.court.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('master.court.create', ['quick_add' => true]) }}"
                                                class="btn-modal" data-depend="#court_category_id"
                                                data-depend_text="{{ __('court.Please Select Court Category First') }}"
                                                data-container="court_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('court_id', $data['courts'], null, ['required' => '', 'class' => 'primary_select', 'data-placeholder' => __('case.Select Court'), 'data-parsley-errors-container' => '#court_id_error']) }}
                                <span id="court_id_error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('ref_name', __('case.Reference Name')) }}
                                {{ Form::text('ref_name',  isset($clientCaseModel)?$clientCaseModel->ref_name : null, ['class' => 'primary_input_field', 'placeholder' => __('case.Reference Name')]) }}
                            </div>
                            <div class="primary_input col-md-6">
                                {{ Form::label('ref_mobile', __('case.Reference Mobile')) }}
                                {{ Form::number('ref_mobile', isset($clientCaseModel)?$clientCaseModel->ref_mobile : null, ['class' => 'primary_input_field', 'placeholder' => __('case.Reference Mobile')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">

                                    <label for="lawyer_id">
                                        <span class="mr-4">{{ __('case.Opposite Lawyer') }}</span>
                                        @if (moduleStatusCheck('EmailtoCL'))
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="send_email_to_lawyer"
                                                    id="send_email_to_lawyer" value="1">
                                                {{ __('case.Send Mail To Lawyer') }}
                                            </label>
                                        @endif
                                    </label>

                                    @can('lawyer.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('lawyer.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="lawyer_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('lawyer_id[]', $data['lawyers'], null, ['class' => 'primary_select', 'data-placeholder' => __('case.Select Lawyer'), 'data-parsley-errors-container' => '#lawyer_id_error', 'multiple', 'id' => 'lawyer_id']) }}
                                <span id="lawyer_id_error"></span>
                            </div>
                            <div class="primary_input col-md-6">

                                <div class="d-flex justify-content-between">
                                    {{ Form::label('stage_id', __('case.Case Stage')) }}
                                    @can('master.stage.store')
                                        <label class="primary_input_label green_input_label" for="">
                                            <a href="{{ route('master.stage.create', ['quick_add' => true]) }}"
                                                class="btn-modal"
                                                data-container="case_stage_add_modal">{{ __('case.Create New') }}
                                                <i class="fas fa-plus-circle"></i></a></label>
                                    @endcan
                                </div>
                                {{ Form::select('stage_id', $data['stages'], isset($clientCaseModel)?$clientCaseModel->stage_id : null, ['class' => 'primary_select', 'data-placeholder' => __('case.Select Case Stage'), 'data-parsley-errors-container' => '#stage_id_error']) }}
                                <span id="stage_id_error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-12">
                                {{ Form::label('case_charge', __('case.Case Charge')) }}
                                {{ Form::text('case_charge', 0, ['class' => 'primary_input_field', 'placeholder' => __('case.Case Charge')]) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-12">

                                <div class="d-flex justify-content-between">

                                    <label for="staff_id">
                                        <span class="mr-4">{{ __('case.Assign Staff') }}</span>
                                    </label>
                                </div>
                                {{ Form::select('staff_ids[]', $data['staffs'], null, ['class' => 'primary_select', 'data-placeholder' => __('case.Select Staff'), 'data-parsley-errors-container' => '#staff_id_error', 'multiple', 'id' => 'staff_id']) }}
                                <span id="staff_id_error"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('receiving_date', __('case.Receiving Date')) }}
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="receiving_date_yes"
                                            id="receiving_date_yes">
                                        {{ __('case.Add Receive Date') }}
                                    </label>
                                </div>
                                {{ Form::text('receiving_date', date('Y-m-d H:i'), ['style' => 'display:none;', 'class' => 'primary_input_field primary-input form-control datetime', 'id' => 'receiving_date', 'placeholder' => __('case.Date')]) }}
                            </div>
                            <div class="primary_input col-md-6">
                                {{ Form::label('filling_date', __('case.Filing Date')) }}
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="filling_date_yes"
                                            id="filling_date_yes">
                                        {{ __('case.Add Filing Date') }}
                                    </label>
                                </div>
                                {{ Form::text('filling_date', date('Y-m-d H:i'), ['style' => 'display:none;', 'class' => 'primary_input_field primary-input form-control datetime', 'id' => 'filling_date', 'placeholder' => __('case.Date')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('hearing_date', __('case.Hearing Date')) }}
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="hearing_date_yes"
                                            id="hearing_date_yes">
                                        {{ __('case.Add Hearing Date') }}
                                    </label>
                                </div>
                                {{ Form::text('hearing_date', date('Y-m-d H:i'), ['style' => 'display:none;', 'class' => 'primary_input_field primary-input form-control datetime', 'id' => 'hearing_date', 'placeholder' => __('case.Date')]) }}
                            </div>
                            <div class="primary_input col-md-6">
                                {{ Form::label('judgement_date', __('case.Judgement Date')) }}
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="judgement_date_yes"
                                            id="judgement_date_yes">
                                        {{ __('case.Add Judgement Date') }}
                                    </label>
                                </div>
                                {{ Form::text('judgement_date', date('Y-m-d H:i'), ['style' => 'display:none;', 'class' => 'primary_input_field primary-input datetime form-control', 'id' => 'judgement_date', 'placeholder' => __('case.Date')]) }}
                            </div>
                        </div>

                        <div class="primary_input" id="hearing_date_row" style="display: none;">
                            {{ Form::label('hearing_date_description', __('case.Hearing Date Description'), ['class' => 'required']) }}
                            {{ Form::textarea('hearing_date_description', null, ['class' => 'primary_textarea', 'placeholder' => __('case.Hearing Date Description'), 'rows' => 5, 'data-parsley-errors-container' => '#hearing_date_description_error', 'id' => 'hearing_date_description']) }}
                            <span id="hearing_date_description_error"></span>
                        </div>
                        <div class="primary_input" id="judgement_row" style="display: none;">
                            {{ Form::label('judgement', __('case.Judgement'), ['class' => 'required']) }}
                            {{ Form::textarea('judgement', null, ['class' => 'primary_textarea', 'placeholder' => __('case.Judgement'), 'rows' => 5, 'data-parsley-errors-container' => '#judgement_error', 'id' => 'judgement']) }}
                            <span id="judgement_error"></span>
                        </div>
                        @includeIf('customfield::fields', ['fields' => $fields, 'model' => null])
                        <div class="primary_input">
                            {{ Form::label('description', __('case.Case Description')) }}
                            {{ Form::textarea('description', isset($clientCaseModel) ? $clientCaseModel->description : null, [
                                'class' => 'primary_input_field summernote',
                                'placeholder' => __('case.Case Description'),
                                'rows' => 5,
                                'data-parsley-errors-container' => '#description_error',
                            ]) }}
                            <span id="description_error"></span>
                        </div>

                        @if(isset($clientCaseModel))
                            @includeIf('case.file',['files'=>$clientCaseModel->clientsFiles])
                        @else
                            @includeIf('case.file')
                        @endif

                        <div class="text-center mt-3">
                            <button class="primary_btn_large submit" type="submit"><i
                                    class="ti-check"></i>{{ __('common.Create') }}
                            </button>

                            <button class="primary_btn_large submitting" type="submit" disabled style="display: none;">
                                <i class="ti-check"></i>{{ __('common.Creating') . '...' }}
                            </button>

                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade animated act_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1" role="dialog"
        aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated client_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1" role="dialog"
        aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated client_category_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1"
        role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated lawyer_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1" role="dialog"
        aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated case_stage_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1"
        role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="modal fade animated court_category_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1"
        role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated court_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1" role="dialog"
        aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="modal fade animated case_category_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1"
        role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="modal fade animated case_sub_category_add_modal infix_advocate_modal" id="remote_modal" tabindex="-1"
        role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    </div>

    <div class="modal fade animated file_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog"
    aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>
@stop
@push('admin.scripts')
    <script>
        $(document).ready(function() {
            var type = $('#type').val();
             changeType(type);
            _formValidation();
            _componentAjaxChildLoad('#content_form', '#court_category_id', '#court_id', 'court');
            $(document).on('click', '#hearing_date_yes', function() {
                if (this.checked) {
                    $('#hearing_date').show();
                    $('#hearing_date_row').show();
                    $('#hearing_date_description').attr('required', true);
                } else {
                    $('#hearing_date').hide();
                    $('#hearing_date_row').hide();
                    $('#hearing_date_description').attr('required', false);
                }
            });

            $(document).on('click', '#filling_date_yes', function() {
                if (this.checked) {
                    $('#filling_date').show();
                } else {
                    $('#filling_date').hide();
                }
            });

            $(document).on('click', '#judgement_date_yes', function() {
                if (this.checked) {
                    $('#judgement_date').show();
                    $('#judgement_row').show();
                    $('#judgement').attr('required', true);
                } else {
                    $('#judgement_date').hide();
                    $('#judgement_row').hide();
                    $('#judgement').attr('required', false);
                }
            });

            $(document).on('click', '#receiving_date_yes', function() {
                if (this.checked) {
                    $('#receiving_date').show();
                } else {
                    $('#receiving_date').hide();
                }
            });
            $(document).on('click', '.PetRes', function() {
                if ($(this).val() == 'petitioner') {
                    $('.p_r_name').html('{{ __("case.Respondent Name") }}');
                    $('.p_r_advocate').html('{{ __('case.Respondent Advocate') }}');
                } else {
                    $('.p_r_name').html('{{ __("case.Petitioner Name") }}');
                    $('.p_r_advocate').html('{{ __("case.Petitioner Advocate") }}');
                }
                $('#type').val($(this).val());
            })
            $(document).on('click', '#addMoreButton', function() {
                var type = $('#type').val();
                changeType(type);

            })
            function changeType(type) {

                if (type == 'petitioner') {
                    var name = '{{ __("case.Respondent Name") }}';
                    var advocate = '{{ __('case.Respondent Advocate') }}';
                } else {
                    var name = '{{ __("case.Petitioner Name") }}';
                    var advocate = '{{ __("case.Petitioner Advocate") }}';
                }

                var addMore = `<div class="row">
                            <div class="primary_input col-md-5">
                                <label for="" class="p_r_name">${name}</label>
                                {{ Form::text('p_r_name[]', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Name')]) }}
                            </div>
                            <div class="primary_input col-md-5">
                                <label for="" class="p_r_advocate">${advocate}</label>
                                {{ Form::text('p_r_advocate[]', null, ['class' => 'primary_input_field', 'placeholder' => __('case.Advocate')]) }}
                            </div>
                <div class="primary_input col-md-2 mt-45">
                    <button class="removeBtn primary-btn icon-only fix-gr-bg fl-r"
                        type="button">
                        <span class="ti-trash"></span> </button>
                </div></div>`;
                $('#addMoreDiv').append(addMore);
            }
            $(document).on('click', '.removeBtn', function() {
                $(this).parent().parent().remove();
            })
        });

        _componentAjaxChildLoad('#client_quick_add_form', '#country_id', '#state_id', 'state')
        _componentAjaxChildLoad('#client_quick_add_form', '#state_id', '#city_id', 'city')

        _componentAjaxChildLoad('#court_quick_add_form', '#country_id', '#state_id', 'state')
        _componentAjaxChildLoad('#court_quick_add_form', '#state_id', '#city_id', 'city')
    </script>
@endpush

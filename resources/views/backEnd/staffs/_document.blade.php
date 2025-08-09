
@php

    $files = $staffDetails->registerLawyerDocument ? $staffDetails->registerLawyerDocument->lawyerFiles : null;
@endphp
<div role="tabpanel" class="tab-pane fade" id="document">
    <div class="white-box">
        <div class="QA_section QA_section_heading_custom check_box_table">
            <div class="QA_table ">
                @if ($files)
                    @foreach ($files as $item)
                        <div class="single-meta">
                            <div class="col-xl-12 mt-3 ">
                                <div class="attach-file-section d-flex align-items-center mb-2">
                                    <div class="primary_input flex-grow-1">
                                        <div class="primary_file_uploader">
                                           <h4 class="pt-10">{{ $item->title ?? $item->user_filename }}</h4>
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg">
                                                    <div class="name btn-modal flex-grow-1  btn-modal" data-container="file_modal" data-href="{{ route('file.show', $item->uuid) }}" style="cursor: pointer;">
                                                       {{ __('common.View') }}
                                                    </div>
                                                 </label>
                                                <input type="file" class="d-none" value="{{ $item->filepath }}" name="clinetfiles[]" id="attach_file_{{ $item->id + 100 }}">
                                            </button>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade animated file_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog"
aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>
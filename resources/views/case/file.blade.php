@if (isset($files))
    @foreach ($files as $item)
        <div class="col-xl-12 mt-3 ">
            <div class="attach-file-section d-flex align-items-center mb-2">
                <div class="primary_input flex-grow-1">
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="placeholderStaffsName"
                            placeholder="{{ $item->user_filename }}" readonly>
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
    @endforeach
@endif
<div class="col-xl-12 mt-3 attach-file-row">
    <div class="attach-file-section d-flex align-items-center mb-2">
        <div class="primary_input flex-grow-1">
            <div class="primary_file_uploader">
                <input class="primary-input" type="text" id="placeholderAttachFile"
                    placeholder="{{ __('common.Browse file') }}" readonly>
                <button class="" type="button">
                    <label class="primary-btn small fix-gr-bg" for="attach_file">{{ __('common.Browse') }} </label>
                    <input type="file" class="d-none" name="file[]" id="attach_file" multiple>
                </button>
            </div>
        </div>
    </div>
</div>

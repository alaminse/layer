<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        {{ __('common.Select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
        aria-labelledby="dropdownMenu2">
        <a href="{{ route('case.show', $model->id) }}"
            class="dropdown-item"><i class="icon-file-eye"></i>
            {{ __('common.View') }}</a>            
        @if($model->judgement_status != 'Close')
        <a href="#" class="dropdown-item assignLawyer" data-case_id="{{ $model->id }}" data-modal-size="modal-md">
            {{ __('case.Assign Staff/Lawyer') }}</a>
            @endif
        @if (!$model->judgement)
            @if (permissionCheck('case.edit'))
                <a href="{{ route('case.edit', $model->id) }}"
                    class="dropdown-item"><i
                        class="icon-pencil mr-2"></i>{{ __('common.Edit') }}
                </a>
            @endif
            @if (permissionCheck('date.store'))
                <a href="{{ route('date.create', ['case' => $model->id]) }}"
                    class="dropdown-item"><i
                        class="icon-calendar3 mr-2"></i>{{ __('case.New Date') }}
                </a>
            @endif
            @if (permissionCheck('putlist.store'))
                <a href="{{ route('putlist.create', ['case' => $model->id]) }}"
                    class="dropdown-item"><i
                        class="icon-calendar3 mr-2"></i>{{ __('case.New Put Up Date') }}
                </a>
            @endif
            @if (permissionCheck('lobbying.store'))
                <a href="{{ route('lobbying.create', ['case' => $model->id]) }}"
                    class="dropdown-item"><i
                        class="icon-calendar3 mr-2"></i>{{ __('case.New Lobbying Date') }}
                </a>
            @endif
            @if (permissionCheck('judgement.store'))
                <a href="{{ route('judgement.create', ['case' => $model->id]) }}"
                    class="dropdown-item"><i
                        class="icon-calendar3 mr-2"></i>{{ __('case.New Judgement Date') }}
                </a>
            @endif
        @endif
        @if (permissionCheck('case.destroy'))
            <span id="delete_item" data-id="{{ $model->id }}"
                data-url="{{ route('case.destroy', $model->id) }}"
                class="dropdown-item"><i class="icon-trash"></i>
                {{ __('common.Delete') }}
            </span>
        @endif

    </div>
</div>
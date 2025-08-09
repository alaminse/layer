<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ __('common.Select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
    <a href="{{ route('case.show', $model->id) }}" class="dropdown-item"><i
            class="icon-file-eye"></i> {{ __('common.View') }}</a>
    <span id="delete_item" data-id="{{ $model->id }}" data-url="{{ route
        ('case.destroy', $model->id)
    }}" class="dropdown-item"><i class="icon-trash"></i> {{ __('common.Delete') }}
    </span>

    </div>
</div>
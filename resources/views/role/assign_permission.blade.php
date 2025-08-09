@extends('layouts.master', ['title' => 'Permission'])

@section('mainContent')
    <link rel="stylesheet" href="{{ asset('public/backEnd/css/role_module_style.css') }}">

    <div class="role_permission_wrap">
        <div class="permission_title">
            <h4>@lang('role.Assign Permission') ({{ @$role->name }})</h4>
        </div>
    </div>

    {{ Form::open(['class' => 'form-horizontal', 'route' => 'roles.assign.permission', 'method' => 'POST']) }}
    <div class="erp_role_permission_area">
        <input type="hidden" name="role_id" value="{{ @$role->id }}">

        <div class="mesonary_role_header">
            @foreach ($permissions as $groupName => $groupPermissions)
                <div class="single_role_blocks">
                    <div class="single_permission" id="{{ $groupName }}">
                        <div class="permission_header d-flex align-items-center justify-content-between">
                            <div>
                                <input type="checkbox"
                                    class="common-radio permission-checkAll main_permission_id_{{ $groupName }}"
                                    id="Main_Module_{{ $groupName }}" data-group="{{ $groupName }}">
                                <label for="Main_Module_{{ $groupName }}">{{ ucfirst($groupName) }} Permissions</label>
                            </div>
                        </div>

                        <div class="permission_body">
                            <ul>
                                @foreach ($groupPermissions as $permission)
                                    <li>
                                        <div class="submodule">
                                            <input type="checkbox" name="permission_id[]" value="{{ $permission->name }}"
                                                class="infix_csk common-radio permission_id_{{ $groupName }} module_link"
                                                id="Sub_Module_{{ $permission->id }}"
                                                {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                            <label for="Sub_Module_{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-40">
            <div class="col-lg-12 text-center">
                <button class="primary-btn fix-gr-bg">
                    <span class="ti-check"></span>
                    @lang('common.Submit')
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}


    @push('scripts')
        <script>
            $('.permission-checkAll').on('click', function() {
                let group = $(this).data('group');
                $('.permission_id_' + group).prop('checked', $(this).is(':checked'));
            });

            $('.module_link').on('change', function() {
                let group = $(this).attr('class').match(/permission_id_(\w+)/)[1];
                let all = $('.permission_id_' + group).length;
                let checked = $('.permission_id_' + group + ':checked').length;
                $('#Main_Module_' + group).prop('checked', all === checked);
            });
        </script>
    @endpush
@endsection

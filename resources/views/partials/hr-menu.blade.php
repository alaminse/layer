{{-- @if (permissionCheck('human_resource')) --}}
@php
    $staffs = ['staffs.index', 'staffs.edit', 'staffs.view', 'staffs.create'];
    $roles = [
        'permission.roles.index',
        'permission.roles.edit',
        'permission.roles.view',
        'permission.roles.create',
        'permission.permissions.index',
    ];
    $events = ['events.index', 'events.edit', 'events.view', 'events.create'];
    $payroll = [
        'payroll.index',
        'payroll.edit',
        'payroll.view',
        'payroll.create',
        'genrate_payroll',
        'staff_search_for_payroll',
    ];
    $pedningStaff = ['registration.lawyer.pending', 'registration.lawyer.approve', 'registration.lawyer.show'];

    $nav = array_merge(['roles', 'permissions', 'organizations', 'subscriptions']);
@endphp


@php
    $isNavActive = Route::is('roles.*', 'permissions.*', 'organizations.*', 'subscriptions.*');
@endphp

<li class="{{ $isNavActive ? 'mm-active' : '' }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $isNavActive ? 'true' : 'false' }}">

        <div class="nav_icon_small">
            <span class="fas fa-users"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('common.Human Resource') }}</span>
        </div>
    </a>
    <ul>
        {{-- @if (moduleStatusCheck('Registration') && permissionCheck('registration.lawyer.pending')) --}}
        @if (moduleStatusCheck('Registration'))
            <li>
                <a href="{{ route('registration.lawyer.pending') }}"
                    class="{{ spn_active_link($pedningStaff, 'active') }}">


                    {{ __('common.Pending Lawyer') }}
                    @if (config('app.app_sync'))
                        <span class="demo_addons addon mr-4"> Addon </span>
                    @endif


                </a>
            </li>
        @endif
        {{-- @if (permissionCheck('staffs.index')) --}}
        <li>
            <a href="{{ route('staffs.index') }}"
                class="{{ spn_active_link($staffs, 'active') }}">{{ __('common.Staff') }}</a>
        </li>
        {{-- @endif --}}
        {{-- @if (permissionCheck('permission.roles.index')) --}}

        @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
            <li>
                <a href="{{ route('roles.index') }}"
                    class="{{ Route::is('roles.*') ? 'active' : '' }}">{{ __('role.Role') }}</a>
            </li>
        @endcan
        @canany(['permission-list', 'permission-create', 'permission-edit', 'permission-delete'])
            <li>
                <a href="{{ route('permissions.index') }}"
                    class="{{ Route::is('permissions.*') ? 'active' : '' }}">Permissions</a>
            </li>
        @endcan
        @canany(['organization-list', 'organization-create', 'organization-edit', 'organization-delete'])
            <li>
                <a href="{{ route('organizations.index') }}"
                    class="{{ Route::is('organizations.*') ? 'active' : '' }}">Organization</a>
            </li>
        @endcan
        @canany(['subscription-list', 'subscription-create', 'subscription-edit', 'subscription-delete'])
            <li>
                <a href="{{ route('subscriptions.index') }}" class="{{ Route::is('subscriptions.*') ? 'active' : '' }}">
                    Subscription
                </a>
            </li>
        @endcan
        {{-- @endif --}}

        {{-- @if (permissionCheck('attendances.index')) --}}
        <li>
            <a href="{{ route('attendances.index') }}"
                class="{{ spn_active_link('attendances.index', 'active') }}">{{ __('attendance.Attendance') }}</a>
        </li>
        {{-- @endif --}}
        {{-- @if (permissionCheck('attendance_report.index')) --}}
        <li>
            <a href="{{ route('attendance_report.index') }}"
                class="{{ spn_active_link(['attendance_report.index', 'attendance_report.search'], 'active') }}">{{ __('attendance.Attendance Report') }}</a>
        </li>
        {{-- @endif --}}
        {{-- @if (permissionCheck('events.index')) --}}
        <li>
            <a href="{{ route('events.index') }}"
                class="{{ spn_active_link($events, 'active') }}">{{ __('event.Event') }}</a>
        </li>
        {{-- @endif --}}

        {{-- @if (permissionCheck('payroll.index')) --}}
        <li>
            <a href="{{ route('payroll.index') }}"
                class="{{ spn_active_link($payroll, 'active') }}">{{ __('payroll.Payroll') }}</a>
        </li>
        {{-- @endif --}}
        {{-- @if (permissionCheck('payroll_reports.index')) --}}
        <li>
            <a href="{{ route('payroll_reports.index') }}"
                class="{{ spn_active_link(['payroll_reports.index', 'payroll_reports.search'], 'active') }}">{{ __('payroll.Payroll Reports') }}</a>
        </li>
        {{-- @endif --}}

    </ul>
</li>
{{-- @endif --}}

@extends('layouts.master', ['title' => 'Organization'])
@section('mainContent')
    <section class="admin-visitor-area up_admin_visitor">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header xs_mb_0">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Organization List</h3>
                        <ul class="d-flex">
                            @can('organization-create')
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                        href="{{ route('organizations.create') }}"><i class="ti-plus"></i>New
                                        Organization</a></li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-20">
                <div class="QA_section QA_section_heading_custom check_box_table SplitDivTable">
                    <div class="QA_table">
                        <div class="mt-30">
                            <table class="table Crm_table_active3">
                                <thead>
                                    @include('backEnd.partials.alertMessagePageLevelAll')
                                    <tr>
                                        <th>@lang('common.Name')</th>
                                        <th>@lang('common.Email')</th>
                                        <th>@lang('common.Phone')</th>
                                        <th>@lang('common.Address')</th>
                                        <th>@lang('common.Status')</th>
                                        <th>@lang('common.Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($organizations as $org)
                                        <tr>
                                            <td>{{ $org->name }}</td>
                                            <td>{{ $org->user?->email }}</td>
                                            <td>{{ $org->phone }}</td>
                                            <td>{{ $org->address }}</td>
                                            <td>
                                                @if ($org->status == 1)
                                                    <span class="badge badge-success">{{ __('common.Active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('common.Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center flex-wrap">
                                                    <div class="dropdown CRM_dropdown d-inline ml-1">
                                                        <button class="btn btn-secondary dropdown-toggle mb-1"
                                                            type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenu2">
                                                            @can('organization-show')
                                                                <a href="{{ route('organizations.show', $org->id) }}" class="dropdown-item">@lang('common.Show')</a>
                                                            @endcan
                                                            @can('organization-edit')
                                                                <a href="{{ route('organizations.edit', $org->id) }}"
                                                                    class="dropdown-item">@lang('common.Edit')</a>
                                                            @endcan
                                                            @can('organization-delete')
                                                            <a href="#" class="dropdown-item" type="button"
                                                                data-toggle="modal"
                                                                data-target="#deleteItem_{{ $org->id }}">@lang('common.Delete')</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Include delete modal --}}
                                                @include('backEnd.partials.deleteModalMessage', [
                                                    'item_id' => $org->id,
                                                    'item_name' => 'Organization',
                                                    'route_url' => route('organizations.destroy', $org->id),
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

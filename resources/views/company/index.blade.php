@extends('layouts.master', ['title' => __('client.Company')])

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header xs_mb_0">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('client.Company List') }}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('company.store'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="{{ route('company.create') }}"><i class="ti-plus"></i>{{ __
                        ('client.New Company') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.SL') }}</th>
                                        <th>{{ __('client.Company') }}</th>
                                        <th>{{ __('client.Contact') }}</th>
                                        <th>{{ __('client.Category') }}</th>
                                        <th>{{ __('client.Address') }}</th>
                                        <th>{{ __('common.Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companies as $model)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('company.show', $model->id) }}">{{ $model->name }}</a>
                                            </td>
                                            <td>
                                                {{ __('client.Mobile') }}: {{ $model->mobile }} <br>
                                                {{ __('client.Email') }}: {{ $model->email }}
                                            </td>
                                            <td>{{ @$model->category->name }}</td>
                                            <td>
                                                {!! $model->address ? $model->address  .', <br>' : '' !!}
                                                {{ $model->state ? $model->state->name .', ' : ''}}
                                                {{ $model->city ? $model->city->name .', ' : '' }}
                                                {{ $model->country ? $model->country->name : '' }}
                                            </td>

                                            <td>


                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        @if(permissionCheck('company.show'))
                                                            <a href="{{ route('company.show', $model->id) }}"
                                                               class="dropdown-item edit_brand">{{__('common.Show')}}</a>
                                                        @endif
                                                        @if(permissionCheck('company.edit'))
                                                            <a href="{{ route('company.edit', $model->id) }}"
                                                               class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                        @endif
                                                        @if(permissionCheck('company.destroy'))
                                                            <span id="delete_item" data-id="{{ $model->id }}" data-url="{{ route
                                                                    ('company.destroy', $model->id)
                                                                    }}"
                                                                  class="dropdown-item"><i class="icon-trash"></i>
                                                                        {{ __('common.Delete') }} </span>
                                                        @endif


                                                    </div>
                                                </div>


                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                @include('partials.delete_modal')
            </div>
        </div>
    </section>

@stop


@push('admin.scripts')


    <script>
        $(document).ready(function () {
        });

    </script>
@endpush


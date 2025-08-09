@extends('layouts.master', ['title' =>'Permission'])
@section('mainContent')


<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @if(isset($permission))
                                    @lang('common.Edit')
                                @else
                                    @lang('common.Add')
                                @endif
                                Permission
                            </h3>
                        </div>
                        @if(isset($permission))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('permissions.update',$permission->id),'method' => 'PUT']) }}
                        @else
                        {{ Form::open(['class' => 'form-horizontal', 'url' => route('permissions.store')]) }}
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row  mt-25">
                                    <div class="col-lg-12">
                                        @if(session()->has('message-success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success') }}
                                        </div>
                                        @elseif(session()->has('message-danger'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger') }}
                                        </div>
                                        @endif
                                        <div class="input-effect">
                                            <label>Permission Name <span>*</span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($permission)? @$permission->name: ''}}" required="1">
                                            <input type="hidden" name="id" value="{{isset($permission)? @$permission->id: ''}}">
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                   
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        {{-- @if(permissionCheck('permission.roles.edit') || permissionCheck('permission.roles.store')) --}}
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            {{!isset($permission)? 'save' : 'update'}}

                                        </button>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">Permission @lang('common.List')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="QA_section QA_section_heading_custom check_box_table SplitDivTable">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="mt-30">
                                <table class="table Crm_table_active3">
                                        <thead>
                                           @include('backEnd.partials.alertMessagePageLevelAll')
                                            <tr>
                                                <th width="30%">Permission</th>
                                                <th width="40%">@lang('role.Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $permission)
                                            <tr>
                                                <td>{{@$permission->name}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <div class="dropdown CRM_dropdown d-inline ml-1">
                                                        <button class="btn btn-secondary dropdown-toggle mb-1" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                            <a href="{{ route('permissions.edit',$permission->id) }}" class="dropdown-item" type="button">@lang('common.Edit')</a>
                                                            <a href="#"  class="dropdown-item"  type="button" data-toggle="modal" href="#" data-id="{{@$permission->id}}" data-target="#deleteItem_{{@$permission->id}}">@lang('role.Delete')</a>
                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
                                                    </div>
                                                    
                                                </td>
                                                {{-- Error modal message --}}
                                                @include('backEnd.partials.deleteModalMessage',[
                                                    'item_id' => @$permission->id,
                                                    'item_name' => 'Permission',
                                                    'route_url' => route('permissions.destroy', $permission->id)])
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

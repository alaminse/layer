@extends('layouts.master', ['title' => 'Create Organization'])

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">Add New Organization & Admin</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        {!! Form::open(['route' => 'organizations.store', 'method' => 'POST', 'files' => true, 'class' => 'form-validate-jquery', 'id' => 'organization_form']) !!}

                        {{-- Organization Info --}}
                        <h5 class="mb-3">Organization Info</h5>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('name', 'Organization Name', ['class' => 'required']) }}
                                {{ Form::text('name', old('name'), ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Organization Name']) }}
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('address', 'Address') }}
                                {{ Form::text('address', old('address'), ['class' => 'primary_input_field', 'placeholder' => 'Address']) }}
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', old('phone'), ['class' => 'primary_input_field', 'placeholder' => 'Phone']) }}
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="primary_input">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', old('description'), ['class' => 'primary_input_field summernote', 'rows' => 4]) }}
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- User Info --}}
                        <hr>
                        <h5 class="mb-3 mt-4">Admin User Info</h5>
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('user_name', 'Full Name', ['class' => 'required']) }}
                                {{ Form::text('user_name', old('user_name'), ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'User Full Name']) }}
                                @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('user_email', 'Email', ['class' => 'required']) }}
                                {{ Form::email('user_email', old('user_email'), ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'User Email']) }}
                                @error('user_email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('password', 'Password', ['class' => 'required']) }}
                                {{ Form::password('password', ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Password']) }}
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="primary_input col-md-6">
                                {{ Form::label('avatar', 'Avatar') }}
                                {{ Form::file('avatar', ['class' => 'primary_input_field']) }}
                                @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="primary_input col-md-12">
                                <label for="subscription_id" class="required">Subscription</label>
                                <select name="subscription_id" class="primary_input_field form-control" id="subscription_id">
                                    <option value="">Select Subscription</option>
                                    @foreach($subscriptions as $id => $label)
                                        <option value="{{ $id }}">{!! $label !!}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <div class="text-center mt-3">
                            <button class="primary_btn_large submit" type="submit">
                                <i class="ti-check"></i> Create Organization
                            </button>
                            <button class="primary_btn_large submitting" type="submit" disabled style="display: none;">
                                <i class="ti-check"></i> Creating...
                            </button>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('admin.scripts')
    <script>
        $(document).ready(function () {
            _formValidation();
        });
    </script>
@endpush

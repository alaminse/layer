@extends('layouts.master', ['title' => 'Create Subscription'])

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">Add New Subscription</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        {!! Form::open(['route' => 'subscriptions.store', 'method' => 'POST', 'files' => true, 'class' => 'form-validate-jquery', 'id' => 'subscription_form']) !!}
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('name', 'Subscription Name', ['class' => 'required']) }}
                                {{ Form::text('name', null, ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Subscription Name']) }}
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('price', 'Price (৳)', ['class' => 'required']) }}
                                {{ Form::number('price', null, ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Price']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('offer_price', 'Offer Price (optional)') }}
                                {{ Form::number('offer_price', null, ['class' => 'primary_input_field', 'placeholder' => 'Offer Price']) }}
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('banner', 'Banner Image') }}
                                {{ Form::file('banner', ['class' => 'primary_input_field']) }}
                            </div>
                        </div>

                        <div class="primary_input">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', null, ['class' => 'primary_input_field summernote', 'rows' => 4, 'maxlength' => 1500]) }}
                        </div>

                        <div class="primary_input">
                            {{ Form::label('status', 'Status') }}
                            {{ Form::select('status', ['1' => 'Active', '0' => 'Inactive'], '1', ['class' => 'primary_select']) }}
                        </div>
                        <div style="height: 50px"></div>

                        <div class="text-center mt-3">
                            <button class="primary_btn_large submit" type="submit">
                                <i class="ti-check"></i> Create Subscription
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

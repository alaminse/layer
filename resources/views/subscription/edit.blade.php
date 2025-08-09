@extends('layouts.master', ['title' => 'Edit Subscription'])

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">Edit Subscription</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        {!! Form::model($subscription, ['route' => ['subscriptions.update', $subscription->id], 'method' => 'PUT', 'files' => true, 'class' => 'form-validate-jquery', 'id' => 'subscription_form']) !!}
                        
                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('name', 'Subscription Name', ['class' => 'required']) }}
                                {{ Form::text('name', old('name', $subscription->name), ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Subscription Name']) }}
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('price', 'Price (৳)', ['class' => 'required']) }}
                                {{ Form::number('price', old('price', $subscription->price), ['required' => '', 'class' => 'primary_input_field', 'placeholder' => 'Price']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="primary_input col-md-6">
                                {{ Form::label('offer_price', 'Offer Price (optional)') }}
                                {{ Form::number('offer_price', old('offer_price', $subscription->offer_price), ['class' => 'primary_input_field', 'placeholder' => 'Offer Price']) }}
                            </div>

                            <div class="primary_input col-md-6">
                                {{ Form::label('banner', 'Banner Image') }}
                                {{ Form::file('banner', ['class' => 'primary_input_field']) }}
                                @if ($subscription->banner)
                                    <div class="mt-2">
                                        <img src="{{ asset('public/' . $subscription->banner) }}" alt="Banner" width="120" height="auto">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="primary_input">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', old('description', $subscription->description), ['class' => 'primary_input_field summernote', 'rows' => 4, 'maxlength' => 1500]) }}
                        </div>

                        <div class="primary_input">
                            {{ Form::label('status', 'Status') }}
                            {{ Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $subscription->status), ['class' => 'primary_select']) }}
                        </div>

                        <div class="text-center mt-3">
                            <button class="primary_btn_large submit" type="submit">
                                <i class="ti-check"></i> Update Subscription
                            </button>
                            <button class="primary_btn_large submitting" type="submit" disabled style="display: none;">
                                <i class="ti-check"></i> Updating...
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

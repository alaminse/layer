@extends('frontend.default.layouts.app')
@section('title',app('general_setting')->site_title.' | Cart')
@section('breadcrumb','Cart')
@section('styles')
    <style>
        .section_padding {
            padding-top: 75px!important;
            padding-right: 0px;
            padding-bottom: 75px!important;
            padding-left: 0px;
        }
    </style>
@endsection
@section('content')
    @include('frontend.default.partials._breadcrumb')
    <section class="our_speciality section_padding">
        <div class="container-fluid">
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-xl-6 col-md-8">--}}
{{--                    <div class="section_tittle text-center">--}}
{{--                        <h5>AMazing Features</h5>--}}
{{--                        <h2>Some Features that make--}}
{{--                            Us Proud</h2>--}}
{{--                        <p>Looking forward to something different & unique! Here we are with few that never expected in--}}
{{--                            others. </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row justify-content-center" id="cart_data">
                @include('frontend.default.cart._cart_data')
            </div>
        </div>
    </section>
    <div id="append_html"></div>
@endsection

@push('scripts')
    <script>
        (function($){
            "use strict";
            let _token = $('meta[name=_token]').attr('content') ;
            $(document).ready(function() {

                $(document).on('click', '#coupon_apply_btn', function(event){
                    event.preventDefault();
                    couponApply();
                });

                $(document).on('click', '#apply_coupon_remove_btn', function(event){
                    event.preventDefault();
                    applyCouponRemove();
                });

                function couponApply(){
                    let coupon_code = $('#coupon_code').val();
                    if(coupon_code){
                        $('#pre-loader').removeClass('d-none');
                        let formData = new FormData();
                        formData.append('_token', _token);
                        formData.append('coupon_code', coupon_code);
                        $.ajax({
                            url: '{{route('frontend.checkout.coupon-apply')}}',
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if(response.error){
                                    toastr.error(response.error,'Error');
                                    $('#pre-loader').addClass('d-none');
                                }else{
                                    $('#cart_data').html(response.cartData);
                                    toastr.success("{{__('defaultTheme.coupon_applied_successfully')}}","{{__('common.success')}}");
                                    $('#pre-loader').addClass('d-none');
                                }
                            },
                            error: function (response) {
                                toastr.error(response.responseJSON.errors.coupon_code)
                                $('#pre-loader').addClass('d-none');
                            }
                        });
                    }else{
                        toastr.error("{{__('defaultTheme.coupon_field_is_required')}}","{{__('common.error')}}");
                    }
                }

                function applyCouponRemove() {
                    $('#pre-loader').removeClass('d-none');
                    let url = "{{route('frontend.checkout.coupon-delete')}}";
                    $.get(url, function(response) {
                        $('#cart_data').html(response.cartData);
                        $('#pre-loader').addClass('d-none');
                        toastr.success("{{__('defaultTheme.coupon_deleted_successfully')}}","{{__('common.success')}}");
                    });
                }

            });
        })(jQuery);

    </script>
@endpush


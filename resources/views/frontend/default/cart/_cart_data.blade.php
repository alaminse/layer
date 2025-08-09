<div class="col-xl-7 col-lg-8">
    <div class="sales_product_details bg-white style2 mb_30">
        <h4 class="f_s_22 f_w_600 mb_30">{{__('order.shopping_cart')}}</h4>
        <div class="sales_billing_box mb_25imp">
            <div class="sales_billing_box_head d-flex align-items-center gap_20 justify-content-between">
                <h4 class="f_s_16 f_w_600 m-0">{{__('order.you_have')}} {{$cartData->count()}} {{__('order.items_in_your_cart')}}	</h4>
                <a href="{{route('customer.dashboard')}}" class="primary-btn fix-gr-bg">{{__('order.continue_shopping')}}</a>
            </div>
            <div class="sales_billing_box_body border-top-0 style2">
                <!-- single_cart_list -->
                @foreach($cartData as $cart)
                <div class="single_cart_list d-flex align-items-center gap_30 flex-wrap">
                    <div class="single_cart_left d-flex align-items-center flex-wrap flex-fill">
                        <a href="javascript:void(0)"><span class="close_icon ti-close remove_from_cart" data-id="{{$cart->id}}"></span></a>
                        <div class="thumb cart_menu_image">
                            <img class="img-fluid" src="{{showImage($cart->item->thumbnail_image?$cart->item->thumbnail_image:isPathPublic().'/images/dummy/default.png')}}" alt="">
                        </div>
                        <div class="cart_info flex-fill">
                            <a href="#">
                                <h4 class="f_s_18 f_w_600 mb_5 theme_text_hover">{{$cart->item->name}}</h4>
                            </a>
                            <p class="f_s_14 f_w_500 mb_15"> <span class="font-italic">by</span>   <a href="#" class="theme_text_hover">Codethemes</a> </p>
                            <div class="lisence_list d-flex align-items-center gap_C40 flex-wrap">
                                @if($cart->item_type != 4)
                                <div class="lisence_list_single d-flex align-items-center gap_5">

                                    <h5 class="m-0 f_s_14 f_w_600">{{__('order.license')}} :</h5>
                                    <a title="Change License" href="javascript:void(0)" class="change_cart_item" data-cart="{{$cart->id}}">
                                        <p class="m-0 f_s_14 f_w_600">{{$cart->licenseType()}}</p>
                                    </a>
                                </div>
                                <div class="lisence_list_single d-flex align-items-center gap_5">
                                    <h5 class="m-0 f_s_14 f_w_600">{{__('order.support')}} :</h5>

                                    <a title="Change License" href="javascript:void(0)" class="change_cart_item" data-cart="{{$cart->id}}">
                                        <p class="m-0 f_s_14 f_w_600">{{$cart->supportType()}}</p>
                                    </a>
                                </div>
                                @else
                                    <div class="lisence_list_single d-flex align-items-center gap_5">
                                        <h5 class="m-0 f_s_14 f_w_600">{{__('product.plan')}} : </h5>
                                        <p class="m-0 f_s_14 f_w_600">{{$cart->plan->plan->name}}  </p>
                                    </div>
                                    <div class="lisence_list_single d-flex align-items-center gap_5">
                                        <h5 class="m-0 f_s_14 f_w_600">{{__('order.subscription')}} :</h5>
                                        <p class="m-0 f_s_14 f_w_600">{{$cart->subscription_type}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h4 class="f_s_20 f_w_600 m-0">{{showPrice($cart->total_price)}}</h4>
                </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end gap_15 flex-wrap mb_30">
            <h4 class="f_s_14 f_w_600 m-0 ">{{__('order.sub_total')}}</h4>
            <h4 class="font_30 f_w_600 m-0">{{showPrice($payable_amount['sub_total'])}}</h4>
        </div>
        <div class="d-flex align-items-center gap_10 flex-wrap justify-content-end">
            <a href="javascript:void(0)" id="empty_cart_item" class="primary_line_btn3 sales_large_btn fix-gr-bg  text-center text-nowrap">{{__('order.empty_cart')}}</a>
            <a href="{{route('frontend.checkout')}}" class="primary-btn sales_large_btn fix-gr-bg  text-center text-nowrap"> {{__('order.secure_checkout')}}</a>
        </div>
    </div>
</div>
<div class="col-xl-3 col-lg-4">
    <div class="sales_white_box d-flex flex-column align-items-center">
        @if(auth()->check())

        @if($payable_amount['coupon_apply'])
            <h4 class="f_s_14 f_w_600 mb_15 mt_10">{{__('order.coupon_amount')}}<span class="ml-15"><a id="apply_coupon_remove_btn" href="javascript:void(0)"><i class="fas fa-times text-danger"></i></a></span>  </h4>
            <h3 class="f_s_30 f_w_600 mb_30"> {{showPrice($payable_amount['coupon_amount'])}}</h3>
        @else
            <div class="col-12">
                <div class="primary_input primary_input_coupon d-flex align-items-center gap_10">
                    <label class="font_13 theme_text f_w_500 mb-0 d-none" for="">{{__('order.coupon')}}</label>
                    <div class="input-group primary_input_coupon text-right ">
                        <input type="text" id="coupon_code" class="primary_input_field" placeholder="Coupon Code" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                    <div class="input-group-append fix-gr-bg">
                        <button id="coupon_apply_btn" class="primary-btn fix-gr-bg radius_30px" type="button">{{__('order.apply')}}</button>
                    </div>
                </div>
            </div>
        @endif

        @endif

        <h4 class="f_s_14 f_w_600 mb_15 mt_10">{{__('order.total_payable')}}</h4>
        <h3 class="f_s_30 f_w_600 mb_30">{{showPrice($payable_amount['grand_total'])}}</h3>
        <a href="{{route('frontend.checkout')}}" class="primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap mb_20">{{__('order.secure_checkout')}}</a>
{{--        <p class="f_s_14 f_w_400 m-0 text-center mb-1">Price displayed excludes any applicable taxes.</p>--}}
    </div>
</div>

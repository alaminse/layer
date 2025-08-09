<a class="pulse theme_color shoping_cart_toggler" href="#">
    <!-- bell   -->
    <i class="fa fa-shopping-cart"></i>
    <!--/ bell   -->
    <span class="notification_count" > {{$cartData->count()}}</span>
    <span class="pulse-ring notification_count_pulse"></span>
</a>
<!-- Shopping Cart::start -->
<div class="shoping_cart_notifyWrapper">
    <div class="shoping_cart_notify_header position-relative">
        <h4 class="f_s_20 f_w_600">{{__('order.shopping_cart')}}</h4>
        <p class="f_s_14 f_w_500 mb_20">{{$cartData->count()}} {{__('order.items_selected')}}</p>
        <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.9616 0.335815L21.7417 19.0076H0.181373L10.9616 0.335815Z" fill="white"/>
        </svg>
    </div>
    <div class="shoping_cart_notify_body mb_30">
        @foreach($cartData as $cart)
            <div class="shoping_cart_notify_single d-flex align-items-center gap_20 flex-wrap">
                <div class="shoping_cartNotify_left d-flex align-items-center gap_10">
{{--                    <label class="primary_checkbox checkbox_20 d-flex mr-0">--}}
{{--                    </label>--}}
                    <a class="cart_item_remove_btn" href="javascript:void(0)"><span class="close_icon ti-close remove_from_cart " data-id="{{$cart->id}}"></span></a>
                    <a href="#" class="thumb cart_menu_image">
                        <img class="img-fluid" src="{{showImage($cart->item->thumbnail_image?$cart->item->thumbnail_image:isPathPublic().'/images/dummy/default.png')}}" alt="">
                    </a>
                </div>
                <div class="shoping_cartNotify_right">
                    <a href="#">
                        <h4 class="theme_text_hover f_s_18 mb_12">{{$cart->item->name}}</h4>
                    </a>
                    <div class="shoping_count d-flex align-items-center gap_10">
                        <h5 class="f_s_14 f_w_500 m-0 theme_text5">{{showPrice($cart->discount_price)}}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="shoping_cart_notify_bottom">
        <div class="shoping_cart_notify_total d-flex align-items-center justify-content-between mb_30">
            <h4 class="f_s_16 f_w_600 m-0">{{__('order.sub_total')}}</h4>
            <h4 class="f_s_16 f_w_600 m-0">{{showPrice($payable_amount['sub_total'])}}</h4>
        </div>
        <a class="primary-btn sales_large_btn  fix-gr-bg w-100 text-center text-nowrap mb_10" href="{{route('frontend.cart')}}">{{__('order.view_cart')}}</a>
{{--        <a class="primary-btn sales_large_btn  fix-gr-bg w-100 text-center text-nowrap" href="#">process to checkout</a>--}}
    </div>
</div>
<!-- Shopping Cart::end -->

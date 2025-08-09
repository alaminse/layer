

<div class="sales_white_box mb_20 d-flex flex-column">
    <div class="sales_lisence_header d-flex align-items-center gap_10 mb_20">
        <div class="sales_lisence_header flex-fill position-relative">
            <h4 class="f_s_20 f_w_600 m-0 gj-cursor-pointer License_toggler regular_license_toggler">{{__('product.regular_license')}}<i class="fas fa-chevron-down fa-fw f_s_14"></i></h4>
            <h4 class="f_s_20 f_w_600 m-0 gj-cursor-pointer License_toggler extended_license_toggler">{{__('product.extended_license')}}<i class="fas fa-chevron-down fa-fw f_s_14"></i></h4>
            <!-- lisence_hover_box::start  -->
            <div class="lisence_hover_box position-absolute bg-white">
                <!-- lisence_hover_single::start  -->
                <div class="lisence_hover_single select_license" data-license="1">
                    <div class="lisence_hover_head d-flex align-items-center">
                        <div class="lisence_hover_head_left flex-fill d-flex align-items-center gap_5">
                            <h4 class="lisence_title_text f_s_16 f_w_600 m-0">{{__('product.regular_license')}}</h4>
                            <span class="lisence_title_text_badge regular_license_badge">Selected</span>
                        </div>
                        <div class="lisence_hover_head_right">
                            <h4 class="f_s_24 f_w_600 m-0 position-relative"> <span class="currency_icon">{{currencySymbol()}}</span> <span class="theme_text">{{showPriceWithoutSymbol($product->calculatePrice()['regular_discount_price'])}}</span></h4>
                        </div>
                    </div>
                    <div class="lisence_hover_body">
                        <p>{{$license_description->regular_license_description}}</p>
                    </div>
                </div>
                <!-- lisence_hover_single::end  -->

                <!-- lisence_hover_single::start  -->
                <div class="lisence_hover_single select_license" data-license="2">
                    <div class="lisence_hover_head d-flex align-items-center">
                        <div class="lisence_hover_head_left flex-fill d-flex align-items-center gap_5">
                            <h4 class="lisence_title_text f_s_16 f_w_600 m-0">{{__('product.extended_license')}}</h4>
                            <span class="lisence_title_text_badge extended_license_badge"></span>
                        </div>
                        <div class="lisence_hover_head_right">
                            <h4 class="f_s_24 f_w_600 m-0 position-relative"> <span class="currency_icon">{{currencySymbol()}}</span> <span class="theme_text">{{showPriceWithoutSymbol($product->calculatePrice()['extended_discount_price'])}}</span></h4>
                        </div>
                    </div>
                    <div class="lisence_hover_body">
                        <p>{{$license_description->extended_license_description}}</p>
                    </div>
                </div>
                <!-- lisence_hover_single::end  -->
                <div class="lisence_hover_bottom text-center">
                    <a href="#">{{__('product.view_license_details')}}</a>
                </div>
            </div>
            <!-- lisence_hover_box::end  -->
        </div>


        <h4 class="f_s_16 f_w_600 m-0 regular_license_without_support_price text-nowrap">
            @if($product->is_discount)
                <del class="opacity_05 mr-2">{{showPrice($product->calculatePrice()['regular_price'])}}</del>{{showPrice($product->calculatePrice()['regular_discount_price'])}}
            @else
                {{showPrice($product->calculatePrice()['regular_price'])}}
            @endif
        </h4>
        <h4 class="f_s_16 f_w_600 m-0 extended_license_without_support_price text-nowrap">
            @if($product->is_discount)
                <del class="opacity_05 mr-2">{{showPrice($product->calculatePrice()['extended_price'])}}</del>{{showPrice($product->calculatePrice()['extended_discount_price'])}}
            @else
                {{showPrice($product->calculatePrice()['extended_price'])}}
            @endif
        </h4>
        <h4 class="f_s_16 f_w_600 m-0 regular_license_with_support_price text-nowrap">
            @if($product->is_discount)
                <del class="opacity_05 mr-2">{{showPrice($product->calculatePrice()['regular_price'] + $product->calculatePrice()['regular_support_price'])}}</del>{{showPrice($product->calculatePrice()['regular_discount_price'] + $product->calculatePrice()['regular_support_price'])}}
            @else
                {{showPrice($product->calculatePrice()['regular_price'] + $product->calculatePrice()['regular_support_price'])}}
            @endif
        </h4>
        <h4 class="f_s_16 f_w_600 m-0 extended_license_with_support_price text-nowrap">
            @if($product->is_discount)
                <del class="opacity_05 mr-2">{{showPrice($product->calculatePrice()['extended_price'] +$product->calculatePrice()['extended_support_price'])}}</del>{{showPrice($product->calculatePrice()['extended_discount_price'] +$product->calculatePrice()['extended_support_price'])}}
            @else
                {{showPrice($product->calculatePrice()['extended_price']+$product->calculatePrice()['extended_support_price'])}}
            @endif
        </h4>

    </div>
    <div class="sales_border mb_15"></div>
    <ul class="sales_infoList mb_25imp">
        @foreach($license_list as $row)
            <li>{{$row->license}}</li>
        @endforeach
    </ul>
    <div class="Extend_lisence_box d-flex align-items-center gap_10 mb_13 flex-wrap">
        <div class="Extend_lisence_box_left d-flex align-items-start gap_15 flex-fill">
            <label class="primary_checkbox checkbox_20 d-flex mr-0 ">
                <input type="checkbox" name="extended_support" class="extended_support">
                <span class="checkmark"></span>
            </label>
            <h4 class="f_s_14 f_w_500 mb-0">{{__('product.extend_support_to_12_months')}}</h4>
        </div>
        <h4 class="f_s_16 f_w_600 m-0 regular_license">{{showPrice($product->calculatePrice()['regular_support_price'])}}</h4>
        <h4 class="f_s_16 f_w_600 m-0 extended_license">{{showPrice($product->calculatePrice()['extended_support_price'])}}</h4>
    </div>

    <div class="sales_border mb_20"></div>
    <a data-subscription_type="null" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="0" class="primary-btn sales_large_btn fix-gr-bg w-100 text-center mb_10 text-nowrap add_to_cart"  href="javascript:void(0)">{{__('product.add_to_cart')}}</a>
    @auth
        <a data-subscription_type="null" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="0" class="primary-btn sales_large_btn  fix-gr-bg w-100 text-center text-nowrap buy_now_btn"  href="javascript:void(0)">{{__('order.buy_now')}}</a>
    @endauth
</div>

<div class="sales_white_box d-flex flex-column">
    <h4 class="f_s_16 f_w_600 mb_20">{{__('product.need_support_for_this_item_?')}}</h4>
    <a class="primary-btn sales_large_btn  fix-gr-bg w-100 text-center text-nowrap" href="{{route('customer.support-ticket.create')}}">{{__('product.go_to_item_support')}}</a>
</div>

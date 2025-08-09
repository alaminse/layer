<!-- sales_cart_modal::start  -->
<div class="modal fade sales_cart_modal" id="add_cart_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered max_700" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-body p-0">
                <div class="sales_cart_header d-flex align-items-center justify-content-center flex-column">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 0C8.96875 0 0 8.96875 0 20C0 31.0312 8.96875 40 20 40C31.0312 40 40 31.0312 40 20C40 8.96875 31.0312 0 20 0Z" fill="#07DE10"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M29.6719 13.2578C30.1563 13.7422 30.1563 14.5391 29.6719 15.0234L17.9531 26.7422C17.7109 26.9844 17.3906 27.1094 17.0703 27.1094C16.75 27.1094 16.4297 26.9844 16.1875 26.7422L10.3281 20.8828C9.84375 20.3984 9.84375 19.6016 10.3281 19.1172C10.8125 18.6328 11.6094 18.6328 12.0938 19.1172L17.0703 24.0938L27.9063 13.2578C28.3906 12.7656 29.1875 12.7656 29.6719 13.2578Z" fill="white"/>
                    </svg>
                    <h4 class="f_s_20 f_w_600">{{__('order.item_added_to_your_cart')}}</h4>
                </div>

                <!-- single_cart_list -->
                <div class="single_modalcart_list d-flex align-items-start gap_30 flex-wrap">
                    <div class="single_cart_left d-flex align-items-center flex-wrap flex-fill">
                        <div class="thumb ml-0 mb-2 cart_menu_image">
                            <img class="img-fluid" src="{{showImage($cartSingleData->item->thumbnail_image?$cartSingleData->item->thumbnail_image:isPathPublic().'/images/dummy/default.png')}}" alt="">
                        </div>
                        <div class="cart_info flex-fill">
                            <a href="#">
                                <h4 class="f_s_18 f_w_600 mb_5 theme_text_hover line_h28">{{$cartSingleData->item->name}}</h4>
                            </a>
                            <p class="f_s_14 f_w_500 m-0"> <span class="font-italic">by</span>   <a href="#" class="theme_text_hover">Codethemes</a> </p>
                        </div>
                    </div>
                    <div class="">
                        <h4 class="font_24 f_w_600 mb_12">{{showPrice($cartSingleData->total_price)}}</h4>
                        @if($cartSingleData->item_type !=4)
                        <div class="lisence_list_single d-flex align-items-center gap_5">
                            <h5 class="m-0 f_s_14 f_w_600">{{__('order.license')}} : </h5>
                            <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->licenseType()}}</p>
                        </div>
                        <div class="lisence_list_single d-flex align-items-center gap_5 mb_20">
                            <h5 class="m-0 f_s_14 f_w_600">{{__('order.support')}} :</h5>
                            <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->supportType()}}</p>
                        </div>
                        <a href="javascript:void(0)" class="change_cart_item Change_details" data-cart="{{$cartSingleData->id}}">{{__('order.change_details')}}</a>
                        @else
                            <div class="lisence_list_single d-flex align-items-center gap_5">
                                <h5 class="m-0 f_s_14 f_w_600">{{__('product.plan')}} : </h5>
                                <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->plan->plan->name}}</p>
                            </div>
                            <div class="lisence_list_single d-flex align-items-center gap_5 mb_20">
                                <h5 class="m-0 f_s_14 f_w_600">{{__('order.subscription')}} :</h5>
                                <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->subscription_type}}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modalcart_foot">
                    <div class="d-flex align-items-center gap_10 justify-content-end flex-wrap">
                        <a href="#" data-dismiss="modal" class="primary_line_btn3 style2 fix-gr-bg text-nowrap">{{__('order.keep_browsing')}}</a>
                        <a href="{{route('frontend.cart')}}" class="primary-btn fix-gr-bg text-nowrap">{{__('order.go_to_cart')}}</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- sales_cart_modal::end  -->

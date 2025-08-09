<!-- sales_cart_modal_edit::start  -->
<div class="modal fade sales_cart_modal" id="edit_cart_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered max_700" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-body p-0">
                <div class="sales_cart_header d-flex align-items-center justify-content-center flex-column">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 0C8.96875 0 0 8.96875 0 20C0 31.0312 8.96875 40 20 40C31.0312 40 40 31.0312 40 20C40 8.96875 31.0312 0 20 0Z" fill="#07DE10"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M29.6719 13.2578C30.1563 13.7422 30.1563 14.5391 29.6719 15.0234L17.9531 26.7422C17.7109 26.9844 17.3906 27.1094 17.0703 27.1094C16.75 27.1094 16.4297 26.9844 16.1875 26.7422L10.3281 20.8828C9.84375 20.3984 9.84375 19.6016 10.3281 19.1172C10.8125 18.6328 11.6094 18.6328 12.0938 19.1172L17.0703 24.0938L27.9063 13.2578C28.3906 12.7656 29.1875 12.7656 29.6719 13.2578Z" fill="white"/>
                    </svg>
                    <h4 class="f_s_20 f_w_600">{{__('order.cart_item_update')}}e</h4>
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
                        <div class="lisence_list_single d-flex align-items-center gap_5">
                            <h5 class="m-0 f_s_14 f_w_600">{{__('order.license')}} : </h5>
                            <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->licenseType()}}</p>
                        </div>
                        <div class="lisence_list_single d-flex align-items-center gap_5 mb_20">
                            <h5 class="m-0 f_s_14 f_w_600">{{__('order.support')}} :</h5>
                            <p class="m-0 f_s_14 f_w_500">{{$cartSingleData->supportType()}}</p>
                        </div>
                    </div>
                </div>

                <div class="modalcart_foot">
                    <form id="update_cart_form">
                        <input type="hidden" value="{{$cartSingleData->id}}" name="id">
                        <input type="hidden" value="10" name="support_price">
                        <div class="lisence_expire_wrap  align-items-center gap_10 mb_30">

                           <div class="row">
                               <div class="col-md-6">
                                   <div class="primary_input mb-15 d-flex align-items-center gap_10">
                                       <label class="primary_input_label" for="license_type">{{__('order.select_a_license')}} :</label>
                                       <select class="primary_select" id="license_type" name="license_type">
                                           <option value="1" {{$cartSingleData->license_type == 1 ?'selected':''}} >Regular</option>
                                           <option value="2" {{$cartSingleData->license_type != 1 ?'selected':''}} >Extended</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="primary_input mb-15 d-flex align-items-center gap_10">
                                       <label class="primary_input_label" for="support">{{__('order.support_duration')}} :</label>
                                       <select class="primary_select" id="support" name="support">
                                           <option value="0" {{$cartSingleData->support == 0 ?'selected':''}} >6 Months</option>
                                           <option value="1" {{$cartSingleData->support == 1 ?'selected':''}} >12 Months</option>
                                       </select>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div class="sales_border mb_20"></div>
                        <div class="d-flex align-items-center gap_10 justify-content-end flex-wrap">
                            <a href="#" data-dismiss="modal" class="primary_line_btn3 style2 fix-gr-bg text-nowrap">{{__('common.cancel')}}</a>
                            <button type="submit" class="primary-btn fix-gr-bg text-nowrap">{{__('common.update')}}</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- sales_cart_modal_edit::end  -->

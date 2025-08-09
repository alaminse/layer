@if($recommended_products->count() > 0)
    <div class="sales_white_box d-flex flex-column mt-30">
        <h4 class="f_s_16 f_w_600 mb_20">{{__('product.recommended_product')}}</h4>
        @foreach($recommended_products as $key => $product)
            <div class="sales_product_box white-bg mb_30">
                <a href="{{$product->productPath()}}" class="thumb overflow-hidden d-block">
                    <img class="img-fluid" src="{{showImage($product->thumbnail_image?$product->thumbnail_image:isPathPublic().'images/dummy/sales_1.png')}}" alt="">
                </a>
                <div class="sales_product_meta d-flex align-items-center gap_10">
                    <div class="sales_product_meta_info flex-fill">
                        <a href="{{$product->productPath()}}">
                            <h4 class="f_s_18 f_w_600">{{$product->name}}</h4>
                        </a>
                        <p class="f_s_14 f_w_500 m-0">{{$product->productType()}}</p>
                    </div>
                    @if($product->product_type != 4)
                        <h4 class="prise_amount f_s_18 f_w_600 m-0">
                            @if($product->is_discount)
                                <del class="opacity_05"> {{showPrice($product->calculatePrice()['regular_price'])}} </del>
                                {{showPrice($product->calculatePrice()['regular_discount_price'])}}
                            @else
                                {{showPrice($product->calculatePrice()['regular_price'])}}
                            @endif
                        </h4>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

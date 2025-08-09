@foreach($products as $product)
    <div class="starter_product_box white-bg">
        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="8" viewBox="0 0 33 8">
            <g id="nav" transform="translate(-189 -4726)">
                <circle id="Ellipse_250" data-name="Ellipse 250" cx="4" cy="4" r="4"
                        transform="translate(189 4726)" fill="#ececed" />
                <circle id="Ellipse_251" data-name="Ellipse 251" cx="4" cy="4" r="4"
                        transform="translate(202 4726)" fill="#ececed" />
                <circle id="Ellipse_252" data-name="Ellipse 252" cx="4" cy="4" r="4"
                        transform="translate(214 4726)" fill="#ececed" />
            </g>
        </svg>
        <a href="{{$product->productPath()}}" class="thumb overflow-hidden d-block">
            <img class="img-fluid" src="{{showImage($product->thumbnail_image?$product->thumbnail_image:isPathPublic().'frontend/default/img/start_1.png')}}" alt="">
        </a>
        <div class="sales_product_meta d-flex align-items-center gap_10">
            <div class="sales_product_meta_info flex-fill">
                <a href="{{$product->productPath()}}">
                    <h4 class="f_s_20 f_w_600">{{$product->name}}</h4>
                </a>
                <p class="f_s_16 f_w_400 m-0">{{$product->productType()}}</p>
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

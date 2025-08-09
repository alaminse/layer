<!--product section start-->
<section id="products" class="our_speciality section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">
                <div class="section_tittle text-center">
                    <h5>Our Products</h5>
                    <h2>Some Features that make
                        Us Proud</h2>
                    <p>Looking forward to something different & unique! Here we are with few that never expected in
                        others. </p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- content  -->
            <div class="col-12">
                <div class="box_header common_table_header mb_30 gap_20 d-flex flex-wrap">
                    <div class="main-title d-flex flex-wrap gap_20 flex-fill">
                        <h3 class="mb-0">{{__('frontend.our_products')}}</h3>

                        <ul class="nav nav-pills product_nav mb-3 d-flex gap_10" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active primary_btn" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">{{__('product.all_item')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link primary_btn" id="pills-single-tab" data-toggle="pill" href="#pills-single" role="tab" aria-controls="pills-single" aria-selected="false">{{__('product.single')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link primary_btn" id="pills-module-tab" data-toggle="pill" href="#pills-module" role="tab" aria-controls="pills-module" aria-selected="false">{{__('product.module')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link primary_btn" id="pills-bundle-tab" data-toggle="pill" href="#pills-bundle" role="tab" aria-controls="pills-bundle" aria-selected="false">{{__('product.bundle')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link primary_btn" id="pills-subscription-tab" data-toggle="pill" href="#pills-subscription" role="tab" aria-controls="pills-subscription" aria-selected="false">{{__('product.subscription')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- content  -->
            <div class="col-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                        <div class="row">
                            @foreach($all_products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-single" role="tabpanel" aria-labelledby="pills-single-tab">
                        <div class="row">
                            @foreach($single_products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-module" role="tabpanel" aria-labelledby="pills-module-tab">
                        <div class="row">
                            @foreach($module_products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-bundle" role="tabpanel" aria-labelledby="pills-bundle-tab">
                        <div class="row">
                            @foreach($bundle_products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-subscription" role="tabpanel" aria-labelledby="pills-subscription-tab">
                        <div class="row">
                            @foreach($subscription_products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
<!-- product section end-->

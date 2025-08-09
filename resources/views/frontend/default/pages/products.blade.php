@extends('frontend.default.layouts.app')
@section('breadcrumb','Products')
@section('styles')
    <style>
        .active_btn{
            border: 1px solid transparent;
            color: #fff;
            background: -webkit-gradient(linear, left top, right top, from(#7C32FF), color-stop(70%, #A235EC), to(#C738D8));
            background: -o-linear-gradient(left, #7C32FF 0%, #A235EC 70%, #C738D8 100%);
            background: linear-gradient(90deg, #7C32FF 0%, #A235EC 70%, #C738D8 100%);
        }
        .section_padding {
            padding-top: 75px!important;
            padding-right: 0px;
            padding-bottom: 75px!important;
            padding-left: 0px;
        }
    </style>
@endsection
@section('title',app('general_setting')->site_title.' | Products')
@section('content')
    @include('frontend.default.partials._breadcrumb')
    <section class="our_speciality section_padding">
        <div class="container">
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
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="box_header common_table_header mb_30 gap_20 d-flex flex-wrap">
                        <div class="main-title d-flex flex-wrap gap_20 flex-fill">
                            <h3 class="mb-0 mr-30" >{{__('product.our_product')}}</h3>
                            <ul class="d-flex gap_10 flex-wrap">
                                <li>
                                    <a href="{{route('frontend.products')}}" class="primary_btn {{$request_data['all_filter'] ? 'active_btn':'' }}" >{{__('product.all_item')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('frontend.products',['filter'=>'1'])}}" class="primary_btn {{$request_data['filter'] == 1 ? 'active_btn':'' }}" >{{__('product.single')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('frontend.products',['filter'=>'2'])}}" class="primary_btn {{$request_data['filter'] == 2 ? 'active_btn':'' }}" >{{__('product.module')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('frontend.products',['filter'=>'3'])}}" class="primary_btn {{$request_data['filter'] == 3 ? 'active_btn':'' }}" >{{__('product.bundle')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('frontend.products',['filter'=>'4'])}}" class="primary_btn {{$request_data['filter'] == 4 ? 'active_btn':'' }}" >{{__('product.subscription')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex gap_20 flex-wrap align-items-center">
                            <h4 class="f_s_14 f_w_500 mb-0">{{__('product.sort_by_:')}}</h4>
                            <div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if($request_data['sort'] == 'a')
                                        {{__('product.newest')}}
                                    @elseif($request_data['sort'] == 'd')
                                        {{__('product.oldest')}}
                                    @elseif($request_data['sort'] == 't')
                                        {{__('product.top_rated')}}
                                    @else
                                        {{__('product.date_created')}}
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a href="{{route('frontend.products',['filter'=>$request_data['filter'],'sort'=>'a'])}}" class="dropdown-item" type="button">{{__('product.newest')}}</a>
                                    <a href="{{route('frontend.products',['filter'=>$request_data['filter'],'sort'=>'d'])}}" class="dropdown-item" type="button">{{__('product.oldest')}}</a>
                                    <a href="{{route('frontend.products',['filter'=>$request_data['filter'],'sort'=>'t'])}}" class="dropdown-item" type="button">{{__('product.top_rated')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @foreach($products as $key => $product)
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
    </section>
@endsection

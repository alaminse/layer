@extends('frontend.default.layouts.app')
@section('title',app('general_setting')->site_title.' | Pricing')
@section('styles')
    <style>
        @media only screen and (max-width: 600px) {
            #load_more_btn {
               display: block!important;
            }
            .content_hide_show{
                overflow:hidden; width:100%; height:600px;
            }

        }
        .sales_product_details_banner a{
            text-align: center!important;
        }
        .sales_product_details{
            padding-bottom: 25px!important;
        }
    </style>
@endsection

@section('share_meta')
    <meta property="og:description" content="{{$product->description}}" />
    <meta name="description" content="{{$product->description}}">
    <meta property="og:title" content="{{@substr(@$product->name,0,60)}}" />
    <meta name="title" content="{{ @substr(@$product->name,0,60) }}"/>
    <meta property="og:image" content="{{showImage($product->thumbnail_image?$product->thumbnail_image:isPathPublic().'images/dummy/banner.jpg')}}" />
    <meta property="og:url" content="{{$product->productPath()}}" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
{{--    <meta property="og:type" content="{{@$product->product->meta_description}}" />--}}

    @php
        $total_tag = $product->tags->count();
        $meta_tags = '';
        foreach($product->tags as $key => $tag){
            if($key + 1 < $total_tag){
                $meta_tags .=$tag->tag->name.', ';
            }else{
                $meta_tags .= $tag->tag->name;
            }
        }
    @endphp
    <meta name ="keywords" content="{{$meta_tags}}">
@endsection
@section('content')
    <section class="our_speciality section_padding">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="sales_product_details custom_description bg-white mb_30">
                        <div class="sales_product_title2 mb_40 d-flex align-items-center">
                            <h1 class="font_28 f_w_600 mb_13 flex-fill">{{$product->name}}</h1>
                            <h1 class="d-md-none">{{showPrice($product->calculatePrice()['regular_discount_price'])}}</h1>

                        </div>
                        <div class="sales_product_details_banner mb_25 text-center">
                            <img class="img-fluid" src="{{showImage($product->banner_image?$product->banner_image:isPathPublic().'images/dummy/banner.jpg')}}" alt="">
                            @if($product->demo_url)
                            <a target="_blank" href="{{$product->demo_url}}" class="text-center primary-btn fix-gr-bg text-center preview_btn text-white mt_25">Live Preview</a>
                            @endif
                        </div>
                        <div class="description_content">
                            {!! $product->description !!}

                        </div>
                        <a class="d-none mt-3 mb-3" href="javascript:void(0);" id="load_more_btn">show More...</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    @include('frontend.default.pages.partials.product_details._license_data')
                    @include('frontend.default.pages.partials.product_details._related_product')
                </div>
            </div>
        </div>
        <!-- append cart modal -->
        <input type="hidden" value="1" id="license_type">
    </section>
    <div id="append_html"></div>
@endsection

@push('scripts')
    <script src="{{asset(asset_path('modules/customer/js/license_toggler.js'))}}"></script>
    <script>
        (function($){
            "use strict";
            $(document).ready(function () {
                $(".description_content").addClass("content_hide_show");
                $("#load_more_btn").click( function() {
                    $(".description_content").toggleClass("content_hide_show");
                    if($('div.description_content').hasClass('content_hide_show')){
                        $("#load_more_btn").text('show more...');
                    }else {
                        $("#load_more_btn").text('show less...') ;
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

@extends('frontend.default.layouts.app')
@section('title',app('general_setting')->site_title.' | Pricing')


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
@section('styles')
    <style>
        .avatar_div img{
            width: auto!important;
        }
        .module_link{
            color: inherit;
        }
        .module_link:hover{
            color: #7C32FF;
        }
        .dashed {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px dashed var(--gradient_1);
        }
        .green_input_label{
            color: #54DA8A!important;
        }
        .opacity_05{
            opacity: 0.5;
        }

        @media only screen and (max-width: 600px) {
            #load_more_btn {
                display: block!important;
            }
            .content_hide_show{
                overflow:hidden; width:100%; height:600px;
            }
            .preview_btn{
                height: 32px;
                line-height: 32px;
            }
        }
        .sales_pricing_tab{
            margin: 45px 0!important;
        }
        .preview_btn{
            border-radius: 100px;
            height: 47px;
            line-height: 47px;
        }

    </style>
@endsection
@section('content')
    <section class="our_speciality section_padding">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="sales_pricing_wrapper">
                        <h1 class="pricing_title">{{$product->name}} <br>{{__('product.pricing_plan')}}</h1>

                        <div class="d-flex align-items-center justify-content-center">

                            @php
                                $month = false;
                                $annual = false;
                                $lifetime = false;
                                foreach ($product->packagePlans as $key => $plan){
                                    if(!$month && $plan->monthly_price > 0){
                                        $month = true;
                                    }
                                    if(!$annual && $plan->annual_price > 0){
                                        $annual = true;
                                    }
                                     if(!$lifetime && $plan->lifetime_price > 0){
                                        $lifetime = true;
                                    }
                                }

                            @endphp
                            <ul class="nav sales_pricing_tab" id="myTab" role="tablist">
                                @if($month)
                                <li class="nav-item">
                                    <a class="nav-link {{!$annual?'active':''}}" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="true">{{__('product.monthly')}}</a>
                                </li>
                                @endif
                                @if($annual)
                                <li class="nav-item">
                                    <a class="nav-link {{$annual?'active':''}}" id="annual-tab" data-toggle="tab" href="#annual" role="tab" aria-controls="annual" aria-selected="false">{{__('product.annual')}}</a>
                                </li>
                                @endif
                                @if($lifetime)
                                <li class="nav-item">
                                    <a class="nav-link" id="lifetime-tab" data-toggle="tab" href="#lifetime" role="tab" aria-controls="lifetime" aria-selected="false">{{__('product.lifetime')}}</a>
                                </li>
                                @endif
                            </ul>
                            @if($product->demo_url)
                            <a target="_blank" href="{{$product->demo_url}}" class="text-center primary-btn fix-gr-bg text-center preview_btn text-white ml-4">Live Preview</a>
                            @endif

                        </div>
                        <!-- tab-content:start -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade {{!$annual?'active show':''}}" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <!-- content ::start  -->
                                <div class="pricing_wrapper">
                                    <!-- sales_pricing_box -->
                                    @if($product->packagePlans->count() > 0)
                                        @foreach($product->packagePlans as $key => $plan)
                                            @if($plan->monthly_price > 0)
                                            <div class="sales_pricing_box d-flex flex-column justify-content-center">
                                                <div class="sales_pricing_head text-center">
                                                    <span class="package_name style{{$key+1}}">{{ $plan->plan->name }}</span>

                                                    <div class="prise_tag d-flex align-items-center justify-content-center gap_5">
                                                        <h4 class="prise_icon m-0">{{currencySymbol()}}</h4>
                                                        <h4 class="prise_value_30 m-0">{{$plan->calculatePrice('monthly')['discount_price']}}</h4>
                                                        <span class="prise_year">/month</span>
                                                    </div>

                                                    @if($plan->is_monthly_discount && $plan->calculatePrice('monthly')['discount_amount'] >= 1)
                                                        <h6 class="prise_value_30 mt-2 text-nowrap">
                                                            <del class="opacity_05">
                                                                {{showPrice($plan->calculatePrice('monthly')['price'])}}
                                                            </del>
                                                        </h6>
                                                    @endif

                                                    <p class="mt-5">{{$plan->desc}}</p>
                                                </div>

                                                <div class="mt-10">
                                                    <div class="d-flex justify-content-between font_16">
                                                        <div class="name">
                                                            {{ __('pricing.license_limit') }}
                                                        </div>
                                                        <div class="value">
                                                            {{$plan->license_limit == 0 ? 'unlimited' : $plan->license_limit}}
                                                        </div>
                                                    </div>
                                                </div>


                                                @if($plan->product->modules()->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.modules') }}</h4>
                                                    @foreach($plan->product->modules() as $key => $p_module)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_module->id,$plan->planModuleIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <a class="module_link ml-10" href="{{route('product.products.show',$p_module->id)}}" >{{$p_module->name}}</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @if($product->features->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.features') }}</h4>
                                                    @foreach($product->features as $key => $p_feature)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_feature->id,$plan->planFeatureIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <span class="ml-10">  {{$p_feature->feature}}</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="sales_foot mt-40">
                                                    <a data-subscription_type="monthly" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="add_to_cart primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('product.add_to_cart')}}</a>
                                                    @auth
                                                    <a data-subscription_type="monthly" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="buy_now_btn primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('order.buy_now')}}</a>
                                                    @endauth
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!-- content ::end  -->
                            </div>
                            <div class="tab-pane fade  {{$annual?'active show':''}}" id="annual" role="tabpanel" aria-labelledby="annual-tab">
                                <!-- content ::start  -->
                                <div class="pricing_wrapper">
                                    <!-- sales_pricing_box -->
                                    @if($product->packagePlans->count() > 0)
                                        @foreach($product->packagePlans as $key => $plan)
                                            @if($plan->annual_price > 0)
                                            <div class="sales_pricing_box d-flex flex-column justify-content-center">
                                                <div class="sales_pricing_head text-center">
                                                    <span class="package_name style{{$key+1}}">{{ $plan->plan->name }}</span>

                                                    <div class="prise_tag d-flex align-items-center justify-content-center gap_5">
                                                        <h4 class="prise_icon m-0">{{currencySymbol()}}</h4>
                                                        <h4 class="prise_value_30 m-0">{{$plan->calculatePrice('annual')['discount_price']}}</h4>
                                                        <span class="prise_year">/year</span>
                                                    </div>

                                                    @if($plan->is_yearly_discount && $plan->calculatePrice('annual')['discount_amount'] >= 1)
                                                        <h6 class="prise_value_30 mt-2 text-nowrap">
                                                            <del class="opacity_05">
                                                                {{showPrice($plan->calculatePrice('annual')['price'])}}
                                                            </del>
                                                        </h6>
                                                    @endif
                                                    <p class="mt-5">{{$plan->desc}}</p>
                                                </div>

                                                <div class="mt-10">
                                                    <div class="d-flex justify-content-between font_16">
                                                        <div class="name">
                                                            {{ __('pricing.license_limit') }}
                                                        </div>
                                                        <div class="value">
                                                            {{$plan->license_limit == 0 ? 'unlimited' : $plan->license_limit}}
                                                        </div>
                                                    </div>
                                                </div>


                                                @if($plan->product->modules()->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.modules') }}</h4>
                                                    @foreach($plan->product->modules() as $key => $p_module)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_module->id,$plan->planModuleIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <a class="module_link ml-10" href="{{route('product.products.show',$p_module->id)}}" >{{$p_module->name}}</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @if($product->features->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.features') }}</h4>
                                                    @foreach($product->features as $key => $p_feature)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_feature->id,$plan->planFeatureIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <span class="ml-10">  {{$p_feature->feature}}</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="sales_foot mt-40">
                                                    <a data-subscription_type="annual" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="add_to_cart primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('product.add_to_cart')}}</a>
                                                    @auth
                                                    <a data-subscription_type="annual" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="buy_now_btn primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('order.buy_now')}}</a>
                                                    @endauth
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!-- content ::end  -->
                            </div>
                            <div class="tab-pane fade" id="lifetime" role="tabpanel" aria-labelledby="lifetime-tab">
                                <!-- content ::start  -->
                                <div class="pricing_wrapper">
                                    <!-- sales_pricing_box -->
                                    @if($product->packagePlans->count() > 0)
                                        @foreach($product->packagePlans as $key => $plan)
                                            @if($plan->lifetime_price > 0)
                                            <div class="sales_pricing_box d-flex flex-column justify-content-center">
                                                <div class="sales_pricing_head text-center">
                                                    <span class="package_name style{{$key+1}}">{{ $plan->plan->name }}</span>



                                                    <div class="prise_tag d-flex align-items-center justify-content-center gap_5">
                                                        <h4 class="prise_icon m-0">{{currencySymbol()}}</h4>
                                                        <h4 class="prise_value_30 m-0">{{$plan->calculatePrice('lifetime')['discount_price']}}</h4>
                                                        <span class="prise_year">/lifetime</span>
                                                    </div>

                                                    @if($plan->is_lifetime_discount && $plan->calculatePrice('lifetime')['discount_amount'] >= 1)
                                                        <h6 class="prise_value_30 mt-2 text-nowrap">
                                                            <del class="opacity_05">
                                                                {{showPrice($plan->calculatePrice('lifetime')['price'])}}
                                                            </del>
                                                        </h6>
                                                    @endif

                                                    <p class="mt-5">{{$plan->desc}}</p>
                                                </div>

                                                <div class="mt-10">
                                                    <div class="d-flex justify-content-between font_16">
                                                        <div class="name">
                                                            {{ __('pricing.license_limit') }}
                                                        </div>
                                                        <div class="value">
                                                            {{$plan->license_limit == 0 ? 'unlimited' : $plan->license_limit}}
                                                        </div>
                                                    </div>
                                                </div>


                                                @if($plan->product->modules()->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.modules') }}</h4>
                                                    @foreach($plan->product->modules() as $key => $p_module)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_module->id,$plan->planModuleIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <a class="module_link ml-10" href="{{route('product.products.show',$p_module->id)}}" >{{$p_module->name}}</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @if($product->features->count() > 0)
                                                    <h4 class="mt-15">{{ __('product.features') }}</h4>
                                                    @foreach($product->features as $key => $p_feature)
                                                        <div class="mt-10">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="name font_16">
                                                                    @if(in_array($p_feature->id,$plan->planFeatureIds()))
                                                                        <i class="fa fa-check-circle green_input_label"></i>
                                                                    @else
                                                                        <i class="fa fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    <span class="ml-10">  {{$p_feature->feature}}</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="sales_foot mt-40">
                                                    <a data-subscription_type="lifetime" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="add_to_cart primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('product.add_to_cart')}}</a>
                                                    @auth
                                                    <a data-subscription_type="lifetime" data-item_id="{{$product->id}}" data-item_type="{{$product->product_type}}" data-plan_id="{{$plan->id}}" href="javascript:void(0)" class="buy_now_btn primary-btn sales_large_btn w-100  fix-gr-bg  text-center text-nowrap">{{__('order.buy_now')}}</a>
                                                    @endauth
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!-- content ::end  -->
                            </div>
                        </div>
                        <!-- tab-content:end  -->
                    </div>

                    <div class="sales_product_details  bg-white">

                        <div class="sales_product_title2 mb_40 d-flex align-items-center">
                            <h1 class="font_28 f_w_600 mb_13 flex-fill">{{$product->packageProduct->name}} Description</h1>
                        </div>

{{--                        <div class="sales_product_details_banner mb_30">--}}
{{--                            <img class="img-fluid" src="{{showImage($product->banner_image?$product->banner_image:isPathPublic().'images/dummy/banner.jpg')}}" alt="">--}}
{{--                        </div>--}}
                        <div class="custom_description description_content">
                            {!! $product->packageProduct->description !!}
                        </div>

                        <a class="d-none mt-3 mb-3" href="javascript:void(0);" id="load_more_btn">show More...</a>



                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="append_html"></div>
@endsection

@push('scripts')

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

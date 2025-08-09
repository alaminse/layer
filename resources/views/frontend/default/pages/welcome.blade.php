@extends('frontend.default.layouts.app',['banner'=>true])

@section('title',app('general_setting')->site_title.' | Welcome')

@section('share_meta')
    <meta property="og:description" content="{{$homepage_seo->description}}" />
    <meta name="description" content="{{$homepage_seo->description}}">
    <meta property="og:title" content="{{@substr($homepage_seo->title,0,60)}}" />
    <meta name="title" content="{{ @substr(@$homepage_seo->title,0,60) }}"/>
    @if($homepage_seo->image)
    <meta property="og:image" content="{{showImage($homepage_seo->image)}}" />
    @endif
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <link rel="canonical" href="{{url()->current()}}"/>
    <meta name ="keywords" content="{{$homepage_seo->keywords}}">
@endsection
@section('content')
    <div class="starter_section starter_bg  position-relative ">
        <div class="border_group">
            <div class="single_border"></div>
            <div class="single_border"></div>
            <div class="single_border"></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="starter_title text-center  postion-relative ">
{{--                        <svg class="count_svg" xmlns="http://www.w3.org/2000/svg"--}}
{{--                             xmlns:xlink="http://www.w3.org/1999/xlink" width="468.738" height="200"--}}
{{--                             viewBox="0 0 468.738 200">--}}
{{--                            <defs>--}}
{{--                                <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1"--}}
{{--                                                gradientUnits="objectBoundingBox">--}}
{{--                                    <stop offset="0" stop-color="#e2e9f7" />--}}
{{--                                    <stop offset="1" stop-color="#fff" stop-opacity="0.2" />--}}
{{--                                </linearGradient>--}}
{{--                            </defs>--}}
{{--                            <path id="Path_4210" data-name="Path 4210"--}}
{{--                                  d="M-277.9-136.81H-204v42.564h-140.78v-36.219l76.933-77.991q13.219-13.219,13.219-27.363,0-8.2-5.089-13.02t-15.664-4.825q-10.575,0-16.259,5.684t-5.684,19.167V-214.4l-47.984-4.891v-8.46q0-30.139,18.572-46.993t50.826-16.854q30.8,0,49.9,15.069t19.1,41.507a55.9,55.9,0,0,1-5.948,25.71q-5.948,11.7-18.506,24.653ZM-105.921-91.6q-36.087,0-55.122-24.917T-180.078-191.4q0-50.1,19.1-75.017t55.056-24.917q35.691,0,54.792,24.917t19.1,75.017q0,49.967-19.035,74.884T-105.921-91.6Zm0-42.961q25.644,0,25.644-56.841t-25.644-56.841q-26.041,0-26.041,56.841T-105.921-134.563ZM38.428-121.344V-170.65H-10.878V-206.34H38.428v-49.306H74.119v49.306h49.306v35.691H74.119v49.306Z"--}}
{{--                                  transform="translate(345.313 291.602)" fill="url(#linear-gradient)" />--}}
{{--                        </svg>--}}
                        <h3>Get started with <br>
                            a pre-made script & module</h3>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="starter_sidebar mb_20">
                        <h4>{{__('frontend.product_type')}}</h4>
                        <ul>
                            <li class="mb_20">
                                <label class="primary_checkbox d-flex w-100">
                                    <input name="types[]" class="types" value="0" type="checkbox" id="all">
                                    <span class="checkmark mr_10"></span>
                                    <span class="label_name f_w_400">{{__('frontend.all')}}</span>
                                </label>
                            </li>
                            <li class="mb_20">
                                <label class="primary_checkbox d-flex w-100">
                                    <input name="types[]" value="1" class="product_type types" type="checkbox">
                                    <span class="checkmark mr_10"></span>
                                    <span class="label_name f_w_400">{{__('frontend.single')}}</span>
                                </label>
                            </li>
                            <li class="mb_20">
                                <label class="primary_checkbox d-flex w-100">
                                    <input name="types[]" value="2" class="product_type types" type="checkbox">
                                    <span class="checkmark mr_10"></span>
                                    <span class="label_name f_w_400">{{__('frontend.module')}}</span>
                                </label>
                            </li>
                            <li class="mb_20">
                                <label class="primary_checkbox d-flex w-100">
                                    <input name="types[]" value="3" class="product_type types" type="checkbox">
                                    <span class="checkmark mr_10"></span>
                                    <span class="label_name f_w_400">{{__('frontend.bundle')}}</span>
                                </label>
                            </li>
                            <li class="mb_20">
                                <label class="primary_checkbox d-flex w-100">
                                    <input name="types[]" value="4" class="product_type types" type="checkbox">
                                    <span class="checkmark mr_10"></span>
                                    <span class="label_name f_w_400">{{__('frontend.subscription')}}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="input-group starter_input_group mb_20">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18.015" height="18.015"
                                     viewBox="0 0 18.015 18.015">
                                    <g id="icon" transform="translate(-11 -11)">
                                        <path id="Path_22" data-name="Path 22"
                                              d="M28.794,27.732l-4.048-4.048a7.724,7.724,0,1,0-1.062,1.066l4.048,4.044a.751.751,0,0,0,1.062-1.062ZM14.335,23.176a6.249,6.249,0,1,1,4.419,1.835A6.2,6.2,0,0,1,14.335,23.176Z"
                                              transform="translate(0 0)" fill="#8333f9" />
                                    </g>
                                </svg>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search products"
                               aria-label="Username" aria-describedby="basic-addon1" id="search_box">
                    </div>
                    <div class="starter_product_wrapper" id="product_section">
                       @include('frontend.default.pages.partials.index._product_section')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{route('product.filter_by_ajax')}}" id="product_filter_url">
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";
            let _token = $('meta[name=_token]').attr('content') ;
            $(document).ready(function () {
                checkedAllType();

                $("#search_box").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".starter_product_box").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                $(document).on('change', '#all', function(event){
                    if($(this).is(':checked',true))
                    {
                        $(".product_type").prop('checked', true);
                    } else {
                        $(".product_type").prop('checked',false);
                    }
                    let checked = $(".product_type:checked").length;

                    if(!checked) {
                        toastr.warning("You must check at least one.");
                        $('.types').prop('checked', true);
                        return false;
                    }
                    filterProducts();
                });

                $(document).on('change', '.product_type', function(event){
                    let total = 4;
                    if(total === $(this).is(':checked').length)
                    {
                        $("#all").prop('checked', true);
                    } else {
                        $("#all").prop('checked',false);
                    }
                    let checked = $(".product_type:checked").length;
                    if(!checked) {
                        toastr.warning("You must check at least one.");
                        $(this).prop('checked', true);
                        return false;
                    }
                    filterProducts();
                });

                function checkedAllType(){
                    $(".types").prop('checked', true);
                }

                function filterProducts(){
                    var types = [];
                    $(".types:checked").each(function() {
                        types.push($(this).val());
                    });
                    $('#pre-loader').removeClass('d-none');
                    let url =  $('#product_filter_url').val();
                    let data = {
                        "_token":_token,
                        "types":types,
                    }
                    $.post(url,data, function(response){
                        $("#product_section").html(response.productSection)
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });
        })(jQuery);
    </script>
@endpush


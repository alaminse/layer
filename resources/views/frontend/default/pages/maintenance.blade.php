@extends('errors.layout')
@section('title', __('defaultTheme.service_unavailable'))
@section('message')
    <style>
        .banner_box{
            width: 100%;
            height: auto;
        }
    </style>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content_box text-center">
                        <div class="banner_box">
                            <img src="{{showImage(app('general_setting')->maintenance_banner)}}" alt="">
                        </div>
                        <h2>{{app('general_setting')->maintenance_title}}</h2>
                        <h6>{{app('general_setting')->maintenance_subtitle}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection





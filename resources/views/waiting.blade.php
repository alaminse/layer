@extends('layouts.guest', ['title' => 'Waiting'])

@push('css')
    <style>
        .login-resistration-area .main-login-area.login-res-v2::before {
            background-image: url({{ asset(config('configs.login_backgroud_image')) }})
        }

        .login-resistration-area .main-login-area .main-content .media-link {
            float: left;
        }

    </style>
@endpush
@section('content')
    <div class="main-content">
        <div class="logo_img">
            <a href="{{ route('home') }}">
                <img src="{{ asset(config('configs.site_logo')) }}" alt="Logo Image"
                    class="img img-responsive">
            </a>
        </div>

        <h2 class="sho_web d-none d-md-block"> {{ __('auth.Thanks For Registration') }} <br>
            {{ __('auth.to your account') }}</h2>
        <h3>{{ __('auth.Please Wait For Approval. After Review , Admin Update Your Status') }}</h3>

    </div>

@endsection

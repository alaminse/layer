@extends('layouts.guest', ['title' => 'Register'])

@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontend/css/registration.css') }}">
    <style>
        .login-resistration-area .main-login-area.login-res-v2::before {
            background-image: url({{ asset(config('configs.login_backgroud_image')) }})
        }

        .login-resistration-area .main-login-area .main-content .media-link {
            float: left;
        }

        .login-resistration-area .main-login-area .main-content .customer-input nice-select {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #dde0e3;
            padding-bottom: 9px;
            margin-bottom: 19px;
        }

        .nice-select {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #dde0e3;
            padding-bottom: 9px;
            margin-bottom: 19px;
            border-radius: 0px !important;
            padding-left: 0px !important;
        }

        .nice-select-search {
            margin-bottom: 0px !important;
        }

        .nice-select.open .list {
            width: 100%;
        }

    </style>
@endpush
@section('content')
    
        @isset($type)
            @if (moduleStatusCheck('Registration'))
                @if($type == 'lawyer')
                <x-lawyer-registration />
                @endif
            @endif
        @else
            @if (moduleStatusCheck('ClientLogin'))
                <x-client-registration />
            @endif
        @endisset        

@endsection

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>  {{ isset($title)? $title .' | ' .config('configs.site_title'): config('configs.site_title') }} </title>

    <style type="text/css">
        .custome-button{
            padding: 5px 10px !important;
            border: 1px solid #c738d8 !important;
            border-radius: 20px !important;
            width: 60%;
            margin: 0 auto;
            font-size: 16px !important;
            background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
            color: white !important;
        }
    </style>

    <link rel="icon" href="{{asset(asset_path('frontend/default/img/favicon.png'))}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/bootstrap.min.css'))}}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/animate.css'))}}">
    <!-- themify CSS -->
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/themify-icons.css'))}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{ asset(asset_path('backEnd/vendors/font_awesome/css/all.min.css')) }}" />

    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset(asset_path('backEnd/vendors/css/toastr.min.css')) }}" />

    <link rel="stylesheet" href="{{ asset(asset_path('backEnd/vendors/css/nice-select.css')) }}" />

    <!-- popup -->
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/magnific-popup.css'))}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/style.css'))}}">

    @yield('styles')
    <link rel="stylesheet" href="{{asset(asset_path('backEnd/css/sales_style.css'))}}" />

    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/custom.css'))}}">


    <!-- jquery -->
    <script src="{{asset(asset_path('frontend/default/js/jquery-1.12.1.min.js'))}}"></script>


    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('public/landing/css/style.css')}}">

    @yield('styles')
</head>

<body>

<!--::header part start::-->
<section class="main_menu" id="sticky_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{asset('public/landing/img/logo.png')}}" alt="logo"> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse main-menu-item justify-content-center"
                         id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{url('/login')}}" target="_blank" >Demo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#modules">Modules</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front.page.show', 'privacy-policy') }}" target="_blank" >{{ __('saas.Privacy Policy') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front.page.show', 'terms-of-service') }}" target="_blank" >{{ __('saas.Terms of Service') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front.page.show', 'refund-policy') }}" target="_blank" >{{ __('saas.Refund Policy') }}</a>
                            </li>
                        </ul>
                    </div>
                    @guest
                    <a class="btn_1 d-none d-lg-block" href="{{ route('login') }}">{{ __('common.login') }}</a>
                    @else
                        <div class="profile_info mr_10">
                            <img src="{{ auth()->user()?->avatar && file_exists(auth()->user()->avatar) ? asset(auth()->user()->avatar) : asset('public/backEnd/img/staff.jpg') }}" alt="#">
                            <div class="profile_info_iner">
                                <p>Welcome !</p>
                                <h5>{{ auth()->user()->name }}</h5>

                                <div class="profile_info_details">

                                    <a href="{{route('home')}}">{{__('common.dashboard')}} <i class="ti-dashboard"></i></a>


                                    <a href="{{url('/profile_view')}}">{{ __('common.Profile') }} <i class="ti-user"></i></a>

                                    <a href="{{ route('logout') }}" class="log_out" >{{ __('common.log_out') }} <i class="ti-shift-left"></i> </a>

                                </div>
                            </div>
                        </div>
                    @endguest
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Header part end-->


@section('content')
@show

<!-- footer part star-->
<footer class="footer_section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="copyright_text">
                    <p> <img src="{{asset('public/landing/img/copyright.svg')}}" alt="#"> 2019-2020 InfixEdu - Ultimate Education ERP. All Rights
                        Reserved to <a href="https://aorasoft.com">Aorasoft </a> .</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer part end-->

<!-- jquery plugins here-->
<!-- jquery -->
<script src="{{asset('public/landing/js/jquery-1.12.1.min.js')}}"></script>
<!-- popper js -->
<script src="{{asset('public/landing/js/popper.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('public/landing/js/bootstrap.min.js')}}"></script>
<!-- easing js -->
<script src="{{asset('public/landing/js/jquery.magnific-popup.js')}}"></script>
<!--  -->
<script src="{{asset('public/landing/js/jquery.easing.min.js')}}"></script>
<script src="{{ asset('public/backEnd/vendors/js/toastr.min.js') }}"></script>
{!! Toastr::message() !!}

<!-- custom js -->
<script src="{{asset('public/landing/js/custom.js')}}"></script>

@stack('scripts')

</body>

</html>

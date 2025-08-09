{{--@extends('frontend.default.auth.layouts.app')--}}
{{--@section('styles')--}}
{{--    <style>--}}
{{--        .login_logo img {--}}
{{--            max-width: 140px;--}}
{{--            margin: 0 auto;--}}
{{--        }--}}
{{--        .register_part {--}}
{{--            background: var(--background_color) !important;--}}
{{--            min-height: 100vh !important;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}
{{--@section('title')--}}
{{--    {{ __('defaultTheme.email_verify') }}--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--<section class="register_part">--}}
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center align-items-center">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="register_form_iner">--}}
{{--                    <div class="login_logo text-center mb-3">--}}
{{--                        <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>--}}
{{--                    </div>--}}
{{--                    <h2>{{ __('common.welcome') }}! {{ __('common.please') }} <br>{{ __('defaultTheme.verify_your_email') }}.</h2>--}}
{{--                    <form id="registerForm" action="{{route('frontend.resend-link',$user->id)}}}" method="POST" class="register_form">--}}
{{--                        @csrf--}}
{{--                        <div class="form-row">--}}
{{--                            <div class="col-md-12 text-center">--}}
{{--                                <p>{{ __('defaultTheme.before_proceeding_please_check_your_email_for_a_varification_link_if_you_din_not_get_the_email') }}.</p>--}}
{{--                            </div>--}}
{{--                            <input type="hidden" name="verify_code" value="{{$user->verify_code}}">--}}
{{--                            <div class="col-md-12 text-center">--}}
{{--                                <div class="register_area">--}}
{{--                                    <button type="submit" id="submitBtn" class="btn_1">{{ __('defaultTheme.click_here_to_request_another') }}</button>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

{{--@endsection--}}


@extends('frontend.default.auth.layouts.app')
@section('title','Verify Email')
@section('content')
    <section class="login-area up_login">
        <div class="container">
            <div class="row login-height justify-content-center align-items-center">
                <div class="col-lg-12 col-md-12">
                    <div class="form-wrap text-center">

                        <div class="logo-container">
                            <a href="{{url('/')}}"><img class="logoimage" src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                        </div>
                        <h5 class="text-uppercase">{{ __('common.welcome') }}! {{ __('common.please') }} <br>{{ __('defaultTheme.verify_your_email') }}.</h5>


                        <form id="registerForm" action="{{route('frontend.resend-link',$user->id)}}}" method="POST" class="register_form">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 text-center">
                                    <p>{{ __('defaultTheme.before_proceeding_please_check_your_email_for_a_varification_link_if_you_din_not_get_the_email') }}.</p>
                                </div>
                                <input type="hidden" name="verify_code" value="{{$user->verify_code}}">
                                <div class="col-md-12 text-center">
                                    <div class="register_area">
                                        <button type="submit" id="submitBtn" class="btn_1">{{ __('defaultTheme.click_here_to_request_another') }}</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection






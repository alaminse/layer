<style>
    .required:after {
    color: #cc0000;
    content: " *";
    font-weight: bold;
    margin-left: 5px;
}
</style>
<div class="main-content w-100">
    <div class="logo_img">
        <a href="{{ route('home') }}">
            <img src="{{ asset(config('configs.site_logo')) }}" alt="Logo Image"
                class="img img-responsive">
        </a>
    </div>

    <h3 class="sho_web d-none d-md-block"> {{ __('auth.Welcome , Please Register') }} <br>
        {{ __('auth.to your account') }}</h3>
    <h3 class="sho_mb d-sm-block d-md-none">{{ __('auth.Welcome To Register') }}</h3>


    <div class="main-content-action">
        <ul>
            @if ($google)
                <li><a href="{{ route('auth.social.redirect', ['google']) }}">
                        <svg id="google" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                            <path id="Path_739" data-name="Path 739"
                                d="M5.538,146.621l-.87,3.247-3.179.067A12.517,12.517,0,0,1,1.4,138.268h0l2.831.519,1.24,2.814a7.457,7.457,0,0,0,.07,5.021Z"
                                transform="translate(0 -131.514)" fill="#fbbb00"></path>
                            <path id="Path_740" data-name="Path 740"
                                d="M273.63,208.176a12.49,12.49,0,0,1-4.454,12.078h0l-3.565-.182-.5-3.15a7.447,7.447,0,0,0,3.2-3.8h-6.681v-4.943h12Z"
                                transform="translate(-248.848 -198.005)" fill="#518ef8"></path>
                            <path id="Path_741" data-name="Path 741"
                                d="M49.337,316.546h0a12.5,12.5,0,0,1-18.828-3.823l4.049-3.315a7.431,7.431,0,0,0,10.709,3.8Z"
                                transform="translate(-29.02 -294.297)" fill="#28b446"></path>
                            <path id="Path_742" data-name="Path 742"
                                d="M47.7,2.877,43.65,6.19A7.43,7.43,0,0,0,32.7,10.081l-4.07-3.332h0A12.5,12.5,0,0,1,47.7,2.877Z"
                                transform="translate(-27.227)" fill="#f14336"></path>
                        </svg>
                        <span>{{ __('common.Google') }}</span>
                    </a></li>
            @endif
            @if ($facebook)
                <li><a href="{{ route('auth.social.redirect', ['facebook']) }}">
                        <svg fill="#0d8bf0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
                            height="50px">
                            <path
                                d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z" />
                        </svg>
                        <span>{{ __('common.Facebook') }}</span>
                    </a></li>
            @endif
            @if ($twitter)
                <li><a href="{{ route('auth.social.redirect', ['twitter']) }}">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                            <linearGradient id="_osn9zIN2f6RhTsY8WhY4a" x1="10.341" x2="40.798" y1="8.312" y2="38.769"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#2aa4f4" />
                                <stop offset="1" stop-color="#007ad9" />
                            </linearGradient>
                            <path fill="url(#_osn9zIN2f6RhTsY8WhY4a)"
                                d="M46.105,11.02c-1.551,0.687-3.219,1.145-4.979,1.362c1.789-1.062,3.166-2.756,3.812-4.758	c-1.674,0.981-3.529,1.702-5.502,2.082C37.86,8.036,35.612,7,33.122,7c-4.783,0-8.661,3.843-8.661,8.582	c0,0.671,0.079,1.324,0.226,1.958c-7.196-0.361-13.579-3.782-17.849-8.974c-0.75,1.269-1.172,2.754-1.172,4.322	c0,2.979,1.525,5.602,3.851,7.147c-1.42-0.043-2.756-0.438-3.926-1.072c0,0.026,0,0.064,0,0.101c0,4.163,2.986,7.63,6.944,8.419	c-0.723,0.198-1.488,0.308-2.276,0.308c-0.559,0-1.104-0.063-1.632-0.158c1.102,3.402,4.299,5.889,8.087,5.963	c-2.964,2.298-6.697,3.674-10.756,3.674c-0.701,0-1.387-0.04-2.065-0.122C7.73,39.577,12.283,41,17.171,41	c15.927,0,24.641-13.079,24.641-24.426c0-0.372-0.012-0.742-0.029-1.108C43.483,14.265,44.948,12.751,46.105,11.02" />
                        </svg>
                        <span>{{ __('common.Twitter') }}</span>
                    </a></li>
            @endif
            @if ($ios)
                <li><a href="{{ route('apple.social.redirect') }}">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22.773 22.773"
                            style="enable-background:new 0 0 22.773 22.773;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M15.769,0c0.053,0,0.106,0,0.162,0c0.13,1.606-0.483,2.806-1.228,3.675c-0.731,0.863-1.732,1.7-3.351,1.573
                       c-0.108-1.583,0.506-2.694,1.25-3.561C13.292,0.879,14.557,0.16,15.769,0z" />
                                    <path
                                        d="M20.67,16.716c0,0.016,0,0.03,0,0.045c-0.455,1.378-1.104,2.559-1.896,3.655c-0.723,0.995-1.609,2.334-3.191,2.334
                       c-1.367,0-2.275-0.879-3.676-0.903c-1.482-0.024-2.297,0.735-3.652,0.926c-0.155,0-0.31,0-0.462,0
                       c-0.995-0.144-1.798-0.932-2.383-1.642c-1.725-2.098-3.058-4.808-3.306-8.276c0-0.34,0-0.679,0-1.019
                       c0.105-2.482,1.311-4.5,2.914-5.478c0.846-0.52,2.009-0.963,3.304-0.765c0.555,0.086,1.122,0.276,1.619,0.464
                       c0.471,0.181,1.06,0.502,1.618,0.485c0.378-0.011,0.754-0.208,1.135-0.347c1.116-0.403,2.21-0.865,3.652-0.648
                       c1.733,0.262,2.963,1.032,3.723,2.22c-1.466,0.933-2.625,2.339-2.427,4.74C17.818,14.688,19.086,15.964,20.67,16.716z" />
                                </g>
                            </g>
                        </svg>
                        <span>Apple</span>
                    </a></li>
            @endif
        </ul>
        @if($google||$facebook||$twitter||$ios)
        <div class="position-relative text-center or">
            <p>{{ __('auth.or Sign in with Email') }}</p>
        </div>
        @endif
    </div>
    <div class="container">

        {!! Form::open(['route' => 'client.store.frontend', 'class' => 'customer-input form-validate-jquery', 'id' => 'content_form', 'files' => false, 'method' => 'POST']) !!}
        <div class="row">
            <input type="hidden" name="frontend" id="frontend" value="f">
            <div class="col-md-6">
                {!! Form::text('name', null, ['required' => 'required', 'autofocus' => true, 'class' => '', 'id' => 'name', 'placeholder' => __('auth.Enter Your Name').' *']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::text('mobile', null, ['required' => false, 'autofocus' => true, 'class' => '', 'id' => 'mobile', 'placeholder' => __('auth.Enter Your Mobile')]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::email('email', null, [$enable_login ? 'required' : '', 'autofocus' => true, 'class' => '', 'id' => 'email', 'placeholder' => __('auth.Enter Your Email').' *']) !!}
            </div>
            @if ($enable_login)
                <div class="col-md-6">
                    {!! Form::password('password', ['required' => 'required', 'id' => 'password', 'class' => '', 'placeholder' => __('auth.Password').' *']) !!}
                </div>
            @endif
            <div class="col-6">
                {{ Form::select('gender', ['Male' => __('common.Male'), 'FeMale' => __('common.FeMale')], null, ['class' => 'primary_select_regi', 'id' => 'gender', 'data-placeholder' => __('client.Select Gender'), 'data-parsley-errors-container' => '#gender_error']) }}
            </div>
            <div class="col-6">
                {{ Form::select('client_category_id', $client_categories, null, ['class' => 'primary_select_regi', 'id' => 'client_category_id', 'data-placeholder' => __('client.Select Division'), 'data-parsley-errors-container' => '#client_category_id_error']) }}
            </div>
            <div class="col-6">
                {{ Form::select('country_id',$countries,config('configs.country_id'),['class' => 'primary_select_regi', 'id' => 'country_id', 'id' => 'country_id', 'data-placeholder' => __('client.Select country'), 'data-parsley-errors-container' => '#country_id_error']) }}
            </div>
            <div class="col-6">
                {{ Form::select('state_id', $states, null, ['class' => 'primary_select_regi', 'id' => 'state_id', 'data-placeholder' => __('client.Select state'), 'data-parsley-errors-container' => '#state_id_error']) }}
            </div>
            <div class="col-6">
                {{ Form::select('city_id', ['' => __('common.Select State First')], null, ['class' => 'primary_select_regi', 'id' => 'city_id', 'data-placeholder' => __('client.Select city'), 'data-parsley-errors-container' => '#city_id_error']) }}
            </div>

            <div class="col-3">
                <div class="form-check">
                    <label class="primary_checkbox d-flex mr-12">
                        <input type="radio" class="  complete_order0" id="complete_order0" name="type" value="personal"
                            checked>
                        <span class="checkmark mr-2"></span> {{ __('client.Personal') }}
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <label class="primary_checkbox d-flex mr-12">
                        <input type="radio" class="  complete_order0" id="complete_order0" name="type" value="company">
                        <span class="checkmark mr-2"></span> {{ __('client.Company') }}
                    </label>
                </div>
            </div>
            <div class="col-12">
                {{ Form::textarea('address', null, ['class' => '', 'id' => 'address', 'placeholder' => __('client.Address'), 'rows' => 3]) }}
            </div>
            <div class="col-12">
            @includeIf('customfield::fields', ['fields' => $fields, 'model' => null])
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button type="submit" class="login-res-btn submit">{{ __('auth.Sign Up') }}</button>
                <button type="button" class="login-res-btn submitting" style="display:none"
                    disabled>{{ __('auth.Submitting') }}...</button>
                <p class="pl-4 mb-0">{{ __('auth.Have an Account?') }} <a
                        href="{{ route('login') }}">{{ __('auth.Login') }}</a> </p>

            </div>


        </div>
        {!! Form::close() !!}
    </div>
</div>

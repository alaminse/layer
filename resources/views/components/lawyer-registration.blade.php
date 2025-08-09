<style>
    .primary_file_uploader input {
        border: none !important;
        border-bottom: 1px solid #dde0e3 !important;
        border-radius: 0 !important;
        padding-left: 0;
        height: auto !important;
    }
    .primary_file_uploader button {top: 2px;right: 0px;z-index: 1}
    .primary_file_uploader .primary-btn.fix-gr-bg{border-radius: 100px !important}
    .attach-file-row .primary-btn.fix-gr-bg{
        padding: 9px 15px;
        line-height: 1;
        cursor: pointer;
        border-radius: 100%;
        background: -webkit-linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        background: -moz-linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        background: -o-linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        background: -ms-linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        background: linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        color: #ffffff;
        background-size: 200% auto;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .attach-file-row .primary-btn.fix-gr-bg.icon-only{
       --attach-icon: 30px;
       width: var(--attach-icon);
       height: var(--attach-icon);
       line-height: var(--attach-icon);
       border-radius: 100%;
       padding: 0 !important;
       text-align: center;
    }
    .primary_file_uploader button label {line-height: 0;cursor: pointer;}
</style>
<div class="main-content w-100">
    <div class="logo_img">
        <a href="{{ route('home') }}">
            <img src="{{ asset(config('configs.site_logo')) }}" alt="Logo Image"
                class="img img-responsive">
        </a>
    </div>

    <h3 class="sho_web d-none d-md-block mb-5"> {{ __('auth.Welcome To Register As A Lawyer')}}</h3>
    <h3 class="sho_mb d-sm-block d-md-none mb-5">{{ __('auth.Welcome To Register') }}</h3>
    <div class="mt-25">

        {!! Form::open(['route' => 'registration.lawyer.store', 'class' => 'customer-input form-validate-jquery', 'id' => 'content_form', 'files' => false, 'method' => 'POST']) !!}
        <div class="row">
            <input type="hidden" name="frontend" id="frontend" value="f">
            <div class="col-md-4">
                {!! Form::text('name', null, ['required' => 'required', 'autofocus' => true, 'class' => '', 'id' => 'name', 'placeholder' => __('auth.Enter Your Name').' *' ]) !!}
            </div>

            <div class="col-md-4">
                {!! Form::email('email', null, ['required' => true, 'autofocus' => true, 'class' => '', 'id' => 'email', 'placeholder' => __('auth.Enter Your Email') .' *']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::text('mobile', null, ['required' => false, 'autofocus' => true, 'class' => '', 'id' => 'mobile', 'placeholder' => __('auth.Enter Your Mobile')]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::password('password', ['required' => 'required', 'id' => 'password', 'class' => '', 'placeholder' => __('auth.Password') .' *']) !!}
            </div>
            <div class="col-md-6">               
                <input type="text" name="date_of_birth" placeholder="{{ __('common.Date Of Birth') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">

            </div>
            
            <div class="col-md-12">
                {!! Form::text('current_address', null, ['placeholder' => __('common.Address'), 'type' => 'text']) !!}
            </div>
            {{-- <div class="col-md-6">
                {!! Form::text('permanent_address', null, ['placeholder' => __('common.Permanent Address'), 'type' => 'text']) !!}
            </div> --}}
            
            <div class="col-md-12">
                <div class="row mt-3 attach-file-row">
                    <div class="col-5">
                        {!! Form::text('title[]', null, ['autofocus' => true, 'class' => '', 'id' => 'name', 'placeholder' => __('auth.Enter Title')]) !!}
                    </div>
                    <div class="col-5">
                        <div class="primary_input flex-grow-1">
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="placeholderAttachFile"
                                    placeholder="{{ __('common.Browse file') }}" readonly>
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg" for="attach_file">{{ __('common.Browse') }} </label>
                                    <input type="file" class="d-none" name="file[]" id="attach_file">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 pull-right">
                        <button style="cursor:pointer;" class="btn primary-btn small fix-gr-bg icon-only" type="button"
                        id="file_add"> <i class="ti-plus m-0"></i> </button>
                    </div>                    
                </div>                
            </div>
            <div class="col-md-12 appendDiv">
                               
            </div>
            <div class="col-12 mt-25">
                <div class="d-flex align-items-center justify-content-between">
                    <button type="submit" class="login-res-btn submit">{{ __('auth.Sign Up') }}</button>
                    <button type="button" class="login-res-btn submitting" style="display:none"
                        disabled>{{ __('auth.Submitting') }}...</button>
                    <p class="pl-4 mb-0">{{ __('auth.Have an Account?') }} <a
                            href="{{ route('login') }}">{{ __('auth.Login') }}</a> </p>

                </div>

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

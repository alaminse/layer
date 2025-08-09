<!--::header part start::-->
<section class="main_menu" id="sticky_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">

                    <a class="navbar-brand" href="{{route('home')}}"> <img src="{{ asset(config('configs.site_logo')) }}" alt="logo"> </a>
                    <div class="collapse navbar-collapse main-menu-item justify-content-center"
                         id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center">


                        </ul>
                    </div>

                    @if(auth()->check())

                        <!-- profile hover  -->
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
                        <!-- profile hover::end  -->

                    @else
                        <div class="d-flex align-items-center">
                            <a class="btn_1 d-lg-block mr-10" href="{{route('login')}}">{{__('common.login')}}</a>
                        </div>
                    @endif



                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Header part end-->
<ul class="short_curt_icons">
    <li>
        <a href="{{route('login')}}">
            <i class="ti-signin"></i>
        </a>
    </li>
</ul>

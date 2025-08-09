<!DOCTYPE html >

    <html dir="{{ rtl() ? 'rtl' : 'ltr' }}" class="{{ rtl() ? 'rtl' : '' }}" lang="{{ session()->get('locale', Config::get('app.locale')) }}">
    

        <head>
            <style>
                :root {
                    --base_font : {{ in_array(session()->get('locale', Config::get('app.locale')), ['ar']) ?  'Cairo,' : ''}}Poppins, sans-serif;
                    @foreach($color_theme->colors as $color)
--{{ $color->name}}: {{ $color->pivot->value }};
                    @if(in_array($color->name, ['success', 'danger']))
--{{ $color->name}}_with_opacity: {{ $color->pivot->value }}23;
                @endif
            @endforeach
        
}
            </style>
            <!-- Required meta tags -->
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <link rel="icon" href="{{ asset(config('configs.favicon_logo')) }}"
                  type="image/png" />

            <title>
                {{ isset($title)? $title .' | ' .config('configs.site_title'): config('configs.site_title') }}
            </title>

            <meta name="_token" content="{!! csrf_token() !!}" />


            <!-- Bootstrap CSS -->


            @if (rtl())
                <link rel="stylesheet" href="{{ asset('public/backEnd/css/rtl/bootstrap.min.css') }}" />
            @else
                <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/bootstrap.css" />
            @endif

            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/jquery-ui.css" />
            <link rel="stylesheet" href="{{ asset('public/frontend/') }}/vendors/text_editor/summernote-bs4.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/jquery.data-tables.css">
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/buttons.dataTables.min.css">
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/rowReorder.dataTables.min.css">
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/responsive.dataTables.min.css">

            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/bootstrap-datetimepicker.min.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/bootstrap-datepicker.min.css" />
            <link rel="stylesheet" href="{{ asset('public/frontend/') }}/vendors/font_awesome/css/all.min.css" />

            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/themify-icons.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/flaticon.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/font-awesome.min.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/nice-select.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/magnific-popup.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/fastselect.min.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/toastr.min.css" />
            <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/js/select2/select2.css" />

            <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/fullcalendar.min.css') }}">
            <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/daterangepicker.css') }}" />


            <!-- color picker  -->

            <!-- metis menu  -->
            <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/metisMenu.css">

            @yield('css')
            <link rel="stylesheet" href="{{ asset('public/backEnd/css/loade.css') }}" />
            <link rel="stylesheet" href="{{ asset('public/css/parsley.css') }}" />



            @if (rtl())
                <link rel="stylesheet" href="{{ asset('public/backEnd/css/rtl/style.css') }}" />
                <link rel="stylesheet" href="{{ asset('public/backEnd/css/rtl/infix.css') }}" />
            @else
                <link rel="stylesheet" href="{{ asset('public/backEnd/css/style.css') }}" />
                <link rel="stylesheet" href="{{ asset('public/backEnd/css/infix.css') }}" />
            @endif

            <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/style.css" />
            <!--  -->
            @stack('css_before')



            <script>
                const SET_DOMAIN = "{{ url('/') }}"

                const RTL = {{ rtl() ? 'true' : 'false' }};
                const LANG = "{{ session()->get('locale', Config::get('app.locale')) }}";
            </script>

        
        </head>

        @php
            if (empty($color_theme)) {
             $css = "background: url('".asset('/public/backEnd/img/body-bg.jpg')."')  no-repeat center; background-size: cover; ";
         } else {
             if (!empty($color_theme->background_type == 'image')) {
                 $css = "background: url('" . url($color_theme->background_image) . "')  no-repeat center; background-size: cover; background-attachment: fixed; background-position: top; ";
             } else {
                 $css = "background:" . $color_theme->background_color;
             }
         }

        @endphp

        <body class="admin"  style="{!! $css !!} ">

        <div class="preloader">
            <h3 data-text="{{ config('configs.preloader') }}..">
                {{ config('configs.preloader') }}..</h3>
        </div>

        <div class="main-wrapper" style="min-height: 600px">

            @php

                if ( config('configs.site_logo') && file_exists(config('configs.site_logo'))) {
                    $tt = file_get_contents(base_path(config('configs.site_logo')));
                } else {
                    $tt = file_get_contents(public_path('/uploads/settings/logo.png'));
                }

            @endphp
            <input type="text" hidden value="{{ base64_encode($tt) }}" id="logo_img">
            <!-- Sidebar  -->

            @if (moduleStatusCheck('AdvSaas') && Auth::user()->is_saas_admin == 1 && Auth::user()->active_panel == 'saas')
                @include('advsaas::partials.sidebar')
            @else
                @include('partials.sidebar')
            @endif


            <!-- Page Content  -->
            <div id="main-content">
    @include('partials.menu')

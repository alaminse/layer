<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>
<meta name="_token" content="@php echo csrf_token(); @endphp" />

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
<link rel="stylesheet" href="{{asset(asset_path('backEnd/css/preloader.css'))}}" />

<!-- jquery -->
<script src="{{asset(asset_path('frontend/default/js/jquery-1.12.1.min.js'))}}"></script>

<input type="hidden" id="url" value="{{url('/')}}">




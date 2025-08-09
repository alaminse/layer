<!-- jquery plugins here-->

<!-- popper js -->
<script src="{{asset(asset_path('frontend/default/js/popper.min.js'))}}"></script>
<!-- bootstrap js -->
<script src="{{asset(asset_path('frontend/default/js/bootstrap.min.js'))}}"></script>
<!-- easing js -->
<script src="{{asset(asset_path('frontend/default/js/jquery.magnific-popup.js'))}}"></script>
<!--  -->
<script src="{{asset(asset_path('frontend/default/js/jquery.easing.min.js'))}}"></script>
<!-- custom js -->
<script src="{{asset(asset_path('frontend/default/js/custom.js'))}}"></script>

<script type="text/javascript" src="{{asset(asset_path('backEnd/vendors/js/toastr.min.js'))}}"></script>

<script src="{{asset(asset_path('backEnd/vendors/js/nice-select.min.js'))}}"></script>


@php echo Toastr::message(); @endphp

@stack('scripts')

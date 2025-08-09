<!doctype html>
<html lang="en">
<head>
    @include('frontend.default.partials._head')
</head>
<body>
<div id="pre-loader" class="d-none">
    @include('backEnd.partials.preloader')
</div>
@include('frontend.default.partials._sticky_menu')
@if(isset($banner) && $banner)
    @include('frontend.default.partials._banner')
@endif
@section('content')
    @show

@include('frontend.default.partials._footer')
<!--cart route -->

@include('frontend.default.partials._script')
</body>
</html>

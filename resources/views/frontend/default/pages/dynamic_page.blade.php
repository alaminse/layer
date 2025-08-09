@extends('frontend.default.layouts.app')
@section('title',app('general_setting')->site_title.' | '. $pageData->title )
@section('breadcrumb',$pageData->title)
@section('content')
@include('frontend.default.partials._breadcrumb')
<div class="container-fluid">
    {!! $pageData->description !!}
</div>
@endsection

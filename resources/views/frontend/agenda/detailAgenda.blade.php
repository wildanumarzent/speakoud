@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                     <h1 >DETAIL AGENDA</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap bg-grey-alt">
   	<!-- Content -->
	<H1>DETAIL AGENDA</H1>
	<!-- / Content -->
</div>
@endsection


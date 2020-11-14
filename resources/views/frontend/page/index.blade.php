@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>{!! $data['read']->judul !!}</h1>

                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap single-post">
    <div class="container">
        <div class="box-content mt-5">
            <article>
                {!! $data['read']->content !!}
            </article>
        </div>
    </div>
</div>
@endsection

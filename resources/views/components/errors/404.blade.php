@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>Ooops...</h1>

                </div>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">404 Not Found</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" alt="">
    </div>
</div>
<div class="box-wrap single-post">
    <div class="container">
        <div class="box-content mt-5">
            <article>
                <h3>Maaf, halaman yang Anda cari tidak ditemukan</h3>
                <p>Silakan periksa alamatnya dan coba lagi.</p>
            </article>
        </div>
    </div>
</div>
@endsection

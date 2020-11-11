@extends('layouts.frontend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/swiper.min.css') }}">
@endsection

@section('layout-content')
<div id="page" class="bg-sign">
    <div class="logo-signbox">
        <div class="logo">
            <img src="{{ asset(config('addon.images.logo')) }}" alt="Logo BPPT">
        </div>
        <h5>@lang('strip.title_header')</h5>
    </div>
    <div class="wrapper-flex">
        <div class="banner-signbox">
            <div class="banner-title">
                <div class="title-heading text-center">
                    <h1>{!! $configuration['website_name'] !!}</h1>
                    <h5>@lang('strip.application_description')</h5>
                </div>
            </div>
            <div class="swiper-container swiper-1" style="height: 100vh; width: 100%;">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="thumbnail-img">
                            <img src="{{ asset('assets/tmplts_frontend/images/slide-1.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="thumbnail-img">
                            <img src="{{ asset('assets/tmplts_frontend/images/slide-2.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-signbox">
            <div class="form-signbox-top">
                <a href="{{ route('home') }}" class="link-icon ml-auto" title="Beranda">
                    Beranda
                    <span>
                        <i class="las la-home"></i>
                    </span>
                </a>
            </div>
            <div class="form-signbox-center">
                <div class="item-signbox">
                    <ul class="nav-signbox">
                        <li class="{{ Request::is('login') ? 'active' : '' }}">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="">Register</a>
                        </li>
                    </ul>
                </div>
                <div class="item-signbox">
                    <div class="title-heading">
                        <h3>@lang('strip.login_title')</h3>
                    </div>
                </div>
                <div class="item-signbox form">
                    @yield('content')
                </div>
            </div>
            <div class="form-signbox-bottom">
                Copyright © {{ now()->format('Y') }} Pusat Pembinaan, Pendidikan dan Pelatihan BPPT
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_frontend/js/swiper.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //SLIDER HOME
    var swiper = new Swiper('.swiper-1', {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 1000,
        autoplay: {
            delay: 3000,
        },
        parallax: true,
        draggable: false,
        simulateTouch: false,
        loop: 'true',
        effect: 'fade',
    });
</script>
@endsection

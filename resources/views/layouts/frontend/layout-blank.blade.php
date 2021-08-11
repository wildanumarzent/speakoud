@extends('layouts.frontend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/swiper.min.css') }}">
@endsection

@section('layout-content')
<div id="page" class="bg-sign">
    <div class="logo-signbox">
        <div class="logo">
            {{-- <img src="{{ asset(config('addon.images.logo')) }}" title="BPPT" alt="Logo BPPT"> --}}
        </div>
        <h5>SPEAKOUD</h5>
    </div>
    <div class="wrapper-flex">
        @foreach ($banner['login'] as $login)
        <div class="banner-signbox">
            <div class="banner-title">
                <div class="title-heading text-center">
                    {!! $login->keterangan !!}
                </div>
            </div>
            <div class="swiper-container swiper-1" style="height: 100vh; width: 100%;">
                <div class="swiper-wrapper">
                    @foreach ($login->banner as $banner)
                    <div class="swiper-slide">
                        <div class="thumbnail-img">
                            <img src="{{ asset(config('addon.images.path.banner').$login->id.'/'.$banner->file) }}" title="{!! $banner->judul !!}" alt="{!! strip_tags(Str::limit($banner->keterangan, 25)) !!}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        <div class="form-signbox">
            <div class="form-signbox-top">
                <a href="{{ route('home') }}" class="link-icon ml-auto" title="@lang('layout.menu.home')">
                    @lang('layout.menu.home')
                    <span>
                        <i class="las la-home"></i>
                    </span>
                </a>
            </div>
            <div class="form-signbox-center">
                <div class="item-signbox">
                    <ul class="nav-signbox">
                        <li class="{{ Request::is('login') ? 'active' : '' }}">
                            <a href="{{ route('login') }}" title="@lang('layout.menu.login')">@lang('layout.menu.login')</a>
                        </li>
                        <li class="{{ Request::is('register') ? 'active' : '' }}">
                            <a href="{{ route('register') }}" title="@lang('layout.menu.register')">@lang('layout.menu.register')</a>
                        </li>
                    </ul>
                </div>
                @yield('content')
            </div>
            <div class="form-signbox-bottom">
                Copyright © {{ now()->format('Y') }} SPEAKOUD by Sinergi Digital Powered by Sinergi Consulting
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

@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/swiper.min.css') }}">
@endsection

@section('content')
{{-- banner --}}
@if ($data['banner']->banner()->count() > 0)
<div class="slide-intro">
    <div class="swiper-container swiper-1">
        <div class="swiper-wrapper">
            @foreach ($data['banner']->banner as $banner)
            <div class="swiper-slide">
                <div class="slide-inner" data-swiper-parallax="45%">
                    <div class="slide-inner-overlay"></div>
                    <div class="slide-inner-image thumbnail-img">
                        <img src="{{ asset(config('addon.images.path.banner').$banner->banner_kategori_id.'/'.$banner->file) }}" title="{!! $banner->judul !!}" alt="{!! strip_tags(Str::limit($banner->keterangan, 25)) !!}">
                    </div>
                    <div class="slide-inner-info title-heading">
                        @if ($loop->first)
                        <h6 class="Text-white">@lang('strip.banner_welcome')</h6>
                        @endif
                        <h1 data-swiper-parallax="-400px">{!! $banner->judul !!}</h1>
                        {!! $banner->keterangan !!}
                        @if (!empty($banner->link))
                        <div class="box-btn">
                            <a href="{!! $banner->link !!}" class="btn btn-primary text-white" title="{!! $banner->judul !!}">@lang('strip.button_selengkapnya')</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-next sbn-1"><i class="la la-angle-right"></i></div>
        <div class="swiper-button-prev sbp-1"><i class="la la-angle-left"></i></div>
    </div>
</div>
@endif
{{-- page one --}}
@if (!empty($data['pageOne']))
<div class="box-wrap">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-5">
                <div class="video-intro">
                    <div class="thumbnail-img">
                        <img src="{{ $data['pageOne']->getCover($data['pageOne']->cover['filename']) }}" title="{{ $data['pageOne']->cover['title'] }}" alt="{{ $data['pageOne']->cover['alt'] }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="title-heading">
                    <h6>BPPT @lang('strip.title_header')</h6>
                    <h1>{!! $data['pageOne']->judul !!}</h2>
                </div>
                <article class="summary-text">
                    {!! $data['pageOne']->content !!}
                </article>
            </div>

        </div>
    </div>
</div>
@endif
{{-- page six --}}
@if (!empty($data['pageSix']))
<div class="box-wrap bg-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading text-white text-center">
                    <h6>BPPT @lang('strip.title_header')</h6>
                    <h1>{!! $data['pageSix']->judul !!}</h2>
                    <div class="box-btn">
                        <a href="{{ route('page.read', ['id' => $data['pageSix']->id, 'slug' => $data['pageSix']->slug]) }}" class="btn btn-primary white" title="{!! $data['pageSix']->judul !!}">
                            @lang('strip.button_selengkapnya')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- program pelatihan --}}
<div class="box-wrap bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading">
                    <h6>BPPT @lang('strip.title_header')</h6>
                    <h1>@lang('strip.widget_1_title')</h2>
                </div>
                <div class="summary-text m-0">
                    <p>@lang('strip.widget_1_description')</p>
                </div>
            </div>
        </div>
        <div class="swiper-container mt-5 swiper-2" style="overflow: visible;">
            <div class="swiper-wrapper">

                @foreach ($data['mata'] as $mata)
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ $mata->getCover($mata->cover['filename']) }}" title="{{ $mata->cover['title'] }}" alt="{{ $mata->cover['alt'] }}">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                {{ $mata->publish_start->format('d F Y') }}
                            </div>
                            <h5 class="post-title">
                                {!! $mata->judul !!}
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
                @if ($data['mata']->count() == 0)
                <div>
                    <h5 style="color: red;">! Tidak ada program pelatihan !</h5>
                </div>
                @endif

            </div>
            <div class="box-btn d-flex align-items-center  mt-xl-5">
                <div class="swiper-btn-wrapper">
                    <div class="swiper-button-prev swiper-btn sbp-2"><i class="la la-angle-left"></i></div>
                    <div class="swiper-button-next swiper-btn sbn-2"><i class="la la-angle-right"></i></div>
                </div>
                <a href="{{ route('course.list') }}" class="link-icon ml-xl-auto" title="@lang('strip.widget_1_button')">
                    @lang('strip.widget_1_button')
                    <span>
                        <i class="las la-arrow-right"></i>
                    </span>
                </a>

            </div>
        </div>
    </div>
</div>
{{-- acara --}}
<div class="box-wrap bg-grey-alt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading text-center">
                    <h6>BPPT @lang('strip.title_header')</h6>
                    <h1>@lang('strip.widget_2_title')</h2>
                    <div class="summary-text m-0">
                        <p>@lang('strip.widget_2_description')</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            @for ($i = 0; $i < 6; $i++)
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">

                        <div class="thumbnail-img">
                            <img src="{{ asset('assets/tmplts_frontend/images/study-3.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="detail-jadwal.html">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endfor

        </div>
        <div class="box-btn d-flex justify-content-center">
            <a href="" class="link-icon">
                @lang('strip.widget_2_button')
                <span>
                    <i class="las la-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
{{-- langganan --}}
<div class="box-wrap bg-blue">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="title-heading text-center text-white">
                    <h6>BPPT @lang('strip.title_header')</h6>
                    <h1>@lang('strip.widget_3_title')</h2>
                    <div class="summary-text m-0">
                        <p>@lang('strip.widget_3_description')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="" class="subs-box">
                    <input class="form-control" type="email" placeholder="Email address">
                    <button class="btn btn-primary white">@lang('strip.widget_3_button')</button>
                </form>
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
            delay: 5000,
        },
        parallax: true,
        draggable: false,
        simulateTouch: false,
        loop: 'true',
        navigation: {
            nextEl: '.sbn-1',
            prevEl: '.sbp-1',
            }
    });

    var swiper = new Swiper('.swiper-2', {
        slidesPerView: 3,
        spaceBetween: 20,
        speed: 1000,
        parallax: true,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.sbn-2',
            prevEl: '.sbp-2',
            }
    });
</script>
@endsection

@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>@lang('strip.widget_2_title_2')</h1>

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
    <div class="container">
        <div class="row">

            @foreach ($data['jadwal'] as $item)
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">

                        <div class="thumbnail-img">
                            <img src="{{ $item->getCover($item->cover['filename']) }}" title="{{ $item->cover['title'] }}" alt="{{ $item->cover['alt'] }}">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            {{ $item->created_at->format('d F Y') }}
                        </div>
                        <a href="{{ route('course.jadwal.detail', ['id' => $item->id]) }}">
                            <h5 class="post-title">
                                {!! $item->judul !!}
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Jam Mulai</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($item->start_time)->format('H:i A') }}</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">Jam Selesai</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($item->end_time)->format('H:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

        </div>

        @if ($data['jadwal']->count() == 0)
        <div class="text-center">
            <h5 style="color: red;">! Tidak ada jadwal pelatihan !</h5>
        </div>
        @endif

        <div class="box-btn d-flex justify-content-center">
            {{ $data['jadwal']->onEachSide(3)->links() }}
        </div>
    </div>
</div>
@endsection

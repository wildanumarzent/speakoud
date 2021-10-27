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
            {{-- @include('components.breadcrumbs') --}}
        </div>
    </div>
    <div class="">
        <img src="{{ $configuration['banner_default'] }}" width="100%" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap">
    <div class="container">
        <div class="row justify-content-xl-between">
            <div class="col-md-5">
                <div class="mb-3">
                    <div class="">
                        <img src="{{ $data['read']->getCover($data['read']->cover['filename']) }}" width="100%" title="{{ $data['read']->cover['title'] }}" alt="{{ $data['read']->cover['alt'] }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-post">
                    <div class="post-date">
                        {{ $data['read']->created_at->format('d F Y') }}
                    </div>
                    <div class="post-info flex-column">
                        <div class="box-info mb-3">
                            <div class="item-info text-left">
                                <span class="ml-4">Tanggal Mulai</span>
                                <div class="data-info">
                                    <i class="las la-calendar"></i>
                                    <span>{{ $data['read']->start_date->format('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="item-info text-left">
                                <span class="ml-4">Tanggal Selesai</span>
                                <div class="data-info">
                                    <i class="las la-calendar"></i>
                                    <span>{{ $data['read']->end_date->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-info mb-3">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">Jam</span>
                                <div class="data-info">
                                    <i class="las la-clock"></i>
                                    <span>{{ \Carbon\Carbon::parse($data['read']->start_time)->format('H:i A').' - '.\Carbon\Carbon::parse($data['read']->end_time)->format('H:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-info mb-5">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">Tempat</span>
                                <div class="data-info">
                                    <i class="las la-map-marker"></i>
                                    <span>{!! $data['read']->lokasi !!}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <article class="summary-text m-0">
                        {!! $data['read']->keterangan !!}
                    </article>
                    <div class="box-btn">
                        {{-- <a href="{{ route('course.register', ['id' => $data['read']->mata_id]) }}" class="btn btn-primary">Daftar</a> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>@lang('strip.widget_1_title')</h1>

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

            @foreach ($data['mata'] as $item)
            <div class="col-md-4">
                <div class="item-post">
                    <div class="box-img">
                        <div class="thumbnail-img">
                            <img src="{{ $item->getCover($item->cover['filename']) }}" title="{{ $item->cover['title'] }}" alt="{{ $item->cover['alt'] }}">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            {{ $item->created_at->format('d F Y') }}
                        </div>
                        <h5 class="post-title">
                            <a href="{{ route('course.detail', ['id' => $item->id]) }}">{!! $item->judul !!}</a>
                        </h5>
                        <div class="post-info">
                            <a href="{{ route('course.detail', ['id' => $item->id]) }}" class="btn btn-primary mr-auto">@lang('strip.widget_1_button')</a>
                            <div class="box-info">
                                <div class="item-info">
                                    <div class="data-info">
                                        <i class="las la-user"></i>
                                        <span>{{ $item->peserta->count() }}</span>
                                    </div>
                                    <span>Enrolled</span>
                                </div>
                                <div class="item-info">
                                    <div class="data-info">
                                        <i class="las la-comment"></i>
                                        <span>{{ $item->materi->count() }}</span>
                                    </div>
                                    <span>Topics</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

        </div>

        @if ($data['mata']->count() == 0)
        <div class="text-center">
            <h5 style="color: red;">! Tidak ada program pelatihan !</h5>
        </div>
        @endif

        <div class="box-btn d-flex justify-content-center">
            {{ $data['mata']->onEachSide(3)->links() }}
        </div>
    </div>
</div>
@endsection

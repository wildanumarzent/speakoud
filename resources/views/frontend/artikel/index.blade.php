@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>@lang('strip.article_title')</h1>

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
            @foreach ($data['artikel'] as $item)
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            {{ $item->created_at->format('d F Y') }}
                        </div>
                        <div class="thumbnail-img">
                            <img src="{{ $item->getCover($item->cover['filename']) }}" title="{{ $item->cover['title'] }}" alt="{{ $item->cover['alt'] }}">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            {{-- Marketing --}}
                        </div>
                        <a href="{{ route('artikel.read', ['id' => $item->id, 'slug' => $item->slug]) }}">
                            <h6 class="post-title">
                                {!! $item->judul !!}
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        @if ($data['artikel']->count() == 0)
        <div class="text-center">
            <h5 style="color: red;">! Tidak ada artikel !</h5>
        </div>
        @endif

        <div class="box-btn d-flex justify-content-center">
            {{ $data['artikel']->onEachSide(3)->links() }}
        </div>
    </div>
</div>
@endsection

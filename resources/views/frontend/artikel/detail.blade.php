@extends('layouts.frontend.layout')

@section('classes', 'bannerless')

@section('content')
<div class="box-wrap single-post">
    <div class="container">

        <!-- <div class="breadcrumb justify-content-center">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="current"><a href="">Artikel</a></li>
            </ul>
        </div> -->
        <div class="box-post text-center">
            <div class="post-date">
                {{ $data['read']->created_at->format('d F Y') }}
            </div>
            <div class="title-heading text-center">
                <h1>{!! $data['read']->judul !!}</h1>
            </div>
            <div class="post-info justify-content-center">
                <div class="box-info mb-3">
                    <div class="item-info text-left">
                        <span class="ml-4">Create</span>
                        <div class="data-info">
                            <i class="las la-user-edit"></i>
                            <span>{!! $data['read']->userCreated['name'] !!}</span>
                        </div>
                    </div>
                    <div class="item-info text-left">
                        <span class="ml-4">Tags</span>
                        <div class="data-info">
                            <i class="las la-tag"></i>
                            @if ($data['read']->tags()->count() > 0)
                                @foreach($data['read']->tags as $tag)
                                <span class="ml-1">{{$tag->parent->nama.","}}</span>
                                @endforeach
                            @else
                            <span>No Tags</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-content mt-5">
            <article>
                {!! $data['read']->content !!}
            </article>
        </div>
        @livewire('komentar-form',['model' => $data['read']])

    </div>
</div>
<div class="box-wrap bg-grey">
<div class="container">
    <div class="title-heading mb-4">
        <h6>BPPT @lang('strip.title_header')</h6>
        <h1>@lang('strip.article_recent')</h1>
    </div>
    <div class="row mt-5">

        @foreach ($data['recent'] as $item)
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



            @if ($data['recent']->count() == 0)
            <div class="d-flex justify-content-center">
                <h5 style="color: red;">! Tidak ada artikel lainnya !</h5>
            </div>
            @endif

    </div>
</div>
</div>
@endsection

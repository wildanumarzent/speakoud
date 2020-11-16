@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>Artikel</h1>
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
            @forelse($data['artikel'] as $artikel)
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            {{$artikel->created_at->format('Y M d')}}
                        </div>
                        <div class="thumbnail-img">
                            <img src="{{$artikel->getCover($artikel->cover)}}" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            @forelse($artikel->tags as $tag) {{$tag->parent->nama.","}} @empty  @endforelse
                        </div>
                        <a href="{{route('artikel.show',['id' => $artikel->id,'slug'=>$artikel->slug])}}">
                            <h6 class="post-title">
                                {{$artikel->title}}
                            </h6>
                        </a>
                    </div>
                </div>
            </div>

            @empty
            <h1 class="text-center">Data Artikel Kosong</h1>
            @endforelse
        </div>
        {{-- <div class="box-btn d-flex justify-content-center">
            <a href="" class="link-icon">
                Lihat lainnya
                <span>
                    <i class="las la-arrow-right"></i>
                </span>
            </a>
        </div> --}}
    </div>
</div>

@endsection

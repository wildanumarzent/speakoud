@extends('layouts.frontend.layout')

@section('content')
<main>
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
                   {{$data['artikel']->created_at->format('Y M d')}}
                </div>
                <div class="title-heading text-center">
                    <h1>{{$data['artikel']->title}}</h1>
                </div>
                <div class="post-info justify-content-center">
                    <div class="box-info mb-3">
                        <div class="item-info text-left">
                            <span class="ml-4">Create</span>
                            <div class="data-info">
                                <i class="las la-user-edit"></i>
                                <span>{{$data['artikel']->user->name}}</span>
                            </div>
                        </div>
                        <div class="item-info text-left">
                            <span class="ml-4">Tags</span>
                            <div class="data-info">
                                <i class="las la-tag"></i>
                                @forelse($data['artikel']->tags as $tag)<span class="ml-1">{{$tag->parent->nama.","}}</span> @empty <span class="ml-1">Null</span> @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-content mt-5">
                <article>
                    <article>
                          {!!$data['artikel']->intro!!}
                        {{-- <img src="{{$data['artikel']->getCover($data['artikel']->cover)}}" style="float: left;"> --}}
                        {!!$data['artikel']->content!!}
                    </article>
                </article>
            </div>
        </div>
    </div>
    <div class="box-wrap bg-grey">
    <div class="container">
        <div class="title-heading mb-4">
            <h6>BPPT E-Learning</h6>
            <h1>Recent Post</h1>
        </div>
        <div class="row mt-5">
            @forelse($data['recent'] as $artikel)
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
                <h3 class="text-center text-bold">Tidak Ada Post Lain...</h3>
            @endforelse

        </div>
    </div>
    </div>
</main>
@endsection

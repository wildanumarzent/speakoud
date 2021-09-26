@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
	<div class="container">
		<div class="banner-content">
			<div class="banner-text">
				<div class="title-heading text-center">
					<h1>DETAIL MATERI</h1>
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
	<!-- Content -->
	<div class="container flex-grow-1 container-p-y">
        <div class="title-heading">
            <h1>{{ $data['mata']->judul}}</h1>
        </div>
		<div class="row justify-content-between mb-5">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                       <div class="item-media">
                           <div class="box-icon-media">
                               <div class="thumbnail-img">
                                   <img src="{{ asset('/userfile/photo/'.$data['mata']->creator->photo['filename'] != null ? '/userfile/photo/'.$data['mata']->creator->photo['filename'] : '/userfile/photo/assets/img/speakoud.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
                               </div>
                               <i class="las la-user-tie"></i>
                           </div>
                           <div class="media-body">
                               <span>Instruktur</span>
                               <h6>{{$data['mata']->creator->name}}</h6>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-6 col-lg-4">
                       <div class="item-media">
                           <div class="box-icon-media">
                               <i class="las la-tag"></i>
                           </div>
                           <div class="media-body">
                               <span>Kategori</span>
                               <h6>{{$data['mata']->program->judul}}</h6>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-6 col-lg-4">
                       <div class="item-media">
                       <div class="box-icon-media">
                               <i class="las la-star-half-alt"></i>
                           </div>
                           <div class="media-body">
                               <span>Review</span>
                               <div class="box-stars">
                                   @foreach ($data['numberRating'] as $i)
                                       <i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.2em;"></i>
                                   @endforeach
                                   <strong style="margin-left: 5px; color: black"> ({{ $data['mata']->getRating('student_rating') }})</strong>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="d-flex flex-column">
                    <div class="box-price mb-3">
                        @if($data['mata']->price == 0 || $data['mata']->price == null)
                        <div class="large free">Free
                        @else
                        <div class="large no-free">Rp. {{number_format($data['mata']->price)}}
                        @endif
                        </div>
                    </div>
                    {{-- {{dd( $data['peserta']->status_peserta == 1 || $data['instruktur'] != null)}} --}}
                    @role('peserta_internal|instruktur_internal')
                        @if ($data['peserta'] != null)
                            @if (auth()->user() != null)
                                @if ($data['peserta']->status_peserta == 1)
                                <a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" target="_blank" class="btn btn-primary filled">Mulai</a>
                                    @else
                                    <a href="{{ route('profile.front',['id'=> $data['mata']->id]) }}" target="_blank" class="btn btn-primary filled">Mulai</a>
                                @endif
                            @else
                            <a href="{{ route('register') }}" target="_blank" class="btn btn-primary filled">Daftar</a>
                            @endif
                        @else
                            @if ($data['instruktur'] != null)
                                 <a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" target="_blank" class="btn btn-primary filled">Mulai</a>
                            @else 

                            <a href="{{ route('register') }}" target="_blank" class="btn btn-primary filled">Daftar</a>
                            @endif
                        @endif
                        @elserole('administrator')
                            <a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" target="_blank" class="btn btn-primary filled">PREVIEW</a>
                        @else
                        <a href="{{ route('register') }}" target="_blank" class="btn btn-primary filled">Daftar</a>

                    
                    @endrole
                </div>
            </div>
		</div>
        <ul class="nav nav-tabs tabs-alt container-m-nx container-p-x mb-4">
            <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#search-pages">Overview</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#search-people">Kurikulum</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#search-images">Instruktur</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#search-videos">Reviews</a>
            </li>
        </ul>
		<div class="tab-content">
			<!-- overview -->
			@include('frontend.pelatihan.include.overview')
			<!-- / overview -->

			<!-- curiculum -->
			@include('frontend.pelatihan.include.curiculum')
			<!-- / curiculum -->

			<!-- instructor -->
			@include('frontend.pelatihan.include.instruktor')
			<!-- / instructor -->

			<!-- Reviews -->
			@include('frontend.pelatihan.include.reviews')
            <!-- /Reviews -->
		</div>
	</div>
	<!-- / Content -->
</div>
@endsection

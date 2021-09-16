@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
	<div class="container">
		<div class="banner-content">
			<div class="banner-text">
				<div class="title-heading text-center">
					<h1 style="color:white">DETAIL MATERI</h1>
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
	<div class="container-fluid flex-grow-1 container-p-y">
		<h1 class="mb-3"><strong>{{ $data['mata']->judul}}</strong></h1>
		<div class="row">
			 <div class="col-md-3">
				<div class="media mb-3">
					<img src="{{ asset('/userfile/photo/'.$data['mata']->creator != null ? '/userfile/photo/'.$data['mata']->creator->photo['filename'] : '/userfile/photo/assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
					<div class="media-body pt-2 ml-3">
						<h6 class="mb-2"> <strong style="color: grey">Instruktur</strong></h6>
						<h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->creator->name}}</strong></h6>
					</div>
				</div>
			</div>
			<div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
			<div class="col-md-2">
				<div class="media mb-3">
					<div class="media-body pt-2 ml-3">
						<h6 class="mb-2"><strong style="color: grey">Kategori</strong></h6>
						<h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->program->judul}}</strong></h6>
					</div>
				</div>
			</div>
			<div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
			<div class="col-md-3">
				<div class="media mb-3">
					<div class="media-body pt-2 ml-3">
						<h6 class="mb-2"><strong style="color: grey">Review</strong></h6>
						@foreach ($data['numberRating'] as $i)
							<i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.2em;"></i>
						@endforeach
						<strong style="color: black"> ( {{ $data['mata']->getRating('student_rating') }} REVIEW)</strong>
					</div>
				</div>
			</div>
			<div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
			<div class="col-md-3">
				<div class="media mb-3">
					<div class="media-body pt-2 ml-3">
						<h3 class="mb-2" style="color: rgb(0, 255, 21)"> <strong>Free</strong>
                           @role('peserta_internal')
							@if ($data['peserta'] != null)
								@if (auth()->user() != null)
                                    @if ($data['peserta']->status_peserta == 1)
									<a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" class="btn btn-warning">START</a>
                                     @else 
                                     <a href="{{ route('profile.front',['id'=> $data['mata']->id]) }}" class="btn btn-warning">START</a>
                                    @endif
								@else 
								<a href="{{ route('register') }}" class="btn btn-warning">More Info</a>
								@endif
							@else 
								<a href="{{ route('register') }}" class="btn btn-warning">More Info</a>
							@endif
                            @elserole('administrator')
                                <a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" class="btn btn-warning">PREVIEW</a>
                            @else 
                            <a href="{{ route('register') }}" class="btn btn-warning">More Info</a>
                            @endrole
						 </h3>
					</div>
				</div>
			</div>
		   <br>

			<ul class="search-nav nav nav-tabs tabs-alt container-m-nx container-p-x mb-4">
				<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#search-pages"><h6><i class="ion ion-md-copy" style="color: orange"></i>&nbsp; <strong>Overview</strong> </h6></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#search-people"><h6><i class="ion ion-logo-dropbox" style="color: orange"></i>&nbsp; <strong>Kurikulum</strong> </h6></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#search-images"><h6><i class="ion ion-ios-person" style="color: orange"></i>&nbsp; <strong>Instruktur</strong> </h6></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#search-videos"><h6><i class="ion ion-ios-chatbubbles" style="color: orange"></i>&nbsp; <strong>Reviews</strong> </h6></a>
				</li>
			</ul>

		</div>
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

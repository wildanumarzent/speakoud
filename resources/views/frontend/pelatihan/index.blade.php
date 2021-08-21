@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
	<div class="container">
		<div class="banner-content">
			<div class="banner-text">
				<div class="title-heading text-center">
					<h1 style="color:white">ALL COURSE</h1>
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
        <div class="ui-bordered px-4 pt-4 mb-4">
              <div class="form-row">
                <div class="col-md mb-4">
                    
                </div>
                <div class="col-md mb-4">
                 
                </div>
                <div class=" col-md col-xl-2 mb-4">
                  <label class="form-label">Status</label>
                  <select class="custom-select">
                    <option>Newly published</option>
                    <option>Alphabetical</option>
                    <option>Most members</option>
                  </select>
                </div>
                <div class="col-md mb-4">
                  <label class="form-label d-none d-md-block">&nbsp;</label>
                   <input type="text" class="form-control" placeholder="Search...">
                  {{-- <button type="button" class="btn btn-secondary btn-block">Show</button> --}}
                </div>
              </div>
            </div>
            <!-- / Filters -->
		<div class="row">
			@foreach ($data['mata'] as $mata)
			{{-- d-flex --}}
			<div class="col-sm-6 col-lg-3 d-inlex">
				<div class="card mb-3 shadow" style="height: calc(100% - 1rem);">
						<a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}" class="d-block ui-rect-60 ui-bg-cover box-img" style="position: relative; display:block; width: 100%; height: 200px">
							<div class="thumb-img" style="position: absolute; top:0; bottom:0; left:0; right:0; z-index:1;">
								<img class="card-img-top" src="{{ $mata->getCover($mata->cover['filename']) }}" alt="Card image cap" style="display: block; width:100%; height:100%; object-fit: cover; object-position: center; ">
							</div>
						</a>
					<div class="card-body">
					<h6 class="mb-3"><a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">{!! $mata->judul !!}</a></h5>
					{{-- <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p> --}}
					<hr style="color: orange; background-color: orange">
					<div class="media">
						{{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
						<div class="mr-3">
						<h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> {{count($mata->peserta)}}</a></h5>
						</div>
						<div class="media-body">
						{{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
						</div>
						<div class="text-muted small">
							@if ($mata->price == null)
								<h6 style="color: rgb(20, 245, 0); font-family: 'arial'"> <strong >FREE</strong> </h6>   
							@else
								<h6 style="color: rgb(245, 147, 0)"> <strong>{{number_format($mata->price)}}</strong> </h6>
							@endif
						</div>
					</div>
					</div>
				</div>
			</div>
			@endforeach
			
		</div>
		<hr class="border-light mt-2 mb-4">

		<nav>
			<ul class="pagination justify-content-center">
			<li class="page-item disabled">
				<a class="page-link" href="javascript:void(0)">«</a>
			</li>
			<li class="page-item active">
				<a class="page-link" href="javascript:void(0)">1</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="javascript:void(0)">2</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="javascript:void(0)">3</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="javascript:void(0)">4</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="javascript:void(0)">5</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="javascript:void(0)">»</a>
			</li>
			</ul>
		</nav>

		</div>
	<!-- / Content -->
</div>
@endsection

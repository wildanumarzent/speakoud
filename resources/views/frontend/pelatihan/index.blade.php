@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
	<div class="container">
		<div class="banner-content">
			<div class="banner-text">
				<div class="title-heading text-center">
					<h1 >DAFTAR MATERI</h1>
				</div>
			</div>
			@include('components.breadcrumbs')
		</div>
	</div>
	<div class="thumbnail-img">
		<img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
	</div>
</div>
<div class="box-wrap bg-grey">
		  <!-- Content -->
	<div class="container flex-grow-1 container-p-y">
        <div class="row justify-content-end mb-5">
            <div class="col-lg-8">
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Status</label>
                        <select class="custom-select" id="selectorId" name="filter">
                        <option value="Newly published" {{ (Request::is('pelatihan/Newly%20published')) ? ' selected' : '' }}>Newly published</option>
                        <option value="Alphabetical" {{ (Request::is('pelatihan/Alphabetical')) ? ' selected' : '' }}>Alphabetical</option>
                        <option value="mostmember">Most members</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-2">
                        <form action="" method="get">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="form-label">search</label>
                                    <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" placeholder="Search...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100 filled ">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <!-- / Filters -->

		<div class="row">
            @if ($data['mata']->total() == 0)
            <tr>
                <td colspan="7" align="center">
                    <i><strong style="color:red;">
                    @if (Request::get('q'))
                    ! Pelatihan Tidak Di Temukan !
                    @else
                    ! Data Pelatihan kosong !
                    @endif
                    </strong></i>
                </td>
            </tr>
            @endif
			@foreach ($data['mata'] as $mata)
			{{-- d-flex --}}
			<div class="col-lg-4">
				<!-- <div class="card mb-3 shadow" style="height: calc(100% - 1rem);">
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
							@if ($mata->price == null || $mata->price == 0)
								<h6 style="color: rgb(20, 245, 0);"> <strong><a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">FREE</a> </strong> </h6>
							@else
								<h6 style="color: rgb(245, 147, 0)"> <strong>{{number_format($mata->price)}}</strong> </h6>
							@endif
						</div>
					</div>
					</div>
				</div> -->

                <div class="item-post">
                    <a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}" class="box-img">
                        <div class="thumbnail-img">
                            <img src="{{ $mata->getCover($mata->cover['filename']) }}" title="" alt="">
                        </div>
                    </a>
                    <div class="box-post">
                        <div class="post-date">
                            {{ $mata->created_at->format('d F Y') }}
                        </div>
                        <h5 class="post-title" >
                            <a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">{!! $mata->judul !!}</a>
                        </h5>
                        <div class="post-info">
                            <div class="box-price">
                                @if ($mata->price == null || $mata->price == 0)
                                    <div class="free">Free</div>
                                @else
                                    <div class="no-free">{{number_format($mata->price)}}</div>

                                @endif
                            </div>
                            <div class="box-info">
                                <div class="item-info">
                                    <div class="data-info">
                                        <i class="las la-user"></i>
                                        <span>{{count($mata->peserta)}}</span>
                                    </div>
                                    <span>Enroll</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


			</div>
			@endforeach

		</div>
		<hr class="border-light mt-2 mb-4">

		{{ $data['mata']->onEachSide(1)->links() }}

	</div>
	<!-- / Content -->
</div>
@endsection
@section('script')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
@endsection
@section('jsbody')
    <script>
    $("select").on("change", function(){
        var orderBy = $('#selectorId option:selected').val()
        window.location.href = "{{ url('pelatihan/')}}"+"/"+orderBy;
    })
    </script>
@endsection

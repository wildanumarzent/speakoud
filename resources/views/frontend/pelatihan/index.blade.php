
@extends('layouts.frontend.layout')


@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
    <style>
    .custom-select {
    display: inline-block;
    width: 100%;
    height: calc(2em + .75rem + 2px);
    padding: .375rem 1.75rem .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    vertical-align: middle;
    background: #fff url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e) no-repeat right .75rem center/8px 10px;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    }
    </style>
@endsection

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
            <div class="col-lg-10">
                <div class="form-row">
					<div class="col-md-3 mb-2">
						<form action="" method="get">
                        <label class="form-label">Status</label>
                        <select class="form-control custom-select" id="selectorId" name="f" style="font-size: 1rem; font-weight:400; height:calc(2em+.75rem+2px); padding:.375rem 1.75rem .375rem .75rem;">
							@foreach (config('addon.label.filter_course') as $key => $value)
							<option value="{{ $key }}" {{ Request::get('f') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
							@endforeach
						</select>
                    </div>
                    <div class="col-md-3 mb-2">
						<form action="" method="get">
                        <label class="form-label">Kategori</label>
                        <select class="form-control custom-select" id="selectorId" name="k" style="font-size: 1rem; font-weight:400; height:calc(2em+.75rem+2px); padding:.375rem 1.75rem .375rem .75rem;">
							@foreach ($data['kategori'] as $key => $value)
							<option value="{{ $value->id }}" {{ Request::get('k') == ''.$value->id.'' ? 'selected' : '' }}>{{ $value->judul }}</option>
							@endforeach
						</select>
                    </div>
                    <div class="col-md-6 mb-2">
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Keywords</label>
                                    <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" placeholder="Masukan Kata...">
                                </div>
                                <div class="col-md-4">
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
			{{-- {{dd($data['mata'])}} --}}
			@foreach ($data['mata'] as $mata)
			{{-- d-flex --}}
			<div class="col-lg-4">
                <div class="item-post">
                    <a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}" class="box-img">
                        <div class="thumbnail-img">
                            <img src="{{ $mata->getCover($mata->cover['filename']) }}" title="" alt="">
                        </div>
                    </a>
                    <div class="box-post">
                        <div class="post-date">
                            {{ $mata->created_at != null ? $mata->created_at->format('d F Y') : 'Tanggal Belum Di Sertakan' }}
                        </div>
                        <h5 class="post-title" >
                            <a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">{!! $mata->judul !!}</a>
                        </h5>
                        <div class="post-info">
                            <div class="box-price">
                                @if ($mata->type_pelatihan == 0)
                                    <div class="free"> <a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">Free</a> </div>
                                @else
                                    {{-- <div class="no-free"><a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">Rp. {{number_format($mata->price)}}</a></div> --}}
                                    <div class="no-free"><a href="{{ route('pelatihan.detail', ['id' => $mata->id]) }}">Private</a></div>
                                @endif
                            </div>
                            <div class="box-info">
                                <div class="item-info">
                                    <div class="data-info">
                                        <i class="las la-user"></i>
                                        @php
                                            $instruktur = count($mata->instruktur);
                                            $peserta = count($mata->peserta);

                                            $enrol = $instruktur + $peserta;
                                        @endphp
                                        <span>{{$enrol}}</span>
                                    </div>
                                    <span>Peserta</span>
                                </div>
                                <div class="item-info">
										<div class="data-info">
											<i class="las la-comment"></i>
                                            {{-- {{dd($mata->bahan)}} --}}
											<span>{{ $mata->bahan->count() }}</span>
										</div>
										<span>Materi</span>
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
    {{-- <script>
    $("select").on("change", function(){
        var orderBy = $('#selectorId option:selected').val()
        window.location.href = "{{ url('pelatihan/')}}"+"/"+orderBy;
    })
    </script> --}}
@endsection

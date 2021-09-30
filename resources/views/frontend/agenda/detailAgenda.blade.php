@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                     <h1 >DETAIL AGENDA</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap">
   	<!-- Content -->
	<div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="title-heading">
                    <h1>{{$data['data']->judul}}</h1>
                </div>
                <div class="box-event">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row" >
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Tanggal Mulai :</span>
                                    <div class="point-event">
                                        <i class="las la-calendar"></i>
                                        <div class="data-event">
                                            <strong>{{$data['data']->start_date->format('d F Y')}}</strong>
                                        </div>
                                    </div>
                                    <span></span>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Tanggal Selesai :</span>
                                    <div class="point-event">
                                        <i class="las la-calendar"></i>
                                        <div class="data-event">
                                        <strong>{{$data['data']->end_date->format('d F Y')}}}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Pukul :</span>
                                    <div class="point-event">
                                        <i class="las la-clock"></i>
                                        <div class="data-event">
                                        <strong>{{ \Carbon\Carbon::parse($data['data']->start_time)->format('H:i').' s/d '.\Carbon\Carbon::parse($data['data']->end_time)->format('H:i') }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Lokasi :</span>
                                    <div class="point-event">
                                        <i class="las la-clock"></i>
                                        <div class="data-event">
                                        <strong>{{$data['data']->lokasi}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <article class="mt-4 mb-3">
                   {!! $data['data']->keterangan !!}
                </article>
                <div class="box-participant">
                    <div class="title-heading">
                        <h3 class="mb-4">Pembicara</h3>
                    </div>
                    <div class="list-participant">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="item-participant">
                                    <div class="img-participant">
                                        <div class="thumbnail-img">
                                            <img src="{{ asset('/userfile/cover/'.$data['data']->cover['filename'])}}" alt="">
                                        </div>
                                    </div>
                                    <div class="info-participant">
                                        <h6 class="name">{{$data['data']->nama_pembicara}}</h6>
                                        <div class="departement">{!! $data['data']->keterangan_pembicara !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box-information">
                    <form action="">
                        <div class="title-heading text-center">
                            <h3 class="mb-4">Beli Tiket</h3>
                        </div>
                        <ul class="list-information">
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-question"></i> -->
                                    <span>Kuota Peserta</span>
                                </div>
                                <div class="data-information">
                                    <span>{{$data['data']->kuota_peserta}}</span>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-award"></i> -->
                                    <span>Sisa Kuota</span>
                                </div>
                                <div class="data-information">
                                    <span>4</span>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-check-circle"></i> -->
                                    <span>Biaya</span>
                                </div>
                                <div class="data-information">
                                    <div class="box-price">
                                        @if ($data['data']->harga == 0 || $data['data']->harga == null)
                                        <div class="no-free">Free</div>
                                        @else 
                                        <div class="no-free">Rp. {{number_format($data['data']->harga)}}</div>

                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-users"></i> -->
                                    <span>Peserta Terdaftar</span>
                                </div>
                                <div class="data-information">
                                    <span>50</span>
                                    {{-- <input type="number" id="quantity" value="1" name="quantity" min="1" max="5" style="width: 100px"> --}}
                                </div>
                            </li>
                        </ul>
                        <button class="btn btn-primary filled d-block w-100 mt-5" type="submit">Beli</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<!-- / Content -->
</div>
@endsection


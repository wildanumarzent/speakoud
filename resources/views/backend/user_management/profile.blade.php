@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>Hi! {!! $data['user']->name !!}</h1>

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
    <div class="container">
        <div class="account-wrap">
            <div class="title-heading mb-4">
                <h3>Profile</h3>
            </div>
            @include('components.alert')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Foto</label><br>
                        <a href="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" data-fancybox="gallery">
                            <img src="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" title="photo {{ $data['user']->name }}" alt="My photo profile" style="width: 80px;">
                        </a>
                    </div>
                </div>

                @role ('internal|mitra|instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIP</label>
                        <p><strong>{{ $data['user']->getDataByRole($data['user'])->nip }}</strong></p>
                    </div>
                </div>
                @endrole
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <p><strong>{!! $data['user']->name !!}</strong></p>
                    </div>
                </div>
                @role ('internal|mitra|instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        @role ('internal|mitra')
                        <p><strong>{{ $data['user']->getDataByRole($data['user'])->instansi['nama_instansi'] }}</strong></p>
                        @else
                        <p><strong>{{ $data['user']->getDataByRole($data['user'])->instansi($data['user']->getDataByRole($data['user']))->nama_instansi }}</strong></p>
                        @endrole
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kedeputian</label>
                        <p><strong>{{ $data['user']->getDataByRole($data['user'])->kedeputian }}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jabatan</label>
                        @role ('instruktur_internal|instruktur_mitra')
                        <p><strong>{{ $data['user']->getDataByRole($data['user'])->pangkat }}</strong></p>
                        @else
                        <p><strong>{{ config('addon.label.jabatan.'.$data['user']->getDataByRole($data['user'])->pangkat) ?? '-' }}</strong></p>
                        @endrole
                    </div>
                </div>
                @endrole
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Telpon</label>
                        <p><strong>{!! $data['information']->phone ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <p><strong>{{ $data['information']->address ?? '-' }}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kab / Kota</label>
                        <p><strong>{!! $data['information']->city ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mt-4">
                        <h6 class="title">1. Akun</h6>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <p><strong>{!! $data['user']->username !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <p><strong>{!! $data['user']->email !!}</strong> </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mt-4">
                        @if ($data['user']->email_verified == 0)
                        <div class="alert alert-warning" role="alert">
                            Email anda belum <em>diverifikasi</em>, anda tidak akan mendapatkan <em>notifikasi</em>. <br>
                            <a href="{{ route('profile.email.verification.send') }}"><i class="las la-envelope"></i> <strong>Verifikasi Sekarang</strong></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mt-4">
                        <h6 class="title">2. Logs Activity</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Access</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->first_access) ? $data['user']->first_access->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Access</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->last_access) ? $data['user']->last_access->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Login</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->last_login) ? $data['user']->last_login->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>IP Address</label>
                        <p><strong>{!! $data['user']->ip_address ?? '-' !!}</strong></p>
                    </div>
                </div>
                @role('peserta_internal|peserta_mitra')
                <div class="col-md-12">
                    <div class="form-group mt-4">
                        <h6 class="title">3. Complete Learning Journey</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <ul class="list-group">
                           @foreach($data['myJourney'] as $j)
                           <li class="list-group-item">{{$j->journey->judul}}</li>
                           @endforeach
                        </ul>
                    </div>
                </div>
                @endrole
                <div class="col-md-12">
                    <div class="box-btn text-right">
                       <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

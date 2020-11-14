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
                <h3>Account Detail</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="username">Foto</label><br>
                        <a href="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" data-fancybox="gallery">
                            <img src="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" title="photo {{ $data['user']->name }}" alt="My photo profile" style="width: 80px;">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Nama</label>
                        <p><strong>{!! $data['user']->name !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <p><strong>{!! $data['user']->username !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <p>
                            <strong>{!! $data['user']->email !!}</strong>
                        </p>
                        @if ($data['user']->email_verified == 0)
                        <div class="alert alert-warning" role="alert">
                            Email anda belum <em>diverifikasi</em>, anda tidak akan mendapatkan <em>notifikasi</em>. <br>
                            <a href=""><strong>Verifikasi Sekarang</strong></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Nomor Telpon</label>
                        <p><strong>{!! $data['information']->optional['phone'] ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Nomor HP</label>
                        <p><strong>{!! $data['information']->optional['mobile_phone'] ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Alamat</label>
                        <p><strong>{!! $data['information']->optional['address'] ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Kab / Kota</label>
                        <p><strong>{!! $data['information']->general['city'] ?? '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mt-4">
                        <h6 class="title">Logs Activity</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">First Access</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->first_access) ? $data['user']->first_access->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Last Access</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->last_access) ? $data['user']->last_access->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Last Login</label><br>
                        <p class="post-date"><strong>{!! !empty($data['user']->last_login) ? $data['user']->last_login->format('d F Y H:i A') : '-' !!}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">IP Address</label>
                        <p><strong>{!! $data['user']->ip_address ?? '-' !!}</strong></p>
                    </div>
                </div>
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

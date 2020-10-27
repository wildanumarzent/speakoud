@extends('layouts.frontend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/authentication.css') }}">
@endsection

@section('layout-content')
<div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('{{ asset(config('addon.images.banner_default')) }}');">
    <div class="ui-bg-overlay bg-dark opacity-25"></div>

    <div class="authentication-inner py-5">

      <div class="card">
        <div class="p-4 p-sm-5">
          <!-- Logo -->
          <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
            <div class="ui-w-60">
                <div class="w-100 d-flex justify-content-center">
                    <img src="{{ asset(config('addon.images.logo')) }}" alt="" style="width:80px;">
                </div>
            </div>
          </div>
          <!-- / Logo -->

          @yield('content')

        </div>
        <div class="card-footer py-3 px-4 px-sm-5">
          <div class="text-center text-muted">
            Copyright © {{ now()->format('Y') }} Pusat Pembinaan, Pendidikan dan Pelatihan BPPT
          </div>
        </div>
      </div>

    </div>
</div>
@endsection

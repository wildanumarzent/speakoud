@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/css/error.css') }}">
@endsection

@section('layout-content')
<div class="overflow-hidden" style="background-color: #687182 !important;">
    <div class="container d-flex align-items-stretch ui-mh-100vh p-0">
      <div class="row w-100">
        <div class="d-flex col-md justify-content-center align-items-center order-2 order-md-1 position-relative p-5">
          <div class="error-bg-skew theme-bg-white"></div>

          <div class="text-md-left text-center text-white">
            <h1 class="display-2 font-weight-bolder mb-4">Whoops...</h1>
            <div class="text-xlarge font-weight-light mb-5"> Sepertinya ada yang salah. Kami sedang mengerjakannya.</div>
            <div class="text-big">
                Coba lagi atau <a href="mailto:{{ $configuration['email'] }}" class="text-white">hubungi kami</a>
            </div>
          </div>
        </div>

        <div class="d-flex col-md-5 justify-content-center align-items-center order-1 order-md-2 text-center text-white p-5">
          <div>
            <div class="error-code font-weight-bolder mb-2">500</div>
            <div class="error-description font-weight-light">Server Error</div>
          </div>
        </div>

      </div>
    </div>
</div>
@endsection

@section('jsbody')
<script>
    function goBack() {
      window.history.back();
    }
</script>
@endsection

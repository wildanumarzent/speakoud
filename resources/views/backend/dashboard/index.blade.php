@extends('layouts.backend.layout')

@section('styles')
@endsection

@section('content')
<h4 class="font-weight-bold py-3 mb-3">
    Dashboard
    <div class="text-muted text-tiny mt-1 time-frame">
        <small class="font-weight-normal">Today is {{ now()->format('l, j F Y') }} (<em id="time-part"></em>)</small>
    </div>
</h4>

<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        Selamat datang, <strong><em>{{ auth()->user()->name }}</em></strong> di aplikasi Learning Management System !
      </div>
    </div>
</div>

@livewire('announcement')

@role ('developer|administrator')
@include('backend.dashboard.administrator')
@endrole

@role ('internal|mitra')
@include('backend.dashboard.internal-mitra')
@endrole

@role ('instruktur_internal|instruktur_mitra')
@include('backend.dashboard.instruktur')
@endrole

@role ('peserta_internal|peserta_mitra')
@include('backend.dashboard.peserta')
@endrole

@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $(document).ready(function() {
        var interval = setInterval(function() {
            var momentNow = moment();
            $('#time-part').html(momentNow.format('hh:mm:ss A'));
        }, 100);
    });
</script>
@include('components.toastr')
@endsection

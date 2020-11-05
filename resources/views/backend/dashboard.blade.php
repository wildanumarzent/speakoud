@extends('layouts.backend.layout')

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

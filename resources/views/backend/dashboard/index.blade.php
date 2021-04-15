@extends('layouts.backend.layout')

@section('styles')
    <style>
        .icon-example {
            width: 70px;
            height: 70px;
            font-size: 20px;
            position: relative;
        }
        .icon-example:after {
            content: attr(data-title);
            display: none;
            position: absolute;
            background: #444;
            color: #fff;
            padding: 3px 6px;
            border-radius: 2px;
            bottom: 100%;
            left: 50%;
            font-weight: bold;
            transform: translate(-50%, -4px);
            font-size: 12px;
            white-space: nowrap;
        }
        .icon-example:hover:after {
            display: block;
        }
    </style>
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
        Selamat datang, <strong><em>{!! auth()->user()->name !!}</em></strong> di aplikasi Learning Management System !
      </div>
    </div>
</div>

@role('peserta_internal|peserta_mitra')
@if (auth()->user()->peserta->status_profile == 0 || empty(auth()->user()->photo['filename']))
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <i class="las la-exclamation-triangle"></i> Data Profile anda belum lengkap, <a href="{{ route('profile.edit') }}"><strong>Lengkapi sekarang</strong></a>.
      </div>
    </div>
</div>
@endif
@endrole

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

    $('.jump-tugas').on('change', function () {

        var id = $(this).val();

        if (id) {
            window.location = '/tugas/'+id+'/peserta'
        }

        return false;
    });
</script>
@include('components.toastr')
@endsection

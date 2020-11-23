@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['quiz']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['quiz']->bahan->judul !!}</strong>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

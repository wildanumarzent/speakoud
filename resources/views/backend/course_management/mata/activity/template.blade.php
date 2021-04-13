@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@yield('style')
@endsection

@section('content')
<!-- Filters -->
<div class="card">
    <div class="card-body">
        <div class="form-row align-items-center">
            <div class="col-md">
                <form action="" method="GET">
                    <div class="form-group">
                        <label class="form-label">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->
<div class="text-left">
    @php
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $route = route('course.detail', ['id' => $data['mata']->id]);
        } else {
            $route = route('mata.index', ['id' => $data['mata']->program_id]);
        }
    @endphp
    <a href="{{ $route }}" class="btn btn-secondary rounded-pill" title="kembali ke list program"><i class="las la-arrow-left"></i>Kembali</a>
    @if (!auth()->user()->hasRole('instruktur_internal|instruktur_mitra'))
    <a class="btn btn-success" href={{route('mata.export.activity',['id'=> $data['mata']->id ])}}><i class="las la-download"></i>Export Activity Report</a>
    @endif
</div>
<br>

<div class="card">

    <div class="list-group list-group-flush account-settings-links flex-row">
        @role ('instruktur_internal|instruktur_mitra')
        <a class="list-group-item list-group-item-action {{ Request::segment(3) == 'completion' ? 'active' : '' }}" href="{{ route('mata.completion', ['id' => $data['mata']->id]) }}">Activity Completion</a>
        @else
        <a class="list-group-item list-group-item-action {{ Request::segment(3) == 'pembobotan' ? 'active' : '' }}" href="{{ route('mata.pembobotan', ['id' => $data['mata']->id]) }}">Pembobotan Nilai</a>
        <a class="list-group-item list-group-item-action {{ Request::segment(3) == 'completion' ? 'active' : '' }}" href="{{ route('mata.completion', ['id' => $data['mata']->id]) }}">Activity Completion</a>
        <a class="list-group-item list-group-item-action {{ Request::segment(3) == 'compare' ? 'active' : '' }}" href="{{ route('mata.compare', ['id' => $data['mata']->id]) }}">Compare Test</a>
        @endrole
    </div>
    <div class="card-body">
        @yield('content-view')
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@yield('script')
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>

@yield('body')
@include('components.toastr')
@endsection

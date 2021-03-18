@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    @foreach ($data['mata'] as $item)
    <div class="col-sm-6 col-xl-3">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url({{ $item->getCover($item->cover['filename']) }});">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> {{ $item->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        {{ $item->judul }}
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary" href="{{ route('course.detail', ['id' => $item->id]) }}" title="klik untuk melihat detail pelatihan">
                            DETAIL
                        </a>
                    </div>
                    <div class="text-muted small">
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if ($data['mata']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Kategori Pelatihan tidak ditemukan !
            @else
            ! Kategori Pelatihan kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['mata']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['mata']->firstItem() }}</strong> - <strong>{{ $data['mata']->lastItem() }}</strong> dari
                <strong>{{ $data['mata']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['mata']->onEachSide(3)->links() }}
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')

@include('components.toastr')
@endsection

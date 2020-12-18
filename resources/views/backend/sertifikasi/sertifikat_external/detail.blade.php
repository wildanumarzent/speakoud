@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="text-left">
    <a href="{{ route('sertifikat.external.peserta', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke program"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Sertifikat External</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-body">
        <div class="file-manager-container file-manager-col-view" id="files">
            @foreach ($data['sertifikat'] as $item)
            <div class="file-item only">
                <a href="{{ route('bank.data.stream', ['path' => $item->sertifikat]) }}" class="file-item-name" data-fancybox="gallery">
                    <div class="file-item-icon las la-certificate text-secondary"></div>
                    <div class="desc-of-name">
                        {{ collect(explode("/", $item->sertifikat))->last() }}
                    </div>
                </a>
                <div class="file-item-actions btn-group dropdown">
                    <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item js-sa2-delete-file" href="javascript:void(0)" title="klik untuk menghapus file">
                        <i class="las la-trash-alt"></i> Hapus
                      </a>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($data['sertifikat']->count() == 0)
            <div class="file-item">
                <div class="file-item-icon las la-ban text-danger"></div>
                <div class="file-item-name">
                  Sertifikat kosong
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection


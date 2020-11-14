@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')

<div class="card">
    <h6 class="card-header">
      Form Banner
    </h6>
    <form action="{{ !isset($data['banner']) ? route('banner.media.store', ['id' => $data['kategori']->id]) : route('banner.media.update', ['id' => $data['kategori']->id, 'bannerId' => $data['banner']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['banner']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">File</label>
                </div>
                @if (isset($data['banner']))
                    <input type="hidden" name="old_file" value="{{ $data['banner']->file }}">
                    <div class="col-md-1">
                        <a href="{{ asset(config('addon.images.path.banner').$data['banner']->banner_kategori_id.'/'.$data['banner']->file) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ asset(config('addon.images.path.banner').$data['banner']->banner_kategori_id.'/'.$data['banner']->file) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['banner']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="file" placeholder="masukan file...">
                    @include('components.field-error', ['field' => 'file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.banner_default.m')) }}</strong></small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['banner'])) ? old('judul', $data['banner']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan keterangan...">{!! (isset($data['banner'])) ? old('keterangan', $data['banner']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Status</label>
                </div>
                <div class="col-md-10">
                    <select class="status custom-select form-control" name="publish">
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ isset($data['banner']) ? (old('publish', $data['banner']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Link</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                    value="{{ (isset($data['banner'])) ? old('link', $data['banner']->link) : old('link') }}" placeholder="masukan link..." >
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('banner.media', ['id' => $data['kategori']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['banner']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

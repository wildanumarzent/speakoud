@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Instansi
    </h6>
    <form action="{{ !isset($data['instansi']) ? route('instansi.internal.store') : route('instansi.internal.update', ['id' => $data['instansi']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['instansi']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Kode Instansi</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('kode_instansi') is-invalid @enderror" name="kode_instansi"
                    value="{{ (isset($data['instansi'])) ? old('kode_instansi', $data['instansi']->kode_instansi) : old('kode_instansi') }}" placeholder="masukan kode instansi..." autofocus>
                  @include('components.field-error', ['field' => 'kode_instansi'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama Instansi</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" name="nama_instansi"
                    value="{{ (isset($data['instansi'])) ? old('nama_instansi', $data['instansi']->nama_instansi) : old('nama_instansi') }}" placeholder="masukan nama instansi...">
                  @include('components.field-error', ['field' => 'nama_instansi'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Telpon</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('telpon') is-invalid @enderror" name="telpon"
                    value="{{ (isset($data['instansi'])) ? old('telpon', $data['instansi']->telpon) : old('telpon') }}" placeholder="masukan telpon...">
                  @include('components.field-error', ['field' => 'telpon'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">FAX</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('fax') is-invalid @enderror" name="fax"
                    value="{{ (isset($data['instansi'])) ? old('fax', $data['instansi']->fax) : old('fax') }}" placeholder="masukan fax...">
                  @include('components.field-error', ['field' => 'fax'])
                </div>
            </div>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Logo</label>
                </div>
                @if (isset($data['instansi']))
                    <input type="hidden" name="old_logo" value="{{ $data['instansi']->logo }}">
                    <div class="col-md-1">
                        <a href="{{ $data['instansi']->getLogo($data['instansi']->logo) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['instansi']->getLogo($data['instansi']->logo) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['instansi']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('logo') is-invalid @enderror" type="file" id="upload-2" lang="en" name="logo" placeholder="masukan logo...">
                    @include('components.field-error', ['field' => 'logo'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.logo_instansi.m')) }}</strong></small>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">NIP Pimpinan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nip_pimpinan') is-invalid @enderror" name="nip_pimpinan"
                    value="{{ (isset($data['instansi'])) ? old('nip_pimpinan', $data['instansi']->nip_pimpinan) : old('nip_pimpinan') }}" placeholder="masukan nip pimpinan...">
                  @include('components.field-error', ['field' => 'nip_pimpinan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama Pimpinan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama_pimpinan') is-invalid @enderror" name="nama_pimpinan"
                    value="{{ (isset($data['instansi'])) ? old('nama_pimpinan', $data['instansi']->nama_pimpinan) : old('nama_pimpinan') }}" placeholder="masukan nama pimpinan...">
                  @include('components.field-error', ['field' => 'nama_pimpinan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jabatan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                    value="{{ (isset($data['instansi'])) ? old('jabatan', $data['instansi']->jabatan) : old('jabatan') }}" placeholder="masukan jabatan...">
                  @include('components.field-error', ['field' => 'jabatan'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('instansi.internal.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['instansi']) ? 'Simpan perubahan' : 'Simpan' }}</button>
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
@include('components.toastr')
@endsection

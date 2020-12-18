@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Sertifikat Internal
    </h6>
    <form action="{{ !isset($data['sertifikat']) ? route('sertifikat.internal.store', ['id' => $data['mata']->id]) : route('sertifikat.internal.update', ['id' => $data['mata']->id, 'sertifikatId' => $data['sertifikat']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['sertifikat']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nomor</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor"
                    value="{{ isset($data['sertifikat']) ? old('nomor', $data['sertifikat']->nomor) : old('nomor') }}" placeholder="masukan nomor..." autofocus>
                  @include('components.field-error', ['field' => 'nomor'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Tanggal Pengesahan</label>
                </div>
               <div class="col-md-10">
                 <input type="text" class="date-picker form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ isset($data['sertifikat']) ? old('tanggal', $data['sertifikat']->tanggal->format('Y-m-d')) : old('tanggal') }}" placeholder="masukan tanggal pengesahan...">
                 @include('components.field-error', ['field' => 'tanggal'])
               </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama Pimpinan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama_pimpinan') is-invalid @enderror" name="nama_pimpinan"
                    value="{{ isset($data['sertifikat']) ? old('nama_pimpinan', $data['sertifikat']->nama_pimpinan) : old('nama_pimpinan') }}" placeholder="masukan nama pimpinan...">
                  @include('components.field-error', ['field' => 'nama_pimpinan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jabatan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                    value="{{ isset($data['sertifikat']) ? old('jabatan', $data['sertifikat']->jabatan) : old('jabatan') }}" placeholder="masukan jabatan...">
                  @include('components.field-error', ['field' => 'jabatan'])
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">TTE (Tanda Tangan Elektronik)</label>
                </div>
                <div class="col-md-10">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-0"></label>
                        <input type="file" class="form-control custom-file-input file @error('tte') is-invalid @enderror" id="file-0" lang="en" name="tte" value="browse...">
                        @error('tte')
                            @include('components.field-error', ['field' => 'tte'])
                        @else
                        <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong></small>
                        @enderror
                    </label>
                </div>
            </div> --}}
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('mata.index', ['id' => $data['mata']->program_id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['sertifikat']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $( ".date-picker" ).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
</script>
@include('components.toastr')
@endsection

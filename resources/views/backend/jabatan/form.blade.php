@extends('layouts.backend.layout')

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Jabatan
    </h6>
    <form action="{{ !isset($data['jabatan']) ? route('jabatan.store') : route('jabatan.update', ['id' => $data['jabatan']->id]) }}" method="POST">
        @csrf
        @if (isset($data['jabatan']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    value="{{ (isset($data['jabatan'])) ? old('nama', $data['jabatan']->nama) : old('nama') }}" placeholder="masukan nama..." autofocus>
                  @include('components.field-error', ['field' => 'nama'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan keterangan...">{!! (isset($data['jabatan'])) ? old('keterangan', $data['jabatan']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
          <a href="{{ route('jabatan.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
          &nbsp;&nbsp;
          <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">{{ isset($data['jabatan']) ? 'Simpan perubahan' : 'Simpan' }}</button>
          &nbsp;&nbsp;
          <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

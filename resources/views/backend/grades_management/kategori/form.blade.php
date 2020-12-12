@extends('layouts.backend.layout')

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Grades
    </h6>
    <form action="{{ !isset($data['kategori']) ? route('grades.store') : route('grades.update', ['id' => $data['kategori']->id]) }}" method="POST">
        @csrf
        @if (isset($data['kategori']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    value="{{ (isset($data['kategori'])) ? old('nama', $data['kategori']->nama) : old('nama') }}" placeholder="masukan nama..." autofocus>
                  @include('components.field-error', ['field' => 'nama'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan keterangan...">{!! (isset($data['kategori'])) ? old('keterangan', $data['kategori']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('grades.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['kategori']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
          </div>
    </form>
</div>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

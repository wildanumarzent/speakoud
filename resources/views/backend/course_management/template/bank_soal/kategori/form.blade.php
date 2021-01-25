@extends('layouts.backend.layout')

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Template Kategori Soal
    </h6>
    <form action="{{ !isset($data['kategori']) ? route('template.soal.kategori.store', ['id' => $data['mata']->id]) : route('template.soal.kategori.update', ['id' => $data['kategori']->template_mata_id, 'kategoriId' => $data['kategori']->id]) }}" method="POST">
        @csrf
        @if (isset($data['kategori']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['kategori'])) ? old('judul', $data['kategori']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
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
                <a href="{{ route('template.soal.kategori', ['id' => $data['mata']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
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
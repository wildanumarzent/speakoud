@extends('layouts.backend.layout')

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Grades Nilai
    </h6>
    <form action="{{ !isset($data['nilai']) ? route('grades.nilai.store', ['id' => $data['kategori']->id]) : route('grades.nilai.update', ['id' => $data['nilai']->kategori_id, 'nilaiId' => $data['nilai']->id]) }}" method="POST">
        @csrf
        @if (isset($data['nilai']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nilai Maksimum</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="number" class="form-control @error('maksimum') is-invalid @enderror" name="maksimum"
                            value="{{ (isset($data['nilai'])) ? old('maksimum', $data['nilai']->maksimum) : old('maksimum') }}" placeholder="masukan nilai maksimum...">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                        @include('components.field-error', ['field' => 'maksimum'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nilai Minimum</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="number" class="form-control @error('minimum') is-invalid @enderror" name="minimum"
                          value="{{ (isset($data['nilai'])) ? old('minimum', $data['nilai']->minimum) : old('minimum') }}" placeholder="masukan nilai minimum..." autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                        @include('components.field-error', ['field' => 'minimum'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                    value="{{ (isset($data['nilai'])) ? old('keterangan', $data['nilai']->keterangan) : old('keterangan') }}" placeholder="masukan keterangan...">
                  @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('grades.nilai', ['id' => $data['kategori']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['nilai']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
          </div>
    </form>
</div>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

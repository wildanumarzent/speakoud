@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Grades Letter
    </h6>
    <form action="{{ !isset($data['letter']) ? route('grades.letter.store') : route('grades.letter.update', ['id' => $data['letter']->id]) }}" method="POST">
        @csrf
        @if (isset($data['letter']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nilai Maksimum</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control @error('nilai_maksimum') is-invalid @enderror" name="nilai_maksimum"
                            value="{{ (isset($data['letter'])) ? old('nilai_maksimum', $data['letter']->nilai_maksimum) : old('nilai_maksimum') }}" placeholder="masukan nilai maksimum...">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                        @include('components.field-error', ['field' => 'nilai_maksimum'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nilai Minimum</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control @error('nilai_minimum') is-invalid @enderror" name="nilai_minimum"
                          value="{{ (isset($data['letter'])) ? old('nilai_minimum', $data['letter']->nilai_minimum) : old('nilai_minimum') }}" placeholder="masukan nilai minimum..." autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                        @include('components.field-error', ['field' => 'nilai_minimum'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Angka</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('angka') is-invalid @enderror" name="angka"
                    value="{{ (isset($data['letter'])) ? old('angka', $data['letter']->angka) : old('angka') }}" placeholder="masukan angka...">
                  @include('components.field-error', ['field' => 'angka'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('grades.letter') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['letter']) ? 'Simpan perubahan' : 'Simpan' }}</button>
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

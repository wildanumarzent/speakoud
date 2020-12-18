@extends('backend.course_management.bahan.form')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Kategori</label>
    </div>
    <div class="col-md-10">
        <select class="selectpicker @error('kategori') is-invalid @enderror" name="kategori" data-style="btn-default">
            <option value=" " selected disabled>Pilih</option>
            @foreach (config('addon.label.quiz_kategori') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('kategori', $data['bahan']->quiz->kategori) == ''.$key.'' ? 'selected' : '') : (old('kategori') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
            @endforeach
        </select>
        @error('kategori')
        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Durasi</label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control @error('durasi') is-invalid @enderror" name="durasi"
                value="{{ (isset($data['bahan'])) ? old('durasi', $data['bahan']->quiz->durasi) : old('durasi') }}" placeholder="masukan durasi...">
            <div class="input-group-append">
                <span class="input-group-text">MENIT</span>
            </div>
            @include('components.field-error', ['field' => 'durasi'])
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Tipe</label>
    </div>
    <div class="col-md-10">
        <select class="status custom-select form-control" name="tipe">
            @foreach (config('addon.label.quiz_tipe') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->quiz->tipe) == ''.$key.'' ? 'selected' : '') : (old('tipe') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Tampilan</label>
    </div>
    <div class="col-md-10">
        <select class="status custom-select form-control" name="view">
            @foreach (config('addon.label.quiz_view') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('view', $data['bahan']->quiz->view) == ''.$key.'' ? 'selected' : '') : (old('view') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

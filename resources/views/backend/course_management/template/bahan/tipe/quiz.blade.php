@extends('backend.course_management.template.bahan.form')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content-bahan')
@if (!isset($data['bahan']) && empty(Request::get('kategori')) || isset($data['bahan']) && $data['bahan']->quiz->kategori >= 3)
<fieldset class="form-group">
    <div class="row">
    <div class="col-md-2 text-md-right  pt-sm-0">
        <label class="col-form-label">Mandatory</label>
    </div>
    <div class="col-md-10">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_mandatory" value="1" {{ isset($data['bahan']) ? (old('is_mandatory', $data['bahan']->quiz->is_mandatory == '1') ? 'checked' : 'checked') : (old('tipe') ? 'checked' : 'checked') }}>
            <span class="form-check-label">
                Ya
            </span>
        </label>
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_mandatory" value="0" {{ isset($data['bahan']) ? (old('is_mandatory', $data['bahan']->quiz->is_mandatory == '0') ? 'checked' : '') : (old('tipe') ? '' : '') }}>
            <span class="form-check-label">
                Tidak
            </span>
        </label>
    </div>
    </div>
</fieldset>
@else
<input type="hidden" name="is_mandatory" value="1">
@endif
@if (!isset($data['bahan']) && empty(Request::get('kategori')) || isset($data['bahan']) && $data['bahan']->quiz->kategori >= 3)
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Kategori</label>
    </div>
    <div class="col-md-10">
        <select class="selectpicker @error('kategori') is-invalid @enderror" name="kategori" data-style="btn-default">
            <option value=" " selected disabled>Pilih</option>
            @foreach (config('addon.label.quiz_kategori') as $key => $value)
                @if (!isset($data['bahan']) && empty(Request::get('kategori')) || isset($data['bahan']) && $data['bahan']->quiz->kategori >= 3)
                    @if ($key >= 3)
                    <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('kategori', $data['bahan']->quiz->kategori) == ''.$key.'' ? 'selected' : '') : ((old('kategori') == ''.$key.'' || Request::get('kategori') == $key) ? 'selected' : '') }}>{{ $value }}</option>
                    @endif
                @else
                <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('kategori', $data['bahan']->quiz->kategori) == ''.$key.'' ? 'selected' : '') : ((old('kategori') == ''.$key.'' || Request::get('kategori') == $key) ? 'selected' : '') }}>{{ $value }}</option>
                @endif
            @endforeach
        </select>
        @error('kategori')
        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
        @enderror
    </div>
</div>
@else
<input type="hidden" name="kategori" value="{{ isset($data['bahan']) ? $data['bahan']->quiz->kategori : Request::get('kategori') }}">
@endif
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
@if (!isset($data['bahan']) && empty(Request::get('kategori')) || isset($data['bahan']) && $data['bahan']->quiz->kategori >= 3)
<div class="form-group row" id="tipe">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Tipe</label>
    </div>
    <div class="col-md-10">
        <select class="status custom-select form-control" name="tipe" id="ulang">
            @foreach (config('addon.label.quiz_tipe') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->quiz->tipe) == ''.$key.'' ? 'selected' : '') : (old('tipe') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
@else
<input type="hidden" name="tipe" value="1">
@endif
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
<fieldset class="form-group" id="hasil">
    <div class="row">
    <div class="col-md-2 text-md-right  pt-sm-0">
        <label class="col-form-label">Tampilkan Hasil Quiz</label>
    </div>
    <div class="col-md-10">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="hasil" value="1" {{ isset($data['bahan']) ? (old('hasil', $data['bahan']->quiz->hasil == '1') ? 'checked' : '') : (old('tipe') ? 'checked' : 'checked') }}>
            <span class="form-check-label">
                Ya
            </span>
        </label>
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="hasil" value="0" {{ isset($data['bahan']) ? (old('hasil', $data['bahan']->quiz->hasil == '0') ? 'checked' : 'checked') : (old('tipe') ? 'checked' : 'checked') }}>
            <span class="form-check-label">
                Tidak
            </span>
        </label>
    </div>
    </div>
</fieldset>
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('body')
@if (!isset($data['bahan']))
<script>
    $(document).ready(function() {
        $('#tipe').hide();
        $('input[type=radio][name=is_mandatory]').change(function() {
            if (this.value == 0) {
                $('#tipe').toggle('slow');
            } else {
                $('#tipe').hide();
            }
        });

        $('#hasil').hide();
        $('#ulang').change(function() {
            if (this.value == 0) {
                $('#hasil').toggle('slow');
            } else {
                $('#hasil').hide();
            }
        });
    });
</script>
@else
<script>
    $(document).ready(function() {
        var tipe = "{{ $data['bahan']->quiz->tipe }}";
        if (tipe == 0) {
            $('#tipe').show();
            $('#hasil').show();
        } else {
            $('#tipe').hide();
            $('#hasil').hide();
        }
        $('input[type=radio][name=is_mandatory]').change(function() {
            if (this.value == 0) {
                $('#tipe').toggle('slow');
            } else {
                $('#tipe').hide();
            }
        });
        $('#ulang').change(function() {
            if (this.value == 0) {
                $('#hasil').toggle('slow');
            } else {
                $('#hasil').hide();
            }
        });
    });
</script>
@endif
@endsection

@extends('backend.course_management.template.bahan.form')

@section('content-bahan')
<fieldset class="form-group">
    <div class="row">
    <div class="col-md-2 text-md-right  pt-sm-0">
        <label class="col-form-label">Tipe Video Conference</label>
    </div>
    <div class="col-md-10">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="tipe" value="0" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->conference->tipe == '0') ? 'checked' : 'checked') : (old('tipe') ? 'checked' : 'checked') }}>
            <span class="form-check-label">
                BPPT Conference
            </span>
        </label>
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="tipe" value="1" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->conference->tipe == '1') ? 'checked' : '') : (old('tipe') ? '' : '') }}>
            <span class="form-check-label">
                Platform (zoom, gmeet, dll)
            </span>
        </label>
    </div>
    </div>
</fieldset>
@endsection

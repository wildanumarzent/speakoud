@extends('backend.course_management.bahan.form')

@section('content-bahan')
<fieldset class="form-group">
    <div class="row">
    <div class="col-md-2 text-md-right  pt-sm-0">
        <label class="col-form-label">Tipe Video Conference</label>
    </div>
    <div class="col-md-10">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="tipe" value="0" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->conference->tipe == '0') ? 'checked' : '') : (old('tipe') ? 'checked' : 'checked') }}>
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
<div class="form-group row" id="meeting-link">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Meeting Link</label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
        <input type="text" class="form-control @error('meeting_link') is-invalid @enderror" name="meeting_link"
            value="{{ (isset($data['bahan'])) ? old('meeting_link', $data['bahan']->conference->meeting_link) : old('meeting_link') }}" placeholder="masukan link meeting...">
        @include('components.field-error', ['field' => 'meeting_link'])
        </div>
    </div>
</div>

@if (!isset($data['bahan']))
    <script>
        $("#meeting-link").hide();
    </script>
@endif
    <script>
    $('input[name=tipe]').change(function() {
        if ($(this).val() == 1) {
            $('#meeting-link').toggle('slow');
        } else {
            $('#meeting-link').toggle();
        }
    });
    </script>
@endsection

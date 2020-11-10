@extends('backend.course_management.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Scorm Package</label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
        <input type="file" name="package">
        @include('components.field-error', ['field' => 'package'])
        </div>
        <small class="text-danger">Scorm 1.2 / 2004 (.zip)</small>
    </div>
</div>
@endsection

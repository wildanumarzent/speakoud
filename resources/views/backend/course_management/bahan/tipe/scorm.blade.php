@extends('backend.course_management.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Scorm Package</label>
    </div>
    <div class="col-sm-10">
        <label class="custom-file mt-2">
            <label class="custom-file-label mt-1" for="file-1"></label>
            @if (isset($data['bahan']))
                <input type="hidden" name="old_package" value="{{ $data['bahan']->scorm->package }}">
            @endif
            <input type="file" class="form-control custom-file-input file @error('package') is-invalid @enderror" type="file" id="file-1" lang="en" name="package" value="browse...">
            @error('package')
            @include('components.field-error', ['field' => 'package'])
            @else
            <small class="text-danger">Scorm 1.2 / 2004 (.zip)</small>
            @enderror
    </div>
</div>
@endsection

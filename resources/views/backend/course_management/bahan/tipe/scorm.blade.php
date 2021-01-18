@extends('backend.course_management.bahan.form')

@section('content-bahan')
@if(!isset($data['bahan']))
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Scorm Package</label>
    </div>
    <div class="col-sm-10">
        <label class="custom-file mt-2">
            <label class="custom-file-label mt-1" for="file-1"></label>
            @if (isset($data['bahan']))
                <input type="hidden" name="old_package" value="{{ $data['bahan']->scorm->scorm->package_name }}">
            @endif
            <input type="file" class="form-control custom-file-input file @error('package') is-invalid @enderror" type="file" id="file-1" lang="en" name="package" value="browse...">
            @error('package')
            @include('components.field-error', ['field' => 'package'])
            @else
            <small class="text-danger">Scorm 1.2 / 2004 (.zip)</small>
            @enderror
    </div>
</div>
@endif
@if(isset($data['bahan']))
@if($data['scorm']->count() > 0)
{{-- <input type="hidden" name="package" value="{{asset('userfile/scorm/default.zip')}}">
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Pakai Package Sebelumnya</label>
    </div>
    <div class="col-sm-10">
       <select name="scorm_id" class="form-control">
           <option value="" disabled selected>Pilih Scorm Package</option>
           @foreach($data['scorm'] as $scorm)
           <option value="{{$scorm->id}}">{{$scorm->package_name}}</option>
           @endforeach
       </select>
    </div>
</div> --}}
@endif
@endif

<br>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Repeatable</label>
    </div>
    <div class="col-sm-10">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="repeatable" class="custom-control-input" value="1" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->scorm->scorm->repeatable == '1') ? 'checked' : '') : (old('repeatable') ? 'checked' : 'checked') }}>
            <span class="custom-control-label">Yes</span>
        </label>
    </div>
</div>
@endsection

@extends('backend.course_management.bahan.form')

@section('content-bahan')
@if (!isset($data['bahan']))
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Instruktur</label>
    </div>
    <div class="col-md-10">
        <select class="select2 show-tick @error('mata_instruktur_id') is-invalid @enderror" name="mata_instruktur_id" data-style="btn-default">
            <option value=" " selected disabled></option>
            @foreach ($data['instruktur'] as $enroll)
                <option value="{{ $enroll->id }}">{{ $enroll->instruktur->user->name }}</option>
            @endforeach
        </select>
        @error('mata_instruktur_id')
        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
        @enderror
    </div>
</div>
@else
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Instruktur</label>
    </div>
    <div class="col-md-10">
        <input type="text" class="form-control" value="{{ $data['bahan']->evaluasiPengajar->mataInstruktur->instruktur->user->name }}" readonly>
    </div>
</div>
@endif
@endsection

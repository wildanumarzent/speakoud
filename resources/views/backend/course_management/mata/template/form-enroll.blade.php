@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="row flex-column-reverse flex-xl-row mt-4">
    @include('backend.course_management.mata.template.step')
    <div class="col-xl-9">
        <div class="card">
            <h6 class="card-header">
            Form Enroll Instruktur
            </h6>
            <form action="{{ route('enroll.store.template', ['id' => $data['mata']->id, 'templateId' => $data['tMata']->id]) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                        <label class="col-form-label text-sm-right">Instruktur</label>
                        </div>
                        <div class="col-md-10">
                            <select class="select2 show-tick @error('instruktur_id') is-invalid @enderror" name="instruktur_id[]" data-style="btn-default" multiple="multiple">
                                @foreach ($data['instruktur_list'] as $instruktur)
                                    <option value="{{ $instruktur->id }}"> {{ strtoupper($instruktur->user['name']) }}</option>
                                @endforeach
                            </select>
                            @error('instruktur_id')
                            <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                    <div class="col-md-10 ml-sm-auto text-md-left text-right">
                        <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['materi']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2();
</script>
@include('components.toastr')
@endsection

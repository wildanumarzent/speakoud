@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="row flex-column-reverse flex-xl-row mt-4">
    @include('backend.course_management.mata.template.step')
    <div class="col-xl-9">
        <div class="card">
            <h6 class="card-header">
            Form Mata
            </h6>
            <form action="{{ route('materi.store.template', ['id' => $data['mata']->id, 'templateId' => $data['tMata']->id]) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div id="accordion2">
                        @foreach ($data['tMata']->materi as $key => $materi)
                        <div class="card mb-2">
                            <div class="card-header">
                              <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#mata-{{ $materi->id }}">
                                <strong>{!! $materi->judul !!}</strong>
                                <div class="collapse-icon"></div>
                              </a>
                            </div>
                            <div id="mata-{{ $materi->id }}" class="collapse" data-parent="#accordion2">
                              <div class="card-body">

                                <input type="hidden" name="materi_id[]" value="{{ $materi->id }}">
                                <div class="form-group row">
                                    <div class="col-md-2 text-md-right">
                                      <label class="col-form-label text-sm-right">Instruktur </label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="select2 show-tick @error('instruktur_id.'.$key) is-invalid @enderror" name="instruktur_id[]" data-style="btn-default">
                                            <option value=" " selected>Pilih</option>
                                            @foreach ($data['instruktur'] as $instruktur)
                                            <option value="{{ $instruktur->instruktur_id }}" {{ old('instruktur_id.'.$key) == $instruktur->instruktur_id ? 'selected' : '' }}>{{ $instruktur->instruktur->user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('instruktur_id.'.$key)
                                        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                                        @enderror
                                    </div>
                                </div>

                              </div>
                            </div>
                        </div>
                        @endforeach
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

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

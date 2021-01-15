@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<script src="{{ asset('assets/tmplts_backend/js/forms_selects.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Learning Journey
    </h6>
    <form action="{{ !isset($data['journey']) ? route('journey.store') : route('journey.update', ['id' => $data['journey']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['journey']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control gen_slug @error('judul') is-invalid @enderror" name="judul" lang="id"
                    value="{{ (isset($data['journey'])) ? old('judul', $data['journey']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>


            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="masukan deskripsi...">{!! (isset($data['journey'])) ? old('deskripsi', $data['journey']->deskripsi) : old('deskripsi') !!}</textarea>
                    @include('components.field-error', ['field' => 'deskripsi'])
                </div>
            </div>



            {{-- @include('components.selectKompetensi',['kompetensi' => $data['kompetensi']]) --}}
            <hr>


        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('journey.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['journey']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{route('artikel.store')}}" method="POST">
            @csrf
           @if($data['mode'] == 'edit')
           <input type="hidden" name="id" value="{{$data['data']->id}}">
           @endif
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Title</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'title'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Intro</label>
                        </div>
                        <div class="col-md-10">
                          <textarea name="intro" id="RTE-M"></textarea>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Content</label>
                        </div>
                        <div class="col-md-10">
                          <textarea name="intro" id="RTE-IMG"></textarea>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Cover</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tags</label>
                        </div>
                        <div class="col-md-10">

                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="tags" class="form-control" id="bs-tagsinput-2"
                          value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" autofocus>
                          @include('components.field-error', ['field' => 'tags'])
                        </div>
                    </div>
                    <hr>
                    <span class="text-muted text-bold">Meta</span>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Title</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="m_title"
                          value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Description</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="m_description"
                          value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Keywords</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="m_keywords"
                          value="{{ (isset($data['data'])) ? old('title', $data['data']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-10 ml-sm-auto text-md-left text-right">
                        <a href="{{ route('artikel.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['data']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>


@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/forms_selects.js') }}"></script>
@endsection

@endsection

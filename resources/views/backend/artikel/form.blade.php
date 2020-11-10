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

        <form action="{{route('artikel.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
             <input type="hidden" name="mode" value="{{$data['mode']}}">
           @if($data['mode'] == 'edit')
           <input type="hidden" name="id" value="{{$data['artikel']->id}}">
           <input type="hidden" name="old_cover" value="{{$data['artikel']->cover}}">
           @endif
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Title</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ (isset($data['artikel'])) ? old('title', $data['artikel']->title) : old('title') }}" placeholder="masukan title..." autofocus>
                          @include('components.field-error', ['field' => 'title'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Intro</label>
                        </div>
                        <div class="col-md-10">
                          <textarea name="intro" id="RTE-M">{{old('intro')  ?? @$data['artikel']['intro']}}</textarea>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Content</label>
                        </div>
                        <div class="col-md-10">
                          <textarea name="content" id="RTE-IMG">{{old('content')  ?? @$data['artikel']['content']}}</textarea>
                          @include('components.field-error', ['field' => 'content'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Cover</label>
                        </div>
                        <div class="col-md-10">
                            <input type="file" class="form-control @error('cover') is-invalid @enderror" name="cover"
                            placeholder="masukan foto..." autofocus>
                          @include('components.field-error', ['field' => 'intro'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tags</label>
                        </div>
                        <div class="col-md-10">

                          <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" class="form-control" id="bs-tagsinput-2" autofocus>
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
                          value="{{ old('m_title', @$data['artikel']->meta_data['title']) }}" placeholder="masukan meta title..." autofocus>
                          @include('components.field-error', ['field' => 'm_title'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Description</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="m_description"
                          value="{{ old('m_description', @$data['artikel']->meta_data['description']) }}" placeholder="masukan meta description..." autofocus>
                          @include('components.field-error', ['field' => 'm_description'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Keywords</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('title') is-invalid @enderror" name="m_keywords"
                          value="{{ old('m_keywords', @$data['artikel']->meta_data['keywords']) }}" placeholder="masukan meta keywords..." autofocus>
                          @include('components.field-error', ['field' => 'm_keywords'])
                        </div>
                    </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-10 ml-sm-auto text-md-left text-right">
                        <a href="{{ route('artikel.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['artikel']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                         <button type="submit" class="btn btn-secondary" name="action" value="draft" title="Draft" data-toggle="tooltip">Draft</button>
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

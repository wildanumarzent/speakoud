@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Inquiry
    </h6>
    <form action="{{ route('inquiry.update', ['id' => 1]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Name</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control gen_slug @error('name') is-invalid @enderror" name="name" lang="id"
                    value="{{ (isset($data['inquiry'])) ? old('name', $data['inquiry']->name) : old('name') }}" placeholder="masukan nama..." autofocus>
                  @include('components.field-error', ['field' => 'name'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Slug</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" name="slug" lang="id"
                    value="{{ (isset($data['inquiry'])) ? old('slug', $data['inquiry']->slug) : old('slug') }}">
                  @include('components.field-error', ['field' => 'slug'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Body</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('body') is-invalid @enderror" name="body" placeholder="masukan body...">{!! (isset($data['inquiry'])) ? old('body', $data['inquiry']->body) : old('body') !!}</textarea>
                    @include('components.field-error', ['field' => 'body'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">After Body</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('after_body') is-invalid @enderror" name="after_body" placeholder="masukan after body...">{!! (isset($data['inquiry'])) ? old('after_body', $data['inquiry']->after_body) : old('after_body') !!}</textarea>
                    @include('components.field-error', ['field' => 'after_body'])
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Status</label>
                </div>
                <div class="col-md-10">
                    <select class="status custom-select form-control" name="publish">
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ isset($data['inquiry']) ? (old('publish', $data['inquiry']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">Form</label>
                <div class="col-sm-10">
                  <label class="custom-control custom-checkbox m-0">
                    <input type="checkbox" class="custom-control-input" name="show_form" value="1" {{ isset($data['inquiry']) ? (old('show_form', $data['inquiry']->show_form) == 1 ? 'checked' : '') : (old('show_form') ? 'checked' : '') }}>
                    <span class="custom-control-label ml-4">Show</span>
                  </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">Map</label>
                <div class="col-sm-10">
                  <label class="custom-control custom-checkbox m-0">
                    <input type="checkbox" class="custom-control-input" name="show_map" value="1" {{ isset($data['inquiry']) ? (old('show_map', $data['inquiry']->show_map) == 1 ? 'checked' : '') : (old('show_map') ? 'checked' : '') }}>
                    <span class="custom-control-label ml-4">Show</span>
                  </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Latitude</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                    value="{{ (isset($data['inquiry'])) ? old('latitude', $data['inquiry']->latitude) : old('latitude') }}" placeholder="masukan latitude..." >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Longitude</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                    value="{{ (isset($data['inquiry'])) ? old('longitude', $data['inquiry']->longitude) : old('longitude') }}" placeholder="masukan longitude..." >
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('inquiry.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['inquiry']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('jsbody')

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

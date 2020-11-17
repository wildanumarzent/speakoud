@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Artikel
    </h6>
    <form action="{{ !isset($data['artikel']) ? route('artikel.store') : route('artikel.update', ['id' => $data['artikel']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['artikel']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control gen_slug @error('judul') is-invalid @enderror" name="judul" lang="id"
                    value="{{ (isset($data['artikel'])) ? old('judul', $data['artikel']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Slug</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" name="slug" lang="id"
                    value="{{ (isset($data['artikel'])) ? old('slug', $data['artikel']->slug) : old('slug') }}">
                  @include('components.field-error', ['field' => 'slug'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Intro</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('intro') is-invalid @enderror" name="intro" placeholder="masukan intro...">{!! (isset($data['artikel'])) ? old('intro', $data['artikel']->intro) : old('intro') !!}</textarea>
                    @include('components.field-error', ['field' => 'intro'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Content</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('content') is-invalid @enderror" name="content" placeholder="masukan content...">{!! (isset($data['artikel'])) ? old('content', $data['artikel']->content) : old('content') !!}</textarea>
                    @include('components.field-error', ['field' => 'content'])
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
                        <option value="{{ $key }}" {{ isset($data['artikel']) ? (old('publish', $data['artikel']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tags</label>
                </div>
                <div class="col-md-10">
                    <input type="text" value="@if(isset($data['artikel'])) @forelse($data['artikel']->tags as $tag) {{$tag->parent->nama}},  @empty @endforelse @endif" name="tags" class="form-control" id="tags">
                </div>
            </div>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Cover</label>
                </div>
                @if (isset($data['artikel']))
                    <input type="hidden" name="old_cover_file" value="{{ $data['artikel']->cover['filename'] }}">
                    <div class="col-md-1">
                        <a href="{{ $data['artikel']->getCover($data['artikel']->cover['filename']) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['artikel']->getCover($data['artikel']->cover['filename']) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['artikel']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                    @include('components.field-error', ['field' => 'cover_file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_title" value="{{ isset($data['artikel']) ? old('cover_title', $data['artikel']->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_alt" value="{{ isset($data['artikel']) ? old('cover_alt', $data['artikel']->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Title</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title"
                    value="{{ (isset($data['artikel'])) ? old('meta_title', $data['artikel']->meta_data['title']) : old('meta_title') }}" placeholder="masukan meta title..." >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Description</label>
                </div>
                <div class="col-md-10">
                  <textarea class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" placeholder="separated by comma(,)" >{{ (isset($data['artikel'])) ? old('meta_description', $data['artikel']->meta_data['description']) : old('meta_description') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Keywords</label>
                </div>
                <div class="col-md-10">
                  <textarea class="form-control @error('meta_keywords') is-invalid @enderror" name="meta_keywords" placeholder="separated by comma(,)" >{{ (isset($data['artikel'])) ? old('meta_keywords', $data['artikel']->meta_data['keywords']) : old('meta_keywords') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('artikel.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['artikel']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
// Bootstrap Tagsinput
$(function() {

  $('#tags').tagsinput({ tagClass: 'badge badge-primary' });
});
</script>
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

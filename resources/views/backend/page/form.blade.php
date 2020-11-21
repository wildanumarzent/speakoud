@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
@if (isset($data['parent']))
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        Under "<strong>{{ $data['parent']->judul }}</strong>"
      </div>
    </div>
</div>
@endif

<div class="card">
    <h6 class="card-header">
      Form Page
    </h6>
    <form action="{{ !isset($data['page']) ? route('page.store', ['parent' => Request::get('parent')]) : route('page.update', ['id' => $data['page']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['page']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control gen_slug @error('judul') is-invalid @enderror" name="judul" lang="id"
                    value="{{ (isset($data['page'])) ? old('judul', $data['page']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Slug</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" name="slug" lang="id"
                    value="{{ (isset($data['page'])) ? old('slug', $data['page']->slug) : old('slug') }}">
                  @include('components.field-error', ['field' => 'slug'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Intro</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('intro') is-invalid @enderror" name="intro" placeholder="masukan intro...">{!! (isset($data['page'])) ? old('intro', $data['page']->intro) : old('intro') !!}</textarea>
                    @include('components.field-error', ['field' => 'intro'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Content</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('content') is-invalid @enderror" name="content" placeholder="masukan content...">{!! (isset($data['page'])) ? old('content', $data['page']->content) : old('content') !!}</textarea>
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
                        <option value="{{ $key }}" {{ isset($data['page']) ? (old('publish', $data['page']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Cover</label>
                </div>
                @if (isset($data['page']))
                    <input type="hidden" name="old_cover_file" value="{{ $data['page']->cover['filename'] }}">
                    <div class="col-md-1">
                        <a href="{{ $data['page']->getCover($data['page']->cover['filename']) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['page']->getCover($data['page']->cover['filename']) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['page']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                    @include('components.field-error', ['field' => 'cover_file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_title" value="{{ isset($data['page']) ? old('cover_title', $data['page']->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_alt" value="{{ isset($data['page']) ? old('cover_alt', $data['page']->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                        </div>
                    </div>
                </div>
            </div>
            @role('developer')
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Custom View</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('custom_view') is-invalid @enderror" name="custom_view"
                    value="{{ (isset($data['page'])) ? old('custom_view', $data['page']->custom_view) : old('custom_view') }}" placeholder="masukan custom view...">
                  @include('components.field-error', ['field' => 'custom_view'])
                </div>
            </div>
            @else
            <input type="hidden" name="custom_view" value="{{ !isset($data['page']) ? old('custom_view') : old('custom_view', $data['page']->custom_view) }}">
            @endrole
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Title</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title"
                    value="{{ (isset($data['page'])) ? old('meta_title', $data['page']->meta_data['title']) : old('meta_title') }}" placeholder="masukan meta title..." >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Description</label>
                </div>
                <div class="col-md-10">
                  <textarea class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" placeholder="separated by comma(,)" >{{ (isset($data['page'])) ? old('meta_description', $data['page']->meta_data['description']) : old('meta_description') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Meta Keywords</label>
                </div>
                <div class="col-md-10">
                  <textarea class="form-control @error('meta_keywords') is-invalid @enderror" name="meta_keywords" placeholder="separated by comma(,)" >{{ (isset($data['page'])) ? old('meta_keywords', $data['page']->meta_data['keywords']) : old('meta_keywords') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('page.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['page']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

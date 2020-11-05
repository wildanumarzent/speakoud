@extends('layouts.backend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('layout-content')
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    @foreach ($errors->all() as $error)
        <i class="las la-ban"></i> {{ $error }} <br>
    @endforeach
  </div>
@endif

<div class="card">
    <div class="card-header with-elements">
        <div class="card-header-elements">
            <div class="file-manager-container file-manager-col-view" style="background-color: #fff !important">
                <form action="{{ route('bank.data.filemanager', ['path' => Request::get('path')]) }}" method="GET">
                    <div class="input-group">
                        @if (Request::get('path') != null)
                            <input type="hidden" name="path" value="{{ Request::get('path') }}">
                        @endif
                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Filename...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="file-manager-container file-manager-col-view" id="files">
        @if (!empty(Request::get('path')))
        <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <a href="javascript:history.back()" class="file-item-icon las la-level-up-alt text-secondary"></a>
            <a href="javascript:history.back()" class="file-item-name">
            ..&nbsp;
            </a>
            <div class="file-item-changed">-</div>
            <div class="file-item-actions btn-group dropdown">

            </div>
        </div>
        @endif
        @foreach ($data['directories'] as $key => $value)
        <div class="file-item">
            <a href="{{ route('bank.data', ['type' => Request::segment(3), 'path' => $value['path']]) }}">
                <div class="file-item-icon las la-folder-open text-secondary"></div>
                <div class="file-item-name">
                    {{ $value['name'] }}
                </div>
            </a>
            @if ($data['roles'] && Request::segment(3) == 'global' || !$data['roles'] && Request::segment(3) == 'personal')
            <div class="file-item-actions btn-group dropdown">
                <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class=" dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item js-sa2-delete" href="javascript:;" data-url="{{ route('bank.data.directory.destroy', ['path' => $value['full_path']]) }}"
                        title="klik untuk menghapus folder">
                        <i class="las la-trash-alt"></i>
                        <span>Hapus</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endforeach
        @foreach ($data['files'] as $key => $file)
        <div class="file-item only">
            @if ($file->file_type == 'mp3' || $file->file_type == 'pptx' || $file->file_type == 'ppt' || $file->file_type == 'pdf')
            <a href="javascript:;" class="file-item-name modals-preview" data-toggle="modal" data-target="#preview-file"
                data-id="{{ $file->id }}" data-type="{{ $file->file_type }}" data-path="{{ $file->file_path }}">
            @else
            <a href="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="file-item-name" data-fancybox="gallery">
            @endif
                @if ($file->file_type == 'jpg' || $file->file_type == 'jpeg' || $file->file_type == 'png')
                    <div class="file-item-img" style="background-image: url({{ route('bank.data.stream', ['path' => $file->file_path]) }})"></div>
                @else
                    <div class="file-item-icon las la-file-{{ $file->icon($file->file_type) }} text-secondary"></div>
                @endif
                <div class="desc-of-name">
                    {{ $file->name($file) }}
                </div>
            </a>
            @if ($data['roles'] || $file->owner_id == auth()->user()->id)
            <div class="file-item-actions btn-group dropdown">
                <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:;" class="dropdown-item modals-edit" data-toggle="modal" data-target="#modals-edit-file" title="klik untuk mengedit file"
                    onclick="edit_file({{ $file->id }})" data-id="{{ $file->id }}" data-thumbnail="{{ $file->thumbnail }}" data-filename="{{ $file->filename }}"
                    data-keterangan="{{ $file->keterangan }}" data-is-video="{{ $file->is_video }}" data-thumb-default="{{ asset(config('addon.images.thumbnail')) }}">
                    <i class="las la-pen"></i> Edit
                    </a>
                    <a class="dropdown-item js-sa2-delete-file" href="javascript:void(0)" data-file-id="{{ $file->id }}" title="klik untuk menghapus file">
                    <i class="las la-trash-alt"></i> Hapus
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endforeach
        @if (count($data['directories']) == 0 && count($data['files']) == 0)
        <div class="file-item">
            <div class="file-item-icon las la-ban text-danger"></div>
            <div class="file-item-name">
                Data kosong
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>

@include('components.toastr')
@endsection

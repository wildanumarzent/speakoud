@extends('layouts.backend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/file-manager.css') }}">
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
        {{-- <div class="card-header-elements ml-auto">
            <div class="file-manager-actions">
                <a href="{{ route('bank.data', ['type' => 'global']) }}" class="btn btn-primary icon-btn-only-sm mr-2" title="klik untuk upload file">
                    <i class="las la-upload"></i>
                    <span>Upload</span>
                </a>
            </div>
        </div> --}}
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
        </div>
        @endforeach
        @foreach ($data['files'] as $key => $file)
        <div class="file-item only">
            @if (Request::get('view') == 'text-editor')
            <a href="javascript:void();" data-link="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="js-select-file">
            @endif
            @if (Request::get('view') == 'button')
            <a href="#" data-link="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="js-select-file" onclick="sendPath()">
            <input type="hidden" value="{{ $file->file_path }}" id="path">
            @endif
                <div class="file-item-name">
                    @if ($file->file_type == 'jpg' || $file->file_type == 'jpeg' || $file->file_type == 'png')
                        <div class="file-item-img" style="background-image: url({{ route('bank.data.stream', ['path' => $file->file_path]) }})"></div>
                    @else
                        <div class="file-item-icon las la-file-{{ $file->icon($file->file_type) }} text-secondary"></div>
                    @endif
                    <div class="desc-of-name">
                        {{ $file->name($file) }}
                    </div>
                </div>
            </a>
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
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
@if (Request::get('view') == 'text-editor')
<script>
    $(document).ready(function () {
        $('.js-select-file').on('click', function (e) {
            var link = $(this).attr('data-link'),
            base = window.opener || window.parent;
            e.preventDefault();
            base.postMessage({ sender: "TestFM", url: link }, "*");
        });
    });
</script>
@endif
@if (Request::get('view') == 'button')
<script>
    function sendPath() {
       if (window.opener != null && !window.opener.closed) {
                var pathName = window.opener.document.getElementById("file_path");
                pathName.value = document.getElementById("path").value;
            }
        window.close();
    }
</script>
@endif
@include('components.toastr')
@endsection

@extends('layouts.backend.application')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/dropzone/dropzone.css') }}">
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
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="type-file" value="{{ Request::get('type-file') }}">
                        <input type="hidden" name="view" value="{{ Request::get('view') }}">
                        <input type="hidden" name="path" value="{{ Request::get('path') }}">
                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Nama File...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-header-elements ml-auto">
            <div class="file-manager-actions">
                <button type="button" class="btn btn-warning icon-btn-only-sm mr-2" data-toggle="modal" data-target="#modals-form-folder" title="klik untuk membuat folder">
                    <i class="las la-folder-plus"></i>
                    <span>Folder</span>
                </button>
                <div class="btn-group float-right dropdown ml-2">
                    <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown"><i class="las la-upload"></i><span>Upload</span></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:;" class="dropdown-item" data-toggle="modal" data-target="#modals-add-file" title="klik untuk mengupload file">
                            <i class="las la-file-upload"></i>
                            <span>Form</span>
                        </a>
                        <a href="javascript:;" id="upload" class="dropdown-item" title="klik untuk mengupload file">
                            <i class="las la-hand-pointer"></i>
                            <span>Drag / Drop</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    @if (!empty(Request::get('path')))
        @php
            $getLast = collect(explode("/", Request::get('path')))->last();
            $getCur = str_replace($getLast, '', Request::get('path'));
            $rplc = Str::replaceFirst('/', '', Request::get('path'));
            $pathFolder = explode('/', $rplc);
        @endphp
        <ol class="breadcrumb bg-lighter">
            <li class="breadcrumb-item">
                <a href="{{ route('bank.data', ['type' => Request::segment(3)]) }}">Bank Data</a>
            </li>
            @foreach ($pathFolder as $pf)
                @if ($pf == $getLast)
                    <li class="breadcrumb-item active">{!! Str::limit($pf, 15) !!}</li>
                @else
                    <li class="breadcrumb-item">
                    <a href="{{ route('bank.data', ['type' => Request::segment(3), 'path' => Str::replaceLast('/', '', $getCur)]) }}">{!! Str::limit($pf, 15) !!}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    @endif
    <div class="file-manager-container file-manager-col-view" id="files">
        @if (!empty(Request::get('path')))
        <div class="file-item">
            @php
                $lastPath = collect(explode("/", Request::get('path')))->last();
                $path = str_replace('/'.$lastPath, '', Request::get('path'));
                if (Request::get('view') == 'text-editor') {
                    $route = route('bank.data.filemanager', ['view' => Request::get('view')]);
                    if (!empty($path)) {
                        $route = route('bank.data.filemanager', ['view' => Request::get('view'), 'path' => $path]);
                    }
                } else {
                    $route = route('bank.data.filemanager', ['type-file' => Request::get('type-file'), 'view' => Request::get('view')]);
                    if (!empty($path)) {
                        $route = route('bank.data.filemanager', ['type-file' => Request::get('type-file'), 'view' => Request::get('view'), 'path' => $path]);
                    }
                }
            @endphp
            <div class="file-item-select-bg bg-primary"></div>
            <a href="{{ $route }}" class="file-item-icon las la-level-up-alt text-secondary"></a>
            <a href="{{ $route }}" class="file-item-name">
            ..&nbsp;
            </a>
            <div class="file-item-changed">-</div>
            <div class="file-item-actions btn-group dropdown">

            </div>
        </div>
        @endif
        @if (empty(Request::get('q')))
        @foreach ($data['directories'] as $key => $value)
        <div class="file-item">
            <a href="{{ route('bank.data.filemanager', ['type-file' => Request::get('type-file'), 'view' => Request::get('view'), 'path' => $value['path']]) }}">
                <div class="file-item-icon las la-folder-open text-secondary"></div>
                <div class="file-item-name">
                    {{ $value['name'] }}
                </div>
            </a>
        </div>
        @endforeach
        @endif
        @foreach ($data['files'] as $key => $file)
        <div class="file-item only">
            @if (Request::get('view') == 'text-editor')
            <a href="javascript:void();" data-link="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="js-select-file">
            @endif
            @if (Request::get('view') == 'button')
            <a href="#" data-link="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="js-select-file" onclick="sendPath(this.getAttribute('data-id'))" data-id="{{ $file->id }}">
            <input type="hidden" value="{{ $file->file_path }}" id="path-{{ $file->id }}">
            @endif
                <div class="file-item-name">
                    @if ($file->file_type == 'jpg' || $file->file_type == 'jpeg' || $file->file_type == 'png')
                        <div class="file-item-img" style="background-image: url({{ route('bank.data.stream', ['path' => $file->file_path]) }})"></div>
                    @else
                        <div class="file-item-icon las la-file-{{ $file->icon($file->file_type) }} text-secondary"></div>
                    @endif
                    <div class="desc-of-name">
                        {{ $file->NameFile($file) }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @if (empty(Request::get('q')) ? count($data['directories']) == 0 && count($data['files']) == 0 : count($data['files']) == 0)
        <div class="file-item">
            <div class="file-item-icon las la-ban text-danger"></div>
            <div class="file-item-name">
                Data kosong
            </div>
        </div>
        @endif
    </div>
    <div id="dropzone">
        <div class="dropzone needsclick" id="dropzone-upload">
            <div class="dz-message needsclick">
              Drop files disini atau klik untuk upload
              <span class="note needsclick">(Tipe File : <strong>{{ strtoupper(config('addon.mimes.bank_data.m')) }}</strong>, Max Upload File <strong>10</strong>, Max Upload Size : <strong>{{ ini_get('upload_max_filesize') }}</strong>)</span>
            </div>
            <div class="fallback">
              <input name="file" type="file" multiple>
            </div>
        </div>
    </div>
</div>

@include('backend.bank_data.form-folder')
@include('backend.bank_data.form-add-file')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/dropzone/dropzone.js') }}"></script>
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
    function sendPath(data_id) {
        if (window.opener != null && !window.opener.closed) {
            var pathName = window.opener.document.getElementById("file_path");
            pathName.value = document.getElementById("path-" + data_id).value;
        }
        window.close();
    }
</script>
@endif
<script>
    $(document).ready(function () {
    //form upload
    $('#files').show();
    $("#dropzone").hide();
    $('#upload').click(function(){
        $('#files').toggle('slow');
        $("#dropzone").toggle('slow');
    });
    //dropzone
    $('#dropzone-upload').dropzone({
        url: '/files?path={{ Request::get('path') }}&view={{ Request::get('view') }}',
        method:'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        parallelUploads: 2,
        maxFilesize: 2000,
        maxFiles: 10,
        filesizeBase: 1000,
        // acceptedFiles:"image/*",
        paramName:"file_path",
        dictInvalidFileType:"Type file ini tidak dizinkan",
        addRemoveLinks: true,

        init : function () {
            this.on('complete', function () {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success('Berhasil upload file', 'Success');

                    setTimeout(() => window.location.reload(), 1500);
                }
            });
        }
    });
});
</script>
@include('components.toastr')
@endsection

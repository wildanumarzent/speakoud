@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
@include('components.alert-any')

<div class="card">
    <div class="card-header with-elements">
        <div class="card-header-elements">
            <div class="file-manager-container file-manager-col-view" style="background-color: #fff !important">
                <form action="{{ route('bank.data', ['type' => Request::segment(3), 'path' => Request::get('path')]) }}" method="GET">
                    <div class="input-group">
                        @if (Request::get('path') != null)
                            <input type="hidden" name="path" value="{{ Request::get('path') }}">
                        @endif
                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Nama File...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-header-elements ml-auto">
            @if ($data['roles'] && Request::segment(3) == 'global' || !$data['roles'] && Request::segment(3) == 'personal')
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
            @endif
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
                    $route = route('bank.data', ['type' => Request::segment(3)]);
                    if (!empty($path)) {
                        $route = route('bank.data', ['type' => Request::segment(3), 'path' => $path]);
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
            @endif
            @foreach ($data['files'] as $key => $file)
            <div class="file-item only">
                @if ($file->file_type == 'mp3' || $file->file_type == 'wav' || $file->file_type == 'pptx' || $file->file_type == 'ppt' || $file->file_type == 'pdf')
                <a href="javascript:;" class="file-item-name modals-preview" data-toggle="modal" data-target="#preview-file"
                    data-id="{{ $file->id }}" data-type="{{ $file->file_type }}" data-path="{{ $file->file_path }}">
                @else
                <a href="{{ route('bank.data.stream', ['path' => $file->file_path]) }}" class="file-item-name" data-fancybox="gallery">
                @endif
                    @if ($file->file_type == 'jpg' || $file->file_type == 'jpeg' || $file->file_type == 'png' || $file->is_video == 1)
                        @if (!empty($file->thumbnail))
                        <div class="file-item-img" style="background-image: url({{ route('bank.data.stream', ['path' => $file->thumbnail]) }})"></div>
                        @else
                        <div class="file-item-icon las la-file-{{ $file->icon($file->file_type) }} text-secondary"></div>
                        @endif
                    @else
                        <div class="file-item-icon las la-file-{{ $file->icon($file->file_type) }} text-secondary"></div>
                    @endif
                    <div class="desc-of-name">
                        {{ $file->NameFile($file) }}
                    </div>
                </a>
                @if ($data['roles'] || $file->owner_id == auth()->user()->id)
                <div class="file-item-actions btn-group dropdown">
                    <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a href="javascript:;" class="dropdown-item modals-edit" data-toggle="modal" data-target="#modals-edit-file" title="klik untuk mengubah file" data-id="{{ $file->id }}" data-thumbnail="{{ $file->thumbnail }}" data-filename="{{ $file->filename }}"
                        data-keterangan="{{ $file->keterangan }}" data-is-video="{{ $file->is_video }}" data-thumb-default="{{ asset(config('addon.images.thumbnail')) }}">
                        <i class="las la-pen"></i> Ubah
                      </a>
                      <a class="dropdown-item js-sa2-delete-file" href="javascript:void(0)" data-file-id="{{ $file->id }}" title="klik untuk menghapus file">
                        <i class="las la-trash-alt"></i> Hapus
                      </a>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
            @if (empty(Request::get('q')) ? count($data['directories']) == 0 && count($data['files']) == 0 : count($data['files']) == 0)
            <div class="file-item">
                <div class="file-item-icon las la-ban text-danger"></div>
                <div class="file-item-name">
                  File kosong
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
</div>

@include('backend.bank_data.form-folder')
@include('backend.bank_data.form-add-file')
@include('backend.bank_data.form-edit-file')
@include('backend.bank_data.preview-file')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>

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
        url: '/files?path={{ Request::get('path') }}',
        method:'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        parallelUploads: 2,
        maxFilesize: 0,
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
    //delete directory
    $('.js-sa2-delete').on('click', function () {
        var data_url = $(this).attr('data-url');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus folder ini. Data yang sudah dihapus tidak dapat dikembalikan!",
            type: "warning",
            confirmButtonText: "Ya, hapus!",
            customClass: {
                confirmButton: "btn btn-danger btn-lg",
                cancelButton: "btn btn-info btn-lg"
            },
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: () => !Swal.isLoading(),
            cancelButtonText: "Tidak, terima kasih",
            preConfirm: () => {
                return $.ajax({
                    url: data_url,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                }).then(response => {
                    if (!response.success) {
                        return new Error(response.message);
                    }
                    return response;
                }).catch(error => {
                    swal({
                        type: 'error',
                        text: 'Error while deleting data. Error Message: ' + error
                    })
                });
            }
        }).then(response => {
            if (response.value.success) {
                Swal.fire({
                    type: 'success',
                    text: 'Folder berhasil dihapus'
                }).then(() => {
                    window.location.reload();
                })
            } else {
                Swal.fire({
                    type: 'error',
                    text: response.value.message
                }).then(() => {
                    window.location.reload();
                })
            }
        });
    });
    //delete file
    $('.js-sa2-delete-file').on('click', function () {
        var id = $(this).attr('data-file-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus file ini, data yang bersangkutan dengan file ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
            type: "warning",
            confirmButtonText: "Ya, hapus!",
            customClass: {
                confirmButton: "btn btn-danger btn-lg",
                cancelButton: "btn btn-info btn-lg"
            },
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: () => !Swal.isLoading(),
            cancelButtonText: "Tidak, terima kasih",
            preConfirm: () => {
                return $.ajax({
                    url: '/files/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                }).then(response => {
                    if (!response.success) {
                        return new Error(response.message);
                    }
                    return response;
                }).catch(error => {
                    swal({
                        type: 'error',
                        text: 'Error while deleting data. Error Message: ' + error
                    })
                });
            }
        }).then(response => {
            if (response.value.success) {
                Swal.fire({
                    type: 'success',
                    text: 'File berhasil dihapus'
                }).then(() => {
                    window.location.reload();
                })
            } else {
                Swal.fire({
                    type: 'error',
                    text: response.value.message
                }).then(() => {
                    window.location.reload();
                })
            }
        });
    });
});

$('.modals-edit').click(function() {
    var id = $(this).data('id');
    var is_video = $(this).data('is-video');
    var thumbnail = $(this).data('thumbnail');
    var thumb_default = $(this).data('thumb-default');
    var filename = $(this).data('filename');
    var keterangan = $(this).data('keterangan');
    var url = '/files/' + id;

    if (is_video == 1) {
        $('#form-thumbnail').show();

        if (thumbnail != '') {
            $(".modal-body #old-thumb").attr("src", '/bank/data/view/' + thumbnail);
        } else {
            $(".modal-body #old-thumb").attr("src", thumb_default);
        }

    } else {
        $('#form-thumbnail').hide();
    }

    $(".modal-dialog #form-edit-file").attr('action', url);
    $('.modal-body #thumbnail').val(thumbnail);
    $('.modal-body #filename').val(filename);
    $('.modal-body #keterangan').val(keterangan);
});

//modal preview file
$('.modals-preview').click(function() {
    var path = $(this).data('path');
    var type = $(this).data('type');
    var url = '/bank/data/view/' + path;

    if (type == 'mp3') {
        $('#view-audio').show();
        $("#plyr-audio-player").attr("src", url);
    } else {
        $('#view-audio').hide();
    }

    if (type == 'ppt' || type == 'pptx') {
        $('#view-ppt').show();
        $("#src-ppt").attr("src", "https://view.officeapps.live.com/op/view.aspx?src=" + url);
    } else {
        $('#view-ppt').hide();
    }

    if (type == 'pdf') {
        $('#view-pdf').show();
        $("#src-pdf").attr("src", url);
    } else {
        $('#view-pdf').hide();
    }
});
</script>

@include('components.toastr')
@endsection

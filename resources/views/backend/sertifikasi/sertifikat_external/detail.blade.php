@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="text-left">
    <a href="{{ route('sertifikat.external.peserta', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke program"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Sertifikat External</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-body">
        <div class="file-manager-container file-manager-col-view" id="files">
            @foreach ($data['sertifikat'] as $item)
            <div class="file-item only">
                <a href="{{ route('bank.data.stream', ['path' => $item->sertifikat]) }}" target="_blank" class="file-item-name">
                    <div class="file-item-icon las la-certificate text-secondary"></div>
                    <div class="desc-of-name">
                        {{ collect(explode("/", $item->sertifikat))->last() }}
                    </div>
                </a>
                <div class="file-item-actions btn-group dropdown">
                    <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item js-sa2-delete" href="javascript:void(0)" data-mataid="{{ $item->mata_id }}" data-pesertaid="{{ $item->peserta_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus file sertifikat">
                        <i class="las la-trash-alt"></i> Hapus
                      </a>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($data['sertifikat']->count() == 0)
            <div class="file-item">
                <div class="file-item-icon las la-ban text-danger"></div>
                <div class="file-item-name">
                  Sertifikat kosong
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
$(document).ready(function () {
    $('.js-sa2-delete').on('click', function () {
        var mata_id = $(this).attr('data-mataid');
        var peserta_id = $(this).attr('data-pesertaid');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus sertifikat ini, Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/mata/"+ mata_id +"/sertifikat/external/peserta/"+ peserta_id +"/detail/" + id,
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
                    text: 'Sertifikat berhasil dihapus'
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
    })
});
</script>

@include('components.toastr')
@endsection



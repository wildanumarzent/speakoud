@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<!-- Filters -->
<div class="card">
    <div class="card-body">
        <div class="form-row align-items-center">
            <div class="col-md">
                <form action="" method="GET">
                    <div class="form-group">
                        <label class="form-label">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->

<div class="text-left">
@role ('instruktur_internal|instruktur_mitra')
    <button type="button" onclick="goBack()" class="btn btn-secondary rounded-pill" title="kembali ke list template soal"><i class="las la-arrow-left"></i>Kembali</button>
@else
    <a href="{{ route('template.mata.index') }}" class="btn btn-secondary rounded-pill" title="kembali ke list template mata"><i class="las la-arrow-left"></i>Kembali</a>
@endrole
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Template Kategori Soal List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('template.soal.kategori.create', ['id' => $data['mata']->id]) }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah kategori soal">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Judul</th>
                    <th>Keterangan</th>
                    <th style="width: 120px;">Jumlah Soal</th>
                    <th style="width: 210px;">Pembuat</th>
                    <th style="width: 230px;">Tanggal Dibuat</th>
                    <th style="width: 230px;">Tanggal Diperbarui</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['kategori']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('q'))
                        ! Kategori soal tidak ditemukan !
                        @else
                        ! Kategori soal kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['kategori'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-center"><span class="badge badge-primary"><strong>{{ $item->soal->count() }}</strong></span></td>
                    <td>{{ $item->creator->name }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td>
                        <a href="{{ route('template.soal.index', ['id' => $item->template_mata_id, 'kategoriId' => $item->id]) }}" class="btn icon-btn btn-sm btn-success" title="klik untuk melihat list template soal">
                            <i class="las la-list"></i>
                        </a>
                        <a href="{{ route('template.soal.kategori.edit', ['id' => $item->template_mata_id, 'kategoriId' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit template kategori soal">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-mataid="{{ $item->template_mata_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus template kategori soal">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['kategori']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('q'))
                        ! Kategori soal tidak ditemukan !
                        @else
                        ! Kategori soal kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['kategori'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Judul</div>
                                    <div class="desc-table">{{ $item->judul }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Keterangan</div>
                                    <div class="desc-table">{{ $item->keterangan ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Creator</div>
                                    <div class="desc-table">{{ $item->creator->name }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('template.soal.index', ['id' => $item->template_mata_id, 'kategoriId' => $item->id]) }}" class="btn icon-btn btn-sm btn-success" title="klik untuk melihat list template soal">
                                            <i class="las la-list"></i>
                                        </a>
                                        <a href="{{ route('template.soal.kategori.edit', ['id' => $item->template_mata_id, 'kategoriId' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit template kategori soal">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-mataid="{{ $item->template_mata_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus template kategori soal">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            <tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['kategori']->firstItem() }}</strong> - <strong>{{ $data['kategori']->lastItem() }}</strong> dari
                <strong>{{ $data['kategori']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['kategori']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
$(document).ready(function () {
    $('.js-sa2-delete').on('click', function () {
        var mata_id = $(this).attr('data-mataid');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus template kategori soal ini, data yang bersangkutan dengan template kategori soal ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/template/mata/"+ mata_id +"/soal/kategori/" + id,
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
                    text: 'template kategori soal berhasil dihapus'
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

function goBack() {
    window.history.back();
}
</script>

@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
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

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Instansi Mitra List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('instansi.mitra.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah instansi" data-toggle="tooltip">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Logo</th>
                    <th>Nama Instansi</th>
                    <th>Telpon</th>
                    <th>Fax</th>
                    <th>Nama Pimpinan</th>
                    <th>Jabatan</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['instansi']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Instansi tidak ditemukan !
                            @else
                            ! Data Instansi kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instansi'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>
                        <a href="{{ $item->getLogo($item->logo) }}" data-fancybox="gallery">
                            <img src="{{ $item->getLogo($item->logo) }}" class="d-block ui-w-80">
                        </a>
                    </td>
                    <td>{{ $item->nama_instansi }}</td>
                    <td>{{ $item->telpon ?? '-' }}</td>
                    <td>{{ $item->fax ?? '-' }}</td>
                    <td>{{ $item->nama_pimpinan }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        <a href="{{ route('instansi.mitra.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit Instansi" data-toggle="tooltip">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus Instansi" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['instansi']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Instansi tidak ditemukan !
                            @else
                            ! Data Instansi kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instansi'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Nama Instansi</div>
                                    <div class="desc-table">{{ $item->nama_instansi }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Telpon</div>
                                    <div class="desc-table">{{ $item->telpon ?? null }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Fax</div>
                                    <div class="desc-table">{{ $item->fax ?? null }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nama Pimpinan</div>
                                    <div class="desc-table">{{ $item->nama_pimpinan }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Jabatan</div>
                                    <div class="desc-table">{{ $item->jabatan }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('instansi.mitra.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit Instansi" data-toggle="tooltip">
                                                <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus Instansi" data-toggle="tooltip">
                                            <i class="las la-trash-alt"></i>
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
                Menampilkan : <strong>{{ $data['instansi']->firstItem() }}</strong> - <strong>{{ $data['instansi']->lastItem() }}</strong> dari
                <strong>{{ $data['instansi']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['instansi']->onEachSide(1)->links() }}
            </div>
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
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus instansi ini, data yang bersangkutan dengan instansi ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/instansi/mitra/" + id,
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
                    text: 'instansi berhasil dihapus'
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

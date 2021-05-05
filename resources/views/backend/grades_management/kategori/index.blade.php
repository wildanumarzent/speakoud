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
                        <label class="form-label">Limit</label>
                        <select class="limit custom-select" name="l">
                            <option value="20" selected>Any</option>
                            @foreach (config('custom.filtering.limit') as $key => $val)
                            <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="Limit {{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-md">
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
        <h5 class="card-header-title mt-1 mb-0">Grades Kategori List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('grades.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah grades kategori">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th style="width: 210px;">Pembuat</th>
                    <th style="width: 230px;">Tanggal Dibuat</th>
                    <th style="width: 230px;">Tanggal Diperbarui</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['kategori']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i><strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! Grades kategori tidak ditemukan !
                        @else
                        ! Grades kategori kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['kategori'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->creator->name }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td>
                        <a href="{{ route('grades.nilai', ['id' => $item->id]) }}" class="btn btn-sm btn-success" title="klik untuk melihat list grades">
                            <i class="las la-list-ol"></i> Nilai
                        </a>
                        <a href="{{ route('grades.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit grades kategori">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="klik untuk menghapus grades kategori">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['kategori']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i><strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! Grades kategori tidak ditemukan !
                        @else
                        ! Grades kategori kosong !
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
                                    <div class="data-table">Nama</div>
                                    <div class="desc-table">{{ $item->nama }}</div>
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
                                        <a href="{{ route('grades.nilai', ['id' => $item->id]) }}" class="btn btn-sm btn-success" title="klik untuk melihat list grades">
                                            <i class="las la-list-ol"></i> Nilai
                                        </a>
                                        <a href="{{ route('grades.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit grades kategori">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="klik untuk menghapus grades kategori">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
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
    $('.swal-delete').on('click', function () {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus kategori ini. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/grades/" + id,
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
                    text: 'Grades kategori berhasil dihapus'
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

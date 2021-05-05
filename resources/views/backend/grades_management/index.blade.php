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

<div class="text-left">
    <a href="{{ route('grades.index') }}" class="btn btn-secondary rounded-pill" title="kembali ke list kategori"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Grades Nilai List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('grades.nilai.create', ['id' => $data['kategori']->id]) }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah nilai grades">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Nilai Maksimum</th>
                    <th>Nilai Minimum</th>
                    <th>Keterangan</th>
                    <th style="width: 200px;">Tanggal Dibuat</th>
                    <th style="width: 200px;">Tanggal Diperbarui</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['nilai']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! Nilai Grades tidak ditemukan !
                            @else
                            ! Nilai Grades kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['nilai'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{{ $item->maksimum.' %' }}</td>
                    <td>{{ $item->minimum.' %' }}</td>
                    <td><span class="badge badge-primary">{{ $item->keterangan }}</span></td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        <a href="{{ route('grades.nilai.edit', ['id' => $item->kategori_id, 'nilaiId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit nilai grades">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-kategoriid="{{ $item->kategori_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus nilai grades">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['nilai']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! Nilai Grades tidak ditemukan !
                            @else
                            ! Nilai Grades kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['nilai'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Nilai Maksimum</div>
                                    <div class="desc-table">{{ $item->maksimum.' %' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nilai Minimum</div>
                                    <div class="desc-table">{{ $item->minimum.' %' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Keterangan</div>
                                    <div class="desc-table"><span class="badge badge-primary">{{ $item->keterangan }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Created</div>
                                    <div class="desc-table">{{ $item->created_at->format('d F Y - (H:i)') }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Updated</div>
                                    <div class="desc-table">{{ $item->updated_at->format('d F Y - (H:i)') }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('grades.nilai.edit', ['id' => $item->kategori_id, 'nilaiId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit nilai grades">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-kategoriid="{{ $item->kategori_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus nilai grades">
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
                Menampilkan : <strong>{{ $data['nilai']->firstItem() }}</strong> - <strong>{{ $data['nilai']->lastItem() }}</strong> dari
                <strong>{{ $data['nilai']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['nilai']->onEachSide(1)->links() }}
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
    $('.swal-delete').on('click', function () {
        var kategori_id = $(this).attr('data-kategoriid');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus nilai ini, data yang bersangkutan dengan nilai ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/grades/" + kategori_id + "/nilai/" + id,
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
                    text: 'nilai grades berhasil dihapus'
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

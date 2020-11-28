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
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.quiz_item_tipe') as $key => $value)
                        <option value="{{ $key }}" {{ Request::get('t') == ''.$key.'' ? 'selected' : '' }}>{{ $value['title'] }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Soal List</h5>
        <div class="card-header-elements ml-auto">
            <div class="btn-group float-right dropdown ml-2">
                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown"><i class="las la-plus"></i><span>Tambah</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach (config('addon.label.quiz_item_tipe') as $key => $tipe)
                    <a href="{{ route('soal.create', ['id' => $data['kategori']->id, 'tipe' => $key]) }}" class="dropdown-item" ><i class="las la-circle"></i><span>{{ $tipe['title'] }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Tipe Soal</th>
                    <th style="width: 210px;">Creator</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['soal']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('t') || Request::get('q'))
                        ! Soal tidak ditemukan !
                        @else
                        ! Data Soal kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['soal'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{!! $item->pertanyaan !!}</td>
                    <td><span class="badge badge-{{ $item->tipe($item->tipe_jawaban)['color'] }}">{{ $item->tipe($item->tipe_jawaban)['title'] }}</span></td>
                    <td>{{ $item->creator->name }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td>
                        <a href="{{ route('soal.edit', ['id' => $item->kategori_id, 'soalId' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit soal">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-kategoriid="{{ $item->kategori_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus soal">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Showing : <strong>{{ $data['soal']->firstItem() }}</strong> - <strong>{{ $data['soal']->lastItem() }}</strong> of
                <strong>{{ $data['soal']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['soal']->onEachSide(1)->links() }}
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
        var kategori_id = $(this).attr('data-kategoriid');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus soal ini, data yang bersangkutan dengan soal ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/soal/kategori/" + kategori_id + "/" + id,
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
                    text: 'Soal berhasil dihapus'
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


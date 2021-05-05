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

<div class="text-left">
    <a href="{{ route('soal.kategori', ['id' => $data['kategori']->mata_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list kategori"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

@if (session()->has('failures'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    gagal import data. <a href="{{ route('soal.index', ['id' => $data['kategori']->mata_id, 'kategoriId' => $data['kategori']->id]) }}"><em>Kembali ke list</em></a>
</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    @foreach ($errors->all() as $error)
        <i class="las la-thumbtack"></i> {{ $error }} <br>
    @endforeach
  </div>
@endif

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal List</h5>
        <div class="card-header-elements ml-auto">
            <button type="button" class="btn icon-btn-only-sm btn-success" title="klik untuk import soal" data-toggle="modal" data-target="#modals-import">
                <i class="las la-file-import"></i><span>Import</span>
            </button>
            <div class="btn-group float-right dropdown ml-2">
                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown"><i class="las la-plus"></i><span>Tambah</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach (config('addon.label.quiz_item_tipe') as $key => $tipe)
                    <a href="{{ route('soal.create', ['id' => $data['kategori']->mata_id, 'kategoriId' => $data['kategori']->id, 'tipe' => $key]) }}" class="dropdown-item" ><i class="las la-circle"></i><span>{{ $tipe['title'] }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('failures'))
    <div class="table-responsive table-mobile-responsive">
        <table class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Row</th>
                    <th>Attribute</th>
                    <th>Errors</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session()->get('failures') as $validation)
                <tr class="table-danger">
                    <td>{{ $validation->row() }}</td>
                    <td>{{ $validation->attribute() }}</td>
                    <td>
                        <ul>
                            @foreach ($validation->errors() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $validation->values()[$validation->row()] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="table-responsive table-mobile-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Tipe Soal</th>
                    <th style="width: 210px;">Pembuat</th>
                    <th style="width: 230px;">Tanggal Dibuat</th>
                    <th style="width: 230px;">Tanggal Diperbarui</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['soal']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i><strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! Soal tidak ditemukan !
                        @else
                        ! Soal kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['soal'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{!! Str::limit(strip_tags($item->pertanyaan), 180) !!}</td>
                    <td><span class="badge badge-{{ $item->tipe($item->tipe_jawaban)['color'] }}">{{ $item->tipe($item->tipe_jawaban)['title'] }}</span></td>
                    <td>{{ $item->creator->name }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td>
                        @if (!auth()->user()->hasRole('instruktur_internal|instruktur_mitra') || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && $item->creator_id == auth()->user()->id)
                        <a href="{{ route('soal.edit', ['id' => $item->mata_id, 'kategoriId' => $item->kategori_id, 'soalId' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit soal">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-mataid="{{ $item->mata_id }}" data-kategoriid="{{ $item->kategori_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="klik untuk menghapus soal">
                            <i class="las la-trash"></i>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengedit soal" disabled>
                            <i class="las la-pen"></i>
                        </button>
                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk menghapus soal" disabled>
                            <i class="las la-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['soal']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i><strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! Soal tidak ditemukan !
                        @else
                        ! Soal kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['soal'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Pertanyaan</div>
                                    <div class="desc-table">{!! $item->pertanyaan !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Tipe Soal</div>
                                    <div class="desc-table"><span class="badge badge-{{ $item->tipe($item->tipe_jawaban)['color'] }}">{{ $item->tipe($item->tipe_jawaban)['title'] }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Creator</div>
                                    <div class="desc-table">{{ $item->creator->name }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        @if (!auth()->user()->hasRole('instruktur_internal|instruktur_mitra') || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && $item->creator_id == auth()->user()->id)
                                        <a href="{{ route('soal.edit', ['id' => $item->mata_id, 'kategoriId' => $item->kategori_id, 'soalId' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit soal">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-mataid="{{ $item->mata_id }}" data-kategoriid="{{ $item->kategori_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="klik untuk menghapus soal">
                                            <i class="las la-trash"></i>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengedit soal" disabled>
                                            <i class="las la-pen"></i>
                                        </button>
                                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk menghapus soal" disabled>
                                            <i class="las la-trash"></i>
                                        </button>
                                        @endif
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
                Menampilkan : <strong>{{ $data['soal']->firstItem() }}</strong> - <strong>{{ $data['soal']->lastItem() }}</strong> dari
                <strong>{{ $data['soal']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['soal']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@include('backend.bank_soal.modal-import')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
$(document).ready(function () {
    $('.swal-delete').on('click', function () {
        var mata_id = $(this).attr('data-mataid');
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
                    url: "/mata/"+ mata_id +"/soal/kategori/" + kategori_id + "/" + id,
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


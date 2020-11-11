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
        <h5 class="card-header-title mt-1 mb-0">Grades Letter List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('grades.letter.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah grades letter" data-toggle="tooltip">
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
                    <th>Angka</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['letter']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Grades Letter tidak ditemukan !
                            @else
                            ! Data Grades Letter kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['letter'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->nilai_maksimum.' %' }}</td>
                    <td>{{ $item->nilai_minimum.' %' }}</td>
                    <td><strong class="badge badge-primary">{{ $item->angka }}</strong></td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        <a href="{{ route('grades.letter.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit grades letter" data-toggle="tooltip">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus grades letter" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['letter']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Grades Letter tidak ditemukan !
                            @else
                            ! Data Grades Letter kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['letter'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Nilai Maksimum</div>
                                    <div class="desc-table">{{ $item->nilai_maksimum }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nilai Minimum</div>
                                    <div class="desc-table">{{ $item->nilai_minimum }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Angka</div>
                                    <div class="desc-table"><strong class="badge badge-primary">{{ $item->angka }}</strong></div>
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
                                        <a href="{{ route('grades.letter.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit grades letter" data-toggle="tooltip">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus grades letter" data-toggle="tooltip">
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
                Menampilkan : <strong>{{ $data['letter']->firstItem() }}</strong> - <strong>{{ $data['letter']->lastItem() }}</strong> dari
                <strong>{{ $data['letter']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['letter']->onEachSide(1)->links() }}
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
            text: "Anda akan menghapus letter ini, data yang bersangkutan dengan letter ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/grades/letter/" + id,
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
                    text: 'grades letter berhasil dihapus'
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

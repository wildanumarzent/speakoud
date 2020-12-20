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
                    <select class="status custom-select form-control" name="p">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Pages List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('page.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah page">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Judul</th>
                    <th style="width: 40px;">Viewer</th>
                    <th style="width: 70px;">Status</th>
                    <th style="width: 210px;">Tanggal Dibuat</th>
                    <th style="width: 210px;">Tanggal Diperbarui</th>
                    <th style="width: 90px;">Urutan</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['pages']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('p') || Request::get('q'))
                        ! Page tidak ditemukan !
                        @else
                        ! Data Page kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['pages'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td><strong>{!! Str::limit($item->judul, 90) !!}</strong> <a href="{{ route('page.read', ['id' => $item->id, 'slug' => $item->slug]) }}" title="view website" target="_blank"><i class="las la-external-link-alt"></i></a></td>
                    <td><span class="badge badge-info">{!! $item->viewer ?? 0 !!}</span></td>
                    <td>
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->publish == 1 ? 'primary' : 'warning' }}"
                            title="Click to publish page">
                            {{ $item->publish == 1 ? 'Publish' : 'Draft' }}
                            <form action="{{ route('page.publish', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                    </td>
                    <td>{{ $item->created_at->format('d F Y (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i)') }}</td>
                    <td>
                        @php
                        $min = $item->where('parent', $item->parent)->min('urutan');
                        $max = $item->where('parent', $item->parent)->max('urutan');
                        @endphp
                        @if ($min != $item->urutan)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="klik untuk merubah urutan">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('page.position', ['id' => $item->id, 'position' => ($item->urutan - 1), 'parent' => $item->parent]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if ($max != $item->urutan)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="klik untuk merubah urutan">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('page.position', ['id' => $item->id, 'position' => ($item->urutan + 1), 'parent' => $item->parent]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('page.create', ['parent' => $item->id]) }}" class="btn icon-btn btn-sm btn-success" title="klik untuk menambah page">
                            <i class="las la-plus"></i>
                        </a>
                        <a href="{{ route('page.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit page">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus page">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @if (count($item->childs))
                    @include('backend.page.child', ['childs' => $item->childs,'level'=>1])
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Showing : <strong>{{ $data['pages']->firstItem() }}</strong> - <strong>{{ $data['pages']->lastItem() }}</strong> of
                <strong>{{ $data['pages']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['pages']->onEachSide(1)->links() }}
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
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus page ini, data yang bersangkutan dengan page ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/page/" + id,
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
                    text: 'page berhasil dihapus'
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


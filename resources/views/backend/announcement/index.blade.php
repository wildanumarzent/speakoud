@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.css') }}">
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
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Nama Pengumuman...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk filter"><i class="las la-search"></i></button>
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
        <h5 class="card-header-title mt-1 mb-0">Pengumuman List</h5>
        @role ('developer|administrator|internal')
        <div class="card-header-elements ml-auto">
            <a href="{{ route('announcement.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah artikel">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
        @endrole
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Judul</th>
                    <th>Pembuat</th>
                    {{-- <th>Attachment</th> --}}
                    <th>Status</th>
                    <th style="width: 200px;">Tanggal Dibuat</th>
                    <th style="width: 200px;">Tanggal Diperbarui</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['announcement'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td><a href="{{ route('announcement.show', ['announcement' => $item->id]) }}" target="_blank"><strong>{!! Str::limit($item->title, 90) !!}</strong> @if($item->statu != 0)<a href="{{ route('announcement.show', ['announcement' => $item->id]) }}" title="lihat pengumuman" target="_blank"><i class="las la-external-link-alt"></i></a>@endif</a></td>
                    <td >{{ $item->user->name ?? '-' }}</td>

                    {{-- <td >@if(!empty($item->attachment))<a href="{{$item->attachment}}" download>download</a>@endif</td> --}}
                    <td>
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->status == 1 ? 'primary' : 'warning' }}"
                            title="klik unutk publish/draft Pengumuman">
                            {{ config('addon.label.publish.'.$item->status) }}
                            <form action="{{ route('announcement.publish', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                    </td>
                    <td >{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td >{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    @role('peserta_mitra|peserta_internal')
                    <td>
                        <a href="{{ route('announcement.show', ['announcement' => $item->id]) }}" target="_blank" class="btn icon-btn btn-sm btn-success" title="klik untuk melihat pengumuman">
                            <i class="las la-eye"></i>
                        </a>
                    </td>
                    @else
                    <td>
                        <a href="{{ route('announcement.edit', ['announcement' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit pengumuman">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus pengumuman" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                    @endrole
                </tr>
                @empty
                <tr>
                    <td colspan="8" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Pengumuman tidak ditemukan !
                            @else
                            ! Data Pengumuman kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['announcement']->firstItem() }}</strong> - <strong>{{ $data['announcement']->lastItem() }}</strong> dari
                <strong>{{ $data['announcement']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['announcement']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus anno ini ?, Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/announcement/delete/" + id,
                        method: 'delete',
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
                        text: 'Pengumuman berhasil dihapus'
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

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
                        <option value="1" {{ Request::get('p') == '1' ? 'selected' : '' }}>PUBLISH</option>
                        <option value="0" {{ Request::get('p') == '0' ? 'selected' : '' }}>DRAFT</option>
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

<div class="d-flex justify-content-between">
    <a href="{{ route('jadwal.create') }}" class="btn btn-primary rounded-pill" title="klik untuk menambah jadwal pelatihan"><i class="las la-plus"></i>Tambah</a>
</div>
<br>

<div class="row">

    @foreach ($data['jadwal'] as $item)
    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-body d-flex justify-content-between align-items-start pb-1">
                <div>
                    <a href="javascript:;" class="text-body text-big font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!}</a>
                </div>
                <div class="btn-group project-actions dropdown">
                    <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle hide-arrow  btn-toggle-radius" data-toggle="dropdown" aria-expanded="false">
                        <i class="ion ion-ios-more"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 26px; left: 26px;">
                        <a class="dropdown-item" href="{{ route('jadwal.edit', ['id' => $item->id]) }}" title="klik untuk mengedit jadwal pelatihan">
                          <i class="las la-pen"></i> Edit
                        </a>
                        @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                        <a class="dropdown-item js-sa2-delete" href="javascript:void(0);" data-id="{{ $item->id }}" title="klik untuk menghapus jadwal pelatihan">
                          <i class="las la-trash-alt"></i> Hapus
                        </a>
                        @endif
                        <a class="dropdown-item" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} jadwal pelatihan">
                            <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> {{ $item->publish == 1 ? 'Draft' : 'Publish' }}
                            <form action="{{ route('jadwal.publish', ['id' => $item->id]) }}" method="POST">
                              @csrf
                              @method('PUT')
                            </form>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-3">
                <table class="table table-bordered mb-2">
                    <tr>
                        <th style="width:150px;">Creator</th>
                        <td>{{ $item->creator['name'] }}</td>
                    </tr>
                    <tr>
                        <th style="width:150px;">Mata Pelatihan</th>
                        <td>{{ $item->mata->judul }}</td>
                    </tr>
                    <tr>
                        <th style="width:150px;">Tanggal Mulai</th>
                        <td>{{ $item->start_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th style="width:150px;">Tanggal Selesai</th>
                        <td>{{ $item->end_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th style="width:150px;">Jam</th>
                        <td>{{ \Carbon\Carbon::parse($item->start_time)->format('H:i').' s/d '.\Carbon\Carbon::parse($item->end_time)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <th style="width:150px;">Lokasi</th>
                        <td>{{ $item->lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></td>
                    </tr>
                </table>
            </div>
            <hr class="m-0 mb-2">
            <div class="card-body pt-0">
                <div class="row">
                  <div class="col">
                    <div class="text-muted small">Created</div>
                    <div class="font-weight-bold">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                  </div>
                  <div class="col">
                    <div class="text-muted small">Updated</div>
                    <div class="font-weight-bold">{{ $item->updated_at->format('d/m/Y H:i') }}</div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

@if ($data['jadwal']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Jadwal Pelatihan tidak ditemukan !
            @else
            ! Data Jadwal Pelatihan kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['jadwal']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['jadwal']->firstItem() }}</strong> - <strong>{{ $data['jadwal']->lastItem() }}</strong> dari
                <strong>{{ $data['jadwal']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['jadwal']->onEachSide(3)->links() }}
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus jadwal pelatihan ini, data yang bersangkutan dengan jadwal pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/jadwal/" + id,
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
                        text: 'jadwal pelatihan berhasil dihapus'
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


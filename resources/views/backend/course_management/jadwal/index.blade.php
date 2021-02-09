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

@foreach ($data['jadwal'] as $item)
<div class="card">
    <div class="p-4 p-md-5 d-xl-flex justify-content-between align-items-center">
        <div class="box-pertemuan">
            <a href="javascript:;" class="text-body text-large font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!} <span class="badge badge-secondary">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></a>
            <div class="d-flex flex-wrap mt-3">
                <div class="mr-3"><i class="vacancy-tooltip las la-user text-light"></i>&nbsp; {{ $item->creator->name }}</div>
                @if (!empty($item->mata_id))
                <div class="mr-3"><i class="vacancy-tooltip las la-eye text-light"></i>&nbsp; {{ $item->mata->judul }}</div>
                @endif
                <div class="mr-3"><i class="vacancy-tooltip las la-map-pin text-light"></i>&nbsp; {{ $item->lokasi ?? '-' }}</div>
            </div>
            <hr class="">
            <div class="mt-3 mb-4">
                <div class="row">
                    <div class="col-4 col-md-4">
                        <span class="text-muted small">Tanggal Mulai :</span><br>
                        <span><strong>{{ $item->start_date->format('d F Y') }}</strong></span>
                    </div>
                    <div class="col-4 col-md-4">
                        <span class="text-muted small">Tanggal Selesai :</span><br>
                        <span><strong>{{ $item->end_date->format('d F Y') }}</strong></span>
                    </div>
                    <div class="col-4 col-md-4">
                        <span class="text-muted small">Jam :</span><br>
                        <span><strong>{{ \Carbon\Carbon::parse($item->start_time)->format('H:i').' s/d '.\Carbon\Carbon::parse($item->end_time)->format('H:i') }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-btn text-right">
            <a class="btn btn-info icon-btn-only-sm btn-sm-only" href="{{ route('jadwal.edit', ['id' => $item->id]) }}" title="klik untuk mengedit jadwal pelatihan">
                <i class="las la-pen"></i> Ubah
            </a>
            @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
            <a class="btn btn-danger icon-btn-only-sm btn-sm-only js-sa2-delete" href="javascript:void(0);" data-id="{{ $item->id }}" title="klik untuk menghapus jadwal pelatihan">
                <i class="las la-trash-alt"></i> Hapus
            </a>
            @endif
            <a class="btn btn-secondary icon-btn-only-sm btn-sm-only" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} jadwal pelatihan">
                <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> {{ $item->publish == 0 ? 'Publish' : 'Draft' }}
                <form action="{{ route('jadwal.publish', ['id' => $item->id]) }}" method="POST">
                @csrf
                @method('PUT')
                </form>
            </a>
        </div>
    </div>
</div>
@endforeach

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


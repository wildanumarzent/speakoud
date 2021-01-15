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
                    <label class="form-label">Program Pelatihan</label>
                    <select class="status custom-select form-control" name="p">
                        <option value=" " selected>Semua</option>
                        @foreach ($data['mata'] as $item)
                        <option value="{{ $item->id }}" {{ Request::get('p') == ''.$item->id.'' ? 'selected' : '' }}>{{ $item->judul }}</option>
                        @endforeach
                        <option value="0" {{ Request::get('p') == 'null' ? 'selected' : '' }}>Belum Terkait</option>
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
<a href="{{ route('kompetensi.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah kompetensi">
    <i class="las la-plus"></i><span>Tambah</span>
</a>
<hr>
                @if ($data['kompetensi']->total() == 0)
                <div class="card">
                    <div class="card-body text-center">
                        <strong style="color: red;">
                            @if (Request::get('p') || Request::get('q'))
                            ! Kompetensi tidak ditemukan !
                            @else
                            ! Data Kompetensi kosong !
                            @endif
                        </strong>
                    </div>
                </div>
                @endif

                @foreach ($data['kompetensi'] as $item)
                <div class="card mb-3">

                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body ml-4">
                                <div class="row">
                                    <div class="col-10">
                                        <span class="text-big">{{$item->judul}}</span>
                                        {{-- <span  class="rounded-pill btn-sm btn-primary ml-2">Tags</span> --}}
                                    </div>
                                    <div class="col-2">
                                        <div class="btn-group dropdown dropdown-right mr-3">
                                            <button type="button" class="btn btn-sm btn-warning borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                Aksi&nbsp;&nbsp;<i class="ion ion-ios-more"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('kompetensi.edit', ['kompetensi' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit kategori pelatihan">
                                                    <i class="las la-pen"></i><span>Ubah</span>
                                                </a>
                                                <a href="javascript:void(0);" class="dropdown-item js-sa2-delete" data-id="{{ $item->id }}" title="klik untuk menghapus kategori pelatihan">
                                                    <i class="las la-trash-alt"></i> <span>Hapus</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="my-2">
                                    {!! Str::limit($item->deskripsi,120) !!}
                                    {{-- Cras semper eu ipsum sed posuere. Fusce nec felis turpis. Aenean tellus nibh, porttitor ac neque a, tincidunt pharetra neque. Suspendisse imperdiet, tortor non fermentum fringilla, purus erat consequat sem, in efficitur felis enim nec sem. --}}

                                </div>

                                <div class="small">
                                    <a href="javascript:void(0)" class="text-muted"><i class="las la-user text-lighter text-big align-middle"></i>&nbsp; {{$item->user->name}}</a>
                                    <span class="text-muted ml-3"><i class="ion ion-md-time text-lighter text-big align-middle"></i>&nbsp; {{$item->created_at->format('Y-m-d H:i:s')}}</span>
                                    <small class="text-muted ml-3">Program Pelatihan : @forelse($data['listMata']->where('kompetensi_id',$item->id) as $list) {{$list->mata->judul}}&nbsp; @empty Belum Terkait Program Pelatihan @endforelse</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if ($data['kompetensi']->total() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6 m--valign-middle">
                                Menampilkan : <strong>{{ $data['kompetensi']->firstItem() }}</strong> - <strong>{{ $data['kompetensi']->lastItem() }}</strong> dari
                                <strong>{{ $data['kompetensi']->total() }}</strong>
                            </div>
                            <div class="col-lg-6 m--align-right">
                                {{ $data['kompetensi']->onEachSide(3)->links() }}
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
$(document).ready(function () {
    $('.js-sa2-delete').on('click', function () {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus kompetensi ini, data yang bersangkutan dengan kompetensi ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/kompetensi/" + id + "/delete",
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
                    text: 'kompetensi berhasil dihapus'
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

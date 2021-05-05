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
    <a href="{{ route('template.mata.index') }}" class="btn btn-secondary rounded-pill" title="kembali ke list program"><i class="las la-arrow-left"></i>Kembali</a>&nbsp;
    <a href="{{ route('template.materi.create', ['id' => $data['mata']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah template mata"><i class="las la-plus"></i>Tambah</a>
</div>
<br>

<div class="card mb-4">
    <ul class="list-group list-group-flush drag">

        @foreach ($data['materi'] as $item)
        <li class="list-group-item py-4" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
            <div class="media flex-wrap">
                <div class="media-body ml-sm-4">
                <h5 class="mb-2">
                    <div class="float-right dropdown ml-3">
                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('template.bahan.index', ['id' => $item->id]) }}" title="klik untuk melihat template materi">
                                <i class="las la-folder"></i> <span>Template Materi</span>
                            </a>
                            <a href="{{ route('template.materi.edit', ['id' => $item->template_mata_id, 'materiId' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit template mata">
                                <i class="las la-pen"></i><span>Ubah</span>
                            </a>
                            @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                            <a href="javascript:void(0);" data-mataid="{{ $item->template_mata_id }}" data-id="{{ $item->id }}" class="dropdown-item swal-delete" title="klik untuk menghapus template mata">
                                <i class="las la-trash-alt"></i><span>Hapus</span>
                            </a>
                            @endif
                            @if ($item->min('urutan') != $item->urutan)
                                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk menaikan posisi">
                                    <i class="las la-arrow-up"></i> <span>Naikan Posisi</span>
                                    <form action="{{ route('template.materi.position', ['id' => $item->template_mata_id, 'materiId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </a>
                            @else
                            <a href="javascript:void(0)" class="dropdown-item"><i class="las la-arrow-up"></i> <span>Naikan Posisi</span></a>
                            @endif
                            @if ($item->max('urutan') != $item->urutan)
                                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk menurunkan posisi">
                                    <i class="las la-arrow-down"></i> <span>Turunkan Posisi</span>
                                    <form action="{{ route('template.materi.position', ['id' => $item->template_mata_id, 'materiId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="dropdown-item"><i class="las la-arrow-down"></i> <span>Turunkan Posisi</span></a>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('template.bahan.index', ['id' => $item->id]) }}" class="text-body">{!! $item->judul !!}</a>&nbsp;
                </h5>
                <div class="d-flex flex-wrap align-items-center mb-2">
                    <div class="text-muted small mr-2">
                        <i class="las la-user text-primary"></i>
                        <span>{{ $item->creator->name }}</span>
                    </div>
                    <div class="text-muted small">
                        <i class="las la-clock text-primary"></i>
                        <span>{{ $item->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div>{!! Str::limit(strip_tags($item->keterangan), 120) !!}</div>
                <div class="mt-2">
                    <span class="badge badge-outline-secondary text-muted font-weight-normal">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span>
                </div>
                </div>
            </div>
        </li>
        @endforeach

    </ul>
</div>

@if ($data['materi']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! Template Mata tidak ditemukan !
            @else
            ! Template Mata kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['materi']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['materi']->firstItem() }}</strong> - <strong>{{ $data['materi']->lastItem() }}</strong> dari
                <strong>{{ $data['materi']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['materi']->onEachSide(3)->links() }}
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
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script>
    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                var id = '{{ $data['mata']->id }}';
                // console.log(data);
                $.ajax({
                    data: {'datas' : data},
                    url: '/template/mata/'+ id +'/materi/sort',
                    type: 'POST',
                    dataType:'json',
                });
                if (data) {
                    location.reload();
                }
            }
        });
        $( "#drag" ).disableSelection();
    });

    //delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var mata_id = $(this).attr('data-mataid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus template mata ini, data yang bersangkutan dengan template mata ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/template/mata/" + mata_id + "/materi/" + id,
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
                        text: 'template mata berhasil dihapus'
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

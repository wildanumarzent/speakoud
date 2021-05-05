@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
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
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Mata Lain</label>
                    <select class="jump select2 show-tick" data-mataid="{{ $data['materi']->template_mata_id }}" data-style="btn-default">
                        <option value="" selected disabled>Pilih</option>
                        @foreach ($data['materi_lain'] as $materi)
                            <option value="{{ $materi->id }}">{!! $materi->judul !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->

<div class="text-left">
    <a href="{{ route('template.materi.index', ['id' => $data['materi']->template_mata_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list mata"><i class="las la-arrow-left"></i>Kembali</a>
    <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#modals-tipe-bahan" title="klik untuk menambah materi pelatihan"><i class="las la-plus"></i>Tambah</button>
</div>
<br>

<div class="card mb-4">
    <ul class="list-group list-group-flush">

        @foreach ($data['bahan'] as $item)
        <li class="list-group-item py-4">
            <div class="media flex-wrap">
                <div class="media-body ml-sm-4">
                <h5 class="mb-2">
                    <div class="float-right dropdown ml-3">
                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if ($item->type($item)['tipe'] == 'quiz')
                            <a class="dropdown-item" href="{{ route('template.quiz.item', ['id' => $item->quiz->id]) }}" title="klik untuk melihat template soal">
                                <i class="las la-list-ol"></i> <span>Soal</span>
                            </a>
                            @endif
                            <a href="{{ route('template.bahan.edit', ['id' => $item->template_mata_id, 'bahanId' => $item->id, 'type' => $item->type($item)['tipe']]) }}" class="dropdown-item" title="klik untuk mengedit template materi">
                                <i class="las la-pen"></i><span>Ubah</span>
                            </a>
                            @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                            <a href="javascript:void(0);" data-materiid="{{ $item->template_materi_id }}" data-id="{{ $item->id }}" class="dropdown-item swal-delete" title="klik untuk menghapus template materi">
                                <i class="las la-trash-alt"></i><span>Hapus</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    <a href="javascript:;" class="text-body">{!! $item->judul !!}</a>&nbsp;
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
                <div>
                    <table class="table table-bordered mb-0" style="width: 300px;">
                        <tr>
                            <th>Tipe</th>
                            <td>
                                <i class="las la-{{ $item->type($item)['icon'] }} mr-2" style="font-size: 1.5em;"></i> <strong>{{ $item->type($item)['title'] }}</strong>
                            </td>
                        </tr>
                        @if ($item->type($item)['tipe'] == 'forum')
                        <tr>
                            <th>Topik</th>
                            <td>{{ config('addon.label.forum_tipe.'.$item->forum->tipe)['title'] }}</td>
                        </tr>
                        @endif
                        @if ($item->type($item)['tipe'] == 'dokumen')
                            <tr>
                                <th>File</th>
                                <td><i class="las la-file-{{ $item->dokumen->bankData->icon($item->dokumen->bankData->file_type) }} mr-2" style="font-size: 1.5em;"></i> {{ strtoupper($item->dokumen->bankData->file_type) }}</td>
                            </tr>
                        @endif
                        @if ($item->type($item)['tipe'] == 'conference')
                            <tr>
                                <th>Tipe Meeting</th>
                                <td>
                                    @if ($item->conference->tipe == 0)
                                        BPPT Conference
                                    @else
                                        Platform
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if ($item->type($item)['tipe'] == 'quiz')
                        <tr>
                            <th>Tipe Quiz</th>
                            <td>
                                {{ config('addon.label.quiz_kategori.'.$item->quiz->kategori) }}
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="mt-2">
                    <span class="badge badge-outline-secondary text-muted font-weight-normal">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span>
                </div>
                </div>
            </div>
        </li>
        @endforeach

    </ul>
</div>

@if ($data['bahan']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! Template Materi tidak ditemukan !
            @else
            ! Template Materi kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['bahan']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['bahan']->firstItem() }}</strong> - <strong>{{ $data['bahan']->lastItem() }}</strong> dari
                <strong>{{ $data['bahan']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['bahan']->onEachSide(3)->links() }}
            </div>
        </div>
    </div>
</div>
@endif

@include('backend.course_management.template.bahan.tipe-bahan')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2();

    $('.jump').on('change', function () {

        var mataid = $(this).attr('data-mataid');
        var id = $(this).val();

        if (id) {
            window.location = '/template/materi/'+ id +'/bahan'
        }
        return false;
    });
    //delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var materi_id = $(this).attr('data-materiid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus template bahan ini, data yang bersangkutan dengan template bahan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/template/materi/" + materi_id + "/bahan/" + id,
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
                        text: 'template bahan berhasil dihapus'
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

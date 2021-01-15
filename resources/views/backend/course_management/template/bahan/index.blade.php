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

@foreach ($data['bahan'] as $item)
<div class="card mb-3">
    <div class="card-body">
        <div class="media align-items-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="text-xlarge font-weight-bolder line-height-1 my-2">{{ $data['number']++ }}</div>
        </div>
        <div class="media-body ml-4">
            <a href="javascript:;" class="text-big">{!! $item->judul !!}</a>
            <div class="my-2">
                <div class="row">
                    <div class="col-md-8">
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
                    <div class="col-md-4 text-right">
                        @if ($item->type($item)['tipe'] == 'quiz')
                        <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('template.quiz.item', ['id' => $item->quiz->id]) }}" title="klik untuk melihat template soal">
                            <i class="las la-list-ol"></i> Soal
                        </a>
                        @endif
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-warning btn-sm icon-btn-only-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melakukan aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('template.bahan.edit', ['id' => $item->template_mata_id, 'bahanId' => $item->id, 'type' => $item->type($item)['tipe']]) }}" class="dropdown-item" title="klik untuk mengedit template materi">
                                    <i class="las la-pen"></i><span>Ubah</span>
                                </a>
                                @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                                <a href="javascript:void(0);" data-materiid="{{ $item->template_materi_id }}" data-id="{{ $item->id }}" class="dropdown-item js-sa2-delete" title="klik untuk menghapus template materi">
                                    <i class="las la-trash-alt"></i><span>Hapus</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="small">
                <span class="text-muted ml-3"><i class="las la-user text-lighter text-big align-middle"></i>&nbsp; {{ $item->creator->name }}</span>
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->created_at->format('d/m/Y H:i') }}</span>
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        </div>
    </div>
</div>
@endforeach

@if ($data['bahan']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('q'))
            ! Template Mata tidak ditemukan !
            @else
            ! Template Mata kosong !
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
        $('.js-sa2-delete').on('click', function () {
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

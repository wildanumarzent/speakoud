@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
@include('backend.course_management.breadcrumbs')

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
    @role ('instruktur_internal|instruktur_mitra')
    <a href="{{ route('course.detail', ['id' => $data['materi']->mata_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke detail course"><i class="las la-arrow-left"></i>Kembali</a>
    @else
    <a href="{{ route('materi.index', ['id' => $data['materi']->mata_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list mata"><i class="las la-arrow-left"></i>Kembali</a>
    @endrole
    <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#modals-tipe-bahan" title="klik untuk menambah materi pelatihan"><i class="las la-plus"></i>Tambah</button>
</div>
<br>

<div class="drag">

    @foreach ($data['bahan'] as $item)
    <div class="card mb-3" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
        <div class="card-body">
            <div class="media align-items-center">
              <div class="d-flex flex-column justify-content-center align-items-center">
                @if ($item->min('urutan') != $item->urutan)
                    <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menaikan posisi">
                        <i class="ion ion-ios-arrow-up"></i>
                        <form action="{{ route('bahan.position', ['id' => $item->materi_id, 'bahanId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                @else
                <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-up"></i></a>
                @endif
                <div class="text-xlarge font-weight-bolder line-height-1 my-2">{{ $data['number']++ }}</div>
                @if ($item->max('urutan') != $item->urutan)
                    <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menurunkan posisi">
                        <i class="ion ion-ios-arrow-down"></i>
                        <form action="{{ route('bahan.position', ['id' => $item->materi_id, 'bahanId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                @else
                    <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-down"></i></a>
                @endif
              </div>
              <div class="media-body ml-4">
                <a href="{{ route('course.bahan', ['id' => $item->mata_id, 'bahanId' => $item->id, 'tipe' => $item->type($item)['tipe']]) }}" class="text-big">{!! $item->judul !!} <span class="badge badge-secondary">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span></a>
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
                                            speakoud Conference
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
                            <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('quiz.item', ['id' => $item->quiz->id]) }}" title="klik untuk melihat soal">
                                <i class="las la-list-ol"></i> <span>Soal</span>
                            </a>
                            @endif
                            <a class="btn btn-primary btn-sm icon-btn-only-sm" href="{{ route('course.bahan', ['id' => $item->mata_id, 'bahanId' => $item->id, 'tipe' => $item->type($item)['tipe']]) }}" title="klik untuk melihat preview">
                                <span>Detail</span> <i class="las la-external-link-alt ml-1"></i>
                            </a>
                            @if (auth()->user()->hasRole('developer|administrator|instruktur_internal') || $item->creator_id == auth()->user()->id)
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-warning btn-sm icon-btn-only-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melakukan aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('bahan.edit', ['id' => $item->materi_id, 'bahanId' => $item->id, 'type' => $item->type($item)['tipe']]) }}" class="dropdown-item" title="klik untuk mengedit materi pelatihan">
                                        <i class="las la-pen"></i><span>Ubah</span>
                                    </a>
                                    <a href="javascript:void(0);" data-materiid="{{ $item->materi_id }}" data-id="{{ $item->id }}" class="dropdown-item js-sa2-delete" title="klik untuk menghapus materi pelatihan">
                                        <i class="las la-trash-alt"></i><span>Hapus</span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} materi pelatihan">
                                        <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> <span>{{ $item->publish == 0 ? 'Publish' : 'Draft' }}</span>
                                        <form action="{{ route('bahan.publish', ['id' => $item->materi_id, 'bahanId' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    </a>
                                </div>
                            </div>
                            @endif
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

</div>

@if ($data['bahan']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Materi Pelatihan tidak ditemukan !
            @else
            ! Materi Pelatihan kosong !
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
@include('backend.course_management.bahan.tipe-bahan')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
<script>
    $('.select2').select2();

    $('.jump').on('change', function () {

        var mataid = $(this).attr('data-mataid');
        var id = $(this).val();

        if (id) {
            window.location = '/materi/'+ id +'/bahan'
        }
        return false;
    });

    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                var id = '{{ $data['materi']->id }}';
                // console.log(data);
                $.ajax({
                    data: {'datas' : data},
                    url: '/materi/'+ id +'/bahan/sort',
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
        $('.js-sa2-delete').on('click', function () {
            var materi_id = $(this).attr('data-materiid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus materi pelatihan ini, data yang bersangkutan dengan materi pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/materi/" + materi_id + '/bahan/' + id,
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
                        text: 'materi pelatihan berhasil dihapus'
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

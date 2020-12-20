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
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.quiz_item_tipe') as $key => $tipe)
                        <option value="{{ $key }}" {{ Request::get('t') == ''.$key.'' ? 'selected' : '' }}>{{ $tipe['title'] }}</option>
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
    <a href="{{ route('bahan.index', ['id' => $data['quiz']->materi_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list materi"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

@if ($data['quiz']->trackItem()->count() > 0)
<div class="alert alert-warning alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    <i class="las la-exclamation"></i> Tidak dapat <strong>menambah, mengedit / menghapuas soal</strong> dikarenakan sudah ada peserta yang mengerjakan!
  </div>
@endif

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('soal.kategori', ['id' => $data['quiz']->mata_id]) }}" class="btn btn-success icon-btn-only-sm" title="manage soal">
                <i class="las la-spell-check"></i><span>Bank Soal</span>
            </a>
            @if ($data['quiz']->trackItem()->count() == 0)
            <button type="button" class="btn btn-primary icon-btn-only-sm" data-toggle="modal" data-target="#modals-soal" title="pilih soal dari bank data">
                <i class="las la-list-alt"></i><span>Pilih Soal</span>
            </button>
            @endif
            {{-- <div class="btn-group float-right dropdown ml-2">
                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown"><i class="las la-plus"></i><span>Tambah</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach (config('addon.label.quiz_item_tipe') as $key => $tipe)
                    <a href="{{ route('quiz.item.create', ['id' => $data['quiz']->id, 'tipe' => $key]) }}" class="dropdown-item" ><i class="las la-circle"></i><span>{{ $tipe['title'] }}</span></a>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Tipe Soal</th>
                    <th style="width: 200px;">Creator</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['quiz_item']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('t') || Request::get('q'))
                            ! Soal tidak ditemukan !
                            @else
                            ! Data Soal kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['quiz_item'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{!! Str::limit(strip_tags($item->pertanyaan), 180) !!}</td>
                    <td><span class="badge badge-outline-primary">{{ config('addon.label.quiz_item_tipe.'.$item->tipe_jawaban)['title'] }}</span></td>
                    <td>{{ $item->creator['name'] }}</td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        @if ($data['quiz']->trackItem()->count() == 0)
                        <a href="{{ route('quiz.item.edit', ['id' => $item->quiz_id, 'itemId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit soal" data-toggle="tooltip">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-quizid="{{ $item->quiz_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus soal" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengedit soal" disabled>
                            <i class="las la-pen"></i>
                        </button>
                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk menghapus soal" disabled>
                            <i class="las la-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['quiz_item']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('t') || Request::get('q'))
                            ! Soal tidak ditemukan !
                            @else
                            ! Data Soal kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['quiz_item'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Pertanyaan</div>
                                    <div class="desc-table">{!! Str::limit(strip_tags($item->pertanyaan), 180) !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Tipe Soal</div>
                                    <div class="desc-table"><span class="badge badge-outline-primary">{{ config('addon.label.quiz_item_tipe.'.$item->tipe_jawaban)['title'] }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Creator</div>
                                    <div class="desc-table">{{ $item->creator['name'] }}</div>
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
                                        @if ($data['quiz']->trackItem()->count() == 0)
                                        <a href="{{ route('quiz.item.edit', ['id' => $item->quiz_id, 'itemId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit soal" data-toggle="tooltip">
                                                <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-quizid="{{ $item->quiz_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus soal" data-toggle="tooltip">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengedit soal" disabled>
                                            <i class="las la-pen"></i>
                                        </button>
                                        <button type="button" class="btn icon-btn btn-sm btn-secondary" title="klik untuk menghapus soal" disabled>
                                            <i class="las la-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['quiz_item']->firstItem() }}</strong> - <strong>{{ $data['quiz_item']->lastItem() }}</strong> dari
                <strong>{{ $data['quiz_item']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['quiz_item']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.course_management.bahan.quiz.modal-soal')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var quiz_id = $(this).attr('data-quizid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus soal ini, data yang bersangkutan dengan soal ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/quiz/" + quiz_id + '/item/' + id,
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
                        text: 'soal berhasil dihapus'
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

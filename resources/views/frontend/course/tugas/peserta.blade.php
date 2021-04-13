@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/projects.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['tugas']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['tugas']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['tugas']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['tugas']->bahan->judul !!}</strong>
      </div>
    </div>
</div>

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
        </div>
    </div>
</div>
<div class="text-left">
    <a href="{{ route('course.bahan', ['id' => $data['tugas']->mata_id, 'bahanId' => $data['tugas']->bahan_id,  'tipe' => 'tugas']) }}" class="btn btn-secondary rounded-pill" title="kembali ke tugas"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>
<!-- / Filters -->
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Peserta List</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Tanggal Pengumpulan</th>
                    @if ($data['tugas']->approval == 1)
                    <th>Status</th>
                    <th>Tanggal Approve</th>
                    <th>Di Approve Oleh</th>
                    <th style="width: 115px;">Approval</th>
                    @endif
                    <th>Komentar</th>
                    <th style="width: 110px;">Nilai</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="9" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('q'))
                        ! Peserta tidak ditemukan !
                        @else
                        ! Data Peserta kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->user->peserta->nip }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    @if ($data['tugas']->approval == 1)
                    <td>
                        @if ($item->approval == '0')
                            <span class="badge badge-danger">Di Tolak</span>
                        @elseif ($item->approval == '1')
                            <span class="badge badge-success">Di Approve</span>
                        @else
                            <span class="badge badge-secondary">Belum di Approve</span>
                        @endif
                    </td>
                    <td>{{ !empty($item->approval_time) ? $item->approval_time->format('d F Y H:i') : '-' }}</td>
                    <td>{{ !empty($item->approval_by) ? $item->approvedBy->name : '-' }}</td>
                    <td>
                        @if ($data['tugas']->approval == 1 && $item->approval >= '0')
                        <a href="javascript:void(0);" class="btn icon-btn btn-secondary btn-sm" title="klik untuk approve" disabled>
                            <i class="las la-check"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn icon-btn btn-secondary btn-sm" title="klik untuk tolak" disabled>
                            <i class="las la-times"></i>
                        </a>
                        @else
                        <a href="javascript:void(0);" class="btn icon-btn btn-success btn-sm approve" title="klik untuk approve">
                            <i class="las la-check"></i>
                            <form action="{{ route('tugas.approval', ['id' => $item->tugas_id, 'responId' => $item->id, 'status' => 1]) }}" method="POST" class="form-approve">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        <a href="javascript:void(0);" class="btn icon-btn btn-danger btn-sm tolak" title="klik untuk tolak">
                            <i class="las la-times"></i>
                            <form action="{{ route('tugas.approval', ['id' => $item->tugas_id, 'responId' => $item->id, 'status' => 0]) }}" method="POST" class="form-tolak">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @endif
                    </td>
                    @endif
                    <td>
                        {!! $item->komentar ?? '-' !!}
                    </td>
                    <td>
                        <span class="badge badge-success">{{ $item->nilai }}</span>
                        <button type="button" class="btn btn-primary icon-btn btn-sm modals-nilai" data-toggle="modal" data-target="#modals-nilai-form-{{ $item->id }}" title="klik untuk memberikan nilai"
                            data-id="{{ $item->id }}",
                            data-tugasid="{{ $item->tugas_id }}"
                            data-nilai="{{ $item->nilai }}"
                        >
                            <i class="las la-pen-alt"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modals-dokumen-{{ $item->id }}" title="klik untuk melihat tugas">
                            <i class="las la-file"></i> <span>Dokumen</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['peserta']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('frontend.course.tugas.modal-nilai')
@include('frontend.course.tugas.dokumen')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection
@section('jsbody')
<script>
    $('.approve').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin akan approve tugas ini ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Approve!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
        if (result.value) {
            $(".form-approve").submit();
        }
        })
    });

    $('.tolak').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin akan tolak tugas ini ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
        if (result.value) {
            $(".form-tolak").submit();
        }
        })
    });

    //modal
    // $('.modals-nilai').click(function() {
    //     var id = $(this).data('id');
    //     var tugas_id = $(this).data('tugasid');
    //     var nilai = $(this).data('nilai');
    //     var url = '/tugas/'+ tugas_id +'/penilaian/'+ id;

    //     $(".modal-dialog #form-nilai").attr('action', url);
    //     $('.modal-body #nilai').val(nilai);
    // });

    $(document).ready(function () {
        $('input[type=number][max]:not([max=""])').on('input', function(ev) {
            var $this = $(this);
            var maxlength = $this.attr('max').length;
            var value = $this.val();
            if (value && value.length >= maxlength) {
                $this.val(value.substr(0, maxlength));
            }
        });
    });
</script>
@include('includes.tiny-mce')
@include('components.toastr')
@endsection


@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['quiz']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['quiz']->bahan->judul !!}</strong>
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
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="s">
                        <option value=" " selected>Semua</option>
                        <option value="1" {{ Request::get('s') == '1' ? 'selected' : '' }}>Sedang Mengerjakan</option>
                        <option value="2" {{ Request::get('s') == '2' ? 'selected' : '' }}>Sudah Selesai</option>
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
<div class="text-left">
    <a href="{{ route('course.bahan', ['id' => $data['quiz']->mata_id, 'bahanId' => $data['quiz']->bahan_id,  'tipe' => 'quiz']) }}" class="btn btn-secondary rounded-pill" title="kembali ke quiz"><i class="las la-arrow-left"></i>Kembali</a>
    <a href="{{route('quiz.export.jawaban',['id' => $data['quiz']->id])}}" class="btn btn-success rounded-pill"><i class="las la-download"></i>Export</a>
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
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi Pengerjaan</th>
                    <th>Status</th>
                    <th>Soal Diisi</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="9" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('s') || Request::get('q'))
                        ! Peserta tidak ditemukan !
                        @else
                        ! Data Peserta kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                @php
                    if (!empty($item->end_time)) {
                        $start = $item->start_time;
                        $end = $item->end_time;
                        $totalDuration = $end->diffInSeconds($start);
                        $menit = gmdate('i', $totalDuration);
                        $detik = gmdate('s', $totalDuration);
                        $duration = $menit.' Menit '.$detik.' Detik';
                    } else {
                        $duration = '-';
                    }
                @endphp
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->user->peserta->nip }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ !empty($item->start_time) ? $item->start_time->format('l, j F Y H:i A') : '-' }}</td>
                    <td>{{ !empty($item->end_time) ? $item->end_time->format('l, j F Y H:i A') : '-' }}</td>
                    <td>{{ $duration }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge badge-warning">Sedang Mengerjakan</span>
                        @else
                            <span class="badge badge-success">Sudah Selesai</span>
                        @endif
                    </td>
                    <td class="text-center"><strong>{{ $item->quiz->trackItem()->where('user_id', $item->user_id)->count() }}</strong></td>
                    <td>
                        @if ($item->cek == 0)
                        <a href="javascript:;" class="btn btn-success icon-btn btn-sm peserta" title="Klik untuk mengkonfirmasi jawaban peserta">
                            <i class="las la-check"></i>
                            <form action="{{ route('quiz.peserta.cek', ['id' => $item->id])}}" method="POST" id="form-peserta">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn btn-secondary icon-btn btn-sm" disabled><i class="las la-check"></i></button>
                        @endif
                        <a href="{{ route('quiz.peserta.jawaban', ['id' => $item->quiz_id, 'pesertaId' => $item->user_id]) }}" class="btn btn-info icon-btn btn-sm" title="Klik untuk melihat jawaban peserta">
                            <i class="las la-eye"></i>
                        </a>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //peserta
    $('.peserta').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin sudah cek semua jawaban peserta ini ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: "Tidak, belum",
        }).then((result) => {
        if (result.value) {
            $("#form-peserta").submit();
        }
        })
    });
</script>
@include('components.toastr')
@endsection


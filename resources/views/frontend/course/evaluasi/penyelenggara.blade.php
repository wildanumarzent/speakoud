@extends('layouts.backend.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['mata']->program->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['mata']->judul !!}</strong>
      </div>
    </div>
</div>

<div class="text-left">
    <a href="{{ route('course.detail', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke detail course"><i class="las la-arrow-left"></i>Kembali</a>
</div>

<div class="card mb-4 mt-4">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Evaluasi Penyelenggara Diklat</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-body">
        <div class="card-datatable table-responsive d-flex justify-content-center mb-2">
            <table class="table table-striped table-bordered mb-0" style="width:50%;">
                <tr>
                    <th style="width: 150px;">Nama</th>
                    <td>{!! $data['preview']->nama !!}</td>
                </tr>
                <tr>
                    <th style="width: 150px;">Tanggal Mulai</th>
                    <td>{{ $data['preview']->waktu_mulai }}</td>
                </tr>
                <tr>
                    <th style="width: 150px;">Tanggal Selesai</th>
                    <td>{{ $data['preview']->waktu_selesai }}</td>
                </tr>
                <tr>
                    <th style="width: 150px;">Durasi</th>
                    <td>
                        @if (!empty($data['preview']->lama_jawab))
                        <span class="badge badge-primary"><i class="las la-clock"></i> {{ $data['preview']->lama_jawab.' Menit' }}</span>
                        @else
                        Tidak ada durasi
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width: 150px;">Jumlah Pertanyaan</th>
                    <td>{{ count($data['preview']->instrumen) }} Soal</td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        @role ('peserta_internal|peserta_mitra')
                        @if (!empty($data['apiUser']) && $data['apiUser']->is_complete == 1)
                        Anda telah menyelesaikan evaluasi ini
                        @else
                        <a href="{{ route('evaluasi.penyelenggara.form', ['id' => $data['mata']->id]) }}" class="btn btn-primary btn-block mt-2"><i class="las la-play-circle"></i> Mulai</a>
                        @endif
                        @else
                        <a href="{{ route('evaluasi.penyelenggara.rekap', ['id' => $data['mata']->id]) }}" class="btn btn-primary btn-block mt-2"><i class="las la-calendar"></i> Rekap</a>
                        @endrole
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

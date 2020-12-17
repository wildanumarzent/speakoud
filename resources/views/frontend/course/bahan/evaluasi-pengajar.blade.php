@extends('frontend.course.bahan')

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
        <tr>
            <th style="width: 150px;">Nama Instruktur</th>
            <td>{{ $data['bahan']->evaluasiPengajar->mataInstruktur->instruktur->user->name }}</td>
        </tr>
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
        @if (auth()->user()->hasRole('peserta_internal|peserta_mitra'))
        <tr>
            <th colspan="2" class="text-center">
                @if (!empty($data['apiUser']) && $data['apiUser']->is_complete == 1)
                    Anda telah menyelesaikan evaluasi ini
                @else
                    <a href="{{ route('evaluasi.pengajar.form', ['id' => $data['bahan']->mata_id, 'bahanId' => $data['bahan']->id]) }}" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
                @endif
            </th>
        </tr>
        @else
        <tr>
            <th colspan="2">
                <a href="{{ route('evaluasi.pengajar.rekap', ['id' => $data['bahan']->mata_id, 'bahanId' => $data['bahan']->id]) }}" class="btn btn-primary btn-block"><i class="las la-calendar"></i> Rekap</a>
            </th>
        </tr>
        @endif
    </table>
</div>
@endsection

@extends('frontend.course.bahan')

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
        <tr>
            <th style="width: 150px;">Nama Instruktur</th>
            <td>{{ $data['bahan']->evaluasiPengajar->mataInstruktur->instruktur->user->name }}</td>
        </tr>
        <tr>
            <th style="width: 150px;">Judul</th>
            <td>{{ $data['preview']->nama }}</td>
        </tr>
        <tr>
            <th style="width: 150px;">Kode Evaluasi</th>
            <td>{{ $data['preview']->kode }}</td>
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
            <th style="width: 150px;">Waktu Pengerjaan</th>
            <td>{{ $data['preview']->lama_jawab }} Menit</td>
        </tr>
        <tr>
            <th style="width: 150px;">Jumlah Soal</th>
            <td>{{ count($data['preview']->instrumen) }} Soal</td>
        </tr>
        @if (auth()->user()->hasRole('peserta_internal|peserta_mitra'))
        <tr>
            <th colspan="2">
                <a href="{{ route('evaluasi.pengajar.form', ['id' => $data['bahan']->mata_id, 'bahanId' => $data['bahan']->id]) }}" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
            </th>
        </tr>
        @else
        <tr>
            <th style="width: 150px;">Peserta</th>
            <td>
                <a href="" class="btn btn-info btn-sm"><i class="las la-users"></i> Lihat</a>
            </td>
        </tr>
        @endif
    </table>
</div>
@endsection

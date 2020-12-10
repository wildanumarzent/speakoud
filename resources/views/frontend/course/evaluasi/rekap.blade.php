@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<style>
  .custom-control-label::before {
    border : rgba(24,28,33,0.3) solid 1px;
  }
  .hidden {
    display: none;
  }
</style>
@endsection

@section('content')
<div class="text-left">
    <a href="{{ route('course.detail', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke tugas"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0"><i class="las la-edit"></i> {{ $data['result']->evaluasi->nama }}</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-body">
        <h5 class="text-center">
            {{ $data['result']->evaluasi->instruksi_umum }}
        </h5>
        <h6 class="text-center text-muted">
            {{ $data['result']->evaluasi->instruksi_khusus }}
        </h6>

        @foreach ($data['result']->result_detail as $key => $soal)
            @php
                $json = json_encode($soal);
                $output = json_decode($json, true);
            @endphp
            <div class="card-body mb-2" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                <div class="form-group">
                    <span class="text-muted mb-2 d-inline-block">Kelompok Soal : {{ $soal->kelompok_soal }}</span>
                    <h5>{!! $soal->Pertanyaan !!}</h5>
                    <hr style="border-color: #d1a340;">
                    <span class="text-muted mb-2 d-inline-block">Rekap Jawaban :</span>
                    <table class="table table-bordered mb-2" style="width: 400px;">
                        <tr>
                            <th>Tidak Baik</th>
                            <td>{{ $output['Tidak Baik'] }}</td>
                        </tr>
                        <tr>
                            <th>Kurang Baik</th>
                            <td>{{ $output['Kurang Baik'] }}</td>
                        </tr>
                        <tr>
                            <th>Cukup</th>
                            <td>{{ $output['Cukup'] }}</td>
                        </tr>
                        <tr>
                            <th>Baik</th>
                            <td>{{ $output['Baik'] }}</td>
                        </tr>
                        <tr>
                            <th>Sangat Baik</th>
                            <td>{{ $output['Sangat Baik'] }}</td>
                        </tr>
                    </table>
                    <table class="table table-bordered mb-2" style="width: 400px;">
                        <thead>
                            <tr>
                                <th>Total Nilai</th>
                                <th>Jumlah Peserta</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $output['Total Nilai'] }}</td>
                                <td>{{ $output['Jumlah Peserta'] }}</td>
                                <td><strong>{{ $output['Skor'] }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        @foreach ($data['result']->result_essai as $key => $essai)
        <div class="card-body mb-2" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
            <div class="form-group">
                <span class="text-muted mb-2 d-inline-block">Kelompok Soal : {{ $essai->kelompok_soal }}</span>
                <h5>{!! $essai->Pertanyaan !!}</h5>
                <hr style="border-color: #d1a340;">
                <span class="text-muted mb-2 d-inline-block">Rekap Jawaban :</span>
                <table class="table table-bordered mb-2" style="width: 600px;">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Kode Peserta</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($essai->jawabans as $item)
                        <tr>
                            <td>{{ $item->kode_peserta }}</td>
                            <td>{{ $item->jawab }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

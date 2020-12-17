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
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['mata']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['mata']->judul !!} <i class="las la-arrow-right"></i>
        <strong>Rekap</strong>
      </div>
    </div>
</div>

<div class="text-left">
    <a href="{{ route('evaluasi.penyelenggara', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke evaluasi"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="row">
    @foreach ($data['result']->result_detail as $key => $soal)
    @php
        $json = json_encode($soal);
        $output = json_decode($json, true);
    @endphp
        <div class="col-sm-6 col-xl-4">

            <div class="card card-list mb-4">
                <div class="card-body d-flex justify-content-between align-items-start pb-2">
                    <div>
                        <a href="javascript:void(0)" class="text-body text-big font-weight-semibold">{{ ($key+1) }}. {!! $soal->Pertanyaan !!}</a>
                        <div class="text-muted small mt-1">Kelompok Soal : {{ $soal->kelompok_soal }}</div>
                    </div>
                </div>
                <div class="card-body pb-3">
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

        </div>
    @endforeach
</div>
<div class="row">
    @foreach ($data['result']->result_essai as $key => $essai)
    <div class="col-sm-12 col-xl-12">
        <div class="card card-list mb-4">
            <div class="card-body d-flex justify-content-between align-items-start pb-2">
                <div>
                    <a href="javascript:void(0)" class="text-body text-big font-weight-semibold">{!! $soal->Pertanyaan !!}</a>
                    <div class="text-muted small mt-1">Kelompok Soal : {{ $soal->kelompok_soal }}</div>
                </div>
            </div>
            <div class="card-body pb-3">
                <table class="table table-bordered mb-2">
                    <thead>
                        <tr>
                            <th>Kode Peserta</th>
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
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

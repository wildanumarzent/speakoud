@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/users.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="text-left">
    <a href="{{ route('quiz.item', ['id' => $data['quiz']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke soal"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal yang akan ditampilkan di peserta {{ $data['quiz']->soal_acak == 1 ? '(ACAK)' : '' }}</h5>
    </div>
    <div class="card-body">
        {{-- <h6 class="text-center text-muted">
            Persentase Nilai : <span class="badge badge-primary">{{ round(($data['item']->where('benar', 1)->count() / $data['item']->count()) * 100) }}</span>
        </h6> --}}
        @foreach ($data['soal'] as $item)
        <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
            <div class="form-group">
                <span class="text-muted mb-2 d-inline-block">Soal <strong>No. {{ $loop->iteration }}</strong> :</span>
                <h5>{!! $item->pertanyaan !!}</h5>
                <hr style="border-color: #d1a340;">
                <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                @if ($item->tipe_jawaban == 0)
                    @foreach ($item->pilihan as $key => $value)
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" {{ $item->jawaban == $key ? 'checked' : '' }} disabled>
                        <span class="custom-control-label" {!! $item->jawaban == $key ? 'style="color: green;"' : '' !!}>{{ $value }} {!! $item->jawaban == $key ? '<i class="las la-check"></i>' : '' !!}</span> 
                    </label>
                    <br>
                    @endforeach
                @elseif ($item->tipe_jawaban == 1)
                    <br><strong>JAWABAN : </strong>
                    @foreach ($jawaban as $jwb)
                    <span class="badge badge-success">{{ $jwb }}</span>
                    @endforeach
                @elseif ($item->tipe_jawaban == 3)
                    @foreach (config('addon.label.quiz_item_tipe')[3]['choice'] as $keyT => $valT)
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" {{ $item->jawaban == $keyT ? 'checked' : '' }} disabled>
                        <span class="custom-control-label" {!! $item->jawaban == $keyT ? 'style="color: green;"' : '' !!}>{{ $valT }} {!! $item->jawaban == $keyT ? '<i class="las la-check"></i>' : '' !!}</span>
                    </label>
                    &nbsp;
                    @endforeach
                @else
                <div class="position-relative">
                    <textarea class="form-control" readonly></textarea>
                </div>
                @endif
            </div>
        </div>
        <br>
        @endforeach
        @if ($data['soal']->count() == 0)
        <div class="d-flex justify-content-center" style="color: red;">
            <h5>! Belum ada soal !</h5>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection
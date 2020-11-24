@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/users.css') }}">
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

<div class="media align-items-center py-3 mb-3">
    <img src="{{ $data['peserta']->user->getPhoto($data['peserta']->user->photo['filename']) }}" alt="" class="d-block ui-w-100 rounded-circle">
    <div class="media-body ml-4">
      <h4 class="font-weight-bold mb-0">{{ $data['peserta']->user->name }} <span class="text-muted font-weight-normal">{{ $data['peserta']->user->email }}</span></h4>
      <div class="text-muted mb-2">ID: {{ $data['peserta']->user->id }}</div>
      <a href="{{ route('quiz.peserta', ['id' => $data['quiz']->id]) }}" class="btn btn-default btn-sm"><i class="las la-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal yang sudah diisi</h5>
    </div>
    <div class="card-body">
        @foreach ($data['item'] as $item)
        <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
            <div class="form-group">
                <span class="text-muted mb-2 d-inline-block">Soal <strong>No. {{ $item->posisi }}</strong> :</span>
                <h5>{!! $item->item->pertanyaan !!}</h5>
                <hr style="border-color: #d1a340;">
                <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                @if ($item->item->tipe_jawaban == 0)
                    @foreach ($item->item->pilihan as $key => $value)
                    @php
                        if ($item->jawaban == $item->item->jawaban && $item->jawaban == $key) {
                            $color = 'green';
                            $icon = 'las la-check';
                        } elseif ($item->jawaban != $item->item->jawaban && $item->jawaban == $key) {
                            $color = 'red';
                            $icon = 'las la-times';
                        } else {
                            $color = '';
                            $icon = '';
                        }
                    @endphp
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" {{ $item->jawaban == $key ? 'checked' : '' }} disabled disabled>
                        <span class="custom-control-label" style="color: {{ $item->item->jawaban == $key ? 'green' : $color }}">{{ $value }} <i class="{{ $item->item->jawaban == $key ? 'las la-check' : $icon }}"></i></span>
                    </label>
                    <br>
                    @endforeach
                @elseif ($item->item->tipe_jawaban == 1)
                    @php
                        $jawaban = array_map('strtolower', $item->item->jawaban);
                    @endphp
                    <div class="input-group">
                        <input type="text" class="form-control @if (in_array(strtolower(str_replace(' ', '', $item->jawaban)), str_replace(' ', '', $jawaban), true) == true) is-valid @else is-invalid @endif" value="{{ $item->jawaban }}" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="@if (in_array(strtolower(str_replace(' ', '', $item->jawaban)), str_replace(' ', '', $jawaban), true) == true) las la-check @else las la-times @endif"></i></span>
                        </div>
                    </div>
                    <br><strong>JAWABAN : </strong>
                    @foreach ($jawaban as $jwb)
                    <span class="badge badge-success">{{ $jwb }}</span>
                    @endforeach
                @else
                <div class="position-relative">
                    @php
                        if ($item->benar == '0') {
                            $valid = 'is-invalid';
                        } elseif ($item->benar == '1') {
                            $valid = 'is-valid';
                        } else {
                            $valid = '';
                        }
                    @endphp
                    <textarea class="form-control {{ $valid }}" readonly>{{ $item->jawaban }}</textarea>
                </div>
                <br>
                <a href="javascript:void(0);" class="btn icon-btn btn-success btn-sm" onclick="$(this).find('#form-benar').submit();" title="klik jika jawaban benar">
                    <i class="las la-check"></i>
                    <form action="{{ route('quiz.item.essay', ['id' => $item->id, 'status' => 1]) }}" method="POST" id="form-benar">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
                <a href="javascript:void(0);" class="btn icon-btn btn-danger btn-sm" onclick="$(this).find('#form-salah').submit();" title="klik jika jawaban salah">
                    <i class="las la-times"></i>
                    <form action="{{ route('quiz.item.essay', ['id' => $item->id, 'status' => 0]) }}" method="POST" id="form-salah">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
                @endif
            </div>
        </div>
        <br>
        @endforeach
        @if ($data['item']->count() == 0)
        <div class="d-flex justify-content-center" style="color: red;">
            <h5>! Belum mengisi soal !</h5>
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

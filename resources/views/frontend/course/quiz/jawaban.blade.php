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
      @role ('peserta_internal|peserta_mitra')
      <a href="{{ route('course.bahan', ['id' => $data['quiz']->mata_id, 'bahanId' => $data['quiz']->bahan_id, 'tipe' => 'quiz']) }}" class="btn btn-default btn-sm"><i class="las la-arrow-left"></i> Kembali</a>
      @else
      <a href="{{ route('quiz.peserta', ['id' => $data['quiz']->id]) }}" class="btn btn-default btn-sm"><i class="las la-arrow-left"></i> Kembali</a>
      @endrole
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5" style="text-align:center;">
                        PRESENTASE NILAI : <span class="badge badge-primary" style="font-size: 15px;">{{ round(($data['item']->where('benar', 1)->count() / $data['item']->count()) * 100) }}</span>
                    </th>
                </tr>
                <tr style="text-align:center;">
                    <th rowspan="2">Jumlah Soal</th>
                    <th rowspan="2">Soal Diisi</th>
                    <th rowspan="2">Jawaban Benar</th>
                    <th rowspan="2">Jawaban Salah</th>
                    <th rowspan="2">Jawaban Belum dicek</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td><span class="badge badge-secondary">{{ $data['quiz']->item()->count() }}</span></td>
                    <td><span class="badge badge-secondary">{{ $data['item']->count() }}</span></td>
                    <td><span class="badge badge-success">{{ $data['item']->where('benar', 1)->count() }}</span></td>
                    <td><span class="badge badge-danger">{{ $data['item']->where('benar', 0)->count() }}</span></td>
                    <td><span class="badge badge-warning">{{ $data['item']->whereNull('benar')->count() }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal yang sudah diisi</h5>
    </div>
    <div class="card-body">
        {{-- <h6 class="text-center text-muted">
            Persentase Nilai : <span class="badge badge-primary">{{ round(($data['item']->where('benar', 1)->count() / $data['item']->count()) * 100) }}</span>
        </h6> --}}
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
                        <input type="radio" class="custom-control-input" {{ $item->jawaban == $key ? 'checked' : '' }} disabled>
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
                @elseif ($item->item->tipe_jawaban == 3)
                @foreach (config('addon.label.quiz_item_tipe')[3]['choice'] as $keyT => $valT)
                @php
                    if ($item->jawaban == $item->item->jawaban && $item->jawaban == $keyT) {
                        $color = 'green';
                        $icon = 'las la-check';
                    } elseif ($item->jawaban != $item->item->jawaban && $item->jawaban == $keyT) {
                        $color = 'red';
                        $icon = 'las la-times';
                    } else {
                        $color = '';
                        $icon = '';
                    }
                @endphp
                <label class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" {{ $item->jawaban == $keyT ? 'checked' : '' }} disabled>
                    <span class="custom-control-label" style="color: {{ $item->item->jawaban == $keyT ? 'green' : $color }}">{{ $valT }} <i class="{{ $item->item->jawaban == $keyT ? 'las la-check' : $icon }}"></i></span>
                </label>
                &nbsp;
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

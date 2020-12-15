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
    <a href="{{ route('course.bahan', ['id' => $data['mata']->id, 'bahanId' => $data['bahan']->id, 'tipe' => 'evaluasi-pengajar']) }}" class="btn btn-secondary rounded-pill" title="kembali ke evaluasi"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0"><i class="las la-edit"></i> {{ $data['preview']->nama }}</h5>
        <div class="card-header-elements ml-auto">
            <div class="btn-group btn-group">
                <button type="button" class="btn btn-warning" id="countdown">
                    @if (empty($data['preview']->lama_jawab))
                    Tidak ada durasi
                    @endif
                </button>
            </div>
        </div>
    </div>
    <form action="{{ route('evaluasi.pengajar.submit', ['id' => $data['mata']->id, 'bahanId' => $data['bahan']->id, 'submit' => 'yes']) }}" method="POST">
        @csrf
        <div class="card-body">
            <h5 class="text-center">
                {{ $data['preview']->instruksi_umum }}
            </h5>
            <h6 class="text-center text-muted">
                {{ $data['preview']->instruksi_khusus }}
            </h6>

            @foreach ($data['preview']->instrumen as $key => $soal)
            <div class="card-body mb-2" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                <div class="form-group">
                    <span class="text-muted mb-2 d-inline-block">Soal <strong>No. {{ ($key+1) }}</strong> :</span>
                    <h5>{!! $soal->pertanyaan !!}</h5>
                    <hr style="border-color: #d1a340;">
                    <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                    <input type="hidden" name="instrumen[]" value="{{ $soal->id }}">
                    @if ($soal->tipe == 'pg')
                        @foreach ($soal->opsi as $key)
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="opsi-{{ $soal->id }}" value="{{ $key->value }}">
                            <span class="custom-control-label">{{ $key->text }}</span>
                        </label>
                        &nbsp;
                        @endforeach
                    @else
                    <textarea class="form-control" name="opsi-{{ $soal->id }}" placeholder="Masukan jawaban"></textarea>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-12 text-right">
                <a href="{{ route('course.bahan', ['id' => $data['mata']->id, 'bahanId' => $data['bahan']->id, 'tipe' => 'evaluasi-pengajar']) }}" class="btn btn-danger mr-2" title="klik untuk kembali">Kembali</a>
                <button type="submit" class="btn btn-primary finish" title="klik untuk selesai">
                    Selesai
                </button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@if (!empty($data['preview']->lama_jawab))
<script>
    var timer2 = "{{ $data['countdown'] }}";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) {

            Swal.fire({
            title: "Durasi Evaluasi sudah habis",
            text: "Klik selesai untuk mengakhiri evaluasi",
            type: "warning",
            confirmButtonText: "Selesai",
            customClass: {
                confirmButton: "btn btn-primary btn-lg"
            },
            showLoaderOnConfirm: false,
            allowOutsideClick: false,
            preConfirm: () => {
                return $.ajax({
                    url: "/course/{{ $data['mata']->id }}/bahan/{{ $data['bahan']->id }}/evaluasi/pengajar",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                }).then(response => {
                    if (!response.success) {
                        return new Error(response.message);
                    }
                    return response;
                }).catch(error => {
                    swal({
                        type: 'error',
                        text: 'Error while deleting data. Error Message: ' + error
                    })
                });
            }
            }).then(response => {
                if (response.value.success) {
                    window.location.href = '/course/{{ $data['mata']->id }}/bahan/{{ $data['bahan']->id }}/evaluasi-pengajar';
                }
            });

            clearInterval(interval);
        };

        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        $('#countdown').html('<i class="las la-clock"></i> ' + minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
    }, 1000);
</script>
@endif
@endsection

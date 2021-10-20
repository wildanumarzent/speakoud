@extends('frontend.course.roomCourse')

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
        {!! $data['quiz']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['quiz']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['quiz']->bahan->judul !!}</strong>
      </div>
    </div>
</div>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">{{ $data['quiz']->materi->judul }} : "{{ $data['quiz']->bahan->judul }}"</h5>
        <div class="card-header-elements ml-auto">
            <div class="btn-group btn-group">
                @if (!empty($data['quiz']->durasi))
                <button type="button" class="btn btn-warning" id="countdown"></button>
                @else
                <button type="button" class="btn btn-warning"><i class="las la-clock"></i> Durasi tidak ditentukan</button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (isset($data['quiz_tracker']))
            @foreach ($data['quiz_tracker'] as $key1 => $soal1)
            <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                <div class="form-group" id="soal-change-{{ $key1 }}" data-id="{{ $soal1->quiz_item_id }}">
                    <span class="text-muted mb-2 d-inline-block">Soal <strong>No. {{ ($key1+1) }}</strong> :</span>
                    <h5>{!! $soal1->item->pertanyaan !!}</h5>
                    <hr style="border-color: #d1a340;">
                    <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                    <input type="hidden" id="position-{{ $key1 }}" value="{{ $soal1->posisi }}">
                    <input type="hidden" id="type-{{ $key1 }}" value="{{ $soal1->item->tipe_jawaban }}">
                    @if ($soal1->item->tipe_jawaban == 0)
                        @foreach ($soal1->item->pilihan as $keyA => $value)
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="jawaban-{{ $key1 }}" value="{{ $keyA }}" {{ $soal1->jawaban == ''.$keyA.'' ? 'checked' : '' }}>
                            <span class="custom-control-label">{{ $value }}</span>
                        </label>
                        &nbsp;
                        @endforeach
                    @elseif ($soal1->item->tipe_jawaban == 1)
                        <input type="text" class="form-control" name="jawaban-{{ $key1 }}" value="{{ $soal1->jawaban }}" placeholder="Masukan jawaban">
                    @elseif ($soal1->item->tipe_jawaban == 3)
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="jawaban-{{ $key1 }}" value="1" {{ $soal1->jawaban == '1' ? 'checked' : '' }}>
                        <span class="custom-control-label">TRUE</span>
                    </label>
                    &nbsp;
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="jawaban-{{ $key1 }}" value="0" {{ $soal1->jawaban == '0' ? 'checked' : '' }}>
                        <span class="custom-control-label">FALSE</span>
                    </label>
                    &nbsp;
                    @else
                        <textarea class="form-control" name="jawaban-{{ $key1 }}" placeholder="Masukan jawaban">{{ $soal1->jawaban }}</textarea>
                    @endif
                </div>
            </div>
            <br>
            @endforeach
        @endif
        @if ($data['quiz']->soal_acak == 0)
            @foreach ($data['soal'] as $key2 => $soal2)
            <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                <div class="form-group" id="soal-change-{{ ($key2+count($data['quiz_tracker'])) }}" data-id="{{ $soal2->id }}">
                    <span class="text-muted mb-2 d-inline-block">Soal <strong>No. {{ ($key2+1+count($data['quiz_tracker'])) }}</strong> :</span>
                    <h5>{!! $soal2->pertanyaan !!}</h5>
                    <hr style="border-color: #d1a340;">
                    <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                    <input type="hidden" id="position-{{ ($key2+count($data['quiz_tracker'])) }}" value="{{ ($key2+1+count($data['quiz_tracker'])) }}">
                    <input type="hidden" id="type-{{ ($key2+count($data['quiz_tracker'])) }}" value="{{ $soal2->tipe_jawaban }}">
                    @if ($soal2->tipe_jawaban == 0)
                        @foreach ($soal2->shufflePilihan($soal2->pilihan) as $keyB => $value)
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="jawaban-{{ ($key2+count($data['quiz_tracker'])) }}" value="{{ $keyB }}">
                            <span class="custom-control-label">{{ $value }}</span>
                        </label>
                        &nbsp;
                        @endforeach
                    @elseif ($soal2->tipe_jawaban == 1)
                    <input type="text" class="form-control" name="jawaban-{{ ($key2+count($data['quiz_tracker'])) }}" placeholder="Masukan jawaban">
                    @elseif ($soal2->tipe_jawaban == 3)
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="jawaban-{{ ($key2+count($data['quiz_tracker'])) }}" value="1">
                        <span class="custom-control-label">TRUE</span>
                    </label>
                    &nbsp;
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="jawaban-{{ ($key2+count($data['quiz_tracker'])) }}" value="0">
                        <span class="custom-control-label">FALSE</span>
                    </label>
                    &nbsp;
                    @else
                    <textarea class="form-control" name="jawaban-{{ ($key2+count($data['quiz_tracker'])) }}" placeholder="Masukan jawaban"></textarea>
                    @endif
                </div>
            </div>
            <br>
            @endforeach
        @endif
    </div>
    <div class="card-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <a href="{{ route('course.bahan', [ 'id' => $data['quiz']->mata_id, 'bahanId' => $data['quiz']->bahan_id, 'tipe' => 'quiz']) }}" class="btn btn-danger mr-2" title="klik untuk kembali">Kembali</a>
            <a href="javascript:;" class="btn btn-primary finish" title="klik untuk selesai">
                Selesai
                <form action="{{ route('quiz.finish', ['id' => $data['quiz']->id, 'button' => 'yes'])}}" method="POST" id="form-finish">
                    @csrf
                </form>
            </a>
          </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@if (!empty($data['quiz']->durasi))
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
            title: "Durasi Quiz sudah habis",
            text: "Klik selesai untuk melihat hasil akhir",
            type: "warning",
            confirmButtonText: "Selesai",
            customClass: {
                confirmButton: "btn btn-primary btn-lg"
            },
            showLoaderOnConfirm: false,
            allowOutsideClick: false,
            preConfirm: () => {
                return $.ajax({
                    url: "/quiz/{{ $data['quiz']->id }}/finish",
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
                    window.location.href = '/course/{{ $data['quiz']->mata_id }}/bahan/{{ $data['quiz']->bahan_id }}/quiz';
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
<script>
    var soal = "{{ $data['quiz']->item()->count() }}";
    //submit jawaban
    for (let index = 0; index < soal; index++) {
        $("#soal-change-"+index).change(function() {
            var id = $("#soal-change-"+index).data('id');
            var posisi = $("#position-"+index).val();
            var type = $('#type-'+index).val();
            if (type == 2) {
                var jawaban = $('textarea[name="jawaban-'+index+'"]').val();
            } else if (type == 0 || type == 3) {
                var jawaban = $('input[name="jawaban-'+index+'"]:checked').val();
            } else {
                var jawaban = $('input[name="jawaban-'+index+'"]').val();
            }

            $.ajax({
                method: "POST",
                url: "/quiz/{{ $data['quiz']->id }}/track/jawaban",
                data: {
                    id:id,
                    posisi:posisi,
                    jawaban:jawaban,
                },
                success: function (response) {

                }
            });
        });
    }

    //finish
    $('.finish').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, selesai!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
            if (result.value) {
                $("#form-finish").submit();
            }
        })
    });
</script>
@endsection

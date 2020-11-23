@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/smartwizard/smartwizard.css') }}">
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
        <h5 class="card-header-title mt-1 mb-0">{{ $data['quiz']->bahan->judul }}</h5>
        <div class="card-header-elements ml-auto">
            <div class="btn-group btn-group">
                @if (!empty($data['quiz']->durasi))
                <button type="button" class="btn btn-warning" id="countdown"></button>
                @else
                <button type="button" class="btn btn-warning"><i class="las la-clock"></i> Waktu tidak ditentukan</button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- <h6>Soal No : <span class="badge badge-primary" id="soal-number">1</span></h6> --}}
        <form id="smartwizard-6">
            <ul class="card px-4 pt-3 mb-3" style="display: none;">
                @if (isset($data['quiz_tracker']))
                    @foreach ($data['quiz_tracker'] as $key1 => $soal1)
                    <li>
                        <a href="#smartwizard-6-step-{{ $key1 }}" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">1</span>
                        <div class="text-muted small">SOAL</div>
                        ISI
                        </a>
                    </li>
                    @endforeach
                @endif
                @foreach ($data['soal'] as $key2 => $soal2)
                <li>
                  <a href="#smartwizard-6-step-{{ !isset($data['quiz_tracker']) ? $key2 : ($key2 + count($data['quiz_tracker'])) }}" class="mb-3">
                    <span class="sw-done-icon ion ion-md-checkmark"></span>
                    <span class="sw-number">1</span>
                    <div class="text-muted small">SOAL</div>
                    ISI
                  </a>
                </li>
                @endforeach
                <li>
                    <a href="#smartwizard-6-step-{{ !isset($data['quiz_tracker']) ? (count($data['soal'])+1) : (count($data['soal'])+1+count($data['quiz_tracker'])) }}" class="mb-3">
                      <span class="sw-done-icon ion ion-md-checkmark"></span>
                      <span class="sw-number">1</span>
                      <div class="text-muted small">SOAL</div>
                      ISI
                    </a>
                </li>
            </ul>

            <div id="soal-ujian">
                @if (isset($data['quiz_tracker']))
                    @foreach ($data['quiz_tracker'] as $key1 => $soal1)
                    <div id="smartwizard-6-step-{{ $key1 }}" class="card animated fadeIn" data-itemid="{{ $soal1->quiz_item_id }}">
                    <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                        <div class="form-group mb-0">
                            <span class="text-muted mb-2 d-inline-block">Soal no : <span id="soal-number">{{ $soal1->posisi }}</span></span>
                        <h5>{!! $soal1->item->pertanyaan !!}</h5>
                        <hr style="border-color: #d1a340;">
                        <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                        <input type="hidden" id="type-{{ $key1 }}" value="{{ $soal1->item->tipe_jawaban }}">
                        @if ($soal1->item->tipe_jawaban == 0)
                            @foreach ($soal1->item->shufflePilihan($soal1->item->pilihan) as $keyA => $valueA)
                            <label class="custom-control custom-radio mb-3">
                                <input type="radio" class="custom-control-input" name="jawaban-{{ $key1 }}" value="{{ $keyA }}" {{ $soal1->jawaban == $keyA ? 'checked' : '' }}>
                                <span class="custom-control-label">{{ $valueA }}</span>
                            </label>

                            @endforeach
                        @elseif ($soal1->item->tipe_jawaban == 1)
                        <input type="text" class="form-control" name="jawaban-{{ $key1 }}" placeholder="masukan jawaban" value="{{ $soal1->jawaban }}">
                        @else
                        <textarea class="form-control" name="jawaban-{{ $key1 }}" placeholder="masukan jawaban...">{!! $soal1->jawaban !!}</textarea>
                        @endif
                        </div>
                    </div>
                    </div>
                    @endforeach
                @endif
                @foreach ($data['soal'] as $key2 => $soal2)
                <div id="smartwizard-6-step-{{ !isset($data['soal_tracker']) ? $key2 : ($key2+count($data['soal_tracker'])) }}" class="card animated fadeIn" data-itemid="{{ $soal2->id }}">
                  <div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;">
                    <div class="form-group mb-0">
                        <span class="text-muted mb-2 d-inline-block">Soal no : <span id="soal-number">1</span></span>
                      <h5>{!! $soal2->pertanyaan !!}</h5>
                      <hr style="border-color: #d1a340;">
                      <span class="text-muted mb-2 d-inline-block">Jawab :</span>
                      <input type="hidden" id="type-{{ !isset($data['soal_tracker']) ? $key2 : ($key2+count($data['soal_tracker'])) }}" value="{{ $soal2->tipe_jawaban }}">
                      @if ($soal2->tipe_jawaban == 0)
                        @foreach ($soal2->shufflePilihan($soal2->pilihan) as $keyB => $value)
                        <label class="custom-control custom-radio mb-3">
                            <input type="radio" class="custom-control-input" name="jawaban-{{ !isset($data['soal_tracker']) ? $key2 : ($key2+count($data['soal_tracker'])) }}" value="{{ $keyB }}">
                            <span class="custom-control-label">{{ $value }}</span>
                        </label>

                        @endforeach
                      @elseif ($soal2->tipe_jawaban == 1)
                      <input type="text" class="form-control" name="jawaban-{{ !isset($data['soal_tracker']) ? $key2 : ($key2+count($data['soal_tracker'])) }}" placeholder="masukan jawaban">
                      @else
                      <textarea class="form-control" name="jawaban-{{ !isset($data['soal_tracker']) ? $key2 : ($key2+count($data['soal_tracker'])) }}" placeholder="masukan jawaban..."></textarea>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
                <div id="smartwizard-6-step-{{ !isset($data['quiz_tracker']) ? (count($data['soal'])+1) : (count($data['soal'])+1+count($data['quiz_tracker'])) }}" class="card animated fadeIn">
                    <h6>Apakah anda yakin sudah mengisi semua jawaban ?</h6><br>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success btn-block finish-quiz" data-id="{{ $data['quiz']->id }}" title="klik untuk selesai">
                            SELESAI
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<input type="hidden" value="{{ $data['quiz']->item->count() }}" id="counter-soal">
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/smartwizard/smartwizard.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/validate/validate.js') }}"></script>
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
    $(function() {
        var $form = $('#smartwizard-6');

        $form.validate({
            errorPlacement: function errorPlacement(error, element) {
                $(element).parents('.form-group').append(
                error.addClass('invalid-feedback small d-block')
                )
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            rules: {
                'wizard-confirm': {
                equalTo: 'input[name="wizard-password"]'
                }
            }
        });
        $form.smartWizard({
            autoAdjustHeight: false,
            backButtonSupport: false,
            useURLhash: false,
            showStepURLhash: false,
            lang: {
                next: 'Selanjutnya',
                previous: 'Sebelumnya'
            }
        }).on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            var item = parseInt($("#counter-soal").val());

            if (currentStepIndex == item) {
                $('#soal-number').html('Rekap Soal');
            } else {
                $('#soal-number').html(currentStepIndex+1);
            }

            if (currentStepIndex+1 <= item) {
                //track jawaban
                var type = $('#type-'+currentStepIndex).val();
                var id = $('#smartwizard-6-step-'+currentStepIndex).data('itemid');
                if (type == 2) {
                    var jawaban = $('textarea[name="jawaban-'+currentStepIndex+'"]').val();
                } else if (type == 0) {
                    var jawaban = $('input[name="jawaban-'+currentStepIndex+'"]:checked').val();
                } else {
                    var jawaban = $('input[name="jawaban-'+currentStepIndex+'"]').val();
                }

                $.ajax({
                    method: "POST",
                    url: "/quiz/{{ $data['quiz']->id }}/track/jawaban",
                    data: {
                        id:id,
                        posisi :currentStepIndex+1,
                        jawaban:jawaban,
                    },
                    success: function (response) {
                    }
                });
            }

            if (stepDirection === 'forward'){ return $form.valid(); }
            return true;
        }).on('showStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            var item = parseInt($("#counter-soal").val());

            if (currentStepIndex == item) {
                $('#soal-number').html('Rekap Soal');
            } else {
                $('#soal-number').html(currentStepIndex+1);
            }

            if (currentStepIndex+1 === parseInt(item+1)) {
                $('#btn-finish').removeClass('hidden');
            }  else {
                $('#btn-finish').addClass('hidden');
            }
        });
    });
    //finish
    $(document).ready(function () {
        $('.finish-quiz').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "",
                type: "warning",
                confirmButtonText: "Ya, Selesai!",
                customClass: {
                    confirmButton: "btn btn-danger btn-lg",
                    cancelButton: "btn btn-info btn-lg"
                },
                showLoaderOnConfirm: true,
                showCancelButton: true,
                allowOutsideClick: () => !Swal.isLoading(),
                cancelButtonText: "Tidak, terima kasih",
                preConfirm: () => {
                    return $.ajax({
                        url: "/quiz/"+id+"/finish",
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
                    Swal.fire({
                        type: 'success',
                        text: 'Quiz selesai'
                    }).then(() => {
                        window.location.href = '/course/{{ $data['quiz']->mata_id }}/bahan/{{ $data['quiz']->bahan_id }}/quiz';
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        text: response.value.message
                    }).then(() => {
                        window.location.reload();
                    })
                }
            });
        })
    });
</script>
@endsection

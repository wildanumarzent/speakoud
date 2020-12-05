@extends('layouts.backend.layout')

@section('content')
<div class="text-left">
    <a href="{{ route('course.detail', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke tugas"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0"><i class="las la-edit"></i> {{ $data['preview']->nama }}</h5>
        <div class="card-header-elements ml-auto">
            <div class="btn-group btn-group">
                <button type="button" class="btn btn-warning" id="countdown"></button>
            </div>
        </div>
    </div>
    <form action="{{ route('evaluasi.submit', ['id' => $data['mata']->id]) }}" method="POST">
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
                <a href="{{ route('course.detail', [ 'id' => $data['mata']->id]) }}" class="btn btn-danger mr-2" title="klik untuk kembali">Kembali</a>
                <button type="submit" class="btn btn-primary finish" title="klik untuk selesai">
                    Selesai
                </button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('jsbody')
<script>
    var timer2 = "{{ $data['countdown'] }}";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) {
            clearInterval(interval);
        };

        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        $('#countdown').html('<i class="las la-clock"></i> ' + minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
    }, 1000);
</script>
@endsection

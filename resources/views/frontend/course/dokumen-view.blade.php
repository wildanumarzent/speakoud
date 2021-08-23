@extends('layouts.backend.layoutdokumen')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@yield('style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['bahan']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['bahan']->mata->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['bahan']->materi->judul !!}</strong>
      </div>
    </div>
</div>

@include('components.alert-any')

<div class="row">
    <div class="col">
        <div class="card mb-4">
            <div class="card-header with-elements">
                <h5 class="card-header-title mt-1 mb-0">{!! $data['bahan']->judul !!}</h5>
                <div class="card-header-elements ml-auto">
                    @role('peserta_internal|peserta_mitra')
                        @if (empty($data['bahan']->activityCompletionByUser->track_end) && $data['bahan']->completion_type == 1 || empty($data['bahan']->activityCompletionByUser->track_end) && $data['bahan']->completion_type == 3)
                        <button id="show-complete" class="btn btn-primary btn-sm icon-btn-only-sm complete" title="klik untuk konfirmasi telah menyelesaikan materi">
                            <span>Complete</span> <i class="las la-check ml-2"></i>
                            <form action="{{ route('activity.complete', ['bahanId' => $data['bahan']->id])}}" method="POST" class="form-complete">
                                @csrf
                            </form>
                        </button>
                        @endif
                    @endrole
                </div>
            </div>
            <div class="card-body" id="on-load">
                {!! $data['bahan']->keterangan !!}
                @yield('content-view')
            </div>
            {{-- <div class="card-footer">
                <div class="row">
                    <div class="col-md-4">
                        @if ($data['bahan']->urutan > 1)
                        @foreach ($data['prev'] as $prev)
                        <a href="{{ route('course.bahan', ['id' => $prev->mata_id, 'bahanId' => $prev->id, 'tipe' => $prev->type($prev)['tipe']]) }}" class="btn btn-secondary" title="klik untuk ke materi sebelumnya"><i class="las la-arrow-left"></i> Sebelumnya</a>
                        @endforeach
                        @else
                        <button type="button" class="btn btn-secondary" disabled><i class="las la-arrow-left"></i> Sebelumnya</button>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="{{ route('course.detail', ['id' => $data['bahan']->mata_id]) }}" class="btn btn-danger" title="klik untuk kembali ke detail">Kembali</a>
                    </div>
                    <div class="col-md-4 text-right">
                        @if ($data['bahan']->urutan < $data['materi']->bahan()->count())
                        @foreach ($data['next'] as $next)
                        <a href="{{ route('course.bahan', ['id' => $next->mata_id, 'bahanId' => $next->id, 'tipe' => $next->type($next)['tipe']]) }}" class="btn btn-secondary" title="klik untuk ke bahan selanjutnya">Selanjutnya <i class="las la-arrow-right" style="margin-left: 7px; margin-right: 0"></i></a>
                        @endforeach
                        @else
                        <button type="button" class="btn btn-secondary" disabled>Selanjutnya <i class="las la-arrow-right" style="margin-left: 7px; margin-right: 0"></i></button>
                        @endif
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
   
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@yield('script')
@endsection

@section('jsbody')
@yield('body')
<script>
    $('.select2').select2();

    $('.jump').on('change', function () {

        var id = $(this).attr('data-mataid');
        var bahanId = $(this).val();
        var tipe = $('option:selected', this).attr('data-tipe');

        if (id) {
            window.location = '/course/' + id + '/bahan/' + bahanId + '/' + tipe;
        }
        return false;
    });

    $('.complete').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin sudah menyelesaikan materi ini ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, sudah!',
        cancelButtonText: "Tidak, belum",
        }).then((result) => {
            if (result.value) {
                $(".form-complete").submit();
            }
        })
    });
</script>
@if ($data['bahan']->completion_type == 2)
<script>
    $( document ).ready(function() {
        $.ajax({
            type : "POST",
            url : "/activity/{{ $data['bahan']->id }}/complete?is_ajax=yes",
        });
    });
</script>
@endif

@if ($data['bahan']->completion_type == 3)
@if (now() > $data['timer'])
<script>
    $("#show-complete").show();
</script>
@else
<script>
    $("#show-complete").hide();
    var timer2 = "{{ $data['countdown'] }}";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) {
            $("#show-complete").show();
            clearInterval(interval);
        }

    }, 1000);
</script>
@endif
@endif

@include('components.toastr')
@endsection

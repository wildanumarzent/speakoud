@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
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

<div class="row">
    <div class="col">
        <div class="card mb-4">
            <div class="card-header with-elements">
                <h5 class="card-header-title mt-1 mb-0">{!! $data['bahan']->judul !!}</h5>
                <div class="card-header-elements ml-auto">
                </div>
            </div>
            <div class="card-body">
                {!! $data['bahan']->keterangan !!}
                @yield('content-view')
            </div>
            <div class="card-footer">
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
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-3">
        @if($data['bahan']->segmenable_type == 'App\Models\Course\Bahan\BahanScorm')
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title">Scorm Result</span>
            </h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                 <p><span class="text-muted">Status : </span> <span class="text-bold">{{@$data['cpData']['core']['lesson_status']}}</span></p>
                 <p><span class="text-muted">Score : </span> <span class="text-bold">{{@$data['cpData']['core']['score']['raw'] ?? "0"}} / {{@$data['cpData']['core']['score']['max'] ?? "0"}}</span></p>
                 <p><span class="text-muted">Session Time : </span> <span class="text-bold">{{@$data['cpData']['core']['session_time'] ?? '-'}}</span></p>
                </li>
            </ul>
        </div>
        @endif
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title"> Bahan Lainnya</span>
            </h6>
            <div class="card-body">
                <select class="jump select2 show-tick" data-mataid="{{ $data['bahan']->mata_id }}" data-style="btn-default">
                    <option value="" selected disabled>Pilih Bahan</option>
                    @foreach ($data['mata']->materiPublish as $materi)
                    <optgroup label="{!! $materi->judul !!}">
                        @foreach ($materi->bahanPublish('jump')->get() as $bahan)
                        <option value="{{ $bahan->id }}" data-tipe="{{ $bahan->type($bahan)['tipe']  }}">{!! $bahan->judul !!}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title">Creator</span>
            </h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="media align-items-center">
                    <a href="{{ $data['bahan']->creator->getPhoto($data['bahan']->creator->photo['filename']) }}" data-fancybox="gallery">
                      <img src="{{ $data['bahan']->creator->getPhoto($data['bahan']->creator->photo['filename']) }}" class="d-block ui-w-30 rounded-circle" alt="">
                    </a>
                    <div class="media-body px-2">
                      <a href="javascript:void(0)" class="text-body" title="{{ $data['bahan']->creator['name']  }}"><strong>{{ $data['bahan']->creator['name']  }}</strong></a>
                    </div>
                  </div>
                </li>
            </ul>
        </div>

        {{-- <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title">{!! $data['bahan']->judul !!}</span>
            </h6>
            <div class="card-body">
                @if (!empty($data['bahan']->keterangan))
                {!! $data['bahan']->keterangan !!}
                @else
                <div class="text-center" style="color: red;">
                    <i>! Tidak ada keterangan !</i>
                </div>
                @endif
            </div>
        </div> --}}
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
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
</script>

@include('components.toastr')
@endsection

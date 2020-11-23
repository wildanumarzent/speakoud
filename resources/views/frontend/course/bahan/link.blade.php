@extends('frontend.course.bahan')

@section('content-view')
<strong class="text-center">Klik tombol dibawah untuk {{ auth()->user()->hasRole('peserta_internal|peserta_mitra') ? 'mengikuti' : 'memulai' }} video conference!</strong><br>
@if ($data['bahan']->link->tipe == 0)
<a href="{{ route('conference.room', ['id' => $data['bahan']->link->id]) }}" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
@else
@if (!auth()->user()->hasRole('peserta_internal|peserta_mitra') || auth()->user()->hasRole('peserta_internal|peserta_mitra') && $data['bahan']->link->status == 1)
<a href="{{ route('conference.platform.start', ['id' => $data['bahan']->link->id]) }}" target="_blank" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
@else
<button class="btn btn-secondary btn-block" type="button" disabled><i class="las la-play-circle"></i> Mulai</button>
@endif
@endif
@endsection


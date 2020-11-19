@extends('frontend.course.bahan')

@section('content-view')
@if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
<a href="" class="btn btn-info icon-btn-only-sm mb-4" title="klik untuk melihat peserta">
    <i class="las la-users"></i><span> Peserta</span>
</a>
@endif

<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
       <tr>
           <th style="width: 120px;">Tipe Quiz</th>
           <td>{{ config('addon.label.quiz_tipe.'.$data['bahan']->quiz->tipe) }}</td>
       </tr>
       <tr>
            <th style="width: 120px;">Jumlah Soal</th>
            <td><strong>{{ $data['bahan']->quiz->item()->count() }}</strong></td>
        </tr>
        <tr>
            <th style="width: 120px;">Durasi Soal</th>
            <td>
                @if (!empty($data['bahan']->quiz->durasi))
                <i class="las la-clock"></i> {{ $data['bahan']->quiz->durasi }} Menit
                @else
                Tidak ditentukan
                @endif
            </td>
        </tr>
        @role ('peserta_internal|peserta_mitra')
        <tr>
            <th colspan="2">
                <a href="{{ route('quiz.room', ['id' => $data['bahan']->quiz]) }}" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
            </th>
        </tr>
        @endrole
    </table>
</div>
@endsection

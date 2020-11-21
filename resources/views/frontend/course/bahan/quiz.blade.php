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
           <th style="width: 150px;">Tipe Quiz</th>
           <td>{{ config('addon.label.quiz_tipe.'.$data['bahan']->quiz->tipe) }}</td>
       </tr>
       <tr>
           <th style="width: 150px;">Jumlah Soal</th>
           <td><strong>{{ $data['bahan']->quiz->item()->count() }}</strong></td>
       </tr>
       <tr>
           <th style="width: 150px;">Durasi Soal</th>
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
            <th style="width: 150px;">Tanggal Mulai</th>
            <td>{{ !empty($data['bahan']->quiz->trackUserIn) ? $data['start_time'] : 'Belum memulai' }}</td>
        </tr>
        <tr>
            <th style="width: 150px;">Tanggal Selesai</th>
            <td>
                {{ (!empty($data['bahan']->quiz->trackUserIn) && !empty($data['bahan']->quiz->trackUserIn->end_time)) ? $data['finish_time'] : 'Belum selesai' }}
            </td>
        </tr>
        <tr>
            <th style="width: 150px;">Waktu Mengerjakan</th>
            <td>
                @if (!empty($data['bahan']->quiz->trackUserIn) && !empty($data['bahan']->quiz->trackUserIn->end_time))
                {{ $data['total_duration'].' Menit' }}
                @else
                -
                @endif
            </td>
        </tr>
        <tr>
            <th style="width: 150px;">Status</th>
            <td>
                @if (!empty($data['bahan']->quiz->trackUserIn))
                {{ $data['bahan']->quiz->trackUserIn->status == 1 ? 'Sedang Mengerjakan' : 'Sudah Selesai' }}
                @else
                Belum dikerjakan
                @endif
            </td>
        </tr>
        <tr>
            <th style="width: 150px;">Soal Diisi</th>
            <td><strong>{{ $data['bahan']->quiz->trackUserItem()->count() == 0 ? 'Belum Diisi' : $data['bahan']->quiz->trackUserItem()->count() }}</strong></td>
        </tr>
        @if ($data['bahan']->quiz->item()->count() > 0)
        <tr>
            <th colspan="2" class="text-center">
                Klik tombol dibawah untuk mulai mengerjakan. Selamat mengerjakan!
                <a href="{{ route('quiz.room', ['id' => $data['bahan']->quiz]) }}" class="btn btn-primary btn-block mt-2"><i class="las la-play-circle"></i> Mulai</a>
            </th>
        </tr>
        @endif
        @endrole
    </table>
</div>
@endsection
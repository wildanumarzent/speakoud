@extends('frontend.course.bahan')

@section('content-view')
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
        <tr>
            <th colspan="2">
                <a href="" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
            </th>
        </tr>
    </table>
</div>
@endsection

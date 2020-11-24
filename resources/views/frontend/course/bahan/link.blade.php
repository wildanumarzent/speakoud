@extends('frontend.course.bahan')

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
        <tr>
           <th style="width: 150px;">Conference</th>
           <td>
               @if ($data['bahan']->link->tipe == 0)
                   BPPT Conference
               @else
                   Platform External
               @endif
           </td>
        </tr>
        <tr>
            <th style="width: 150px;">Status</th>
            <td>
                @if ($data['bahan']->link->status == 0)
                    Belum dimulai
                @elseif ($data['bahan']->link->status == 1)
                    Sedang berlangsung
                @else
                    Sudah selesai
                @endif
            </td>
         </tr>
         <tr>
            <th style="width: 150px;">Peserta</th>
            <td>
                <a href="{{ route('conference.peserta.list', ['id' => $data['bahan']->link->id]) }}" class="btn btn-info icon-btn-only-sm btn-sm" title="klik untuk melihat peserta">
                    <i class="las la-users"></i><span> Lihat</span>
                </a>
            </td>
         </tr>
         <tr>
             <th colspan="2" class="text-center">
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
             </th>
         </tr>
    </table>
</div>
@endsection


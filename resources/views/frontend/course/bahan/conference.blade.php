@extends('frontend.course.bahan')

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
        <tr>
           <th style="width: 150px;">Conference</th>
           <td>
               @if ($data['bahan']->conference->tipe == 0)
                   BPPT Conference
               @else
                   Platform External
               @endif
           </td>
        </tr>
        <tr>
            <th style="width: 150px;">Status</th>
            <td>
                @if ($data['bahan']->conference->status == 0)
                    Belum dimulai
                @elseif ($data['bahan']->conference->status == 1)
                    Sedang berlangsung
                @else
                    Sudah selesai
                @endif
            </td>
         </tr>
         <tr>
            <th style="width: 150px;">Tanggal</th>
            <td>{{ $data['bahan']->conference->tanggal->format('d F Y') }}</td>
         </tr>
         <tr>
            <th style="width: 150px;">Jam Mulai</th>
            <td>{{ $data['bahan']->conference->start_time->format('H:i (A)') }}</td>
         </tr>
         <tr>
            <th style="width: 150px;">Jam Selesai</th>
            <td>{{ $data['bahan']->conference->end_time->format('H:i (A)') }}</td>
         </tr>
         @if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && !empty($data['bahan']->conference->trackByUser) && $data['bahan']->conference->status == 2)
         <tr>
            <th style="width: 150px;">Masuk</th>
            <td>
                {{ $data['bahan']->conference->trackByUser->join->format('d F Y (H:i A)') }}
            </td>
         </tr>
         <tr>
            <th style="width: 150px;">Keluar</th>
            <td>
                {{ !empty($data['bahan']->conference->trackByUser->leave) ? $data['bahan']->conference->trackByUser->leave->format('d F Y (H:i A)') : '-' }}
            </td>
         </tr>
         <tr>
            <th style="width: 150px;">Verifikasi Kehadiran</th>
            <td>
                @if ($data['bahan']->conference->trackByUser->check_in_verified == 1)
                <span class="badge badge-success">Sudah Diverifikasi <i class="las la-check"></i></span>
                @else
                <span class="badge badge-danger">Belum Diverifikasi <i class="las la-times"></i></span>
                @endif
            </td>
         </tr>
         @if ($data['bahan']->conference->trackByUser->check_in_verified == 1)
         <tr>
            <th style="width: 150px;">Diverifikasi Tanggal</th>
            <td>
                {{ $data['bahan']->conference->trackByUser->check_in->format('d F Y (H:i A)') }}
            </td>
         </tr>
         @endif
         @endif
         @if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['bahan']->conference->trackByUser) && $data['bahan']->conference->status == 2)
         <tr>
            <th colspan="2" class="text-center">
                <strong class="text-center">Anda tidak mengikuti Video Conference ini</strong>
            </th>
         </tr>
         @endif
         @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
         <tr>
            <th style="width: 150px;">Peserta</th>
            <td>
                <a href="{{ route('conference.peserta.list', ['id' => $data['bahan']->conference->id]) }}" class="btn btn-info icon-btn-only-sm btn-sm" title="klik untuk melihat peserta">
                    <i class="las la-users"></i><span> Lihat</span>
                </a>
            </td>
         </tr>
         @if ($data['bahan']->conference->status == 1 && count($data['bahan']->conference->api) != 0)
        <tr>
            <th style="width: 150px;">Konfirmasi</th>
            <td>
                <a href="javascript:;" class="btn btn-danger icon-btn-only-sm btn-sm close-vidcon" title="klik untuk menutup conference">
                    Tutup Video Conference
                    <form action="{{ route('conference.finish', ['id' => $data['bahan']->conference->id])}}" method="POST" id="form-close">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
            </td>
        </tr>
        @endif
         @endif
         @if ($data['bahan']->conference->status < 2)
         <tr>
             <th colspan="2" class="text-center">
                <strong class="text-center">Klik tombol dibawah untuk {{ auth()->user()->hasRole('peserta_internal|peserta_mitra') ? 'mengikuti' : 'memulai' }} video conference!</strong><br>
                @if (now()->format('Y-m-d') < $data['bahan']->conference->tanggal && now() < $data['bahan']->conference->start_time || now() >= $data['bahan']->conference->end_time )
                <button class="btn btn-secondary btn-block" type="button" disabled><i class="las la-play-circle"></i> Mulai</button>
                @else
                    @if ($data['bahan']->conference->tipe == 0)
                        <a href="{{ route('conference.room', ['id' => $data['bahan']->conference->id]) }}" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
                    @else
                        @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra') || auth()->user()->hasRole('peserta_internal|peserta_mitra') && $data['bahan']->conference->status == 1)
                            <a href="{{ route('conference.platform.start', ['id' => $data['bahan']->conference->id]) }}" target="_blank" class="btn btn-primary btn-block"><i class="las la-play-circle"></i> Mulai</a>
                        @else
                            <button class="btn btn-secondary btn-block" type="button" disabled><i class="las la-play-circle"></i> Mulai</button>
                        @endif
                    @endif
                @endif
             </th>
         </tr>
         @endif
    </table>
</div>
@endsection

@section('body')
<script>
    $('.close-vidcon').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin akan menutup video conference ini ?",
        text: "Video conference tidak akan bisa dibuka lagi",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tutup!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
        if (result.value) {
            $("#form-close").submit();
        }
        })
    });
</script>
@endsection


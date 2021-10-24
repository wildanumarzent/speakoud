@extends('frontend.course.bahan')

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-2">
    <table class="table table-striped table-bordered mb-0">
       <tr>
           <th style="width: 150px;">Tipe Quiz</th>
           <td>{{ config('addon.label.quiz_kategori.'.$data['bahan']->quiz->kategori) }}</td>
       </tr>
       <tr>
           <th style="width: 150px;">Jumlah Soal</th>
           <td><strong>{{ $data['bahan']->quiz->item()->count() }}</strong> <a href="{{ route('quiz.preview', ['id' => $data['bahan']->quiz->id]) }}" class="btn btn-info icon-btn-only-sm btn-sm" title="preview soal">
                <i class="las la-list"></i><span>Preview Soal</span>
            </a></td>
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
        @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
        <tr>
            <th style="width: 150px;">Peserta</th>
            <td>
                <a href="{{ route('quiz.peserta', ['id' => $data['bahan']->quiz->id]) }}" class="btn btn-info icon-btn-only-sm btn-sm" title="klik untuk melihat peserta">
                    <i class="las la-users"></i><span> Lihat</span>
                </a>
            </td>
        </tr>
        @endif
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
                    {{ $data['total_duration'] }}
                    @else
                    -
                    @endif
                </td>
            </tr>
            {{-- {{dd($data['bahan']->quiz->trackUserIn)}} --}}
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
                @if (!empty($data['bahan']->quiz->trackUserIn) && $data['bahan']->quiz->trackUserIn->status == 2 && $data['bahan']->quiz->hasil == 1)
                <tr>
                    <th style="width: 150px;">Hasil Quiz</th>
                    <td><span class="badge badge-primary">{{ round(($data['bahan']->quiz->trackUserItem()->where('benar', 1)->count() / $data['bahan']->quiz->item->count()) * 100) }}</span></td>
                </tr>
                @endif
                <tr>
                    <th colspan="2" class="text-center">
                        @if (!empty($data['bahan']->quiz->trackUserIn) && $data['bahan']->quiz->trackUserIn || $data['bahan']->quiz->trackUserIn)
                        Anda telah menyelesaikan quiz ini
                        <a href="{{ route('mata.nilai.peserta', ['id' => $data['bahan']->mata->id]) }}" class="btn btn-success rounded-pill icon-btn-only-sm btn-block" title="Daftar Nilai">
                            <i class="las la-list-ol"></i> <span>Lihat Nilai</span>
                        </a>
                        @if ($data['bahan']->quiz->tipe == 0 && $data['bahan']->quiz->trackUserIn->cek == 0)
                        <br>
                        <a href="javascript:void(0);" data-quizid="{{ $data['bahan']->quiz->id }}" data-pesertaid="{{ auth()->user()->id }}" class="btn btn-success js-ulangi" title="klik untuk mengulangi quiz">
                            <i class="las la-history"></i> Ulangi Quiz
                        </a>
                        @endif
                        @else
                        Klik tombol dibawah untuk mulai mengerjakan. Selamat mengerjakan!
                        <a href="{{ route('quiz.room', ['id' => $data['bahan']->quiz]) }}" class="btn btn-primary btn-block mt-2"><i class="las la-play-circle"></i> Mulai</a>
                        @endif
                    </th>
                </tr>
            @else
            <tr>
                <th colspan="2" class="text-center">
                    <i>*Instruktur belum memasukan soal</i>
                </th>
            </tr>
            @endif
        @endrole
    </table>
</div>
@endsection

@section('body')
<script>
    $(document).ready(function () {
        $('.js-ulangi').on('click', function () {
            var quiz_id = $(this).attr('data-quizid');
            var peserta_id = $(this).attr('data-pesertaid');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Jawaban sebelumnya akan terhapus !",
                type: "warning",
                confirmButtonText: "Ya, ulangi!",
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
                        url: "/quiz/"+ quiz_id +"/user/"+ peserta_id,
                        method: 'DELETE',
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
                        text: 'berhasil mereset jawaban quiz'
                    }).then(() => {
                        window.location.href = '/quiz/{{ $data['bahan']->quiz->id }}/test';
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

@extends('layouts.backend.layout')

@section('content')
@if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))    
<!-- Filters -->
<div class="card">
    <div class="card-body">
        <div class="form-row align-items-center">
            <div class="col-md">
                <form action="" method="GET">
                    <div class="form-group">
                        <label class="form-label">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->
@endif

<div class="text-left">
    <a href="{{ route('course.detail', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list program"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

@if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))    
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Daftar Nilai</h5>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="{{ $data['bahan']->count() }}" class="text-center">
                        {{ strtoupper($data['mata']->judul) }}
                    </th>
                </tr>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th style="width: 120px;">NIP</th>
                    <th style="width: 180px;">Nama</th>
                    <th style="width: 120px;">Email</th>
                    @forelse($data['bahan'] as $item)
                    <th class="text-center">{{ $item->judul }}</th>
                    @empty
                    <th></th>
                    @endforelse
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                    <tr>
                        <td colspan="{{ $data['bahan']->count()+4 }}" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Peserta tidak ditemukan !
                                @else
                                ! Belum ada peserta !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{{ $item->peserta->nip }}</td>
                    <td>{{ $item->peserta->user->name }}</td>
                    <td>{{ $item->peserta->user->email }}</td>
                    @forelse($data['bahan'] as $bahan)
                    <td class="text-center">
                        @if ($bahan->quiz()->count() > 0)
                            @php
                                $nilaiQuiz = $bahan->quiz->trackItem->where('user_id', $item->peserta->user_id);
                            @endphp
                            @if ($nilaiQuiz->count() > 0)
                                <span class="badge badge-primary">
                                    <strong>{{ round(($nilaiQuiz->where('benar', 1)->count() / $nilaiQuiz->count()) * 100) }}</strong>
                                </span>
                            @else
                            <span class="badge badge-danger">
                                <strong>0</strong>
                            </span>
                            @endif
                        @else
                            @php
                                $nilaiTugas = $bahan->tugas->respon()->where('user_id', $item->peserta->user_id)->first();
                            @endphp
                            @if (!empty($nilaiTugas) && !empty($nilaiTugas->nilai))
                                <span class="badge badge-primary">
                                    <strong>{{ $nilaiTugas->nilai }}</strong>
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <strong>0</strong>
                                </span>
                            @endif
                        @endif
                    </td>
                    @empty
                    <td></td>
                    @endforelse
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['peserta']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Daftar Nilai</h5>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="7" class="text-center">
                        {{ strtoupper($data['mata']->judul) }}
                    </th>
                </tr>
                <tr>
                    <th>Grade item</th>
                    <th class="text-center">Grade</th>
                    {{-- <th class="text-center">Range</th> --}}
                    <th class="text-center">Percentace</th>
                    {{-- <th>Feedback</th> --}}
                    <th class="text-center">Status</th>
                    <th>Mengulang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['bahan'] as $bahan)
               
                <tr>
                    @php
                        if ($bahan->quiz()->count() > 0) {

                            $quiz = $bahan->quiz->trackItem->where('user_id', auth()->user()->id);
                            // dd($quiz);
                            if ($quiz->count() > 0) {
                                $grade = round(($quiz->where('benar', 1)->count() / $quiz->count()) * 100);
                            } else {
                                $grade = 0;
                            }

                            $feedback = '';
                            $bobot = 0;
                            if (!empty($bahan->mata->bobot->quiz) && $bahan->quiz->kategori == 1 || $bahan->quiz->kategori == 4) {
                                $bobot = $bahan->mata->bobot->quiz;
                            }

                            if (!empty($bahan->mata->bobot->post_test) && $bahan->quiz->kategori == 2) {
                                $bobot = $bahan->mata->bobot->post_test;
                            }

                            if (!empty($bahan->mata->bobot->progress_test) && $bahan->quiz->kategori == 3) {
                                $bobot = $bahan->mata->bobot->progress_test;
                            }

                            $calculate = round($bobot * ($grade/100));

                        } else {

                            $tugas = $bahan->tugas->respon()->where('user_id', auth()->user()->id)->first();
                            if (!empty($tugas) && !empty($tugas->nilai)) {
                               $grade = $tugas->nilai;
                            } else {
                               $grade = 0;
                            }

                            $feedback = '';
                            if (!empty($tugas)) {
                                $feedback = $tugas->komentar;
                            }

                            $bobot = 0;
                            if (!empty($bahan->mata->bobot->tugas_mandiri)) {
                                $bobot = $bahan->mata->bobot->tugas_mandiri;
                            }

                            $calculate = round($bobot * ($grade/100));

                        }
                    @endphp
                    <td><strong>{{ $bahan->judul }}</strong></td>
                    <td class="text-center">
                        <span class="badge badge-primary">
                            <strong>{{ $grade }}</strong>
                        </span>
                    </td>
                    {{-- <td class="text-center">
                        <strong>0 - 100</strong>
                    </td> --}}
                    <td class="text-center">
                        <strong>{{ $grade.'%' }}</strong>
                    </td>
                    {{-- <td>{!! $feedback !!}</td> --}}
                    <td class="text-center">
                        {{-- {{dd($bahan->quiz->trackUserIn)}} --}}
                        @if ($bahan->quiz->trackUserIn != null)
                            @if ($bahan->quiz->trackUserIn->is_graduaded == 1)
                                <strong class="badge badge-primary">Lulus</strong>
                                @else  
                                <strong class="badge badge-danger">Belum Lulus</strong>
                            @endif
                        @endif
                    </td>

                    <td>
                        @if ($bahan->quiz->trackUserIn != null)
                            @if ($bahan->quiz->trackUserIn->is_graduaded == 1)
                                <strong class="badge badge-primary">Tidak perlu mengulang quis</strong>
                                @else  
                                <a href="{{ route('quiz.room', ['id' => $bahan->quiz]) }}" class="btn btn-primary btn-block mt-2"><i class="las la-play-circle"></i> Ulangi Quiz</a>
                            @endif
                        @endif
                    </td>
                    {{-- <td class="text-center">
                        <strong>{{ $calculate.'%' }}</strong>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
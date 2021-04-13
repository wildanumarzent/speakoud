@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/tickets.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.min.css">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="card mb-4">
<div class="row no-gutters row-bordered ui-bordered text-center">
    <a href="javascript:void(0)" class="d-flex col flex-column text-body py-3">
      <div class="font-weight-bold">{!! $data['read']->program->judul !!}</div>
      <div class="text-muted small">Kategori</div>
    </a>
    <a href="javascript:void(0)" class="d-flex col flex-column text-body py-3">
      <div class="font-weight-bold">{!! $data['read']->publish_start->format('d F Y (H:i A)') !!}</div>
      <div class="text-muted small">Tanggal Mulai</div>
    </a>
    <a href="javascript:void(0)" class="d-flex col flex-column text-body py-3">
      <div class="font-weight-bold">{!! !empty($data['read']->publish_end) ? $data['read']->publish_end->format('d F Y (H:i A)') : '-' !!}</div>
      <div class="text-muted small">Tanggal Selesai</div>
    </a>
</div>
</div>

<div class="row">
    <div class="col">
        <div class="card mb-4">
            <div class="card-header with-elements">
                <div class="media align-items-center mb-2">
                    <img src="{{ $data['read']->creator->getPhoto($data['read']->creator->photo['filename']) }}" alt="" class="d-block ui-w-50 rounded-circle" title="Created by : {{ $data['read']->creator->name }}">
                    <div class="media-body ml-3">
                      <h5 class="mb-1"><a href="javascript:void(0)" class="text-body">{!! $data['read']->judul !!}</a></h5>
                      {{-- <div class="text-muted small">Last Updated {{ $data['read']->updated_at->format('d F Y') }}</div> --}}
                      <div class="text-muted small"><i class="las la-user"></i> <strong>{{ $data['read']->peserta->count() }}</strong> Peserta Enroll <i class="las la-comment ml-3"></i> <strong>{{ $data['read']->materi->count() }}</strong> Topik</div>
                    </div>
                </div>
                <div class="card-header-elements ml-auto">
                    <div class="btn-group float-right dropdown ml-2">
                        <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm btn-sm" data-toggle="dropdown"><i class="las la-share-alt"></i><span>Bagikan</span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="https://www.facebook.com/share.php?u={{ url()->full() }}&title={!! $data['read']->judul !!}" class="dropdown-item" target="_blank">
                                <i class="lab la-facebook" style="color:#3b5998;"></i><span>Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={!! $data['read']->judul !!}&amp;url={{ url()->full() }}" class="dropdown-item" >
                                <i class="lab la-twitter" style="color:#55acee;"></i><span>Twitter</span>
                            </a>
                            <a href="whatsapp://send?text={!! $data['read']->judul !!} {{ url()->full() }}" class="dropdown-item" target="_blank" >
                                <i class="lab la-whatsapp" style="color:#009688;"></i><span>WhatsApp</span>
                            </a>
                            <a href="https://plus.google.com/share?url={{ url()->full() }}" class="dropdown-item" target="_blank" >
                                <i class="lab la-google-plus" style="color:#dd4b39;"></i><span>Google Plus</span>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->full() }}&title={!! $data['read']->judul !!}&source={{ request()->root() }}" class="dropdown-item" target="_blank" >
                                <i class="lab la-linkedin" style="color:#0077b5;"></i><span>LinkedIn</span>
                            </a>
                            <a href="https://pinterest.com/pin/create/bookmarklet/?media={{ $data['read']->getCover($data['read']->cover['filename']) }}&url={{ url()->full() }}&is_video=false&description={!! $data['read']->keterangan !!}" class="dropdown-item" target="_blank" >
                                <i class="lab la-pinterest" style="color:#cb2027;"></i><span>Pinterest</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body mt-2">
                {!! $data['read']->content !!}
            </div>
        </div>
        <hr class="mt-2 mb-4">
        <h6 class="font-weight-semibold mb-4">Pelatihan</h6>
        @role ('administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <div class="text-left">
            <a href="{{ route('mata.completion', ['id' => $data['read']->id]) }}" class="btn btn-info rounded-pill icon-btn-only-sm" title="Aktivitas">
                <i class="las la-chart-line"></i> <span>Aktivitas</span>
            </a>
        </div>
        <br>
        @endrole
        <div id="accordion2">
            @foreach ($data['materi'] as $key => $materi)
            <div class="card mb-2">
                <div class="card-header">
                  <a class="d-flex justify-content-between text-body collapsed" data-toggle="collapse" href="#materi-{{ $key }}" aria-expanded="false">
                    <strong>{!! $materi->judul !!}</strong>
                    <div class="collapse-icon"></div>
                  </a>
                </div>
                <div id="materi-{{ $key }}" class="collapse" data-parent="#accordion2" style="">
                  <div class="card-body">
                    @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
                    <a href="{{ route('bahan.index', ['id' => $materi->id]) }}" class="btn btn-success rounded-pill btn-sm mb-2" title="manajemen bahan"><i class="las la-folder"></i>Materi</a>
                    @endif

                    {!! $materi->keterangan !!}

                    <ul class="list-group list-group-flush mt-2">
                        @foreach ($materi->bahanPublish as $bahan)
                        <li class="list-group-item py-4">
                            <div class="media flex-wrap">
                                <div class="d-none d-sm-block ui-w-120 text-center">
                                    @if ($bahan->type($bahan)['tipe'] == 'dokumen')
                                    <i class="las la-file-{{ $bahan->dokumen->bankData->icon($bahan->dokumen->bankData->file_type) }} mr-2" style="font-size: 4em;"></i>
                                    @elseif ($bahan->type($bahan)['tipe'] == 'video')
                                        @if (!empty($bahan->video->bankData->thumbnail))
                                            <div class="d-block ui-rect-67 ui-bg-cover" style="background-image: url({{ route('bank.data.stream', ['path' => $bahan->video->bankData->thumbnail]) }});"></div>
                                        @else
                                            <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 4em;"></i>
                                        @endif
                                    @else
                                    <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 4em;"></i>
                                    @endif
                                </div>
                                <div class="media-body ml-sm-2">
                                    <h5 class="mb-2">
                                        @role ('peserta_internal|peserta_mitra')
                                        @if ($bahan->completion_type > 0)
                                        <div class="float-right font-weight-semibold ml-3">
                                            @if ($bahan->activityCompletionByUser()->count() == 1 && !empty($bahan->activityCompletionByUser->track_end))
                                                @if ($bahan->activityCompletionByUser->status == 1)
                                                    <i class="las la-check-square text-success" style="font-size: 2em;" title="anda sudah menyelesaikan materi ini"></i>
                                                @else
                                                    <i class="las la-check-square text-danger" style="font-size: 2em;" title="materi telah diselesaikan (Check by : {{ $bahan->activityCompletionByUser->completed->name }})"></i>
                                                @endif
                                            @else
                                            <i class="las la-stop text-secondary" style="font-size: 2em;" title="anda belum menyelesaikan materi ini"></i>
                                            @endif
                                        </div>
                                        @endif
                                        @endrole
                                        <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => $bahan->type($bahan)['tipe']]) }}" class="text-body">{!! $bahan->judul !!}</a>&nbsp;
                                    </h5>
                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                        <div class="text-muted small">
                                            @if ($bahan->restrict_access == 1)
                                                <i class="las la-calendar text-primary"></i>
                                                <span>Tanggal : <strong>{{ $bahan->publish_start->format('d F Y H:i (A)') }}</strong> s/d <strong>{{ $bahan->publish_end->format('d F Y H:i (A)') }}</strong></span>
                                            @endif
                                            @if ($bahan->restrict_access == '0')
                                                <i class="las la-folder text-danger"></i>
                                                <span>Materi ini tidak bisa diakses sebelum menyelesaikan materi <strong class="badge badge-danger">{{ $bahan->restrictBahan($bahan->requirement)->judul }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>{!! strip_tags(Str::limit($bahan->keterangan, 120)) !!}</div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                  </div>
                </div>
            </div>
            @endforeach
            @if (!auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && !empty($data['read']->kode_evaluasi) && $data['checkKode'] == true)
            <div class="card mb-2">
                <div class="card-header">
                  <a class="d-flex justify-content-between text-body collapsed" data-toggle="collapse" href="#evaluasi-penyelenggara" aria-expanded="false">
                    <strong>Evaluasi Penyelenggaraan Diklat</strong>
                    <div class="collapse-icon"></div>
                  </a>
                </div>
                <div id="evaluasi-penyelenggara" class="collapse" data-parent="#accordion2" style="">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item py-4">
                                <div class="media flex-wrap">
                                    <div class="d-none d-sm-block ui-w-120 text-center">
                                        <i class="las la-edit mr-2" style="font-size: 4em;"></i>
                                    </div>
                                    <div class="media-body ml-sm-2">
                                    <h5 class="mb-2">
                                        @role ('peserta_internal|peserta_mitra')
                                        <div class="float-right font-weight-semibold ml-3">
                                            @if (!empty($data['apiUser']) && $data['apiUser']->is_complete == 1)
                                            <i class="las la-check-square text-success" style="font-size: 2em;" title="anda sudah mengisi evaluasi ini"></i>
                                            @else
                                            <i class="las la-stop text-secondary" style="font-size: 2em;" title="anda belum mengisi evaluasi ini"></i>
                                            @endif
                                        </div>
                                        @endrole
                                        <a href="{{ route('evaluasi.penyelenggara', ['id' => $data['read']->id]) }}" class="text-body">{{ $data['preview']->nama }}</a>&nbsp;
                                    </h5>
                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                        <div class="text-muted small">
                                            <i class="las la-calendar text-primary"></i>
                                            <span>{{ $data['preview']->waktu_mulai.' s/d '.$data['preview']->waktu_selesai }}</span>
                                        </div>
                                    </div>
                                    <div>Durasi pengerjaan :
                                        @if (!empty($data['preview']->lama_jawab))
                                        <span class="badge badge-warning"><i class="las la-clock"></i> {{ $data['preview']->lama_jawab.' Menit' }}</span>
                                        @else
                                        Tidak ada durasi
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @include('frontend.course.sertifikat')
    </div>
    <div class="col-md-4 col-xl-3">
         <!-- Leaders -->
         <div class="card mb-4">
            <h6 class="card-header with-elements">
              <span class="card-header-title"> Pengajar</span>
            </h6>
            <ul class="list-group list-group-flush">
                @foreach ($data['read']->instruktur as $ins)
                {{-- @foreach ($data['read']->materi()->select('instruktur_id')->groupBy('instruktur_id')->get() as $ins) --}}
                <li class="list-group-item">
                  <div class="media align-items-center">
                    <a href="{{ $ins->instruktur->user->getPhoto($ins->instruktur->user->photo['filename']) }}" data-fancybox="gallery">
                      <img src="{{ $ins->instruktur->user->getPhoto($ins->instruktur->user->photo['filename']) }}" class="d-block ui-w-30 rounded-circle" alt="">
                    </a>
                    <div class="media-body px-2">
                      <a href="javascript:void(0)" class="text-body" title="{{ $ins->instruktur->user['name']  }}"><strong>{{ $ins->instruktur->user['name']  }}</strong></a>
                    </div>
                  </div>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- / Leaders -->
        @if ($data['read']->show_feedback == 1)
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title"> Rating</span>
            </h6>
            @php
                // dd($data['read']->rating('per_rating', 5))
            @endphp
            <div class="card-body">
                @foreach ($data['numberProgress'] as $i)
                <div class="progress-course mb-4">
                    <div class="progress">
                        <span class="badge badge-warning mr-3">{{ $i }}</span>
                        <div class="progress-bar" style="width: {{ $data['read']->rating->count() > 0 ? round(($data['read']->getRating('per_rating', $i) / $data['read']->getRating('student_rating')) * 100) : 0 }}%;">
                            {{ $data['read']->rating->count() > 0 ? round(($data['read']->getRating('per_rating', $i) / $data['read']->getRating('student_rating')) * 100) : 0 }}%
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-center text-muted">
                    <h3 class="badge badge-primary" style="font-size: 20px;">
                        {{ $data['read']->rating->count() > 0 ? round($data['read']->getRating('review'), 2) : 0 }}
                    </h3><br>
                    {{ $data['read']->getRating('student_rating') }} Rating Peserta
                </div>
            </div>
            <div class="card-footer">
                <div class="small text-center">
                    @role ('peserta_internal|peserta_mitra')
                    <select id="rating" name="rating" class="mb-2">
                        <option value="" ></option>
                        @for ($i = 1; $i < 6; $i++)
                        <option value="{{ $i }}" {{ $data['read']->ratingByUser()->count() > 0 ? ($data['read']->ratingByUser->rating == $i ? 'selected' : '') : 0 }}>1</option>
                        @endfor
                    </select>
                    @else
                    @if ($data['read']->rating->count() > 0)
                    @foreach ($data['numberRating'] as $i)
                        <i class="fa{{ (floor($data['read']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.8em;"></i>
                    @endforeach
                    @else
                    @foreach ($data['numberRating'] as $i)
                        <i class="far fa-star text-warning" style="font-size: 1.8em;"></i>
                    @endforeach
                    @endif
                    @endrole
                </div>
            </div>
        </div>
        @endif
        @if ($data['read']->show_comment == 1)
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title"> Komentar</span>
            </h6>
            <form action="{{ route('course.comment', ['id' => $data['read']->id]) }}" method="POST" id="form-comment">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control @error('komentar') is-invalid @enderror" name="komentar" placeholder="masukan komentar...">{{ old('komentar') }}</textarea>
                        @include('components.field-error', ['field' => 'komentar'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    @if ($data['read']->comment->count() > 0)
        @if ($data['read']->show_comment == 1)
        <div class="col-md-9">
            <hr class="mt-2 mb-4">
            <h6 class="font-weight-semibold mb-4">Komentar</h6>
            @foreach ($data['read']->comment as $comment)
            <div class="card mb-3">
                <div class="card-body">
                <div class="media">
                    <img src="{{ asset(config('addon.images.photo')) }}" alt="" class="d-block ui-w-40 rounded-circle">
                    <div class="media-body ml-4">
                    <div class="float-right text-muted small">
                        @if (auth()->user()->hasRole('administrator') || $comment->creator_id == auth()->user()->id)
                            <a href="javascript:;" data-id="{{ $comment->id }}" class="btn btn-danger icon-btn btn-sm js-sa2-delete"><i class="las la-trash-alt"></i></a>
                        @endif
                    </div>
                    <a href="javascript:void(0)">{{ $comment->user->name }}</a>
                    <div class="text-muted small">{{ $comment->created_at->format('l, j F Y (H:i A)') }}</div>
                    <div class="mt-2">
                        {!! $comment->komentar !!}
                    </div>
                    <div class="small mt-2">
                    </div>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/js/sidenav.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js" type="text/javascript"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_tickets_edit.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/ui_sidenav.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#rating').barrating({
            theme: 'fontawesome-stars',
            onSelect:function(value, text, event) {
              var mataId = '{{ $data['read']->id }}';
              $.ajax({
                type:"POST",
                url: "/course/"+ mataId +"/rating",
                data : {
                  rating : value
                },
                cache: false,
                success : function() {
                    window.location.reload();
                }
              });
            }
        });

        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin akan menghapus komentar ini ?",
                text: "",
                type: "warning",
                confirmButtonText: "Ya, hapus!",
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
                        url: "/komentar/delete/" + id,
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
                        text: 'komentar pelatihan berhasil dihapus'
                    }).then(() => {
                        window.location.reload();
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

@include('components.toastr')
@endsection

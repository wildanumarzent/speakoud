@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/tickets.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        <strong>{!! $data['read']->program->judul !!}</strong>
      </div>
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
                      <div class="text-muted small"><i class="las la-user"></i> <strong>0</strong> students enrolled <i class="las la-comment ml-3"></i> <strong>{{ $data['read']->materi->count() }}</strong> topics</div>
                    </div>
                </div>
                <div class="card-header-elements ml-auto">
                    <div class="btn-group float-right dropdown ml-2">
                        <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm btn-sm" data-toggle="dropdown"><i class="las la-share-alt"></i><span>Share</span></button>
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
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title"> Course Content</span>
            </h6>
            <div class="card-body">
                @foreach ($data['read']->materiPublish as $materi)
                <div class="bg-white ui-bordered mb-2 hide-collapse">
                    <a href="#materi-{{ $materi->id }}" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse" aria-expanded="true">
                        <strong><i class="las la-thumbtack"></i> {!! $materi->judul !!}</strong>
                        <span class="collapse-icon"></span>
                    </a>
                    <div id="materi-{{ $materi->id }}" class="text-muted collapse">
                        <div class="card-body pb-2">
                            {!! $materi->keterangan ?? $materi->judul !!}
                            @foreach ($materi->bahanPublish as $bahan)
                            <div class="form-group mt-2">
                                @if ($bahan->type($bahan)['tipe'] == 'forum')
                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 1.5em;"></i>
                                <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => 'forum']) }}"><strong>{!! $bahan->judul !!}</strong></a>
                                @endif
                                @if ($bahan->type($bahan)['tipe'] == 'dokumen')
                                <i class="las la-file-{{ $bahan->dokumen->bankData->icon($bahan->dokumen->bankData->file_type) }} mr-2" style="font-size: 1.5em;"></i>
                                <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => 'dokumen']) }}"><strong>{!! $bahan->judul !!}</strong></a>
                                @endif
                                @if ($bahan->type($bahan)['tipe'] == 'link')
                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 1.5em;"></i>
                                <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => 'link']) }}"><strong>{!! $bahan->judul !!}</strong></a>
                                @endif
                                @if ($bahan->type($bahan)['tipe'] == 'quiz')
                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 1.5em;"></i>
                                <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => 'quiz']) }}"><strong>{!! $bahan->judul !!}</strong></a>
                                @endif
                                @if ($bahan->type($bahan)['tipe'] == 'scorm')
                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 1.5em;"></i>
                                <a href="{{ route('course.bahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => 'scorm']) }}"><strong>{!! $bahan->judul !!}</strong></a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-3">
         <!-- Leaders -->
         <div class="card mb-4">
            <h6 class="card-header with-elements">
              <span class="card-header-title"> Pengajar</span>
            </h6>
            <ul class="list-group list-group-flush">
                @foreach ($data['read']->instruktur as $ins)
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
        <div class="card mb-4">
            <h6 class="card-header with-elements">
                <span class="card-header-title"> Student Feedback</span>
            </h6>
            @php
                // dd($data['read']->rating('per_rating', 5))
            @endphp
            <div class="card-body">
                @php
                    $number = [1, 2, 3, 4, 5];
                @endphp
                @foreach ($number as $i)
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
                    {{ $data['read']->getRating('student_rating') }} Student Ratings
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
                    @foreach ($number as $i)
                        <i class="fa{{ (floor($data['read']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.8em;"></i>
                    @endforeach
                    @else
                    @foreach ($number as $i)
                        <i class="far fa-star text-warning" style="font-size: 1.8em;"></i>
                    @endforeach
                    @endif
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/js/sidenav.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js" type="text/javascript"></script>
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
    });
</script>

@include('components.toastr')
@endsection

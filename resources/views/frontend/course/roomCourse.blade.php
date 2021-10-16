<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Pelatihan</title>

    <!-- Css Global -->
    <link rel="stylesheet" href="{{asset('assets/roomCourse/css/line-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/roomCourse/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/roomCourse/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">

</head>
<body>
    {{-- @include('components.toastr') --}}
    
    <main>
        <div class="header-nav">
            <div class="hn-right">
                <div class="item-hn">
                    <div class="toggle toggle-sn">
                        <i class="las la-expand"></i>
                        <span></span>
                    </div>
                </div>
                <div class="item-hn">
                    <a href="{{route('platihan.index')}}" class="toggle toggle-close">
                        <i class="las la-times"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="box-wrap">
            <div class="sidebar-nav">
                <div class="box-breadcrumb" style="height: 0px; padding-top:10px">
                    <div class="title-heading">
                        <h5>{{$data['bahan']->judul}}</h5>
                    </div>
                </div>

                <div class="box-curiculum">
                    <ul class="list-curiculum">
                    @foreach ($data['materiByMata'] as $key => $materi)
                        <li class="item-curiculum">
                            <div class="title-curiculum" data-toggle="collapse" data-target="#curiculum-{{ $key }}">
                                <i class="las la-angle-down"></i>
                                <h5>{{$materi->judul}}</h5>
                                {{-- <span class="meta sum"></span> --}}
                            </div>
                            <ul class="section-course collapse" id="curiculum-{{ $key }}" aria-expanded="false">
                                @foreach ($materi->bahanPublish as $bahan)
                                
                                <li class="item-course">
                                    <a href="{{ route('course.MateriBahan', ['id' => $data['mata']->id, 'bahanId' => $bahan->id, 'tipe' => $bahan->type($bahan)['tipe']]) }}" class="title-course" 
                                        @if ($bahan->completion_type > 0)
                                            @if ($bahan->activityCompletionByUser()->count() == 1 && !empty($bahan->activityCompletionByUser->track_end))
                                                @if ($bahan->activityCompletionByUser->status == 1)
                                                 title="read"
                                                @else
                                                 title="unread"
                                                @endif
                                            @else
                                            
                                            @endif
                                        @endif
                                       >
                                        @if ($bahan->type($bahan)['tipe'] == 'dokumen')
                                        <i class="las la-file-{{ $bahan->dokumen->bankData->icon($bahan->dokumen->bankData->file_type) }} mr-2"></i>
                                        @elseif ($bahan->type($bahan)['tipe'] == 'video')
                                            @if (!empty($bahan->video->bankData->thumbnail))
                                                <div class="d-block ui-rect-67 ui-bg-cover" style="background-image: url({{ route('bank.data.stream', ['path' => $bahan->video->bankData->thumbnail]) }});"></div>
                                            @else
                                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2"></i>
                                            @endif
                                        @else
                                         <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2"></i>
                                        @endif
                                        
                                        <h6>{!! $bahan->judul !!}</h6>
                                        <span class="meta course-status" title="unread"></span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                     @endforeach
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div class="container">
              
                    <div class="box-content mt-3">
                         <h5 class="card-header-title mt-1 mb-0">{!! $data['bahan']->judul !!}</h5>
                         <hr>
                         <br>
                       @yield('content')
                         <article>
                            {!! $data['bahan']->keterangan !!}
                        </article>
                    </div>
                    <div class="nav-content">
                        <div class="nav-btn prev">
                            @if ($data['bahan']->urutan > 1)
                            @foreach ($data['prev'] as $prev)
                            {{-- <a href="" class="btn btn-secondary" title="klik untuk ke materi sebelumnya"><i class="las la-arrow-left"></i> Sebelumnya</a> --}}
                            <a href="{{ route('course.MateriBahan', ['id' => $prev->mata_id, 'bahanId' => $prev->id, 'tipe' => $prev->type($prev)['tipe']]) }}">
                                <i class="las la-arrow-left"></i>
                                <span>Prev</span>
                            </a>
                            @endforeach
                            @else
                            <a href="#">
                                <i class="las la-arrow-left"></i>
                                <span>Prev</span>
                            </a>
                            @endif
                        </div>
                        @role('peserta_internal|peserta_mitra')
                            @if (empty($data['bahan']->activityCompletionByUser->track_end) && $data['bahan']->completion_type == 1 || empty($data['bahan']->activityCompletionByUser->track_end) && $data['bahan']->completion_type == 3)

                            <button id="show-complete" style="padding: 10px 15px" class="btn btn-primary btn-sm icon-btn-only-sm complete" title="klik untuk konfirmasi telah menyelesaikan materi">

                                <span>Complete</span> <i class="las la-check ml-2"></i>
                                <form action="{{ route('activity.complete', ['bahanId' => $data['bahan']->id])}}" method="POST" class="form-complete">
                                    @csrf
                                </form>
                            </button>
                            @endif
                        @endrole
                        <div class="nav-btn next">
                            @if ($data['bahan']->urutan < $data['materi']->bahan()->count())
                            @foreach ($data['next'] as $next)
                            <a href="{{ route('course.MateriBahan', ['id' => $next->mata_id, 'bahanId' => $next->id, 'tipe' => $next->type($next)['tipe']]) }}">
                                <span>Next</span>
                                <i class="las la-arrow-right"></i>
                            </a>
                            @endforeach
                            @else
                            <a href="#">
                                <span>Next</span>
                                <i class="las la-arrow-right"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@include('components.modalWarning')

    <!-- jQuery.min.js -->
    <script src="{{asset('assets/roomCourse/js/jquery.min.js')}}"></script>
    
    <!-- jQuery Global-->
    <script src="{{asset('assets/roomCourse/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('.toggle-sn').click(function() {
			isToggle();
		});

		function isToggle() {
			$('.toggle-sn').toggleClass('is-actived');
			$('.box-wrap').toggleClass('is-hidden');
		}
        $('.complete').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin sudah menyelesaikan materi ini ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, sudah!',
        cancelButtonText: "Tidak, belum",
        }).then((result) => {
            if (result.value) {
                $(".form-complete").submit();
            }
        })
    });

    var session = "{{session()->has('warning')}}";
    if (session) {
        $('#myModal').modal('show');
    }
    
     $('.jump').on('change', function () {

        var id = $(this).attr('data-mataid');
        var bahanId = $(this).val();
        var tipe = $('option:selected', this).attr('data-tipe');

        if (id) {
            window.location = '/course/' + id + '/bahan/' + bahanId + '/' + tipe;
        }
        return false;
    });
    </script>
    @if ($data['bahan']->completion_type == 2)
    <script>
        $( document ).ready(function() {
            $.ajax({
                type : "POST",
                url : "/activity/{{ $data['bahan']->id }}/complete?is_ajax=yes",
            });
        });
    </script>
    @endif
    @if ($data['bahan']->completion_type == 3)
@if (now() > $data['timer'])
<script>
    $("#show-complete").show();
</script>
@else
<script>
    $("#show-complete").hide();
    var timer2 = "{{ $data['countdown'] }}";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) {
            $("#show-complete").show();
            clearInterval(interval);
        }

    }, 1000);
</script>
@endif
@endif
</body>
</html>
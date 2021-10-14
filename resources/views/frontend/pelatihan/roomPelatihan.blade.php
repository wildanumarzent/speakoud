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

</head>
<body>
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
            {{-- <div class="box-breadcrumb">
                <ul class="list-breadcrumb">
                    <li class="item-breadcrumb">
                        <a href="">
                            <span>Course</span>
                        </a>
                    </li>
                    <li class="item-breadcrumb">
                        <a href="">
                            <span>Sistem Management Mutu</span>
                        </a>
                    </li>
                    <li class="item-breadcrumb">
                        <span>ISO 9001:2015 Managemen Mutu</span>
                    </li>
                </ul>
                <div class="title-heading mt-3">
                    <h6>ISO 9001:2015 Managemen Mutu</h6>
                </div>
            </div> --}}
            <div class="box-curiculum">
                <ul class="list-curiculum">
                @foreach ($data['materi'] as $key => $materi)
                    <li class="item-curiculum">
                        <div class="title-curiculum" data-toggle="collapse" data-target="#curiculum-{{ $key }}">
                            <i class="las la-angle-down"></i>
                            <h5>{{$materi->judul}}</h5>
                            <span class="meta sum">{{count($data['materi'])}}</span>
                        </div>
                        <ul class="section-course collapse" id="curiculum-{{ $key }}" aria-expanded="false">
                            @foreach ($materi->bahanPublish as $bahan)
                           
                            <li class="item-course">
                                <a href="{{ route('course.MateriBahan', ['id' => $data['read']->id, 'bahanId' => $bahan->id, 'tipe' => $bahan->type($bahan)['tipe']]) }}" class="title-course"
                                     @role ('peserta_internal|peserta_mitra|instruktur_internal')
                                    @if ($bahan->completion_type > 0)
                                        @if ($bahan->activityCompletionByUser()->count() == 1 && !empty($bahan->activityCompletionByUser->track_end))
                                            @if ($bahan->activityCompletionByUser->status == 1)
                                            title="read"
                                            @else
                                             title="unread"
                                            @endif                                
                                        @endif
                                    @endif
                                    @endrole
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
                                    <span class="meta course-status" title="read"></span>
                                    
                                    {{-- @role ('peserta_internal|peserta_mitra|instruktur_internal')
                                    @if ($bahan->completion_type > 0)
                                        @if ($bahan->activityCompletionByUser()->count() == 1 && !empty($bahan->activityCompletionByUser->track_end))
                                            @if ($bahan->activityCompletionByUser->status == 1)
                                            <span class="meta course-status" title="read"></span>
                                            @else
                                            <span class="meta course-status" title="unread"></span>
                                            @endif
                                        @else
                                        
                                        @endif
                                    @endif
                                    @endrole --}}
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
                <div class="box-content">
                    
                    <article>
                        {!! $data['read']->content !!}
                    </article>
                </div>
                <div class="nav-content">
                    <div class="nav-btn prev">
                        <a href="">
                            <i class="las la-arrow-left"></i>
                            <span>Prev</span>
                        </a>
                    </div>
                    <div class="nav-btn next">
                        <a href="">
                            <span>Next</span>
                            <i class="las la-arrow-right"></i>
                        </a>
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
    <script>
        $('.toggle-sn').click(function() {
			isToggle();
		});

		function isToggle() {
			$('.toggle-sn').toggleClass('is-actived');
			$('.box-wrap').toggleClass('is-hidden');
		}

        
    var session = "{{session()->has('warning')}}";
    if (session) {
        $('#myModal').modal('show');
    }
    </script>
</body>
</html>
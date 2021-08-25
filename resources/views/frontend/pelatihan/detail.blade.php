@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1 style="color:white">DETAIL COURSE</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap bg-grey-alt">
    <div class="container-fluid flex-grow-1 container-p-y">
        <h1 class="mb-3"><strong>{{ $data['mata']->judul}}</strong></h1>
        <div class="row">

            <div class="col-md-3">
                <div class="media mb-3">
                    <img src="{{ $data['mata']->creator->photo['filename'] != null ? asset('/userfile/photo'.$data['mata']->creator->photo['filename'] != null) : asset('assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
                    <div class="media-body pt-2 ml-3">
                        <h6 class="mb-2"> <strong style="color: grey">Teacher</strong></h6>
                        <h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->creator->name}}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
            <div class="col-md-3">
                <div class="media mb-3">
                    <div class="media-body pt-2 ml-3">
                        <h6 class="mb-2"><strong style="color: grey">Categories</strong></h6>
                        <h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->program->judul}}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
            <div class="col-md-3">
                <div class="media mb-3">
                    <div class="media-body pt-2 ml-3">
                        <h6 class="mb-2"><strong style="color: grey">Review</strong></h6>
                                
                        @foreach ($data['numberRating'] as $i)
                            <i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.2em;"></i>
                        @endforeach

                        <strong style="color: black"> ( {{ $data['mata']->getRating('student_rating') }} REVIEW)</strong>
                    </div>
                </div>
            </div>
            <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
            <div class="col-md-2">
                <div class="media mb-3">
                    <div class="media-body pt-2 ml-3">
                        <h3 class="mb-2" style="color: rgb(0, 255, 21)"> <strong>Free</strong> 
                            @if (auth()->user() != null)
                                @if ( $data['peserta']->status_peserta == 1)
                                <a href="{{ route('pelatihan.mata', ['id' => $data['mata']->id]) }}" class="btn btn-warning">START</a>
                                @else   
                                <a href="{{ route('profile.front',['id'=> $data['mata']->id]) }}" class="btn btn-warning">START</a>
                                @endif
                            @else 
                                <a href="javascript:void(0)" class="btn btn-warning">MORE INFO</a>
                            @endif
                         </h3>
                    </div>
                </div>
            </div>
            </div>
           <br>

            <ul class="search-nav nav nav-tabs tabs-alt container-m-nx container-p-x mb-4">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#search-pages"><h6><i class="ion ion-md-copy" style="color: orange"></i>&nbsp; <strong>Overview</strong> </h6></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-people"><h6><i class="ion ion-logo-dropbox" style="color: orange"></i>&nbsp; <strong>Curriculum</strong> </h6></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-images"><h6><i class="ion ion-ios-person" style="color: orange"></i>&nbsp; <strong>Instructor</strong> </h6></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-videos"><h6><i class="ion ion-ios-chatbubbles" style="color: orange"></i>&nbsp; <strong>Reviews</strong> </h6></a>
              </li>
            </ul>

            <div class="tab-content">
              <!-- overview -->
              <div class="tab-pane fade show active" id="search-pages">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="ui-bordered">
                                    <div class="p-4">
                                        {!! $data['mata']->program->keterangan !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-md-4 pt-0">
                        <div class="container">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 79px"><i class="fas fa-question" style="color: orange"></i> Quizzes</h6></th>
                                    <th><h6><strong>{{count($data['mata']->quiz)}}</strong></h6></th>   
                                </tr>
                            </table>
                            <hr style="color: orange">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 63px"><i class="far fa-file-alt" style="color: orange"></i> Certificate</h6></th>
                                    <th><h6><strong>No</strong></h6></th>     
                                </tr>
                            </table>
                            <hr style="color: orange">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 41px"><i class="fas fa-check-circle" style="color: orange"></i> Assessments</h6></th>
                                    <th><h6><strong>yes</strong></strong></h6></th>     
                                </tr>
                            </table>
                            <hr style="color: orange">
                           <table class="table-responsive mt-3">
                                <tr>
                                   <th><h6 style="padding-right: 66px"><i class="fas fa-users" style="color: orange"></i> Students</h6></th>
                                    <th><h6><strong>{{$data['mata']->peserta->count()}}</strong></h6></th>       
                                </tr>
                            </table>
                            <hr style="color: orange">
                             <table class="table-responsive mt-3">
                                <tr>
                                     <th><h6 style="padding-right: 70px"><i class="far fa-clock" style="color: orange"></i> Duration</h6></th>
                                    <th><h6><strong>{{$data['duration']->days}} days</strong></h6></th>        
                                </tr>
                            </table>
                            <hr style="color: orange">
                        </div>
                    </div>
                </div>
              </div>
              <!-- / overview -->

              <!-- curiculum -->
            <div class="tab-pane fade" id="search-people">
                <div class="row">
                    <div class="col-md-10">
                        <div class="theme-bg-white ui-bordered mb-2">
                            <a href="#company-faq-1" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                                <h5>{{$data['mata']->judul}}</h1>
                                <span class="collapse-icon"><h5 style="color: orange; font-weight: bold">{{count($data['mata']->materi)}}</h3></span>
                            </a>
                            <h3></h3>
                            <div id="company-faq-1" class="collapse text-muted">
                                @foreach ($data['mata']->materi as $key => $item)
                                <div class="card-body py-6">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col"> <a href="#company-faq-{{$key + $key}}"><h5><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.{{$key+1}}</strong></h5></a> </div>
                                            <div class="d-none d-md-block col-10">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-sm-11">
                                                        <div class="theme-bg-white ui-bordered mb-2">
                                                                <a href="#company-faq-{{$key +$key}}" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                                                                <h6>{{$item->judul}}</h6>
                                                                <span class="collapse-icon"><h3 style="color: orange; font-weight: bold"></h3></span>
                                                            </a>
                                                            <h3></h3>
                                                            <div id="company-faq-{{$key+$key}}" class="collapse text-muted">
                                                                <div class="card-body py-6">
                                                                     @foreach ($item->bahanPublish as $bahan)
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
                                                                                        {{-- @role ('peserta_internal|peserta_mitra') --}}
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
                                                                                        {{-- @endrole  --}}
                                                                                        <a href="javascript:;" class="text-body">{!! $bahan->judul !!}</a>&nbsp;
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
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="col-1"><h3><i class="fas fa-lock" style="color: orange"></i></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <!-- / curiculum -->

              <!-- instructor -->
              <div class="tab-pane fade" id="search-images">
                     <!-- Header -->
                    <div class="container-m-nx container-m-ny theme-bg-white mb-4">
                    <div class="media col-md-10 col-lg-8 col-xl-7 py-5 mx-auto">
                      <img src="{{ $data['mata']->creator->photo['filename'] != null ? asset('/userfile/photo'.$data['mata']->creator->photo['filename'] != null) : asset('assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
                         <div class="media-body pt-2 ml-3">
                            <h6 class="mb-2"> <strong style="color: grey">Teacher</strong></h6>
                            <h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->creator->name}}</strong></h6>
                        </div>
                    </div>
                    <hr class="m-0">
                    </div>
              </div>
              <!-- / instructor -->

              <!-- Reviews -->
            <div class="tab-pane fade" id="search-videos">
                @if ($data['mata']->show_feedback == 1)
                    <div class="row">
                        <div class="container">
                            <div class="card mb-4">
                                <h6 class="card-header with-elements">
                                    <span class="card-header-title"> Rating</span>
                                </h6>
                                <div class="card-body">
                                    @foreach ($data['numberProgress'] as $i)
                                    <div class="progress-course mb-4">
                                        <div class="progress">
                                            <span class="badge badge-warning mr-3"> {{ $i }} </span>
                                            <div class="progress-bar" style="width: {{ $data['mata']->rating->count() > 0 ? round(($data['mata']->getRating('per_rating', $i) / $data['mata']->getRating('student_rating')) * 100) : 0 }}%;">
                                                {{ $data['mata']->rating->count() > 0 ? round(($data['mata']->getRating('per_rating', $i) / $data['mata']->getRating('student_rating')) * 100) : 0 }}%
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-center text-muted">
                                        <h3 class="badge badge-primary" style="font-size: 20px;">
                                            {{ $data['mata']->rating->count() > 0 ? round($data['mata']->getRating('review'), 2) : 0 }}
                                        </h3><br>
                                        {{ $data['mata']->getRating('student_rating') }} Rating Peserta
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="small text-center">
                                        @role ('peserta_internal|peserta_mitra')
                                        <select id="rating" name="rating" class="mb-2">
                                            <option value="" ></option>
                                            @for ($i = 1; $i < 6; $i++)
                                            <option value="{{ $i }}" {{ $data['mata']->ratingByUser()->count() > 0 ? ($data['mata']->ratingByUser->rating == $i ? 'selected' : '') : 0 }}>1</option>
                                            @endfor
                                        </select>
                                        @else
                                        @if ($data['mata']->rating->count() > 0)
                                        @foreach ($data['numberRating'] as $i)
                                            <i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.8em;"></i>
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
                        </div>
                    </div>
                @endif
                {{-- <div class="row">
                    @if ($data['mata']->show_feedback == 1)
                        <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h1 style="text-align: center; color: orange; font-size: 200px; font-weight: bold"> {{ $data['mata']->getRating('student_rating') }}</h1>
                                    <div class="ui-star filled" style="text-align: center;font-size: 50px; color: orange">
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                    </div>
                                    <h3 style="text-align: center" >  {{ $data['mata']->rating->count() > 0 ? round($data['mata']->getRating('review'), 2) : 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <!-- Side info -->
                        <div class="card mb-4">
                        <hr class="border-light m-0">
                        <div class="card-body">
                        @foreach ($data['numberProgress'] as $i)
                        <div class="progress-course mb-4">
                            <div class="progress">
                                <span class="badge badge-warning mr-3" style="font-size: 20px"> {{$i}}</span>
                                <div class="progress-bar" style="width: 5000px;">
                                    {{ $data['mata']->rating->count() > 0 ? round(($data['mata']->getRating('per_rating', $i) / $data['mata']->getRating('student_rating')) * 100) : 0 }}%
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <hr class="border-light m-0">
                        </div>
                        <!-- / Side info -->
                        </div>
                        <!-- / Search -->
                    </div>
                    @endif
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

{{-- <div class="tab-pane fade" id="search-people">
    <div class="row">
        <div class="col-md-10">
            <div class="theme-bg-white ui-bordered shadow">
                <a href="#company-faq-1" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                    <h5>{{$data['mata']->judul}}</h1>
                    <span class="collapse-icon"><h5 style="color: orange; font-weight: bold">{{count($data['mata']->materi)}}</h3></span>
                </a>
                <div id="company-faq-1" class="collapse text-muted">
                    @foreach ($data['mata']->materi as $key => $item)
                    <div class="card-body py-6">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md">
                                <div class="theme-bg-white ui-bordered mb-2">
                                <a href="#company-faq-{{$key + 2}}" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                                   <h5><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.{{$key+1}}</strong> {{$item->judul}}</h5>
                                </a>
                                <div id="company-faq-{{$key + 2}}" class="collapse text-muted">
                                    @foreach ($item->bahanPublish as $bahan)
                                        <div class="card-body py-3 mb-2" style="margin-left:50px ">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-1">
                                                    <a href="javascript:void(0)" class="text-big font-weight-semibold">
                                                        @if ($bahan->type($bahan)['tipe'] == 'dokumen')
                                                        <i class="las la-file-{{ $bahan->dokumen->bankData->icon($bahan->dokumen->bankData->file_type) }} mr-2" style="font-size: 3em; color:orange"></i>  
                                                        @elseif ($bahan->type($bahan)['tipe'] == 'video')
                                                            @if (!empty($bahan->video->bankData->thumbnail))
                                                                <div class="d-block ui-rect-67 ui-bg-cover" style="background-image: url({{ route('bank.data.stream', ['path' => $bahan->video->bankData->thumbnail]) }});"></div>
                                                            @else
                                                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 3em; color:orange"></i>
                                                            @endif
                                                        @else
                                                        <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 3em; color:orange"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="d-none d-md-block col-11">

                                                    <div class="row no-gutters align-items-center">
                                                    <div class="col-11"><h6>{{$bahan->judul}}</h6></div>
                                                    <div class="media col-1 align-items-center">
                                                        <div class="media-body flex-truncate ml-2">
                                                            test
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- People -->
<div class="tab-pane fade" id="search-people">
    <div class="row">
        <div class="col-md-10">
             <div class="theme-bg-white ui-bordered shadow">
                <a href="#company-faq-1" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                    <h5>{{$data['mata']->judul}}</h1>
                    <span class="collapse-icon"><h5 style="color: orange; font-weight: bold">{{count($data['mata']->materi)}}</h3></span>
                </a>
                <div id="company-faq-1" class="collapse text-muted">
                    @foreach ($data['mata']->materi as $key => $item)
                    <div class="card-body py-6">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md">
                                <div class="theme-bg-white ui-bordered mb-2">
                                <a href="#company-faq-{{$key + 2}}" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                                   <h5><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.{{$key+1}}</strong> {{$item->judul}}</h5>
                                </a>
                                <div id="company-faq-{{$key + 2}}" class="collapse text-muted">
                                    @foreach ($item->bahanPublish as $bahan)
                                        <div class="card-body py-3 mb-2" style="margin-left:50px ">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-1">
                                                    <a href="javascript:void(0)" class="text-big font-weight-semibold">
                                                        @if ($bahan->type($bahan)['tipe'] == 'dokumen')
                                                        <i class="las la-file-{{ $bahan->dokumen->bankData->icon($bahan->dokumen->bankData->file_type) }} mr-2" style="font-size: 3em; color:orange"></i>  
                                                        @elseif ($bahan->type($bahan)['tipe'] == 'video')
                                                            @if (!empty($bahan->video->bankData->thumbnail))
                                                                <div class="d-block ui-rect-67 ui-bg-cover" style="background-image: url({{ route('bank.data.stream', ['path' => $bahan->video->bankData->thumbnail]) }});"></div>
                                                            @else
                                                                <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 3em; color:orange"></i>
                                                            @endif
                                                        @else
                                                        <i class="las la-{{ $bahan->type($bahan)['icon'] }} mr-2" style="font-size: 3em; color:orange"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="d-none d-md-block col-11">

                                                    <div class="row no-gutters align-items-center">
                                                    <div class="col-11"><h6>{{$bahan->judul}}</h6></div>
                                                    <div class="media col-1 align-items-center">
                                                        <div class="media-body flex-truncate ml-2">
                                                            test
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach 
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
             </div>
        </div>
    </div>
</div>
<!-- / People -->

<!-- Kurikulum -->
<div class="tab-pane fade" id="search-people">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach ($data['mata']->materi as $key => $item)
            <div class="item-curiculum">
                <a href="#company-faq-{{$key + 2}}" class="title-curiculum" data-toggle="collapse">
                    <h6 class="mr-auto mb-0"><strong> {{$item->judul}}</strong></h6>
                    <i class="las la-chevron-circle-down"></i>
                </a>
                <div id="company-faq-{{$key + 2}}" class="collapse sublist-curiculum" data-parent="#search-people">
                    @foreach ($item->bahanPublish as $bahan)
                        <div class="card-body px-0">
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
                                        <div class="media-body flex-truncate ml-2" style="color: orange">
                                            <h6><i class="fas fa-lock"></i></h6>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- / People -->

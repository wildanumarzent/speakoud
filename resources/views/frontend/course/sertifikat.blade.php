@if (auth()->user()->hasRole('peserta_internal|peserta_mitra'))
    @if (!empty($data['read']->sertifikatInternal) || $data['read']->sertifikatExternalByUser->count() > 0)
    <hr class="mt-4 mb-4">
    <h6 class="font-weight-semibold mb-4">Sertifikat</h6>
        @if (!empty($data['read']->sertifikatInternal))
        <div class="card mb-2">
            <div class="card-header">
                <a class="collapsed text-body" data-toggle="collapse" href="#sertifikat-internal">
                    <i class="las la-thumbtack"></i> Sertifikat Internal
                </a>
            </div>
            <div id="sertifikat-internal" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group list-group-flush mt-2">
                        <li class="list-group-item py-4">
                            <div class="media flex-wrap">
                                <div class="d-none d-sm-block ui-w-120 text-center">
                                    <i class="las la-certificate text-success mr-2" style="font-size: 4em;"></i>
                                </div>
                                <div class="media-body ml-sm-2">
                                    <h5 class="mb-2">
                                        <div class="float-right font-weight-semibold ml-3">
                                            @if ($data['read']->sertifikatPeserta($data['read']->sertifikatInternal->id)->count() == 0)
                                            <a href="javascript:;" onclick="$('#form-cetak').submit();">
                                                <i class="las la-print text-primary" style="font-size: 2em;" title="cetak sertifikat"></i>
                                                <form action="{{ route('sertifikat.internal.cetak', ['id' => $data['read']->id, 'sertifikatId' => $data['read']->sertifikatInternal->id]) }}" method="POST" id="form-cetak">
                                                    @csrf
                                                </form>
                                            </a>
                                            @else
                                            <a href="{{ route('bank.data.stream', ['path' => $data['read']->sertifikatPeserta->file_path]) }}"><i class="las la-download text-primary" style="font-size: 2em;" title="download sertifikat"></i></a>
                                            @endif
                                        </div>
                                        <a href="javascript:;" class="text-body">Sertifikat {{ $data['read']->judul }}</a>&nbsp;
                                    </h5>
                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                        <div class="text-muted small">
                                            <i class="las la-calendar text-primary"></i>
                                            <span>Tanggal Pengesahan : <strong>{{ $data['read']->sertifikatInternal->tanggal->format('d F Y') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
        @if ($data['read']->sertifikatExternalByUser->count() > 0)
        <div class="card mb-2">
            <div class="card-header">
                <a class="collapsed text-body" data-toggle="collapse" href="#sertifikat-external">
                    <i class="las la-thumbtack"></i> Sertifikat External
                </a>
            </div>
            <div id="sertifikat-external" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group list-group-flush mt-2">
                        @foreach ($data['read']->sertifikatExternalByUser as $exter)
                        <li class="list-group-item py-4">
                            <div class="media flex-wrap">
                                <div class="d-none d-sm-block ui-w-120 text-center">
                                    <i class="las la-certificate text-success mr-2" style="font-size: 4em;"></i>
                                </div>
                                <div class="media-body ml-sm-2">
                                    <h5 class="mb-2">
                                        <div class="float-right font-weight-semibold ml-3">
                                            <a href="{{ route('bank.data.stream', ['path' => $exter->sertifikat]) }}" target="_blank"><i class="las la-print text-primary" style="font-size: 2em;" title="cetak sertifikat"></i></a>
                                        </div>
                                        <a href="javascript:;" class="text-body">{{ collect(explode("/", $exter->sertifikat))->last() }}</a>&nbsp;
                                    </h5>
                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                        <div class="text-muted small">
                                            <i class="las la-calendar text-primary"></i>
                                            <span><strong>{{ $exter->created_at->format('d F Y H:i') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    @endif
@endif


<!-- Kurikulum -->
<div class="tab-pane fade show active" id="happening">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach ($data['jadwal'] as $item)
                <div class="card mb-3 shadow">
                    <div class="p-4 p-md-5 d-xl-flex justify-content-between align-items-center">
                        <div class="box-pertemuan">
                            <a href="{{route('detail.agenda',['id' => $item->id])}}" style="font-size: 30px; color:orange; font-weight: bold" class="text-body text-large font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!} </a>
                            <div class="d-flex flex-wrap mt-3">
                                <div class="mr-3"><i class="vacancy-tooltip las la-user text-light"></i>&nbsp; {{ $item->creator->name }}</div>
                                @if (!empty($item->mata_id))
                                <div class="mr-3" style="font-size: 30px"><i class="vacancy-tooltip las la-eye text-light"></i>&nbsp; {{ $item->mata->judul }}</div>
                                @endif
                                <div class="mr-3"><i class="vacancy-tooltip las la-map-pin text-light"></i>&nbsp; {{ $item->lokasi ?? '-' }}</div>
                            </div>
                            <hr class="">
                            <div class="mt-3 mb-4">
                                <div class="row">
                                    <div class="col-4 col-md-4">
                                        <span class="text-muted small">Tanggal Mulai :</span><br>
                                        <span><strong>{{ $item->start_date->format('d F Y') }}</strong></span>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <span class="text-muted small">Tanggal Selesai :</span><br>
                                        <span><strong>{{ $item->end_date->format('d F Y') }}</strong></span>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <span class="text-muted small">Jam :</span><br>
                                        <span><strong>{{ \Carbon\Carbon::parse($item->start_time)->format('H:i').' s/d '.\Carbon\Carbon::parse($item->end_time)->format('H:i') }}</strong></span>
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
<!-- / People -->

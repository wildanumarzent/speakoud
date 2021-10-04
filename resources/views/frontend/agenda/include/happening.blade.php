
<!-- Kurikulum -->
<div class="tab-pane fade show active" id="happening">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @foreach ($data['jadwal'] as $item)
                <div class="item-event">
                    <div class="box-event-left">
                        <div class="event-date">
                            <div class="event-dd">{{ $item->start_date->format('d') }}</div>
                            <div class="event-mm">{{ $item->start_date->format('M') }}</div>
                        </div>
                        <div class="event-title">
                            <a href="{{route('detail.agenda',['id' => $item->id])}}" title="{!! $item->judul !!}" class="title-heading">
                                <h3>
                                    {!! Str::limit($item->judul, 80) !!}
                                </h3>
                            </a>
                            <div class="d-flex flex-wrap">
                                <div class="point-event mr-3">
                                    <i class="las la-user"></i>
                                    <div class="data-event">{{ $item->creator->name }}</div>
                                </div>
                                @if (!empty($item->mata_id))
                                <div class="point-event">
                                    <i class="vacancy-tooltip las la-eye text-light"></i>
                                    <div class="data-event">{{ $item->mata->judul }}</div>
                                </div>
                                @endif
                                <div class="point-event">
                                <i class="las la-map-pin"></i>
                                    <div class="data-event">{{ $item->lokasi ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-event-right">
                        <div class="row">
                            <div class="col-6 col-lg-4">
                                <span class="text-muted">Tanggal Mulai :</span>
                                <div class="point-event">
                                   <i class="las la-calendar"></i>
                                    <div class="data-event">
                                        <strong>{{ $item->start_date->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <span class="text-muted">Tanggal Selesai :</span>
                                <div class="point-event">
                                   <i class="las la-calendar"></i>
                                    <div class="data-event">
                                    <strong>{{ $item->end_date->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <span class="text-muted">Pukul :</span>
                                <div class="point-event">
                                    <i class="las la-clock"></i>
                                    <div class="data-event">
                                    <strong>{{ \Carbon\Carbon::parse($item->start_time)->format('H:i').' s/d '.\Carbon\Carbon::parse($item->end_time)->format('H:i') }}</strong>
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

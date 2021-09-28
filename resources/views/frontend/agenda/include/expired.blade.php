<div class="tab-pane fade" id="expired">
    <div class="media col-md-12">
        @foreach ($data['expired'] as $item)
        <div class="card mb-3 shadow">
            <div class="card-body">
            <div class="media align-items-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                <a href="javascript:void(0)" class="text-relative text-primary "><i class="ion ion-ios-arrow-up"></i></a>
                <div class="text-xlarge font-weight-bolder" style="color: orange; font-size:35px">{{$item->start_date->format('d')}} <span style="color: orange; font-size:12px; margin-top: none"></div>
                    {{$item->start_date->format('F')}}</span>

                <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-down"></i></a>
                </div>
                <div class="media-body ml-4">
                <a href="javascript:void(0)" class="text-big" style="color: orange; font-size:24px; font-weight: bold">{{$item->judul}}</a>
                <div class="my-2">
                    {!! $item->keterangan !!}
                </div>
                <div class="small">
                    <span class="text-muted ml-3"><i class="ion ion-md-time text-lighter text-big align-middle"></i>&nbsp; {{$item->start_time}} - {{$item->end_time}}</span>
                </div>
                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

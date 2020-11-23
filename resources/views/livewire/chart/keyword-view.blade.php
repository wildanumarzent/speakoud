    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">Most Viewed Keywords</div>
        <div class="card-header-elements ml-auto">
            {{-- Header Element --}}
            {{-- <div class="btn-group mr-3">
            <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown" aria-expanded="false">
              <i class="ion ion-ios-more"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" id="sales-dropdown-menu" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 26px; left: 26px;">
              <a class="dropdown-item" href="javascript:void(0)">Action 1</a>
              <a class="dropdown-item" href="javascript:void(0)">Action 2</a>
            </div>
          </div> --}}

        </div>
      </h6>
      <div class="mt-3">
        <div style="height:200px;">
            <livewire:livewire-pie-chart
                :pie-chart-model="$chart"
            />
        </div>
      </div>
      <div class="card-footer text-center py-2">
        <div class="row">
          <div class="col">
            <div class="text-muted small">View Terbesar</div>
            <strong class="text-big">{{$max->viewer ?? 0}}</strong>
          </div>
          <div class="col">
            <div class="text-muted small">View Terendah</div>
            <strong class="text-big">{{$min->viewer ?? 0}}</strong>
          </div>
        </div>
      </div>
    </div>

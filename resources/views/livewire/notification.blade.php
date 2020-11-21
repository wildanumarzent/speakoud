<div class="demo-navbar-notifications nav-item dropdown mr-lg-3">
    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
      <i class="ion ion-md-notifications-outline navbar-icon align-middle"></i>
      <span class="badge badge-primary badge-dot indicator"></span>
      <span class="d-lg-none align-middle">&nbsp; Notifications</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        @if($notification->count() > 0)
      <div class="bg-primary text-center text-white font-weight-bold p-3">
        {{$notification->count()}} New Notifications
      </div>
      @endif
      @forelse($notification as $n)
      <div class="list-group list-group-flush">
        <a href="
        @switch($n->notifable_type)
        @case('App\Models\Artikel')
        {{route('artikel.list')}}
        @break
        @case('App\Models\Component\Announcement')
        {{route('announcement.show',['announcement' => $n->notifable_id])}}
        @default

        @break
        @endswitch
        " class="list-group-item list-group-item-action media d-flex align-items-center">
          {{-- <div class="ui-icon ui-icon-sm ion ion-md-home bg-secondary border-0 text-white"></div> --}}
          <div class="media-body line-height-condenced ml-3">
            <div class="text-body">{{$n->title}}</div>
            <div class="text-light small mt-1">
             {!!$n->description!!}
            </div>
            <div class="text-light small mt-1">{{$n->created_at->diffForhumans()}}</div>
          </div>
        </a>
      </div>
      @empty
      <div class="list-group list-group-flush">
        <a href="
        " class="list-group-item list-group-item-action media d-flex align-items-center">
          <div class="media-body line-height-condenced ml-3">
            <div class="text-light small mt-1">
             Notification is Empty
            </div>
          </div>
        </a>
      </div>
      @endforelse

      {{-- <a href="javascript:void(0)" class="d-block text-center text-light small p-2 my-1">Show all notifications</a> --}}
    </div>
  </div>

<style>
   .scrollable {
    max-height:430px;
    overflow-y: scroll;
}
.scrollable::-webkit-scrollbar {
  width: 5px;
}
/* Track */
.scrollable::-webkit-scrollbar-track {
  box-shadow: rgba(221,221,221,0.2);
  border-radius: 5px;
}

/* Handle */
.scrollable::-webkit-scrollbar-thumb {
  background:rgba(0,153,255,0.2);
  border-radius: 5px;
}
</style>
<div class="demo-navbar-notifications nav-item dropdown mr-lg-3" id="notif-bar">
  <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
      <i class="las la-bell navbar-icon align-middle"></i>
    @if($unread->count() > 0)
    <span class="badge badge-primary badge-dot indicator"></span>
    @endif
    <span class="d-lg-none align-middle">&nbsp; Notifikasi</span>
  </a>
  <div class="dropdown-menu dropdown-menu-right"  style="min-width:330px;">
    <div class="bg-primary text-center text-white font-weight-bold p-3">
        @if($unread->count() > 0)
        {{$unread->count()}} Notifikasi Baru
        @else
        Notifikasi
        @endif
      </div>

    <div class="scrollable">
      <div class="list-group list-group-flush">
        @forelse($notification as $n)
          <form action="{{route('notification.show',['id' => $n->id])}}" method="GET">
            <button
            type="submit"
            {{-- @if(isset($n->url))  type="submit" @else type="button" @endif --}}
            class="list-group-item list-group-item-action media d-flex align-items-center">
            <div class="ui-icon ui-icon-sm las la-bell bg-warning border-0 text-body"></div>
            <div class="media-body line-height-condenced ml-3">
                  <div class="text-body">
                    <div class="row">
                        <div class="col-10">
                            {{$n->title}}
                        </div>
                        {{-- <div class="col-2">
                            @foreach($unread as $u)
                            @if($u->id == $n->id)
                            <span class="badge badge-primary">baru</span>
                            @endif
                            @endforeach
                        </div> --}}
                    </div>


                </div>
                  <div class="text-light small mt-1">
                  {!!$n->description!!}
                  </div>
                  <div class="text-light small mt-1">{{$n->created_at->diffForhumans()}}</div>
                </div>
              </button>
          </form>
        @empty
          <a href="javascript:void(0)" class="list-group-item list-group-item-action media text-center">
            <i><strong style="color:red;">! Notifikasi kosong !</strong></i>
          </a>
        @endforelse
      </div>
    </div>
  </div>
</div>

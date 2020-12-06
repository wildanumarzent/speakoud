<h4 class="font-weight-bold py-3 mb-4">
    Comment
</h4>

@if($data['comment']->count() > 0)
@foreach($data['comment'] as $value)
<div class="card mb-3">
    <div class="card-body">
      <div class="media">
        @if(@$value->user->hasDokumen != null)
        <img src="{{asset('dokumen/foto_pegawai/'.$value->user->hasDokumen->foto_pegawai)}}" class="d-block ui-w-50 rounded-circle mt-1" style="width : 50px; height:50px;object-fit:cover">
        @endif
        <div class="media-body ml-4">
          <div class="float-right text-muted small">{{$value->created_at->diffForHumans()}}</div>
          @if(@$value->user->hasDataPersonal != null)
          <a href="javascript:void(0)">{{$value->user->hasDataPersonal->nama}}</a>
          @else
          <a href="javascript:void(0)">{{@$value->user->username}}</a>
          @endif
          <div class="mt-2">
            {!!$value->comment!!}
          </div>
          <div class="small mt-2">

          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  @endif

<form action="{{route('comment')}}" method="post">
    @csrf
    <input type="hidden" name="announcement_id" value="{{$data['artikel']->id}}">
    <input type="hidden" name="user_id" value="{{auth::id()}}">
    <input type="text" name="comment" id="" class="form-control" placeholder="Tulis Komentar..." required>
</form>

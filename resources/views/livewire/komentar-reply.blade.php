
<div class="collapse" id="reply-{{$komentarID}}">
    <form wire:submit.prevent="reply">
        <input type="hidden" name="commentID" wire:model="commentID" value={{$komentarID}} wire:ignore>
        <input type="text" name="replyData" wire:model="replyData" class="form-control" placeholder="Tulis Tanggapan...">
        </form>
    <div class="card card-body">

    @foreach($reply as $r)
     <p>{{$r->komentar}}</p>
     <small class="text-muted">{{$r->user->name}},{{$r->created_at->diffForhumans()}}</small>
     <hr>
    @endforeach
    </div>
  </div>

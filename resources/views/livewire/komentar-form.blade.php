<div class="box-comment">
    @if (auth()->guard()->check() == false)
    <div class="alert alert-primary text-center" role="alert" style="background-color: #d1e0ff; border: none">
        <a href="{{ route('login') }}" style="font-weight: 700; color: #064ad0">Login for Commet</a>
    </div>
    @else
    <form wire:submit.prevent="store">
        <div class="form-group">
            <input type="hidden" name="model" wire:model="model" value={{$model}}>
            <textarea class="form-control" name="comments" wire:model="comentdata" cols="30" rows="10" placeholder="Tulis Komentar..." required autofocus></textarea>
        </div>
        <div class="box-btn text-right">
            <button type="submit" class="btn btn-primary">Comment</button>
        </div>
    </form>
    @endif
</div>
<h5 class="mb-5">Comments :</h5>
<div class="list-comment">
    @forelse($list as $komentar)
    <div class="comment-item">
        <div class="comment-header">
            <div class="header-profile">
                <div class="img-user">
                    <div class="thumbnail-img">
                        <img src="{{ $komentar->user->getPhoto($komentar->user->photo['filename']) }}">
                    </div>
                </div>
                <div class="user-name">
                    <div class="name">{{$komentar->user->name}}</div>
                    <div class="header-info">{{ $komentar->created_at->diffForhumans() }}</div>
                </div>

            </div>

        </div>
        <div class="comment-body">
            <article>
                {!! $komentar->komentar !!}
            </article>
        </div>
    </div>
    @empty
    <h5 style="color: red;">! Belum ada komentar !</h5>
    @endforelse

</div>

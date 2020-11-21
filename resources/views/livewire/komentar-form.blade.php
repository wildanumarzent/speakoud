
        <div class="box-content mt-5">
            <h3>Comment</h3>
            <hr>
            <form wire:submit.prevent="store">
                <input type="hidden" name="model" wire:model="model" value={{$model}}>
                <input type="text" name="comments" wire:model="comentdata" class="form-control" placeholder="Tulis Komentar...">
            </form>
            <br>
            @forelse($list as $komentar)
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ $komentar->user->getPhoto($komentar->user->photo['filename']) }}" alt="userfoto" style="border-radius: 15px; width:70px;height:70px;object-fit:cover">
                        <label>{{$komentar->user->name}}</label>
                    </div>
                    <div class="col-md-10">
                       <p>{!!$komentar->komentar!!}</p>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                    <span class="text-muted">{{$komentar->created_at->diffForhumans()}}</span>
                    <a data-toggle="collapse" href="#reply-{{$komentar->id}}" role="button" aria-expanded="false" aria-controls="reply-1" class="text-right" style="float:right">Lihat Tanggapan</a>
                </div>

                @livewire('komentar-reply',['komentarID' => $komentar->id])
            </div>
            <br>
            @empty
            <h4>Tidak Ada Komentar</h4>
           @endforelse
        </div>

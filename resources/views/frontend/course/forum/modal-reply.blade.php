<div class="modal fade" id="form-reply">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('forum.topik.reply.store', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id, 'parent' => '']) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Reply
            <span class="font-weight-light">Diskusi</span>
            <br>
            {{-- <small class="text-muted">We need payment information to process your order.</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <input type="hidden" name="parent" id="parent">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Message</label>
              <textarea class="form-control tiny @error('message') is-invalid @enderror" name="message" placeholder="Masukan message...">{!! old('message') !!}</textarea>
              @include('components.field-error', ['field' => 'message'])
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col">
                <a id="advance" class="form-label"><i class="las la-edit"></i> Tampilkan lebih banyak</a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
</div>

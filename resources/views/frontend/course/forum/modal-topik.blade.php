<div class="modal fade" id="form-topik">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('forum.topik.store', ['id' => $data['bahan']->forum->id]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Topik</span>
            <br>
            {{-- <small class="text-muted">We need payment information to process your order.</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Subject</label>
              <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="masukan subject..." autofocus>
              @include('components.field-error', ['field' => 'subject'])
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Message</label>
              <textarea class="form-control tiny @error('message') is-invalid @enderror" name="message" placeholder="Masukan message...">{!! old('message') !!}</textarea>
              @include('components.field-error', ['field' => 'message'])
            </div>
          </div>
          @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Limit Reply</label>
              <input type="number" class="form-control @error('limit_reply') is-invalid @enderror" name="limit_reply" value="{{ old('limit_reply') }}" placeholder="masukan limit reply...">
              @include('components.field-error', ['field' => 'limit_reply'])
            </div>
          </div>
          @endif
          <div class="form-row">
            <div class="form-group col">
                <a href="{{ route('forum.topik.create', ['id' => $data['bahan']->forum->id]) }}" class="form-label"><i class="las la-edit"></i> Tampilkan lebih banyak</a>
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

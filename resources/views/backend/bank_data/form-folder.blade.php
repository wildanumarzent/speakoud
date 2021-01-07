<!-- Modal template -->
<div class="modal fade" id="modals-form-folder">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('bank.data.directory.store', ['path' => Request::get('path'), 'view' => Request::get('view')]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Folder</span>
            <br>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Nama Folder</label>
              <input type="text" class="form-control @error('directory') is-invalid @enderror" name="directory" value="{{ old('directory') }}" placeholder="Masukan nama folder">
              @include('components.field-error', ['field' => 'directory'])
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
</div>

<!-- Modal template -->
<div class="modal fade" id="modals-add-instruktur">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('mata.instruktur.store', ['id' => $data['mata']->id]) }}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Instruktur ke program</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Instruktur</label>
                    <select class="select2 show-tick @error('instruktur_id') is-invalid @enderror" name="instruktur_id[]" data-style="btn-default" multiple="multiple">
                        @foreach ($data['instruktur_list'] as $instruktur)
                            <option value="{{ $instruktur->id }}"> {{ strtoupper($instruktur->user['name']) }}</option>
                        @endforeach
                    </select>
                    @error('instruktur_id')
                    <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
</div>

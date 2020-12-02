<!-- Modal template -->
<div class="modal fade" id="modals-add-peserta">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('mata.peserta.store', ['id' => $data['mata']->id]) }}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Peserta ke program</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Peserta</label>
                    <select class="select2 show-tick @error('peserta_id') is-invalid @enderror" name="peserta_id[]" data-style="btn-default" multiple="multiple">
                        @foreach ($data['peserta_list'] as $peserta)
                            <option value="{{ $peserta->id }}"> {{ strtoupper($peserta->user['name']) }}</option>
                        @endforeach
                    </select>
                    @error('peserta_id')
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

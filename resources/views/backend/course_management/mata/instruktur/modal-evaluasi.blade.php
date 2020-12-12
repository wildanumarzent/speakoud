<!-- Modal template -->
<div class="modal fade" id="modals-evaluasi-form">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST" id="form-evaluasi">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Kode Evaluasi</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Instruktur</label>
                    <input type="text" class="form-control" id="name" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Kode Evaluasi</label>
                    <input type="text" class="form-control @error('kode_evaluasi') is-invalid @enderror" name="kode_evaluasi" id="kode_evaluasi" placeholder="Masukan kode evaluasi">
                    @include('components.field-error', ['field' => 'kode_evaluasi'])
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

<!-- Modal template -->
<div class="modal fade" id="modals-nilai-form">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST" id="form-nilai">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">
            Penilaian
            <span class="font-weight-light">WEBINAR</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Nilai</label>
                    <input type="number" class="form-control @error('nilai') is-invalid @enderror" name="nilai" max="100" id="nilai" placeholder="Masukan nilai">
                    @include('components.field-error', ['field' => 'nilai'])
                    <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" placeholder="Masukan catatan"></textarea>
                    @include('components.field-error', ['field' => 'catatan'])
                </div>
            </div>
            <div class="form-row">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="konfirmasi" value="1" id="konfirmasi">
                    <span class="custom-control-label ml-4">Konfirmasi</span>
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
</div>

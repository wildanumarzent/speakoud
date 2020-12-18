<!-- Modal template -->
<div class="modal fade" id="modals-upload">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST" id="form-upload" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Sertifikat</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="pesertaid" name="peserta_id" readonly>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Peserta</label>
                    <input type="text" class="form-control" id="name" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Sertifikat</label>
                    <label class="custom-file-label mt-2" for="file-0"></label>
                    <input type="file" class="form-control custom-file-input file @error('sertifikat') is-invalid @enderror" id="file-0" lang="en" name="sertifikat" value="browse...">
                    @error('sertifikat')
                        @include('components.field-error', ['field' => 'sertifikat'])
                    @else
                    <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.sertifikat.m')) }}</strong></small>
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

@if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['bahan']->tugas->responByUser))
<div class="modal fade" id="modals-upload-file">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('tugas.send', ['id' => $data['bahan']->tugas->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Upload
            <span class="font-weight-light">File Tugas</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body" style="max-height: 750px; overflow-y: scroll;">
            <div id="list">
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                        @include('components.field-error', ['field' => 'keterangan'])
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Files</label>
                            <label class="custom-file mt-3 mb-2">
                            <label class="custom-file-label mt-1" for="file-0"></label>
                            <input type="file" class="form-control custom-file-input file @error('files.0') is-invalid @enderror" type="file" id="file-0" lang="en" name="files[]" value="browse...">
                            @include('components.field-error', ['field' => 'files.0'])
                        </label>
                        <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.tugas.m')) }}</strong>, Max Upload : <strong>50 MB</strong></small>
                    </div>
                    <div class="col-md-1" id="add-files">
                        <button type="button" id="add" class="btn btn-success btn-sm icon-btn" title="tambah file lainnya"><i class="las la-plus"></i></button>
                    </div>
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
@endif

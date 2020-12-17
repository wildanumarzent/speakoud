<!-- Modal template -->
<div class="modal fade" id="modals-add-file">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('bank.data.files.store', ['path' => Request::get('path')]) }}" method="POST" enctype="multipart/form-data" id="form-edit-file">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">File</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">File</label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_video" value="1" id="show-thumb">
                            <span class="custom-control-label ml-4">Video</span>
                        </label>
                        <label class="custom-file mt-3">
                        <label class="custom-file-label mt-1" for="file-1"></label>
                        <input type="file" class="form-control custom-file-input file @error('file_path') is-invalid @enderror" type="file" id="file-1" lang="en" name="file_path" value="browse...">
                        @include('components.field-error', ['field' => 'file_path'])
                    </label>
                    <small>Tipe File : <strong>{{ strtoupper(config('addon.mimes.bank_data.m')) }}</strong>, Max Upload Size : {{ ini_get('upload_max_filesize') }}</small>
                </div>
            </div>
            <div class="form-row" id="thumbnail">
                <div class="form-group col">
                    <label class="form-label">Thumbnail</label>
                        <label class="custom-file mt-3">
                        <label class="custom-file-label mt-1" for="file-2"></label>
                        <input type="file" class="form-control custom-file-input file @error('thumbnail') is-invalid @enderror" type="file" id="file-2" lang="en" name="thumbnail" value="browse...">
                        @include('components.field-error', ['field' => 'thumbnail'])
                    </label>
                    <small>Tipe File : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong>, Max Upload Size : {{ ini_get('upload_max_filesize') }}</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Filename</label>
                    <input type="text" class="form-control @error('filename') is-invalid @enderror" name="filename" value="{{ old('filename') }}" placeholder="Masukan nama file">
                    @include('components.field-error', ['field' => 'filename'])
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
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

<script>
$("#thumbnail").hide();
$('#show-thumb').click(function() {
    if ($(this).val() == 1) {
        $('#thumbnail').toggle('slow');
    } else {
        $('#thumbnail').hide();
    }
});
</script>

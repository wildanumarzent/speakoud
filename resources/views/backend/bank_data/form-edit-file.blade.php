<!-- Modal template -->
<div class="modal fade" id="modals-edit-file">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST" enctype="multipart/form-data" id="form-edit-file">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">
            Edit
            <span class="font-weight-light">Data File</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row" id="form-thumbnail">
                <div class="form-group col">
                    <label class="form-label">Thumbnail</label>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="custom-file mt-3">
                            <label class="custom-file-label mt-1" for="file-1"></label>
                            <input type="hidden" name="old_thumbnail" id="thumbnail">
                            <input type="file" class="form-control custom-file-input file @error('thumbnail') is-invalid @enderror" ype="file" id="file-1" lang="en" name="thumbnail" value="browse...">
                            @include('components.field-error', ['field' => 'thumbnail'])
                        </div>
                        <div class="col-md-7">
                            <a href="javascript:;" id="show-thumb"><small class="text-muted">Current thumbnail</small></a><br>
                            <img id="thumb" class="old-thumb" style="width: 120px;">
                        </div>
                    </div>
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Filename</label>
                    <input type="text" class="form-control @error('filename') is-invalid @enderror" name="filename" id="filename" placeholder="Masukan nama file">
                    @include('components.field-error', ['field' => 'filename'])
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="Masukan keterangan" id="keterangan"></textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
        </form>
    </div>
</div>

<script>
    $('.old-thumb').hide();
    $('#show-thumb').click(function() {
        $('.old-thumb').toggle('slow');
    });
</script>

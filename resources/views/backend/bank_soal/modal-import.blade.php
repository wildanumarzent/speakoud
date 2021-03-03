<div class="modal fade" id="modals-import">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('soal.import', ['id' => $data['kategori']->mata_id, 'kategoriId' => $data['kategori']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Import
            <span class="font-weight-light">Soal</span>
            <br>
            {{-- <small class="text-muted">We need payment information to process your order.</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
        </div>
        <div class="modal-body">
            {{-- <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Pastikan penulisan soal <strong>sudah tersedia di aplikasi & belum tersedia di enroll program ini</strong>
            </div> --}}
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">File</label>
              <label class="custom-file-label" for="file-1"></label>
              <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="file-1" lang="en" name="file">
              @include('components.field-error', ['field' => 'file'])
              <small class="text-muted">Tipe File : <strong>XLS, XLSX</strong></small><br>
              <a href="{{ url('userfile/excel/soal.xlsx') }}" class="btn btn-sm btn-outline-success mt-3"><i class="las la-file-excel mr-2"></i> Download Contoh file Excel</small></a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" title="klik untuk menutup">Tutup</button>
            <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">Simpan</button>
        </div>
      </form>
    </div>
</div>

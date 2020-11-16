
<div class="modal fade" id="modals-tags">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Tags
            <span class="font-weight-light" id="nama"></span>
            <br>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col">
              <label class="form-label">Keterangan</label>
              <textarea class="form-control @error('keterangan') is-invalid @enderror tiny" rows="3" name="keterangan">{{ old('keterangan') }}</textarea>
              @include('components.field-error', ['field' => 'keterangan'])
            </div>
            </div>
            <div class="form-row">
                <fieldset class="form-group col">
                    <div class="row">
                      <label class="col-form-label col-sm-2 text-sm-right pt-sm-0 ml-2">Standar</label>
                      <div class="col-sm-5">
                        <div class="custom-controls-stacked">
                          <label class="custom-control custom-radio">
                            <input name="standar" type="radio" class="custom-control-input" checked="">
                            <span class="custom-control-label">Ya</span>
                          </label>
                          <label class="custom-control custom-radio">
                            <input name="standar" type="radio" class="custom-control-input">
                            <span class="custom-control-label">Tidak</span>
                          </label>
                        </div>
                      </div>
                      @include('components.field-error', ['field' => 'standar'])
                    </div>
                  </fieldset>

              <fieldset class="form-group col">
                <div class="row">
                  <label class="col-form-label col-sm-2 text-sm-right pt-sm-0">Pantas</label>
                  <div class="col-sm-5">
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-radio">
                        <input name="pantas" type="radio" class="custom-control-input" checked="">
                        <span class="custom-control-label">Ya</span>
                      </label>
                      <label class="custom-control custom-radio">
                        <input name="pantas" type="radio" class="custom-control-input">
                        <span class="custom-control-label">Tidak</span>
                      </label>
                    </div>
                  </div>
                  @include('components.field-error', ['field' => 'pantas'])
                </div>
              </fieldset>
            </div>

            <div class="form-row">
            <div class="form-group col">
                <label class="form-label">Related</label>
                <textarea class="form-control @error('related') is-invalid @enderror" rows="3" name="related">{{ old('related') }}</textarea>
                @include('components.field-error', ['field' => 'related'])
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

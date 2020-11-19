@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Tags
    </h6>
    <form class="modal-content" action="{{ route('tags.update') }}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$data['tags']->id}}">

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
              <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan" id="keterangan">{!!$data['tags']->keterangan!!}</textarea>
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
                            <input name="standar" type="radio" class="custom-control-input" value="1" @if($data['tags']->standar == 1) checked="true" @endif>
                            <span class="custom-control-label">Ya</span>
                          </label>
                          <label class="custom-control custom-radio">
                            <input name="standar" type="radio" class="custom-control-input" value="0" @if($data['tags']->standar == 0) checked="true" @endif>
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
                        <input name="pantas" type="radio" class="custom-control-input" value="1" @if($data['tags']->pantas == 1) checked="true" @endif>
                        <span class="custom-control-label">Ya</span>
                      </label>
                      <label class="custom-control custom-radio">
                        <input name="pantas" type="radio" class="custom-control-input" value="0" @if($data['tags']->pantas == 0) checked="true" @endif>
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
                <textarea class=" form-control @error('related') is-invalid @enderror" rows="3" name="related">{{ $data['tags']->related }}</textarea>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
// Bootstrap Tagsinput
$(function() {

  $('#tags').tagsinput({ tagClass: 'badge badge-primary' });
});
</script>
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Bahan Pelatihan <strong>---> "{{ strtoupper(Request::get('type')) }}"</strong>
    </h6>
    <form action="{{ !isset($data['bahan']) ? route('bahan.store', ['id' => $data['materi']->id, 'type' => Request::get('type')]) : route('bahan.update', ['id' => $data['bahan']->materi_id, 'bahanId' => $data['bahan']->id, 'type' => Request::get('type')]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['bahan']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['bahan'])) ? old('judul', $data['bahan']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Status</label>
                </div>
                <div class="col-md-10">
                    <select class="status custom-select form-control" name="publish">
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('publish', $data['bahan']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['bahan'])) ? old('keterangan', $data['bahan']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            @yield('content-bahan')
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('bahan.index', ['id' => $data['materi']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['bahan']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

@endsection

@section('jsbody')
@include('includes.tiny-mce-with-fileman')
@if (Request::get('type') == 'dokumen')
<script>
    function openFm() {
        var win = window.open("/bank/data/filemanager/view?type-file=dokumen&view=button", "fm", "width=1400,height=800");
    }
</script>
@endif
@include('components.toastr')
@endsection

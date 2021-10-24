@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
@include('backend.course_management.breadcrumbs')

<div class="card">
    <h6 class="card-header">
      Form Mata Pelatihan
    </h6>
    <form action="{{ !isset($data['materi']) ? route('materi.store', ['id' => $data['mata']->id]) : route('materi.update', ['id' => $data['materi']->mata_id, 'materiId' => $data['materi']->id]) }}" method="POST">
        @csrf
        @if (isset($data['materi']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['materi'])) ? old('judul', $data['materi']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
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
                        <option value="{{ $key }}" {{ isset($data['materi']) ? (old('publish', $data['materi']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['materi'])) ? old('keterangan', $data['materi']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div> --}}
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('materi.index', ['id' => $data['mata']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['materi']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2();
</script>
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

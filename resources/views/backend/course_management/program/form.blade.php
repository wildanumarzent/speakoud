@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Kategori Pelatihan
    </h6>
    <form action="{{ !isset($data['program']) ? route('program.store') : route('program.update', ['id' => $data['program']->id]) }}" method="POST">
        @csrf
        @if (isset($data['program']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['program'])) ? old('judul', $data['program']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            @if (!isset($data['program']) && auth()->user()->hasRole('developer|administrator'))
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tipe (<em>program pelatihan untuk</em>)</label>
                </div>
                <div class="col-md-10">
                    <select id="tipe" class="custom-select form-control @error('tipe') is-invalid @enderror" name="tipe">
                        <option value=" " selected disabled>Pilih</option>
                        <option value="0">BPPT</option>
                        <option value="1">Mitra</option>
                    </select>
                    @error('tipe')
                        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row" id="mitra">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Mitra</label>
                </div>
                <div class="col-md-9">
                    <select class="select2 show-tick @error('mitra_id') is-invalid @enderror" name="mitra_id" data-style="btn-default">
                        <option value=" " selected disabled>Pilih</option>
                        @foreach ($data['mitra'] as $mitra)
                        <option value="{{ $mitra->id }}">{{ $mitra->instansi['nama_instansi'] }}</option>
                        @endforeach
                    </select>
                    @error('mitra_id')
                        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                    @enderror
                </div>
                <div class="col-md-1">
                    <div class="col-md-1">
                        <a href="{{ route('mitra.create') }}" class="btn btn-primary icon-btn" title="klik untuk menambah mitra"><i class="las la-plus"></i></a>
                    </div>
                </div>
            </div>
            @endif
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="Masukan keterangan...">{!! (isset($data['program'])) ? old('keterangan', $data['program']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('program.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['program']) ? 'Simpan perubahan' : 'Simpan' }}</button>
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
    //select mitra
    $('.select2').select2();
    $('#mitra').hide();
    $('#tipe').change(function(){
        if($('#tipe').val() == 1) {
            $('#mitra').show();
        } else {
            $('#mitra').hide();
        }
    });
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

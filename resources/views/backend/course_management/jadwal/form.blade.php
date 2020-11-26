@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Jadwal Pelatihan
    </h6>
    <form action="{{ !isset($data['jadwal']) ? route('jadwal.store') : route('jadwal.update', ['id' => $data['jadwal']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['jadwal']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Program Pelatihan</label>
                </div>
                <div class="col-md-10">
                  <select class="select2 show-tick @error('mata_id') is-invalid @enderror" name="mata_id" data-style="btn-default">
                    <option value=" " selected disabled>Pilih</option>
                      @foreach ($data['mata'] as $mata)
                          <option value="{{ $mata->id }}" {{ isset($data['jadwal']) ? (old('mata_id', $data['jadwal']->mata_id) == $mata->id ? 'selected' : '') : (old('mata_id') == $mata->id ? 'selected' : '') }}> {{ strtoupper($mata->judul) }}</option>
                      @endforeach
                  </select>
                  @error('mata_id')
                  <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['jadwal'])) ? old('judul', $data['jadwal']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['jadwal'])) ? old('keterangan', $data['jadwal']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="date-picker form-control @error('start_date') is-invalid @enderror" name="start_date"
                            value="{{ (isset($data['jadwal'])) ? old('start_date', $data['jadwal']->start_date->format('Y-m-d')) : old('start_date') }}" placeholder="masukan tanggal mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'start_date'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Selesai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="date-picker form-control @error('end_date') is-invalid @enderror" name="end_date"
                            value="{{ (isset($data['jadwal'])) ? old('end_date', $data['jadwal']->end_date->format('Y-m-d')) : old('end_date') }}" placeholder="masukan tanggal selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'end_date'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jam Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="time-picker form-control @error('start_time') is-invalid @enderror" name="start_time"
                            value="{{ (isset($data['jadwal'])) ? old('start_time', $data['jadwal']->start_time) : old('start_time') }}" placeholder="masukan jam mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-clock"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'start_time'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jam Selesai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="time-picker form-control @error('end_time') is-invalid @enderror" name="end_time"
                            value="{{ (isset($data['jadwal'])) ? old('end_time', $data['jadwal']->end_time) : old('end_time') }}" placeholder="masukan jam selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-clock"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'end_time'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Lokasi</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                            value="{{ (isset($data['jadwal'])) ? old('lokasi', $data['jadwal']->lokasi) : old('lokasi') }}" placeholder="masukan lokasi...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-map-marker"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'lokasi'])
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Cover</label>
                </div>
                @if (isset($data['jadwal']))
                    <input type="hidden" name="old_cover_file" value="{{ $data['jadwal']->cover['filename'] }}">
                    <div class="col-md-1">
                        <a href="{{ $data['jadwal']->getCover($data['jadwal']->cover['filename']) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['jadwal']->getCover($data['jadwal']->cover['filename']) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['jadwal']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                    @include('components.field-error', ['field' => 'cover_file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_title" value="{{ isset($data['jadwal']) ? old('cover_title', $data['jadwal']->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_alt" value="{{ isset($data['jadwal']) ? old('cover_alt', $data['jadwal']->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Status</label>
                </div>
                <div class="col-md-10">
                    <select class="status custom-select form-control" name="publish">
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ isset($data['jadwal']) ? (old('publish', $data['jadwal']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('jadwal.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['jadwal']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2();
    //datetime
    $(function() {
        var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

        $( ".date-picker" ).datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        $('.time-picker').bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: 'HH:mm'
        });
    });
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

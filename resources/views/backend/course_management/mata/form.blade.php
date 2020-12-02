@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
@include('backend.course_management.breadcrumbs')

<div class="card">
    <h6 class="card-header">
      Form Program Pelatihan
    </h6>
    <form action="{{ !isset($data['mata']) ? route('mata.store', ['id' => $data['program']->id]) : route('mata.update', ['id' => $data['mata']->program_id, 'mataId' => $data['mata']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['mata']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['mata'])) ? old('judul', $data['mata']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
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
                        <option value="{{ $key }}" {{ isset($data['mata']) ? (old('publish', $data['mata']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="datetime-picker form-control @error('publish_start') is-invalid @enderror" name="publish_start"
                            value="{{ isset($data['mata']) ? old('publish_start', $data['mata']->publish_start->format('Y-m-d H:i')) : old('publish_start', now()->addDays(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'publish_start'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Selesai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="hidden" id="get_val" value="{{ isset($data['mata']) ? old('publish_end', (!empty($data['mata']->publish_end) ? $data['mata']->publish_end->format('Y-m-d H:i') : now()->addDays(1)->addYears(1)->format('Y-m-d 00:00'))) : old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}">
                        <input id="publish_end" type="text" class="datetime-picker form-control @error('publish_end') is-invalid @enderror" name="publish_end"
                            value="{{ isset($data['mata']) ? old('publish_end', (!empty($data['mata']->publish_end) ? $data['mata']->publish_end->format('Y-m-d H:i') : '')) : old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                            <span class="input-group-text">
                                <input type="checkbox" id="checked" name="enable" value="1"
                                    {{ isset($data['mata']) ? (!empty($data['mata']->publish_end) ? 'checked' : '') : (old('enable') ? 'checked' : 'checked')}}>&nbsp; Enable
                            </span>
                        </div>
                        @include('components.field-error', ['field' => 'publish_end'])
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Summary</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('intro') is-invalid @enderror" name="intro" placeholder="masukan summary...">{!! (isset($data['mata'])) ? old('intro', $data['mata']->intro) : old('intro') !!}</textarea>
                    @include('components.field-error', ['field' => 'intro'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Deskripsi</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('content') is-invalid @enderror" name="content" placeholder="masukan deskripsi...">{!! (isset($data['mata'])) ? old('content', $data['mata']->content) : old('content') !!}</textarea>
                    @include('components.field-error', ['field' => 'content'])
                </div>
            </div>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Cover</label>
                </div>
                @if (isset($data['mata']))
                    <input type="hidden" name="old_cover_file" value="{{ $data['mata']->cover['filename'] }}">
                    <div class="col-md-1">
                        <a href="{{ $data['mata']->getCover($data['mata']->cover['filename']) }}" data-fancybox="gallery">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['mata']->getCover($data['mata']->cover['filename']) }}');"></div>
                        </a>
                    </div>
                @endif
                <div class="col-md-{{ isset($data['mata']) ? '9' : '10' }}">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                    @include('components.field-error', ['field' => 'cover_file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_title" value="{{ isset($data['mata']) ? old('cover_title', $data['mata']->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_alt" value="{{ isset($data['mata']) ? old('cover_alt', $data['mata']->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">Tampilkan Feedback Peserta</label>
                <div class="col-sm-10">
                  <label class="custom-control custom-checkbox m-0">
                    <input type="checkbox" class="custom-control-input" name="show_feedback" value="1" {{ isset($data['mata']) ? (old('show_feedback', $data['mata']->show_feedback) == 1 ? 'checked' : '') : (old('show_feedback') ? 'checked' : 'checked') }}>
                    <span class="custom-control-label ml-4">Ya</span>
                  </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">Tampilkan Komentar</label>
                <div class="col-sm-10">
                  <label class="custom-control custom-checkbox m-0">
                    <input type="checkbox" class="custom-control-input" name="show_comment" value="1" {{ isset($data['mata']) ? (old('show_comment', $data['mata']->show_comment) == 1 ? 'checked' : '') : (old('show_comment') ? 'checked' : 'checked') }}>
                    <span class="custom-control-label ml-4">Ya</span>
                  </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('mata.index', ['id' => $data['program']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['mata']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>

<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //datetime
    $('.datetime-picker').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });
    //enable publish end
    $('#checked').click(function() {
        if ($('#checked').prop('checked') == false) {
            $('#publish_end').val('').removeClass('datetime-picker').attr('readonly', true);
        } else {
            var get_val = $('#get_val').val();
            $('#publish_end').val(get_val);
        }
    });
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

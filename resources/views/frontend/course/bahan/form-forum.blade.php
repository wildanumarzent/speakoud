@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Topik
    </h6>
    <form action="{{ !isset($data['topik']) ? route('forum.topik.store', ['id' => $data['forum']->id]) : '' }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['topik']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Subject</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject"
                    value="{{ (isset($data['topik'])) ? old('subject', $data['topik']->subject) : old('subject') }}" placeholder="masukan subject..." autofocus>
                  @include('components.field-error', ['field' => 'subject'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Message</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('message') is-invalid @enderror" name="message" placeholder="Masukan message...">{!! (isset($data['topik'])) ? old('message', $data['topik']->message) : old('message') !!}</textarea>
                    @include('components.field-error', ['field' => 'message'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">Pinned</label>
                <div class="col-sm-10">
                  <label class="custom-control custom-checkbox m-0">
                    <input type="checkbox" class="custom-control-input" name="pin" value="1" {{ isset($data['topik']) ? (old('pin', $data['topik']->pin) == 1 ? 'checked' : '') : (old('pin') ? 'checked' : '') }}>
                    <span class="custom-control-label ml-4"></span>
                  </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Attachment</label>
                </div>
                <div class="col-md-10">
                    @if (isset($data['topik']))
                        <input type="hidden" name="old_attachment" value="{{ $data['topik']->attachment }}">
                        @if (!empty($data['topik']->attachment))
                        <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['topik']->attachment]) }}">Download</a></small>
                        @endif
                    @endif
                    <label class="custom-file-label" for="upload-1"></label>
                    <input class="form-control custom-file-input file @error('attachment') is-invalid @enderror" type="file" id="upload-1" lang="en" name="attachment" placeholder="masukan attachment...">
                    @include('components.field-error', ['field' => 'attachment'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Publish Start</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="hidden" id="get_val_start" value="{{ isset($data['topik']) ? old('publish_start', (!empty($data['topik']->publish_start) ? $data['topik']->publish_start->format('Y-m-d H:i') : now()->format('Y-m-d 00:00'))) : old('publish_start', now()->format('Y-m-d 00:00')) }}">
                        <input id="publish_start" type="text" class="datetime-picker form-control @error('publish_start') is-invalid @enderror" name="publish_start"
                            value="{{ isset($data['topik']) ? old('publish_start', (!empty($data['topik']->publish_start) ? $data['topik']->publish_start->format('Y-m-d H:i') : '')) : old('publish_start', now()->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                            <span class="input-group-text">
                                <input type="checkbox" id="checked_start" name="enable_start" value="1"
                                    {{ isset($data['topik']) ? (!empty($data['topik']->publish_start) ? 'checked' : '') : (old('enable_start') ? 'checked' : '')}}>&nbsp; Enable
                            </span>
                        </div>
                        @include('components.field-error', ['field' => 'publish_start'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Publish End</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="hidden" id="get_val_end" value="{{ isset($data['topik']) ? old('publish_end', (!empty($data['topik']->publish_end) ? $data['topik']->publish_end->format('Y-m-d H:i') : now()->format('Y-m-d 00:00'))) : old('publish_end', now()->format('Y-m-d 00:00')) }}">
                        <input id="publish_end" type="text" class="datetime-picker form-control @error('publish_end') is-invalid @enderror" name="publish_end"
                            value="{{ isset($data['topik']) ? old('publish_end', (!empty($data['topik']->publish_end) ? $data['topik']->publish_end->format('Y-m-d H:i') : '')) : old('publish_end', now()->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                            <span class="input-group-text">
                                <input type="checkbox" id="checked_end" name="enable_end" value="1"
                                    {{ isset($data['topik']) ? (!empty($data['topik']->publish_end) ? 'checked' : '') : (old('enable_end') ? 'checked' : '')}}>&nbsp; Enable
                            </span>
                        </div>
                        @include('components.field-error', ['field' => 'publish_end'])
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('course.bahan', ['id' => $data['forum']->mata_id, 'bahanId' => $data['forum']->bahan_id, 'tipe' => 'forum']) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['topik']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //datetime
    $('.datetime-picker').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });
    //enable publish
    $('#checked_start').click(function() {
        if ($('#checked_start').prop('checked_start') == false) {
            $('#publish_start').val('').removeClass('datetime-picker').attr('readonly', true);
        } else {
            var get_val_start = $('#get_val_start').val();
            $('#publish_start').val(get_val_start);
        }
    });
    $('#checked_end').click(function() {
        if ($('#checked_end').prop('checked_end') == false) {
            $('#publish_end').val('').removeClass('datetime-picker').attr('readonly', true);
        } else {
            var get_val_end = $('#get_val_end').val();
            $('#publish_end').val(get_val_end);
        }
    });
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

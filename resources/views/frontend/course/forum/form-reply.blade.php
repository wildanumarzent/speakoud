@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['topik']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['topik']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['topik']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['topik']->bahan->judul !!}</strong>
      </div>
    </div>
</div>

<div class="card">
    <h6 class="card-header">
      Form Reply
    </h6>
    <form action="{{ !isset($data['diskusi']) ? route('forum.topik.reply.store', ['id' => $data['forum']->id, 'topikId' => $data['topik']->id, 'parent' => Request::get('parent')]) : route('forum.topik.reply.update', ['id' => $data['forum']->id, 'topikId' => $data['topik']->id, 'replyId' => $data['diskusi']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['diskusi']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Subject</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control" value="Re : {{ $data['topik']->subject }}" readonly>
                  @include('components.field-error', ['field' => 'subject'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Message</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('message') is-invalid @enderror" name="message" placeholder="Masukan message...">{!! (isset($data['diskusi'])) ? old('message', $data['diskusi']->message) : old('message') !!}</textarea>
                    @include('components.field-error', ['field' => 'message'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Attachment</label>
                </div>
                <div class="col-md-10">
                    @if (isset($data['diskusi']))
                        <input type="hidden" name="old_attachment" value="{{ $data['diskusi']->attachment }}">
                        @if (!empty($data['diskusi']->attachment))
                        <small class="text-muted">File Sebelumnya : <a href="{{ asset('userfile/attachment/forum/'.$data['forum']->id.'/topik/'.$data['topik']->id.''.$data['diskusi']->attachment) }}">Download</a></small>
                        @endif
                    @endif
                    <label class="custom-file-label" for="upload-1"></label>
                    <input class="form-control custom-file-input file @error('attachment') is-invalid @enderror" type="file" id="upload-1" lang="en" name="attachment" placeholder="masukan attachment...">
                    @include('components.field-error', ['field' => 'attachment'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('forum.topik.room', ['id' => $data['forum']->id, 'topikId' => $data['topik']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['diskusi']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('jsbody')
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

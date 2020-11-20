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
      Form Announcement
    </h6>
    <form action="{{ !isset($data['announcement']) ? route('announcement.store') : route('announcement.update', ['id' => $data['anno']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['announcement']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Judul Announcement</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title')?' is-invalid':'' }}" value="{{ old('title')  ?? @$data['data']->title }}"placeholder="Masukan Judul Laporan">
                    {!! $errors->first('title', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Content</label>
                    <textarea id="RTE-IMG" class="form-control tiny" name="content">{!! old('content')  ?? @$data['data']->content !!}</textarea>
                {!! $errors->first('content', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Summary</label>
                    <textarea id="RTE-M" class="form-control tiny" name="sub_content">{!! old('sub_content')  ?? @$data['data']->content !!}</textarea>
                {!! $errors->first('sub_content', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label w-100">Attachment</label>
                    <a href="{{asset('user_folder'.'/'.@$data['data']->sender_id.'/'.'AnnouncementFile'.'/'.@$data['data']->attachment)}}" download>{{@$data['data']->attachment}}</a>
                    <hr>
                    <input type="file" name="attachment">

                    <small class="form-text text-muted">Masukan File Lampiran</small>
                </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('announcement.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['anno']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
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

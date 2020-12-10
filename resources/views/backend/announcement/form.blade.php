@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">

@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Announcement
    </h6>
    <form action="{{ !isset($data['announcement']) ? route('announcement.store') : route('announcement.update', ['id' => $data['announcement']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['announcement']))
            @method('PUT')
            <input type="hidden" name="old_attachment" value="{{ $data['announcement']->attachment }}">
            <input type="hidden" name="id" value="{{ $data['announcement']->id }}">
        @endif
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Judul Announcement</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title')?' is-invalid':'' }}" value="{{ old('title')  ?? @$data['announcement']->title }}"placeholder="Masukan Judul Laporan">
                    {!! $errors->first('title', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Content</label>
                    <textarea id="RTE-IMG" class="form-control tiny" name="content">{!! old('content')  ?? @$data['announcement']->content !!}</textarea>
                {!! $errors->first('content', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Summary</label>
                    <textarea id="RTE-M" class="form-control tiny" name="sub_content">{!! old('sub_content')  ?? @$data['announcement']->content !!}</textarea>
                {!! $errors->first('sub_content', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    <label class="form-label w-100">Attachment</label>
                    <a href="{{asset('user_folder'.'/'.@$data['announcement']->sender_id.'/'.'AnnouncementFile'.'/'.@$data['announcement']->attachment)}}" download>{{@$data['announcement']->attachment}}</a>
                    <hr>
                    <input type="file" name="attachment">

                    <small class="form-text text-muted">Masukan File Lampiran</small>
                </div>
                <div class="form-group">
                      <label class="col-form-label text-sm-right">Status</label>

                        <select class="status custom-select form-control" name="status">
                            @foreach (config('addon.label.publish') as $key => $value)
                            <option value="{{ $key }}" {{ isset($data['announcement']) ? (old('status', $data['announcement']->status) == ''.$key.'' ? 'selected' : '') : (old('status') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                            @endforeach
                        </select>

                </div>

                <div class="form-group">
                    <label class="form-label w-100">Kirim Kepada :</label>
                    <select class="select2-demo form-control" multiple style="width: 100%">
                        @php
                        $value_id = explode(',',@$data['data']->receiver);
                        $a = 'Hallo';
                        @endphp
                            @foreach($data['role'] as $value)
                            @if (isset($data['announcement']))
                        <option value="{{$value->id}}" @foreach($value_id as $u) {{$value->id == $u ? 'selected' : ''}} @endforeach>{{$value->name}}</option>
                            @else
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif
                            @endforeach
                    </select>
                </div>



        </div>

        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('announcement.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['announcement']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/autosize/autosize.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/forms_selects.js') }}"></script>
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

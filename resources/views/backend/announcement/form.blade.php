@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">

@endsection

@section('content')
@include('sweetalert::alert')
<div class="card">
    <h6 class="card-header">
      Form Pengumuman
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
                <label class="form-label">Judul Pengumuman</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title')?' is-invalid':'' }}" value="{{ old('title')  ?? @$data['announcement']->title }}"placeholder="Masukan Judul Pengumuman">
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
                    <small class="form-text text-muted">Masukan File Lampiran | Max 5mb | txt,doc,xls,png,jpeg,rar,zip</small>
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
                   <div class="collapse" id="kompetensi">
                   <select class="select2-demo form-control" name="receiver[]" multiple style="width: 100%">
                       @php
                       $role = explode('|',@$data['announcement']->receiver);
                       @endphp
                           @foreach($data['role'] as $value)
                           <option value="{{ $value->name }}" @if(!empty($data['announcement']) && in_array($value->name,$role)) selected @endif> {{ str_replace('_', ' ', ucwords($value->name)) }}</option>
                           @endforeach
                   </select>
                </div>
                   <label class="custom-control custom-checkbox">
                    <input type="checkbox" name="receiver" value="all"  class="custom-control-input" data-toggle="collapse" data-target="#kompetensi">
                    <span class="custom-control-label">Kirim Kepada Semua User</span>
                  </label>

               </div>
                <div class="form-group">
                    <label class="form-label">Masa Berlaku Pengumuman</label>
                        <input required type="date" name="end_date" class="form-control {{ $errors->has('end_date')?' is-invalid':'' }}" value="{{ old('end_date')  ?? @$data['announcement']->end_date }}"placeholder="Tentukan Masa Berlaku Pengumuman">
                        {!! $errors->first('end_date', '<small class="form-text text-danger">:message</small>') !!}
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
    $('.collapse').collapse()
</script>
<script>
// Bootstrap Tagsinput
$(function() {

  $('#tags').tagsinput({ tagClass: 'badge badge-primary' });
});
</script>
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

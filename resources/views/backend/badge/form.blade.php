@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/contacts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">

@endsection

@section('content')
@include('sweetalert::alert')
<div class="card">
    <h6 class="card-header">
      Form Badge
    </h6>
    <form action="{{ !isset($data['badge']) ? route('badge.store') : route('badge.update', ['id' => $data['badge']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tipe" value="{{$data['tipe']}}">
        <input type="hidden" name="mata_id" value = "{{$data['mataID']}}">
        @if(isset($data['tipeUtama']))
        <input type="hidden" name="tipe_utama" value="{{$data['tipeUtama']}}">
        @endif
        @if (isset($data['badge']))
            @method('PUT')
            <input type="hidden" name="old_icon" value="{{ $data['badge']->icon }}">
            <input type="hidden" name="id" value="{{ $data['badge']->id }}">
        @endif
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Nama Badge</label>
                    <input type="text" name="nama" class="form-control {{ $errors->has('nama')?' is-invalid':'' }}" value="{{ old('nama')  ?? @$data['badge']->nama }}"placeholder="Masukan Nama Badge">
                    {!! $errors->first('nama', '<small class="form-text text-danger">:message</small>') !!}
                </div>

                <div class="form-group">
                    <label class="form-label w-100">icon</label>
                    @if(isset($data['badge']))
                    <img class="contact-badge" src="{{asset($data['badge']->icon)}}" style="width: 200px;height:200px;object-fit:cover;"></a>
                    <hr>
                    @endif
                    <input type="file" name="icon">
                    <small class="form-text text-muted">Upload Icon | Max 10mb | png,jpeg</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control {{ $errors->has('deskripsi')?' is-invalid':'' }}" value="{{ old('deskripsi')  ?? @$data['badge']->deskripsi }}"placeholder="Masukan Deskripsi Badge">
                {!! $errors->first('deskripsi', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                @if($data['tipe'] != 'materi')
                <div class="form-group">
                    <div class="form-label">{{$data['minimumLabel']}}</div>
                    <input type="number" name="nilai_minimal" class="form-control {{ $errors->has('nilai_minimal')?' is-invalid':'' }}" value="{{ old('nilai_minimal')  ?? @$data['badge']->nilai_minimal }}"placeholder="Masukan {{$data['minimumLabel']}}">
                    {!! $errors->first('nilai_minimal', '<small class="form-text text-danger">:message</small>') !!}
                </div>
                @else
                <input type="hidden" name="nilai_minimal" value="100">
                @endif
                @if(isset($data['data']) )
                <div class="form-group">
                    <div class="form-label">{{ucwords($data['tipe'])}}</div>
                    <select class="selectpicker" data-style="btn-default" data-live-search="true" name="tipe_id">
                        @foreach($data['data'] as $value)
                        <option data-tokens="" value="{{$value->id}}">{{$value->judul ?? $value->subject ?? $value->bahan->judul}}</option>
                        @endforeach
                      </select>
                </div>
                @endif
        </div>

        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('badge.list',['mataID' => $data['mataID'] ] ) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['badge']) ? 'Simpan perubahan' : 'Simpan' }}</button>
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
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('jsbody')
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

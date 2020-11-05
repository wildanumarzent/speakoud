@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Materi Pelatihan
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
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['materi'])) ? old('keterangan', $data['materi']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('materi.index', ['id' => $data['mata']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['materi']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

@endsection

@section('jsbody')
<script>
    //text editor
    tinymce.init({
        selector: '.tiny',
        height: 400,
        min_height: 300,
        max_height: 500,
        plugins: 'image, link, media, wordcount, lists, code, table, preview',
        toolbar: ['formatselect | bold italic strikethrough superscript subscript forecolor backcolor formatpainter | table link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat code'],

        path_absolute : "/",
        file_picker_callback: function (callback, value, meta) {
            window.addEventListener('message', function receiveMessage(event) {
                window.removeEventListener('message', receiveMessage, false);
                if (event.data.sender === 'TestFM') {
                    callback(event.data.url);
                    tinymce.activeEditor.windowManager.close();
                }
            }, false);
            tinymce.activeEditor.windowManager.openUrl({
                title: 'File manager',
                url: '/bank/data/filemanager/view',
                width: 1000,
                height: 800,
                resizable: true,
                maximizable: true,
                inline: 1,
            });
        },
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
    });
</script>
@include('components.toastr')
@endsection

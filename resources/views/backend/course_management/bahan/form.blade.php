@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@yield('style')
@endsection

@section('content')
@include('backend.course_management.breadcrumbs')

<div class="card">
    <h6 class="card-header">
      Form Materi Pelatihan : <strong>"{{ strtoupper(Request::get('type')) }}"</strong>
    </h6>
    <form action="{{ !isset($data['bahan']) ? route('bahan.store', ['id' => $data['materi']->id, 'type' => Request::get('type')]) : route('bahan.update', ['id' => $data['bahan']->materi_id, 'bahanId' => $data['bahan']->id, 'type' => Request::get('type')]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['bahan']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($data['bahan'])) ? old('judul', $data['bahan']->judul) : old('judul') }}" placeholder="masukan judul..." autofocus>
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
                        <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('publish', $data['bahan']->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['bahan'])) ? old('keterangan', $data['bahan']->keterangan) : old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            @yield('content-bahan')
            <hr>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Batasi akses materi sesuai tanggal :</label>
                </div>
                <div class="col-md-10">
                    <label class="custom-control custom-checkbox m-0">
                        <input type="checkbox" class="custom-control-input" name="batas_tanggal" value="1" id="batasi" {{ isset($data['bahan']) && !empty($data['bahan']->publish_start) && !empty($data['bahan']->publish_end) ? 'checked' : '' }}>
                        <span class="custom-control-label ml-4">Ya</span>
                      </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="hidden" id="val_start" value="{{ isset($data['bahan']) && !empty($data['bahan']->publish_start) ? old('publish_start', $data['bahan']->publish_start->format('Y-m-d H:i')) : old('publish_start', now()->format('Y-m-d H:i')) }}">
                        <input id="publish_start" type="text" class="datetime-picker form-control @error('publish_start') is-invalid @enderror" name="publish_start"
                            value="{{ isset($data['bahan']) && !empty($data['bahan']->publish_start) ? old('publish_start', $data['bahan']->publish_start->format('Y-m-d H:i')) : '' }}" placeholder="masukan tanggal mulai...">
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
                        <input type="hidden" id="val_end" value="{{ isset($data['bahan']) && !empty($data['bahan']->publish_end) ? old('publish_end', $data['bahan']->publish_end->format('Y-m-d H:i')) : old('publish_end', now()->addDays(3)->format('Y-m-d H:i')) }}">
                        <input id="publish_end" type="text" class="datetime-picker form-control @error('publish_end') is-invalid @enderror" name="publish_end"
                            value="{{ isset($data['bahan']) && !empty($data['bahan']->publish_end) ? old('publish_end', $data['bahan']->publish_end->format('Y-m-d H:i')) : '' }}" placeholder="masukan tanggal selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'publish_end'])
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('bahan.index', ['id' => $data['materi']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['bahan']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
@yield('script')
@endsection

@section('jsbody')
<script>
    //datetime
    $(document).ready(function() {
        $('#batasi').change(function() {
            if(this.checked) {
                var ps = $('#val_start').val();
                var pe = $('#val_end').val();
                $('#publish_start').val(ps);
                $('#publish_end').val(pe);
            } else {
                $('#publish_start').val('');
                $('#publish_end').val('');
            }
        });
    });
    $('.datetime-picker').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });
</script>

@include('includes.tiny-mce-with-fileman')
@yield('body')
@include('components.toastr')
@endsection

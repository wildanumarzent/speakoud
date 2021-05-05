@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@yield('style')
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Template Materi Pelatihan : <strong>"{{ strtoupper(Request::get('type')) }}"</strong>
    </h6>
    <form action="{{ !isset($data['bahan']) ? route('template.bahan.store', ['id' => $data['materi']->id, 'type' => Request::get('type')]) : route('template.bahan.update', ['id' => $data['bahan']->template_materi_id, 'bahanId' => $data['bahan']->id, 'type' => Request::get('type')]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['bahan']))
            @method('PUT')
        @endif
        <div class="card-body">
            <div id="accordion2">
                <div class="card mb-2">
                  <div class="card-header">
                    <a class="d-flex justify-content-between text-body" data-toggle="collapse" aria-expanded="true" href="#general">
                        <strong>General</strong>
                        <div class="collapse-icon"></div>
                    </a>
                  </div>

                  <div id="general" class="collapse show" data-parent="#accordion2" style="">
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
                              <label class="col-form-label text-sm-right">Keterangan</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($data['bahan'])) ? old('keterangan', $data['bahan']->keterangan) : old('keterangan') !!}</textarea>
                                @include('components.field-error', ['field' => 'keterangan'])
                            </div>
                        </div>
                        @yield('content-bahan')
                    </div>
                  </div>
                </div>

                <div class="card mb-2">
                  <div class="card-header">
                    <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#activity">
                      <strong>Activity Completion</strong>
                      <div class="collapse-icon"></div>
                    </a>
                  </div>
                  <div id="activity" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Completion Condition</label>
                            </div>
                            <div class="col-md-10">
                                <select class="custom-select form-control" name="completion_type" id="completion">
                                    @foreach (config('addon.label.bahan_completion') as $keyCom => $com)
                                    <option value="{{ $keyCom }}" {{ isset($data['bahan']) ? (old('completion_type', $data['bahan']->completion_type) == ''.$keyCom.'' ? 'selected' : '') : '' }}>{{ $com }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="durasi-completion">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label">Durasi</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('completion_duration') is-invalid @enderror" name="completion_duration"
                                        value="{{ (isset($data['bahan'])) && !empty($data['bahan']->completion_parameter) ? old('completion_duration', $data['bahan']->completion_parameter['timer']) : old('completion_duration') }}" placeholder="masukan durasi...">
                                    <div class="input-group-append">
                                        <span class="input-group-text">MENIT</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'completion_duration'])
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="card mb-2">
                  <div class="card-header">
                    <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#restrict">
                      <strong>Restrict Access</strong>
                      <div class="collapse-icon"></div>
                    </a>
                  </div>
                  <div id="restrict" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Restrict</label>
                            </div>
                            <div class="col-md-10">
                                <select class="custom-select form-control" name="restrict_access" id="restrict-access">
                                    <option value=" " selected>Pilih</option>
                                    @foreach (config('addon.label.bahan_restrict') as $keyRes => $res)
                                    @if ($keyRes != 1)
                                    <option value="{{ $keyRes }}" {{ isset($data['bahan']) ? (old('restrict_access', $data['bahan']->restrict_access) == ''.$keyRes.'' ? 'selected' : '') : '' }}>{{ $res }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="requirement">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Materi bisa diakses setelah</label>
                            </div>
                            <div class="col-md-10">
                                <select class="select2 show-tick @error('requirement') is-invalid @enderror" name="requirement" data-style="btn-default">
                                    <option value=" " selected disabled>Pilih</option>
                                    @foreach ($data['bahan_list'] as $bahan)
                                    <option value="{{ $bahan->id }}" {{ isset($data['bahan']) ? (old('requirement', $data['bahan']->requirement) == $bahan->id ? 'selected' : '') : (old('requirement') == $bahan->id ? 'selected' : '') }}>{{ $bahan->judul }}</option>
                                    @endforeach
                                </select>
                                @error('requirement')
                                <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('template.bahan.index', ['id' => $data['materi']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
            &nbsp;&nbsp;
            <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">{{ isset($data['bahan']) ? 'Simpan perubahan' : 'Simpan' }}</button>
            &nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
@yield('script')
@endsection

@section('jsbody')
<script>
    $('.select2').select2();
</script>
@if (!isset($data['bahan']))
<script>
    $(document).ready(function() {
        $('#durasi-completion').hide();
        $('#completion').on('change', function() {
            if ($('#completion').val() == 3) {
                $('#durasi-completion').toggle('slow');
            } else {
                $('#durasi-completion').hide();
            }
        });

        $('#requirement').hide();
        $('#tanggal').hide();
        $('#restrict-access').on('change', function() {
            if ($('#restrict-access').val() == '0') {
                $('#requirement').toggle('slow');
            } else if ($('#restrict-access').val() == ' ') {
                $('#requirement').hide();
            }
        });
    });
</script>
@else
<script>
    $(document).ready(function() {
        var completion = $('#completion').val();
        if (completion == 3) {
            $('#durasi-completion').show();
        } else {
            $('#durasi-completion').hide();
        }
        $('#completion').on('change', function() {
            if ($('#completion').val() == 3) {
                $('#durasi-completion').toggle('slow');
            } else {
                $('#durasi-completion').hide();
            }
        });

        var restrict = $('#restrict-access').val();

        if (restrict == ' ') {
            $('#requirement').hide();
        } else if (restrict == '0') {
            $('#requirement').show();
        }

        $('#restrict-access').on('change', function() {
            if ($('#restrict-access').val() == '0') {
                $('#requirement').toggle('slow');
            } else if ($('#restrict-access').val() == ' ') {
                $('#requirement').hide();
            }
        });
    });
</script>
@endif

@include('includes.tiny-mce-with-fileman')
@yield('body')
@include('components.toastr')
@endsection

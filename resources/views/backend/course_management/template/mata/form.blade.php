@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#boot">Pembobotan Nilai</a>
    </div>
    <form action="{{ !isset($data['mata']) ? route('template.mata.store') : route('template.mata.update', ['id' => $data['mata']->id]) }}" method="POST">
        @csrf
        @if (isset($data['mata']))
            @method('PUT')
        @endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="data">
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
                                <label class="col-form-label text-sm-right">Pola Penyelenggaraan</label>
                            </div>
                            <div class="col-md-10">
                                <select class="selectpicker show-tick" data-style="btn-default" name="pola_penyelenggaraan">
                                    <option value=" " selected>Pilih</option>
                                    @foreach (config('addon.master_data.pola_penyelenggaraan') as $key => $value)
                                    <option value="{{ $key }}" {{ isset($data['mata']) ? (old('pola_penyelenggaraan', $data['mata']->pola_penyelenggaraan) == ''.$key.'' ? 'selected' : '') : (old('pola_penyelenggaraan') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Sumber Anggaran</label>
                            </div>
                            <div class="col-md-10">
                                <select class="selectpicker show-tick" data-style="btn-default" name="sumber_anggaran">
                                    <option value=" " selected>Pilih</option>
                                    @foreach (config('addon.master_data.sumber_anggaran') as $key => $value)
                                    <option value="{{ $key }}" {{ isset($data['mata']) ? (old('sumber_anggaran', $data['mata']->sumber_anggaran) == ''.$key.'' ? 'selected' : '') : (old('sumber_anggaran') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="summary">
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
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body pb-2">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Tampilkan Rating Peserta</label>
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
                </div>
                <div class="tab-pane fade" id="boot">
                    {{-- kehadiran --}}
                    <div class="card-body">
                        <h6 class="small font-weight-semibold mb-4">1. Kehadiran <span class="text-muted font-weight-normal">(jika mengikuti semua, faktor pembagi dengan jumlah video yang ada dan yang diikuti oleh peserta)</span></h6>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Join Video Conference</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('join_vidconf') is-invalid @enderror" name="join_vidconf" max="100"
                                        value="{{ isset($data['mata']) ? old('join_vidconf', $data['mata']->bobot->join_vidconf) : old('join_vidconf', 30) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'join_vidconf'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                    </div>
                    {{-- keaktifan --}}
                    <hr class="border-light m-0">
                    <div class="card-body pb-2">
                        <h6 class="small font-weight-semibold mb-4">2. Keaktifan</h6>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Activity Completion</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('activity_completion') is-invalid @enderror" name="activity_completion" max="100"
                                        value="{{ isset($data['mata']) ? old('activity_completion', $data['mata']->bobot->activity_completion) : old('activity_completion', 10) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'activity_completion'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Forum Diskusi</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('forum_diskusi') is-invalid @enderror" name="forum_diskusi" max="100"
                                        value="{{ isset($data['mata']) ? old('forum_diskusi', $data['mata']->bobot->forum_diskusi) : old('forum_diskusi', 10) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'forum_diskusi'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Webinar</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('webinar') is-invalid @enderror" name="webinar" max="100"
                                        value="{{ isset($data['mata']) ? old('webinar', $data['mata']->bobot->webinar) : old('webinar', 10) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'webinar'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                    </div>
                    {{-- tugas --}}
                    <hr class="border-light m-0">
                    <div class="card-body pb-2">
                        <h6 class="small font-weight-semibold mb-4">3. Tugas</h6>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Progress Test</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" id="progress-test" class="form-control @error('progress_test') is-invalid @enderror" name="progress_test" max="100"
                                        value="{{ isset($data['mata']) ? old('progress_test', $data['mata']->bobot->progress_test) : old('progress_test') }}" placeholder="masukan nilai" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                        <span class="input-group-text">
                                            <input type="checkbox" id="cp" name="enable_progress" value="1" {{ isset($data['mata']) && !empty($data['mata']->bobot->progress_test) ? 'checked' : ''}}>&nbsp; Enable
                                        </span>
                                    </div>
                                    @include('components.field-error', ['field' => 'progress_test'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Quiz</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('quiz') is-invalid @enderror" name="quiz" max="100"
                                        value="{{ isset($data['mata']) ? old('quiz', $data['mata']->bobot->quiz) : old('quiz', 10) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'quiz'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Tugas Mandiri</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" id="tugas-mandiri" class="form-control @error('tugas_mandiri') is-invalid @enderror" name="tugas_mandiri" max="100"
                                        value="{{ isset($data['mata']) ? old('tugas_mandiri', $data['mata']->bobot->tugas_mandiri) : old('tugas_mandiri') }}" placeholder="masukan nilai" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                        <span class="input-group-text">
                                            <input type="checkbox" id="cp_t" name="enable_tugas" value="1" {{ isset($data['mata']) && !empty($data['mata']->bobot->tugas_mandiri) ? 'checked' : ''}}>&nbsp; Enable
                                        </span>
                                    </div>
                                    @include('components.field-error', ['field' => 'tugas_mandiri'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                    </div>
                    {{-- post test --}}
                    <hr class="border-light m-0">
                    <div class="card-body pb-2">
                        <h6 class="small font-weight-semibold mb-4">4. Post Test</h6>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">Post Test</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" id="post-test" class="form-control @error('post_test') is-invalid @enderror" name="post_test" max="100"
                                        value="{{ isset($data['mata']) ? old('post_test', $data['mata']->bobot->post_test) : old('post_test', 30) }}" placeholder="masukan nilai">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @include('components.field-error', ['field' => 'post_test'])
                                </div>
                                <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="card-footer text-center">
            <a href="{{ route('template.mata.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
            &nbsp;&nbsp;
            <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">{{ isset($data['mata']) ? 'Simpan perubahan' : 'Simpan' }}</button>
            &nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
$(document).ready(function () {

    $('#summary').hide();

    $('input[type=number][max]:not([max=""])').on('input', function(ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
    });

    $('#cp').click(function() {
        if ($('#cp').prop('checked') == true) {
            $('#progress-test').removeAttr('disabled');
        } else {
            $('#progress-test').prop('disabled', true);
            $('#progress-test').val('');
        }
    });
    if ($('#cp').prop('checked') == true) {
        $('#progress-test').removeAttr('disabled');
    } else {
        $('#progress-test').prop('disabled', true);
        $('#progress-test').val('');
    }

    $('#cp_t').click(function() {
            if ($('#cp_t').prop('checked') == true) {
                $('#tugas-mandiri').removeAttr('disabled');
            } else {
                $('#tugas-mandiri').prop('disabled', true);
                $('#tugas-mandiri').val('');
            }
        });
        if ($('#cp_t').prop('checked') == true) {
            $('#tugas-mandiri').removeAttr('disabled');
        } else {
            $('#tugas-mandiri').prop('disabled', true);
            $('#tugas-mandiri').val('');
        }
});
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#boot">Pembobotan Nilai</a>
    </div>
    <div class="card-body">
        <form action="{{ !isset($data['mata']) ? route('template.mata.store') : route('template.mata.update', ['id' => $data['mata']->id]) }}" method="POST">
            @csrf
            @if (isset($data['mata']))
                @method('PUT')
            @endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="data">
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
                    <hr>
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
                <div class="tab-pane fade" id="boot">
                    {{-- kehadiran --}}
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
                    {{-- keaktifan --}}
                    <hr class="m-0 mb-4">
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
                    {{-- tugas --}}
                    <hr class="m-0 mb-4">
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
                    {{-- post test --}}
                    <hr class="m-0 mb-4">
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
            <div class="card-footer">
                <div class="row">
                  <div class="col-md-10 ml-sm-auto text-md-left text-right">
                    <a href="{{ route('template.mata.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                    <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['mata']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                  </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>

$(document).ready(function () {

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
});
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

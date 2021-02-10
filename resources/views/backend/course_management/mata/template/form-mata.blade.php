@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="row flex-column-reverse flex-xl-row mt-4">
    @include('backend.course_management.mata.template.step')
    <div class="col-xl-9">
        <div class="card">
            <div class="list-group list-group-flush account-settings-links flex-row">
                <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#boot">Pembobotan Nilai</a>
            </div>
            <div class="card-body">
                <form action="{{ route('mata.store.template', ['id' => $data['program']->id, 'templateId' => $data['tMata']->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data">
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Judul</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $data['tMata']->judul) }}" placeholder="masukan judul..." autofocus>
                                    @include('components.field-error', ['field' => 'judul'])
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Kode Evaluasi Penyelenggara</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('kode_evaluasi') is-invalid @enderror" name="kode_evaluasi" value="{{ old('kode_evaluasi') }}" placeholder="masukan kode evaluasi...">
                                    @include('components.field-error', ['field' => 'kode_evaluasi'])
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
                                        <option value="{{ $key }}" {{ old('pola_penyelenggaraan', $data['tMata']->pola_penyelenggaraan) == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
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
                                        <option value="{{ $key }}" {{ old('sumber_anggaran', $data['tMata']->sumber_anggaran) == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" class="datetime-picker form-control @error('publish_start') is-invalid @enderror" name="publish_start"
                                            value="{{ old('publish_start', now()->addDays(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal mulai...">
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
                                        <input type="hidden" id="get_val" value="{{ old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}">
                                        <input id="publish_end" type="text" class="datetime-picker form-control @error('publish_end') is-invalid @enderror" name="publish_end"
                                            value="{{ old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal selesai...">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                                            <input type="hidden" name="enable" value="1">
                                            {{-- <span class="input-group-text">
                                                <input type="checkbox" id="checked" name="enable" value="1"
                                                    {{ isset($data['mata']) ? (!empty($data['mata']->publish_end) ? 'checked' : '') : (old('enable') ? 'checked' : 'checked')}}>&nbsp; Enable
                                            </span> --}}
                                        </div>
                                        @include('components.field-error', ['field' => 'publish_end'])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Total Jam Pelatihan</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('jam_pelatihan') is-invalid @enderror" name="jam_pelatihan"
                                            value="{{ old('jam_pelatihan') }}" placeholder="masukan jam pelatihan...">
                                        <div class="input-group-append">
                                            <span class="input-group-text">JAM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Summary</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control tiny @error('intro') is-invalid @enderror" name="intro" placeholder="masukan summary...">{!! old('judul', $data['tMata']->intro) !!}</textarea>
                                    @include('components.field-error', ['field' => 'intro'])
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Deskripsi</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control tiny @error('content') is-invalid @enderror" name="content" placeholder="masukan deskripsi...">{!! old('judul', $data['tMata']->content) !!}</textarea>
                                    @include('components.field-error', ['field' => 'content'])
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 text-md-right">
                                    <label class="col-form-label text-sm-right">Cover</label>
                                </div>
                                <div class="col-md-10">
                                    <label class="custom-file-label" for="upload-2"></label>
                                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                                    @include('components.field-error', ['field' => 'cover_file'])
                                    <small class="text-muted mb-2">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                                    <div class="row mt-3 hide-meta">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="cover_title" value="{{ old('cover_title') }}" placeholder="title cover...">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="cover_alt" value="{{ old('cover_alt') }}" placeholder="alt cover...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-2 text-sm-right">Tampilkan Rating Peserta</label>
                                <div class="col-sm-10">
                                    <label class="custom-control custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input" name="show_feedback" value="1" {{ old('judul', $data['tMata']->show_feedback) == 1 ? 'checked' : '' }}>
                                    <span class="custom-control-label ml-4">Ya</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-2 text-sm-right">Tampilkan Komentar</label>
                                <div class="col-sm-10">
                                    <label class="custom-control custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input" name="show_comment" value="1" {{ old('judul', $data['tMata']->show_comment) == 1 ? 'checked' : '' }}>
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
                                            value="{{ old('join_vidconf', $data['tMata']->bobot->join_vidconf) }}" placeholder="masukan nilai">
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
                                            value="{{ old('activity_completion', $data['tMata']->bobot->activity_completion) }}" placeholder="masukan nilai">
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
                                            value="{{ old('forum_diskusi', $data['tMata']->bobot->forum_diskusi) }}" placeholder="masukan nilai">
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
                                            value="{{ old('webinar', $data['tMata']->bobot->webinar) }}" placeholder="masukan nilai">
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
                                            value="{{ old('progress_test', $data['tMata']->bobot->progress_test) }}" placeholder="masukan nilai" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                            <span class="input-group-text">
                                                <input type="checkbox" id="cp" name="enable_progress" value="1" {{ $data['tMata']->bobot->progress_test == 1 ? 'checked' : ''}}>&nbsp; Enable
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
                                            value="{{ old('quiz', $data['tMata']->bobot->quiz) }}" placeholder="masukan nilai">
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
                                            value="{{ old('post_test', $data['tMata']->bobot->post_test) }}" placeholder="masukan nilai">
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
                            <a href="{{ route('mata.index', ['id' => $data['program']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                            <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['mata']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/forms_selects.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
    $('.hide-meta').hide();
    //datetime
    $('.datetime-picker').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });
    //enable publish end
    $('#checked').click(function() {
        if ($('#checked').prop('checked') == false) {
            $('#publish_end').val('').removeClass('datetime-picker').attr('readonly', true);
        } else {
            var get_val = $('#get_val').val();
            $('#publish_end').val(get_val);
        }
    });


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

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
@include('backend.course_management.breadcrumbs')

<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
        {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#boot">Pembobotan Nilai</a> --}}
    </div>
    <div class="card-body">
        <form action="{{ !isset($data['mata']) ? route('mata.store', ['id' => $data['program']->id]) : route('mata.update', ['id' => $data['mata']->program_id, 'mataId' => $data['mata']->id]) }}" method="POST" enctype="multipart/form-data">
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
                          <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="datetime-picker form-control @error('publish_start') is-invalid @enderror" name="publish_start"
                                    value="{{ isset($data['mata']) ? old('publish_start', $data['mata']->publish_start->format('Y-m-d H:i')) : old('publish_start', now()->addDays(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal mulai...">
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
                                <input type="hidden" id="get_val" value="{{ isset($data['mata']) ? old('publish_end', (!empty($data['mata']->publish_end) ? $data['mata']->publish_end->format('Y-m-d H:i') : now()->addDays(1)->addYears(1)->format('Y-m-d 00:00'))) : old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}">
                                <input id="publish_end" type="text" class="datetime-picker form-control @error('publish_end') is-invalid @enderror" name="publish_end"
                                    value="{{ isset($data['mata']) ? old('publish_end', (!empty($data['mata']->publish_end) ? $data['mata']->publish_end->format('Y-m-d H:i') : '')) : old('publish_end', now()->addDays(1)->addYears(1)->format('Y-m-d 00:00')) }}" placeholder="masukan tanggal selesai...">
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
                                    value="{{ isset($data['mata']) ? old('jam_pelatihan', $data['mata']->jam_pelatihan) : old('jam_pelatihan') }}" placeholder="masukan jam pelatihan...">
                                <div class="input-group-append">
                                    <span class="input-group-text">JAM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                     <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">Tipe Pelatihan</label>
                        </div>
                        <div class="col-md-10">
                            <select class="status custom-select form-control" name="type_pelatihan">
                                @foreach (config('addon.label.tipe_pelatihan') as $key => $value)
                                    <option value="{{ $key }}" {{ isset($data['program']) ? (old('is_sertifikat', $data['program']->is_sertifikat) == ''.$key.'' ? 'selected' : '') : (old('is_sertifikat') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @include('components.field-error', ['field' => 'type_pelatihan'])
                        </div>
                    </div>

                    {{-- harga --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                        <label class="col-form-label text-sm-right">Harga</label>
                        </div>
                        <div class="col-md-10">
                        <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                            value="{{ (isset($data['mata'])) ? old('price', $data['mata']->price) : old('price') }}" placeholder="masukan price..." autofocus>
                        @include('components.field-error', ['field' => 'price'])
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">Sertifikat</label>
                        </div>
                        <div class="col-md-10">
                            <select class="status custom-select form-control" name="is_sertifikat">
                                @foreach (config('addon.label.is_sertifikat') as $key => $value)
                                    <option value="{{ $key }}" {{ isset($data['program']) ? (old('is_sertifikat', $data['program']->is_sertifikat) == ''.$key.'' ? 'selected' : '') : (old('is_sertifikat') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">Penilaian</label>
                        </div>
                        <div class="col-md-10">
                            <select class="status custom-select form-control" name="is_penilaian">
                                @foreach (config('addon.label.penilaian') as $key => $value)
                                    <option value="{{ $key }}" {{ isset($data['program']) ? (old('is_penilaian', $data['program']->is_penilaian) == ''.$key.'' ? 'selected' : '') : (old('is_penilaian') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Cover</label>
                        </div>
                        @if (isset($data['mata']))
                        <input type="hidden" name="old_cover_file" value="{{ $data['mata']->cover['filename'] }}">
                        @endif
                        <div class="col-md-10">
                            <label class="custom-file-label" for="upload-2"></label>
                            <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                            @include('components.field-error', ['field' => 'cover_file'])
                            <small class="text-muted mb-2">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                            @if (isset($data['mata']))
                            <a href="{{ $data['mata']->getCover($data['mata']->cover['filename']) }}" data-fancybox="gallery">
                                <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['mata']->getCover($data['mata']->cover['filename']) }}');"></div>
                            </a>
                            @endif
                            <div class="row mt-3 hide-meta">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cover_title" value="{{ isset($data['mata']) ? old('cover_title', $data['mata']->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cover_alt" value="{{ isset($data['mata']) ? old('cover_alt', $data['mata']->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">Kompetensi</label>
                          </div>
                          <div class="col-md-10">

                            <div class="select2-primary">
                            <select class="select2-demo form-control @error('kompetensi_id') is-invalid @enderror" name="kompetensi_id[]" data-style="btn-default" multiple>
                                <option disabled>Pilih Kompetensi</option>
                                @foreach ($data['kompetensi'] as $k)
                                    <option value="{{ $k->id }}" @if(!empty($data['kompetensiMata']) && in_array($k->id,$data['kompetensiMata']->pluck('kompetensi_id')->toArray())) selected @endif> {{ ucwords($k->judul) }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <hr> --}}
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
                <div class="tab-pane fade text-mute" id="boot" hidden>
                    {{-- kehadiran --}}
                    {{-- <h6 class="small font-weight-semibold mb-4">1. Kehadiran <span class="text-muted font-weight-normal">(jika mengikuti semua, faktor pembagi dengan jumlah video yang ada dan yang diikuti oleh peserta)</span></h6>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Join Video Conference</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" class="form-control @error('join_vidconf') is-invalid @enderror" name="join_vidconf" max="100"
                                    value="0" placeholder="masukan nilai">
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'join_vidconf'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- keaktifan --}}
                    {{-- <hr class="m-0 mb-4">
                    <h6 class="small font-weight-semibold mb-4">2. Keaktifan</h6>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Activity Completion</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" class="form-control @error('activity_completion') is-invalid @enderror" name="activity_completion" max="100"
                                    value="10" placeholder="masukan nilai">
                                {{-- <input type="number" class="form-control @error('activity_completion') is-invalid @enderror" name="activity_completion" max="100"
                                    value="{{ isset($data['mata']) ? old('activity_completion', $data['mata']->bobot->activity_completion) : old('activity_completion', 10) }}" placeholder="masukan nilai"> --}}
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'activity_completion'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Forum Diskusi</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" class="form-control @error('forum_diskusi') is-invalid @enderror" name="forum_diskusi" max="100"
                                    value="0" placeholder="masukan nilai">
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'forum_diskusi'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Webinar</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" class="form-control @error('webinar') is-invalid @enderror" name="webinar" max="100"
                                    value="0" placeholder="masukan nilai">
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'webinar'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- tugas --}}
                    {{-- <hr class="m-0 mb-4">
                    <h6 class="small font-weight-semibold mb-4">3. Tugas</h6>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Progress Test</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" id="progress-test" class="form-control @error('progress_test') is-invalid @enderror" name="progress_test" max="100"
                                    value="0" placeholder="masukan nilai" disabled>
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                    <span class="input-group-text">
                                        <input type="checkbox" id="cp" name="enable_progress" value="1" {{ isset($data['mata']) && !empty($data['mata']->bobot->progress_test) ? 'checked' : ''}}>&nbsp; Enable
                                    </span>
                                </div>
                                @include('components.field-error', ['field' => 'progress_test'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Quiz</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" class="form-control @error('quiz') is-invalid @enderror" name="quiz" max="100"
                                    value="0" placeholder="masukan nilai">
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'quiz'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tugas Mandiri</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group"> --}}
                                <input type="hidden" id="tugas-mandiri" class="form-control @error('tugas_mandiri') is-invalid @enderror" name="tugas_mandiri" max="100"
                                    value="0" placeholder="masukan nilai" disabled>
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                    <span class="input-group-text">
                                        <input type="checkbox" id="cp_t" name="enable_tugas" value="1" {{ isset($data['mata']) && !empty($data['mata']->bobot->tugas_mandiri) ? 'checked' : ''}}>&nbsp; Enable
                                    </span>
                                </div>
                                @include('components.field-error', ['field' => 'tugas_mandiri'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">100</span></span></i>
                        </div>
                    </div> --}}
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
                                    value="90" placeholder="masukan nilai">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                                @include('components.field-error', ['field' => 'post_test'])
                            </div>
                            <i>*<span class="text-muted">Input range <span class="badge badge-danger">0</span> - <span class="badge badge-success">90</span></span></i>
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
    $('#summary').hide();
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

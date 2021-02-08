<div>
    <form action="{{ !isset($jadwal) ? route('jadwal.store') : route('jadwal.update', ['id' => $jadwal->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($jadwal))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Dengan Program Pelatihan</label>
                </div>
                <label class="custom-control custom-checkbox">
                    <input wire:model='checked' type="checkbox" name="receiver" value="yes"  class="custom-control-input" data-toggle="collapse" data-target="#program" @if($checked == true) checked @endif>
                    <span class="custom-control-label">Ya</span>
                  </label>

            </div>
            @if($checked == true)
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Program Pelatihan</label>
                </div>
                <div class="col-md-10">
                  <select wire:model.lazy="mataId" class="form-control show-tick @error('mata_id') is-invalid @enderror" name="mata_id" data-style="btn-default" required>
                    <option value="" selected >Pilih</option>
                      @foreach ($mataP as $m)
                          <option value="{{ $m->id }}" {{ isset($jadwal) ? (old('mata_id', $jadwal->mata_id) == $m->id ? 'selected' : '') : (old('mata_id') == $m->id ? 'selected' : '') }}> {{ strtoupper($m->judul) }}</option>
                      @endforeach
                  </select>
                  @error('mata_id')
                  <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                  @enderror
                </div>
            </div>
            @endif
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Judul</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                    value="{{ (isset($jadwal)) ? old('judul', $jadwal->judul) : $mata->judul ?? old('judul') }}" placeholder="masukan judul..." autofocus>
                  @include('components.field-error', ['field' => 'judul'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi...">{!! (isset($jadwal)) ? old('keterangan', $jadwal->keterangan) : $mata->content ?? old('keterangan') !!}</textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        @php
                        if(isset($mata)){
                            $start = date_format($mata->publish_start,"Y-m-d");
                            $end =  date_format($mata->publish_end,"Y-m-d");
                            $tStart = date_format($mata->publish_start,"H:i");
                            $tEnd = date_format($mata->publish_end,"H:i");
                        }
                        @endphp
                        <input type="text" class="date-picker form-control @error('start_date') is-invalid @enderror" name="start_date"
                            value="{{ (isset($jadwal)) ? old('start_date', $jadwal->start_date->format('Y-m-d')) : $start ?? old('start_date') }}" placeholder="masukan tanggal mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'start_date'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tanggal Selesai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="date-picker form-control @error('end_date') is-invalid @enderror" name="end_date"
                            value="{{ (isset($jadwal)) ? old('end_date', $jadwal->end_date->format('Y-m-d')) : $end ?? old('end_date') }}" placeholder="masukan tanggal selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'end_date'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jam Mulai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="time-picker form-control @error('start_time') is-invalid @enderror" name="start_time"
                            value="{{ (isset($jadwal)) ? old('start_time', $jadwal->start_time) : $tStart ??old('start_time') }}" placeholder="masukan jam mulai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-clock"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'start_time'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jam Selesai</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="time-picker form-control @error('end_time') is-invalid @enderror" name="end_time"
                            value="{{ (isset($jadwal)) ? old('end_time', $jadwal->end_time) : $tEnd ?? old('end_time') }}" placeholder="masukan jam selesai...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-clock"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'end_time'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Lokasi</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                            value="{{ (isset($jadwal)) ? old('lokasi', $jadwal->lokasi) : old('lokasi') }}" placeholder="masukan lokasi...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-map-marker"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'lokasi'])
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group media row" style="min-height:1px">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Cover</label>
                </div>
                @if (isset($jadwal))
                    <input type="hidden" name="old_cover_file" value="{{ $jadwal->cover['filename'] }}">
                @endif
                <div class="col-md-10">
                    <label class="custom-file-label" for="upload-2"></label>
                    <input class="form-control custom-file-input file @error('cover_file') is-invalid @enderror" type="file" id="upload-2" lang="en" name="cover_file" placeholder="masukan cover...">
                    @include('components.field-error', ['field' => 'cover_file'])
                    <small class="text-muted">Tipe File : <strong>{{ strtoupper(config('addon.mimes.cover.m')) }}</strong></small>
                    @if (isset($jadwal))
                        <div class="col-md-1">
                            <a href="{{ $jadwal->getCover($jadwal->cover['filename']) }}" data-fancybox="gallery">
                                <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $jadwal->getCover($jadwal->cover['filename']) }}');"></div>
                            </a>
                        </div>
                    @endif
                    <div class="row mt-3 hide-meta">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_title" value="{{ isset($jadwal) ? old('cover_title', $jadwal->cover['title']) : old('cover_title') }}" placeholder="title cover...">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cover_alt" value="{{ isset($jadwal) ? old('cover_alt', $jadwal->cover['alt']) : old('cover_alt') }}" placeholder="alt cover...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Status</label>
                </div>
                <div class="col-md-10">
                    <select class="status custom-select form-control" name="publish">
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ isset($jadwal) ? (old('publish', $jadwal->publish) == ''.$key.'' ? 'selected' : '') : (old('publish') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('jadwal.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($jadwal) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>

<script>
    window.addEventListener('clicked', event => {
        // $('.collapse').collapse('show')
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
                url: '/bank/data/filemanager/view?view=text-editor',
                width: 1000,
                height: 600,
                resizable: true,
                maximizable: true,
                inline: 1,
            });
        },
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
    });
    });
</script>

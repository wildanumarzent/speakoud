@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
        {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#attachment">Attachment</a> --}}
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#akun">Akun</a>
    </div>
    <div class="card-body">
        <form action="{{ !isset($data['peserta']) ? route('peserta.store') : route('peserta.update', ['id' => $data['peserta']->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($data['peserta']))
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $data['peserta']->user_id }}">
            @endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="data">
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">NIP</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                            value="{{ (isset($data['peserta'])) ? old('nip', $data['peserta']->nip) : old('nip') }}" placeholder="masukan nip..." autofocus>
                          @include('components.field-error', ['field' => 'nip'])
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Nama</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ (isset($data['peserta'])) ? old('name', $data['peserta']->user->name) : old('name') }}" placeholder="masukan nama...">
                          @include('components.field-error', ['field' => 'name'])
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jenis Peserta</label>
                        </div>
                        <div class="col-md-10">
                            <select class="selectpicker show-tick" data-style="btn-default" name="jenis_peserta">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.jenis_peserta') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('jenis_peserta', $data['peserta']->jenis_peserta) == ''.$key.'' ? 'selected' : '') : (old('jenis_peserta') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jenis Kelamin</label>
                        </div>
                        <div class="col-md-10">
                            <select class="selectpicker show-tick" data-style="btn-default" name="jenis_kelamin">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.jenis_kelamin') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('jenis_kelamin', $data['peserta']->jenis_kelamin) == ''.$key.'' ? 'selected' : '') : (old('jenis_kelamin') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Agama</label>
                        </div>
                        <div class="col-md-10">
                            <select class="selectpicker show-tick" data-style="btn-default" name="agama">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.agama') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('agama', $data['peserta']->agama) == ''.$key.'' ? 'selected' : '') : (old('agama') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tempat Lahir</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir"
                            value="{{ (isset($data['peserta'])) ? old('tempat_lahir', $data['peserta']->tempat_lahir) : old('tempat_lahir') }}" placeholder="masukan tempat lahir...">
                          @include('components.field-error', ['field' => 'tempat_lahir'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tanggal Lahir</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="date-picker form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir"
                                    value="{{ (isset($data['peserta'])) ? (!empty($data['peserta']->tanggal_lahir) ? old('tanggal_lahir', $data['peserta']->tanggal_lahir->format('Y-m-d')) : '') : old('tanggal_lahir') }}" placeholder="masukan tanggal lahir...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="las la-calendar"></i></span>
                                </div>
                                @include('components.field-error', ['field' => 'tanggal_lahir'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Nomor Telpon</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ (isset($data['peserta'])) ? old('phone', $data['peserta']->user->information->phone) : old('phone') }}" placeholder="masukan nomor telpon...">
                                @include('components.field-error', ['field' => 'phone'])
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Pangkat / Gol. Ruang</label>
                        </div>
                        <div class="col-md-10">
                            <select class="select2 show-tick" data-style="btn-default" name="pangkat">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.pangkat') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('pangkat', $data['peserta']->pangkat) == ''.$key.'' ? 'selected' : '') : (old('pangkat') == ''.$key.'' ? 'selected' : '') }}>{{ $value.' - '.config('addon.master_data.golongan.'.$key) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jabatan</label>
                        </div>
                        <div class="col-md-10">
                            <select class="select2 show-tick" data-style="btn-default" name="jabatan_id">
                                <option value=" " selected>Pilih</option>
                                @foreach ($data['jabatan'] as $jabatan)
                                <option value="{{ $jabatan->id }}" {{ isset($data['peserta']) ? (old('jabatan_id', $data['peserta']->jabatan_id) == $jabatan->id ? 'selected' : '') : (old('jabatan_id') == $jabatan->id ? 'selected' : '') }}>{{ $jabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jenjang Jabatan</label>
                        </div>
                        <div class="col-md-10">
                            <select class="selectpicker show-tick" data-style="btn-default" name="jenjang_jabatan">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.jenjang_jabatan') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('jenjang_jabatan', $data['peserta']->jenjang_jabatan) == ''.$key.'' ? 'selected' : '') : (old('jenjang_jabatan') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- @role ('developer|administrator')
                    @if (!isset($data['peserta']) && Request::get('peserta') == 'mitra')
                    <div class="form-group row" id="mitra">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Mitra</label>
                        </div>
                        <div class="col-md-9">
                          <select class="select2 show-tick @error('mitra_id') is-invalid @enderror" name="mitra_id" data-style="btn-default">
                              <option value="" disabled selected>Pilih</option>
                              @foreach ($data['mitra'] as $mitra)
                              <option value="{{ $mitra->id }}" {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>{{ $mitra->instansi['nama_instansi'] }} - ({{ $mitra->user->name }})</option>
                              @endforeach
                          </select>
                          @error('mitra_id')
                          <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                          @enderror
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('mitra.create') }}" class="btn btn-primary icon-btn" title="klik untuk menambah mitra"><i class="las la-plus"></i></a>
                        </div>
                    </div>
                    @endif
                    @endrole --}}
                    {{-- @role ('mitra')
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Instansi / Perusahaan</label>
                        </div>
                        <div class="col-md-10">
                          <input type="hidden" name="instansi_id" value="{{ auth()->user()->mitra->instansi_id }}">
                          <input type="text" class="form-control" value="{{ auth()->user()->mitra->instansi->nama_instansi }}" readonly>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Instansi / Perusahaan</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select class="select2 show-tick @error('instansi_id') is-invalid @enderror" name="instansi_id" data-style="btn-default">
                                    <option value=" " selected disabled>Pilih</option>
                                    @foreach ($data['instansi'] as $instansi)
                                    <option value="{{ $instansi->id }}" {{ isset($data['peserta']) ? (old('instansi_id', $data['peserta']->instansi_id) == $instansi->id ? 'selected' : '') : (old('instansi_id') == $instansi->id ? 'selected' : '') }}>
                                        {{ $instansi->nama_instansi }} - ({{ $instansi->kode_instansi }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('instansi_id')
                                    <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endrole --}}
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Unit Kerja</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('kedeputian') is-invalid @enderror" name="kedeputian"
                            value="{{ (isset($data['peserta'])) ? old('kedeputian', $data['peserta']->kedeputian) : old('kedeputian') }}" placeholder="masukan unit kerja...">
                          @include('components.field-error', ['field' => 'kedeputian'])
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Alamat</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('alamat') is-invalid @enderror" name="address" placeholder="masukan alamat...">{{ (isset($data['peserta'])) ? old('address', $data['peserta']->user->information->address) : old('address') }}</textarea>
                          @include('components.field-error', ['field' => 'address'])
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="attachment">
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Foto Sertifikat</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-6"></label>
                            @if (isset($data['peserta']))
                                <input type="hidden" name="old_foto_sertifikat" value="{{ $data['peserta']->foto_sertifikat }}">
                                @if (!empty($data['peserta']->foto_sertifikat))
                                <small class="text-muted">File Sebelumnya : <a href="{{ asset('userfile/photo/sertifikat/'.$data['peserta']->foto_sertifikat)}}">Download</a></small><br>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('foto_sertifikat') is-invalid @enderror" type="file" id="file-6" lang="en" name="foto_sertifikat" value="browse...">
                            @include('components.field-error', ['field' => 'foto_sertifikat'])
                            <small class="text-muted">Tipe Foto Sertifikat : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong>, Maksimal Upload <strong>1 MB</strong>, Latar harus berwarna merah</small>
                        </div>
                    </div> --}}
                   
                </div>
                <div class="tab-pane fade" id="akun">
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Email</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ (isset($data['peserta'])) ? old('email', $data['peserta']->user->email) : old('email') }}" placeholder="masukan email...">
                          @include('components.field-error', ['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Username</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ (isset($data['peserta'])) ? old('username', $data['peserta']->user->username) : old('username') }}" placeholder="masukan username...">
                          @include('components.field-error', ['field' => 'username'])
                        </div>
                    </div>
                    @if (!isset($data['peserta']) && auth()->user()->hasRole('developer|administrator'))
                    <input type="hidden" name="roles" value="peserta_{{ Request::get('peserta') }}">
                    @endif
                    @if (!isset($data['peserta']) && auth()->user()->hasRole('internal|mitra'))
                    <input type="hidden" name="roles" value="peserta_{{ auth()->user()->roles[0]->name }}">
                    @endif
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Password</label>
                        </div>
                        <div class="col-md-10">
                          <div class="input-group">
                          <input type="password" id="password-field" class="form-control gen-field @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" placeholder="masukan password...">
                          <div class="input-group-append">
                            <span toggle="#password-field" class="input-group-text toggle-password fas fa-eye"></span>
                            <span class="btn btn-warning ml-2" id="generate"> Generate Password</span>
                          </div>
                          @include('components.field-error', ['field' => 'password'])
                          </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label">Konfirmasi Password</label>
                        </div>
                        <div class="col-md-10">
                          <div class="input-group">
                          <input type="password" id="password-confirm-field" class="form-control gen-field @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="masukan konfirmasi password...">
                          <div class="input-group-append">
                            <span toggle="#password-confirm-field" class="input-group-text toggle-password-confirm fas fa-eye"></span>
                          </div>
                          @include('components.field-error', ['field' => 'password_confirmation'])
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('peserta.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">{{ isset($data['peserta']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              &nbsp;&nbsp;
              <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
    //select mitra
    $('.select2').select2();
    // $('#mitra').hide();
    // $('#select-role').change(function(){
    //     if($('#select-role').val() == 'peserta_mitra') {
    //         $('#mitra').show();
    //     } else {
    //         $('#mitra').hide();
    //     }
    // });
    //date
    $(function() {
        var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

        $( ".date-picker" ).datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    });
    //show & hide password
    $(".toggle-password, .toggle-password-confirm").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
    //generate password
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }
    $("#generate").click(function(){
        $(".gen-field").val(makeid(8));
    });
</script>

@include('components.toastr')
@endsection

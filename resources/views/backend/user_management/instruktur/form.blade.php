@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#data">Data</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#akun">Akun</a>
    </div>
    <div class="card-body">
        <form action="{{ !isset($data['instruktur']) ? route('instruktur.store') : route('instruktur.update', ['id' => $data['instruktur']->id]) }}" method="POST">
            @csrf
            @if (isset($data['instruktur']))
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $data['instruktur']->user_id }}">
            @endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="data">
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">NIP</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                            value="{{ (isset($data['instruktur'])) ? old('nip', $data['instruktur']->nip) : old('nip') }}" placeholder="masukan nip..." autofocus>
                          @include('components.field-error', ['field' => 'nip'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Nama</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ (isset($data['instruktur'])) ? old('name', $data['instruktur']->user->name) : old('name') }}" placeholder="masukan nama...">
                          @include('components.field-error', ['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Unit kerja / Instansi / Perusahaan</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" name="unit_kerja"
                            value="{{ (isset($data['instruktur'])) ? old('unit_kerja', $data['instruktur']->unit_kerja) : old('unit_kerja') }}" placeholder="masukan unit kerja...">
                          @include('components.field-error', ['field' => 'unit_kerja'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Kedeputian</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('kedeputian') is-invalid @enderror" name="kedeputian"
                            value="{{ (isset($data['instruktur'])) ? old('kedeputian', $data['instruktur']->kedeputian) : old('kedeputian') }}" placeholder="masukan kedeputian...">
                          @include('components.field-error', ['field' => 'kedeputian'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Pangkat</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('pangkat') is-invalid @enderror" name="pangkat"
                            value="{{ (isset($data['instruktur'])) ? old('pangkat', $data['instruktur']->pangkat) : old('pangkat') }}" placeholder="masukan pangkat...">
                          @include('components.field-error', ['field' => 'pangkat'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Alamat</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="masukan alamat...">{{ (isset($data['instruktur'])) ? old('alamat', $data['instruktur']->alamat) : old('alamat') }}</textarea>
                          @include('components.field-error', ['field' => 'alamat'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan CPNS</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('sk_cpns') is-invalid @enderror" name="sk_cpns" placeholder="masukan surat keterangan cpns...">{{ (isset($data['instruktur'])) ? old('sk_cpns', $data['instruktur']->sk_cpns) : old('sk_cpns') }}</textarea>
                          @include('components.field-error', ['field' => 'sk_cpns'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Pengangkatan</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('sk_pengangkatan') is-invalid @enderror" name="sk_pengangkatan" placeholder="masukan surat keterangan pengangkatan...">{{ (isset($data['instruktur'])) ? old('sk_pengangkatan', $data['instruktur']->sk_pengangkatan) : old('sk_pengangkatan') }}</textarea>
                          @include('components.field-error', ['field' => 'sk_pengangkatan'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Golongan</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('sk_golongan') is-invalid @enderror" name="sk_golongan" placeholder="masukan surat keterangan golongan...">{{ (isset($data['instruktur'])) ? old('sk_golongan', $data['instruktur']->sk_golongan) : old('sk_golongan') }}</textarea>
                          @include('components.field-error', ['field' => 'sk_golongan'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Jabatan</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('sk_jabatan') is-invalid @enderror" name="sk_jabatan" placeholder="masukan surat keterangan jabatan...">{{ (isset($data['instruktur'])) ? old('sk_jabatan', $data['instruktur']->sk_jabatan) : old('sk_jabatan') }}</textarea>
                          @include('components.field-error', ['field' => 'sk_jabatan'])
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="akun">
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Email</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ (isset($data['instruktur'])) ? old('email', $data['instruktur']->user->email) : old('email') }}" placeholder="masukan email...">
                          @include('components.field-error', ['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Username</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ (isset($data['instruktur'])) ? old('username', $data['instruktur']->user->username) : old('username') }}" placeholder="masukan username...">
                          @include('components.field-error', ['field' => 'username'])
                        </div>
                    </div>
                    @if (!isset($data['instruktur']) && auth()->user()->hasRole('developer|administrator'))
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Roles</label>
                        </div>
                        <div class="col-md-10">
                          <select id="select-role" class="selectpicker show-tick @error('roles') is-invalid @enderror" name="roles" data-style="btn-default">
                              <option value="" disabled selected>Pilih</option>
                              <option value="instruktur_internal" {{ old('roles') == 'instruktur_internal' ? 'selected' : '' }}>Instruktur Internal</option>
                              <option value="instruktur_mitra" {{ old('roles') == 'instruktur_mitra' ? 'selected' : '' }}>Instruktur Mitra</option>
                          </select>
                          @error('roles')
                          <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                          @enderror
                        </div>
                    </div>
                    <div class="form-group row" id="mitra">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Mitra</label>
                        </div>
                        <div class="col-md-9">
                          <select class="select2 show-tick @error('mitra_id') is-invalid @enderror" name="mitra_id" data-style="btn-default">
                              <option value="" disabled selected>Pilih</option>
                              @foreach ($data['mitra'] as $mitra)
                              <option value="{{ $mitra->id }}" {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>{{ $mitra->instansi['nama_instansi'] }}</option>
                              @endforeach
                          </select>
                          @error('mitra_id')
                          <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                          @enderror
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('mitra.create') }}" class="btn btn-primary" title="klik untuk menambah mitra"><i class="las la-plus"></i> Tambah</a>
                        </div>
                    </div>
                    @endif
                    @if (!isset($data['instruktur']) && auth()->user()->hasRole('internal|mitra'))
                    <input type="hidden" name="roles" value="instruktur_{{ auth()->user()->roles[0]->name }}">
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
                            <span class="btn btn-warning ml-2" id="generate"><i class="las la-recycle"></i> Generate Password</span>
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
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-10 ml-sm-auto text-md-left text-right">
                        <a href="{{ route('instruktur.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['instruktur']) ? 'Simpan perubahan' : 'Simpan' }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
//select mitra
$('.select2').select2();
$('#mitra').hide();
$('#select-role').change(function(){
    if($('#select-role').val() == 'instruktur_mitra') {
        $('#mitra').show();
    } else {
        $('#mitra').hide();
    }
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

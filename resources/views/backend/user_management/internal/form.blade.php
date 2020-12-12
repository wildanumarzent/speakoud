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
        <form action="{{ !isset($data['internal']) ? route('internal.store') : route('internal.update', ['id' => $data['internal']->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($data['internal']))
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $data['internal']->user_id }}">
                <input type="hidden" name="old_email" value="{{ $data['internal']->user->email }}">
            @else
                <input type="hidden" name="roles" value="internal">
            @endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="data">
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">NIP</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                            value="{{ (isset($data['internal'])) ? old('nip', $data['internal']->nip) : old('nip') }}" placeholder="masukan nip..." autofocus>
                          @include('components.field-error', ['field' => 'nip'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Nama</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ (isset($data['internal'])) ? old('name', $data['internal']->user->name) : old('name') }}" placeholder="masukan nama...">
                          @include('components.field-error', ['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Unit kerja / Instansi / Perusahaan</label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select class="select2 show-tick @error('instansi_id') is-invalid @enderror" name="instansi_id" data-style="btn-default">
                                    <option value=" " selected disabled>Pilih</option>
                                    @foreach ($data['instansi'] as $instansi)
                                    <option value="{{ $instansi->id }}" {{ isset($data['internal']) ? (old('instansi_id', $data['internal']->instansi_id) == $instansi->id ? 'selected' : '') : (old('instansi_id') == $instansi->id ? 'selected' : '') }}>
                                        {{ $instansi->nama_instansi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('instansi_id')
                                    <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('instansi.internal.create') }}" class="btn btn-primary icon-btn" title="klik untuk menambah instansi"><i class="las la-plus"></i></a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Kedeputian</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('kedeputian') is-invalid @enderror" name="kedeputian"
                            value="{{ (isset($data['internal'])) ? old('kedeputian', $data['internal']->kedeputian) : old('kedeputian') }}" placeholder="masukan kedeputian...">
                          @include('components.field-error', ['field' => 'kedeputian'])
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jabatan</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('pangkat') is-invalid @enderror" name="pangkat"
                            value="{{ (isset($data['internal'])) ? old('pangkat', $data['internal']->pangkat) : old('pangkat') }}" placeholder="masukan jabatan...">
                          @include('components.field-error', ['field' => 'pangkat'])
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Jabatan</label>
                        </div>
                        <div class="col-md-10">
                            <select class="status custom-select form-control" name="pangkat">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.label.jabatan') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['internal']) ? (old('pangkat', $data['internal']->pangkat) == ''.$key.'' ? 'selected' : '') : (old('pangkat') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
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
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ (isset($data['internal'])) ? old('phone', $data['internal']->user->information->phone) : old('phone') }}" placeholder="masukan nomor telpon...">
                                @include('components.field-error', ['field' => 'phone'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Alamat</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('alamat') is-invalid @enderror" name="address" placeholder="masukan alamat...">{{ (isset($data['internal'])) ? old('address', $data['internal']->user->information->address) : old('address') }}</textarea>
                          @include('components.field-error', ['field' => 'address'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan CPNS</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-1"></label>
                            @if (isset($data['internal']))
                                <input type="hidden" name="old_sk_cpns" value="{{ $data['internal']->sk_cpns['file'] }}">
                                @if (!empty($data['internal']->sk_cpns['file']))
                                <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['internal']->sk_cpns['file']]) }}">Download</a></small>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('sk_cpns') is-invalid @enderror" type="file" id="file-1" lang="en" name="sk_cpns" value="browse...">
                            @include('components.field-error', ['field' => 'sk_cpns'])
                            <textarea class="form-control @error('keterangan_cpns') is-invalid @enderror" name="keterangan_cpns" placeholder="masukan surat keterangan cpns...">{{ (isset($data['internal'])) ? old('keterangan_cpns', $data['internal']->sk_cpns['keterangan']) : old('keterangan_cpns') }}</textarea>
                            @include('components.field-error', ['field' => 'keterangan_cpns'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Pengangkatan</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-2"></label>
                            @if (isset($data['internal']))
                                <input type="hidden" name="old_sk_pengangkatan" value="{{ $data['internal']->sk_pengangkatan['file'] }}">
                                @if (!empty($data['internal']->sk_pengangkatan['file']))
                                <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['internal']->sk_pengangkatan['file']]) }}">Download</a></small>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('sk_pengangkatan') is-invalid @enderror" type="file" id="file-2" lang="en" name="sk_pengangkatan" value="browse...">
                            @include('components.field-error', ['field' => 'sk_pengangkatan'])
                            <textarea class="form-control @error('keterangan_pengangkatan') is-invalid @enderror" name="keterangan_pengangkatan" placeholder="masukan surat keterangan pengangkatan...">{{ (isset($data['internal'])) ? old('keterangan_pengangkatan', $data['internal']->sk_pengangkatan['keterangan']) : old('keterangan_pengangkatan') }}</textarea>
                            @include('components.field-error', ['field' => 'keterangan_pengangkatan'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Golongan</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-3"></label>
                            @if (isset($data['internal']))
                                <input type="hidden" name="old_sk_golongan" value="{{ $data['internal']->sk_golongan['file'] }}">
                                @if (!empty($data['internal']->sk_golongan['file']))
                                <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['internal']->sk_golongan['file']]) }}">Download</a></small>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('sk_golongan') is-invalid @enderror" type="file" id="file-3" lang="en" name="sk_golongan" value="browse...">
                            @include('components.field-error', ['field' => 'sk_golongan'])
                            <textarea class="form-control @error('keterangan_golongan') is-invalid @enderror" name="keterangan_golongan" placeholder="masukan surat keterangan golongan...">{{ (isset($data['internal'])) ? old('keterangan_golongan', $data['internal']->sk_golongan['keterangan']) : old('keterangan_golongan') }}</textarea>
                            @include('components.field-error', ['field' => 'keterangan_golongan'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Surat Keterangan Jabatan</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-4"></label>
                            @if (isset($data['internal']))
                                <input type="hidden" name="old_sk_jabatan" value="{{ $data['internal']->sk_jabatan['file'] }}">
                                @if (!empty($data['internal']->sk_jabatan['file']))
                                <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['internal']->sk_jabatan['file']]) }}">Download</a></small>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('sk_jabatan') is-invalid @enderror" type="file" id="file-4" lang="en" name="sk_jabatan" value="browse...">
                            @include('components.field-error', ['field' => 'sk_jabatan'])
                          <textarea class="form-control @error('keterangan_jabatan') is-invalid @enderror" name="keterangan_jabatan" placeholder="masukan surat keterangan jabatan...">{{ (isset($data['internal'])) ? old('keterangan_jabatan', $data['internal']->sk_jabatan['keterangan']) : old('keterangan_jabatan') }}</textarea>
                          @include('components.field-error', ['field' => 'keterangan_jabatan'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">

                        </div>
                        <div class="col-md-10">
                            <div class="alert alert-warning alert-dismissible">
                                <i class="las la-file"></i>
                                <small class="text-muted">Tipe File Surat Keterangan : <strong>{{ strtoupper(config('addon.mimes.surat_keterangan.m')) }}</strong></small>
                            </div>
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
                            value="{{ (isset($data['internal'])) ? old('email', $data['internal']->user->email) : old('email') }}" placeholder="masukan email...">
                          @include('components.field-error', ['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Username</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ (isset($data['internal'])) ? old('username', $data['internal']->user->username) : old('username') }}" placeholder="masukan username...">
                          @include('components.field-error', ['field' => 'username'])
                        </div>
                    </div>
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
                            <span class="btn btn-warning ml-2" id="generate">Generate Password</span>
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
                        <a href="{{ route('internal.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['internal']) ? 'Simpan perubahan' : 'Simpan' }}</button>
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
     //select
     $('.select2').select2();
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

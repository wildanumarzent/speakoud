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
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#akun">Akun</a>
    </div>
    <div class="card-body">
        <form action="{{ !isset($data['instruktur']) ? route('instruktur.store') : route('instruktur.update', ['id' => $data['instruktur']->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($data['instruktur']))
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $data['instruktur']->user_id }}">
            @endif
            <div class="tab-content">
             
                <div class="tab-pane fade show active" id="data">
                    
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
                        <label class="col-form-label text-sm-left">Jenis Kelamin</label>
                        </div>
                        <div class="col-md-10">
                            <select class="selectpicker show-tick" data-style="btn-default" name="gender">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.jenis_kelamin') as $key => $value)
                                <option value="{{ $key }}" {{ old('gender', $data['instruktur']->gender ?? '') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @if ($data['instruktur']->gender ?? '0')
                            <span style="color: red;"><i>*belum diisi</i></span>
                            @endif
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Pendidikan</label>
                        </div>
                        <div class="col-md-10">
                         <select class="selectpicker show-tick" data-style="btn-default" name="pendidikan">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.label.pendidikan') as $key => $value)
                                <option value="{{ $key }}" {{ old('pendidikan', $data['instruktur']->pendidikan ?? '') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @if ($data['instruktur']->pendidikan ?? '0')
                            <span style="color: red;"><i>*belum diisi</i></span>
                            @endif
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
                                    value="{{ (isset($data['instruktur'])) ? old('phone', $data['instruktur']->information->phone) : old('phone') }}" placeholder="masukan nomor telpon...">
                                @include('components.field-error', ['field' => 'phone'])
                            </div>
                        </div>
                    </div>
                      <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Alamat</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('alamat') is-invalid @enderror" name="address" placeholder="masukan alamat...">{{ (isset($data['instruktur'])) ? old('address', $data['instruktur']->user->information->address) : old('address') }}</textarea>
                          @include('components.field-error', ['field' => 'address'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tanggal Lahir</label>
                        </div>
                        <div class="col-md-10">
                         <input type="text" class="date-picker form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir"
                            value="{{ !empty($data['instruktur']->tanggal_lahir) ? old('tanggal_lahir', $data['instruktur']->tanggal_lahir->format('Y-m-d')) : '' }}" placeholder="masukan tanggal lahir...">
                        <div class="input-group-append">
                          @include('components.field-error', ['field' => 'name'])
                        </div>
                    </div>
                    
                    {{-- <div id="surat-keterangan">
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Surat Keterangan CPNS</label>
                            </div>
                            <div class="col-md-10">
                                <label class="custom-file-label mt-1" for="file-1"></label>
                                @if (isset($data['instruktur']))
                                    <input type="hidden" name="old_sk_cpns" value="{{ $data['instruktur']->sk_cpns['file'] }}">
                                    @if (!empty($data['instruktur']->sk_cpns['file']))
                                    <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['instruktur']->sk_cpns['file']]) }}">Download</a></small>
                                    @endif
                                @endif
                                <input type="file" class="form-control custom-file-input file @error('sk_cpns') is-invalid @enderror" type="file" id="file-1" lang="en" name="sk_cpns" value="browse...">
                                @include('components.field-error', ['field' => 'sk_cpns'])
                                <textarea class="form-control @error('keterangan_cpns') is-invalid @enderror" name="keterangan_cpns" placeholder="masukan surat keterangan cpns...">{{ (isset($data['instruktur'])) ? old('keterangan_cpns', $data['instruktur']->sk_cpns['keterangan']) : old('keterangan_cpns') }}</textarea>
                                @include('components.field-error', ['field' => 'keterangan_cpns'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Surat Keterangan Pengangkatan</label>
                            </div>
                            <div class="col-md-10">
                                <label class="custom-file-label mt-1" for="file-2"></label>
                                @if (isset($data['instruktur']))
                                    <input type="hidden" name="old_sk_pengangkatan" value="{{ $data['instruktur']->sk_pengangkatan['file'] }}">
                                    @if (!empty($data['instruktur']->sk_pengangkatan['file']))
                                    <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['instruktur']->sk_pengangkatan['file']]) }}">Download</a></small>
                                    @endif
                                @endif
                                <input type="file" class="form-control custom-file-input file @error('sk_pengangkatan') is-invalid @enderror" type="file" id="file-2" lang="en" name="sk_pengangkatan" value="browse...">
                                @include('components.field-error', ['field' => 'sk_pengangkatan'])
                                <textarea class="form-control @error('keterangan_pengangkatan') is-invalid @enderror" name="keterangan_pengangkatan" placeholder="masukan surat keterangan pengangkatan...">{{ (isset($data['instruktur'])) ? old('keterangan_pengangkatan', $data['instruktur']->sk_pengangkatan['keterangan']) : old('keterangan_pengangkatan') }}</textarea>
                                @include('components.field-error', ['field' => 'keterangan_pengangkatan'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Surat Keterangan Golongan</label>
                            </div>
                            <div class="col-md-10">
                                <label class="custom-file-label mt-1" for="file-3"></label>
                                @if (isset($data['instruktur']))
                                    <input type="hidden" name="old_sk_golongan" value="{{ $data['instruktur']->sk_golongan['file'] }}">
                                    @if (!empty($data['instruktur']->sk_golongan['file']))
                                    <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['instruktur']->sk_golongan['file']]) }}">Download</a></small>
                                    @endif
                                @endif
                                <input type="file" class="form-control custom-file-input file @error('sk_golongan') is-invalid @enderror" type="file" id="file-3" lang="en" name="sk_golongan" value="browse...">
                                @include('components.field-error', ['field' => 'sk_golongan'])
                                <textarea class="form-control @error('keterangan_golongan') is-invalid @enderror" name="keterangan_golongan" placeholder="masukan surat keterangan golongan...">{{ (isset($data['instruktur'])) ? old('keterangan_golongan', $data['instruktur']->sk_golongan['keterangan']) : old('keterangan_golongan') }}</textarea>
                                @include('components.field-error', ['field' => 'keterangan_golongan'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                              <label class="col-form-label text-sm-right">Surat Keterangan Jabatan</label>
                            </div>
                            <div class="col-md-10">
                                <label class="custom-file-label mt-1" for="file-4"></label>
                                @if (isset($data['instruktur']))
                                    <input type="hidden" name="old_sk_jabatan" value="{{ $data['instruktur']->sk_jabatan['file'] }}">
                                    @if (!empty($data['instruktur']->sk_jabatan['file']))
                                    <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['instruktur']->sk_jabatan['file']]) }}">Download</a></small>
                                    @endif
                                @endif
                                <input type="file" class="form-control custom-file-input file @error('sk_jabatan') is-invalid @enderror" type="file" id="file-4" lang="en" name="sk_jabatan" value="browse...">
                                @include('components.field-error', ['field' => 'sk_jabatan'])
                              <textarea class="form-control @error('keterangan_jabatan') is-invalid @enderror" name="keterangan_jabatan" placeholder="masukan surat keterangan jabatan...">{{ (isset($data['instruktur'])) ? old('keterangan_jabatan', $data['instruktur']->sk_jabatan['keterangan']) : old('keterangan_jabatan') }}</textarea>
                              @include('components.field-error', ['field' => 'keterangan_jabatan'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">Curriculum Vitae</label>
                        </div>
                        <div class="col-md-10">
                            <label class="custom-file-label mt-1" for="file-5"></label>
                            @if (isset($data['instruktur']))
                                <input type="hidden" name="old_cv" value="{{ $data['instruktur']->cv }}">
                                @if (!empty($data['instruktur']->cv))
                                <small class="text-muted">File Sebelumnya : <a href="{{ route('bank.data.stream', ['path' => $data['instruktur']->cv]) }}">Download</a></small>
                                @endif
                            @endif
                            <input type="file" class="form-control custom-file-input file @error('cv') is-invalid @enderror" type="file" id="file-5" lang="en" name="cv" value="browse...">
                            @include('components.field-error', ['field' => 'cv'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">

                        </div>
                        <div class="col-md-10">
                            <div class="alert alert-warning alert-dismissible">
                                <i class="las la-file"></i>
                                <small class="text-muted">Tipe File Curriculum Vitae : <strong>{{ strtoupper(config('addon.mimes.surat_keterangan.m')) }}</strong></small>
                            </div>
                        </div>
                    </div> --}}
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
                    <input type="hidden" name="roles" value="instruktur_{{ Request::get('instruktur') }}">
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
            <div class="card-footer text-center">
              <a href="{{ route('instruktur.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">{{ isset($data['instruktur']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              &nbsp;&nbsp;
              <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
//select mitra
$('.select2').select2();
$('#kedeputian').hide();
$('#surat-keterangan').hide();
// $('#select-role').change(function(){
//     if($('#select-role').val() == 'instruktur_mitra') {
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

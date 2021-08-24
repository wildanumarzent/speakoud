@extends('layouts.backend.layoutCourse')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
@role('peserta_internal|peserta_mitra')
    {{-- {{dd($data['user']->peserta->status_profile == 0)}} --}}
    @if ($data['user']->peserta->status_peserta == 0 || empty($data['user']->photo['filename']))
        <div class="alert alert-danger">
            <i class="las la-exclamation-triangle"></i> Data Profile anda belum lengkap, <strong>Lengkapi data dibawah ini</strong>.
        </div>
    @else 
    {{-- {{dd($data['id'])}} --}}
     <a href="{{ route('pelatihan.mata',['id'=> $data['id']]) }}" class="btn btn-warning mb-3">Mulai Pelatihan</a>
    @endif
    
@endrole

<div class="card">
    <div class="card-header with-elements">
        {{-- @role('peserta_internal|peserta_mitra')
           
            @if ($data['user']->peserta->status_peserta == 1 || empty($data['user']->photo['filename']))
               
                <a href="{{ route('profile.front',['id'=> $data['id']]) }}" class="btn btn-warning">Mulai Pelatihan</a>
                
            @endif 
        @endrole --}}
        <h5 class="card-header-title mt-1 mb-0"><i class="las la-edit"></i> Edit profile</h5>
    </div>
    <form action="{{ route('profile.editFront') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group media" style="min-height:1px">
                <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['user']->getPhoto($data['user']->photo['filename']) }}');"></div>
                <div class="media-body ml-3">
                    <label class="form-label">
                        Ganti foto :
                    </label><br>
                    <small class="text-muted">Tipe : <strong>{{ strtoupper(config('custom.files.photo.m')) }}</strong></small>
                    <label class="custom-file mt-3">
                        <label class="custom-file-label mt-1" for="file-1"></label>
                        <input type="hidden" name="old_photo" value="{{ $data['user']->photo['filename'] }}">
                        <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="file-1" lang="en" name="file">
                        @include('components.field-error', ['field' => 'file'])
                        @role ('peserta_internal|peserta_mitra')
                            @if (empty($data['user']->photo['filename']))
                            <span style="color: red;"><i>*belum diisi</i></span>
                            @endif
                        @endrole
                    </label>
                </div>
                <div class="form-group" id="desk-foto">
                    <label class="form-label">Deskripsi foto</label>
                    <input type="text" class="form-control mb-1 @error('photo_description') is-invalid @enderror" name="photo_description" value="{{ old('photo_description', $data['user']->photo['description']) }}" placeholder="Masukan deskripsi...">
                    @include('components.field-error', ['field' => 'photo_description'])
                </div>
            </div>
        </div>
        <hr class="border-light m-0">
        <div class="card-body pb-2">
            <h5>DATA :</h5><br>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Nama</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $data['user']->name) }}" placeholder="masukan nama...">
                  @include('components.field-error', ['field' => 'name'])
                </div>
            </div>
            @role ('peserta_internal|peserta_mitra')
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Jenis Kelamin</label>
                </div>
                <div class="col-md-10">
                    <select class="selectpicker show-tick" data-style="btn-default" name="jenis_kelamin">
                        <option value=" " selected>Pilih</option>
                        @foreach (config('addon.master_data.jenis_kelamin') as $key => $value)
                        <option value="{{ $key }}" {{ old('jenis_kelamin', $data['user']->peserta->jenis_kelamin) == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @if ($data['user']->peserta->jenis_kelamin < '0')
                    <span style="color: red;"><i>*belum diisi</i></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Agama</label>
                </div>
                <div class="col-md-10">
                    <select class="selectpicker show-tick" data-style="btn-default" name="agama">
                        <option value=" " selected>Pilih</option>
                        @foreach (config('addon.master_data.agama') as $key => $value)
                        <option value="{{ $key }}" {{ old('agama', $data['user']->peserta->agama) == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @if ($data['user']->peserta->agama < '0')
                    <span style="color: red;"><i>*belum diisi</i></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Tempat Lahir</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control mb-1 @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir', $data['user']->peserta->tempat_lahir) }}" placeholder="Masukan tempat lahir...">
                    @if (empty($data['user']->peserta->tempat_lahir))
                    <span style="color: red;"><i>*belum diisi</i></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Tanggal Lahir</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="date-picker form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir"
                            value="{{ !empty($data['user']->peserta->tanggal_lahir) ? old('tanggal_lahir', $data['user']->peserta->tanggal_lahir->format('Y-m-d')) : '' }}" placeholder="masukan tanggal lahir...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </div>
                        @include('components.field-error', ['field' => 'tanggal_lahir'])
                    </div>
                    @if (empty($data['user']->peserta->tanggal_lahir))
                    <span style="color: red;"><i>*belum diisi</i></span>
                    @endif
                </div>
            </div>
            @endrole
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                    <label class="col-form-label text-sm-left">Telpon</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+62</span>
                        </div>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('phone', $data['information']->no_hp) }}" placeholder="Masukan telpon...">
                        @include('components.field-error', ['field' => 'no_hp'])
                    </div>
                    @role ('peserta_internal|peserta_mitra')
                    @if (empty($data['information']->no_hp))
                    <span style="color: red;"><i>*belum diisi</i></span>
                    @endif
                    @endrole
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                    <label class="col-form-label text-sm-left">Kota Tinggal</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="kota_tinggal" value="{{ old('kota_tinggal', $data['information']->kota_tinggal) }}" placeholder="Masukan Kota tinggal...">
                        @include('components.field-error', ['field' => 'address'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Jabatan</label>
                </div>
                <div class="col-md-10">
                    <select class="select2 show-tick" data-style="btn-default" name="jabatan_id">
                        <option value=" " selected>Pilih</option>
                        @foreach ($data['jabatan'] as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $data['user']->peserta->jabatan_id) == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Departemen</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('departemen') is-invalid @enderror" name="departemen"
                    value="{{ old('departemen', $data['information']->Departemen) }}" placeholder="masukan departemen...">
                  @include('components.field-error', ['field' => 'departemen'])
                </div>
            </div>
        </div>
        <hr class="border-light m-0">
        <div class="card-body pb-2">
            <h5>AKUN :</h5><br>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Email</label>
                </div>
                <div class="col-md-10">
                    <input type="hidden" name="old_email" value="{{ $data['user']->email }}">
                    <input type="text" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $data['user']->email) }}" placeholder="Masukan email...">
                    @include('components.field-error', ['field' => 'email'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Username</label>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control mb-1 @error('username') is-invalid @enderror" name="username" value="{{ old('username', $data['user']->username) }}"
                        placeholder="Masukan username...">
                    @include('components.field-error', ['field' => 'username'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Password sebelumnya (<em>jika ingin mengubah password</em>)</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="password" id="current-password-field" class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                            value="{{ old('current_password') }}"
                            placeholder="Masukan password sebelumnya...">
                        <div class="input-group-append">
                            <span toggle="#current-password-field" class="input-group-text toggle-current-password fas fa-eye" title="tampilkan password"></span>
                        </div>
                        @include('components.field-error', ['field' => 'current_password'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Password Baru</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="password" id="password-field" class="form-control gen-field @error('password') is-invalid @enderror" name="password"
                            placeholder="Masukan password baru...">
                        <div class="input-group-append">
                            <span toggle="#password-field" class="input-group-text toggle-password fas fa-eye"></span>
                        </div>
                        @include('components.field-error', ['field' => 'password'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-left">
                  <label class="col-form-label text-sm-left">Konfirmasi Password</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="password" id="password-confirm-field" class="form-control gen-field @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Masukan konfirmasi password...">
                        <div class="input-group-append">
                            <span toggle="#password-confirm-field" class="input-group-text toggle-password-confirm fas fa-eye"></span>
                        </div>
                        @include('components.field-error', ['field' => 'password_confirmation'])
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>

<script>
$(".hide-collapse").show();
$("#desk-foto").hide();

$('.select2').select2();
//date
$(function() {
    var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

    $( ".date-picker" ).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
});

$(".toggle-current-password, .toggle-password, .toggle-password-confirm").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

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

@include('includes.tiny-mce')
@include('components.toastr')
@endsection
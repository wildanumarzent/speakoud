@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0"><i class="las la-edit"></i> Edit profile</h5>
    </div>
    <form action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="bg-general ui-bordered mb-2">
                <a href="#account" class="d-flex justify-content-between text-body py-3 px-4 collapsed" data-toggle="collapse" aria-expanded="true">
                    <strong>Data</strong>
                    <span class="collapse-icon"></span>
                </a>
                <div id="general" class="text-muted collapse show">
                    <div class="card-body pb-2">
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control mb-1 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $data['user']->name) }}" placeholder="Masukan nama...">
                            @include('components.field-error', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telpon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $data['information']->phone) }}" placeholder="Masukan telpon...">
                                @include('components.field-error', ['field' => 'phone'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control mb-1 @error('address') is-invalid @enderror" name="address" placeholder="Masukan alamat...">{{ old('address', $data['information']->address) }}</textarea>
                            @include('components.field-error', ['field' => 'address'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white ui-bordered mb-2">
                <a href="#account" class="d-flex justify-content-between text-body py-3 px-4 collapsed" data-toggle="collapse" aria-expanded="true">
                    <strong>Akun</strong>
                    <span class="collapse-icon"></span>
                </a>
                <div id="account" class="text-muted collapse show">
                    <div class="card-body pb-2">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="hidden" name="old_email" value="{{ $data['user']->email }}">
                            <input type="text" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $data['user']->email) }}" placeholder="Masukan email...">
                            @include('components.field-error', ['field' => 'email'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control mb-1 @error('username') is-invalid @enderror" name="username" value="{{ old('username', $data['user']->username) }}"
                                placeholder="Masukan username...">
                            @include('components.field-error', ['field' => 'username'])
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Password sebelumnya (<em>jika ingin mengubah password</em>)</label>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password baru</label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi password</label>
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
                            <div class="form-group ml-2">
                                <span class="btn btn-warning"  id="generate"> Generate password</span>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label class="form-label">City / Town</label>
                            <input type="text" class="form-control mb-1 @error('city') is-invalid @enderror" name="city"
                                value="{{ old('city', ($data['information'] != null ? $data['information']->city : '')) }}" placeholder="Enter city/town...">
                            @include('components.field-error', ['field' => 'city'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control mb-1 tiny @error('description') is-invalid @enderror" name="description" placeholder="Enter description...">
                                {{ old('description', ($data['information'] != null ? $data['information']->description : '')) }}
                            </textarea>
                            @include('components.field-error', ['field' => 'description'])
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="bg-white ui-bordered mb-2">
                <a href="#user-picture" class="d-flex justify-content-between text-body py-3 px-4 collapsed" data-toggle="collapse" aria-expanded="true">
                    <strong>Foto</strong>
                    <span class="collapse-icon"></span>
                </a>
                <div id="user-picture" class="text-muted collapse show">
                    <div class="card-body pb-2">
                        <div class="form-group media" style="min-height:1px">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['user']->getPhoto($data['user']->photo['filename']) }}');"></div>
                            <div class="media-body ml-3">
                                <label class="form-label">
                                    Ganti foto :
                                </label><br>
                                <small class="text-muted">Tipe : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong></small>
                                <label class="custom-file mt-3">
                                    <label class="custom-file-label mt-1" for="file-1"></label>
                                    <input type="hidden" name="old_photo" value="{{ $data['user']->photo['filename'] }}">
                                    <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="file-1" lang="en" name="file">
                                    @include('components.field-error', ['field' => 'file'])
                                </label>
                            </div>
                        </div>
                        @role ('peserta_internal|peserta_mitra')
                        <div class="form-group media" style="min-height:1px">
                            <div class="ui-bg-cover" style="width: 100px;height: 100px;background-image: url('{{ $data['user']->peserta->getFotoSertifikat($data['user']->peserta->foto_sertifikat) }}');"></div>
                            <div class="media-body ml-3">
                                <label class="form-label">
                                    Ganti foto sertifikat :
                                </label><br>
                                <small class="text-muted">Tipe Foto Sertifikat : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong>, Maksimal Upload <strong>1 MB</strong>, Latar harus berwarna merah</small>
                                <label class="custom-file mt-3">
                                    <label class="custom-file-label mt-1" for="file-2"></label>
                                    <input type="hidden" name="old_photo" value="{{ $data['user']->peserta->foto_sertifikat }}">
                                    <input class="form-control custom-file-input file @error('foto_sertifikat') is-invalid @enderror" type="file" id="file-2" lang="en" name="foto_sertifikat">
                                    @include('components.field-error', ['field' => 'foto_sertifikat'])
                                </label>
                            </div>
                        </div>
                        @endrole
                        <div class="form-group" id="desk-foto">
                            <label class="form-label">Deskripsi foto</label>
                            <input type="text" class="form-control mb-1 @error('photo_description') is-invalid @enderror" name="photo_description" value="{{ old('photo_description', $data['user']->photo['description']) }}" placeholder="Masukan deskripsi...">
                            @include('components.field-error', ['field' => 'photo_description'])
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="bg-white ui-bordered mb-2 hide-collapse">
                <a href="#additional-name" class="d-flex justify-content-between text-body py-3 px-4 collapsed" data-toggle="collapse" aria-expanded="true">
                    <strong>Additional name</strong>
                    <span class="collapse-icon"></span>
                </a>
                <div id="additional-name" class="text-muted collapse">
                    <div class="card-body pb-2">
                        <div class="form-group">
                            <label class="form-label">First name - phonetic</label>
                            <input type="text" class="form-control mb-1 @error('first_name') is-invalid @enderror" name="first_name"
                                value="{{ old('first_name', ($data['information'] != null ? $data['information']->additional_name['first_name'] : '')) }}" placeholder="Enter first name...">
                            @include('components.field-error', ['field' => 'first_name'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Surname - phonetic</label>
                            <input type="text" class="form-control mb-1 @error('sur_name') is-invalid @enderror" name="sur_name"
                                value="{{ old('sur_name', ($data['information'] != null ? $data['information']->additional_name['sur_name'] : '')) }}" placeholder="Enter sur name...">
                            @include('components.field-error', ['field' => 'sur_name'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Middle name</label>
                            <input type="text" class="form-control mb-1 @error('middle_name') is-invalid @enderror" name="middle_name"
                                value="{{ old('middle_name', ($data['information'] != null ? $data['information']->additional_name['middle_name'] : '')) }}" placeholder="Enter middle name...">
                            @include('components.field-error', ['field' => 'middle_name'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alternate name</label>
                            <input type="text" class="form-control mb-1 @error('alternate_name') is-invalid @enderror" name="alternate_name"
                                value="{{ old('alternate_name', ($data['information'] != null ? $data['information']->additional_name['alternate_name'] : '')) }}" placeholder="Enter alternate name...">
                            @include('components.field-error', ['field' => 'alternate_name'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white ui-bordered mb-2 hide-collapse">
                <a href="#optional" class="d-flex justify-content-between text-body py-3 px-4 collapsed" data-toggle="collapse" aria-expanded="true">
                    <strong>Optional</strong>
                    <span class="collapse-icon"></span>
                </a>
                <div id="optional" class="text-muted collapse">
                    <div class="card-body pb-2">
                        <div class="form-group">
                            <label class="form-label">Web page</label>
                            <input type="text" class="form-control mb-1 @error('web_page') is-invalid @enderror" name="web_page"
                                value="{{ old('web_page', ($data['information'] != null ? $data['information']->optional['web_page'] : '')) }}" placeholder="Enter web page...">
                            @include('components.field-error', ['field' => 'web_page'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">ICQ number</label>
                            <input type="text" class="form-control mb-1 @error('icq_number') is-invalid @enderror" name="icq_number"
                                value="{{ old('icq_number', ($data['information'] != null ? $data['information']->optional['icq_number'] : '')) }}" placeholder="Enter icq number...">
                            @include('components.field-error', ['field' => 'icq_number'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Skype ID</label>
                            <input type="text" class="form-control mb-1 @error('skype_id') is-invalid @enderror" name="skype_id"
                                value="{{ old('skype_id', ($data['information'] != null ? $data['information']->optional['skype_id'] : '')) }}" placeholder="Enter skype id...">
                            @include('components.field-error', ['field' => 'skype_id'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">AIM ID</label>
                            <input type="text" class="form-control mb-1 @error('aim_id') is-invalid @enderror" name="aim_id"
                                value="{{ old('aim_id', ($data['information'] != null ? $data['information']->optional['aim_id'] : '')) }}" placeholder="Enter aim id...">
                            @include('components.field-error', ['field' => 'aim_id'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Yahoo ID</label>
                            <input type="text" class="form-control mb-1 @error('yahoo_id') is-invalid @enderror" name="yahoo_id"
                                value="{{ old('yahoo_id', ($data['information'] != null ? $data['information']->optional['yahoo_id'] : '')) }}" placeholder="Enter yahoo id...">
                            @include('components.field-error', ['field' => 'yahoo_id'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">MSN ID</label>
                            <input type="text" class="form-control mb-1 @error('msn_id') is-invalid @enderror" name="msn_id"
                                value="{{ old('msn_id', ($data['information'] != null ? $data['information']->optional['msn_id'] : '')) }}" placeholder="Enter msn id...">
                            @include('components.field-error', ['field' => 'msn_id'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">ID number</label>
                            <input type="text" class="form-control mb-1 @error('id_number') is-invalid @enderror" name="id_number"
                                value="{{ old('id_number', ($data['information'] != null ? $data['information']->optional['id_number'] : '')) }}" placeholder="Enter id number...">
                            @include('components.field-error', ['field' => 'id_number'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Institution</label>
                            <input type="text" class="form-control mb-1 @error('institution') is-invalid @enderror" name="institution"
                                value="{{ old('institution', ($data['information'] != null ? $data['information']->optional['institution'] : '')) }}" placeholder="Enter institution...">
                            @include('components.field-error', ['field' => 'institution'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Departemnt</label>
                            <input type="text" class="form-control mb-1 @error('departement') is-invalid @enderror" name="departement"
                                value="{{ old('departement', ($data['information'] != null ? $data['information']->optional['departement'] : '')) }}" placeholder="Enter departement...">
                            @include('components.field-error', ['field' => 'departement'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control mb-1 @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone', ($data['information'] != null ? $data['information']->optional['phone'] : '')) }}" placeholder="Enter phone...">
                            @include('components.field-error', ['field' => 'phone'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mobile phone</label>
                            <input type="text" class="form-control mb-1 @error('mobile_phone') is-invalid @enderror" name="mobile_phone"
                                value="{{ old('mobile_phone', ($data['information'] != null ? $data['information']->optional['mobile_phone'] : '')) }}" placeholder="Enter mobile phone...">
                            @include('components.field-error', ['field' => 'mobile_phone'])
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control mb-1 @error('address') is-invalid @enderror" name="address"
                                value="{{ old('address', ($data['information'] != null ? $data['information']->optional['address'] : '')) }}" placeholder="Enter address...">
                            @include('components.field-error', ['field' => 'address'])
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="" class="btn btn-danger mr-2">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>

<script>
$(".hide-collapse").show();
$("#desk-foto").hide();

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

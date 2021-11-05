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
                            <select class="selectpicker show-tick" data-style="btn-default" name="gender">
                                <option value=" " selected>Pilih</option>
                                @foreach (config('addon.master_data.jenis_kelamin') as $key => $value)
                                <option value="{{ $key }}" {{ isset($data['peserta']) ? (old('gender', $data['peserta']->user->information->gender) == ''.$key.'' ? 'selected' : '') : (old('gender') == ''.$key.'' ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tempat Lahir</label>
                        </div>
                        <div class="col-md-10">
                          <input type="text" class="form-control @error('place_of_birthday') is-invalid @enderror" name="place_of_birthday"
                            value="{{ (isset($data['peserta'])) ? old('place_of_birthday', $data['peserta']->user->information->place_of_birthday) : old('place_of_birthday') }}" placeholder="masukan tempat lahir...">
                          @include('components.field-error', ['field' => 'place_of_birthday'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Tanggal Lahir</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="date-picker form-control @error('tanggal_lahir') is-invalid @enderror" name="date_of_birthday"
                                    value="{{ (isset($data['peserta'])) ? (!empty($data['peserta']->user->information->date_of_birthday) ? old('tanggal_lahir', $data['peserta']->user->information->date_of_birthday->format('Y-m-d')) : '') : old('date_of_birthday') }}" placeholder="masukan tanggal lahir...">
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
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Alamat</label>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="masukan alamat...">{{ (isset($data['peserta'])) ? old('address', $data['peserta']->user->information->address) : old('address') }}</textarea>
                          @include('components.field-error', ['field' => 'address'])
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

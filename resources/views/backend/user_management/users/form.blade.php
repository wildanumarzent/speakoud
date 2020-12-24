@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form User
    </h6>
    <form action="{{ !isset($data['user']) ? route('user.store') : route('user.update', ['id' => $data['user']->id]) }}" method="POST">
    @csrf
    @if (isset($data['user']))
        @method('PUT')
        <input type="hidden" name="old_email" value="{{ $data['user']->email }}">
    @endif
      <div class="card-body">
        <div class="form-group row">
            <div class="col-md-2 text-md-right">
              <label class="col-form-label text-sm-right">Nama</label>
            </div>
            <div class="col-md-10">
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (isset($data['user'])) ? old('name', $data['user']->name) : old('name') }}" placeholder="masukan nama..." autofocus>
              @include('components.field-error', ['field' => 'name'])
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 text-md-right">
              <label class="col-form-label text-sm-right">Email</label>
            </div>
            <div class="col-md-10">
              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ (isset($data['user'])) ? old('email', $data['user']->email) : old('email') }}" placeholder="masukan email...">
              @include('components.field-error', ['field' => 'email'])
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 text-md-right">
              <label class="col-form-label text-sm-right">Username</label>
            </div>
            <div class="col-md-10">
              <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ (isset($data['user'])) ? old('username', $data['user']->username) : old('username') }}" placeholder="masukan username...">
              @include('components.field-error', ['field' => 'username'])
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
                        value="{{ (isset($data['user'])) ? old('phone', $data['user']->information->phone) : old('phone') }}" placeholder="masukan nomor telpon...">
                    @include('components.field-error', ['field' => 'phone'])
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 text-md-right">
              <label class="col-form-label text-sm-right">Alamat</label>
            </div>
            <div class="col-md-10">
              <textarea class="form-control @error('alamat') is-invalid @enderror" name="address" placeholder="masukan alamat...">{{ (isset($data['user'])) ? old('address', $data['user']->information->address) : old('address') }}</textarea>
              @include('components.field-error', ['field' => 'address'])
            </div>
        </div>
        <hr>
        @if (isset($data['user']))
          @if ($data['user']->roles[0]->name == 'developer' || $data['user']->roles[0]->name == 'administrator')
          <div class="form-group row">
              <div class="col-md-2 text-md-right">
                <label class="col-form-label text-sm-right">Roles</label>
              </div>
              <div class="col-md-10">
                <select class="selectpicker show-tick @error('roles') is-invalid @enderror" name="roles" data-style="btn-default">
                    <option value="" disabled selected>Pilih</option>
                    @foreach ($data['roles'] as $item)
                        <option value="{{ $item->name }}" {{ isset($data['user']) ? (old('roles', $data['user']->roles[0]->name) == $item->name ? 'selected' : '') : (old('roles') == $item->name ? 'selected' : '') }}>
                          {{ strtoupper($item->name) }}
                        </option>
                    @endforeach
                </select>
                @error('roles')
                <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                @enderror
              </div>
          </div>
          @else
          <input type="hidden" name="roles" value="{{ (isset($data['user'])) ? old('roles', $data['user']->roles[0]->name) : old('roles') }}">
          @endif
        @else
          <div class="form-group row">
            <div class="col-md-2 text-md-right">
              <label class="col-form-label text-sm-right">Roles</label>
            </div>
            <div class="col-md-10">
              <select class="selectpicker show-tick @error('roles') is-invalid @enderror" name="roles" data-style="btn-default">
                  <option value="" disabled selected>Pilih</option>
                  @foreach ($data['roles'] as $item)
                      <option value="{{ $item->name }}" {{ isset($data['user']) ? (old('roles', $data['user']->roles[0]->name) == $item->name ? 'selected' : '') : (old('roles') == $item->name ? 'selected' : '') }}>
                        {{ strtoupper($item->name) }}
                      </option>
                  @endforeach
              </select>
              @error('roles')
              <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
              @enderror
            </div>
          </div>
        @endif
        <div class="form-group row">
          <div class="col-md-2 text-md-right">
            <label class="col-form-label text-sm-right">Password</label>
          </div>
          <div class="col-md-10">
            <div class="input-group">
            <input type="password" id="password-field" class="form-control gen-field @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="masukan password...">
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
      <div class="card-footer">
        <div class="row">
          <div class="col-md-10 ml-sm-auto text-md-left text-right">
            <a href="{{ route('user.index') }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
            <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['user']) ? 'Simpan perubahan' : 'Simpan' }}</button>
          </div>
        </div>
      </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('jsbody')
<script>
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

@extends('layouts.frontend.layout-blank')

@section('content')

<div class="item-signbox">
    <div class="title-heading">
        <h3>@lang('strip.register_title')</h3>
    </div>
</div>
<div class="item-signbox form">
    @include('components.alert')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input type="hidden" name="roles" value="peserta_internal">
        <div class="form-group">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukan nama...">
            @include('components.field-error', ['field' => 'name'])
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan email...">
            @include('components.field-error', ['field' => 'email'])
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Masukan username...">
            @include('components.field-error', ['field' => 'username'])
        </div>
         <div class="form-group">
            <label class="custom-control custom-checkbox m-0">
                <input type="checkbox" class="custom-control-input" name="roles" id="instruktur" value="instruktur_internal">
                <span class="custom-control-label"> Want to become an instructor?</span>
            </label>
        </div>
        <div class="form-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Masukan password...">
            @include('components.field-error', ['field' => 'password'])
        </div>
        <div class="form-group">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Masukan konfirmasi password...">
            @include('components.field-error', ['field' => 'password_confirmation'])
        </div>
       

        <div class="box-btn text-center">
            <button class="btn btn-primary" type="submit"><span>Register</span></button>
        </div>
    </form>
</div>
@endsection

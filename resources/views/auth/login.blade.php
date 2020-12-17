@extends('layouts.frontend.layout-blank')

@section('content')

<div class="item-signbox">
    <div class="title-heading">
        <h3>@lang('strip.login_title')</h3>
    </div>
</div>
<div class="item-signbox form">
    {{-- @include('components.alert') --}}
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Masukan username...">
            @include('components.field-error', ['field' => 'username'])
        </div>
        <div class="form-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukan password...">
            @include('components.field-error', ['field' => 'password'])
        </div>
        <div class="form-group">
            <label class="custom-control custom-checkbox m-0">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="custom-control-label">Ingat saya</span>
            </label>
        </div>
        <div class="box-btn text-center">
            <button class="btn btn-primary" type="submit"><span>Login</span></button>
            <a class="link-forgot" href="{{ route('password.email') }}">Lupa Password?</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.frontend.layout-blank')

@section('content')

<div class="item-signbox">
    <div class="title-heading">
        <h3>@lang('strip.reset_password_title')</h3>
    </div>
</div>
<div class="item-signbox form">
    @include('components.alert')
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
        <div class="form-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Masukan password baru...">
            @include('components.field-error', ['field' => 'password'])
        </div>
        <div class="form-group">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Masukan konfirmasi password...">
            @include('components.field-error', ['field' => 'password_confirmation'])
        </div>
        <div class="box-btn text-center">
            <button class="btn btn-primary" type="submit"><span>Reset</span></button>
        </div>
    </form>
</div>
@endsection

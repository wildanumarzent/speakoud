@extends('layouts.frontend.layout-blank')

@section('content')

<div class="item-signbox">
    <div class="title-heading">
        <h3>@lang('strip.forgot_password_title')</h3>
    </div>
</div>
<div class="item-signbox form">
    <p class="text-center mb-2">@lang('strip.forgot_password_description')</p>
    @include('components.alert')
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan email...">
            @include('components.field-error', ['field' => 'email'])
        </div>
        <div class="box-btn text-center">
            <button class="btn btn-primary" type="submit"><span>Kirim</span></button>
        </div>
    </form>
</div>
@endsection

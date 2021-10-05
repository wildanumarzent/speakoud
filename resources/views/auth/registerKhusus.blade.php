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
        <input type="hidden" name="mataId" value="{{$mataId}}">
        <input type="hidden" name="roles" value="peserta_internal">
        <input type="hidden" name="type_pelatihan" value="{{$type_pelatihan}}">
        <div class="form-group">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukan nama...">
            @include('components.field-error', ['field' => 'name'])
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan email...">
            @include('components.field-error', ['field' => 'email'])
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

@extends('layouts.frontend.layout')

@section('content')
<h5 class="text-center text-muted font-weight-normal mb-4">Login to your account</h5>

@include('components.alert')
<!-- Form -->
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Masukan username...">
        @include('components.field-error', ['field' => 'username'])
    </div>
    <div class="form-group">
        <label class="form-label d-flex justify-content-between align-items-end">
            <div>Password</div>
            <a href="javascript:void(0)" class="d-block small">Lupa password?</a>
        </label>
        <div class="input-group">
            <input type="password" id="password-field" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukan password...">
            <div class="input-group-append">
                <span toggle="#password-field" class="input-group-text toggle-password fas fa-eye"></span>
            </div>
            @include('components.field-error', ['field' => 'password'])
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center m-0">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <span class="custom-control-label">Ingat saya</span>
        </label>
        <button type="submit" class="btn btn-primary">Log In</button>
    </div>
</form>
<!-- / Form -->
@endsection

@section('jsbody')
<script>
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");

    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
});
</script>
@endsection

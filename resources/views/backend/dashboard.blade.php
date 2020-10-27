@extends('layouts.backend.layout')

@section('content')
<h4 class="font-weight-bold py-3 mb-3">
    Dashboard
    <div class="text-muted text-tiny mt-1"><small class="font-weight-normal">Today is {{ now()->format('l, j F Y (H:i A)') }}</small></div>
</h4>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')

<div class="modal modal-fill-in fade" id="modals-fill-in">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <p class="text-white text-large text-center font-weight-light mb-3">Apakah anda akan mengakhiri Conference ini ?</p>
          <div class="input-group input-group-lg mb-3 d-flex justify-content-center">
            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-danger btn-lg">
                YA
                <form action="{{ route('conference.leave', ['id' => $data['conference']->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                </form>
            </a>&nbsp;&nbsp;&nbsp;
            <a href="{{ route('conference.room', ['id' => $data['conference']->id]) }}" class="btn btn-primary btn-lg" type="button">TIDAK</a>
          </div>
          <div class="text-center text-right text-white opacity-50">Jika tidak, anda akan kembali ke room</div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
$(window).on('load',function(){
    $('#modals-fill-in').modal({
        backdrop: 'static'
    });
});
</script>
@include('components.toastr')
@endsection

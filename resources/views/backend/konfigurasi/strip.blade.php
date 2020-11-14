@extends('layouts.backend.layout')

@section('content')
<div class="card">
    <h6 class="card-header">
      <i class="fas fa-edit"></i> Strip Text
    </h6>
    <div class="card-body">
        <form action="" method="GET">
        @foreach ($data['files'] as $key => $value)
        <div class="form-group row">
            <label class="col-form-label col-sm-2 text-sm-right">{{ str_replace('_', ' ', strtoupper($key)) }}</label>
            <div class="col-sm-10">
                <textarea class="form-control mb-1" name="lang[{{ $key }}]" placeholder="masukan isi...">{{ $value }}</textarea>
            </div>
        </div>
        @endforeach
        <hr>
        <div class="form-group row">
          <div class="col-sm-10 ml-sm-auto">
            <button type="submit" class="btn btn-primary" name="action" value="save">Simpan perubahan</button>
          </div>
        </div>
      </form>
    </div>
</div>
@endsection

@section('jsbody')

@include('components.toastr')
@endsection

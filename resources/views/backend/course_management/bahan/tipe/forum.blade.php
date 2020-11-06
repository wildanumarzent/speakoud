@extends('backend.course_management.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Tipe</label>
    </div>
    <div class="col-md-10">
        <select class="status custom-select form-control" name="tipe">
            @foreach (config('addon.label.forum_tipe') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->forum->tipe) == ''.$key.'' ? 'selected' : '') : (old('tipe') == ''.$key.'' ? 'selected' : '') }}>{{ $value['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>
@endsection

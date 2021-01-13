@extends('backend.course_management.template.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Option</label>
    </div>
    <div class="col-md-10">
        <select class="status custom-select form-control" name="tipe" id="tipe">
            @foreach (config('addon.label.forum_tipe') as $key => $value)
            <option value="{{ $key }}" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->forum->tipe) == ''.$key.'' ? 'selected' : '') : '' }}>{{ $value['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row" id="limit">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Limit Topik <i>(untuk peserta)</i></label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
        <input type="text" class="form-control @error('limit_topik') is-invalid @enderror" name="limit_topik"
            value="{{ (isset($data['bahan'])) ? old('limit_topik', $data['bahan']->forum->limit_topik) : old('limit_topik') }}" placeholder="masukan limit topik...">
        @include('components.field-error', ['field' => 'limit_topik'])
        </div>
    </div>
</div>
@endsection

@section('body')
    @if (!isset($data['bahan']))
    <script>
        $(document).ready(function() {
            $('#limit').hide();
            $('#tipe').on('change', function() {
                if ($('#tipe').val() == 1) {
                    $('#limit').toggle('slow');
                } else {
                    $('#limit').hide();
                }
            });
        });
    </script>
    @else
    <script>
        $(document).ready(function() {
            var tipe = $('#tipe').val();
            if (tipe == 1) {
                $('#limit').show();
            } else {
                $('#limit').hide();
            }
            $('#tipe').on('change', function() {
                if ($('#tipe').val() == 1) {
                    $('#limit').toggle('slow');
                } else {
                    $('#limit').hide();
                }
            });
        });
    </script>
    @endif
@endsection

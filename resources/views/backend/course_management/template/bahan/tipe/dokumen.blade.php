@extends('backend.course_management.template.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Dokumen</label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
        <input type="text" id="file_path" class="form-control @error('file_path') is-invalid @enderror" name="file_path" value="{{ isset($data['bahan']) ? old('file_path', $data['bahan']->dokumen->bankData->file_path) : old('file_path') }}" placeholder="Pilih dokumen dari bank data..." readonly onclick="openFm()">
        <div class="input-group-append">
            <button type="button" class="btn btn-warning" onclick="openFm()"><i class="las la-server"></i></button>
        </div>
        @include('components.field-error', ['field' => 'file_path'])
        </div>
    </div>
</div>
@endsection

@section('body')
<script>
    function openFm() {
        var win = window.open("/bank/data/filemanager/view?type-file=dokumen&view=button", "fm", "width=1400,height=800");
    }
</script>
@endsection

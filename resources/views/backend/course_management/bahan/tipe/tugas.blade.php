@extends('backend.course_management.bahan.form')

@section('content-bahan')
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Tanggal Mulai Pengumpulan</label>
    </div>
    <div class="col-md-10">
        <div class="input-group">
            <input type="text" class="datetime-picker form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai"
                value="{{ isset($data['bahan']) && !empty($data['bahan']->tugas->tanggal_mulai) ? old('tanggal_mulai', $data['bahan']->tugas->tanggal_mulai->format('Y-m-d H:i')) : old('tanggal_mulai') }}" placeholder="masukan tanggal mulai pengumpulan...">
            <div class="input-group-append">
                <span class="input-group-text"><i class="las la-calendar"></i></span>
            </div>
            @include('components.field-error', ['field' => 'tanggal_mulai'])
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
      <label class="col-form-label text-sm-right">Batas Akhir Pengumpulan</label>
    </div>
    <div class="col-md-10">
        <div class="input-group">
            <input type="text" class="datetime-picker form-control @error('tanggal_selesai') is-invalid @enderror" name="tanggal_selesai"
                value="{{ isset($data['bahan']) && !empty($data['bahan']->tugas->tanggal_selesai) ? old('tanggal_selesai', $data['bahan']->tugas->tanggal_selesai->format('Y-m-d H:i')) : old('tanggal_selesai') }}" placeholder="masukan batas akhir pengumpulan...">
            <div class="input-group-append">
                <span class="input-group-text"><i class="las la-calendar"></i></span>
            </div>
            @include('components.field-error', ['field' => 'tanggal_selesai'])
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Izinkan pengumupulan tugas setelah melewati batas ?</label>
    </div>
    <div class="col-sm-10">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="after_due_date" class="custom-control-input" value="1" {{ isset($data['bahan']) ? (old('after_due_date', $data['bahan']->tugas->after_due_date == '1') ? 'checked' : '') : (old('after_due_date') ? '' : '') }}>
            <span class="custom-control-label">Ya</span>
        </label>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Approval</label>
    </div>
    <div class="col-sm-10">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="approval" class="custom-control-input" value="1" {{ isset($data['bahan']) ? (old('approval', $data['bahan']->tugas->approval == '1') ? 'checked' : '') : (old('approval') ? '' : '') }}>
            <span class="custom-control-label">Ya</span>
        </label>
    </div>
</div>
@if (!isset($data['bahan']))
<div id="list">
    <div class="form-group row">
        <div class="col-md-2 text-md-right">
            <label class="col-form-label">Files</label>
        </div>
        <div class="col-md-9">
            <label class="custom-file mt-2">
                <label class="custom-file-label mt-2" for="file-0"></label>
                <input type="file" class="form-control custom-file-input file @error('files.0') is-invalid @enderror" id="file-0" lang="en" name="files[]" value="browse...">
                @error('files.0')
                    @include('components.field-error', ['field' => 'files.0'])
                @else
                <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.tugas.m')) }}</strong>, Max Upload : <strong>50 MB</strong></small>
                @enderror
            </label>
        </div>
        <div class="col-md-1" id="add-files">
            <button type="button" id="add" class="btn btn-success icon-btn btn-sm"><i class="las la-plus"></i></button>
        </div>
    </div>
</div>
<br>
@endif
@endsection

@section('body')
<script>
    $(function()  {
        var no = 1;
        $("#add").click(function() {
            $("#list").append(`
            <div class="form-group row num-list" id="delete-`+no+`">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label"></label>
                </div>
                <div class="col-md-9">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-`+no+`"></label>
                        <input type="file" class="form-control custom-file-input file @error('files.`+no+`') is-invalid @enderror" id="file-`+no+`" lang="en" name="files[]" value="browse...">
                        @include('components.field-error', ['field' => 'files.`+no+`'])
                    </label>
                </div>
                <div class="col-md-1">
                    <button type="button" id="remove" data-id="`+no+`" class="btn btn-danger icon-btn btn-sm"><i class="las la-times"></i></button>
                </div>
            </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = 19;
            if (noOfColumns < maxNum) {
                $("#add-files").show();
            } else {
                $("#add-files").hide();
            }

            // FILE BROWSE
            function callfileBrowser() {
                $(".custom-file-input").on("change", function() {
                    const fileName = Array.from(this.files).map((value, index) => {
                        if (this.files.length == index + 1) {
                            return value.name
                        } else {
                            return value.name + ', '
                        }
                    });
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            }
            callfileBrowser();

            no++;
        });
    });

    $(document).on('click', '#remove', function() {
        var id = $(this).attr("data-id");
        $("#delete-"+id).remove();
    });
</script>
@endsection

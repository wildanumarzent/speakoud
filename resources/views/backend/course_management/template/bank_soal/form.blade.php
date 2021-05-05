@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Soal
    </h6>
    <form action="{{ route('template.soal.store', ['id' => $data['kategori']->template_mata_id, 'kategoriId' => $data['kategori']->id, 'tipe' => Request::get('tipe')]) }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Pertanyaan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('pertanyaan') is-invalid @enderror" name="pertanyaan">{!! old('pertanyaan') !!}</textarea>
                    @include('components.field-error', ['field' => 'pertanyaan'])
                </div>
            </div>
            @if (Request::get('tipe') == '0')
            <div id="list">
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                        <label class="col-form-label text-sm-right">Pilihan</label>
                    </div>
                    <div class="col-md-10 d-flex align-items-center">
                        <label class="custom-control custom-radio mb-0">
                            <input type="radio" class="custom-control-input" name="jawaban" value="0" checked>
                            <span class="custom-control-label"></span>
                        </label>
                        <input type="text" class="form-control @error('pilihan.0') is-invalid @enderror" name="pilihan[]" value="{{ old('pilihan.0') }}" placeholder="masukan pilihan...">
                    </div>
                    @error ('pilihan.0')
                    <label class="error jquery-validation-error small form-text invalid-feedback text-center" style="display: inline-block;color:red;">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            @elseif (Request::get('tipe') == '1')
            <div id="list">
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                        <label class="col-form-label">Jawaban</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('jawaban.0') is-invalid @enderror" name="jawaban[]" value="{{ old('jawaban.0') }}" placeholder="masukan jawaban...">
                        @include('components.field-error', ['field' => 'jawaban.0'])
                    </div>
                </div>
            </div>
            @elseif (Request::get('tipe') == '3')
            <fieldset class="form-group">
                <div class="row">
                <div class="col-md-2 text-md-right  pt-sm-0">
                    <label class="col-form-label">Jawaban</label>
                </div>
                <div class="col-md-10">
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jawaban" value="1" {{ (old('jawaban') ? 'checked' : 'checked') }}>
                        <span class="form-check-label">
                            TRUE
                        </span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jawaban" value="0" {{ (old('jawaban') ? '' : '') }}>
                        <span class="form-check-label">
                            FALSE
                        </span>
                    </label>
                </div>
                </div>
            </fieldset>
            @endif
            @if (Request::get('tipe') < '2')
            <div class="form-group row" id="add-jawaban">
                <div class="col-md-2 text-md-right d-none d-md-block">
                        <label class="col-form-label">&nbsp;</label>
                    </div>
                <div class="col-md-10 d-flex justify-content-start">
                    <button type="button" id="add" class="btn btn-success"><i class="las la-plus"></i>{{ Request::get('tipe') == 0 ? 'Pilihan' : 'Jawaban' }}</button>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('template.soal.index', ['id' => $data['kategori']->template_mata_id, 'kategoriId' => $data['kategori']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
            &nbsp;&nbsp;
            <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">Simpan</button>
            &nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('jsbody')
@if (Request::get('tipe') == '0')
<script>
    $(function()  {
        var no=1;
        $("#add").click(function() {
            $("#list").append(`
                <div class="form-group row num-list align-items-center" id="delete-`+no+`">
                    <label class="col-form-label col-md-2 text-md-right"></label>
                    <div class="col-md-9 d-flex align-items-center">
                        <label class="custom-control custom-radio mb-0">
                            <input type="radio" class="custom-control-input" name="jawaban" value="`+no+`">
                            <span class="custom-control-label"></span>
                        </label>
                        <input type="text" class="form-control @error('pilihan.`+no+`') is-invalid @enderror" name="pilihan[]" value="{{ old('pilihan.`+no+`') }}" placeholder="masukan pilihan...">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" id="remove" data-id="`+no+`" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                    @error ('pilihan.`+no+`')
                    <label class="error jquery-validation-error small form-text invalid-feedback text-center" style="display: inline-block;">{{ $message }}</label>
                    @enderror
                </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = 9;
            if (noOfColumns < maxNum) {
                $("#add-jawaban").show();
            } else {
                $("#add-jawaban").hide();
            }

            no++;
        })
    });

    $(document).on('click', '#remove', function() {
        var id = $(this).attr("data-id");
        $("#delete-"+id).remove();
    });
</script>
@elseif (Request::get('tipe') == '1')
<script>
    $(function()  {
        var no=1;
        $("#add").click(function() {
            $("#list").append(`
                <div class="form-group row num-list align-items-center" id="delete-`+no+`">
                    <label class="col-form-label col-md-2 text-md-right"></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control @error('jawaban.`+no+`') is-invalid @enderror" name="jawaban[]" value="{{ old('jawaban.`+no+`') }}" placeholder="masukan jawaban...">
                        @include('components.field-error', ['field' => 'jawaban.`+no+`'])
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="remove" data-id="`+no+`" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = 19;
            if (noOfColumns < maxNum) {
                $("#add-jawaban").show();
            } else {
                $("#add-jawaban").hide();
            }
            no++;
        })
    });

    $(document).on('click', '#remove', function() {
        var id = $(this).attr("data-id");
        $("#delete-"+id).remove();
    });
</script>
@endif
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Soal Quiz
    </h6>
    <form action="{{ route('template.quiz.item.update', ['id' => $data['quiz']->id, 'itemId' => $data['quiz_item']->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Pertanyaan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('pertanyaan') is-invalid @enderror" name="pertanyaan">{!! old('pertanyaan', $data['quiz_item']->pertanyaan) !!}</textarea>
                    @include('components.field-error', ['field' => 'pertanyaan'])
                </div>
            </div>
        </div>
        <div id="list">
            @if ($data['quiz_item']->tipe_jawaban == 0)
                @foreach ($data['quiz_item']->pilihan as $key => $value)
                <div class="form-group row" id="delete-pilihan-{{ $key }}">
                    <label class="col-form-label col-sm-2 text-sm-right">
                        @if ($loop->first)
                        Pilihan
                        @endif
                    </label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="jawaban" value="{{ $key }}" {{ $key == $data['quiz_item']->jawaban ? 'checked' : '' }}>
                            <span class="custom-control-label"></span>
                        </label>
                        <input type="text" class="form-control @error('pilihan.'.$key) is-invalid @enderror" name="pilihan[]" value="{{ old('pilihan'.$key, $value) }}" placeholder="masukan pilihan...">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="del" data-id="{{ $key }}" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                    @error ('pilihan.'.$key)
                    <label class="error jquery-validation-error small form-text invalid-feedback text-center" style="display: inline-block;color:red;">{{ $message }}</label>
                    @enderror
                </div>
                @endforeach
            @elseif ($data['quiz_item']->tipe_jawaban == 1)
                @foreach ($data['quiz_item']->jawaban as $key => $value)
                <div class="form-group row" id="delete-jawaban-{{ $key }}">
                    <label class="col-form-label col-sm-2 text-sm-right">
                        @if ($loop->first)
                        Jawaban
                        @endif
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('jawaban.'.$key) is-invalid @enderror" name="jawaban[]" value="{{ old('jawaban.'.$key, $value) }}" placeholder="masukan jawaban...">
                        @include('components.field-error', ['field' => 'jawaban.'.$key])
                        </div>
                    <div class="col-sm-1">
                        <button type="button" id="del" data-id="{{ $key }}" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                </div>
                @endforeach
            @elseif ($data['quiz_item']->tipe_jawaban == 3)
                <fieldset class="form-group">
                    <div class="row">
                    <div class="col-md-2 text-md-right  pt-sm-0">
                        <label class="col-form-label">Jawaban</label>
                    </div>
                    <div class="col-md-10">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jawaban" value="1" {{ old('jawaban', $data['quiz_item']->jawaban == 1) ? 'checked' : 'checked' }}>
                            <span class="form-check-label">
                                TRUE
                            </span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jawaban" value="0" {{ old('jawaban', $data['quiz_item']->jawaban == 0) ? 'checked' : '' }}>
                            <span class="form-check-label">
                                FALSE
                            </span>
                        </label>
                    </div>
                    </div>
                </fieldset>
            @endif
        </div>
        @if ($data['quiz_item']->tipe_jawaban != 2)
            @if ($data['quiz_item']->tipe_jawaban == 0 && count($data['quiz_item']->pilihan) < 10 || $data['quiz_item']->tipe_jawaban == 1 && count($data['quiz_item']->jawaban) < 20)
            <div class="form-group row" id="add-jawaban">
                <div class="col-md-2 text-md-right d-none d-md-block">
                        <label class="col-form-label">&nbsp;</label>
                    </div>
                <div class="col-md-10 d-flex justify-content-start">
                    <button type="button" id="add" class="btn btn-success"><i class="las la-plus"></i>{{ $data['quiz_item']->tipe_jawaban == 0 ? 'Pilihan' : 'Jawaban' }}</button>
                </div>
            </div>
            @endif
        @endif
        <div class="card-footer text-center">
            <a href="{{ route('template.quiz.item', ['id' => $data['quiz']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
            &nbsp;&nbsp;
            <button type="submit" class="btn btn-primary" title="klik untuk menyimpan">Simpan Perubahan</button>
            &nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="Reset">Reset</button>
        </div>
    </form>
</div>
@if ($data['quiz_item']->tipe_jawaban == 0)
<input type="hidden" id="total-pilihan" value="{{ count($data['quiz_item']->pilihan) }}">
@elseif ($data['quiz_item']->tipe_jawaban == 1)
<input type="hidden" id="total-jawaban" value="{{ count($data['quiz_item']->jawaban) }}">
@endif
@endsection

@section('scripts')

@endsection

@section('jsbody')
@if ($data['quiz_item']->tipe_jawaban == 0)
<script>
    $(function()  {
        var totalPilihan = $("#total-pilihan").val();
        var integer = parseInt(totalPilihan);
        var no = integer+1;
        $("#add").click(function() {
            $("#list").append(`
                <div class="form-group row num-list" id="delete-`+no+`">
                    <label class="col-form-label col-sm-2 text-sm-right"></label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="jawaban" value="`+no+`">
                            <span class="custom-control-label"></span>
                        </label>
                        <input type="text" class="form-control @error('pilihan.`+no+`') is-invalid @enderror" name="pilihan[]" value="{{ old('pilihan'.`+no+`) }}" placeholder="masukan pilihan...">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="remove" data-id="`+no+`" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                    @error ('pilihan.`+no+`')
                    <label class="error jquery-validation-error small form-text invalid-feedback text-center" style="display: inline-block;">{{ $message }}</label>
                    @enderror
                </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = (10 - parseInt(totalPilihan));
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
    $(document).on('click', '#del', function() {
        var id = $(this).attr("data-id");
        $("#delete-pilihan-"+id).remove();
    });
</script>
@elseif ($data['quiz_item']->tipe_jawaban == 1)
<script>
    $(function()  {
        var totalJawaban = $("#total-jawaban").val();
        var integer = parseInt(totalJawaban);
        var no = integer+1;
        $("#add").click(function() {
            $("#list").append(`
                <div class="form-group row num-list" id="delete-`+no+`">
                    <label class="col-form-label col-sm-2 text-sm-right"></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('jawaban.`+no+`') is-invalid @enderror" name="jawaban[]" value="{{ old('jawaban.`+no+`') }}" placeholder="masukan jawaban...">
                        @include('components.field-error', ['field' => 'jawaban.`+no+`'])
                        </div>
                    <div class="col-sm-1">
                        <button type="button" id="remove" data-id="`+no+`" class="btn icon-btn btn-danger btn-sm"><span class="las la-times"></span></button>
                    </div>
                </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = (20 - parseInt(totalJawaban));
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
    $(document).on('click', '#del', function() {
        var id = $(this).attr("data-id");
        $("#delete-jawaban-"+id).remove();
    });
</script>
@endif
@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

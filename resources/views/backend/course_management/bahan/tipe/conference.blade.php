@extends('backend.course_management.bahan.form')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.css') }}">
@endsection

@section('content-bahan')
<fieldset class="form-group">
    <div class="row">
    <div class="col-md-2 text-md-right  pt-sm-0">
        <label class="col-form-label">Tipe Video Conference</label>
    </div>
    <div class="col-md-10">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="tipe" value="0" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->conference->tipe == '0') ? 'checked' : 'checked') : (old('tipe') ? 'checked' : 'checked') }}>
            <span class="form-check-label">
                BPPT Conference
            </span>
        </label>
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="tipe" value="1" {{ isset($data['bahan']) ? (old('tipe', $data['bahan']->conference->tipe == '1') ? 'checked' : '') : (old('tipe') ? '' : '') }}>
            <span class="form-check-label">
                Platform (zoom, gmeet, dll)
            </span>
        </label>
    </div>
    </div>
</fieldset>
<div class="form-group row" id="meeting-link">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Meeting Link (jika tipe platform)</label>
    </div>
    <div class="col-sm-10">
        <div class="input-group">
        <input type="text" class="form-control @error('meeting_link') is-invalid @enderror" name="meeting_link"
            value="{{ (isset($data['bahan']) && $data['bahan']->conference->tipe == 1) ? old('meeting_link', $data['bahan']->conference->meeting_link) : old('meeting_link') }}" placeholder="masukan link meeting...">
        @include('components.field-error', ['field' => 'meeting_link'])
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Tanggal</label>
    </div>
   <div class="col-md-10">
     <input type="text" class="date-picker form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ (isset($data['bahan'])) ? old('tanggal', $data['bahan']->conference->tanggal->format('Y-m-d')) : old('tanggal') }}" placeholder="masukan tanggal...">
     @include('components.field-error', ['field' => 'tanggal'])
   </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Jam Mulai</label>
    </div>
    <div class="col-md-10">
        <input type="text" class="time-picker form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ (isset($data['bahan'])) ? old('start_time', $data['bahan']->conference->start_time->format('H:i:s')) : old('start_time') }}" placeholder="masukan jam mulai...">
        @include('components.field-error', ['field' => 'start_time'])
    </div>
</div>
<div class="form-group row">
    <div class="col-md-2 text-md-right">
        <label class="col-form-label">Jam Selesai</label>
    </div>

    <div class="col-md-10">
      <input type="text" class="time-picker form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{ (isset($data['bahan'])) ? old('end_time', $data['bahan']->conference->end_time->format('H:i:s')) : old('end_time') }}" placeholder="masukan jam selesai...">
      @include('components.field-error', ['field' => 'end_time'])
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.js') }}"></script>
@endsection

@section('body')
<script>
$(function() {
    var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

    $( ".date-picker" ).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });

    $('.time-picker').bootstrapMaterialDatePicker({
      date: false,
      shortTime: false,
      format: 'HH:mm'
    });
});
</script>

@if (!isset($data['bahan']))
<script>
    $(document).ready(function() {
        $('#meeting-link').hide();
        $('input[type=radio][name=tipe]').change(function() {
            if (this.value == 1) {
                $('#meeting-link').toggle('slow');
            } else {
                $('#meeting-link').hide();
            }
        });
    });
</script>
@else
<script>
    $(document).ready(function() {
        var tipe = "{{ $data['bahan']->conference->tipe }}";
        if (tipe == 1) {
            $('#meeting-link').show();
        } else {
            $('#meeting-link').hide();
        }
        $('input[type=radio][name=tipe]').change(function() {
            if (this.value == 1) {
                $('#meeting-link').toggle('slow');
            } else {
                $('#meeting-link').hide();
            }
        });
    });
</script>
@endif
@endsection

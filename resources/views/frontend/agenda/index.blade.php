@extends('layouts.frontend.layout')
@section('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/fullcalendar/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/flatpickr/flatpickr.css') }}">
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
@endsection
@section('scripts')
<!-- Dependencies -->
{{-- <script src="{{ asset('assets/tmplts_backend/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/forms_pickers.js') }}"></script> --}}

<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/timepicker/timepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
{{-- <script src="{{ asset('assets/tmplts_backend/js/ui_fullcalendar.js') }}"></script> --}}
@endsection
@section('jsbody')
<script>
    $('.hide-meta').hide();
    $('.select2').select2();
    //datetime
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
@include('components.toastr')
@endsection
@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1 style="color:white">Agenda Kegiatan</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap bg-grey-alt">
    <div class="container">
        <div class="row">
            @include('frontend.agenda.kalender')
        </div>
    </div>
</div>
@endsection


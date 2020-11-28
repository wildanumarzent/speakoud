@extends('frontend.course.bahan')

{{-- @section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/plyr/plyr.css') }}">
@endsection --}}

@section('content-view')
<audio id="plyr-audio-player" controls style="width:100%;">
    <source src="{{ route('bank.data.stream', ['path' => $data['bahan']->audio->bankData->file_path]) }}" type="audio/mp3">
</audio>
@endsection

{{-- @section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/plyr/plyr.js') }}"></script>
@endsection

@section('body')
<script src="{{ asset('assets/tmplts_backend/js/ui_media-player.js') }}"></script>
@endsection --}}

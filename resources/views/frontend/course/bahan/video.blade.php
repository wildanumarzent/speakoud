@extends('frontend.course.bahan')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/plyr/plyr.css') }}">
@endsection

@section('content-view')
<div id="plyr-video-player">
    <video controls id="get-duration">
        <source src="{{ route('bank.data.stream', ['path' => $data['bahan']->video->bankData->file_path]) }}" type="video/mp4">
        Your browser does not support HTML video.
    </video>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/plyr/plyr.js') }}"></script>
@endsection

@section('body')
<script src="{{ asset('assets/tmplts_backend/js/ui_media-player.js') }}"></script>
@endsection
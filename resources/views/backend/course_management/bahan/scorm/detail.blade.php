@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/scorm/css/style.css') }}">
@endsection
@section('content')
    <div class="scorm-course">
      <iframe class="scorm-iframe" id="scorm-content" src="{{$data['path2']}}">
        {{-- path1 = odading
        path2 = scorm sample (golf) --}}
      </iframe>
    </div>

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/scormAPI.js') }}"></script>
@endsection

<script>
window.API.on("LMSInitialize", function() {
    document.getElementById("scorm-content").setAttribute("src", "");
});
</script>

@endsection

@extends('frontend.course.bahan')

@section('content-view')
<iframe class="scorm-iframe" id="scorm-content" style="width:100%;height:500px;" src=""></iframe>
<a href="javascript:;" data-uid="{{auth()->user()->id}}" data-uname="{{auth()->user()->name}}" data-src="{{ url($data['bahan']->scorm->package) }}" class="btn btn-sm btn-primary scorm-play" title="klik untuk mulai">
   Mulai
</a>
<a href="javascript:;" class="btn btn-sm btn-success scorm-stop" title="klik jika selesai">
    Selesai
 </a>
<div id="logDisplay"></div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/pipewerks.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/scormAPI.js') }}"></script>
<script>
    (function ($) {
        function setupScormApi() {
            window.API = new window.simplifyScorm.ScormAPI();

        }


        $(document).ready(setupScormApi());
        $('.scorm-play').on('click', function () {
            console.log(API);
            var src = $(this).attr('data-src');
            var uid = parseInt($(this).attr('data-uid'));
            var uname = $(this).attr('data-uname');
            var json = {
            "core": {
            "student_id": uid,
            "student_name": uname,
            "lesson_status": "incomplete",
            "lesson_location": "2",
        }
        };
        window.API.loadFromJSON(json);
        document.getElementById("scorm-content").setAttribute("src",src);
        });


        $('.scorm-stop').on('click', function () {
            var save = window.API.cmi.toJSON();
            console.log(save);
        });
    })(jQuery);
    </script>
    @endsection


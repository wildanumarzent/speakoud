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
<script>
    var API ={};
    (function ($) {
        function setupScormApi() {

            API.LMSInitialize = LMSInitialize;
            API.LMSGetLastError = LMSGetLastError;
            API.LMSGetValue = LMSGetValue;
            API.LMSSetValue = LMSSetValue;
            API.LMSCommit = LMSCommit;
            API.LMSFinish = LMSFinish;
            API.LMSGetDiagnostic = LMSGetDiagnostic;
            API.LMSGetErrorString = LMSGetErrorString;
            

        }

        function LMSInitialize(initializeInput) {
            displayLog("LMSInitialize: " + initializeInput);
            return true;
        }
        function LMSGetValue(cmi) {
            displayLog("LMSGetValue: " + cmi);
            return "";
        }
        function LMSSetValue(cmi, varvalue) {
            displayLog("LMSSetValue: " + cmi + "=" + varvalue);
            return "";
        }
        function LMSCommit(commitInput) {
            displayLog("LMSCommit: " + commitInput);
            return true;
        }
        function LMSFinish(finishInput) {
            displayLog("LMSFinish: " + finishInput);
            return true;
        }
        function LMSGetLastError() {
            displayLog("LMSGetLastError: ");
            return 0;
        }
        function LMSGetDiagnostic(errorCode) {
            displayLog("LMSGetDiagnostic: " + errorCode);
            return "";
        }
        function LMSGetErrorString(errorCode) {
            displayLog("LMSGetErrorString: " + errorCode);
            return "";
        }
        function displayLog(textToDisplay){
            console.log(textToDisplay);
        }

        $(document).ready(setupScormApi());
        $('.scorm-play').on('click', function () {
            console.log(API);
            var src = $(this).attr('data-src');
            var uid = parseInt($(this).attr('data-uid'));
            var uname = $(this).attr('data-uname');

            // pipwerks.SCORM.set("cmi.core.student_name",uname);
            // pipwerks.SCORM.get("cmi.core.student_name",uname);
            LMSSetValue("cmi.core.student_name",uname);
            LMSSetValue("cmi.core.student_id",uid);
        document.getElementById("scorm-content").setAttribute("src",src);
        });


        $('.scorm-stop').on('click', function () {
            pipwerks.SCORM.get("cmi.core.student_id");
        console.log(API);
        });
    })(jQuery);
    </script>
    @endsection


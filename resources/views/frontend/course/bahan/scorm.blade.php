@extends('frontend.course.bahan')



@section('content-view')
<iframe class="scorm-iframe" id="scorm-content" style="width:100%;height:500px;" src=""></iframe>
<a href="javascript:;" data-src="{{ url($data['bahan']->scorm->package) }}" class="btn btn-sm btn-primary scorm-play" title="klik untuk mulai">
   Mulai
</a>
<div id="logDisplay"></div>
@endsection




@section('script')
{{-- <script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/scormAPI.js') }}"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    var API = {};

    (function ($) {
        $(document).ready(setupScormApi());
        $('.scorm-play').on('click', function () {
            var src = $(this).attr('data-src');
        document.getElementById("scorm-content").setAttribute("src",src);
        });

        function setupScormApi() {
            API.LMSInitialize = LMSInitialize;
            API.LMSGetValue = LMSGetValue;
            API.LMSSetValue = LMSSetValue;
            API.LMSCommit = LMSCommit;
            API.LMSFinish = LMSFinish;
            API.LMSGetLastError = LMSGetLastError;
            API.LMSGetDiagnostic = LMSGetDiagnostic;
            API.LMSGetErrorString = LMSGetErrorString;
        }
        function LMSInitialize(initializeInput) {
            displayLog("LMSInitialize: " + initializeInput);
            return true;
        }
        function LMSGetValue(varname) {
            displayLog("LMSGetValue: " + varname);
            return "";
        }
        function LMSSetValue(varname, varvalue) {
            displayLog("LMSSetValue: " + varname + "=" + varvalue);
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
            var loggerWindow = document.getElementById("logDisplay");
            var item = document.createElement("div");
            item.innerText = textToDisplay;
            loggerWindow.appendChild(item);
        }
    })(jQuery);
    </script>
    @endsection


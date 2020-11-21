@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/scorm/css/style.css') }}">
@endsection
@section('content')
    <div class="scorm-course">
      <iframe class="scorm-iframe" id="scorm-content"></iframe>
    </div>


@section('scripts')
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/scormAPI.js') }}"></script>
@endsection
<div id="logDisplay">
<script>
var API = {};
(function ($) {

    $(document).ready(setupScormApi());

    function setupScormApi() {
        API.LMSInitialize = LMSInitialize;
        API.LMSGetValue = LMSGetValue;
        API.LMSSetValue = LMSSetValue;
        API.LMSCommit = LMSCommit;
        API.LMSFinish = LMSFinish;
        API.LMSGetLastError = LMSGetLastError;
        API.LMSGetDiagnostic = LMSGetDiagnostic;
        API.LMSGetErrorString = LMSGetErrorString;

        document.getElementById("scorm-content").setAttribute("src","http://127.0.0.1:8000/scorm-sample/onetwo/shared/launchpage.html");
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

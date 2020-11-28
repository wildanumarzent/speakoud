@extends('frontend.course.bahan')

@section('content-view')
<iframe class="scorm-iframe" id="scorm-content" style="width:100%;height:500px;" src=""></iframe>
@if($data['bahan']->scorm->repeatable == 0)
@if(empty(@$data['cpData']))
@if(@$data['cpData']['core']['lesson_status'] != 'completed')
<a href="javascript:;" data-uid="{{auth()->user()->id}}" data-sid="{{$data['bahan']->scorm->id}}" data-uname="{{auth()->user()->name}}" data-version="2004 3rd Generation" data-src="{{ url($data['bahan']->scorm->package) }}" class="btn btn-sm btn-primary scorm-play" title="klik untuk mulai"  data-checkpoint="{{$data['checkpoint']->checkpoint ?? 0}}">
    Mulai
 </a>
 <a href="javascript:;" class="btn btn-sm btn-success scorm-exit">
    Selesai
 </a>
 @else
 @endif
@endif
@else
<a href="javascript:;" data-uid="{{auth()->user()->id}}" data-sid="{{$data['bahan']->scorm->id}}" data-uname="{{auth()->user()->name}}" data-version="2004 3rd Generation" data-src="{{ url($data['bahan']->scorm->package) }}" class="btn btn-sm btn-primary scorm-play" title="klik untuk mulai"  data-checkpoint="{{$data['checkpoint']->checkpoint ?? 0}}">
    Mulai
 </a>
 <a href="javascript:;" class="btn btn-sm btn-success scorm-exit">
    Selesai
 </a>
@endif

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/pipewerks.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scorm/js/scorm-api/scormAPI.js') }}"></script>
<script>
    var uid,sid;
    (function ($) {
        function setupScormApi() {
            window.API = new window.simplifyScorm.ScormAPI();
        }


        $(document).ready(setupScormApi());
        $('.scorm-play').on('click', function () {
            var version = $(this).attr('data-version');
            var checkpoint = $(this).attr('data-checkpoint');
            var src = $(this).attr('data-src');
            uid = parseInt($(this).attr('data-uid'));
            sid = parseInt($(this).attr('data-sid'));
            var uname = $(this).attr('data-uname');
            if(checkpoint != 0){
                var mySave = JSON.parse(checkpoint);
            }else{
                var mySave = {
            "core": {
            "student_id": uid,
            "student_name": uname,
            "lesson_status": "incomplete",
            }
            }
        };
        window.API.loadFromJSON(mySave);
        document.getElementById("scorm-content").setAttribute("src",src);
        });

        window.API.on("LMSSetValue", function() {
                catchUpdate();
            });

            window.API.on("LMSFinish", function() {
                catchUpdate();
                window.location.reload(1);
            });

        function catchUpdate(){
            let _token   = $('meta[name="csrf-token"]').attr('content');
            let backup = window.API.cmi.toJSON();
            $.ajax({
        url: "/scorm/checkpoint/store",
        type:"POST",
        data:{
          user_id:uid,
          scorm_id:sid,
          checkpoint:backup,
          _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
            $('.success').text(response.success);
          }
        },
       });
		}
        $('.scorm-exit').on('click', function () {
            catchUpdate();
            window.location.reload(1);
        });
    })(jQuery);
    </script>
    @endsection


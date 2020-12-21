@extends('layouts.backend.layout')


@section('content')
<div class="container">
    <h2 class="text-center font-weight-bolder pt-5">
        {{$data['announcement']->title}}
    </h2>
    <div class="text-center text-muted text-big mx-auto mt-3">
        {!! $data['announcement']->sub_content !!}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex flex-wrap mt-3 card-header">
                    <div class="mr-3"><i class="vacancy-tooltip ion ion-ios-person text-primary" title="Location"></i>&nbsp; {{$data['announcement']->user->name}}</div>
                    <div class="mr-3"><i class="vacancy-tooltip ion ion-md-time text-light" title="Employment"></i>&nbsp; {{$data['announcement']->created_at->diffForhumans()}}</div>
                </div>
                <div class="mt-3 mb-4 ml-4">
                   {!!$data['announcement']->content!!}
                </div>
        </div>
        </div>

    <div class="col-md-9">
        @livewire('komentar-form',['model' => $data['announcement']])
    </div>
    <div class="col-md-3">
        <!-- Attached files -->
        <div class="card mb-4">
           <h6 class="card-header">Attached files</h6>
           <div class="card-body p-3">
               <div class="row no-gutters">
                   {{-- <div class="col-md-6 col-lg-12 col-xl-6 p-1">

                       <div class="project-attachment ui-bordered p-2">
                           <div class="project-attachment-img" style="background-image: url(/img/bg/5.jpg)"></div>
                           <div class="media-body ml-3">
                               <strong class="project-attachment-filename">image_1.jpg</strong>
                               <div class="text-muted small">527KB</div>
                               <div>
                                   <a href="javascript:void(0)">View</a> &nbsp;
                                   <a href="javascript:void(0)">Download</a>
                               </div>
                           </div>
                       </div>

                   </div> --}}
                   @if(!empty($data['announcement']->attachment))
                   <div class="p-1">

                       <div class="project-attachment ui-bordered p-2">
                           <div class="project-attachment-file display-4">
                               <i class="far fa-file"></i>
                               <a href="{{$data['announcement']->attachment}}">Download</a>
                           </div>
                       </div>

                   </div>
                   @endif
               </div>
           </div>
       </div>
       <!-- / Attached files -->
               </div>
</div>
</div>



@endsection

@section('scripts')
    <script src="{{ asset('assets/tmplts_backend/js/pages_vacancies.js') }}"></script>
@endsection

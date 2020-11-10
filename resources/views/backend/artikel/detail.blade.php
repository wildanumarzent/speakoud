@extends('layouts.backend.layout')

@section('content')

<div class="controller">
<!-- alert -->
<div class="card">
<div class="card-header">
    <center><h1>{{$data['artikel']->title}}</h1></center>
</div>
<div class="container-fluid">
<img src="{{@$data['artikel']->getCover($data['artikel']->cover)}}" class="" style="width : 50%; height:50%px;object-fit:cover">
</div>
<div class="card-body">
<small class="text-muted">{{$data['artikel']->created_at->diffForHumans()}} ,  {{$data['artikel']->sender_name}} | Created By : {{$data['artikel']->user->name}} Updated By : {{@$data['artikel']->userUpdate->name}} | Hits : {{$data['artikel']->viewer}}</small>
    <p>{!!$data['artikel']->content!!}</p>
</div>
</div>
<hr>
{{-- @include('components.komentar') --}}
</div>
@endsection

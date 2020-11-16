@extends('frontend.course.bahan')

@section('content-view')
<iframe src="{{ $data['bahan']->link->meeting_link }}" frameborder="0" style="width:100%;height:500px;">
</iframe>
@endsection

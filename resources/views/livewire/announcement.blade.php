@foreach($announcement as $anno)
<div class="alert alert-warning alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="las la-bullhorn mr-2"></i>{{$anno->title}} <a href="{{route('announcement.show',['announcement' => $anno->id])}}">Selengkapnya <i class="las la-external-link-alt"></i></a>
</div>
@endforeach

@if (Request::segment(3) == 'mata')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        <strong>{!! $data['program']->judul !!}</strong>
      </div>
    </div>
</div>
@endif

@if (Request::segment(3) == 'materi')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['mata']->program->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['mata']->judul !!}</strong>
      </div>
    </div>
</div>
@endif

@if (Request::segment(3) == 'bahan')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['materi']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['materi']->mata->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['materi']->judul !!}</strong>
      </div>
    </div>
</div>
@endif

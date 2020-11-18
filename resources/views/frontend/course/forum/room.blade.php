@extends('layouts.backend.layout')

@section('content')
<div class="card mb-4">
    <div class="card-header">
      <div class="media flex-wrap align-items-center">
        <img src="{{ $data['topik']->creator->getPhoto($data['topik']->creator->photo['filename']) }}" class="d-block ui-w-40 rounded-circle" alt>
        <div class="media-body ml-3">
          <a href="javascript:void(0)">{!! $data['topik']->subject !!}</a>
          <div class="text-muted small">{{ $data['topik']->created_at->format('l, j F Y, H:i A') }} - {{ $data['topik']->creator['name'] }}</div>
        </div>
        <div class="media-body ml-3 text-right">
            <div class="btn-group dropdown" id="hover-dropdown-demo">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" data-trigger="hover" aria-expanded="false">Action</button>
                <div class="dropdown-menu" x-placement="bottom-start">
                  <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="{{ $data['topik']->pin == 1 ? 'Unpin' : 'Pin' }} Topik">
                    <i class="las la-thumbtack"></i> {{ $data['topik']->pin == 1 ? 'Unpin' : 'Pin' }}
                    <form action="{{ route('forum.topik.pin', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                  </a>
                  <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="{{ $data['topik']->lock == 1 ? 'Unlock' : 'Lock' }} Topik">
                    <i class="las la-lock"></i> {{ $data['topik']->lock == 1 ? 'Unlock' : 'Lock' }}
                    <form action="{{ route('forum.topik.lock', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                  </a>
                  <a href="" class="dropdown-item" title="Edit topik">
                    <i class="las la-pen"></i> Edit
                  </a>
                  <a href="" class="dropdown-item" title="Hapus topik">
                    <i class="las la-trash"></i> Hapus
                  </a>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      {!! $data['topik']->message !!}
    </div>
    <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
      <div class="px-4 pt-3">
      </div>
      <div class="px-4 pt-3">
        <button type="button" class="btn btn-primary"><i class="ion ion-md-create"></i>&nbsp; Reply</button>
      </div>
    </div>
</div>
@endsection

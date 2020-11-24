@extends('frontend.course.bahan')

@section('style')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content-view')
<div class="card mb-1">
    <div class="card-header d-none d-md-block">
      <div class="row no-gutters align-items-center">
        <div class="col">
            <button type="button" class="btn btn-primary icon-btn-only-sm" data-toggle="modal" data-target="#form-topik" title="klik untuk menambah topik">
                <i class="las la-plus"></i><span>Topik</span>
            </button>
        </div>
        <div class="col-4 text-muted">
          <div class="row no-gutters align-items-center">
            <div class="col-4">Replies</div>
            <div class="col-8">Last update</div>
          </div>
        </div>
      </div>
    </div>

    @foreach ($data['topik'] as $item)
    <div class="card-body py-3">

      <div class="row no-gutters align-items-center">
        <div class="col">
          @role ('peserta_internal|peserta_mitra')
          <a href="{{ route('forum.topik.star', ['id' => $data['bahan']->forum->id, 'topikId' => $item->id]) }}">
              @if ($item->starPerUser()->count() == 0)
              <i class="far fa-star" style="font-size: 1.2em;"></i>
              @else
              <i class="fas fa-star text-warning" style="font-size: 1.2em;"></i>
              @endif
          </a>
          @else
          @if ($item->pin == 1)
          <i class="las la-thumbtack" style="font-size: 1.2em;" title="Topik di pin"></i>
          @endif
          @endrole
          <a href="{{ route('forum.topik.room', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" class="text-big">{!! $item->subject !!}</a>
          @if ($item->lock == 1)
          <span class="badge badge-danger align-text-bottom ml-1">Locked</span>
          @endif
          <div class="text-muted small mt-1">{{ $item->created_at->format('d F Y') }} &nbsp;·&nbsp; <a href="javascript:void(0)" class="text-muted">{{ $item->creator['name'] }}</a></div>
        </div>
        <div class="d-none d-md-block col-4">

          <div class="row no-gutters align-items-center">
            <div class="col-4">{{ $item->diskusi()->count() }}</div>
            <div class="media col-8 align-items-center">
                @if ($item->lastPost()->count() > 0)
                @foreach ($item->lastPost as $last)
                <img src="{{ $last->user->getPhoto($last->user->photo['filename']) }}" alt="" class="d-block ui-w-30 rounded-circle">
                <div class="media-body flex-truncate ml-2">
                  <div class="line-height-1 text-truncate">{{ $last->created_at->diffForHumans() }}</div>
                  <a href="javascript:void(0)" class="text-muted small text-truncate">by {{ Str::limit($last->user['name'], 20) }}</a>
                </div>
                @endforeach
                @else
                <img src="{{ $item->creator->getPhoto($item->creator->photo['filename']) }}" alt="" class="d-block ui-w-30 rounded-circle">
                <div class="media-body flex-truncate ml-2">
                  <div class="line-height-1 text-truncate">{{ $item->created_at->diffForHumans() }}</div>
                  <a href="javascript:void(0)" class="text-muted small text-truncate">by {{ Str::limit($item->creator['name'], 20) }}</a>
                </div>
                @endif
            </div>
          </div>

        </div>
      </div>

    </div>
    <hr class="m-0">
    @endforeach
    @if ($data['topik']->count() == 0)
    <div class="card-body py-3">
        <div class="row no-gutters align-items-center">
            <i><strong style="color: red;"> ! Tidak ada topik ! </strong></i>
        </div>
    </div>
    <hr class="m-0">
    @endif
</div>

@include('frontend.course.forum.modal-topik')
@endsection

@section('body')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/ui_tooltips.js') }}"></script>

@include('includes.tiny-mce-with-fileman')
@endsection

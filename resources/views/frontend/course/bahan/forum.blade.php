@extends('frontend.course.bahan')

@section('content-view')
<div class="row mb-4">
    <div class="col-md-6 text-left">
        <strong>Tipe :
            <i>{{ config('addon.label.forum_tipe.'.$data['bahan']->forum->tipe)['title'] }}</i>
            <i class="las la-info-circle text-primary" data-toggle="popover" data-content="{{ config('addon.label.forum_tipe.'.$data['bahan']->forum->tipe)['description'] }}" data-original-title="Description" ></i>
        </strong>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('forum.topik.create', ['id' => $data['bahan']->forum->id]) }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah topik">
            <i class="las la-plus"></i><span>Topik</span>
        </a>
    </div>
</div>
<div class="card-datatable table-responsive">
    <table class="table table-striped table-bordered mb-0">
        <thead>
            <tr>
                <th>Discussion</th>
                <th style="width: 200px;">Started By</th>
                <th style="width: 200px;">Last Post</th>
                <th style="width: 80px;">Replies</th>
                <th style="width: 113px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($data['topik']->count() == 0)
            <tr>
                <td colspan="7" align="center">
                    <i><strong style="color: red;"> ! Data Topik kosong ! </strong></i>
                </td>
            </tr>
            @endif
            @foreach ($data['topik'] as $item)
            <tr>
                <td>
                    @role ('peserta_internal|peserta_mitra')
                    <i class="far fa-star text-primary mr-2" style="font-size: 1em;"></i>
                    @else
                    @if ($item->pin == 1)
                    <i class="las la-thumbtack mr-2" style="font-size: 1.5em;"></i>
                    @endif
                    @endif
                    <a href="">{!! $item->subject !!}</a>
                    @if ($item->lock == 1)
                    <span class="badge badge-danger">Locked</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $item->creator['name'] }}</strong> <br>
                    {{ $item->created_at->format('d M Y') }}
                </td>
                <td>
                    @if ($item->lastPost()->count() > 0)
                    @foreach ($item->lastPost as $last)
                    <strong>{{ $last->user['name'] }}</strong> <br>
                    {{ $last->created_at->format('d M Y') }}
                    @endforeach
                    @else
                    <strong>{{ $item->creator['name'] }}</strong> <br>
                    {{ $item->created_at->format('d M Y') }}
                    @endif
                </td>
                <td>
                    <h5 class="text-center">{{ $item->diskusi()->count() }}</h5>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-primary btn-sm" title="{{ $item->pin == 1 ? 'Unpin' : 'Pin' }} this discussion">
                        <i class="las la-thumbtack"></i>
                        <form action="{{ route('forum.topik.pin', ['id' => $data['bahan']->forum->id, 'topikId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-danger btn-sm" title="{{ $item->lock == 1 ? 'Unlock' : 'Lock' }} this discussion">
                        <i class="las la-lock"></i>
                        <form action="{{ route('forum.topik.lock', ['id' => $data['bahan']->forum->id, 'topikId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

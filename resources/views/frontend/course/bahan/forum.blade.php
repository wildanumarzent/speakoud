@extends('frontend.course.bahan')

@section('style')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content-view')
<div class="card-datatable table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 10px;"></th>
                <th>
                    <button type="button" class="btn btn-primary icon-btn-only-sm btn-sm" data-toggle="modal" data-target="#form-topik" title="klik untuk menambah topik">
                        <i class="las la-plus"></i><span>Topik Diskusi</span>
                    </button>
                </th>
                <th style="width:180px;">Started By</th>
                <th style="width:180px;">Last Post</th>
                <th style="width:20px;" class="text-center">Replies</th>
                <th style="width:170px;"></th>
            </tr>
        </thead>
        <tbody>
            @if ($data['topik']->count() == 0)
            <tr>
                <td colspan="6" class="text-center">
                    <strong style="color: red;">
                        ! Tidak ada diskusi !
                    </strong>
                </td>
            </tr>
            @endif
            @foreach ($data['topik'] as $item)
            <tr>
                <td>
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
                        <i class="las la-thumbtack" style="font-size: 2em;" title="Topik di pin"></i>
                        @else
                        <a href="{{ route('forum.topik.star', ['id' => $data['bahan']->forum->id, 'topikId' => $item->id]) }}">
                            @if ($item->starPerUser()->count() == 0)
                            <i class="far fa-star" style="font-size: 1.2em;"></i>
                            @else
                            <i class="fas fa-star text-warning" style="font-size: 1.2em;"></i>
                            @endif
                        </a>
                        @endif
                    @endrole
                </td>
                <td>
                    <a href="{{ route('forum.topik.room', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" class="text-big">{!! $item->subject !!}</a>
                    @if ($item->lock == 1)
                    <span class="badge badge-danger align-text-bottom ml-1">Locked</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $item->creator->getPhoto($item->creator->photo['filename']) }}" class="ui-w-40 rounded-circle">
                        </div>
                        <div class="col-md-4">
                            <a class="text-muted small text-truncate">
                                by {{ Str::limit($item->creator['name'], 20) }} <br>
                                {{ $item->created_at->diffForHumans() }}
                            </a>
                        </div>
                    </div>
                </td>
                <td>
                    @if ($item->lastPost()->count() > 0)
                        @foreach ($item->lastPost as $last)
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $last->user->getPhoto($last->user->photo['filename']) }}" class="ui-w-40 rounded-circle">
                            </div>
                            <div class="col-md-4">
                                <a class="text-muted small text-truncate">
                                    by {{ Str::limit($last->user['name'], 15) }} <br>
                                    {{ $last->created_at->diffForHumans() }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $item->creator->getPhoto($item->creator->photo['filename']) }}" class="ui-w-40 rounded-circle">
                        </div>
                        <div class="col-md-4">
                            <a class="text-muted small text-truncate">
                                by {{ Str::limit($item->creator['name'], 15) }} <br>
                                {{ $item->created_at->diffForHumans() }}
                            </a>
                        </div>
                    </div>
                    @endif
                </td>
                <td class="text-center"><strong>{{ $item->diskusi()->count() }}</strong></td>
                <td>
                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-primary icon-btn btn-sm" title="{{ $item->pin == 1 ? 'Unpin' : 'Pin' }} Topik">
                        <i class="las la-thumbtack"></i>
                        <form action="{{ route('forum.topik.pin', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-warning icon-btn btn-sm" title="{{ $item->lock == 1 ? 'Unlock' : 'Lock' }} Topik">
                        <i class="las la-lock"></i>
                        <form action="{{ route('forum.topik.lock', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                    <a href="{{ route('forum.topik.edit', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" class="btn btn-info icon-btn btn-sm" title="Edit topik">
                        <i class="las la-pen"></i>
                    </a>
                    <a href="javascript:;" data-forumid="{{ $item->forum_id }}" data-id="{{ $item->id }}" class="btn btn-danger icon-btn btn-sm js-sa2-delete" title="Hapus topik">
                        <i class="las la-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('frontend.course.forum.modal-topik')
@endsection

@section('body')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/ui_tooltips.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var forum_id = $(this).attr('data-forumid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus topik ini, data yang bersangkutan dengan topik ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
                type: "warning",
                confirmButtonText: "Ya, hapus!",
                customClass: {
                    confirmButton: "btn btn-danger btn-lg",
                    cancelButton: "btn btn-info btn-lg"
                },
                showLoaderOnConfirm: true,
                showCancelButton: true,
                allowOutsideClick: () => !Swal.isLoading(),
                cancelButtonText: "Tidak, terima kasih",
                preConfirm: () => {
                    return $.ajax({
                        url: "/forum/"+ forum_id +"/topik/" + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json'
                    }).then(response => {
                        if (!response.success) {
                            return new Error(response.message);
                        }
                        return response;
                    }).catch(error => {
                        swal({
                            type: 'error',
                            text: 'Error while deleting data. Error Message: ' + error
                        })
                    });
                }
            }).then(response => {
                if (response.value.success) {
                    Swal.fire({
                        type: 'success',
                        text: 'topik berhasil dihapus'
                    }).then(() => {
                        window.location.href = '/course/{{ $data['bahan']->mata_id }}/bahan/{{ $data['bahan']->id }}/forum';
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        text: response.value.message
                    }).then(() => {
                        window.location.reload();
                    })
                }
            });
        })
    });
</script>
@include('includes.tiny-mce-with-fileman')
@endsection

@extends('frontend.course.roomCourse')

@section('style')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content-view')
@if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && $data['bahan']->forum->tipe == 1)
    @if (empty($data['bahan']->forum->limit_topik) || !empty($data['bahan']->forum->limit_topik) && $data['bahan']->forum->topikByUser()->count() < $data['bahan']->forum->limit_topik)
    <button type="button" class="btn btn-primary icon-btn-only-sm btn-sm mb-2" data-toggle="modal" data-target="#form-topik" title="klik untuk menambah topik">
        <i class="las la-plus"></i><span>Topik</span>
    </button>
    @endif
@endif
@if (!auth()->user()->hasRole('peserta_internal|peserta_mitra') || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && $data['bahan']->forum->creator_id == auth()->user()->id)
<button type="button" class="btn btn-primary icon-btn-only-sm btn-sm mb-2" data-toggle="modal" data-target="#form-topik" title="klik untuk menambah topik">
    <i class="las la-plus"></i><span>Topik</span>
</button>
@endif
<div class="table-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 105px;">
                    Pin
                </th>
                <th>Topik</th>
                <th style="width: 190px;">Dibuat</th>
                <th style="width: 190px;">Post Terakhir</th>
                <th style="width: 15px;">Replies</th>
                <th style="width: 180px;">Aksi</th>
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
                    <span class="badge badge-danger align-text-bottom ml-1">Dikunci</span>
                    @endif
                </td>
                <td>
                    <a class="text-muted small text-truncate">
                        Oleh <strong>{{ Str::limit($item->creator['name'], 20) }}</strong> <br>
                        {{ $item->created_at->diffForHumans() }}
                    </a>
                </td>
                <td>
                    @if ($item->lastPost()->count() > 0)
                        @foreach ($item->lastPost as $last)
                        <a class="text-muted small text-truncate">
                            Oleh <strong>{{ Str::limit($last->user['name'], 15) }}</strong> <br>
                            {{ $last->created_at->diffForHumans() }}
                        </a>
                        @endforeach
                    @else
                        <a class="text-muted small text-truncate">
                            Oleh <strong>{{ Str::limit($item->creator['name'], 15) }}</strong> <br>
                            {{ $item->created_at->diffForHumans() }}
                        </a>
                    @endif
                </td>
                <td class="text-center"><strong class="badge badge-info">{{ $item->diskusi()->count() }}</strong></td>
                <td>
                    @if (auth()->user()->hasRole('administrator|internal|mitra') || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && $item->creator_id == auth()->user()->id)
                    <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-primary icon-btn btn-sm" title="{{ $item->pin == 1 ? 'Unpin' : 'Pin' }} Topik">
                        <i class="las la-thumbtack"></i>
                        <form action="{{ route('forum.topik.pin', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                    </a>
                    @endif
                    @if (auth()->user()->hasRole('administrator|internal|mitra') || $item->creator_id == auth()->user()->id)
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
                    @else
                    <a href="{{ route('forum.topik.room', ['id' => $item->forum_id, 'topikId' => $item->id]) }}" class="btn btn-info btn-sm btn-block" title="detail topik">
                        Detail
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('frontend.course.forum.modal-topik')
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
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
@role ('peserta_internal|peserta_mitra')
    @include('includes.tiny-mce')
@else
    @include('includes.tiny-mce-with-fileman')
@endrole
@endsection

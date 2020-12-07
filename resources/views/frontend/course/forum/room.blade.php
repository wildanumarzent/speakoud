@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['forum']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['forum']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['forum']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['forum']->bahan->judul !!}</strong>
      </div>
    </div>
</div>

<div class="text-left">
    <a href="{{ route('course.bahan', ['id' => $data['forum']->mata_id, 'bahanId' => $data['forum']->bahan_id,  'tipe' => 'forum']) }}" class="btn btn-secondary rounded-pill" title="kembali ke forum"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

{{-- topik --}}
<div class="card mb-4">
    <div class="card-header">
      <div class="media flex-wrap align-items-center">
        <img src="{{ $data['topik']->creator->getPhoto($data['topik']->creator->photo['filename']) }}" class="d-block ui-w-40 rounded-circle" alt>
        <div class="media-body ml-3">
          <a href="javascript:void(0)">{!! $data['topik']->subject !!}</a>
          <div class="text-muted small">{{ $data['topik']->created_at->format('l, j F Y, H:i A') }} - {{ $data['topik']->creator['name'] }}</div>
        </div>
        <div class="media-body ml-3 text-right">
            @if (auth()->user()->hasRole('administrator|internal|mitra') || $data['topik']->creator_id == auth()->user()->id)
            <div class="btn-group dropdown" id="hover-dropdown-demo">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" data-trigger="hover" aria-expanded="false">Action</button>
                <div class="dropdown-menu" x-placement="bottom-start">
                @if (auth()->user()->hasRole('administrator|internal|mitra') || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') && $data['topik']->creator_id == auth()->user()->id)
                  <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="{{ $data['topik']->pin == 1 ? 'Unpin' : 'Pin' }} Topik">
                    <i class="las la-thumbtack"></i> {{ $data['topik']->pin == 1 ? 'Unpin' : 'Pin' }}
                    <form action="{{ route('forum.topik.pin', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                  </a>
                  @endif
                  <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="{{ $data['topik']->lock == 1 ? 'Unlock' : 'Lock' }} Topik">
                    <i class="las la-lock"></i> {{ $data['topik']->lock == 1 ? 'Unlock' : 'Lock' }}
                    <form action="{{ route('forum.topik.lock', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                  </a>
                  <a href="{{ route('forum.topik.edit', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id]) }}" class="dropdown-item" title="Edit topik">
                    <i class="las la-pen"></i> Edit
                  </a>
                  <a href="javascript:;" data-forumid="{{ $data['topik']->forum_id }}" data-id="{{ $data['topik']->id }}" class="dropdown-item js-sa2-delete" title="Hapus topik">
                    <i class="las la-trash"></i> Hapus
                  </a>
                </div>
            </div>
            @endif
        </div>
      </div>
    </div>
    <div class="card-body">
      {!! $data['topik']->message !!}
    </div>
    <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
      <div class="px-4 pt-3">
          @if (!empty($data['topik']->attachment))
          <a href="{{ asset('userfile/attachment/forum/'.$data['topik']->forum_id.'/'.$data['topik']->attachment) }}" class="badge badge-outline-success"><i class="las la-download"></i> Download attachment</a>
          @endif
      </div>
      <div class="px-4 pt-3">
          @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra') || auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['topik']->limit_reply) || !empty($data['topik']->limit_reply) && $data['topik']->diskusiByUser()->count() < $data['topik']->limit_reply)
          <button type="button" class="btn btn-primary reply" data-toggle="modal" data-target="#form-reply" data-parent="0"><i class="ion ion-md-create"></i>&nbsp; Reply</button>
          @endif
      </div>
    </div>
</div>

{{-- diskusi --}}
@foreach ($data['topik']->diskusi as $diskusi)
<div class="card ml-4 mb-3">
    <div class="card-body">
      <div class="media">
        <img src="{{ $diskusi->user->getPhoto($diskusi->user->photo['filename']) }}" alt="" class="d-block ui-w-40 rounded-circle">
        <div class="media-body ml-4">
          <div class="float-right text-muted small">
            @if (auth()->user()->hasRole('developer|administrator|internal|mitra') || $diskusi->user_id == auth()->user()->id)
            <div class="btn-group dropdown" id="hover-dropdown-demo">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" data-trigger="hover" aria-expanded="false">Action</button>
                <div class="dropdown-menu" x-placement="bottom-start">
                  <a href="{{ route('forum.topik.reply.edit', ['id' => $data['topik']->forum_id, 'topikId' => $data['topik']->id, 'replyId' => $diskusi->id]) }}" class="dropdown-item" title="Edit diskusi">
                    <i class="las la-pen"></i> Edit
                  </a>
                  <a href="javascript:;" data-forumid="{{ $data['topik']->forum_id }}" data-topikid="{{ $data['topik']->id }}" data-id="{{ $diskusi->id }}" class="dropdown-item js-sa3-delete" title="Hapus diskusi">
                    <i class="las la-trash"></i> Hapus
                  </a>
                </div>
            </div>
            @endif
          </div>
          <a href="javascript:void(0)">Re : {{ $data['topik']->subject  }}</a>
          <div class="text-muted small">{{ $diskusi->created_at->format('l, j F Y, H:i A') }} - by {{ $diskusi->user->name }}</div>
          <div class="mt-2">
            {!! $diskusi->message !!}
          </div>
          <div class="small mt-2">
            @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra') || auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['topik']->limit_reply) || !empty($data['topik']->limit_reply) && $data['topik']->diskusiByUser()->count() < $data['topik']->limit_reply)
            <a href="javascript:void(0)" class="text-light reply" data-toggle="modal" data-target="#form-reply" data-parent="{{ $diskusi->id }}">Reply</a>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>
@endforeach

@include('frontend.course.forum.modal-reply')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
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
                    window.location.href = '/course/{{ $data['forum']->mata_id }}/bahan/{{ $data['forum']->bahan_id }}/forum';
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

    $('.js-sa3-delete').on('click', function () {
        var forum_id = $(this).attr('data-forumid');
        var topik_id = $(this).attr('data-topikid');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus reply ini, data yang bersangkutan dengan reply ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/forum/"+ forum_id +"/topik/" + topik_id + '/reply/' + id,
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
                    text: 'reply berhasil dihapus'
                }).then(() => {
                    window.location.reload();
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

$('.reply').click(function() {
    var parent = $(this).data('parent');
    $("#advance").attr("href", "/forum/{{ $data['forum']->id }}/topik/{{ $data['topik']->id }}/reply/create?parent=" + parent);
    $('.modal-body #parent').val(parent);
});
</script>

@include('includes.tiny-mce-with-fileman')
@include('components.toastr')
@endsection

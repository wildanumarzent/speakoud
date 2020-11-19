@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.css') }}">
@endsection

@section('content')
<!-- Filters -->
<div class="card">
    <div class="card-body">
        <div class="form-row align-items-center">
            <div class="col-md">
                <form action="" method="GET">
                    <div class="form-group">
                        <label class="form-label">Filter</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Komentar...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk filter"><i class="las la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Komentar List</h5>

    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Creator</th>
                    <th>Komentar</th>
                    <th>Model</th>
                    <th>Model Item</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['komentar'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td >{{ $item->user->name ?? '-' }}</td>
                    <td >{{ $item->komentar}}</td>
                    <td >{{ $item->commentable_type ?? '-' }}</td>
                    <td >{{ $item->commentable_id ?? '-' }}</td>
                    <td >{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td >
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus komentar" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Komentar tidak ditemukan !
                            @else
                            ! Data Komentar kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tbody class="tbody-responsive">
                @forelse ($data['komentar'] as $item)
                <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="https://i.pinimg.com/originals/20/4a/c2/204ac2d176b028b2a40638fb7f61039b.jpg" alt="userfoto" style="border-radius: 15px; width:70px;height:70px;object-fit:cover">
                            <label>{{$item->user->name}}</label>
                        </div>
                        <div class="col-md-10">
                           <p>{!!$item->komentar!!}</p>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted">{{$item->created_at->diffForhumans()}}</span>
                        <a data-toggle="collapse" href="#reply-{{$item->id}}" role="button" aria-expanded="false" aria-controls="reply-1" class="text-right" style="float:right">Reply</a>
                    </div>

                    <div class="collapse" id="reply-{{$item->id}}">
                        {{-- <form>
                        <input type="text" name="reply" id="" class="form-control" placeholder="Tulis Tanggapan...">
                        </form> --}}
                        <div class="card card-body">
                         <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>
                         <small class="text-muted">Bot,2019-08-12</small>
                        </div>
                      </div>
                </div>
                <br>
                @empty
                <h4>Tidak Ada Komentar</h4>
                @endforelse
            <tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['komentar']->firstItem() }}</strong> - <strong>{{ $data['komentar']->lastItem() }}</strong> dari
                <strong>{{ $data['komentar']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['komentar']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    @include('backend.komentar.modal')
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus komentar ini, data yang bersangkutan dengan komentar ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/komentar/" + id,
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
                        text: 'User komentar berhasil dihapus'
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
</script>

@include('components.toastr')
@endsection

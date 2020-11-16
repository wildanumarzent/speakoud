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
                        <label class="form-label">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Nama Tags...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
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
        <h5 class="card-header-title mt-1 mb-0">Tags List</h5>

    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Tags</th>
                    <th>Hits
                        <small>(Jumlah Pemakaian)</small>
                    </th>
                    <th>Keterangan</th>
                    <th>Standar</th>
                    <th>Pantas</th>
                    <th>Related</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['tags'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td >{{ $item->nama ?? '-' }}</td>
                    <td >{{ $item->tagsTipe->count()}}</td>
                    <td >{{ $item->keterangan ?? '-' }}</td>
                    <td >
                        <span class="badge badge-outline-{{$item->standar ==1 ? 'success' : 'secondary'}}" name="{{$item->standar ==1 ? 't' : 'f'}}">
                            <i class="ion ion-{{$item->standar ==1 ? 'md-checkmark-circle-outline' : 'md-close-circle-outline'}}"></i>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-outline-{{$item->pantas ==1 ? 'success' : 'secondary'}}" name="{{$item->pantas ==1 ? 't' : 'f'}}">
                            <i class="ion ion-{{$item->pantas ==1 ? 'md-checkmark-circle-outline' : 'md-close-circle-outline'}}"></i>
                        </span>
                    </td>
                    <td >{{ $item->related ?? '-' }}</td>
                    <td >{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td >{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td >
                        <a href="javascript:;" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit tags" data-toggle="modal" data-target="#modals-tags">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus tags" data-toggle="tooltip">
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
                            ! Tags tidak ditemukan !
                            @else
                            ! Data Tags kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tbody class="tbody-responsive">
                @forelse ($data['tags'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Tags</div>
                                    <div class="desc-table">{{ $item->nama ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Hits</div>
                                    <div class="desc-table">{{ $item->tagsTipe->count()}}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Keterangan</div>
                                    <div class="desc-table">{{ $item->keterangan  ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Standar</div>
                                    <div class="desc-table">
                                        <span class="badge badge-outline-{{$item->standar ==1 ? 'success' : 'secondary'}}" name="{{$item->standar ==1 ? 't' : 'f'}}">
                                            <i class="ion ion-{{$item->standar ==1 ? 'md-checkmark-circle-outline' : 'md-close-circle-outline'}}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Pantas</div>
                                    <div class="desc-table">
                                        <span class="badge badge-outline-{{$item->pantas ==1 ? 'success' : 'secondary'}}" name="{{$item->panatas ==1 ? 't' : 'f'}}">
                                            <i class="ion ion-{{$item->pantas ==1 ? 'md-checkmark-circle-outline' : 'md-close-circle-outline'}}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Related</div>
                                    <div class="desc-table">{{ $item->related ?? '-' }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="javascript:;" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit tags" data-toggle="modal" data-target="#modals-tags">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus tags" data-toggle="tooltip">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Tags tidak ditemukan !
                            @else
                            ! Data Tags kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endforelse
            <tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['tags']->firstItem() }}</strong> - <strong>{{ $data['tags']->lastItem() }}</strong> dari
                <strong>{{ $data['tags']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['tags']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    @include('backend.tags.modal')
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
                text: "Anda akan menghapus tags ini, data yang bersangkutan dengan tags ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/tags/" + id,
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
                        text: 'User tags berhasil dihapus'
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

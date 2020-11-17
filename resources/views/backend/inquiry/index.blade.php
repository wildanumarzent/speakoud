@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
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
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
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
        <h5 class="card-header-title mt-1 mb-0">Inquiry Kontak List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('inquiry.edit', ['id' => 1]) }}" class="btn btn-warning icon-btn-only-sm" title="klik untuk setting inquiry" data-toggle="tooltip">
                <i class="las la-cog"></i><span>Setting</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>IP Address</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th style="width: 220px;">Submit Time</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['contact']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Kontak tidak ditemukan !
                            @else
                            ! Data Kontak kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['contact'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->ip_address }}</td>
                    <td>{{ $item->content['name'] }}</td>
                    <td><a href="mailto:{{ $item->content['email'] }}">{{ $item->content['email'] }}</a></td>
                    <td>{{ $item->content['subject'] }}</td>
                    <td>{{ $item->submit_time->format('d F Y - (H:i A)') }}</td>
                    <td>
                        <button class="btn icon-btn btn-info btn-sm modals-detail" data-toggle="modal" data-target="#detail-pesan"
                            data-id="{{ $item->id }}" data-ip="{{ $item->ip_address }}" data-name="{{ $item->content['name'] }}" data-email="{{ $item->content['email'] }}"
                            data-subject="{{ $item->content['subject'] }}" data-message="{{ $item->content['message'] }}" data-status="{{ $item->status }}"
                            title="klik untuk meliha pesan">
                            <i class="las la-eye"></i>
                        </button>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus kontak" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['contact']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Kontak tidak ditemukan !
                            @else
                            ! Data Kontak kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['contact'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">IP Address</div>
                                    <div class="desc-table">{{ $item->ip_address }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nama</div>
                                    <div class="desc-table">{{ $item->content['name'] }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Email</div>
                                    <div class="desc-table"><a href="mailto:{{ $item->content['email'] }}">{{ $item->content['email'] }}</a></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Subject</div>
                                    <div class="desc-table">{{ $item->content['subject'] }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Submit Time</div>
                                    <div class="desc-table">{{ $item->submit_time->format('d F Y - (H:i A)') }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <button class="btn icon-btn btn-info btn-sm modals-detail" data-toggle="modal" data-target="#detail-pesan"
                                            data-id="{{ $item->id }}" data-ip="{{ $item->ip_address }}" data-name="{{ $item->content['name'] }}" data-email="{{ $item->content['email'] }}"
                                            data-subject="{{ $item->content['subject'] }}" data-message="{{ $item->content['message'] }}" data-status="{{ $item->status }}"
                                            title="klik untuk meliha pesan">
                                            <i class="las la-eye"></i>
                                        </button>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus kontak" data-toggle="tooltip">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            <tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['contact']->firstItem() }}</strong> - <strong>{{ $data['contact']->lastItem() }}</strong> dari
                <strong>{{ $data['contact']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['contact']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.inquiry.detail')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
$(document).ready(function () {
    $('.js-sa2-delete').on('click', function () {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus kontak ini, data yang bersangkutan dengan kontak ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/inquiry/contact/" + id,
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
                    text: 'kontak berhasil dihapus'
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

$('.modals-detail').click(function() {
    var id = $(this).data('id');
    var ip = $(this).data('ip');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var url = 'mailto:' + email;
    var subject = $(this).data('subject');
    var message = $(this).data('message');
    var status = $(this).data('status');

    if (status == 0) {
        $.ajax({
            type:"PUT",
            url: "/inquiry/contact/"+ id +"/read"
        });
    }

    $('.modal-body #ip').text(ip);
    $('.modal-body #name').text(name);
    $('.modal-body #email').text(email);
    $('.modal-body #subject').text(subject);
    $('.modal-body #message').text(message);
    $("#mailto").attr("href", url);
});
</script>

@include('components.toastr')
@endsection

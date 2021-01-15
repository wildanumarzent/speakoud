@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/contacts.css') }}">

@endsection

@section('content')

<div class="d-flex justify-content-between">
    <button type="button" data-toggle="modal" data-target="#modal-badge" class="btn btn-primary rounded-pill" title="klik untuk menambah badge"><i class="las la-plus"></i>Tambah</button>
</div>
<br>
<h3>{{$data['mata']}}</h3>
<hr>
<div class="row contacts-col-view">

@foreach($data['badge'] as $item)
<div class="contacts-col col-md-2">

    <div class="card mb-4">
        <div class="card-body">
            <div class="contacts-dropdown dropdown btn-group">

                <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i class="ion ion-ios-more"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('badge.edit',['badge' => $item->id,'type' => $item->tipe])}}">Edit</a>
                    <a class="dropdown-item js-sa2-delete" data-id="{{ $item->id }}" data-toggle="tooltip">Remove</a>
                </div>
            </div>

            <div class="contact-content">
               <center> <img src="{{asset($item->icon)}}" style="width:max-220px;max-height:220px;object-fit:cover;" class="contact-content-img rounded-circle" alt=""></center>
                <div class="contact-content-about">
                    <center>
                    <h5 class="contact-content-name mb-1"><a class="text-body">{{$item->nama}}</a></h5>
                    <div class="contact-content-user text-muted small mb-2">{!! Str::limit($item->deskripsi, 40) !!}</div>
                    <hr class="border-light">
                    <div>
                        @php
                        $tipe = $item->tipe;
                        @endphp
                     Selesaikan {{$item->nilai_minimal}}@if($item->tipe_utama == 1)% di @elseif($item->tipe == 'forum') Post di @else Reply di @endif {{ucwords($item->tipe)}}
                      <strong>
                        {{ucwords(@$item->$tipe->judul ?? $item->$tipe->subject ?? $item->forum->bahan->judul)}}
                      </strong>

                    </div>
                    </center>
                </div>
            </div>

        </div>
    </div>


</div>
@endforeach
</div>


@if ($data['badge']->count() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Badge tidak ditemukan !
            @else
            ! Data Badge kosong !
            @endif
        </strong>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center">
        <strong>
           Total Badge : {{$data['badge']->count()}}
        </strong>
    </div>
</div>
@endif
@include('backend.badge.create',['mataID' => $data['mataID']])
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/pages_contacts.js') }}"></script>

@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus badge ini, data yang bersangkutan dengan badge ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/badges/delete/" + id,
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
                        text: 'badge berhasil dihapus'
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


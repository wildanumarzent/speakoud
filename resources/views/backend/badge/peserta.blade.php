@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/contacts.css') }}">

@endsection

@section('content')
<br>
@foreach($data['mata'] as $mata)
<h4>{{$mata->mata->judul}} </h4>
<hr>
<div class="row contacts-col-view">
@foreach($data['badge']->where('mata_id',$mata->mata->id) as $item)
@php
$myBadge = $data['myBadge']->where('badge_id',$item->id)->first();
@endphp
<div class="contacts-col col-md-2">

    <div class="card card-list mb-4">
        <div class="card-body">
            <div class="contacts-dropdown dropdown btn-group">

                <button title="Klik Untuk Melihat Cara Mendapatkan Badge" type="button" class="btn btn-sm @if(empty($myBadge)) btn-default @else btn-success @endif icon-btn borderless rounded-pill md-btn-flat" data-toggle="collapse" data-target="#quest-{{$item->id}}">
                    <i class="fas @if(empty($myBadge))fa-question-circle @else fa-check-circle @endif}}"></i>
                </button>
            </div>

            <div class="contact-content">

               <center> <img src="{{asset($myBadge->badge->icon ?? 'assets/tmplts_backend/images/default-logo.png')}}" style="width:max-220px;max-height:220px;object-fit:cover;" class="contact-content-img rounded-circle" alt=""></center>
                <div class="contact-content-about">
                    <center>


                    <h5 class="contact-content-name mb-1"><a class="text-body">{{$myBadge->badge->nama ?? 'Terkunci'}}</a></h5>
                    <div class="contact-content-user text-muted small mb-2">{{$myBadge->badge->deskripsi ?? 'Selesaikan Misi Dibawah Untuk Mendapatkan Badge'}}</div>

                    <div class="collapse" id="quest-{{$item->id}}">
                        <hr class="border-light">
                        @php
                        $tipe = $item->tipe;
                        @endphp

                        @if($mata->mata->publish == 0)
                        <strong>Program Diarsipkan !</strong>
                        <p><small>Anda Tidak Dapat mendapatkan Badge Ini Lagi</small></p>
                        @elseif($mata->mata->publish_end <= Carbon\Carbon::now())
                        <strong>Tenggat Waktu Habis !</strong>
                       <p><small>Anda Tidak Dapat mendapatkan Badge Ini Lagi</small></p>
                       @elseif($mata->mata->publish_start >= Carbon\Carbon::now())
                       <strong>Program Belum Dimulai !</strong>
                       <p><small>Anda Tidak Dapat Mengetahui Syarat Untuk Mendapatkan Badge Sekarang</small></p>
                       @else
                       <p> @if(isset($myBadge))Telah Menyelesaikan @else Selesaikan @endif  {{$item->nilai_minimal}}@if($item->tipe_utama == 1)% di @elseif($item->tipe == 'forum') Post di @else Reply di @endif {{ucwords($item->tipe)}}</p>
                       <strong>
                         {{ucwords(@$item->$tipe->judul ?? $item->$tipe->subject ?? $item->forum->bahan->judul)}}
                       </strong>
                       <hr>

                        @endif


                    </div>
                    </center>
                </div>
            </div>

        </div>
    </div>


</div>
@endforeach
</div>
@endforeach

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
            Badge Yang Didapat : {{$data['count']['badge']}}
        </strong>
    </div>
</div>
@endif
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


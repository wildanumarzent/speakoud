@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/style.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="container">
        <div class="row">
        {{-- {{dd($data['mata'])}} --}}
        @foreach ($data['pelatihanKhusus'] as $mata)
        {{-- {{dd($mata->pelatihan)}} --}}
        {{-- d-flex --}}
        <div class="col-lg-4 mt-3">
            <div class="item-post">
                <a href="{{ route('pelatihan.detail', ['id' => $mata->pelatihan->id]) }}" class="box-img">
                    <div class="thumbnail-img">
                        <img src="{{ $mata->pelatihan->getCover($mata->pelatihan->cover['filename']) }}" title="" alt="">
                    </div>
                </a>
                <div class="box-post">
                    <div class="post-date">
                        {{ $mata->created_at != null ? $mata->pelatihan->created_at->format('d F Y') : 'Tanggal Belum Di Sertakan' }}
                    </div>
                    <h5 class="post-title" >
                        <a href="{{  route('course.detail', ['id' => $mata->pelatihan->id]) }}">{!! $mata->pelatihan->judul !!}</a>
                    </h5>
                    <div class="post-info">
                        <div class="box-price">
                           
                           <form action="{{route('peserta.editPelatiahanKhusus',['id'=>$mata->pelatihan->id])}}" method="post">
                               @method('PUT')
                               @csrf
                                <input type="hidden" value="{{$mata->pelatihan->id}}" name="mataId">
                                <input type="hidden" value="{{$mata->peserta_id}}" name="pesertaId">
                                @if ($mata->is_access ==1)
                                <button type="submit" class="badge badge-primary">Sudah Punya Akses</button>
                                @else 
                                <button type="submit" class="badge badge-primary">Beri Akses</button>
                                @endif
                           </form>
                        </div>
                        {{-- <div class="box-info">
                            <div class="item-info">
                                <div class="data-info">
                                    <i class="las la-user"></i>
                                    @php
                                        $instruktur = count($mata->pelatihan->instruktur);
                                        $peserta = count($mata->pelatihan->peserta);

                                        $enrol = $instruktur + $peserta;
                                    @endphp
                                    <span>{{$enrol}}</span>
                                </div>
                                <span>Peserta</span>
                            </div>
                            <div class="item-info">
                                <div class="data-info">
                                    <i class="las la-comment"></i>
                                    <span>{{ $mata->pelatihan->bahan->count() }}</span>
                                </div>
                                <span>Materi</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
    
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus user ini, jika user memiliki data yang bersangkutan, user tidak akan terhapus!",
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
                        url: "/peserta/" + id + "/soft",
                        method: 'GET',
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
                        text: 'User peserta berhasil dihapus'
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

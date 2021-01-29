@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<!-- Filters -->
<div class="card">
    <div class="card-body">
        <form action="" method="GET">
        <div class="form-row align-items-center">
                @role('peserta_mitra|peserta_internal')
                    <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Progress</label>
                    <div class="input-group">
                        <select name="p" class="form-control">
                            <option value="" selected>Semua</option>
                            <option value="owned" @if(Request::get('p') == 'owned') selected @endif>Sudah Dimiliki</option>
                            <option value="progress" @if(Request::get('p') == 'progress') selected @endif>Sedang Progress</option>
                            <option value="potential" @if(Request::get('p') == 'potential') selected @endif>Berpotensi Untuk Dicapai</option>
                            <option value="notPotential" @if(Request::get('p') == 'notPotential') selected @endif>Belum Punya Kompetensi</option>
                        </select>
                    </div>
                </div>
            </div>
            @endrole
            <div class="col-md">

                <div class="form-group">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
<!-- / Filters -->
@role ('developer|administrator|internal')
<a href="{{ route('journey.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah learning journey">
    <i class="las la-plus"></i><span>Tambah</span>
</a>
@endrole
<hr>
                @if ($data['journey']->total() == 0)
                <div class="card">
                    <div class="card-body text-center">
                        <strong style="color: red;">
                            @if (Request::get('p') || Request::get('q'))
                            ! Learning Journey tidak ditemukan !
                            @else
                            ! Data Learning Journey kosong !
                            @endif
                        </strong>
                    </div>
                </div>
                @endif

                @foreach ($data['journey'] as $item)
                <div class="card mt-5">

                    <div class="p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-10 col-sm-8">
                                <a href="javascript:void(0)" class="text-body text-large font-weight-semibold">{{$item->judul}}</a>
                            </div>

                            <div class="col-md-2 col-sm-4">
                                <div class="btn-group">
                                @if($data['listKompetensi']->where('journey_id',$item->id)->count() !=0)
                                 <button type="button" class="btn btn-primary btn-sm rounded-pill" data-toggle="collapse" data-target="#kompetensi-{{$item->id}}">Kompetensi</button>
                                @endif
                                @role ('peserta_mitra|peserta_internal')
                                <form action="{{route('journey.assign',['pesertaId' => auth()->user()->peserta->id])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="journey_id" value="{{$item->id}}">
                                    {{-- <input type="hidden" name="status" value="{{$item->journeyPeserta->status}}"> --}}


                                @php
                                   $totalPoint = $data['totalPoint']->where('journey_id',$item->id)->sum('minimal_poin');
                                    $kompetensiId = $data['listKompetensi']->where('journey_id',$item->id)->pluck('kompetensi_id');
                                    $myPoin = $data['poinKu']->whereIn('kompetensi_id',$kompetensiId)->sum('poin');
                                    if($myPoin == null){
                                    $myPoin = 0;
                                    }
                                    if($totalPoint > 0){
                                    $persentase = round(($myPoin/$totalPoint) * 100);
                                    }

                                    $assigned = $data['assigned']->where('journey_id',$item->id)->first();
                                @endphp

                                @if(!empty($assigned) && $assigned->status == 1 && $persentase < 100)

                                <button type="button" class="btn btn-secondary btn-sm rounded-pill ml-2" data-toggle="collapse">Assigned</button>
                                @elseif(!empty($assigned) && $assigned->status == 1 && $assigned->complete == 0 && $persentase >= 100)
                                <input type="hidden" name="complete" value="1">
                                <button type="submit" class="btn btn-warning btn-sm rounded-pill ml-2" data-toggle="collapse" title="Klik to Complete">Selesaikan</button>
                                @elseif(!empty($assigned) && $assigned->status == 1 && $assigned->complete == 1 && $persentase >= 100)
                                <button type="button" class="btn btn-success btn-sm rounded-pill ml-2" data-toggle="collapse" title="Klik to Complete">Selesai</button>
                                @endif



                            </form>
                            @endrole
                                @role ('developer|administrator|internal')
                                 <div class="dropdown dropdown-right ml-2">
                                    <button type="button" class="btn btn-sm btn-warning borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
                                        <i class="las la-ellipsis-v"></i>&nbsp;&nbsp;Aksi
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('journey.edit', ['journey' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit kategori pelatihan">
                                            <i class="las la-pen"></i><span>Ubah</span>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item js-sa2-delete" data-id="{{ $item->id }}" title="klik untuk menghapus kategori pelatihan">
                                            <i class="las la-trash-alt"></i> <span>Hapus</span>
                                        </a>
                                        <a href="{{ route('journeyKompetensi.create', ['journey' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit kategori pelatihan">
                                            <i class="las la-plus"></i><span>Tambah Kompetensi</span>
                                        </a>
                                    </div>
                                </div>
                                @endrole
                            </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap mt-3">
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-person text-light" title="Department"></i>&nbsp; {{$item->user->name}}</div>
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-time text-primary" title="Employment"></i>&nbsp; {{$item->created_at->format('Y-m-d H:i:s')}}</div>
                        </div>
                        <div class="mt-3 mb-4">

                            {!! Str::limit($item->deskripsi,120) !!}


                        </div>
                        <div class="collapse" id="kompetensi-{{$item->id}}">
                            @role ('peserta_internal|peserta_mitra')

                            @if($totalPoint != 0)
                            <div class="progress mt-3 mb-2">
                                <div class="progress-bar" style="width: {{$persentase}}%;">{{$persentase}}%</div>
                              </div>
                            @endif
                              @endrole
                        <ul class="list-group mt-3">
                            @foreach($data['listKompetensi']->where('journey_id',$item->id) as $k)
                            @role ('developer|administrator|internal')
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-default"> {{$k->kompetensi->judul}}    (Poin : {{$k->minimal_poin}})</span>
                                <div class="btn-group dropdown dropdown-right">
                                    <button type="button" class="btn btn-sm btn-warning  icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
                                        <i class="ion ion-ios-more"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('journeyKompetensi.edit', ['id' => $k->id]) }}" class="dropdown-item" title="klik untuk menghubungkan learning journey kompetensi">
                                            <i class="las la-pen"></i><span>Ubah</span>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item js-sa2-unlink" data-kid="{{ $k->id }}" title="klik untuk memutuskan learning journey kompetensi">
                                            <i class="las la-trash-alt"></i> <span>Hapus</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @else
                                    @role ('peserta_internal|peserta_mitra')
                                    @php
                                    $myPoin = $data['poinKu']->where('kompetensi_id',$k->kompetensi_id)->first();
                                    if($myPoin == null){
                                        $myPoin = 0;
                                    }else{
                                    $myPoin = $myPoin->poin;
                                    }
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">{{$k->kompetensi->judul}}
                                        <span class="badge badge-@if($myPoin == $k->minimal_poin)success @else default @endif">{{$myPoin}}/{{$k->minimal_poin}} @if($myPoin >= $k->minimal_poin)Complete @endif</span>
                                    </li>
                                    @endrole
                            @endrole
                            @endforeach
                        </ul>
                        </div>
                    </div>

                    <hr class="border-light m-0">
                </div>
                @endforeach
                @if ($data['journey']->total() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6 m--valign-middle">
                                Menampilkan : <strong>{{ $data['journey']->firstItem() }}</strong> - <strong>{{ $data['journey']->lastItem() }}</strong> dari
                                <strong>{{ $data['journey']->total() }}</strong>
                            </div>
                            <div class="col-lg-6 m--align-right">
                                {{ $data['journey']->onEachSide(3)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
            text: "Anda akan menghapus learning journey ini, data yang bersangkutan dengan learning journey ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/journey/" + id + "/delete",
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
                    text: 'learning journey berhasil dihapus'
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


    $('.js-sa2-unlink').on('click', function () {
        var id = $(this).attr('data-kid');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus kompetensi ini, data yang bersangkutan dengan kompetensi ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                    url: "/journey/kompetensi/" + id + "/delete",
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
                    text: 'kompetensi berhasil diputuskan'
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

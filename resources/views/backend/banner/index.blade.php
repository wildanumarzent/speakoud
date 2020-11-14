@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <a href="{{ route('banner.media.create', ['id' => $data['kategori']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah banner"><i class="las la-plus"></i>Tambah</a>
</div>
<br>

<div class="row drag">
    @foreach ($data['banner'] as $item)
    <div class="col-sm-6 col-xl-4" id="{{ $item->id }}" style="cursor: move;" title="Ubah posisi">
        <div class="card card-list">
            <div class="w-100">
                <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url({{ asset('userfile/banner/'.$item->banner_kategori_id.'/'.$item->file) }});">
                  <div class="d-flex justify-content-between align-items-end ui-rect-content p-3">
                    <div class="flex-shrink-1">
                      {{-- activate --}}
                      <a href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 1 ? 'publish' : 'un-publish' }} banner">
                        <span class="badge badge-{{ $item->publish == 1 ? 'success' : 'warning' }}">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span>
                        <form action="{{ route('banner.media.publish', ['id' => $item->banner_kategori_id, 'bannerId' => $item->id]) }}" method="POST">
                          @csrf
                          @method('PUT')
                        </form>
                      </a>
                    </div>
                    <div class="text-big">
                      {{-- <div class="badge badge-dark font-weight-bold">GAMBAR</div> --}}
                    </div>
                  </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-3">
                    <a href="#" class="text-body">
                        {{ $item->judul ?? '-' }}
                    </a>
                </h5>
                <p class="text-muted mb-3">
                    {!! !empty($item->keterangan) ? strip_tags(Str::limit($item->keterangan, 70)) : '-' !!}
                </p>
                <div class="media">
                    <div class="media-body">
                        <a href="{{ route('banner.media.edit', ['id' => $item->banner_kategori_id, 'bannerId' => $item->id]) }}" class="btn icon-btn btn-sm btn-info" title="klik untuk mengedit banner">
                            <i class="ion ion-md-create text-white"></i>
                        </a>
                        <a href="javascript:void(0);" data-kategoriid="{{ $item->banner_kategori_id }}"  data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus banner">
                          <i class="ion ion-md-trash text-white"></i>
                        </a>
                    </div>
                      <div class="text-muted small">
                        <i class="las la-user text-primary"></i>
                        <span>{{ $item->creator['name'] }}</span>
                      </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if ($data['banner']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            ! Data Baner kosong !
        </strong>
    </div>
</div>
@endif

@if ($data['banner']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['banner']->firstItem() }}</strong> - <strong>{{ $data['banner']->lastItem() }}</strong> dari
                <strong>{{ $data['banner']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['banner']->onEachSide(3)->links() }}
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/pages_gallery.js') }}"></script>
<script>
    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                var id = '{{ $data['kategori']->id }}';
                $.ajax({
                    data: {'datas' : data},
                    url: '/banner/' + id + '/media/sort',
                    type: 'POST',
                    dataType:'json',
                });
                if (data) {
                    location.reload();
                }
            }
        });
        $( "#drag" ).disableSelection();
    });
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var kategori_id = $(this).attr('data-kategoriid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus banner ini, data yang bersangkutan dengan banner ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/banner/" + kategori_id + '/media/' + id,
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
                        text: 'banner berhasil dihapus'
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

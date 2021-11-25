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
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="p">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.publish') as $key => $value)
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (auth()->user()->hasRole('developer|administrator'))
            <div class="col-md">
                {{-- <div class="form-group">
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        <option value="0" {{ Request::get('t') == '0' ? 'selected' : '' }}>BPPT</option>
                        <option value="1" {{ Request::get('t') == '1' ? 'selected' : '' }}>Mitra</option>
                    </select>
                </div> --}}
            </div>
            @endif
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
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->
@role('developer|administrator')
<div class="d-flex justify-content-between">
    <a href="{{ route('program.create') }}" class="btn btn-primary rounded-pill" title="klik untuk menambah kategori pelatihan"><i class="las la-plus"></i>Tambah</a>
</div>
@endrole
<br>

<div class="drag">
    @foreach ($data['program'] as $item)
   
    <div class="card mb-3" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
              @if ($item->min('urutan') != $item->urutan)
                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menaikan posisi">
                    <i class="ion ion-ios-arrow-up"></i>
                    <form action="{{ route('program.position', ['id' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
              @else
              <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-up"></i></a>
              @endif
              <div class="text-xlarge font-weight-bolder line-height-1 my-2">{{ $data['number']++ }}</div>
              @if ($item->max('urutan') != $item->urutan)
                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menurunkan posisi">
                    <i class="ion ion-ios-arrow-down"></i>
                    <form action="{{ route('program.position', ['id' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
              @else
                <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-down"></i></a>
              @endif
            </div>
            <div class="media-body ml-4">
              <a href="{{ route('mata.index', ['id' => $item->id]) }}" class="text-big">{!! $item->judul !!}
                <span class="badge badge-secondary">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span>
              </a>
              <div class="my-2">
                <div class="row">
                    <div class="col-md-8">
                        {!! Str::limit(strip_tags($item->keterangan), 120) !!}
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- @if ($item->publish == 0 && $item->mata()->count() > 0 && $item->materi()->count() > 0)
                        <a href="javascript:;" onclick="$(this).find('#form-publish').submit();" class="btn btn-{{ $item->publish == 0 ? 'primary' : 'secondary' }} btn-sm icon-btn-only-sm" title="klik {{ $item->publish == 0 ? 'publish' : 'draft' }} kategori">
                            <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> <span>{{ $item->publish == 0 ? 'PUBLISH' : 'DRAFT' }}</span>
                            <form action="{{ route('program.publish', ['id' => $item->id])}}" method="POST" id="form-publish">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @endif --}}
                        <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('mata.index', ['id' => $item->id]) }}" title="klik untuk melihat program pelatihan">
                            <i class="las la-book"></i> <span>Program</span>
                        </a>
                        @if (auth()->user()->hasRole('developer|administrator|internal') || $item->creator_id == auth()->user()->id)
                        <div class="btn-group dropdown ml-2">
                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melihat user enroll"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('program.edit', ['id' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit kategori pelatihan">
                                    <i class="las la-pen"></i><span>Ubah</span>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item js-sa2-delete" data-id="{{ $item->id }}" title="klik untuk menghapus kategori pelatihan">
                                    <i class="las la-trash-alt"></i> <span>Hapus</span>
                                </a>
                                <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} kategori pelatihan">
                                    <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> <span>{{ $item->publish == 0 ? 'Publish' : 'Draft' }}</span>
                                    <form action="{{ route('program.publish', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </a>
                               
                            </div>
                        </div>
                         @endif
                    </div>
                </div>
              </div>
              <div class="small">
                <span class="text-muted ml-3"><i class="las la-user text-lighter text-big align-middle"></i>&nbsp; {{ $item->creator->name }}</span>
                {{-- <span class="text-muted ml-3"><i class="las la-book-open text-lighter text-big align-middle"></i>&nbsp; {{ $item->tipe == 0 ? 'BPPT' : 'Mitra' }}</span> --}}
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->created_at->format('d/m/Y H:i') }}</span>
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->updated_at->format('d/m/Y H:i') }}</span>
              </div>
            </div>
          </div>
        </div>
    </div>
    @endforeach
</div>

@if ($data['program']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Kategori Pelatihan tidak ditemukan !
            @else
            ! Kategori Pelatihan kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['program']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['program']->firstItem() }}</strong> - <strong>{{ $data['program']->lastItem() }}</strong> dari
                <strong>{{ $data['program']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['program']->onEachSide(3)->links() }}
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
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script>
      $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus kategori pelatihan ini, data yang bersangkutan dengan kategori pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/program/" + id,
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
                        text: 'kategori pelatihan berhasil dihapus'
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
    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                $.ajax({
                    data: {'datas' : data},
                    url: '/program/sort',
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
  
    //publish
    $('.publish').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin akan publish program ini ?",
        text: "Data Mata, Materi, Bahan Pelatihan tidak boleh kosong",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, publish!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
        if (result.value) {
            $("#form-publish").submit();
        }
        })
    });
</script>

@include('components.toastr')
@endsection

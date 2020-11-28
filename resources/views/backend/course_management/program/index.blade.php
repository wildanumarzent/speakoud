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
                <div class="form-group">
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        <option value="0" {{ Request::get('t') == '0' ? 'selected' : '' }}>BPPT</option>
                        <option value="1" {{ Request::get('t') == '1' ? 'selected' : '' }}>Mitra</option>
                    </select>
                </div>
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
@if ($data['hasRole'])
<div class="d-flex justify-content-between">
    <a href="{{ route('program.create') }}" class="btn btn-primary rounded-pill" title="klik untuk menambah kategori pelatihan"><i class="las la-plus"></i>Tambah</a>
</div>
<br>
@endif

<div class="row @if ($data['hasRole']) drag @endif">
    @foreach ($data['program'] as $item)
    <div class="col-sm-6 col-xl-4" @if ($data['hasRole']) id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan" @endif>
      <div class="card card-list">
        <div class="card-body d-flex justify-content-between align-items-start pb-1">
          <div>
            <a href="{{ route('mata.index', ['id' => $item->id]) }}" class="text-body text-big font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!}</a>
          </div>
          <div class="btn-group project-actions dropdown">
            <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle hide-arrow  btn-toggle-radius" data-toggle="dropdown" aria-expanded="false">
              <i class="ion ion-ios-more"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 26px; left: 26px;">
              <a class="dropdown-item" href="{{ route('mata.index', ['id' => $item->id]) }}" title="klik untuk melihat program pelatihan">
                <i class="las la-book"></i> Program Pelatihan
              </a>
              @if ($data['hasRole'])
              <a class="dropdown-item" href="{{ route('program.edit', ['id' => $item->id]) }}" title="klik untuk mengedit kategori pelatihan">
                <i class="las la-pen"></i> Edit
              </a>
              @endif
              @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
              <a class="dropdown-item js-sa2-delete" href="javascript:void(0);" data-id="{{ $item->id }}" title="klik untuk menghapus kategori pelatihan">
                <i class="las la-trash-alt"></i> Hapus
              </a>
              @endif
            </div>
          </div>
        </div>
        <div class="card-body pb-3">
          <table class="table table-bordered mb-2">
                <tr>
                    <th>Creator</th>
                    <td>{{ $item->creator['name'] }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></td>
                </tr>
                @if ($data['hasRole'])
                <tr>
                    <th>Urutan</th>
                    <td>
                        @if ($item->min('urutan') != $item->urutan)
                            <a href="javascript:;" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengatur posisi">
                                <i class="las la-long-arrow-alt-up"></i>
                                <form action="{{ route('program.position', ['id' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                        @else
                            <button type="button" class="btn icon-btn btn-default btn-sm" disabled><i class="las la-long-arrow-alt-up"></i></button>
                        @endif
                        @if ($item->max('urutan') != $item->urutan)
                            <a href="javascript:;" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengatur posisi">
                                <i class="las la-long-arrow-alt-down"></i>
                                <form action="{{ route('program.position', ['id' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                        @else
                            <button type="button" class="btn icon-btn btn-default btn-sm" disabled><i class="las la-long-arrow-alt-down"></i></button>
                        @endif
                    </td>
                </tr>
                @endif
                <tr>
                    <th>Action</th>
                    <td>
                        <a class="btn btn-success icon-btn btn-sm" href="{{ route('mata.index', ['id' => $item->id]) }}" title="klik untuk melihat program pelatihan">
                            <i class="las la-book"></i>
                        </a>
                        @if ($data['hasRole'])
                        <a class="btn btn-info icon-btn btn-sm" href="{{ route('program.edit', ['id' => $item->id]) }}" title="klik untuk mengedit kategori pelatihan">
                          <i class="las la-pen"></i>
                        </a>
                        @endif
                        @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                        <a class="btn btn-danger icon-btn btn-sm js-sa2-delete" href="javascript:void(0);" data-id="{{ $item->id }}" title="klik untuk menghapus kategori pelatihan">
                          <i class="las la-trash-alt"></i>
                        </a>
                        @endif
                    </td>
                </tr>
          </table>
          @if (auth()->user()->hasRole('developer|administrator|internal|mitra') && $item->publish == 0 && $item->mata()->count() > 0 && $item->materi()->count() > 0)
          <a href="javascript:;" class="btn btn-success btn-block publish" title="klik untuk publish">
            PUBLISH
            <form action="{{ route('program.publish', ['id' => $item->id])}}" method="POST" id="form-publish">
                @csrf
                @method('PUT')
            </form>
          </a>
          @endif
        </div>
        <hr class="m-0 mb-2">
        <div class="card-body pt-0">
          <div class="row">
            <div class="col">
              <div class="text-muted small">Created</div>
              <div class="font-weight-bold">{{ $item->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="col">
              <div class="text-muted small">Updated</div>
              <div class="font-weight-bold">{{ $item->updated_at->format('d/m/Y H:i') }}</div>
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
            ! Data Kategori Pelatihan kosong !
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

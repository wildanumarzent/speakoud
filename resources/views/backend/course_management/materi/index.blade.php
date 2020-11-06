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
                        <option value="1" {{ Request::get('p') == '1' ? 'selected' : '' }}>PUBLISH</option>
                        <option value="0" {{ Request::get('p') == '0' ? 'selected' : '' }}>DRAFT</option>
                    </select>
                </div>
            </div>
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
@if ($data['check_role'])
<div class="d-flex justify-content-between">
    <a href="{{ route('materi.create', ['id' => $data['mata']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah materi pelatihan"><i class="las la-plus"></i>Tambah</a>
</div>
<br>
@endif

<div class="row drag">

    @foreach ($data['materi'] as $item)
    <div class="col-sm-6 col-xl-4" @if ($data['check_role']) id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan" @endif>
      <div class="card card-list">
        <div class="card-body d-flex justify-content-between align-items-start pb-1">
          <div>
            <a href="{{ route('bahan.index', ['id' => $item->id]) }}" class="text-body text-big font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!}</a>
          </div>

          <div class="btn-group project-actions dropdown">
            <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle hide-arrow  btn-toggle-radius" data-toggle="dropdown" aria-expanded="false">
              <i class="ion ion-ios-more"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 26px; left: 26px;">
              <a class="dropdown-item" href="{{ route('bahan.index', ['id' => $item->id]) }}" title="klik untuk melihat bahan pelatihan">
                <i class="las la-tasks"></i> Bahan Pelatihan
              </a>
              @if ($data['check_role'])
              <a class="dropdown-item" href="{{ route('materi.edit', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" title="klik untuk mengedit materi pelatihan">
                <i class="las la-pen"></i> Edit
              </a>
              @endif
              @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
              <a class="dropdown-item js-sa2-delete" href="javascript:void(0);" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus materi pelatihan">
                <i class="las la-trash-alt"></i> Hapus
              </a>
              @endif
              @if ($data['check_role'])
              <a class="dropdown-item" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} mata pelatihan">
                  <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> {{ $item->publish == 1 ? 'Draft' : 'Publish' }}
                  <form action="{{ route('materi.publish', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                </form>
              </a>
              @endif
            </div>
          </div>
        </div>
        <div class="card-body pb-3">
          <table class="table table-bordered mb-0">
                <tr>
                    <th>Creator</th>
                    <td>{{ $item->creator['name'] }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></td>
                </tr>
                @if ($data['check_role'])
                <tr>
                    <th>Urutan</th>
                    <td>
                        @if ($item->min('urutan') != $item->urutan)
                            <a href="javascript:;" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-secondary" title="klik untuk mengatur posisi">
                                <i class="las la-long-arrow-alt-up"></i>
                                <form action="{{ route('materi.position', ['id' => $item->mata_id, 'materiId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
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
                                <form action="{{ route('materi.position', ['id' => $item->mata_id, 'materiId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
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
          </table>
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

@if ($data['materi']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Materi Pelatihan tidak ditemukan !
            @else
            ! Data Materi Pelatihan kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['materi']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['materi']->firstItem() }}</strong> - <strong>{{ $data['materi']->lastItem() }}</strong> dari
                <strong>{{ $data['materi']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['materi']->onEachSide(3)->links() }}
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
                var id = '{{ $data['mata']->id }}';
                // console.log(data);
                $.ajax({
                    data: {'datas' : data},
                    url: '/mata/'+ id +'/materi/sort',
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
            var mata_id = $(this).attr('data-mataid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus materi pelatihan ini, data yang bersangkutan dengan materi pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/mata/" + mata_id + '/materi/' + id,
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
                        text: 'materi pelatihan berhasil dihapus'
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


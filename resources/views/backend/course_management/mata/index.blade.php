@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
@include('backend.course_management.breadcrumbs')

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
<div class="text-left">
    <a href="{{ route('program.index') }}" class="btn btn-secondary rounded-pill" title="kembali ke list kategori"><i class="las la-arrow-left"></i>Kembali</a>
    @if ($data['hasRole'])
    <a href="{{ route('mata.create', ['id' => $data['program']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah program pelatihan"><i class="las la-plus"></i>Tambah</a>
    @endif
</div>
<br>

<div class="row @if ($data['hasRole']) drag @endif">

    @foreach ($data['mata'] as $item)
    <div class="col-sm-6 col-xl-4" @if ($data['hasRole']) id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan" @endif>
      <div class="card card-list">
        <div class="card-body d-flex justify-content-between align-items-start pb-1">
          <div>
            <a href="{{ route('materi.index', ['id' => $item->id]) }}" class="text-body text-big font-weight-semibold" title="{!! $item->judul !!}">{!! Str::limit($item->judul, 80) !!}</a>
          </div>
          <div class="btn-group project-actions dropdown">
            <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle hide-arrow  btn-toggle-radius" data-toggle="dropdown" aria-expanded="false">
              <i class="ion ion-ios-more"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 26px; left: 26px;">
              <a class="dropdown-item" href="{{ route('materi.index', ['id' => $item->id]) }}" title="klik untuk melihat mata pelatihan">
                <i class="las la-swatchbook"></i> Mata Pelatihan
              </a>
              @if ($data['hasRole'])
              <a class="dropdown-item" href="{{ route('mata.edit', ['id' => $item->program_id, 'mataId' => $item->id]) }}" title="klik untuk mengedit program pelatihan">
                <i class="las la-pen"></i> Edit
              </a>
              @endif
              @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
              <a class="dropdown-item js-sa2-delete" href="javascript:void(0);" data-programid="{{ $item->program_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus program pelatihan">
                <i class="las la-trash-alt"></i> Hapus
              </a>
              @endif
              @if ($data['hasRole'])
              <a class="dropdown-item" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} program pelatihan">
                  <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> {{ $item->publish == 1 ? 'Draft' : 'Publish' }}
                  <form action="{{ route('mata.publish', ['id' => $item->program_id, 'mataId' => $item->id]) }}" method="POST">
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
                    <th>Tanggal Mulai</th>
                    <td>{{ $item->publish_start->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ !empty($item->publish_end) ? $item->publish_end->format('d F Y H:i') : '-' }}</td>
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
                                <form action="{{ route('mata.position', ['id' => $item->program_id, 'mataId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
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
                                <form action="{{ route('mata.position', ['id' => $item->program_id, 'mataId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
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
                        <a class="btn btn-success icon-btn btn-sm" href="{{ route('materi.index', ['id' => $item->id]) }}" title="klik untuk melihat mata pelatihan">
                            <i class="las la-swatchbook"></i>
                        </a>
                        @if ($data['hasRole'])
                        <a class="btn btn-info icon-btn btn-sm" href="{{ route('mata.edit', ['id' => $item->program_id, 'mataId' => $item->id]) }}" title="klik untuk mengedit program pelatihan">
                            <i class="las la-pen"></i>
                        </a>
                        @endif
                        @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                        <a class="btn btn-danger icon-btn btn-sm js-sa2-delete" href="javascript:void(0);" data-programid="{{ $item->program_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus program pelatihan">
                            <i class="las la-trash-alt"></i>
                        </a>
                        @endif
                        @if ($data['hasRole'])
                        <a class="btn btn-secondary icon-btn btn-sm" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} program pelatihan">
                            <i class="las la-{{ $item->publish == 0 ? 'eye-slash' : 'eye' }} "></i>
                            <form action="{{ route('mata.publish', ['id' => $item->program_id, 'mataId' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @endif
                        <a class="btn btn-primary icon-btn btn-sm" href="{{ route('course.detail', ['id' => $item->id]) }}" title="klik untuk melihat detail course">
                            <i class="las la-external-link-alt"></i>
                        </a>
                    </td>
                </tr>
                @if ($data['hasRole'])
                <tr>
                    <th>Enroll</th>
                    <td>
                        <a href="{{ route('mata.instruktur', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="klik untuk melihat instruktur">
                            <i class="las la-user-tie"></i> Instruktur
                        </a>
                        <a href="{{ route('mata.peserta', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="klik untuk melihat peserta">
                            <i class="las la-user"></i> Peserta
                        </a>
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

@if ($data['mata']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Program Pelatihan tidak ditemukan !
            @else
            ! Data Program Pelatihan kosong !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['mata']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['mata']->firstItem() }}</strong> - <strong>{{ $data['mata']->lastItem() }}</strong> dari
                <strong>{{ $data['mata']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['mata']->onEachSide(3)->links() }}
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
                var id = '{{ $data['program']->id }}';
                // console.log(data);
                $.ajax({
                    data: {'datas' : data},
                    url: '/program/'+ id +'/mata/sort',
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
            var program_id = $(this).attr('data-programid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus program pelatihan ini, data yang bersangkutan dengan program pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/program/" + program_id + '/mata/' + id,
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
                        text: 'program pelatihan berhasil dihapus'
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

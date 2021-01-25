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
                    <label class="form-label">Instruktur</label>
                    <select class="instruktur custom-select form-control" name="i">
                        <option value=" " selected>Semua</option>
                        @foreach ($data['instruktur'] as $ins)
                        <option value="{{ $ins->instruktur_id }}" {{ Request::get('i') == ''.$ins->instruktur_id.'' ? 'selected' : '' }}>{{ $ins->instruktur->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
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
    <a href="{{ route('mata.index', ['id' => $data['mata']->program_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list program"><i class="las la-arrow-left"></i>Kembali</a>
    <a href="{{ route('materi.create', ['id' => $data['mata']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah mata pelatihan"><i class="las la-plus"></i>Tambah</a>
</div>
<br>

<div class="row drag">

    @foreach ($data['materi'] as $item)
    <div class="col-sm-6 col-xl-4" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
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
              <a class="dropdown-item" href="{{ route('bahan.index', ['id' => $item->id]) }}" title="klik untuk melihat materi pelatihan">
                <i class="las la-folder"></i> Materi Pelatihan
              </a>
              <a class="dropdown-item" href="{{ route('materi.edit', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" title="klik untuk mengedit mata pelatihan">
                <i class="las la-pen"></i> Ubah
              </a>
              @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
              <a class="dropdown-item js-sa2-delete" href="javascript:void(0);" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus mata pelatihan">
                <i class="las la-trash-alt"></i> Hapus
              </a>
              @endif
              <a class="dropdown-item" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} mata pelatihan">
                  <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> {{ $item->publish == 1 ? 'Draft' : 'Publish' }}
                  <form action="{{ route('materi.publish', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                </form>
              </a>
              @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
              <hr>
              <a class="dropdown-item" href="{{ route('report.activity', ['materiId' => $item->id]) }}" title="klik untuk melihat report aktivitas">
                <i class="las la-file"></i> Activity Completion
              </a>
              <a class="dropdown-item" href="{{ route('report.compare', ['materiId' => $item->id]) }}" title="klik untuk melihat Test Comparison Report">
                <i class="ion ion-ios-git-compare"></i> Test Comparison Report
              </a>
              @endif
            </div>
          </div>
        </div>
        <div class="card-body pb-3">
          <table class="table table-bordered mb-0">
                <tr>
                    <th>Pembuat</th>
                    <td>{{ $item->creator['name'] }}</td>
                </tr>
                <tr>
                    <th>Instruktur</th>
                    <td>{{ $item->instruktur->user['name'] }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></td>
                </tr>
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
                <tr>
                    <th>Aksi</th>
                    <td>
                        <a class="btn btn-success btn-block btn-sm" href="{{ route('bahan.index', ['id' => $item->id]) }}" title="klik untuk melihat materi pelatihan">
                            <i class="las la-folder"></i> Materi Pelatihan
                        </a>
                        <a class="btn btn-info btn-block btn-sm" href="{{ route('materi.edit', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" title="klik untuk mengedit mata pelatihan">
                        <i class="las la-pen"></i> Ubah
                        </a>
                        @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                        <a class="btn btn-danger btn-block btn-sm js-sa2-delete" href="javascript:void(0);" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus mata pelatihan">
                        <i class="las la-trash-alt"></i> Hapus
                        </a>
                        @endif
                        <a class="btn btn-secondary btn-block btn-sm" href="javascript:void(0);" onclick="$(this).find('form').submit();" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} mata pelatihan">
                            <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }}"></i> {{ $item->publish == 0 ? 'Publish' : 'Draft' }}
                            <form action="{{ route('materi.publish', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                        </a>
                    </td>
                </tr>
                @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                <tr>
                    <th>Report</th>
                    <td>

                        <a class="btn btn-warning btn-block btn-sm" href="{{ route('report.activity', ['materiId' => $item->id]) }}" title="klik untuk melihat report aktivitas">
                            <i class="las la-file"></i> Activity Completion
                            </a>

                            <a class="btn btn-warning btn-block btn-sm" href="{{ route('report.compare', ['materiId' => $item->id]) }}" title="klik untuk melihat Test Comparison Report">
                                <i class="ion ion-ios-git-compare"></i> Test Comparison Report
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
              <div class="text-muted small">Tanggal Dibuat</div>
              <div class="font-weight-bold">{{ $item->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="col">
              <div class="text-muted small">Tanggal Diperbarui</div>
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
            ! Mata Pelatihan tidak ditemukan !
            @else
            ! Mata Pelatihan kosong !
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
                text: "Anda akan menghapus mata pelatihan ini, data yang bersangkutan dengan mata pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        text: 'mata pelatihan berhasil dihapus'
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

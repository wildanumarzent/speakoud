@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
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
</div>
<br>

@if (session()->has('failures'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    gagal import data. <a href="{{ route('dosen.index') }}"><em>Kembali ke list</em></a>
</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert"><i class="las la-times"></i></button>
    @foreach ($errors->all() as $error)
        <i class="las la-thumbtack"></i> {{ $error }} <br>
    @endforeach
  </div>
@endif

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Instruktur List</h5>
        <div class="card-header-elements ml-auto">
            <button type="button" class="btn icon-btn-only-sm btn-success" title="klik untuk import data instruktur" data-toggle="modal" data-target="#modals-import">
                <i class="las la-file-import"></i><span>Import</span>
            </button>
            <button type="button" class="btn btn-primary icon-btn-only-sm" data-toggle="modal" data-target="#modals-add-instruktur" title="klik untuk menambahkan instruktur ke program">
                <i class="las la-plus"></i> <span>Tambah</span>
            </button>
        </div>
    </div>
    @if (session()->has('failures'))
    <div class="table-responsive table-mobile-responsive">
        <table class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Row</th>
                    <th>Attribute</th>
                    <th>Errors</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session()->get('failures') as $validation)
                <tr class="table-danger">
                    <td>{{ $validation->row() }}</td>
                    <td>{{ $validation->attribute() }}</td>
                    <td>
                        <ul>
                            @foreach ($validation->errors() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $validation->values()[$validation->attribute()] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>Jabatan</th>
                    <th>Materi Upload</th>
                    <th style="width: 300px;">Kode Evaluasi</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['instruktur']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Instruktur tidak ditemukan !
                            @else
                            ! Instruktur kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instruktur'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->instruktur->nip }}</td>
                    <td>{{ $item->instruktur->user->name }}</td>
                    <td>{{ $item->instruktur->instansi($item->instruktur)->nama_instansi }}</td>
                    <td>{{ $item->instruktur->pangkat }}</td>
                    <td>{{ $item->mata->bahan()->where('creator_id', $item->instruktur->user->id)->count() }}</td>
                    <td>
                        @if (!empty($item->kode_evaluasi))
                        {{ $item->kode_evaluasi }}
                        <button type="button" class="btn btn-primary icon-btn btn-sm modals-evaluasi" data-toggle="modal" data-target="#modals-evaluasi-form" title="klik untuk mengubah kode evaluasi"
                            data-id="{{ $item->id }}"
                            data-mataid="{{ $item->mata_id }}"
                            data-name="{{ $item->instruktur->user->name  }}"
                            data-evaluasi="{{ $item->kode_evaluasi  }}"
                        >
                            <i class="las la-pen"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm modals-evaluasi" data-toggle="modal" data-target="#modals-evaluasi-form" title="klik untuk menambahkan kode evaluasi"
                            data-id="{{ $item->id }}"
                            data-mataid="{{ $item->mata_id }}"
                            data-name="{{ $item->instruktur->user->name  }}"
                        >
                            <i class="las la-plus"></i> Kode Evaluasi
                        </button>
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-danger icon-btn btn-sm js-sa2-delete" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus instruktur pelatihan">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['instruktur']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Instruktur tidak ditemukan !
                            @else
                            ! Instruktur kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instruktur'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">NIP</div>
                                    <div class="desc-table">{{ $item->instruktur->nip }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nama</div>
                                    <div class="desc-table">{{ $item->instruktur->user->name }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Instansi</div>
                                    <div class="desc-table">{{ $item->instruktur->instansi($item->instruktur)->nama_instansi }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Jabatan</div>
                                    <div class="desc-table">{{ $item->instruktur->pangkat }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Materi Upload</div>
                                    <div class="desc-table">{{ $item->mata->bahan()->where('creator_id', $item->instruktur->user->id)->count() }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Kode Evaluasi</div>
                                    <div class="desc-table">
                                        @if (!empty($item->kode_evaluasi))
                                        {{ $item->kode_evaluasi }}
                                        <button type="button" class="btn btn-primary icon-btn btn-sm modals-evaluasi" data-toggle="modal" data-target="#modals-evaluasi-form" title="klik untuk mengubah kode evaluasi"
                                            data-id="{{ $item->id }}"
                                            data-mataid="{{ $item->mata_id }}"
                                            data-name="{{ $item->instruktur->user->name  }}"
                                            data-evaluasi="{{ $item->kode_evaluasi  }}"
                                        >
                                            <i class="las la-pen"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm modals-evaluasi" data-toggle="modal" data-target="#modals-evaluasi-form" title="klik untuk menambahkan kode evaluasi"
                                            data-id="{{ $item->id }}"
                                            data-mataid="{{ $item->mata_id }}"
                                            data-name="{{ $item->instruktur->user->name  }}"
                                        >
                                            <i class="las la-plus"></i> Kode Evaluasi
                                        </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="javascript:void(0);" class="btn btn-danger icon-btn btn-sm js-sa2-delete" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus instruktur pelatihan">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            <tbody>
        </table>
    </div>
    @endif
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['instruktur']->firstItem() }}</strong> - <strong>{{ $data['instruktur']->lastItem() }}</strong> dari
                <strong>{{ $data['instruktur']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['instruktur']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.course_management.mata.instruktur.modal-create')
@include('backend.course_management.mata.instruktur.modal-import')
@include('backend.course_management.mata.instruktur.modal-evaluasi')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('#modals-add-instruktur')
    });

    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var mata_id = $(this).attr('data-mataid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus instruktur pelatihan ini, data yang bersangkutan dengan instruktur pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/mata/" + mata_id + '/instruktur/' + id,
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
                        text: 'instruktur pelatihan berhasil dihapus'
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

    //modal
    $('.modals-evaluasi').click(function() {
        var id = $(this).data('id');
        var mata_id = $(this).data('mataid');
        var name = $(this).data('name');
        var evaluasi = $(this).data('evaluasi');
        var url = '/mata/'+ mata_id +'/instruktur/' + id;

        $(".modal-dialog #form-evaluasi").attr('action', url);
        $('.modal-body #name').val(name);
        $('.modal-body #kode_evaluasi').val(evaluasi);
    });
</script>

@include('components.toastr')
@endsection

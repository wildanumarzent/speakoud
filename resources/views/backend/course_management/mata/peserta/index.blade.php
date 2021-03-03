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
    gagal import data. <a href="{{ route('mata.peserta', ['id' => $data['mata']->id]) }}"><em>Kembali ke list</em></a>
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
        <h5 class="card-header-title mt-1 mb-0">Peserta List</h5>
        <div class="card-header-elements ml-auto">
            <button type="button" class="btn icon-btn-only-sm btn-success" title="klik untuk import data peserta" data-toggle="modal" data-target="#modals-import">
                <i class="las la-file-import"></i><span>Import</span>
            </button>
            @role ('developer|administrator')
            <div class="btn-group float-right dropdown">
                  <a href="{{route('mata.peserta.export',['mataId' => $data['mata']->id])}}" class="btn btn-success dropdown-toggle hide-arrow icon-btn-only-sm" title="klik untuk export peserta"><i class="las la-download"></i><span>Export</span></a>
            </div>
            @endrole
            <button type="button" class="btn btn-primary icon-btn-only-sm" data-toggle="modal" data-target="#modals-add-peserta" title="klik untuk menambahkan peserta ke program">
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
                    <th>Instansi / Perusahaan</th>
                    <th>Unit Kerja</th>
                    {{-- <th>Surat Izin</th> --}}
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="6" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Peserta tidak ditemukan !
                            @else
                            ! Data Peserta kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->peserta->nip }}</td>
                    <td>{{ $item->peserta->user->name }}</td>
                    <td>{{ $item->peserta->instansi($item->peserta)->nama_instansi }}</td>
                    <td>{{ $item->peserta->kedeputian }}</td>
                    {{-- <td>-</td> --}}
                    <td>
                        <a href="javascript:void(0);" class="btn btn-danger icon-btn btn-sm js-sa2-delete" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" title="klik untuk menghapus peserta pelatihan">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['peserta']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@include('backend.course_management.mata.peserta.modal-create')
@include('backend.course_management.mata.peserta.modal-import')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('#modals-add-peserta')
    });

    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
            var mata_id = $(this).attr('data-mataid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus peserta pelatihan ini, data yang bersangkutan dengan peserta pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/mata/" + mata_id + '/peserta/' + id,
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
                        text: 'peserta pelatihan berhasil dihapus'
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

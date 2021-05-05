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
                    <label class="form-label">Limit</label>
                    <select class="limit custom-select" name="l">
                        <option value="20" selected>Any</option>
                        @foreach (config('custom.filtering.limit') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="Limit {{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                @if (Request::get('trash') == 'deleted')
                <input type="hidden" name="trash" value="deleted">
                @endif
                <div class="form-group">
                    <label class="form-label">Roles</label>
                    <select class="role custom-select form-control" name="r">
                        <option value=" " selected>Semua</option>
                        @foreach ($data['roles'] as $role)
                        <option value="{{ $role->id }}" {{ $role->id == Request::get('r') ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="a">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.active') as $key => $value)
                        <option value="{{ $key }}" {{ Request::get('a') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
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

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Users List</h5>
        <div class="card-header-elements ml-auto">
            @role ('developer')
            <a href="{{ route('user.trash') }}" class="btn btn-secondary icon-btn-only-sm" title="klik untuk melihat tong sampah user">
                <i class="las la-trash"></i><span>Recycle Bin</span>
            </a>
            @endrole
            <a href="{{ route('user.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah user">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th style="width: 120px; text-align: center;">Roles</th>
                    <th style="width: 120px; text-align: center;">Status</th>
                    <th style="width: 200px;">Tanggal Dibuat</th>
                    <th style="width: 200px;">Tanggal Diperbarui</th>
                    <th style="width: 200px;">Terakhir login</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['users']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! User tidak ditemukan !
                            @else
                            ! User kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['users'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>
                        <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                        @if ($item->email_verified == 1)
                        <i class="las la-check-circle text-success" title="sudah di verifikasi"></i>
                        @else
                        <i class="las la-times-circle text-danger" title="belum di verifikasi"></i>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-outline-primary">{{ strtoupper(str_replace('_', ' ', $item->roles[0]->name)) }}</span>
                    </td>
                    <td class="text-center">
                        @if ($item->id == auth()->user()->id || $item->roles[0]->id <=  auth()->user()->roles[0]->id)
                        <a href="#" class="badge badge-outline-{{ $item->active == 1 ? 'success' : 'secondary' }}">{{ $item->active == 1 ? 'AKTIF' : 'TIDAK AKTIF' }}</a>
                        @else
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-outline-{{ $item->active == 1 ? 'success' : 'secondary' }}"
                            title="klik untuk {{ $item->active == 0 ? 'mengaktifkan' : 'menon-aktifkan' }} user">{{ $item->active == 1 ? 'AKTIF' : 'TIDAK AKTIF' }}
                            <form action="{{ route('user.activate', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->last_login != null ? $item->last_login->format('d F Y - (H:i)') : '-' }}</td>
                    <td>
                        @if ($item->id == auth()->user()->id || $item->roles[0]->id < auth()->user()->roles[0]->id)
                        <button class="btn icon-btn btn-secondary btn-sm" disabled>
                            <i class="las la-pen"></i>
                        </button>
                        <button class="btn icon-btn btn-secondary btn-sm" disabled>
                            <i class="las la-trash-alt"></i>
                        </button>
                        @else
                        <a href="{{ route('user.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengubah user">
                                <i class="las la-pen"></i>
                        </a>
                            @if ($item->hasRole('internal|mitra|instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra'))
                            <button class="btn icon-btn btn-secondary btn-sm" disabled>
                                <i class="las la-trash-alt"></i>
                            </button>
                            @else
                                <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus user">
                                    <i class="las la-trash-alt"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['users']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! User tidak ditemukan !
                            @else
                            ! User kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['users'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Nama</div>
                                    <div class="desc-table">{{ $item->name }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Username</div>
                                    <div class="desc-table">{{ $item->username }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Roles</div>
                                    <div class="desc-table"><span class="badge badge-outline-primary">{{ strtoupper($item->roles[0]->name) }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Terkarhir Login</div>
                                    <div class="desc-table">{{ $item->last_login != null ? $item->last_login->format('d F Y - (H:i)') : '-' }}</div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        @if ($item->id == auth()->user()->id || $item->roles[0]->id < auth()->user()->roles[0]->id)
                                        <button class="btn icon-btn btn-secondary btn-sm" disabled>
                                            <i class="las la-pen"></i>
                                        </button>
                                        <button class="btn icon-btn btn-secondary btn-sm" disabled>
                                            <i class="las la-trash-alt"></i>
                                        </button>
                                        @else
                                        <a href="{{ route('user.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengubah user">
                                                <i class="las la-pen"></i>
                                        </a>
                                            @if ($item->hasRole('internal|mitra|instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra'))
                                            <button class="btn icon-btn btn-secondary btn-sm" disabled>
                                                <i class="las la-trash-alt"></i>
                                            </button>
                                            @else
                                                <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus user">
                                                    <i class="las la-trash-alt"></i>
                                                </a>
                                            @endif
                                        @endif
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
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['users']->firstItem() }}</strong> - <strong>{{ $data['users']->lastItem() }}</strong> dari
                <strong>{{ $data['users']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['users']->onEachSide(1)->links() }}
            </div>
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
                        url: "/user/" + id + '/soft',
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
                        text: 'User berhasil dihapus'
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

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
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        <option value="5" {{ Request::get('t') == '5' ? 'selected' : '' }}>Internal</option>
                        <option value="6" {{ Request::get('t') == '6' ? 'selected' : '' }}>Mitra</option>
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
        <h5 class="card-header-title mt-1 mb-0">Instruktur List</h5>
        <div class="card-header-elements ml-auto">
            @role ('developer|administrator')
            <div class="btn-group float-right dropdown ml-2">
                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown" title="klik untuk menambah instruktur"><i class="las la-plus"></i><span>Tambah</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('instruktur.create', ['instruktur' => 'internal']) }}" class="dropdown-item" ><i class="las la-user-tie"></i><span>Instruktur Internal</span></a>
                    <a href="{{ route('instruktur.create', ['instruktur' => 'mitra']) }}" class="dropdown-item" ><i class="las la-user-tie"></i><span>Instruktur Mitra</span></a>
                </div>
            </div>
            @else
            <a href="{{ route('instruktur.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah instruktur">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
            @endrole
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP / NIK</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Unit Kerja</th>
                    {{-- <th>Kedeputian</th> --}}
                    <th>Jabatan</th>
                    <th>Telpon</th>
                    <th>Alamat</th>
                    <th style="width: 120px; text-align: center;">Tipe</th>
                    <th style="width: 200px;">Tanggal Dibuat</th>
                    <th style="width: 200px;">Tanggal Diperbarui</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['instruktur']->total() == 0)
                <tr>
                    <td colspan="12" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! User instruktur tidak ditemukan !
                            @else
                            ! User instruktur kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instruktur'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->username }}</td>
                    <td>{{ $item->instansi($item)->nama_instansi ?? '-' }}</td>
                    {{-- <td>{{ $item->kedeputian ?? '-' }}</td> --}}
                    <td>{{ $item->pangkat ?? '-' }}</td>
                    <td>{{ $item->user->information->phone ?? '-' }}</td>
                    <td>{{ $item->user->information->address ?? '-' }}</td>
                    <td>
                        <span class="badge badge-outline-primary">{{ strtoupper(str_replace('_', ' ', $item->user->roles[0]->name)) }}</span>
                    </td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        <a href="{{ route('instruktur.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit instruktur">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus instruktur">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['instruktur']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! User instruktur tidak ditemukan !
                            @else
                            ! User instruktur kosong !
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
                                    <div class="data-table">NIP / NIK</div>
                                    <div class="desc-table">{{ $item->nip ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Nama</div>
                                    <div class="desc-table">{{ $item->user->name }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Username</div>
                                    <div class="desc-table">{{ $item->user->username }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Unit Kerja</div>
                                    <div class="desc-table">{{ $item->instansi($item)->nama_instansi ?? '-' }}</div>
                                </div>
                                {{-- <div class="item-table">
                                    <div class="data-table">Kedeputian</div>
                                    <div class="desc-table">{{ $item->kedeputian ?? '-' }}</div>
                                </div> --}}
                                <div class="item-table">
                                    <div class="data-table">Jabatan</div>
                                    <div class="desc-table">{{ $item->pangkat ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Telpon</div>
                                    <div class="desc-table">{{ $item->user->information->phone ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Alamat</div>
                                    <div class="desc-table">{{ $item->user->information->address ?? '-' }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('instruktur.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit instruktur">
                                                <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus instruktur">
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //delete
    $(document).ready(function () {
        $('.js-sa2-delete').on('click', function () {
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
                        url: "/instruktur/" + id + "/soft",
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
                        text: 'User instruktur berhasil dihapus'
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

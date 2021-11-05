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
                <div class="form-group">
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        <option value="7" {{ Request::get('t') == '7' ? 'selected' : '' }}>Peserta</option>
                        {{-- <option value="8" {{ Request::get('t') == '8' ? 'selected' : '' }}>Mitra</option> --}}
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Jabatan</label>
                    <select class="status custom-select form-control" name="j">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.master_data.jabatan') as $key => $value)
                        <option value="{{ $key }}" {{ Request::get('j') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Peserta List</h5>
        <div class="card-header-elements ml-auto">
            @role ('developer|administrator')
            <div class="btn-group float-right dropdown ml-2">
                <a href="{{ route('peserta.create', ['peserta' => 'internal']) }}" class="btn btn-primary" ><i class="las la-user"></i><span>Tambah peserta</span></a>
            </div>
            @else
            <a href="{{ route('peserta.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah peserta">
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
                    <th>Nama</th>
                    <th>Telpon</th>
                    <th>Alamat</th>
                    <th style="width: 200px;">Tanggal Dibuat</th>
                    <th style="width: 200px;">Tanggal Diperbarui</th>
                    {{-- <th>Learning Journey</th> --}}
                    <th style="width: 80px;" class="text-center">Data</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="15" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! User peserta tidak ditemukan !
                            @else
                            ! User peserta kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>+62{{ $item->user->information->phone ?? '-' }}</td>
                    <td>{{ $item->user->information->address ?? '-' }}</td>
                    {{-- <td>
                        <span class="badge badge-outline-primary">{{ strtoupper(str_replace('_', ' ', $item->user->roles[0]->name)) }}</span>
                    </td> --}}
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    {{-- <td>
                        <a href="{{ route('journey.peserta', ['id' => $item->id]) }}" target="_blank" class="btn btn-primary icon-btn btn-sm" title="klik untuk melihat learning journey">
                            <i class="las la-external-link-alt"></i>
                        </a>
                    </td> --}}
                    <td class="text-center">
                        @if ($item->status_peserta == 1 && !empty($item->user->photo['filename']))
                            <span class="badge badge-success">Complete</span>
                        @else
                            <span class="badge badge-danger">Belum</span>
                        @endif
                    </td>
                    <td >
                        <a href=""></a>
                       
                        <a href="{{ route('peserta.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit peserta">
                            <i class="las la-pen"></i>
                        </a>
                         <a href="{{ route('peserta.detailAkses', ['id' => $item->id]) }}" class="btn icon-btn btn-primary btn-sm" title="Akses Materi">
                            <i class="las la-info"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus peserta">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="15" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! User peserta tidak ditemukan !
                            @else
                            ! User peserta kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">NIP</div>
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
                                    <div class="desc-table">{{ $item->instansi($item)->nama_instansi ?? '-' }}<</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Kedeputian</div>
                                    <div class="desc-table">{{ $item->kedeputian ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Jabatan</div>
                                    <div class="desc-table">{{ config('addon.label.jabatan.'.$item->pangkat) ?? '-' }}</div>
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
                                         
                                        <a href="{{ route('peserta.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit peserta">
                                                <i class="las la-pen"></i>
                                        </a>
                                       
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus peserta">
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
                Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['peserta']->onEachSide(1)->links() }}
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
                        url: "/peserta/" + id + "/soft",
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
                        text: 'User peserta berhasil dihapus'
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

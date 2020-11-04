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
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Program Pelatihan List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('program.create') }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk menambah program pelatihan" data-toggle="tooltip">
                <i class="las la-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th style="width: 10px;">Sort</th>
                    <th>Judul</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 180px;">Creator</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 100px;">Urutan</th>
                    <th style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody class="drag">
                @if ($data['program']->total() == 0)
                <tr>
                    <td colspan="9" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('p') || Request::get('q'))
                            ! Program Pelatihan tidak ditemukan !
                            @else
                            ! Data Program Pelatihan kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['program'] as $item)
                <tr style="cursor: move;" id="{{ $item->id }}" title="geser untuk merubah urutan">
                    <td>{{ $data['number']++ }}</td>
                    <td class="text-center" style="font-size:1.4em;">
                        <i class="las la-arrows-alt"></i>
                    </td>
                    <td><strong>{!! $item->judul !!}</strong></td>
                    <td>
                        <span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span>
                    </td>
                    <td><i class="las la-user"></i> {{ $item->creator['name'] }}</td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
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
                    <td>
                        <a href="{{ route('mata.index', ['id' => $item->id]) }}" class="btn icon-btn btn-success btn-sm" title="klik untuk melihat mata pelatihan" data-toggle="tooltip">
                            <i class="las la-book"></i>
                        </a>
                        <a href="{{ route('program.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit program" data-toggle="tooltip">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus program" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['program']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('p') || Request::get('q'))
                            ! Program Pelatihan tidak ditemukan !
                            @else
                            ! Data Program Pelatihan kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['program'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Judul</div>
                                    <div class="desc-table">{!! $item->judul !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Status</div>
                                    <div class="desc-table"><span class="badge badge-outline-{{ $item->publish == 1 ? 'primary' : 'warning' }}">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Creator</div>
                                    <div class="desc-table"><i class="las la-user"></i> {{ $item->creator['name'] }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Created</div>
                                    <div class="desc-table">{{ $item->created_at->format('d F Y - (H:i)') }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Updated</div>
                                    <div class="desc-table">{{ $item->updated_at->format('d F Y - (H:i)') }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
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
                                        <a href="{{ route('mata.index', ['id' => $item->id]) }}" class="btn icon-btn btn-success btn-sm" title="klik untuk melihat mata pelatihan" data-toggle="tooltip">
                                            <i class="las la-book"></i>
                                        </a>
                                        <a href="{{ route('program.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit program" data-toggle="tooltip">
                                                <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus program" data-toggle="tooltip">
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
                Menampilkan : <strong>{{ $data['program']->firstItem() }}</strong> - <strong>{{ $data['program']->lastItem() }}</strong> dari
                <strong>{{ $data['program']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['program']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
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

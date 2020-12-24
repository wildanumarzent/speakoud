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

<div class="drag">

    @foreach ($data['materi'] as $item)
    <div class="card mb-3" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
              @if ($item->min('urutan') != $item->urutan)
                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menaikan posisi">
                    <i class="ion ion-ios-arrow-up"></i>
                    <form action="{{ route('materi.position', ['id' => $item->mata_id, 'materiId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
              @else
              <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-up"></i></a>
              @endif
              <div class="text-xlarge font-weight-bolder line-height-1 my-2">{{ $data['number']++ }}</div>
              @if ($item->max('urutan') != $item->urutan)
                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menurunkan posisi">
                    <i class="ion ion-ios-arrow-down"></i>
                    <form action="{{ route('materi.position', ['id' => $item->mata_id, 'materiId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
              @else
                <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-down"></i></a>
              @endif
            </div>
            <div class="media-body ml-4">
              <a href="{{ route('bahan.index', ['id' => $item->id]) }}" class="text-big">{!! $item->judul !!} <span class="badge badge-secondary">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span></a>
              <div class="my-2">
                <div class="row">
                    <div class="col-md-4">
                        {!! !empty($item->keterangan) ? Str::limit(strip_tags($item->keterangan), 120) : '-' !!}
                    </div>
                    <div class="col-md-8 text-right">
                        <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('bahan.index', ['id' => $item->id]) }}" title="klik untuk melihat materi pelatihan">
                            <i class="las la-folder"></i> <span>Materi</span>
                        </a>
                        @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-primary btn-sm icon-btn-only-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melihat activity"><i class="las la-chart-pie"></i><span>Activity</span></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('report.activity', ['materiId' => $item->id]) }}" class="dropdown-item" title="klik untuk melihat report aktivitas">
                                    <i class="las la-file"></i><span>Activity Report</span>
                                </a>
                                <a href="{{ route('report.compare', ['materiId' => $item->id]) }}" class="dropdown-item" title="klik untuk melihat Test Comparison Report">
                                    <i class="ion ion-ios-git-compare"></i><span>Test Comparison Report</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-warning btn-sm icon-btn-only-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melakukan aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('materi.edit', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit mata pelatihan">
                                    <i class="las la-pen"></i><span>Ubah</span>
                                </a>
                                @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                                <a href="javascript:void(0);" data-mataid="{{ $item->mata_id }}" data-id="{{ $item->id }}" class="dropdown-item js-sa2-delete" title="klik untuk menghapus mata pelatihan">
                                    <i class="las la-trash-alt"></i><span>Hapus</span>
                                </a>
                                @endif
                                <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} mata pelatihan">
                                    <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> <span>{{ $item->publish == 0 ? 'Publish' : 'Draft' }}</span>
                                    <form action="{{ route('materi.publish', ['id' => $item->mata_id, 'materiId' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="small">
                <span class="text-muted ml-3"><i class="las la-user text-lighter text-big align-middle"></i>&nbsp; {{ $item->creator->name }}</span>
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->created_at->format('d/m/Y H:i') }}</span>
                <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->updated_at->format('d/m/Y H:i') }}</span>
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


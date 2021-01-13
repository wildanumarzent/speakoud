@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
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
            {{-- <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Tanggal Diklat</label>
                    <div class="input-daterange input-group datepicker">
                        <input type="text" class="form-control" name="f" value="{{ Request::get('f') }}">
                        <div class="input-group-append input-group-prepend">
                          <span class="input-group-text">sampai</span>
                        </div>
                        <input type="text" class="form-control" name="t" value="{{ Request::get('t') }}">
                    </div>
                </div>
            </div> --}}
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
    @role('administrator|internal')
    <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#modals-tipe" title="klik untuk menambah program pelatihan"><i class="las la-plus"></i>Tambah</button>
    @else
    <a href="{{ route('mata.create', ['id' => $data['program']->id]) }}" class="btn btn-primary rounded-pill" title="klik untuk menambah program pelatihan"><i class="las la-plus"></i>Tambah</a>
    @endrole
</div>
<br>

<div class="drag">

    @foreach ($data['mata'] as $item)
    <div class="card mb-3" id="{{ $item->id }}" style="cursor: move;" title="geser untuk merubah urutan">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
              @if ($item->min('urutan') != $item->urutan)
                <a href="javascript:void(0)" onclick="$(this).find('form').submit();" class="d-block text-primary text-big line-height-1" title="klik untuk menaikan posisi">
                    <i class="ion ion-ios-arrow-up"></i>
                    <form action="{{ route('mata.position', ['id' => $item->program_id, 'mataId' => $item->id, 'position' => ($item->urutan - 1)]) }}" method="POST">
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
                    <form action="{{ route('mata.position', ['id' => $item->program_id, 'mataId' => $item->id, 'position' => ($item->urutan + 1)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                </a>
              @else
                <a href="javascript:void(0)" class="d-block text-primary text-big line-height-1"><i class="ion ion-ios-arrow-down"></i></a>
              @endif
            </div>
            <div class="media-body ml-4">
              <a href="{{ route('materi.index', ['id' => $item->id]) }}" class="text-big">{!! $item->judul !!} <span class="badge badge-secondary">{{ $item->publish == 1 ? 'Publish' : 'Draft' }}</span></a>
              <div class="my-2">
                <div class="row">
                    <div class="col-md-4">
                        Tanggal Mulai : <strong>{{ $item->publish_start->format('d F Y H:i') }}</strong> <em>s/d</em> <strong>{{ $item->publish_end->format('d F Y H:i') }}</strong>
                        <table class="table table-bordered mb-0" style="width: 200px;">
                            <tr>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-success btn-sm btn-block dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melihat user enroll"><i class="las la-users"></i><span>Enroll</span></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('mata.instruktur', ['id' => $item->id]) }}" class="dropdown-item" ><i class="las la-user-tie"></i><span>Instruktur</span></a>
                                            <a href="{{ route('mata.peserta', ['id' => $item->id]) }}" class="dropdown-item" ><i class="las la-user"></i><span>Peserta</span></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary btn-sm btn-block dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk mengatur sertifikat"><i class="las la-certificate"></i><span>Sertifikat</span></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('sertifikat.internal.form', ['id' => $item->id]) }}" class="dropdown-item" ><i class="las la-tags"></i><span>Internal</span></a>
                                            <a href="{{ route('sertifikat.external.peserta', ['id' => $item->id]) }}" class="dropdown-item" ><i class="las la-tags"></i><span>External</span></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm icon-btn-only-sm mr-1" href="{{ route('mata.pembobotan', ['id' => $item->id]) }}" title="klik untuk melihat laporan program">
                                        <i class="las la-chart-line"></i> <span>Aktivitas</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-8 text-right">
                        <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('materi.index', ['id' => $item->id]) }}" title="klik untuk melihat mata pelatihan">
                            <i class="las la-swatchbook"></i> <span>Mata</span>
                        </a>
                        <a class="btn btn-primary btn-sm icon-btn-only-sm mr-1" href="{{ route('soal.kategori', ['id' => $item->id]) }}" title="klik untuk melihat bank soal">
                            <i class="las la-spell-check"></i> <span>Bank Soal</span>
                        </a>
                        <a class="btn btn-info btn-sm icon-btn-only-sm mr-1" href="{{ route('course.detail', ['id' => $item->id]) }}" title="klik untuk melihat detail course">
                            <span>Detail</span> <i class="las la-external-link-alt ml-1"></i>
                        </a>
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-warning btn-sm icon-btn-only-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="klik untuk melakukan aksi"><i class="las la-ellipsis-v"></i><span>Aksi</span></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('mata.edit', ['id' => $item->program_id, 'mataId' => $item->id]) }}" class="dropdown-item" title="klik untuk mengedit program pelatihan">
                                    <i class="las la-pen"></i><span>Ubah</span>
                                </a>
                                @if (auth()->user()->hasRole('developer|administrator') || $item->creator_id == auth()->user()->id)
                                <a href="javascript:void(0);" data-programid="{{ $item->program_id }}" data-id="{{ $item->id }}" class="dropdown-item js-sa2-delete" title="klik untuk menghapus program pelatihan">
                                    <i class="las la-trash-alt"></i><span>Hapus</span>
                                </a>
                                @endif
                                <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" title="klik untuk {{ $item->publish == 0 ? 'publish' : 'draft' }} program pelatihan">
                                    <i class="las la-{{ $item->publish == 0 ? 'eye' : 'eye-slash' }} "></i> <span>{{ $item->publish == 0 ? 'Publish' : 'Draft' }}</span>
                                    <form action="{{ route('mata.publish', ['id' => $item->program_id, 'mataId' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </a>
                                @role ('administrator|internal')
                                <a href="javascript:void(0);" onclick="$(this).find('#form-publish').submit();" class="dropdown-item copy" data-id="{{ $item->id }}" title="klik untuk copy program ke template">
                                    <i class="las la-clipboard"></i> <span>Copy sebagai template</span>
                                    <form action="{{ route('template.mata.copy', ['id' => $item->id]) }}" method="POST" id="form-copy-{{ $item->id }}">
                                        @csrf
                                    </form>
                                </a>
                                @endrole
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

@if ($data['mata']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('q'))
            ! Program Pelatihan tidak ditemukan !
            @else
            ! Program Pelatihan kosong !
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

<div class="modal fade" id="modals-tipe">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Pilih Tipe
            <span class="font-weight-light">Tambah Program</span>
            <br>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 ml-sm-auto text-center">
                    <a href="{{ route('mata.create', ['id' => $data['program']->id]) }}" class="btn btn-success rounded-pill" title="klik untuk menambah program pelatihan"><i class="las la-plus"></i> Buat Baru</a>
                </div>
                <div class="col-md-6 ml-sm-auto text-center">
                    <button type="button" class="btn btn-primary rounded-pill from-template" title="klik untuk menampilkan template"><i class="las la-clipboard"></i>Dari Template</button>
                </div>
            </div>
            <div id="template">
                <hr>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Template</label>
                        <select class="select2 show-tick select-template" name="template_id" data-id="{{ $data['program']->id }}" data-style="btn-default">
                            <option value=" " selected disabled>Pilih</option>
                            @foreach ($data['template'] as $item)
                                <option value="{{ $item->id }}">{!! $item->judul !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" title="klik untuk menutup">Tutup</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script>
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('#modals-tipe')
    });
    $("#template").hide();
    $('.from-template').click(function(e) {
        $("#template").toggle('slow');
    });
    $('.select-template').on('change', function () {
        var id = $(this).attr('data-id');
        var templateId = $(this).val();
        if (templateId) {
            window.location = "/program/"+ id +"/mata/template/"+ templateId +"/create";
        }
        return false;
        //$('form').submit();
    });
    // Bootstrap Datepicker
    $(function() {
        var isRtl = $('html').attr('dir') === 'rtl';

        $('.datepicker').datepicker({
            orientation: isRtl ? 'auto right' : 'auto left',
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    });
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

    //copy
    $(document).ready(function () {
        $('.copy').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('href');
            Swal.fire({
            title: "Apakah anda yakin ?",
            text: "Data Materi, Bahan Pelatihan tidak boleh kosong",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, copy!',
            cancelButtonText: "Tidak, terima kasih",
            }).then((result) => {
            if (result.value) {
                $("#form-copy-"+id).submit();
            }
            })
        });
    });
</script>

@include('components.toastr')
@endsection

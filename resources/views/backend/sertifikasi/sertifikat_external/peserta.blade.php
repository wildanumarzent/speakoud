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
    <a href="{{ route('mata.index', ['id' => $data['mata']->id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke program"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

@include('components.alert-any')

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Peserta Pelatihan</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="table-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>Kedeputian</th>
                    <th>Jabatan</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Peserta pelatihan tidak ditemukan !
                            @else
                            ! Peserta pelatihan kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->peserta->nip ?? '-' }}</td>
                    <td>{{ $item->peserta->user->name }}</td>
                    <td>{{ $item->peserta->instansi($item->peserta)->nama_instansi ?? '-' }}</td>
                    <td>{{ $item->peserta->kedeputian ?? '-' }}</td>
                    <td>{{ config('addon.label.jabatan.'.$item->peserta->pangkat) ?? '-' }}</td>
                    <td>
                        <button type="button" class="btn icon-btn btn-primary btn-sm modals-upload" data-toggle="modal" data-target="#modals-upload" title="klik untuk mengupload sertifikat"
                            data-pesertaid="{{ $item->peserta_id }}"
                            data-mataid="{{ $item->mata_id }}"
                            data-namapeserta="{{ $item->peserta->user->name }}">
                            <i class="las la-upload"></i>
                        </button>
                        <a href="{{ route('sertifikat.external.peserta.detail', ['id' => $item->mata_id, 'pesertaId' => $item->peserta_id]) }}" class="btn icon-btn btn-success btn-sm" title="klik untuk melihat sertifikat">
                            <i class="las la-certificate"></i>
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
</div>

@include('backend.sertifikasi.sertifikat_external.modal-upload')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //modal
    $('.modals-upload').click(function() {
        var id = $(this).data('id');
        var mata_id = $(this).data('mataid');
        var peserta_id = $(this).data('pesertaid');
        var name = $(this).data('namapeserta');
        var url = '/mata/'+ mata_id +'/sertifikat/external';

        $(".modal-dialog #form-upload").attr('action', url);
        $('.modal-body #name').val(name);
        $('.modal-body #pesertaid').val(peserta_id);
    });
</script>
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/pages/projects.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['tugas']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['tugas']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['tugas']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['tugas']->bahan->judul !!}</strong>
      </div>
    </div>
</div>

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
<div class="text-left">
    <a href="{{ route('course.bahan', ['id' => $data['tugas']->mata_id, 'bahanId' => $data['tugas']->bahan_id,  'tipe' => 'tugas']) }}" class="btn btn-secondary rounded-pill" title="kembali ke tugas"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>
<!-- / Filters -->
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Peserta List</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Tanggal Pengumpulan</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="6" align="center">
                        <i><strong style="color:red;">
                        @if (Request::get('q'))
                        ! Peserta tidak ditemukan !
                        @else
                        ! Data Peserta kosong !
                        @endif
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->user->peserta->nip }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modals-dokumen-{{ $item->id }}" title="klik untuk melihat tugas">
                            <i class="las la-file"></i> <span>Dokumen</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Showing : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> of
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['peserta']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('frontend.course.tugas.dokumen')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection
@section('jsbody')
@include('components.toastr')
@endsection


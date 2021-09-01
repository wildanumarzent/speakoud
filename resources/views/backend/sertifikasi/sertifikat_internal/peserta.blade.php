@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<!-- Filters -->
{{-- <div class="card">
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
</div> --}}
<!-- / Filters -->

<div class="text-left">
    <a href="{{ route('mata.index', ['id' => $data['mata']->program_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke program"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Sertifikat Peserta</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('sertifikat.internal.form', ['id' => $data['mata']->id]) }}" class="btn btn-primary icon-btn-only-sm" title="klik untuk mengatur sertifikat">
                <i class="las la-cog"></i><span>Sertifikat</span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Nama</th>
                    <th>Program</th>
                    <th style="width: 115px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Sertifikat peserta tidak ditemukan !
                            @else
                            ! Sertifikat peserta kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['peserta'] as $item)
                {{-- {{dd($item)}} --}}
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->peserta->user->name }}</td>
                    <td>{{ $item->mata->program->judul}}</td>
                    <td>
                        <a href="{{ route('bank.data.stream', ['path' => $item->file_path]) }}" class="btn icon-btn btn-primary btn-sm" title="sertifikat halaman depan">
                            <i class="las la-certificate"></i>
                        </a>
                        <a href="{{ route('sertifikat.internal.download', ['id' => $item->mata_id, 'sertifikatId' => $item->sertifikat_id]) }}" class="btn icon-btn btn-success btn-sm" title="sertifikat halaman belakang">
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
@include('components.toastr')
@endsection

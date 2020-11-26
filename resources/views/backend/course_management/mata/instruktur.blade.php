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

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Instruktur List</h5>
        <div class="card-header-elements ml-auto">

        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>Kedeputian</th>
                    <th>Materi Upload</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['instruktur']->total() == 0)
                <tr>
                    <td colspan="6" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Instruktur tidak ditemukan !
                            @else
                            ! Data Instruktur kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['instruktur'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->instruktur->nip }}</td>
                    <td>{{ $item->instruktur->user->name }}</td>
                    <td>{{ $item->instruktur->unit_kerja }}</td>
                    <td>{{ $item->instruktur->kedeputian }}</td>
                    <td>{{ $item->mata->bahan()->where('creator_id', $item->instruktur->user->id)->count() }}</td>
                </tr>
                @endforeach
            </tbody>
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

@include('components.toastr')
@endsection

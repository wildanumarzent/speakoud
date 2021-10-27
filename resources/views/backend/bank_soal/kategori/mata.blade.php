@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Program Pelatihan List</h5>
        <div class="card-header-elements ml-auto">
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Judul</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th style="width: 210px;">Pembuat</th>
                    <th style="width: 230px;">Tanggal Dibuat</th>
                    <th style="width: 230px;">Tanggal Diperbarui</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['mata']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i><strong style="color:red;">
                        ! Program pelatihan kosong !
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['mata'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->publish_start->format('d F Y (H:i)') }}</td>
                    <td>{{ $item->publish_end->format('d F Y (H:i)') }}</td>
                    <td>{{ $item->creator != null ? $item->creator->name : 'creator not found !' }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i)') }}</td>
                    <td>
                        <a href="{{ route('soal.kategori', ['id' => $item->id]) }}" class="btn btn-success btn-sm" title="klik untuk melihat bank soal">
                            <i class="las la-list"></i> Bank Soal
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['mata']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
                        <i><strong style="color:red;">
                        ! Program pelatihan kosong !
                        </strong></i>
                    </td>
                </tr>
                @endif
                @foreach ($data['mata'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Judul</div>
                                    <div class="desc-table">{!! $item->judul !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Tanggal Mulai</div>
                                    <div class="desc-table">{!! $item->publish_start !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Tanggal Selesai</div>
                                    <div class="desc-table">{!! $item->publish_end !!}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('soal.kategori', ['id' => $item->id]) }}" class="btn btn-success btn-sm" title="klik untuk melihat bank soal">
                                            <i class="las la-list"></i> Bank Soal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['mata']->firstItem() }}</strong> - <strong>{{ $data['mata']->lastItem() }}</strong> dari
                <strong>{{ $data['mata']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['mata']->onEachSide(1)->links() }}
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

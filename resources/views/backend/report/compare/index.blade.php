@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.css') }}">
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
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="User...">
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
        <h5 class="card-header-title mt-1 mb-0">Test Comparison Report</h5>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nilai Hasil Pretest</th>
                    <th>Nilai Hasil Postest</th>
                    <th>Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['peserta'] as $item)
                @php
                $pretest = ($data['pretestR']->where('user_id',$item->peserta->user->id)->count() / $data['pretestA']->where('user_id',$item->peserta->user->id)->count() ) * 100;
                $postest = ($data['postestR']->where('user_id',$item->peserta->user->id)->count() / $data['postestA']->where('user_id',$item->peserta->user->id)->count()) * 100;
                if($postest < 1){
                    $postest = 1;
                    $pretest += 1;
                }
                $final = (($postest - $pretest) / $postest) * 100;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$item->peserta->user->name}} </td>
                    <td>{{$item->peserta->user->email}}</td>
                    <td>{{$pretest}}</td>
                    <td>{{$postest}}</td>
                    <td>{{$final}}</td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (Request::get('q'))
                            ! Logs tidak ditemukan !
                            @else
                            ! Data Logs kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan :
                Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
                <strong>{{ $data['peserta']->total() }}</strong>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
@endsection


@include('components.toastr')
@endsection

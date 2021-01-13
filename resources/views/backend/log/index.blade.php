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
                        <label class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Tanggal...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning" title="klik untuk filter"><i class="las la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Filters -->
<div class="row">
    @if($data['type'] == 'time')
    <div class="col-md-12">
    @livewire('chart.log-time',['date' => $data['date']] )
    </div>
    @else
    <div class="col-md-12">
    @livewire('chart.log-date')
    </div>
    @endif
    </div>
<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Activity Logs List</h5>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Activity</th>
                    <th>Causer Name</th>
                    <th>Causer IP</th>
                    <th style="width: 300px;">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['log'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td> <b>{{ str_replace('_', ' ', strtoupper(trans($item->logable_name))) }} (Id:{{$item->logable_id}}) :</b> {{$item->event}}  </td>
                    <td>{{$item->creator}}</td>
                    <td>{{$item->ip_address}}</td>
                    <td >{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" align="center">
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
                Menampilkan : <strong>{{ $data['log']->firstItem() }}</strong> - <strong>{{ $data['log']->lastItem() }}</strong> dari
                <strong>{{ $data['log']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['log']->onEachSide(1)->links() }}
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

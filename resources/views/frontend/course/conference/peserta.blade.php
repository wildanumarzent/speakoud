@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-map-pin"></i>
        {!! $data['conference']->program->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['conference']->mata->judul !!} <i class="las la-arrow-right"></i>
        {!! $data['conference']->materi->judul !!} <i class="las la-arrow-right"></i>
        <strong>{!! $data['conference']->bahan->judul !!}</strong>
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
    <a href="{{ route('course.bahan', ['id' => $data['conference']->mata_id, 'bahanId' => $data['conference']->bahan_id,  'tipe' => 'conference']) }}" class="btn btn-secondary rounded-pill" title="kembali ke conference"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

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
                    <th>Masuk</th>
                    <th>Check In</th>
                    <th>Verifikasi</th>
                    <th>Keluar</th>
                    <th style="width: 90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['peserta']->total() == 0)
                <tr>
                    <td colspan="8" align="center">
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
                    <td>{{ $item->join->format('l, j F Y H:i A') }}</td>
                    <td>{{ !empty($item->check_in) ? $item->check_in->format('l, j F Y H:i A') : '-' }}</td>
                    <td>
                        @if ($item->check_in_verified == 0)
                            <span class="badge badge-warning">Belum Diverifikasi</span>
                        @else
                            <span class="badge badge-success">Sudah Diverifikasi</span>
                        @endif
                    </td>
                    <td>{{ !empty($item->leave) ? $item->leave->format('l, j F Y H:i A') : '-' }}</td>
                    <td>
                        @if ($item->check_in_verified == 0)
                        <a href="javascript:;" class="btn btn-success icon-btn btn-sm check" title="Klik untuk verifikasi peserta">
                            <i class="las la-check"></i>
                            <form action="{{ route('conference.peserta.check', ['id' => $item->conference_id, 'trackId' => $item->id, 'tipe' => 'detail'])}}" method="POST" id="form-check">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn btn-secondary icon-btn btn-sm" disabled><i class="las la-check"></i></button>
                        @endif
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //check
    $('.check').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: "Apakah anda yakin ?",
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: "Tidak, terima kasih",
        }).then((result) => {
        if (result.value) {
            $("#form-check").submit();
        }
        })
    });
</script>
@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
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
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="p">
                        <option value=" " selected>Semua</option>
                        @role('administrator|developer')
                        @foreach (config('addon.label.publish') as $key => $value)
                        {{-- <option value=""></option> --}}
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                        @endrole
                        @role('peserta_internal')
                        @foreach (config('addon.label.history_peserta') as $key => $value)
                        {{-- <option value=""></option> --}}
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                        @endrole
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Tanggal Berakhir Diklat</label>
                    <div class="input-daterange input-group datepicker">
                        <input type="text" class="form-control" name="f" value="{{ Request::get('f') }}">
                        <div class="input-group-append input-group-prepend">
                          <span class="input-group-text">sampai</span>
                        </div>
                        <input type="text" class="form-control" name="t" value="{{ Request::get('t') }}">
                    </div>
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
@foreach ($data['mata'] as $item)
{{-- {{dd($item->quiz)}} --}} 
    <div class="card mb-3">
        <div class="card-body">
            <div class="media align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="text-xlarge font-weight-bolder line-height-1 my-2">{{ $data['number']++ }}</div>
            </div>
            <div class="media-body ml-4">
                <a href="{{ route('course.detail', ['id' => $item->id]) }}" class="text-big">{!! $item->judul !!} <span class="badge badge-secondary">{{ $item->program->judul }}</span></a>
                <div class="my-2">
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal Mulai : <strong>{{ $item->publish_start->format('d F Y H:i') }}</strong> <em>s/d</em> <strong>{{ $item->publish_end->format('d F Y H:i') }}</strong>
                            <table class="table table-bordered mb-0" style="width: 200px;">
                                @role ('administrator|internal|mitra')
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
                                @endrole
                                {{-- <tr>
                                    <td style="text-align: center;">INSTRUKTUR <br> <strong>{{ $item->instruktur->count() }}</strong></td>
                                    <td style="text-align: center;">PESERTA <br> <strong>{{ $item->peserta->count() }}</strong></td>
                                    <td style="text-align: center;">TOPIK / MATA <br> <strong>{{ $item->materi->count() }}</strong></td>
                                </tr> --}}
                            </table>
                        </div>
                        <div class="col-md-8 text-right">
                            @role ('administrator|internal|mitra')
                            <a class="btn btn-success btn-sm icon-btn-only-sm mr-1" href="{{ route('materi.index', ['id' => $item->id]) }}" title="klik untuk melihat mata pelatihan">
                                <i class="las la-swatchbook"></i> <span>Mata</span>
                            </a>
                            @endrole
                            <a class="btn btn-info btn-sm icon-btn-only-sm mr-1" href="{{ route('course.detail', ['id' => $item->id]) }}" title="klik untuk melihat detail course">
                                <span>Detail</span> <i class="las la-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="small">
                    <span class="text-muted ml-3"><i class="las la-user text-lighter text-big align-middle"></i>&nbsp; {{ $item->creator->name }}</span>
                    {{-- <span class="text-muted ml-3"><i class="las la-book-open text-lighter text-big align-middle"></i>&nbsp; {{ $item->program->tipe == 0 ? 'BPPT' : 'Mitra' }}</span> --}}
                    <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->created_at->format('d/m/Y H:i') }}</span>
                    <span class="text-muted ml-3"><i class="las la-calendar text-lighter text-big align-middle"></i>&nbsp; {{ $item->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            </div>
        </div>
    </div>  


@endforeach

@if ($data['mata']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (Request::get('p') || Request::get('f') || Request::get('t') || Request::get('q'))
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
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    // Bootstrap Datepicker
    $(function() {
        var isRtl = $('html').attr('dir') === 'rtl';

        $('.datepicker').datepicker({
            orientation: isRtl ? 'auto right' : 'auto left',
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    });
</script>

@include('components.toastr')
@endsection

@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Form Sertifikat Internal
    </h6>
    <form action="{{ !isset($data['sertifikat']) ? route('sertifikat.internal.store', ['id' => $data['mata']->id]) : route('sertifikat.internal.update', ['id' => $data['mata']->id, 'sertifikatId' => $data['sertifikat']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['sertifikat']))
            @method('PUT')
        @endif
        <div class="card-body">
            @if (!isset($data['sertifikat']))
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tipe Sertifikat</label>
                </div>
                <div class="col-md-10">
                    <select id="tipe" class="custom-select form-control @error('tipe') is-invalid @enderror" name="tipe">
                        @foreach (config('addon.label.tipe_sertifikat') as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('tipe')
                        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                    @enderror
                </div>
            </div>
            @else
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Tipe Sertifikat</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{{ config('addon.label.tipe_sertifikat.'.$data['sertifikat']->tipe) }}" readonly>
                </div>
            </div>
            @endif
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nomor</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor"
                        value="{{ isset($data['sertifikat']) ? old('nomor', $data['sertifikat']->nomor) : old('nomor') }}" placeholder="masukan nomor..." autofocus>
                    <small><a href="javascript:;" data-toggle="modal" data-target="#modals-format"><em><i class="las la-info"></i> Format Penulisan</em></a></small>
                    @include('components.field-error', ['field' => 'nomor'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Tanggal Pengesahan</label>
                </div>
               <div class="col-md-10">
                 <input type="text" class="date-picker form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ isset($data['sertifikat']) ? old('tanggal', $data['sertifikat']->tanggal->format('Y-m-d')) : old('tanggal') }}" placeholder="masukan tanggal pengesahan...">
                 @include('components.field-error', ['field' => 'tanggal'])
               </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Nama Pimpinan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('nama_pimpinan') is-invalid @enderror" name="nama_pimpinan"
                    value="{{ isset($data['sertifikat']) ? old('nama_pimpinan', $data['sertifikat']->nama_pimpinan) : old('nama_pimpinan', __('sertifikat.nama_pimpinan')) }}" placeholder="masukan nama pimpinan...">
                  @include('components.field-error', ['field' => 'nama_pimpinan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Jabatan</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                    value="{{ isset($data['sertifikat']) ? old('jabatan', $data['sertifikat']->jabatan) : old('jabatan', __('sertifikat.jabatan')) }}" placeholder="masukan jabatan...">
                  @include('components.field-error', ['field' => 'jabatan'])
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">TTE (Tanda Tangan Elektronik)</label>
                </div>
                <div class="col-md-10">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-0"></label>
                        <input type="file" class="form-control custom-file-input file @error('tte') is-invalid @enderror" id="file-0" lang="en" name="tte" value="browse...">
                        @error('tte')
                            @include('components.field-error', ['field' => 'tte'])
                        @else
                        <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.photo.m')) }}</strong></small>
                        @enderror
                    </label>
                </div>
            </div> --}}
            @if (!isset($data['sertifikat']) || isset($data['sertifikat']) && $data['sertifikat']->tipe == 1)
            <div id="kerjasama">
                <hr>
                <h5>Kerjasama Mitra :</h5>
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                      <label class="col-form-label text-sm-right">Nama Perusahaan / Unit Kerja</label>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" name="unit_kerja"
                        value="{{ isset($data['sertifikat']) ? old('unit_kerja', $data['sertifikat']->unit_kerja) : old('unit_kerja') }}" placeholder="masukan unit kerja...">
                      @include('components.field-error', ['field' => 'unit_kerja'])
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                      <label class="col-form-label text-sm-right">Pejabat Terkait</label>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('pejabat_terkait') is-invalid @enderror" name="pejabat_terkait"
                        value="{{ isset($data['sertifikat']) ? old('pejabat_terkait', $data['sertifikat']->pejabat_terkait) : old('pejabat_terkait') }}" placeholder="masukan pejabat terkait...">
                      @include('components.field-error', ['field' => 'pejabat_terkait'])
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                      <label class="col-form-label text-sm-right">Nama Pejabat</label>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('nama_pejabat') is-invalid @enderror" name="nama_pejabat"
                        value="{{ isset($data['sertifikat']) ? old('nama_pejabat', $data['sertifikat']->nama_pejabat) : old('nama_pejabat') }}" placeholder="masukan nama pejabat...">
                      @include('components.field-error', ['field' => 'nama_pejabat'])
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('sertifikat.internal.peserta', ['id' => $data['mata']->id]) }}" class="btn btn-danger" title="klik untuk kembali ke list">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan">{{ isset($data['sertifikat']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal template -->
<div class="modal fade" id="modals-format">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                Format
                <span class="font-weight-light">Nomor Sertifikat</span>
                <br>
                </h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <em>Penulisan format nomor sertifikat :</em>
                <table class="table table-striped table-bordered mb-0 mt-2 mb-2">
                    <tr>
                        <th>Nomor</th>
                        <td><strong>{no}</strong></td>
                    </tr>
                    <tr>
                        <th>Bulan</th>
                        <td><strong>{bulan}</strong></td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td><strong>{tahun}</strong></td>
                    </tr>
                </table>
                Contoh : <strong><em>{no}/Teknis/DIKLAT/BPPT/{bulan}/{tahun}</em></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $( ".date-picker" ).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
</script>
@if (!isset($data['sertifikat']))
<script>
    $('#kerjasama').hide();
    $('#tipe').change(function(){
        if($('#tipe').val() == 1) {
            $('#kerjasama').show();
        } else {
            $('#kerjasama').hide();
        }
    });
</script>
@endif
@include('components.toastr')
@endsection

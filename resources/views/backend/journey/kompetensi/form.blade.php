@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/tmplts_backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<script src="{{ asset('assets/tmplts_backend/js/forms_selects.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <h6 class="card-header">
      Tambah Kompetensi
    </h6>
    <form action="{{ !isset($data['journeyK']) ? route('journeyKompetensi.store') : route('journeyKompetensi.update', ['id' => $data['journeyK']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($data['journeyK']))
            @method('PUT')
        @else
        <input type="hidden" name="journey_id" value="{{$data['journeyID']}}">
        @endif
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">Kompetensi</label>
                  </div>
                  <div class="col-md-10">
                    <div class="select2-primary">
                    <select required class="form-control @error('kompetensi_id') is-invalid @enderror" name="kompetensi_id" data-style="btn-default">
                        <option disabled>Pilih Kompetensi</option>
                        @foreach ($data['kompetensi'] as $k)
                            <option value="{{ $k->id }}" @if(isset($data['journeyK']) && $k->id == $data['journeyK']['kompetensi_id']) selected @endif> {{ ucwords($k->judul) }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
            </div>


            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Poin Minimal</label>
                </div>
                <div class="col-md-10">
                  <input type="number" class="form-control @error('minimal_poin') is-invalid @enderror" name="minimal_poin" id="" value="{{@$data['journeyK']->minimal_poin}}">
                    @include('components.field-error', ['field' => 'minimal_poin'])
                </div>
            </div>



            {{-- @include('components.selectKompetensi',['kompetensi' => $data['kompetensi']]) --}}
            <hr>


        </div>
        <div class="card-footer">
            <div class="row">
              <div class="col-md-10 ml-sm-auto text-md-left text-right">
                <a href="{{ route('journey.index') }}" class="btn btn-danger" title="klik untuk kembali ke list" data-toggle="tooltip">Kembali</a>
                <button type="submit" class="btn btn-primary" name="action" value="save" title="klik untuk menyimpan" data-toggle="tooltip">{{ isset($data['journeyK']) ? 'Simpan perubahan' : 'Simpan' }}</button>
              </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection



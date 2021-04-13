@foreach ($data['peserta'] as $item)
<!-- Modal template -->
<div class="modal fade" id="modals-nilai-form-{{ $item->id }}">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('tugas.penilaian', ['id' => $item->tugas_id, 'responId' => $item->id]) }}" method="POST" id="form-nilai">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">
            Penilaian
            <span class="font-weight-light">TUGAS</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Nilai</label>
                    <input type="number" class="form-control @error('nilai') is-invalid @enderror" max="100" name="nilai" id="nilai" value="{{ $item->nilai }}" placeholder="Masukan nilai">
                    @include('components.field-error', ['field' => 'nilai'])
                    <i>*<span class="text-muted">Input range <span class="badge badge-danger">10</span> - <span class="badge badge-success">100</span></span></i>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Komentar</label>
                    <textarea class="form-control tiny @error('komentar') is-invalid @enderror" id="komentar" name="komentar" placeholder="Masukan komentar...">{!! $item->komentar !!}</textarea>
                    @include('components.field-error', ['field' => 'komentar'])
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
</div>
@endforeach

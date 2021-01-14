<!-- Modal template -->
<div class="modal fade" id="modals-soal">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="{{ route('template.quiz.item.input', ['id' => $data['quiz']->id]) }}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
            Tambah
            <span class="font-weight-light">Soal ke quiz</span>
            <br>
            </h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body" style="max-height: 600px; min-height: 600px; overflow-y: scroll; background-color: #f9f9f9;">

            Pilih soal dari bank soal untuk dijadikan soal quiz : <br><br>

            <div class="form-row">
                <div class="form-group col">
                    <label class="form-label">Kategori</label>
                    <select id="kategori" class="select2 show-tick" name="kategori_id" data-style="btn-default">
                        <option value=" " selected disabled>Pilih</option>
                        <option value="0">Semua Soal</option>
                        @foreach ($data['soal_kategori'] as $kategori)
                            <option value="{{ $kategori->id }}"> {{ $kategori->judul }} ({{ $kategori->soal->count() }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row" id="form-random">
                <div class="form-group col">
                    <label class="form-label">Soal Random (Acak)</label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="random-soal" name="random" value="1">
                        <span class="custom-control-label ml-4">Ya</span>
                    </label>
                </div>
            </div>
            <div class="form-row" id="form-jml">
                <div class="form-group col">
                    <label class="form-label">Jumlah Soal (Acak)</label>
                    <input type="number" class="form-control @error('jml_soal') is-invalid @enderror" name="jml_soal" value="{{ old('jml_soal') }}" placeholder="Masukan jumlah soal">
                    @include('components.field-error', ['field' => 'jml_soal'])
                </div>
            </div>
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input parent" name="parent">
                                <span class="custom-control-label"></span>
                            </label>
                        </th>
                        <th>Judul</th>
                    </tr>
                </thead>
                <tbody id="soal">
                    <tr>
                        <td colspan="3" class="text-center">
                            <i>
                                <strong style="color:red;">
                                ! Pilih kategori terlebih dahulu !
                                </strong>
                            </i>
                        </td>
                    </tr>
                    {{-- @if ($data['soal']->count() == 0)
                        <tr>
                            <td colspan="3" class="text-center">
                                <i>
                                    <strong style="color:red;">
                                    ! Data Soal kosong !
                                    </strong>
                                </i>
                            </td>
                        </tr>
                    @endif
                    @foreach ($data['soal'] as $soal)
                    <tr>
                        <td>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input child" name="soal_id[]" value="{{ $soal->id }}">
                                <span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>{!! strip_tags($soal->pertanyaan) !!}</td>
                        <td><span class="badge badge-success">{{ $soal->kategori->judul }}</span></td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah soal ke quiz</button>
        </div>
        </form>
    </div>
</div>

<script>
    $('#form-jml').hide();
    $('#random-soal').on('change', function() {
        if ($('#random-soal').val() == 1) {
            $('#form-jml').toggle('slow');
        } else {
            $('#form-jml').hide();
        }
    });
    $(".parent").click(function () {
       $('.child').not(this).prop('checked', this.checked);
    });
</script>

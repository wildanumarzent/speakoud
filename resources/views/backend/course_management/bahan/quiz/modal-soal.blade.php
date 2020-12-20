<!-- Modal template -->
<div class="modal fade" id="modals-soal">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="{{ route('quiz.item.input', ['id' => $data['quiz']->id]) }}" method="POST">
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

            Pilih soal dari bank soal untuk dijadikan soal quiz : <br>
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input parent" name="parent">
                                <span class="custom-control-label"></span>
                            </label>
                        </th>
                        <th>Judul</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data['soal']->count() == 0)
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
                    @endforeach
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
    $(".parent").click(function () {
       $('.child').not(this).prop('checked', this.checked);
   });
</script>

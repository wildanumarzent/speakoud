@foreach ($data['peserta'] as $item)
<div class="modal fade" id="modals-dokumen-{{ $item->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Dokumen Tugas
            <span class="font-weight-light">" {{ $item->user->name }} "</span>
            <br>
            {{-- <small class="text-muted">We need payment information to process your order.</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="row no-gutters">
                @foreach ($item->files($item->bank_data_id) as $key => $file)
                <div class="col-md-6 col-lg-12 col-xl-6 p-1">
                    <div class="project-attachment ui-bordered p-2">
                        <div class="project-attachment-file display-4">
                        <i class="las la-file"></i>
                        </div>
                        <div class="media-body ml-3">
                        <strong class="project-attachment-filename">{{ collect(explode("/", $file->file_path))->last() }}</strong>
                        <div class="text-muted small"></div>
                            <div>
                                <a href="{{ route('bank.data.stream', ['path' => $file->file_path]) }}">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutp</button>
        </div>
      </div>
    </div>
</div>
@endforeach

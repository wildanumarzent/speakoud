<!-- Modal template -->
<div class="modal fade" id="modals-tipe-bahan">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                Pilih Tipe
                <span class="font-weight-light">Materi Pembelajaran</span>
                <br>
                </h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                @foreach (config('addon.label.bahan_tipe') as $key => $value)
                    {{-- @if ($value['get'] != 'evaluasi-pengajar')
                    <a href="{{ route('bahan.create', ['id' => $data['materi']->id, 'type' => $value['get']]) }}" class="media text-body px-3" title="tambah bahan dengan tipe {{ $value['title'] }}">
                        <div class="box-materi py-3">
                            <div class="dot-circle"></div>
                            <div class="media-body ml-3">
                            <h6 class="mb-1"><i class="las la-{{ $value['icon'] }} mr-2" style="font-size: 2em;"></i> {{ $value['title'] }}</h6>
                            <div class="text-muted small">{{ $value['description'] }}</div>
                            </div>
                        </div>
                    </a> --}}
                    @if (!empty($value['child']))
                        @foreach ($value['child'] as $keyT => $valT)
                        <a href="{{ route('bahan.create', ['id' => $data['materi']->id, 'type' => $valT['get'], 'kategori' => $valT['kategori']]) }}" class="media text-body px-3" title="tambah bahan tipe quiz dengan kategori {{ $valT['title'] }}">
                            <div class="box-materi py-3">
                                <div class="dot-circle"></div>
                                <div class="media-body ml-3">
                                <h6 class="mb-1"><i class="las la-{{ $valT['icon'] }} mr-2" style="font-size: 2em;"></i><em>{{ $valT['title'] }}</em></h6>
                                <div class="text-muted small"></div>
                                </div>
                            </div>
                        </a>
                        @endforeach

                        @else 
                          @role ('administrator|internal')
                        <a href="{{ route('bahan.create', ['id' => $data['materi']->id, 'type' => $value['get']]) }}" class="media text-body px-3" title="create bahan dengan tipe forum">
                            <div class="box-materi py-3">
                                <div class="dot-circle"></div>
                                <div class="media-body ml-3">
                                <h6 class="mb-1"><i class="las la-{{ $value['icon'] }} mr-2" style="font-size: 2em;"></i> {{ $value['title'] }}</h6>
                                <div class="text-muted small">{{ $value['description'] }}</div>
                                </div>
                            </div>
                        </a>
                        @endrole
                    @endif
                    {{-- @else --}}
                      
                    {{-- @endif --}}
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

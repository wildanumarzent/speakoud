<div class="table-responsive table-mobile-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Intro</th>
                <th>Publish</th>
                <th>Viewer</th>
                <th style="width: 200px;">Created</th>
                <th style="width: 200px;">Updated</th>
                <th style="width: 110px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($data['artikel']->total() == 0)
            <tr>
                <td colspan="11" align="center">
                    <i>
                        <strong style="color:red;">
                        @if (Request::get('q'))
                        ! User artikel tidak ditemukan !
                        @else
                        ! Data User artikel kosong !
                        @endif
                        </strong>
                    </i>
                </td>
            </tr>
            @endif
            @foreach ($data['artikel'] as $item)
            <tr>
                <td>{{ $data['number']++ }}</td>
                <td>{{ $item->title ?? '-' }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->intro ?? '-' }}</td>
                <td>{{ $item->publish ?? '-' }}</td>
                <td>{{ $item->viewer ?? '-' }}</td>
                <td>{{ $item->alamat ?? '-' }}</td>
                <td>
                    <span class="badge badge-outline-primary">{{ strtoupper(str_replace('_', ' ', $item->user->roles[0]->name)) }}</span>
                </td>
                <td>
                    {{ $item->created_at->format('d F Y - (H:i)') }}
                </td>
                <td>
                    {{ $item->updated_at->format('d F Y - (H:i)') }}
                </td>
                <td>
                    <a href="{{ route('artikel.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit artikel" data-toggle="tooltip">
                            <i class="las la-pen"></i>
                    </a>
                    <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus artikel" data-toggle="tooltip">
                        <i class="las la-trash-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tbody class="tbody-responsive">
            @if ($data['artikel']->total() == 0)
            <tr>
                <td colspan="10" align="center">
                    <i>
                        <strong style="color:red;">
                        @if (Request::get('q'))
                        ! User artikel tidak ditemukan !
                        @else
                        ! Data User artikel kosong !
                        @endif
                        </strong>
                    </i>
                </td>
            </tr>
            @endif
            @foreach ($data['artikel'] as $item)
            <tr>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <div class="item-table">
                                <div class="data-table">NIP</div>
                                <div class="desc-table">{{ $item->nip ?? '-' }}</div>
                            </div>
                            <div class="item-table">
                                <div class="data-table">Nama</div>
                                <div class="desc-table">{{ $item->user->name }}</div>
                            </div>
                            <div class="item-table">
                                <div class="data-table">Unit Kerja</div>
                                <div class="desc-table">{{ $item->unit_kerja ?? '-' }}</div>
                            </div>
                            <div class="item-table">
                                <div class="data-table">Kedeputian</div>
                                <div class="desc-table">{{ $item->kedeputian ?? '-' }}</div>
                            </div>
                            <div class="item-table">
                                <div class="data-table">Pangkat</div>
                                <div class="desc-table">{{ $item->pangkat ?? '-' }}</div>
                            </div>
                            <div class="item-table">
                                <div class="data-table">Alamat</div>
                                <div class="desc-table">{{ $item->alamat ?? '-' }}</div>
                            </div>

                            <div class="item-table m-0">
                                <div class="desc-table text-right">
                                    <a href="{{ route('artikel.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit artikel" data-toggle="tooltip">
                                            <i class="las la-pen"></i>
                                    </a>
                                    <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm js-sa2-delete" title="klik untuk menghapus artikel" data-toggle="tooltip">
                                        <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        <tbody>
    </table>
</div>
<div class="card-footer">
    <div class="row align-items-center">
        <div class="col-lg-6 m--valign-middle">
            Menampilkan : <strong>{{ $data['artikel']->firstItem() }}</strong> - <strong>{{ $data['artikel']->lastItem() }}</strong> dari
            <strong>{{ $data['artikel']->total() }}</strong>
        </div>
        <div class="col-lg-6 m--align-right">
            {{ $data['artikel']->onEachSide(1)->links() }}
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
$(document).ready(function () {
$('.js-sa2-delete').on('click', function () {
    var id = $(this).attr('data-id');
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda akan menghapus artikel ini, data yang bersangkutan dengan artikel ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
        type: "warning",
        confirmButtonText: "Ya, hapus!",
        customClass: {
            confirmButton: "btn btn-danger btn-lg",
            cancelButton: "btn btn-info btn-lg"
        },
        showLoaderOnConfirm: true,
        showCancelButton: true,
        allowOutsideClick: () => !Swal.isLoading(),
        cancelButtonText: "Tidak, terima kasih",
        preConfirm: () => {
            return $.ajax({
                url: "/artikel/" + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json'
            }).then(response => {
                if (!response.success) {
                    return new Error(response.message);
                }
                return response;
            }).catch(error => {
                swal({
                    type: 'error',
                    text: 'Error while deleting data. Error Message: ' + error
                })
            });
        }
    }).then(response => {
        if (response.value.success) {
            Swal.fire({
                type: 'success',
                text: 'User artikel berhasil dihapus'
            }).then(() => {
                window.location.reload();
            })
        } else {
            Swal.fire({
                type: 'error',
                text: response.value.message
            }).then(() => {
                window.location.reload();
            })
        }
    });
})
});
</script>

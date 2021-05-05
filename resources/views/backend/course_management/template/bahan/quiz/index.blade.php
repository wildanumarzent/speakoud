@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.css') }}">
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
                        <label class="form-label">Limit</label>
                        <select class="limit custom-select" name="l">
                            <option value="20" selected>Any</option>
                            @foreach (config('custom.filtering.limit') as $key => $val)
                            <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="Limit {{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Tipe</label>
                    <select class="status custom-select form-control" name="t">
                        <option value=" " selected>Semua</option>
                        @foreach (config('addon.label.quiz_item_tipe') as $key => $tipe)
                        <option value="{{ $key }}" {{ Request::get('t') == ''.$key.'' ? 'selected' : '' }}>{{ $tipe['title'] }}</option>
                        @endforeach
                    </select>
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

<div class="text-left">
    <a href="{{ route('template.bahan.index', ['id' => $data['quiz']->template_materi_id]) }}" class="btn btn-secondary rounded-pill" title="kembali ke list template materi"><i class="las la-arrow-left"></i>Kembali</a>
</div>
<br>

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">Soal List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('template.soal.kategori', ['id' => $data['quiz']->template_mata_id]) }}" class="btn btn-success icon-btn-only-sm" title="manage template soal">
                <i class="las la-spell-check"></i><span>Bank Soal</span>
            </a>
            <button type="button" class="btn btn-primary icon-btn-only-sm" data-toggle="modal" data-target="#modals-soal" title="pilih soal dari bank data">
                <i class="las la-list-alt"></i><span>Pilih Soal</span>
            </button>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Tipe Soal</th>
                    <th style="width: 200px;">Creator</th>
                    <th style="width: 200px;">Created</th>
                    <th style="width: 200px;">Updated</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['quiz_item']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! Soal tidak ditemukan !
                            @else
                            ! Data Soal kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['quiz_item'] as $item)
                <tr>
                    <td>{{ $data['number']++ }}</td>
                    <td>{!! Str::limit(strip_tags($item->pertanyaan), 180) !!}</td>
                    <td><span class="badge badge-outline-primary">{{ config('addon.label.quiz_item_tipe.'.$item->tipe_jawaban)['title'] }}</span></td>
                    <td>{{ $item->creator['name'] }}</td>
                    <td>{{ $item->created_at->format('d F Y - (H:i)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y - (H:i)') }}</td>
                    <td>
                        <a href="{{ route('template.quiz.item.edit', ['id' => $item->template_quiz_id, 'itemId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit template soal" data-toggle="tooltip">
                                <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-quizid="{{ $item->template_quiz_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus template soal" data-toggle="tooltip">
                            <i class="las la-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['quiz_item']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! Soal tidak ditemukan !
                            @else
                            ! Data Soal kosong !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['quiz_item'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Pertanyaan</div>
                                    <div class="desc-table">{!! Str::limit(strip_tags($item->pertanyaan), 180) !!}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Tipe Soal</div>
                                    <div class="desc-table"><span class="badge badge-outline-primary">{{ config('addon.label.quiz_item_tipe.'.$item->tipe_jawaban)['title'] }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Creator</div>
                                    <div class="desc-table">{{ $item->creator['name'] }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Created</div>
                                    <div class="desc-table">{{ $item->created_at->format('d F Y - (H:i)') }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Updated</div>
                                    <div class="desc-table">{{ $item->updated_at->format('d F Y - (H:i)') }}</div>
                                </div>

                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('template.quiz.item.edit', ['id' => $item->template_quiz_id, 'itemId' => $item->id]) }}" class="btn icon-btn btn-info btn-sm" title="klik untuk mengedit template soal" data-toggle="tooltip">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-quizid="{{ $item->template_quiz_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-danger btn-sm swal-delete" title="klik untuk menghapus template soal" data-toggle="tooltip">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Menampilkan : <strong>{{ $data['quiz_item']->firstItem() }}</strong> - <strong>{{ $data['quiz_item']->lastItem() }}</strong> dari
                <strong>{{ $data['quiz_item']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['quiz_item']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.course_management.template.bahan.quiz.modal-soal')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //select 2
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('#modals-soal')
    });
    function stripHtml(html){
        var temporalDivElement = document.createElement("div");
        temporalDivElement.innerHTML = html;
        return temporalDivElement.textContent || temporalDivElement.innerText || "";
    }
    $('#form-random').hide();
    $('#kategori').change(function() {
        var id = $(this).val();
        if (id >= 0) {
            $('#form-random').toggle('slow');
        }
        if (id) {
            $.ajax({
                type : "GET",
                url : "/template/mata/{{ $data['quiz']->template_mata_id }}/soal/kategori/json/{{ $data['quiz']->id }}?kategori_id=" + id,
                success : function(cat) {
                    if(cat){
                        $("#soal").empty();
                        if (cat.length == 0) {
                            $("#soal").append(`
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <i>
                                            <strong style="color:red;">
                                            ! Soal kosong !
                                            </strong>
                                        </i>
                                    </td>
                                </tr>
                            `);
                        } else {
                            $.each(cat, function(key, value){
                                $("#soal").append(`
                                <tr>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input child" name="soal_id[]" value="`+key+`">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>`+stripHtml(value)+`</td>
                                </tr>
                                `);
                            });
                        }

                    } else {
                        $("#soal").append(`
                            <tr>
                                <td colspan="2" class="text-center">
                                    <i>
                                        <strong style="color:red;">
                                        ! Soal tidak ditemukan !
                                        </strong>
                                    </i>
                                </td>
                            </tr>
                        `);
                    }
                },
            });
        }
    });

    //delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var quiz_id = $(this).attr('data-quizid');
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus template soal ini, data yang bersangkutan dengan template soal ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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
                        url: "/template/quiz/" + quiz_id + '/item/' + id,
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
                        text: 'template soal berhasil dihapus'
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

@include('components.toastr')
@endsection

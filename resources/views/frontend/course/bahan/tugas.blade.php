@extends('frontend.course.bahan')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/nestable/nestable.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/jstree/themes/default/style.css') }}">
<style>
    #nestable2 .dd-handle {
      background: #f6f6f6;
      padding: .625rem 1.25rem;
    }

    #nestable2 button[data-action] {
      margin-top: .625rem;
    }

    html:not([dir=rtl]) body:not([dir=rtl]) #nestable2 button[data-action]~.dd-handle {
      padding-left: 2rem;
    }

    [dir=rtl] #nestable2 button[data-action]~.dd-handle {
      padding-right: 2rem;
    }

    /* Custom drag handle */

    .dd-custom-drag-handle .dd-handle {
      border: 0;
      float: left;
      margin: 1px;
      font-size: .625rem;
      line-height: 1.25rem;
    }

    .dd-custom-drag-handle .dd-handle>* {
      vertical-align: middle;
    }

    [dir=rtl] .dd-custom-drag-handle .dd-handle {
      float: right;
    }
</style>
@endsection

@section('content-view')
<div class="card-datatable table-responsive d-flex justify-content-center mb-4">
    <table class="table table-striped table-bordered mb-0">
        <tr>
            <th style="width: 150px;">Tanggal Mulai Pengumpulan</th>
            <td>{{ !empty($data['bahan']->tugas->tanggal_mulai) ? $data['bahan']->tugas->tanggal_mulai->format('d F Y H:i') : 'Tidak dibatasi' }}</td>
       </tr>
        <tr>
             <th style="width: 150px;">Batas Pengumpulan</th>
             <td>{{ !empty($data['bahan']->tugas->tanggal_selesai) ? $data['bahan']->tugas->tanggal_selesai->format('d F Y H:i') : 'Tidak dibatasi' }}</td>
        </tr>
       <tr>
            <th style="width: 150px;">Dokumen Tugas</th>
            <td>
                Silahkan klik dokumen dibawah untuk mengunduh tugas yang diberikan. Selamat mengerjakan!
                <div style="margin-top:20px;min-height:200px;border:1px solid #ddd;padding:20px;">
                    <ol>
                        @foreach ($data['bahan']->tugas->files($data['bahan']->tugas->bank_data_id) as $key => $file)
                        <li><i class="las la-file" style="font-size:1.2em;"></i> <a href="{{ route('bank.data.stream', ['path' => $file->file_path]) }}">{{ collect(explode("/", $file->file_path))->last() }}</a></li>
                        @endforeach
                    </ol>
                </div>
            </td>
        </tr>
        @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
        <tr>
            <th style="width: 150px;">Peserta</th>
            <td>
                <a href="{{ route('tugas.peserta', ['id' => $data['bahan']->tugas->id]) }}" class="btn btn-info icon-btn-only-sm btn-sm" title="klik untuk melihat peserta">
                    <i class="las la-users"></i><span> Lihat</span>
                </a>
            </td>
        </tr>
        @endif
        @if (auth()->user()->hasRole('peserta_internal|peserta_mitra'))
            @if ($data['bahan']->tugas->approval == 0 && empty($data['bahan']->tugas->responByUser))
            <tr>
                <th colspan="2">
                    Klik tombol dibawah untuk mengirim hasil tugas!
                    <button type="button" class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modals-upload-file"><i class="las la-upload"></i> Upload Tugas</button>
                </th>
            </tr>
            @endif
            @if ($data['bahan']->tugas->approval == 1 && empty($data['bahan']->tugas->responByUser) || $data['bahan']->tugas->approval == 1 && !empty($data['bahan']->tugas->responByUser) && $data['bahan']->tugas->responByUser->approval == '0')
            <tr>
                <th colspan="2">
                    Klik tombol dibawah untuk mengirim hasil tugas!
                    <button type="button" class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modals-upload-file"><i class="las la-upload"></i> Upload Tugas</button>
                </th>
            </tr>
            @endif
        @endif
    </table>
</div>

@if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && !empty($data['bahan']->tugas->responByUser))
<hr>
<h5>Tugas Saya</h5>
@if ($data['bahan']->tugas->responByUser->approval == '0')
<p><em>*Mohon untuk upload ulang tugas</em></p>
@endif
<div class="card-datatable table-responsive d-flex justify-content-center mb-4">
    <table class="table table-striped table-bordered mb-0">
        <tr>
            <th style="width: 200px;">Tanggal Pengumpulan</th>
            <td>
                <span class="badge badge-{{ $data['bahan']->tugas->responByUser->telat == 0 ? 'success' : 'danger' }}">
                    {{ $data['bahan']->tugas->responByUser->created_at->format('d F Y H:i') }}
                </span>
                @if ($data['bahan']->tugas->responByUser->telat == 1)
                    <i>(Pengumpulan Telat)</i>
                @endif
            </td>
       </tr>
       <tr>
            <th style="width: 200px;">Keterangan</th>
            <td>{{ $data['bahan']->tugas->responByUser->keterangan ?? '-' }}</td>
       </tr>
       @if ($data['bahan']->tugas->approval == 1)
       <tr>
            <th style="width: 200px;">Approval</th>
            <td>
                @if ($data['bahan']->tugas->responByUser->approval == '0')
                    <span class="badge badge-danger">Di Tolak</span>
                @elseif ($data['bahan']->tugas->responByUser->approval == '1')
                    <span class="badge badge-success">Di Approve</span>
                @else
                    <span class="badge badge-secondary">Belum di Approve</span>
                @endif
            </td>
        </tr>
        @if ($data['bahan']->tugas->responByUser->approval >= '0')
        <tr>
            <th style="width: 200px;">Di Approve / Tolak Oleh</th>
            <td>{{ $data['bahan']->tugas->responByUser->approvedBy->name }}</td>
        </tr>
        @endif
        @if ($data['bahan']->tugas->responByUser->approval == '1')
        <tr>
            <th style="width: 200px;">Tanggal di Approve</th>
            <td>{{ $data['bahan']->tugas->responByUser->approval_time->format('d F Y H:i') }}</td>
        </tr>
        @endif
       @endif
        <tr>
            <th style="width: 150px;">Dokumen Tugas</th>
            <td>
                <div style="margin-top:20px;min-height:200px;border:1px solid #ddd;padding:20px;">
                    <ol>
                        @foreach ($data['bahan']->tugas->responByUser->files($data['bahan']->tugas->responByUser->bank_data_id) as $key => $file)
                        <li><i class="las la-file" style="font-size:1.2em;"></i> <a href="{{ route('bank.data.stream', ['path' => $file->file_path]) }}">{{ collect(explode("/", $file->file_path))->last() }}</a></li>
                        @endforeach
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
            <th style="width: 200px;">Nilai</th>
            <td>
                @if (empty($data['bahan']->tugas->responByUser->nilai))
                    <i>Belum ada penilaian</i>
                @else
                    <span class="badge badge-primary">{{ $data['bahan']->tugas->responByUser->nilai }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <th style="width: 200px;">Komentar</th>
            <td>{!! $data['bahan']->tugas->responByUser->komentar ?? '-' !!}</td>
        </tr>
    </table>
</div>
@endif

@include('frontend.course.tugas.modal-upload')
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/nestable/nestable.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/jstree/jstree.js') }}"></script>
@endsection

@section('body')
<script>
    $('.jstree').jstree();

    $(function()  {
        var no = 1;
        $("#add").click(function() {
            $("#list").append(`
            <div class="form-group row num-list" id="delete-`+no+`">
                <div class="col-md-11">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-`+no+`"></label>
                        <input type="file" class="form-control custom-file-input file @error('files.`+no+`') is-invalid @enderror" id="file-`+no+`" lang="en" name="files[]" value="browse...">
                    </label>
                </div>
                <div class="col-md-1">
                    <button type="button" id="remove" data-id="`+no+`" class="btn btn-danger btn-sm icon-btn"><i class="las la-times"></i></button>
                </div>
            </div>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = 19;
            if (noOfColumns < maxNum) {
                $("#add-files").show();
            } else {
                $("#add-files").hide();
            }

            // FILE BROWSE
            function callfileBrowser() {
                $(".custom-file-input").on("change", function() {
                    const fileName = Array.from(this.files).map((value, index) => {
                        if (this.files.length == index + 1) {
                            return value.name
                        } else {
                            return value.name + ', '
                        }
                    });
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            }
            callfileBrowser();

            no++;
        });
    });

    $(document).on('click', '#remove', function() {
        var id = $(this).attr("data-id");
        $("#delete-"+id).remove();
    });
</script>
@endsection

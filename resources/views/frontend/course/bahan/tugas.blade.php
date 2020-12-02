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
            <th style="width: 150px;">Batas Pengumpulan</th>
            <td>{{ $data['bahan']->publish_end->format('d F Y H:i') }}</td>
       </tr>
       <tr>
            <th style="width: 150px;">Dokumen Tugas</th>
            <td>
                Silahkan klik dokumen dibawah untuk mengunduh tugas yang diberikan. Selamat mengerjakan!
                <div class="jstree" style="margin-top:20px;min-height:200px;border:1px solid #ddd;padding:20px;">
                    <ul>
                      <li>Dokumen
                        <ul>
                          @foreach ($data['bahan']->tugas->files as $key => $file)
                          <li data-jstree="{&quot;icon&quot; : &quot;jstree-file&quot;}"><a href="{{ route('bank.data.stream', ['path' => $file]) }}">{{ collect(explode("/", $file))->last() }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                    </ul>
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
        @if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['bahan']->tugas->responByUser))
        <tr>
            <th colspan="2">
                Klik tombol dibawah untuk mengirim hasil tugas!
                <button type="button" class="btn btn-primary btn-block mt-2" id="upload"><i class="las la-upload"></i> Upload Tugas</button>
            </th>
        </tr>
        @endif
    </table>
</div>
@if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && empty($data['bahan']->tugas->responByUser))
<div class="card-body" style="border: 1px solid #e8e8e9; border-radius: .75rem;" id="form-upload">
    <form action="{{ route('tugas.send', ['id' => $data['bahan']->tugas->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="list">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">Keterangan</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="masukan deskripsi..."></textarea>
                    @include('components.field-error', ['field' => 'keterangan'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label">Files</label>
                </div>
                <div class="col-md-9">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-0"></label>
                        <input type="file" class="form-control custom-file-input file @error('files.0') is-invalid @enderror" id="file-0" lang="en" name="files[]" value="browse...">
                        @error('files.0')
                            @include('components.field-error', ['field' => 'files.0'])
                        @else
                        <small class="text-danger">Tipe File : <strong>{{ strtoupper(config('addon.mimes.tugas.m')) }}</strong></small>
                        @enderror
                    </label>
                </div>
                <div class="col-md-1" id="add-files">
                    <button type="button" id="add" class="btn btn-success icon-btn"><i class="las la-plus"></i></button>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="col-md-10 ml-sm-auto text-md-left text-right">
            <button type="submit" class="btn btn-primary" title="klik untuk mengirim" data-toggle="tooltip">Kirim</button>
        </div>
    </form>
</div>
@endif
@if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && !empty($data['bahan']->tugas->responByUser))
<hr>
<h5>Tugas Saya</h5>
<div class="card-datatable table-responsive d-flex justify-content-center mb-4">
    <table class="table table-striped table-bordered mb-0">
        <tr>
            <th style="width: 200px;">Tanggal Pengumpulan</th>
            <td>{{ $data['bahan']->tugas->responByUser->created_at->format('d F Y H:i') }}</td>
       </tr>
       <tr>
            <th style="width: 200px;">Keterangan</th>
            <td>{{ $data['bahan']->tugas->responByUser->keterangan }}</td>
       </tr>
       <tr>
        <th style="width: 150px;">Dokumen Tugas</th>
        <td>
            <div class="jstree" style="margin-top:20px;min-height:200px;border:1px solid #ddd;padding:20px;">
                <ul>
                  <li>Dokumen
                    <ul>
                      @foreach ($data['bahan']->tugas->responByUser->files as $key => $file)
                      <li data-jstree="{&quot;icon&quot; : &quot;jstree-file&quot;}"><a href="{{ route('bank.data.stream', ['path' => $file]) }}">{{ collect(explode("/", $file))->last() }}</a></li>
                      @endforeach
                    </ul>
                  </li>
                </ul>
            </div>
        </td>
    </tr>
    </table>
</div>
@endif
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/nestable/nestable.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/jstree/jstree.js') }}"></script>
@endsection

@section('body')
<script>
    $('.jstree').jstree();

    $("#form-upload").hide();
    $( "#upload" ).click(function() {
        $("#form-upload").toggle('slow');
    });

    $(function()  {
        var no = 1;
        $("#add").click(function() {
            $("#list").append(`
            <div class="form-group row num-list" id="delete-`+no+`">
                <div class="col-md-2 text-md-right">
                    <label class="col-form-label"></label>
                </div>
                <div class="col-md-9">
                    <label class="custom-file mt-2">
                        <label class="custom-file-label mt-2" for="file-`+no+`"></label>
                        <input type="file" class="form-control custom-file-input file @error('files.`+no+`') is-invalid @enderror" id="file-`+no+`" lang="en" name="files[]" value="browse...">
                    </label>
                </div>
                <div class="col-md-1">
                    <button type="button" id="remove" data-id="`+no+`" class="btn btn-danger icon-btn"><i class="las la-times"></i></button>
                </div>
            </div>
            `);

            // var noOfColumns = $('.num-list').length;
            // var maxNum = 2;
            // if (noOfColumns < maxNum) {
            //     $("#add-files").show();
            // } else {
            //     $("#add-files").hide();
            // }

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

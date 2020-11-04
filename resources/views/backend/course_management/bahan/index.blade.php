@extends('layouts.backend.layout')

@section('styles')
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
                    <label class="form-label">Status</label>
                    <select class="status custom-select form-control" name="p">
                        <option value=" " selected>Semua</option>
                        <option value="1" {{ Request::get('p') == '1' ? 'selected' : '' }}>PUBLISH</option>
                        <option value="0" {{ Request::get('p') == '0' ? 'selected' : '' }}>DRAFT</option>
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
<div class="d-flex justify-content-between">
    <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#modals-tipe-bahan" title="klik untuk menambah bahan pelatihan"><i class="las la-plus"></i>Tambah</button>
</div>
<br>

@include('backend.course_management.bahan.tipe-bahan')
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/tmplts_backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/tmplts_backend/js/ui_modals.js') }}"></script>
<script>
    //sort
    // $(function () {
    //     $(".drag").sortable({
    //         connectWith: '.drag',
    //         update : function (event, ui) {
    //             var data  = $(this).sortable('toArray');
    //             var id = '{{ $data['materi']->id }}';
    //             // console.log(data);
    //             $.ajax({
    //                 data: {'datas' : data},
    //                 url: '/mata/'+ id +'/materi/sort',
    //                 type: 'POST',
    //                 dataType:'json',
    //             });
    //             if (data) {
    //                 location.reload();
    //             }
    //         }
    //     });
    //     $( "#drag" ).disableSelection();
    // });
    //delete
    // $(document).ready(function () {
    //     $('.js-sa2-delete').on('click', function () {
    //         var mata_id = $(this).attr('data-mataid');
    //         var id = $(this).attr('data-id');
    //         Swal.fire({
    //             title: "Apakah anda yakin?",
    //             text: "Anda akan menghapus materi pelatihan ini, data yang bersangkutan dengan materi pelatihan ini akan terhapus. Data yang sudah dihapus tidak dapat dikembalikan!",
    //             type: "warning",
    //             confirmButtonText: "Ya, hapus!",
    //             customClass: {
    //                 confirmButton: "btn btn-danger btn-lg",
    //                 cancelButton: "btn btn-info btn-lg"
    //             },
    //             showLoaderOnConfirm: true,
    //             showCancelButton: true,
    //             allowOutsideClick: () => !Swal.isLoading(),
    //             cancelButtonText: "Tidak, terima kasih",
    //             preConfirm: () => {
    //                 return $.ajax({
    //                     url: "/mata/" + mata_id + '/materi/' + id,
    //                     method: 'DELETE',
    //                     headers: {
    //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                     },
    //                     dataType: 'json'
    //                 }).then(response => {
    //                     if (!response.success) {
    //                         return new Error(response.message);
    //                     }
    //                     return response;
    //                 }).catch(error => {
    //                     swal({
    //                         type: 'error',
    //                         text: 'Error while deleting data. Error Message: ' + error
    //                     })
    //                 });
    //             }
    //         }).then(response => {
    //             if (response.value.success) {
    //                 Swal.fire({
    //                     type: 'success',
    //                     text: 'materi pelatihan berhasil dihapus'
    //                 }).then(() => {
    //                     window.location.reload();
    //                 })
    //             } else {
    //                 Swal.fire({
    //                     type: 'error',
    //                     text: response.value.message
    //                 }).then(() => {
    //                     window.location.reload();
    //                 })
    //             }
    //         });
    //     })
    // });
</script>

@include('components.toastr')
@endsection

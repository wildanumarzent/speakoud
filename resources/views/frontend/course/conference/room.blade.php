@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<style>
    #meet {
        position: relative;
        width: 100% !important;
    }

    #meet::after {
        position: relative;
        content: "";
        padding-top: 75%;
        display: block;
    }

    #meet > iframe {
        position: absolute;
        width: 100% !important;
        height: 100% !important;
        z-index: 20;
    }

</style>
@endsection

@section('content')
<div class="row">
    <div class="@role ('peserta_internal|peserta_mitra') col-xl-12 @else col-xl-8 @endrole">
        <div class="card">
            <h6 class="card-header with-elements">
                <div class="card-header-title">Conference</div>
            </h6>
            <div class="card-body">
                <div id="meet"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="row">
            @if (!auth()->user()->hasRole('peserta_internal|peserta_mitra'))
            <div class="col-md-12">
                <div class="card">
                    <h6 class="card-header with-elements">
                        <div class="card-header-title">Peserta</div>
                    </h6>
                    <div class="card-body" style="max-height: 600px; overflow-y: scroll;">
                        <div class="table-responsive">
                            <table class="table card-table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th style="width: 90px;">Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-peserta">
                                    <tr>
                                        <td colspan="2" align="center">
                                            <i><strong style="color:red;">! Data Peserta Kosong !</strong></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://meet.jit.si/external_api.js'></script>
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: '{{ $data['conference']->meeting_link }}',
        width: 1125,
        height: 700,
        parentNode: document.querySelector('#meet'),
        userInfo: {
            email: '{{ auth()->user()->email }}',
            displayName: '{{ auth()->user()->name }}'
        }
    };

    const api = new JitsiMeetExternalAPI(domain, options);
    api.addEventListener('videoConferenceLeft', function () {
        window.location = '/conference/{{ $data['conference']->id }}/leave';
    });
    api.executeCommand('subject', '{{ $data['conference']->bahan->judul }}');
    // api.executeCommand('avatarUrl', '{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}');

    $(document).ready(function () {
        //list peserta
        setInterval (function () {
            $.ajax({
                url : '/conference/{{ $data['conference']->id }}/peserta',
                type : "POST",
                dataType : "json",
                data : {},
                success : function(data) {
                    $('#list-peserta').html(' ');
                    if (data.peserta.length > 0) {
                        $.each(data.peserta ,function(index, value) {
                            var btn_disable = '';
                            var btn_color = 'success';
                            if (value.check_in_verified == 1) {
                                btn_disable = 'disabled';
                                var btn_color = 'secondary';
                            }
                            $('#list-peserta').append(`
                                <tr>
                                    <td>`+value.name+`</td>
                                    <td>
                                        <button id="verifikasi" class="btn btn-`+btn_color+` btn-sm icon-btn" `+btn_disable+` data-id="`+value.id+`" title="klik untuk verifikasi">
                                            <span><i class="las la-check"></i></span>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#list-peserta').append(`
                            <tr>
                                <td colspan="2" align="center">
                                    <i><strong style="color:red;">! Data Peserta Kosong !</strong></i>
                                </td>
                            </tr>
                        `);
                    }
                },
            });
        }, 5000);

        $(document).on('click', '#verifikasi', function() {
            var id = $(this).attr("data-id");
            $.ajax({
                url : '/conference/{{ $data['conference']->id }}/join/'+ id +'/verification',
                method: 'PUT',
                success:function() {
                    // console.log('success');
                },
                error: function() {
                    // console.log('gagal');
                }
            })
        });
    });
</script>

@include('components.toastr')
@endsection

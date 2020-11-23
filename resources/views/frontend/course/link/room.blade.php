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
            @role ('developer|administrator|internal|mitra|instruktu_internal|instruktur_mitra')
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
                                        <th>Verifikasi Kehadiran</th>
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
            @endrole
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
        roomName: '{{ $data['link']->meeting_link }}',
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
        window.location = '/conference/{{ $data['link']->id }}/leave';
    });
    api.executeCommand('subject', '{{ $data['link']->bahan->judul }}');
    // api.executeCommand('avatarUrl', '{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}');
</script>

@include('components.toastr')
@endsection

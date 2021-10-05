@extends('mailing.layout')

@section('content')
<h3>User <strong>{{ $data['nama_peserta'] }}</strong> Mendaftar sebagai User {{$data['type_pelatihan']}}. </h3>
<p>Login <strong> <a href="{{$data['link_login']}}"> SPEAKOUD </a></p>
<br>
<p>Pelatihan <strong><a href="{{$data['link_pelatihan']}}"> Lihat Pelatihan </a> </strong>  : Lihat List Peserta <a href="{{$data['link_manage_user_request']}}">{{$data['link_manage_user_request']}}</a> </p>
<br>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    {{-- <td>
                        <a href="{{ $data['link'] }}">AKTIVASI</a>
                    </td> --}}
                </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection

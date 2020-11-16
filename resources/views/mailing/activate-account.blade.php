@extends('mailing.layout')

@section('content')
<h3>Aktivasi akun, <strong>{{ $data['email'] }}</strong></h3>
<p>Klik tombol dibawah ini untuk mengaktifkan akun anda :</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <a href="{{ $data['link'] }}">AKTIVASI</a>
                    </td>
                </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection

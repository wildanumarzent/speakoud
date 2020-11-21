@extends('mailing.layout')

@section('content')
<h3>Verifikasi Email, <strong>{{ $data['email'] }}</strong></h3>
<p>Klik tombol dibawah ini untuk verifikasi email anda :</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <a href="{{ $data['link'] }}">Verifikasi</a>
                    </td>
                </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection

@extends('mailing.layout')

@section('content')
<h3>Pesan baru dari <strong>{{ $data['email'] }}</strong></h3>
<p>Detail : <br>
    <table style="border-collapse: collapse;width: 100%;">
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Nama </th>
            <td style="text-align: left; padding: 8px;">{{ $data['name'] }}</td>
        </tr>
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Subject </th>
            <td style="text-align: left; padding: 8px;">{{ $data['subject'] }}</td>
        </tr>
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Message </th>
            <td style="text-align: left; padding: 8px;">{{ $data['message'] }}</td>
        </tr>
    </table>
</p>
@endsection

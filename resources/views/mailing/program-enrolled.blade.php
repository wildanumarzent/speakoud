@extends('mailing.layout')

@section('content')
<h3>Selamat Anda Telah Ter Enroll pada Program :<strong> !</strong></h3>
<hr>
<p>Detail Program<br>
    {{-- <table style="border-collapse: collapse;width: 100%;">
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Program Pelatihan </th>
            <td style="text-align: left; padding: 8px;">{{ $data->mata['judul'] }}</td>
        </tr>
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Tanggal Dimulai </th>
            <td style="text-align: left; padding: 8px;">{{ $data['mata']['publish_start'] }}</td>
        </tr>
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Tanggal Selesai </th>
            <td style="text-align: left; padding: 8px;">{{ $data['mata']['publish_end'] }}</td>
        </tr>
        <tr style="nth-child(event); backgroud-color:#f2f2f2;">
            <th style="text-align: left; padding: 8px;">Jam Pelatihan </th>
            <td style="text-align: left; padding: 8px;">{{ $data['mata']['jam_pelatihan'] }}</td>
        </tr>
    </table> --}}
</p>
@endsection

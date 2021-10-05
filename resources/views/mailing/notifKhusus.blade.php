@extends('mailing.layout')

@section('content')
<h2>Hallo {{$data['nama_peserta']}}</h2>
<h3>Selamat Anda Berhasil Register di Speakoud :<strong></strong></h3>
<h3>permintaan pelatihan khusus anda sedang di tinjau :<strong></strong></h3>
<p>akses pelatiahan <a href="{{$data['link_pelatihan']}}">Lihat Pelatihan</a></p>
<p>happy learning !</p>

@endsection

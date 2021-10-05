@extends('mailing.layout')

@section('content')
<h2>Hallo {{$data['nama_peserta']}}</h2>
<h3>Selamat Anda Berhasil Register di Speakoud : akses untuk memilih pelatihan<strong><a href="{{$data['link_pelatihan']}}">{{$data['link_pelatihan']}}</a></strong></h3>
<p>happy learning !</p>

@endsection

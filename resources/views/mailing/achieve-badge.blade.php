@extends('mailing.layout')

@section('content')
<h3>Selamat Anda Telah Mendapatkan Badge :<strong>{{ $data->badge->judul }} !</strong></h3>
<p>Keep your Good Work !</p>
@endsection

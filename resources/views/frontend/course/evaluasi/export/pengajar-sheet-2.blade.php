<html>
<body>

    <table border="1">
        <thead>
            <tr>
                <th colspan="3" style="text-align: center; height: 75px; width: 80px;">
                    {!! $essay[0]['pertanyaan'] !!} <br>
                    Kelompok Soal : {!! $essay[0]['kelompok_soal'] !!} <br>
                </th>
            </tr>
            <tr>
                <th style="width: 5px;">NO</th>
                <th style="width: 30px;">KODE PESERTA</th>
                <th style="width: 40px;">JAWABAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($essay[0]['jawaban'] as $key => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{!! $item['kode_peserta'] !!}</td>
                <td style="word-wrap: break-word;">{!! $item['jawab'] !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

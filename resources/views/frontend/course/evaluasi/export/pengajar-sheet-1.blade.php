<html>
<body>

    <table border="1">
        <thead>
            <tr>
                <th colspan="11" style="text-align: center; height: 73px;">
                    REKAP EVALUASI PENYELENGGARA <strong>({{ $mata->kode_evaluasi }})</strong> <br>
                    PENGAJAR : {!! $bahan->evaluasiPengajar->mataInstruktur->instruktur->user->name !!} <br>
                    NAMA EVALUASI : {!! $detail->nama !!} <br>
                    PROGRAM PELATIHAN : {!! $mata->judul !!} <br>
                </th>
            </tr>
            <tr>
                <th style="width: 5px;">NO</th>
                <th style="width: 30px;">PERTANYAAN</th>
                <th style="width: 25px;">KELOMPOK SOAL</th>
                <th style="width: 15px;">TIDAK BAIK</th>
                <th style="width: 15px;">KURANG BAIK</th>
                <th style="width: 15px;">CUKUP</th>
                <th style="width: 15px;">BAIK</th>
                <th style="width: 15px;">SANGAT BAIK</th>
                <th style="width: 15px;">TOTAL NILAI</th>
                <th style="width: 20px;">JUMLAH PESERTA</th>
                <th style="width: 15px;">SKOR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pg as $key => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="word-wrap: break-word;">{!! $item['pertanyaan'] !!}</td>
                <td style="word-wrap: break-word;">{!! $item['kelompok_soal'] !!}</td>
                <td>{!! $item['tidak_baik'] !!}</td>
                <td>{!! $item['kurang_baik'] !!}</td>
                <td>{!! $item['cukup'] !!}</td>
                <td>{!! $item['baik'] !!}</td>
                <td>{!! $item['sangat_baik'] !!}</td>
                <td>{!! $item['total_nilai'] !!}</td>
                <td>{!! $item['jumlah_peserta'] !!}</td>
                <td>{!! $item['skor'] !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

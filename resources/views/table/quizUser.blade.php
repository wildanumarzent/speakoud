@php
    if (!empty($quiz->jml_soal_acak)) {
        $totalSoal = $quiz->jml_soal_acak;
    } else {
        $totalSoal = $quiz->item->count();
    }
@endphp
<table class="table card-table table-striped table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>NO</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Username</th>
            @for ($i = 0; $i < $totalSoal; $i++)
            <th>Q{{ ($i+1) }}</th>
            <th>A{{ ($i+1) }}</th>
            @endfor
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->peserta->nip }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->user->username }}</td>
            @foreach($quiz->trackItem()->where('user_id', $item->user_id)->orderBy('posisi', 'ASC')->get() as $value)
            <td>{!!$value->item->pertanyaan!!}</td>
            <td>{{ $value->benar == true ? 1 : 0 }}</td>
            @endforeach
            <th>{{ $quiz->trackItem()->where('user_id', $item->user_id)->where('benar', 1)->count() ?? '-'}}</th>
        </tr>
        @endforeach
    </tbody>
</table>

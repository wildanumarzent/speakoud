<table class="table card-table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>NO</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Username</th>
            @for($number = 0 ; $number < $data['quizItem']->count() ; $number++)
            <th>Q{{$number+1}}</th>
            <th>A{{$number+1}}</th>
            @endfor
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($data['peserta'] as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->peserta->nip }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->user->username }}</td>
            @foreach($data['quizItem'] as $value)
            <td>{!!$value->pertanyaan!!}</td>
            <td>{{$value->track($item->user->id)->benar ?? '-' }}</td>
            @endforeach
            <th>{{$data['totalBenar']->where('user_id',$item->user->id)->count() ?? '-'}}</th>
        </tr>
        @empty
        <tr>
            <td colspan="{{(5 + ($data['quizItem']->count() * 2))}}" align="center">
                <i>
                    <strong style="color:red;">

                    ! Data Quiz kosong !

                    </strong>
                </i>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

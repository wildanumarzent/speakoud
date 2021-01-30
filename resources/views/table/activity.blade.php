

<table id="user-list" class="table card-table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 10px;">No</th>
            <th>NIP</th>
            <th>Nama</th>
            @foreach($data['mata']->bahan()->publish()->get() as $item)
            <th><p>{{ $item->judul }}</p></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($data['peserta'] as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->peserta->nip }} </td>
            <td>{{ $item->peserta->user->email }}</td>
            @foreach($data['mata']->bahan()->publish()->get() as $bahan)
                @php
                    $track = $data['track']->where('bahan_id', $bahan->id)->where('user_id', $item->peserta->user->id)->first();
                @endphp
                @if($data['track']->where('bahan_id', $bahan->id)->where('user_id', $item->peserta->user->id)->count() > 0)
                    <td style="text-align: center;">
                        1
                    </td>
                @else
                    <td style="text-align: center;">
                        0
                    </td>
                @endif
            @endforeach
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center">
                <i>
                    <strong style="color:red;">
                    @if (Request::get('q'))
                    ! Peserta tidak ditemukan !
                    @else
                    ! Data Peserta kosong !
                    @endif
                    </strong>
                </i>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

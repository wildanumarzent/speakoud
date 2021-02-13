<table id="user-list" class="table card-table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>nama</th>
            <th>no identitas</th>
            <th>jenis kelamin</th>
            <th>agama</th>
            <th>tempat lahir</th>
            <th>tanggal lahir</th>
            <th>email</th>
            <th>no hp / telp kantor</th>
            <th>jenis peserta</th>
            <th>gol</th>
            <th>pangkat</th>
            <th>jabatan</th>
            <th>jenjang jabatan</th>
            @if(isset($data['mata']))
            <th>pola penyelengaraan</th>
            <th>sumber anggaran</th>
            @endif
            <th>instansi</th>
            <th>unit kerja</th>
            <th>alamat instansi</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($data['peserta'] as $item)
        <tr>
            {{-- <td>{{ $loop->iteration }}</td> --}}
            <td>{{$item->user->name}}</td>
            <td>{{$item->nip}}</td>
            <td>{{$item->jenis_kelamin}}</td>
            <td>{{config('addon.master_data.agama.'.$item->agama) ?? '-'}}</td>
            <td>{{$item->tempat_lahir}}</td>
            <td>{{$item->tanggal_lahir}}</td>
            <td>{{$item->user->email}}</td>
            <td>{{$item->user->information->phone}}</td>
            <td>{{strtoupper(str_replace('_', ' ', $item->user->roles[0]->name))}}</td>
            <td>{{config('addon.master_data.golongan.'.$item->pangkat) ?? '-'}}</td>
            <td>{{config('addon.master_data.pangkat.'.$item->pangkat) ?? '-'}}</td>
            <td>{{$item->jabatan->nama ?? '-'}}</td>
            <td>{{config('addon.master_data.pangkat.'.$item->jenjang_jabatan) ?? '-'}}</td>
            @if(isset($data['mata']))
            <td>{{@$data['mata']->pola_penyelenggaraan}}</td>
            <td>{{@$data['mata']->sumber_anggaran}}</td>
            @endif
            <td>{{$item->instansi($item)->nama_instansi ?? '-'}}</td>
            <td>{{$item->kedeputian}}</td>
            <td>{{$item->instansi($item)->alamat ?? '-'}}</td>


        </tr>
        @empty
        <tr>
            <td colspan="18" align="center">
                <i>
                    <strong style="color:red;">

                    ! Data Peserta kosong !

                    </strong>
                </i>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@extends('backend.course_management.mata.activity.template')

@section('content-view')
<div class="table-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th style="text-align: center;">Nilai Pre Test</th>
                <th style="text-align: center;">Nilai Post Test</th>
                <th style="text-align: center; width: 300px;">Rata-Rata Nilai Keseluruhan</th>
            </tr>
        </thead>
        <tbody>
            @if ($data['peserta']->total() == 0)
            <tr>
                <td colspan="6" align="center">
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
            @endif
            @foreach ($data['peserta'] as $item)
            <tr>
                @php
                    if ($data['pre']->where('user_id', $item->peserta->user->id)->count() > 0) {
                        $pre = round(($data['pre']->where('user_id', $item->peserta->user->id)->where('benar', 1)->count() / $data['pre']->where('user_id', $item->peserta->user->id)->count()) * 100);
                    } else {
                        $pre = 0;
                    }
                    if ($data['post']->where('user_id', $item->peserta->user->id)->count() > 0) {
                        $post = round(($data['post']->where('user_id', $item->peserta->user->id)->where('benar', 1)->count() / $data['post']->where('user_id', $item->peserta->user->id)->count()) * 100);
                        if ($post > $pre) {
                            $updown = '<i class="las la-arrow-up text-success"></i>';
                        } elseif ($post < $pre)  {
                            $updown = '<i class="las la-arrow-down text-danger"></i>';
                        } else {
                            $updown = '';
                        }

                    } else {
                        $post = 0;
                        $updown = '';
                    }
                    if ($post > 0 && $pre > 0) {
                        $total = (($pre+$post) / 2).'%';
                    } else {
                        $total = 'Belum ada hasil akhir';
                    }
                @endphp
                <td>{{ $data['number']++ }}</td>
                <td>{{ $item->peserta->nip }}</td>
                <td>{{ $item->peserta->user->name }}</td>
                <td style="text-align: center;"><strong>{{ $pre }}%</strong></td>
                <td style="text-align: center;"><strong>{!! $updown.$post !!}%</strong></td>
                <td style="text-align: center;"><strong>{{ $total }}</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                if ($data['pre']->count() > 0) {
                    $rataPre = (round(($data['pre']->where('benar', 1)->count() / $data['pre']->count()) * 100) / 1);
                } else {
                    $rataPre = 0;
                }

                if ($data['post']->count() > 0) {
                    $rataPost = (round(($data['post']->where('benar', 1)->count() / $data['post']->count()) * 100) / 1);
                } else {
                    $rataPost = 0;
                }

                $hasilPrePost = ((($rataPre+$rataPost) / 2) / 1);
            @endphp
            <tr>
                <th colspan="3">Rata - Rata Nilai</th>
                <th class="text-center"><span class="badge badge-primary">{{ $rataPre }}</span></th>
                <th class="text-center"><span class="badge badge-primary">{{ $rataPost }}</span></th>
                <th class="text-center"><span class="badge badge-success">{{ ($rataPre > 0 && $rataPost > 0) ? $hasilPrePost : 0 }}</span></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="card-footer">
    <div class="row align-items-center">
        <div class="col-lg-6 m--valign-middle">
            Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
            <strong>{{ $data['peserta']->total() }}</strong>
        </div>
        <div class="col-lg-6 m--align-right">
            {{ $data['peserta']->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection

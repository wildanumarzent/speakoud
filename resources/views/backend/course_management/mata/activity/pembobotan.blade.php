@extends('backend.course_management.mata.activity.template')

@section('content-view')
<div class="table-responsive table-mobile-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="3" style="width: 10px;">NO</th>
                <th rowspan="3">NIP</th>
                <th rowspan="3">NAMA</th>
                <th colspan="1" style="text-align:center;">KEHADIRAN</th>
                <th colspan="3" style="text-align:center;">KEAKTIFAN</th>
                <th colspan="2" style="text-align:center;">TUGAS</th>
                <th rowspan="3">POST TEST</th>
              </tr>
              <tr style="text-align:center;">
                  <th rowspan="2">Join Video Conference</th>
                  <th rowspan="2">Activity Completion</th>
                  <th rowspan="2">Forum Diskusi</th>
                  <th rowspan="2">Webinar</th>
                  <th rowspan="2">Progress Test</th>
                  <th rowspan="2">Quiz</th>
              </tr>
        </thead>
        <tbody>
            @if ($data['peserta']->total() == 0)
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
            @endif
            @foreach ($data['peserta'] as $item)
            <tr>
                <td>{{ $data['number']++ }}</td>
                <td>{{ $item->peserta->nip }}</td>
                <td>{{ $item->peserta->user->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
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

@extends('backend.course_management.mata.activity.template')

@section('content-view')
<div class="table-responsive table-mobile-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="3" style="width: 10px;">NO</th>
                <th rowspan="3">NIP</th>
                <th rowspan="3">NAMA</th>
                <th colspan="1" style="text-align:center;">
                    KEHADIRAN ({{ $data['mata']->bobot->join_vidconf.'%' }})
                </th>
                <th colspan="3" style="text-align:center;">
                    KEAKTIFAN ({{ ($data['mata']->bobot->activity_completion+$data['mata']->bobot->forum_diskusi+$data['mata']->bobot->webinar).'%' }})
                </th>
                <th colspan="2" style="text-align:center;">
                    TUGAS ({{ !empty($data['mata']->bobot->progress_test) ? ($data['mata']->bobot->progress_test+$data['mata']->bobot->quiz).'%' : ($data['mata']->bobot->quiz).'%' }})
                </th>
                <th rowspan="3" style="text-align:center;">POST TEST ({{ $data['mata']->bobot->post_test.'%' }})</th>
                <th rowspan="3" style="text-align:center;">TOTAL</th>
              </tr>
              <tr style="text-align:center;">
                  <th rowspan="2">Join Video Conference</th>
                  <th rowspan="2">Activity Completion ({{ $data['mata']->bobot->activity_completion.'%' }})</th>
                  <th rowspan="2">Forum Diskusi ({{ $data['mata']->bobot->forum_diskusi.'%' }})</th>
                  <th rowspan="2">Webinar ({{ $data['mata']->bobot->webinar.'%' }})</th>
                  <th rowspan="2">
                      {!! !empty($data['mata']->bobot->progress_test) ? 'Progress Test' : '<s>Progress Test</s>' !!} {{ !empty($data['mata']->bobot->progress_test) ? '('.$data['mata']->bobot->progress_test.'%)' : '' }}
                    </th>
                  <th rowspan="2">Quiz ({{ $data['mata']->bobot->quiz.'%' }})</th>
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
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotVidConf($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotActivity($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotForum($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotWebinar($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    @if (!empty($data['mata']->bobot->progress_test))
                    <strong>{{ $item->mata->bobot->bobotProgress($item->mata_id, $item->peserta->user->id) }}</strong>
                    @else
                        <em>Tidak diaktifkan</em>
                    @endif
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotQuiz($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->bobotPost($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
                <td style="text-align:center;">
                    <strong>{{ $item->mata->bobot->totalBobot($item->mata_id, $item->peserta->user->id) }}%</strong>
                </td>
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

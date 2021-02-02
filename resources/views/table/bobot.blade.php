<table>
    <thead>
        <tr>
            <th rowspan="3" style="width: 10px;">NO</th>
            <th rowspan="3">NIP</th>
            <th rowspan="3">NAMA</th>
            <th colspan="1" align = "center">
                KEHADIRAN ({{ $data['mata']->bobot->join_vidconf.'%' }})
            </th>
            <th colspan="3" align = "center">
                KEAKTIFAN ({{ ($data['mata']->bobot->activity_completion+$data['mata']->bobot->forum_diskusi+$data['mata']->bobot->webinar).'%' }})
            </th>
            <th colspan="2" align = "center">
                TUGAS ({{ !empty($data['mata']->bobot->progress_test) ? ($data['mata']->bobot->progress_test+$data['mata']->bobot->quiz).'%' : ($data['mata']->bobot->quiz).'%' }})
            </th>
            <th rowspan="3" align = "center">POST TEST ({{ $data['mata']->bobot->post_test.'%' }})</th>
            <th rowspan="3" align = "center">TOTAL</th>
          </tr>
          <tr>
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
        <tr></tr>

        @forelse ($data['peserta'] as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->peserta->nip }}</td>
            <td>{{ $item->peserta->user->name }}</td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotVidConf($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotActivity($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotForum($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotWebinar($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                @if (!empty($data['mata']->bobot->progress_test))
                <strong>{{ $item->mata->bobot->bobotProgress($item->mata_id, $item->peserta->user->id) }}</strong>
                @else
                    <em>Tidak diaktifkan</em>
                @endif
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotQuiz($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->bobotPost($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
            <td align = "center">
                <strong>{{ $item->mata->bobot->totalBobot($item->mata_id, $item->peserta->user->id) }}%</strong>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" align="center">
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

<div class="row">
    <div class="col-md-6 col-lg-12 col-xl-6">

        <div class="card mb-4">
            <h6 class="card-header">Pelatihan Aktif</h6>
            <div class="table-responsive">
              <table class="table card-table">
                  <thead>
                      <tr>
                          <th>Judul</th>
                          <th>Tanggal</th>
                          <th>Enroll</th>
                          <th>Topik</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      @if ($data['latestCourse']->count() == 0)
                      <tr>
                          <td colspan="5" class="text-center">
                              <i style="color: red;">! tidak ada pelatihan !</i>
                          </td>
                      </tr>
                      @endif
                      @foreach ($data['latestCourse'] as $course)
                      <tr>
                          <td>{!! $course->judul !!}</td>
                          <td>{{ $course->publish_start->format('d F Y') }} - {{ $course->publish_end->format('d F Y') }}</td>
                          <td>{{ $course->peserta->count() }}</td>
                          <td>{{ $course->materi->count() }}</td>
                          <td>
                            <a href="{{ route('course.detail', ['id' => $course->id]) }}" target="_blank" class="btn btn-primary icon-btn btn-sm" title="klik untuk melihat detail">
                                <i class="las la-external-link-alt"></i>
                            </a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
        </div>

    </div>
    <div class="col-md-6 col-lg-12 col-xl-6">

        <div class="card mb-4">
          <h6 class="card-header">Video Conference</h6>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                  <tr>
                      <th>Program</th>
                      <th>Mata</th>
                      <th>Materi</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                    @if ($data['videoConference']->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center">
                            <i style="color: red;">! tidak ada video conference !</i>
                        </td>
                    </tr>
                    @endif
                    @foreach ($data['videoConference'] as $conf)
                    <tr>
                        <td>{{ $conf->mata->judul }}</td>
                        <td>{{ $conf->materi->judul }}</td>
                        <td>{{ $conf->bahan->judul }}</td>
                        <td>{{ $conf->tanggal->format('d F Y') }}</td>
                        <td>
                            @if ($conf->status == 0)
                                <span class="badge badge-secondary">Belum dimulai</span>
                            @elseif ($conf->status == 1)
                                <span class="badge badge-warning">Sedang berlangsung</span>
                            @else
                                <span class="badge badge-success">Sudah selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('course.bahan', ['id' => $conf->mata_id, 'bahanId' => $conf->bahan_id, 'tipe' => 'conference']) }}" class="btn btn-primary icon-btn btn-sm">
                                <i class="las la-external-link-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
              </tbody>
            </table>
          </div>
        </div>

    </div>
</div>

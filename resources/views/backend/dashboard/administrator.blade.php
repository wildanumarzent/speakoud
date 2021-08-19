{{-- user & course --}}
<div class="row">
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-user-friends display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">User</div>
              <div class="text-large">{{ $data['counter']['user_internal'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-user-tie display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Instruktur</div>
              <div class="text-large">{{ $data['counter']['user_instruktur'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-users display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Peserta</div>
              <div class="text-large">{{ $data['counter']['user_peserta'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="las la-book display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small">Kategori Pelatihan</div>
                <div class="text-large">{{ $data['counter']['course_kategori'] }}</div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class="col-sm-6 col-xl-3">

        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="las la-book-open display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small">Program Pelatihan</div>
                <div class="text-large">{{ $data['counter']['course_program'] }}</div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class="col-sm-6 col-xl-3">

        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="las la-swatchbook display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small">Mata Pelatihan</div>
                <div class="text-large">{{ $data['counter']['course_mata'] }}</div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class="col-sm-6 col-xl-3">

        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="las la-folder display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small">Materi Pelatihan</div>
                <div class="text-large">{{ $data['counter']['course_materi'] }}</div>
              </div>
            </div>
          </div>
        </div>

    </div>
</div>

{{-- manage course --}}
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
                        <td>{!! Str::limit($course->judul, 45) !!}</td>
                        <td>{{ $course->publish_start->format('d F Y') }} <strong>s/d</strong> {{ $course->publish_end->format('d F Y') }}</td>
                        <td class="text-center">
                          <strong>
                            {{ $course->peserta->count() }}
                          </strong>
                        </td>
                        <td class="text-center">
                          <strong>
                            {{ $course->materi->count() }}
                          </strong>
                        </td>
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
            <h6 class="card-header">Kalender Diklat</h6>
            <div class="table-responsive">
                <table class="table card-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jam</th>
                            <th>Lokasi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['jadwalPelatihan']->count() == 0)
                        <tr>
                            <td colspan="4" class="text-center">
                                <i style="color: red;">! tidak ada jadwal pelatihan !</i>
                            </td>
                        </tr>
                        @endif
                        @foreach ($data['jadwalPelatihan'] as $jdwl)
                        <tr>
                            <td>{!! Str::limit($jdwl->judul, 45) !!}</td>
                            <td>{{ $jdwl->start_time.' - '.$jdwl->end_time }}</td>
                            <td>{{ Str::limit($jdwl->lokasi, 20) }}</td>
                            <td>
                                <a href="{{ route('course.jadwal.detail', ['id' => $jdwl->id]) }}" class="btn btn-primary icon-btn btn-sm" title="klik untuk melihat detail">
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

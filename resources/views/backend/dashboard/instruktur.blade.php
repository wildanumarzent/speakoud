<hr class="container-m-nx mt-0 mb-4">
<h4 class="font-weight-semibold mb-4">Pelatihan aktif yang Anda Ajarkan :</h4>

<div class="row">

    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

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

<hr class="container-m-nx mt-0 mb-4">
<h4 class="font-weight-semibold mb-4">Riwayat Pelatihan yang Anda Ajakarkan :</h4>

<div class="row">

    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card card-list">
            <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url(https://e-learning-bppt.apps/assets/tmplts_backend/images/cover.jpg);">
                <div class="d-flex justify-content-end align-items-start ui-rect-content p-3">
                    <div class="flex-shrink-1">
                        <span class="badge badge-primary"><i class="las la-calendar"></i> 12 April 2021</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-2">
                    <div class="text-body">
                        Pelatihan Jabatan Fungsional Perekayasa
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>Jumlah Peserta</th>
                                <td>40</td>
                            </tr>
                            <tr>
                                <th>Jadwal Mengajar</th>
                                <td>Senin, 12 April 2021</td>
                            </tr>
                            <tr>
                                <th>Tugas yang sudah dinilai</th>
                                <td>0/1</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </h5>
                <div class="media">
                    <div class="media-body text-center">
                        <a class="btn btn-primary mr-2" href="" title="klik untuk melihat detail pelatihan">
                            MASUK
                        </a>
                        <a class="btn btn-primary" href="" title="klik untuk menilai tugas">
                            NILAI TUGAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- <div class="row">
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
</div> --}}

<div class="row">
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-medal display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Badge</div>
              <div class="text-large">{{ $data['counter']['peserta_badge'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-certificate display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Sertifikat</div>
              <div class="text-large">{{ $data['counter']['peserta_sertifikat'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="ios ion-md-bookmarks display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Learning Journey</div>
              <div class="text-large">{{ $data['counter']['peserta_journey'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6 col-xl-3">

      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="lnr lnr-graduation-hat display-4 text-primary"></div>
            <div class="ml-3">
              <div class="text-muted small">Program Pelatihan yang Diikuti</div>
              <div class="text-large">{{ $data['counter']['peserta_mata'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>


</div>

<div class="row">

    <div class="col-md-6 col-lg-12 col-xl-6">

        <div class="card mb-4">
          <h6 class="card-header">Program Pelatihan yang diikuti</h6>
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
          <h6 class="card-header">Rekomendasi Program Pelatihan Untuk Meningkatkan Kompetensi</h6>
          <div class="table-responsive">
            <table class="table card-table">
                <thead>
                    <tr>
                        <th>Program Pelatihan</th>
                        <th>Tanggal</th>
                        <th>Jam Pelatihan</th>
                        <th>Kompetensi Terkait</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data['rekomendasi']->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center">
                            <i style="color: red;">! tidak ada program untuk direkomendasikan !</i>
                        </td>
                    </tr>
                    @endif
                    @foreach ($data['rekomendasi'] as $key => $rek)
                    <tr>
                        <td>{{$rek->judul}}</td>
                        <td>{{ $rek->publish_start->format('d F Y') }} - {{ $rek->publish_end->format('d F Y') }}</td>
                        <td>{{$rek->jam_pelatihan}} Jam</td>
                        <td>
                            @foreach($data['kompetensiMata']->where('mata_id',$rek['kompetensiMata'][0]['mata_id']) as $k)
                            <span class="badge badge-default">{{$k->kompetensi->judul}}</span>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>

    </div>

</div>

{{-- <div class="row">
    <div class="col-md-6 col-lg-12 col-xl-6">
        <div class="card mb-4">
            <h6 class="card-header">Jadwal Diklat</h6>
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
                            <td>{!! $jdwl->judul !!}</td>
                            <td>{{ $jdwl->start_time.' - '.$jdwl->end_time }}</td>
                            <td>{{ Str::limit($jdwl->lokasi, 20) }}</td>
                            <td>
                                <a href="{{ route('course.jadwal.detail', ['id' => $jdwl->id]) }}" class="btn btn-primary icon-btn btn-sm">
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
          <h6 class="card-header">Artikel Terbaru</h6>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                  <tr>
                      <th>Judul</th>
                      <th>Creator</th>
                      <th>Tanggal</th>
                      <th>Viewer</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                    @if ($data['latestArticle']->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center">
                            <i style="color: red;">! tidak ada artikel terbaru !</i>
                        </td>
                    </tr>
                    @endif
                    @foreach ($data['latestArticle'] as $art)
                    <tr>
                        <td>{!! $art->judul !!}</td>
                        <td>{{ $art->userCreated->name }}</td>
                        <td>{{ $art->created_at->format('d F Y') }}</td>
                        <td><span class="badge badge-info">{{ $art->viewer }}</span></td>
                        <td>
                            <a href="{{ route('artikel.read', ['id' => $art->id, 'slug' => $art->slug]) }}" class="btn btn-primary icon-btn btn-sm">
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

{{-- <div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">

        <div class="card mb-4">
          <h6 class="card-header">Video Conference yang harus diikuti</h6>
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

{{-- <div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">

        <div class="card mb-4">
          <h6 class="card-header">Badge Yang Telah Didapat : {{$data['counter']['peserta_badge']}}</h6>
          <div class="card-body">

            <div id="icons-container" class="text-center">
                @forelse($data['myBadge'] as $badge)
                <div data-title="{{$badge->badge->nama}}" class="card icon-example  d-inline-flex justify-content-center align-items-center my-2 mx-2c shadow bg-white ml-2">
                  <img src="{{asset($badge->badge->icon)}}" alt="{{$badge->badge->nama}}" style="width: 50px;height: 50px;object-fit:cover;" class="rounded-circle">
                </div>
                @empty
                <center><b>Anda Belum Mendapatkan Badge Apapun</b></center>
                @endforelse
            </div>

          </div>
        </div>

    </div>
</div> --}}

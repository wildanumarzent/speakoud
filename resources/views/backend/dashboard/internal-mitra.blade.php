{{-- user & course --}}
<div class="row">
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
              <div class="las la-book-open display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small">Mata Pelatihan</div>
                <div class="text-large">{{ $data['counter']['course_mata'] }}</div>
              </div>
            </div>
          </div>
        </div>

    </div>
</div>

{{-- manage course --}}
<div class="row">
    <div class="col-md-6 col-lg-12 col-xl-6">

        <div class="card card-list mb-4">
          <h6 class="card-header">Latest Course</h6>
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
                  @for ($i = 0; $i < 5; $i++)
                  <tr>
                      <td>Pelatihan Jabatan Fungsional Perekayasa</td>
                      <td>25 November 2020 - 25 November 2021</td>
                      <td>30</td>
                      <td>8</td>
                      <td>
                        <a href="" class="btn btn-primary icon-btn btn-sm">
                            <i class="las la-external-link-alt"></i>
                        </a>
                      </td>
                  </tr>
                  @endfor
              </tbody>
            </table>
          </div>
        </div>

    </div>
    <div class="col-md-6 col-lg-12 col-xl-6">
        <div class="card card-list mb-4">
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
                      @for ($i = 0; $i < 5; $i++)
                      <tr>
                          <td>Pelatihan JFP Teknisi Litkayasa</td>
                          <td>08:00 - 17:00</td>
                          <td>Bumi Aji, Anak Tuha...</td>
                          <td>
                            <a href="" class="btn btn-primary icon-btn btn-sm">
                                <i class="las la-external-link-alt"></i>
                            </a>
                          </td>
                      </tr>
                      @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>


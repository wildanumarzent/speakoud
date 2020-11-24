<div class="row">
    <div class="col-md-6 col-lg-12 col-xl-6">

        <div class="card card-list mb-4">
          <h6 class="card-header">Course</h6>
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
          <h6 class="card-header">Video Conference</h6>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                  <tr>
                      <th>Materi</th>
                      <th>Bahan</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  @for ($i = 0; $i < 5; $i++)
                  <tr>
                      <td>Pembinaan Karir</td>
                      <td>Webinar Pembinaan Karir</td>
                      <td>25 November 2020</td>
                      <td><span class="badge badge-success">Sudah Selesai</span></td>
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

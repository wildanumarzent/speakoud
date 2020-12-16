@php
    $masterOpen = (Request::is('instansi/internal*') || Request::is('instansi/mitra*') || Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*') || Request::is('grades*') || Request::is('tags*') || Request::is('komentar*'));
    $userOpen = (Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*'));
    $course = (Request::is('program*') || Request::is('mata*') || Request::is('materi*') || Request::is('course*') || Request::is('jadwal*') || Request::is('kalender*'));
@endphp
<div id="layout-sidenav" class="{{ isset($layout_sidenav_horizontal) ? 'layout-sidenav-horizontal sidenav-horizontal container-p-x flex-grow-0' : 'layout-sidenav sidenav-vertical' }} sidenav bg-sidenav-theme">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
        <span class="app-brand-logo demo">
            <img src="{{ asset(config('addon.images.logo')) }}">
        </span>
        <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
          <i class="las la-thumbtack"></i>
        </a>
    </div>

    <div class="sidenav-divider mt-0"></div>

    <!-- Inner -->
    <ul class="sidenav-inner{{ empty($layout_sidenav_horizontal) ? ' py-1' : '' }}">

         <!-- Dashboard -->
        <li class="sidenav-item{{ Request::is('dashboard') ? ' active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidenav-link" title="Dashboard"><i class="sidenav-icon las la-tachometer-alt"></i><div>Dashboard</div></a>
        </li>

        <!-- Module -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">MODULE</li>

        @role ('developer|administrator|internal|mitra')
        <!-- Data Master -->
        <li class="sidenav-item{{ $masterOpen ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Data Master"><i class="sidenav-icon las la-database"></i>
            <div>Data Master</div>
          </a>
            <ul class="sidenav-menu">
                @role ('developer|administrator|internal')
                <!-- Instansi -->
                <li class="sidenav-item{{ (Request::is('instansi/internal*') || Request::is('instansi/mitra*')) ? ' active open' : '' }}">
                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Instansi">
                      <div>Instansi</div>
                    </a>

                    <ul class="sidenav-menu">
                        @role ('developer|administrator')
                        <!-- Internal -->
                        <li class="sidenav-item{{ Request::is('instansi/internal*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.internal.index') }}" class="sidenav-link" title="BPPT">
                              <div>BPPT</div>
                            </a>
                        </li>
                        @endrole
                        <!-- Mitra -->
                        <li class="sidenav-item{{ Request::is('instansi/mitra*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.mitra.index') }}" class="sidenav-link" title="Mitra">
                              <div>Mitra</div>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                <!-- User Management -->
                <li class="sidenav-item{{ $userOpen ? ' active open' : '' }}">
                  <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="User Management">
                    <div>User Management</div>
                  </a>

                  <ul class="sidenav-menu">
                    @role ('developer|administrator')
                    <!-- Users -->
                    <li class="sidenav-item{{ Request::is('user*') ? ' active' : '' }}">
                    <a href="{{ route('user.index') }}" class="sidenav-link" title="Users">
                        <div>Users</div>
                    </a>
                    </li>
                    <!-- User BPPT -->
                    <li class="sidenav-item{{ Request::is('internal*') ? ' active' : '' }}">
                        <a href="{{ route('internal.index') }}" class="sidenav-link" User BPPT>
                            <div>User BPPT</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal')
                    <!-- Mitra -->
                    <li class="sidenav-item{{ Request::is('mitra*') ? ' active' : '' }}">
                        <a href="{{ route('mitra.index') }}" class="sidenav-link" title="Mitra">
                        <div>Mitra</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal|mitra')
                    <!-- Instruktur -->
                    <li class="sidenav-item{{ Request::is('instruktur*') ? ' active' : '' }}">
                        <a href="{{ route('instruktur.index') }}" class="sidenav-link" title="Instruktur">
                        <div>Instruktur</div>
                        </a>
                    </li>
                    <!-- Peserta -->
                    <li class="sidenav-item{{ Request::is('peserta*') ? ' active' : '' }}">
                        <a href="{{ route('peserta.index') }}" class="sidenav-link" title="Peserta">
                        <div>Peserta</div>
                        </a>
                    </li>
                    @endrole
                  </ul>
                </li>
                @role ('developer|administrator')
                <!-- grades -->
                <li class="sidenav-item{{ Request::is('grades*') ? ' active' : '' }}">
                    <a href="{{ route('grades.index') }}" class="sidenav-link" title="Grades Management">
                      <div>Grades Management</div>
                    </a>
                </li>
                <!-- tags -->
                <li class="sidenav-item{{ Request::is('tags*') ? ' active' : '' }}">
                    <a href="{{ route('tags.index') }}" class="sidenav-link" title="Tags">
                      <div>Tags</div>
                    </a>
                </li>
                <!-- komentar -->
                <li class="sidenav-item{{ Request::is('komentar*') ? ' active' : '' }}">
                    <a href="{{ route('komentar.index') }}" class="sidenav-link" title="Komentar">
                      <div>Komentar</div>
                    </a>
                </li>
                @endrole
            </ul>
        </li>
        @endrole

        @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <!-- bank data -->
        <li class="sidenav-item{{ Request::is('bank/data*') ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Bank Data"><i class="sidenav-icon las la-server"></i>
            <div>Bank Data</div>
          </a>

          <ul class="sidenav-menu">
            @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
            <!-- global -->
            <li class="sidenav-item{{ Request::is('bank/data/global*') ? ' active' : '' }}">
              <a href="{{ route('bank.data', ['type' => 'global']) }}" class="sidenav-link" title="Global">
                <div>Global</div>
              </a>
            </li>
            @endrole
            @role ('mitra|instruktur_internal|instruktur_mitra')
            <!-- personal -->
            <li class="sidenav-item{{ Request::is('bank/data/personal*') ? ' active' : '' }}">
                <a href="{{ route('bank.data', ['type' => 'personal']) }}" class="sidenav-link" title="Personal">
                  <div>Personal</div>
                </a>
            </li>
            @endrole
          </ul>
        </li>
        @endrole

        @role ('administrator|internal|mitra')
        <!-- bank soal -->
        <li class="sidenav-item{{ Request::is('soal*') ? ' active' : '' }}">
            <a href="{{ route('soal.kategori') }}" class="sidenav-link" title="Bank Soal"><i class="sidenav-icon las la-spell-check"></i>
              <div>Bank Soal</div>
            </a>
        </li>
        @endrole

        <!-- courses -->
        <li class="sidenav-item{{ $course ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Course Management"><i class="sidenav-icon las la-book-open"></i>
            <div>Course Management</div>
          </a>
          @php
              if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
                  $program = 'course.list';
                  $jadwal = 'course.jadwal';
              } else {
                  $program = 'program.index';
                  $jadwal = 'jadwal.index';
              }
          @endphp
          <ul class="sidenav-menu">
            <!-- program pelatihan -->
            <li class="sidenav-item{{ (Request::is('program*') || Request::is('mata*') || Request::is('materi*') || Request::is('course*')) ? ' active open' : '' }}">
                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Program Pelatihan">
                  <div>Program Pelatihan</div>
                </a>

                <ul class="sidenav-menu">
                    <!-- aktif -->
                    <li class="sidenav-item{{ (Request::is('program*') && Request::get('status') != 'histori' || Request::is('mata*') || Request::is('materi*') || Request::is('course*')) ? ' active' : '' }}">
                        <a href="{{ route($program) }}" class="sidenav-link" title="Aktif">
                          <div>Aktif</div>
                        </a>
                    </li>
                    <!-- histori -->
                    <li class="sidenav-item">
                        <a href="" class="sidenav-link" title="Histori">
                          <div>Histori</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- jadwal -->
            <li class="sidenav-item{{ (Request::is('jadwal*')) ? ' active' : '' }}">
                <a href="{{ route($jadwal) }}" class="sidenav-link" title="Jadwal Diklat">
                  <div>Jadwal Diklat</div>
                </a>
            </li>
            <!-- kalender -->
            <li class="sidenav-item{{ (Request::is('kalender*')) ? ' active' : '' }}">
                <a href="{{route('kalender.index')}}" class="sidenav-link" title="Kalender Diklat">
                  <div>Kalender Diklat</div>
                </a>
            </li>
          </ul>
        </li>

        <!-- sertifikasi -->
        <li class="sidenav-item">
            <a href="" class="sidenav-link" title="Sertifikasi"><i class="sidenav-icon las la-certificate"></i>
              <div>Sertifikasi</div>
            </a>
        </li>
        <!-- announcement -->
        <li class="sidenav-item {{ Request::is('announcement*') ? ' active' : '' }}">
            <a href="{{route('announcement.index')}}" class="sidenav-link" title="Announcement"><i class="sidenav-icon las la-bullhorn"></i>
              <div>Announcement</div>
            </a>
        </li>
        <!-- aktivitas -->
        <li class="sidenav-item">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Aktivitas"><i class="sidenav-icon las la-street-view"></i>
              <div>Aktivitas</div>
            </a>

            <ul class="sidenav-menu">
                <!-- statistik -->
              <li class="sidenav-item {{ Request::is('statistic*') ? ' active' : '' }}">
                  <a href="{{route('statistic.index')}}" class="sidenav-link" title="Statistik">
                    <div>Statistik</div>
                  </a>
              </li>
              <!-- log -->
              <li class="sidenav-item">
                  <a href="" class="sidenav-link" title="Logs">
                    <div>Logs</div>
                  </a>
              </li>
            </ul>
        </li>
        <!-- report -->
        <li class="sidenav-item">
            <a href="" class="sidenav-link" title="Laporan"><i class="sidenav-icon las la-calendar-day"></i>
              <div>Laporan</div>
            </a>
        </li>

        @role ('developer|administrator')
        <!-- website -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">WEBSITE</li>

        <!-- pages -->
        <li class="sidenav-item{{ (Request::is('page*')) ? ' active' : '' }}">
            <a href="{{ route('page.index') }}" class="sidenav-link" title="Pages"><i class="sidenav-icon las la-list"></i>
              <div>Pages</div>
            </a>
        </li>
        <!-- artikel -->
        <li class="sidenav-item{{ (Request::is('artikel*')) ? ' active' : '' }}">
            <a href="{{ route('artikel.index') }}" class="sidenav-link" title="Artikel"><i class="sidenav-icon las la-newspaper"></i>
              <div>Artikel</div>
            </a>
        </li>
        <!-- banner -->
        <li class="sidenav-item{{ (Request::is('banner*')) ? ' active' : '' }}">
            <a href="{{ route('banner.index') }}" class="sidenav-link" title="Banner"><i class="sidenav-icon las la-images"></i>
              <div>Banner</div>
            </a>
        </li>
        <!-- inquiry -->
        <li class="sidenav-item{{ (Request::is('inquiry*')) ? ' active' : '' }}">
            <a href="{{route('inquiry.index')}}" class="sidenav-link" title="Inquiry"><i class="sidenav-icon las la-envelope"></i>
              <div>Inquiry</div>
              @if ($inquiry['total_contact'] > 0)
              <div class="pl-1 ml-auto">
                  <div class="badge badge-danger">{{ $inquiry['total_contact'] }}</div>
              </div>
              @endif
            </a>
        </li>
        <!-- konfig -->
        <li class="sidenav-item{{ Request::is('konfigurasi*') ? ' open active' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Konfigurasi"><i class="sidenav-icon las la-cog"></i>
              <div>Konfigurasi</div>
            </a>

            <ul class="sidenav-menu">
              <!-- konten -->
              <li class="sidenav-item{{ (Request::is('konfigurasi/konten')) ? ' active' : '' }}">
                  <a href="{{ route('config.index') }}" class="sidenav-link" title="Konten">
                    <div>Konten</div>
                  </a>
              </li>
              <!-- strip -->
              <li class="sidenav-item{{ Request::is('konfigurasi/strip') ? ' active' : '' }}">
                  <a href="{{ route('config.strip') }}" class="sidenav-link" title="Strip Text">
                    <div>Strip Text</div>
                  </a>
              </li>
            </ul>
        </li>
        @endrole

    </ul>
</div>

@php
    $masterOpen = (Request::is('instansi/internal*') || Request::is('instansi/mitra*') || Request::is('jabatan*') || Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*') || Request::is('grades*') || Request::is('tags*') || Request::is('komentar*'));
    $userOpen = (Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*'));
    $course = (Request::is('template*') || Request::is('program*') || Request::is('mata*') || Request::is('materi*') || Request::is('quiz*') || Request::is('course*') || Request::is('jadwal*') || Request::is('kalender*'));
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
        <li class="sidenav-header small font-weight-semibold">BELS MODULE</li>

        @role ('developer|administrator|internal|mitra')
        <!-- Data Master -->
        <li class="sidenav-item{{ $masterOpen ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Master Data"><i class="sidenav-icon las la-database"></i>
            <div>Master Data</div>
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
                @role ('developer|administrator')
                 <!-- jabatan -->
                 <li class="sidenav-item{{ Request::is('jabatan*') ? ' active' : '' }}">
                    <a href="{{ route('jabatan.index') }}" class="sidenav-link" title="Jabatan">
                      <div>Jabatan</div>
                    </a>
                </li>
                @endrole
                <!-- Manajemen User -->
                <li class="sidenav-item{{ $userOpen ? ' active open' : '' }}">
                  <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Manajemen User">
                    <div>Manajemen User</div>
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
                    <a href="{{ route('grades.index') }}" class="sidenav-link" title="Manajemen Nilai">
                      <div>Manajemen Nilai</div>
                    </a>
                </li>
                <!-- tags -->
                {{-- <li class="sidenav-item{{ Request::is('tags*') ? ' active' : '' }}">
                    <a href="{{ route('tags.index') }}" class="sidenav-link" title="Tags">
                      <div>Tags</div>
                    </a>
                </li> --}}
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

        @role ('administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <!-- bank soal -->
        <li class="sidenav-item{{ (Request::is('bank/soal*') || Request::is('mata*') && Request::segment(4) == 'kategori') ? ' active' : '' }}">
            <a href="{{ route('soal.mata') }}" class="sidenav-link" title="Bank Soal"><i class="sidenav-icon las la-spell-check"></i>
              <div>Bank Soal</div>
            </a>
        </li>
        @endrole

        <!-- courses -->
        <li class="sidenav-item{{ $course ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Manajemen DIKLAT"><i class="sidenav-icon las la-book-open"></i>
            <div>Manajemen DIKLAT</div>
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
            <li class="sidenav-item{{ (Request::is('template*') || Request::is('program*') || Request::is('mata*') || Request::is('materi*') || Request::is('quiz*') || Request::is('course*')) ? ' active open' : '' }}">
                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Program Pelatihan">
                  <div>Program Pelatihan</div>
                </a>

                <ul class="sidenav-menu">
                    @role ('administrator|internal')
                    <!-- templating -->
                    <li class="sidenav-item{{ (Request::is('template*')) ? ' active' : '' }}">
                        <a href="{{ route('template.mata.index') }}" class="sidenav-link" title="Templating Program Pelatihan">
                            <div>Template</div>
                        </a>
                    </li>
                    @endrole
                    <!-- aktif -->
                    <li class="sidenav-item{{ (Request::is('program*') && Request::segment(2) != 'history' || Request::is('mata*') || Request::is('materi*') || Request::is('quiz*') || Request::is('course*')) ? ' active' : '' }}">
                        <a href="{{ route($program) }}" class="sidenav-link" title="Program Pelatihan Aktif">
                          <div>Aktif</div>
                        </a>
                    </li>
                    <!-- histori -->
                    <li class="sidenav-item{{ (Request::is('program*') && Request::segment(2) == 'history') ? ' active' : '' }}">
                        <a href="{{ route('mata.history') }}" class="sidenav-link" title="Histori Program Pelatihan">
                          <div>Histori</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- jadwal -->
            @role('developer|administrator|internal|mitra')
            <li class="sidenav-item{{ (Request::is('jadwal*')) ? ' active' : '' }}">
                <a href="{{ route($jadwal) }}" class="sidenav-link" title="Kalender Diklat">
                  <div>Kalender Diklat</div>
                </a>
            </li>
            @endrole
            <!-- kalender -->
            <li class="sidenav-item{{ (Request::is('kalender*')) ? ' active' : '' }}">
                <a href="{{route('kalender.index')}}" class="sidenav-link" title="Agenda">
                  <div>
                    @role ('developer|administrator|internal|mitra')
                        Agenda
                    @else
                        Kalender Diklat
                    @endrole
                  </div>
                </a>
            </li>
          </ul>
        </li>


        @role ('peserta_mitra|peserta_internal')
        <!-- journey -->
        {{-- <li class="sidenav-item {{ Request::is('journey*') ? ' active' : '' }}">
            <a href="{{route('journey.index')}}" class="sidenav-link" title="Learning Journey"><i class="sidenav-icon las la-bookmark"></i>
                <div>Learning Journey</div>
            </a>
        </li>
        <!-- badge -->
         <li class="sidenav-item {{ Request::is('badge.my.') ? ' active' : '' }}">
            <a href="{{route('badge.my.index')}}" class="sidenav-link" title="Badge Saya"><i class="sidenav-icon las la-medal"></i>
              <div>Badge Saya</div>
            </a>
        </li> --}}
        @endrole

        @role ('developer|administrator|internal')
        <!-- kompetensi -->
        <li class="sidenav-item {{ Request::is('kompetensi*') ? ' active' : '' }}">
            <a href="{{route('kompetensi.index')}}" class="sidenav-link" title="Kompetensi"><i class="sidenav-icon las la-chalkboard-teacher"></i>
              <div>Kompetensi</div>
            </a>
        </li>
        @endrole

        <!-- sertifikasi -->
        {{-- <li class="sidenav-item">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Sertifikasi"><i class="sidenav-icon las la-certificate"></i>
              <div>Sertifikasi</div>
            </a>

            <ul class="sidenav-menu">
              <!-- bppt -->
              <li class="sidenav-item">
                <a href="" class="sidenav-link" title="Internal">
                  <div>Internal</div>
                </a>
              </li>
              <!-- lan -->
              <li class="sidenav-item">
                  <a href="" class="sidenav-link" title="External">
                    <div>External</div>
                  </a>
              </li>
            </ul>
        </li> --}}
        <!-- announcement -->
        <li class="sidenav-item {{ Request::is('announcement*') ? ' active' : '' }}">
            <a href="{{route('announcement.index')}}" class="sidenav-link" title="Pengumuman"><i class="sidenav-icon las la-bullhorn"></i>
              <div>Pengumuman</div>
            </a>
        </li>
         {{-- <!-- badge -->
         <li class="sidenav-item {{ Request::is('badge*') ? ' active' : '' }}">
            <a href="{{route('announcement.index')}}" class="sidenav-link" title="Announcement"><i class="sidenav-icon oi oi-badge "></i>
              <div>Badges</div>
            </a>
        </li> --}}

        @role ('developer|administrator|internal')
        <!-- aktivitas -->
        <li class="sidenav-item{{ (Request::is('statistic') || Request::is('log*')) ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Laporan"><i class="sidenav-icon las la-calendar-day"></i>
              <div>Laporan</div>
            </a>

            <ul class="sidenav-menu">
                <!-- Activity Report -->
               {{-- <li class="sidenav-item {{ Request::is('report.activity*') ? ' active' : '' }}">
                <a href="#" class="sidenav-link" title="Activity Completion">
                  <div>Activity Completion</div>
                </a>
            </li> --}}
                <!-- statistik -->
                <li class="sidenav-item {{ Request::is('statistic*') ? ' active' : '' }}">
                    <a href="{{route('statistic.index')}}" class="sidenav-link" title="Statistik">
                        <div>Statistik</div>
                    </a>
                </li>

                <!-- log -->
                <li class="sidenav-item{{ Request::is('log*') ? ' active open' : '' }}">
                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="Logs">
                    <div>Logs</div>
                    </a>

                    <ul class="sidenav-menu">

                        <li class="sidenav-item{{ (Request::is('log') && !empty(Request::get('q'))) ? ' active' : '' }}">
                            <a href="{{route('log.index')}}?q={{ \Carbon\Carbon::now()->format('Y-m-d')}}" class="sidenav-link" title="Log Hari ini">
                            <div>Hari Ini</div>
                            </a>
                        </li>

                        <li class="sidenav-item{{ (Request::is('log') && empty(Request::get('q'))) ? ' active' : '' }}">
                            <a href="{{ route('log.index') }}" class="sidenav-link" title="Semua Log">
                            <div>Semua</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        @endrole

        @role ('developer|administrator')
        <!-- website -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">BELS WEBSITE</li>

        <!-- pages -->
        <li class="sidenav-item{{ (Request::is('page*')) ? ' active' : '' }}">
            <a href="{{ route('page.index') }}" class="sidenav-link" title="Pages"><i class="sidenav-icon las la-list"></i>
              <div>Halaman</div>
            </a>
        </li>
        <!-- artikel -->
        <li class="sidenav-item{{ (Request::is('artikel*') || Request::is('tags*')) ? ' active' : '' }}">
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
              <!-- sertifikat -->
              <li class="sidenav-item{{ Request::is('konfigurasi/sertifikat') ? ' active' : '' }}">
                <a href="{{ route('config.sertifikat') }}" class="sidenav-link" title="Sertifikat">
                  <div>Sertifikat</div>
                </a>
            </li>
            </ul>
        </li>
        @endrole

    </ul>
</div>

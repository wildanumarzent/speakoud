@php
    $masterOpen = (Request::is('instansi/internal*') || Request::is('instansi/mitra*') || Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*'));
    $userOpen = (Request::is('user*') || Request::is('internal*') || Request::is('mitra*') ||
                    Request::is('instruktur*') || Request::is('peserta*'));
    $course = (Request::is('program*') || Request::is('mata*') || Request::is('materi*'));
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
            <a href="{{ route('dashboard') }}" class="sidenav-link"><i class="sidenav-icon las la-tachometer-alt"></i><div>Dashboard</div></a>
        </li>

        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">MODULE</li>

        @role ('developer|administrator|internal|mitra')
        <li class="sidenav-item{{ $masterOpen ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-database"></i>
            <div>Data Master</div>
          </a>
            <ul class="sidenav-menu">
                @role ('developer|administrator|internal')
                <li class="sidenav-item{{ (Request::is('instansi/internal*') || Request::is('instansi/mitra*')) ? ' active open' : '' }}">
                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle">
                      <div>Instansi</div>
                    </a>

                    <ul class="sidenav-menu">
                        @role ('developer|administrator')
                        <li class="sidenav-item{{ Request::is('instansi/internal*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.internal.index') }}" class="sidenav-link">
                              <div>BPPT</div>
                            </a>
                        </li>
                        @endrole
                        <li class="sidenav-item{{ Request::is('instansi/mitra*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.mitra.index') }}" class="sidenav-link">
                              <div>Mitra</div>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                <li class="sidenav-item{{ $userOpen ? ' active open' : '' }}">
                  <a href="javascript:void(0)" class="sidenav-link sidenav-toggle">
                    <div>User Management</div>
                  </a>

                  <ul class="sidenav-menu">
                    @role ('developer|administrator')
                    <li class="sidenav-item{{ Request::is('user*') ? ' active' : '' }}">
                    <a href="{{ route('user.index') }}" class="sidenav-link">
                        <div>Users</div>
                    </a>
                    </li>
                    <li class="sidenav-item{{ Request::is('internal*') ? ' active' : '' }}">
                        <a href="{{ route('internal.index') }}" class="sidenav-link">
                            <div>User BPPT</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal')
                    <li class="sidenav-item{{ Request::is('mitra*') ? ' active' : '' }}">
                        <a href="{{ route('mitra.index') }}" class="sidenav-link">
                        <div>Mitra</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal|mitra')
                    <li class="sidenav-item{{ Request::is('instruktur*') ? ' active' : '' }}">
                        <a href="{{ route('instruktur.index') }}" class="sidenav-link">
                        <div>Instruktur</div>
                        </a>
                    </li>
                    <li class="sidenav-item{{ Request::is('peserta*') ? ' active' : '' }}">
                        <a href="{{ route('peserta.index') }}" class="sidenav-link">
                        <div>Peserta</div>
                        </a>
                    </li>
                    @endrole
                  </ul>
                </li>
                <li class="sidenav-item">
                    <a href="" class="sidenav-link">
                        <div>Grades Management</div>
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <li class="sidenav-item{{ Request::is('bank/data*') ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-server"></i>
            <div>Bank Data</div>
          </a>

          <ul class="sidenav-menu">
            @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
            <li class="sidenav-item{{ Request::is('bank/data/global*') ? ' active' : '' }}">
              <a href="{{ route('bank.data', ['type' => 'global']) }}" class="sidenav-link">
                <div>Global</div>
              </a>
            </li>
            @endrole
            @role ('mitra|instruktur_internal|instruktur_mitra')
            <li class="sidenav-item{{ Request::is('bank/data/personal*') ? ' active' : '' }}">
                <a href="{{ route('bank.data', ['type' => 'personal']) }}" class="sidenav-link">
                  <div>Personal</div>
                </a>
            </li>
            @endrole
          </ul>
        </li>
        @endrole

        @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <li class="sidenav-item{{ $course ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-book-open"></i>
            <div>Manage Courses</div>
          </a>

          <ul class="sidenav-menu">
            <li class="sidenav-item{{ (Request::is('program*') || Request::is('mata*') || Request::is('materi*')) ? ' active' : '' }}">
              <a href="{{ route('program.index') }}" class="sidenav-link">
                <div>Program Pelatihan</div>
              </a>
            </li>
            <li class="sidenav-item">
                <a href="" class="sidenav-link">
                  <div>Kalender Diklat</div>
                </a>
            </li>
            <li class="sidenav-item">
                <a href="" class="sidenav-link">
                  <div>Evaluasi</div>
                </a>
            </li>
          </ul>
        </li>
        @endrole

        @role ('developer|administrator|internal')
        <li class="sidenav-item">
            <a href="" class="sidenav-link"><i class="sidenav-icon las la-tags"></i>
              <div>Tags</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="" class="sidenav-link"><i class="sidenav-icon las la-comment"></i>
              <div>Komentar</div>
            </a>
        </li>

        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">WEBSITE</li>

        <li class="sidenav-item">
            <a href="" class="sidenav-link"><i class="sidenav-icon las la-newspaper"></i>
              <div>Artikel</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="" class="sidenav-link"><i class="sidenav-icon las la-icons"></i>
              <div>Widget</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="" class="sidenav-link"><i class="sidenav-icon las la-envelope"></i>
              <div>Inquiry</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-cog"></i>
              <div>Konfigurasi</div>
            </a>

            <ul class="sidenav-menu">
              <li class="sidenav-item">
                  <a href="" class="sidenav-link">
                    <div>Konten</div>
                  </a>
              </li>
              <li class="sidenav-item">
                  <a href="" class="sidenav-link">
                    <div>Strip Text</div>
                  </a>
              </li>
            </ul>
        </li>
        @endrole

    </ul>
</div>

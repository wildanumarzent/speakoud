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
            <a href="{{ route('dashboard') }}" class="sidenav-link" title="@lang('layout.menu.dashboard')"><i class="sidenav-icon las la-tachometer-alt"></i><div>@lang('layout.menu.dashboard')</div></a>
        </li>

        <!-- Module -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">@lang('layout.menu.header_1')</li>

        @role ('developer|administrator|internal|mitra')
        <!-- Data Master -->
        <li class="sidenav-item{{ $masterOpen ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.data_master')"><i class="sidenav-icon las la-database"></i>
            <div>@lang('layout.menu.data_master')</div>
          </a>
            <ul class="sidenav-menu">
                @role ('developer|administrator|internal')
                <!-- Instansi -->
                <li class="sidenav-item{{ (Request::is('instansi/internal*') || Request::is('instansi/mitra*')) ? ' active open' : '' }}">
                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.instansi.title')">
                      <div>@lang('layout.menu.instansi.title')</div>
                    </a>

                    <ul class="sidenav-menu">
                        @role ('developer|administrator')
                        <!-- Internal -->
                        <li class="sidenav-item{{ Request::is('instansi/internal*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.internal.index') }}" class="sidenav-link" title="@lang('layout.menu.instansi.bppt')">
                              <div>@lang('layout.menu.instansi.bppt')</div>
                            </a>
                        </li>
                        @endrole
                        <!-- Mitra -->
                        <li class="sidenav-item{{ Request::is('instansi/mitra*') ? ' active' : '' }}">
                            <a href="{{ route('instansi.mitra.index') }}" class="sidenav-link" title="@lang('layout.menu.instansi.mitra')">
                              <div>@lang('layout.menu.instansi.mitra')</div>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                <!-- User Management -->
                <li class="sidenav-item{{ $userOpen ? ' active open' : '' }}">
                  <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.user_management.title')">
                    <div>@lang('layout.menu.user_management.title')</div>
                  </a>

                  <ul class="sidenav-menu">
                    @role ('developer|administrator')
                    <!-- Users -->
                    <li class="sidenav-item{{ Request::is('user*') ? ' active' : '' }}">
                    <a href="{{ route('user.index') }}" class="sidenav-link" title="@lang('layout.menu.user_management.users')">
                        <div>@lang('layout.menu.user_management.users')</div>
                    </a>
                    </li>
                    <!-- User BPPT -->
                    <li class="sidenav-item{{ Request::is('internal*') ? ' active' : '' }}">
                        <a href="{{ route('internal.index') }}" class="sidenav-link" @lang('layout.menu.user_management.user_bppt')>
                            <div>@lang('layout.menu.user_management.user_bppt')</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal')
                    <!-- Mitra -->
                    <li class="sidenav-item{{ Request::is('mitra*') ? ' active' : '' }}">
                        <a href="{{ route('mitra.index') }}" class="sidenav-link" title="@lang('layout.menu.user_management.mitra')">
                        <div>@lang('layout.menu.user_management.mitra')</div>
                        </a>
                    </li>
                    @endrole
                    @role ('developer|administrator|internal|mitra')
                    <!-- Instruktur -->
                    <li class="sidenav-item{{ Request::is('instruktur*') ? ' active' : '' }}">
                        <a href="{{ route('instruktur.index') }}" class="sidenav-link" title="@lang('layout.menu.user_management.instruktur')">
                        <div>@lang('layout.menu.user_management.instruktur')</div>
                        </a>
                    </li>
                    <!-- Peserta -->
                    <li class="sidenav-item{{ Request::is('peserta*') ? ' active' : '' }}">
                        <a href="{{ route('peserta.index') }}" class="sidenav-link" title="@lang('layout.menu.user_management.peserta')">
                        <div>@lang('layout.menu.user_management.peserta')</div>
                        </a>
                    </li>
                    @endrole
                  </ul>
                </li>
                @role ('developer|administrator')
                <!-- grades -->
                <li class="sidenav-item{{ (Request::is('grades*')) ? ' active open' : '' }}">
                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.grades_management.title')">
                      <div>@lang('layout.menu.grades_management.title')</div>
                    </a>

                    <ul class="sidenav-menu">
                        <!-- letter -->
                        <li class="sidenav-item{{ Request::is('grades/letter*') ? ' active' : '' }}">
                            <a href="{{ route('grades.letter') }}" class="sidenav-link" title="@lang('layout.menu.grades_management.letter')">
                              <div>@lang('layout.menu.grades_management.letter')</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- tags -->
                <li class="sidenav-item{{ Request::is('tags*') ? ' active' : '' }}">
                    <a href="{{ route('tags.index') }}" class="sidenav-link" title="@lang('layout.menu.tags')">
                      <div>@lang('layout.menu.tags')</div>
                    </a>
                </li>
                <!-- komentar -->
                <li class="sidenav-item{{ Request::is('komentar*') ? ' active' : '' }}">
                    <a href="{{ route('komentar.index') }}" class="sidenav-link" title="@lang('layout.menu.komentar')">
                      <div>@lang('layout.menu.komentar')</div>
                    </a>
                </li>
                @endrole
            </ul>
        </li>
        @endrole

        @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <!-- bank data -->
        <li class="sidenav-item{{ Request::is('bank/data*') ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.bank_data.title')"><i class="sidenav-icon las la-server"></i>
            <div>@lang('layout.menu.bank_data.title')</div>
          </a>

          <ul class="sidenav-menu">
            @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
            <!-- global -->
            <li class="sidenav-item{{ Request::is('bank/data/global*') ? ' active' : '' }}">
              <a href="{{ route('bank.data', ['type' => 'global']) }}" class="sidenav-link" title="@lang('layout.menu.bank_data.global')">
                <div>@lang('layout.menu.bank_data.global')</div>
              </a>
            </li>
            @endrole
            @role ('mitra|instruktur_internal|instruktur_mitra')
            <!-- personal -->
            <li class="sidenav-item{{ Request::is('bank/data/personal*') ? ' active' : '' }}">
                <a href="{{ route('bank.data', ['type' => 'personal']) }}" class="sidenav-link" title="@lang('layout.menu.bank_data.personal')">
                  <div>@lang('layout.menu.bank_data.personal')</div>
                </a>
            </li>
            @endrole
          </ul>
        </li>
        @endrole

        @role ('administrator|internal|mitra')
        <!-- bank soal -->
        <li class="sidenav-item{{ Request::is('soal*') ? ' active' : '' }}">
            <a href="{{ route('soal.kategori') }}" class="sidenav-link" title="@lang('layout.menu.bank_soal')"><i class="sidenav-icon las la-spell-check"></i>
              <div>@lang('layout.menu.bank_soal')</div>
            </a>
        </li>
        @endrole

        @role ('developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
        <!-- courses -->
        <li class="sidenav-item{{ $course ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.management_course.title')"><i class="sidenav-icon las la-book-open"></i>
            <div>@lang('layout.menu.management_course.title')</div>
          </a>

          <ul class="sidenav-menu">
            <!-- program -->
            <li class="sidenav-item{{ (Request::is('program*') || Request::is('mata*') || Request::is('materi*') || Request::is('course*')) ? ' active' : '' }}">
              <a href="{{ route('program.index') }}" class="sidenav-link" title="@lang('layout.menu.management_course.program')">
                <div>@lang('layout.menu.management_course.program')</div>
              </a>
            </li>
            @role ('developer|administrator|internal|mitra')
            <!-- jadwal -->
            <li class="sidenav-item{{ (Request::is('jadwal*')) ? ' active' : '' }}">
                <a href="{{ route('jadwal.index') }}" class="sidenav-link" title="@lang('layout.menu.management_course.jadwal')">
                  <div>@lang('layout.menu.management_course.jadwal')</div>
                </a>
            </li>
            @endrole
            <!-- kalender -->
            <li class="sidenav-item{{ (Request::is('kalender*')) ? ' active' : '' }}">
                <a href="{{route('kalender.index')}}" class="sidenav-link" title="@lang('layout.menu.management_course.kalender')">
                  <div>@lang('layout.menu.management_course.kalender')</div>
                </a>
            </li>
          </ul>
        </li>
        @endrole

        @role ('peserta_internal|peserta_mitra')
        <!-- program -->
        <li class="sidenav-item {{ Request::is('course*') ? 'active' : '' }}">
            <a href="{{route('course.list')}}" class="sidenav-link" title="@lang('layout.menu.management_course.program')"><i class="sidenav-icon las la-book-open"></i>
              <div>@lang('layout.menu.management_course.program')</div>
            </a>
        </li>
        @endrole

        <!-- sertifikasi -->
        <li class="sidenav-item">
            <a href="" class="sidenav-link" title="@lang('layout.menu.sertifikasi')"><i class="sidenav-icon las la-certificate"></i>
              <div>@lang('layout.menu.sertifikasi')</div>
            </a>
        </li>
        <!-- announcement -->
        <li class="sidenav-item {{ Request::is('announcement*') ? ' active' : '' }}">
            <a href="{{route('announcement.index')}}" class="sidenav-link" title="@lang('layout.menu.announcement')"><i class="sidenav-icon las la-bullhorn"></i>
              <div>@lang('layout.menu.announcement')</div>
            </a>
        </li>
        <!-- aktivitas -->
        <li class="sidenav-item">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.aktivitas.title')"><i class="sidenav-icon las la-street-view"></i>
              <div>@lang('layout.menu.aktivitas.title')</div>
            </a>

            <ul class="sidenav-menu">
                <!-- statistik -->
              <li class="sidenav-item {{ Request::is('statistic*') ? ' active' : '' }}">
                  <a href="{{route('statistic.index')}}" class="sidenav-link" title="@lang('layout.menu.aktivitas.statistik')">
                    <div>@lang('layout.menu.aktivitas.statistik')</div>
                  </a>
              </li>
              <!-- log -->
              <li class="sidenav-item">
                  <a href="" class="sidenav-link" title="@lang('layout.menu.aktivitas.log')">
                    <div>@lang('layout.menu.aktivitas.log')</div>
                  </a>
              </li>
            </ul>
        </li>
        <!-- report -->
        <li class="sidenav-item">
            <a href="" class="sidenav-link" title="@lang('layout.menu.report')"><i class="sidenav-icon las la-calendar-day"></i>
              <div>@lang('layout.menu.report')</div>
            </a>
        </li>

        @role ('developer|administrator')
        <!-- website -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">@lang('layout.menu.header_2')</li>

        <!-- pages -->
        <li class="sidenav-item{{ (Request::is('page*')) ? ' active' : '' }}">
            <a href="{{ route('page.index') }}" class="sidenav-link" title="@lang('layout.menu.pages')"><i class="sidenav-icon las la-list"></i>
              <div>@lang('layout.menu.pages')</div>
            </a>
        </li>
        <!-- artikel -->
        <li class="sidenav-item{{ (Request::is('artikel*')) ? ' active' : '' }}">
            <a href="{{ route('artikel.index') }}" class="sidenav-link" title="@lang('layout.menu.artikel')"><i class="sidenav-icon las la-newspaper"></i>
              <div>@lang('layout.menu.artikel')</div>
            </a>
        </li>
        <!-- banner -->
        <li class="sidenav-item{{ (Request::is('banner*')) ? ' active' : '' }}">
            <a href="{{ route('banner.index') }}" class="sidenav-link" title="@lang('layout.menu.banner')"><i class="sidenav-icon las la-images"></i>
              <div>@lang('layout.menu.banner')</div>
            </a>
        </li>
        <!-- inquiry -->
        <li class="sidenav-item{{ (Request::is('inquiry*')) ? ' active' : '' }}">
            <a href="{{route('inquiry.index')}}" class="sidenav-link" title="@lang('layout.menu.inquiry')"><i class="sidenav-icon las la-envelope"></i>
              <div>@lang('layout.menu.inquiry')</div>
              @if ($inquiry['total_contact'] > 0)
              <div class="pl-1 ml-auto">
                  <div class="badge badge-danger">{{ $inquiry['total_contact'] }}</div>
              </div>
              @endif
            </a>
        </li>
        <!-- konfig -->
        <li class="sidenav-item{{ Request::is('konfigurasi*') ? ' open active' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('layout.menu.konfigurasi.title')"><i class="sidenav-icon las la-cog"></i>
              <div>@lang('layout.menu.konfigurasi.title')</div>
            </a>

            <ul class="sidenav-menu">
              <!-- konten -->
              <li class="sidenav-item{{ (Request::is('konfigurasi/konten')) ? ' active' : '' }}">
                  <a href="{{ route('config.index') }}" class="sidenav-link" title="@lang('layout.menu.konfigurasi.konten')">
                    <div>@lang('layout.menu.konfigurasi.konten')</div>
                  </a>
              </li>
              <!-- strip -->
              <li class="sidenav-item{{ Request::is('konfigurasi/strip') ? ' active' : '' }}">
                  <a href="{{ route('config.strip') }}" class="sidenav-link" title="@lang('layout.menu.konfigurasi.strip')">
                    <div>@lang('layout.menu.konfigurasi.strip')</div>
                  </a>
              </li>
            </ul>
        </li>
        @endrole

    </ul>
</div>

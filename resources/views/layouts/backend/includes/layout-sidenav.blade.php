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
        <!-- Data Master -->
        <li class="sidenav-item{{ (Request::is('user*') || Request::is('internal*') || Request::is('mitra*') || Request::is('instruktur*') || Request::is('peserta*')) ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-users"></i>
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
        @endrole

    </ul>
</div>

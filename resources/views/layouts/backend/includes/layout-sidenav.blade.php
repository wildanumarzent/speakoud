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
        @role ('developer|administrator')
        <!-- Data Master -->
        <li class="sidenav-item{{ (Request::is('user*')) ? ' active open' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon las la-users"></i>
            <div>User Management</div>
          </a>

          <ul class="sidenav-menu">
            <li class="sidenav-item{{ Request::is('user*') ? ' active' : '' }}">
              <a href="{{ route('user.index') }}" class="sidenav-link">
                <div>Users</div>
              </a>
            </li>
            <li class="sidenav-item{{ Request::is('internal*') ? ' active' : '' }}">
                <a href="{{ route('user.index') }}" class="sidenav-link">
                  <div>Internal</div>
                </a>
            </li>
            <li class="sidenav-item{{ Request::is('mitra*') ? ' active' : '' }}">
                <a href="{{ route('user.index') }}" class="sidenav-link">
                  <div>Mitra</div>
                </a>
            </li>
            <li class="sidenav-item{{ Request::is('guru*') ? ' active' : '' }}">
                <a href="{{ route('user.index') }}" class="sidenav-link">
                  <div>Guru</div>
                </a>
            </li>
            <li class="sidenav-item{{ Request::is('murid*') ? ' active' : '' }}">
                <a href="{{ route('user.index') }}" class="sidenav-link">
                  <div>Murid</div>
                </a>
            </li>
          </ul>
        </li>
        @endrole

    </ul>
</div>

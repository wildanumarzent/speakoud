<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-navbar-theme container-p-x"
    id="layout-navbar">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <a href="{{ route('home') }}" class="navbar-brand app-brand demo d-lg-none py-0 mr-0">
        <span class="app-brand-logo demo bg-white">
            <img src="{{ asset(config('addon.images.logo')) }}" style="width:50px;height:50px;object-fit:cover">
        </span>
        <span class="app-brand-text demo font-weight-normal ml-2">@lang('strip.title_header')</span>
    </a>



    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
      <span class="navbar-toggler-icon"></span>
    </button> -->
        <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-3">
          <a class="nav-item nav-link text-large px-0 mr-lg-4" href="javascript:void(0)">
            <i class="las la-bars"></i>
          </a>
        </div>

    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
        <!-- Divider -->
        <!-- <hr class="d-lg-none w-100 my-2"> -->
        <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
        <div class="navbar-nav align-items-lg-center d-none d-lg-block">
          <!-- Search -->
          <label class="nav-item navbar-text navbar-search-box p-0 active">
            @lang('layout.header.title') &nbsp;
            <a href="{{ route('home') }}" target="_blank" title="Website"><i class="las la-external-link-alt"></i></a>
          </label>
        </div>

        <div class="navbar-nav align-items-lg-center ml-lg-auto">

          <div class="demo-navbar-user nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                <img src="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" alt class="d-block ui-w-30 rounded-circle">
                <span class="px-1 mr-lg-2 ml-2 ml-lg-0 d-none d-lg-block">{{ Str::limit(auth()->user()->name, 30) }}</span>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <span class="dropdown-item name-user d-block d-lg-none">{{ auth()->user()->name }}</span>
              <a href="{{ route('profile') }}" class="dropdown-item" title="@lang('layout.header.profile')">
                  <i class="las la-user-circle"></i>
                  &nbsp; @lang('layout.header.profile')
              </a>
              <div class="dropdown-divider"></div>
              <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="@lang('layout.header.logout')">
                  <i class="las la-sign-out-alt"></i>
                &nbsp; @lang('layout.header.logout')
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </div>
        </div>
    </div>

</nav>

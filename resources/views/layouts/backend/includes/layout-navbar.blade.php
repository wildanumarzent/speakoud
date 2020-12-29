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
            BPPT E-LEARNING SYSTEM &nbsp;
            <a href="{{ route('home') }}" target="_blank" title="Website"><i class="las la-external-link-alt"></i></a>
          </label>
        </div>

        <div class="navbar-nav align-items-lg-center ml-lg-auto">

            <div class="demo-navbar-notifications nav-item dropdown mr-lg-3">
                <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                  <i class="las la-bell navbar-icon align-middle"></i>
                  <span class="badge badge-primary badge-dot indicator"></span>
                  <span class="d-lg-none align-middle">&nbsp; Notifications</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="bg-primary text-center text-white font-weight-bold p-3">
                    4 New Notifications
                  </div>
                  <div class="list-group list-group-flush">

                    <a href="javascript:void(0)" class="list-group-item list-group-item-action media d-flex align-items-center">
                      <div class="ui-icon ui-icon-sm ion ion-md-warning bg-warning border-0 text-body"></div>
                      <div class="media-body line-height-condenced ml-3">
                        <div class="text-body">99% server load</div>
                        <div class="text-light small mt-1">
                          Etiam nec fringilla magna. Donec mi metus.
                        </div>
                        <div class="text-light small mt-1">
                          20h ago
                        </div>
                      </div>
                    </a>

                  </div>

                  <a href="javascript:void(0)" class="d-block text-center text-light small p-2 my-1">Show all notifications</a>
                </div>
            </div>

          <!-- Divider -->
          <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>

          <div class="demo-navbar-user nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                <img src="{{ auth()->user()->getPhoto(auth()->user()->photo['filename']) }}" alt class="d-block ui-w-30 rounded-circle">
                <span class="px-1 mr-lg-2 ml-2 ml-lg-0 d-none d-lg-block">{{ Str::limit(auth()->user()->name, 30) }}</span>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <span class="dropdown-item name-user d-block d-lg-none">{{ auth()->user()->name }}</span>
              <a href="{{ route('profile') }}" class="dropdown-item" title="Profile">
                  <i class="las la-user-circle"></i>
                  &nbsp; Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Log Out">
                  <i class="las la-sign-out-alt"></i>
                &nbsp; Log Out
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </div>
        </div>
    </div>

</nav>

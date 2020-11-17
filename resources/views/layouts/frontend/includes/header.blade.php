<header>
    <div class="main-header">
        <div class="container-fluid">
            <div class="menubar-flex">
                <div class="menubar-left">
                    <a href="{{ route('home') }}" class="main-logo" title="Beranda">
                        <div class="logo">
                            <img src="{{ asset(config('addon.images.logo')) }}" alt="Logo BPPT">
                        </div>
                        <h5>@lang('strip.title_header')</h5>
                    </a>
                </div>
                <div class="menubar-center">
                    <nav class="main-nav">
                        <ul class="list-nav">
                            <li class="{{ empty(Request::segment(1)) ? 'current-nav' : '' }}"><a href="{{ route('home') }}" title="Home">Home</a></li>

                            <li class="has-dropdown {{ Request::is('course*') ? 'current-nav' : '' }}">
                                <a href="#!">Program Pelatihan</a>
                                <ul class="dropdown">
                                    <li class="btn-back"><a href="#!">back</a></li>
                                    @foreach ($menu['program_pelatihan'] as $program)
                                    <li class="has-sub-dropdown is-hidden">
                                        <a href="#!">{!! $program->judul !!}</a>
                                        <ul class="sub-dropdown">
                                            <li class="btn-back"><a href="#!">back</a></li>
                                            @foreach ($program->mataPublish as $mata)
                                            <li><a href="{{ route('course.detail', ['id' => $mata->id]) }}" title="{!! $mata->judul !!}">{!! $mata->judul !!}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="list-jadwal.html">Jadwal</a></li>
                            <li><a href="list-artikel.html">Artikel</a></li>
                            @foreach ($menu['inquiry'] as $inquiry)
                            <li class="{{ Request::is('inquiry*') ? 'current-nav' : '' }}"><a href="{{ route('inquiry.read', ['slug' => $inquiry->slug]) }}">{!! $inquiry->name !!}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                    <div class="navigation-burger">
                        <span></span>
                    </div>
                </div>
                <div class="menubar-right">
                    @if (Auth::guard()->check())
                    <div class="nav-item account has-dropdwon">
                        <a href="#!" class="user">
                            <div class="box-user user-profile" id="user-id">AM</div>
                        </a>
                        <ul class="dropdown">
                            <li>
                                <a href="#!">
                                    <span class="name" id="name">{{ auth()->user()->name }}</span>
                                    <span class="text-sm">{{ auth()->user()->email }}</span>
                                </a>
                            </li>
                            <li><a href="{{ route('dashboard') }}" title="Dashboard">Dashboard</a></li>
                            <li><a href="{{ route('profile') }}" title="Profile">Profile</a></li>
                            <li>
                                <a  href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-front').submit();" title="Log Out">Log Out</a>
                                <form id="logout-form-front" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <div class="nav-item account">
                        <a href="{{ route('login') }}" class="user" title="Login">
                            <span>Login</span>
                            <div class="box-user">
                                <i class="las la-user"></i>
                            </div>
                        </a>
                    </div>
                    @endif
                    <div class="nav-item navigation-bar">
                        <div class="navigation-label">

                        </div>
                        <div class="navigation-burger">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

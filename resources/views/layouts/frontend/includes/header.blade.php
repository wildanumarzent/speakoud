<header>
    <div class="main-header">
        <div class="container-fluid">
            <div class="menubar-flex">
                <div class="menubar-left">
                    <a href="{{ route('home') }}" class="main-logo" title="@lang('layout.menu.home')">
                        <div class="logo">
                            <img src="{{ asset(config('addon.images.logo')) }}" alt="Logo BPPT">
                        </div>
                        <h5>@lang('strip.title_header')</h5>
                    </a>
                </div>
                <div class="menubar-center">
                    <nav class="main-nav">
                        <ul class="list-nav">
                            <li class="{{ empty(Request::segment(1)) ? 'current-nav' : '' }}"><a href="{{ route('home') }}" title="@lang('layout.menu.home')">@lang('layout.menu.home')</a></li>

                            <li class="has-dropdown {{ Request::is('course/list*') ? 'current-nav' : '' }}">
                                <a href="#!" title="Program Pelatihan">Program Pelatihan</a>
                                <ul class="dropdown">
                                    <li class="btn-back"><a href="#!" title="kembali">kembali</a></li>
                                    @foreach ($menu['program_pelatihan'] as $program)
                                    <li class="has-sub-dropdown is-hidden">
                                        <a href="#!" title="{!! $program->judul !!}">{!! $program->judul !!}</a>
                                        <ul class="sub-dropdown">
                                            <li class="btn-back"><a href="#!">kembali</a></li>
                                            @foreach ($program->mataPublish as $mata)
                                            <li><a href="{{ route('course.detail', ['id' => $mata->id]) }}" title="{!! $mata->judul !!}">{!! $mata->judul !!}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            {{-- <li class="{{ Request::is('course/jadwal*') ? 'current-nav' : '' }}"><a href="{{ route('course.jadwal') }}" title="Kalender Pelatihan">Agenda</a></li> --}}
                            <li class="{{ Request::is('content/artikel*') ? 'current-nav' : '' }}"><a href="{{ route('artikel.list') }}" title="Artikel">Artikel</a></li>
                            @foreach ($menu['inquiry'] as $inquiry)
                            <li class="{{ Request::is('inquiry*') ? 'current-nav' : '' }}"><a href="{{ route('inquiry.read', ['slug' => $inquiry->slug]) }}" title="{!! $inquiry->name !!}">{!! $inquiry->name !!}</a></li>
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
                        <a href="#!" class="user" title="{{ auth()->user()->name }}">
                            @php
                                $name = auth()->user()->name;
                                $match = preg_split('/([\s\n\r]+)/u', $name, null, PREG_SPLIT_DELIM_CAPTURE);
                                if (count($match) == 1) {
                                    $join = substr($match[0], 0, 1);
                                } else {
                                    $join = substr($match[0], 0, 1).substr($match[2], 0, 1);
                                }
                            @endphp
                            <div class="box-user user-profile" id="user-id">{!! $join !!}</div>
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

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
                            <li class="{{ empty(Request::segment(1)) ? 'current-nav' : '' }}"><a href="{{ route('home') }}" title="Beranda">Home</a></li>
                            
                            <li class="has-dropdown">
                                <a href="#!">Program Pelatihan</a>
                                <ul class="dropdown">
                                    <li class="btn-back"><a href="#!">back</a></li>
                                    <li class="has-sub-dropdown is-hidden">
                                        <a href="#!">Diklat Fungsional</a>
                                        <ul class="sub-dropdown">
                                            <li class="btn-back"><a href="#!">back</a></li>
                                            <li><a href="">Jabatan Fungsional Perekayasa</a></li>
                                            <li><a href="">Jabatan Fungsional Teknisi Litkayasa</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-sub-dropdown is-hidden">
                                        <a href="#!">Diklat Teknis</a>
                                        <ul class="sub-dropdown">
                                            <li class="btn-back"><a href="#!">back</a></li>
                                            <li><a href="">TOEFL ITP Preparation Course</a></li>
                                            <li><a href="">Penulisan Karya Tulis Ilmiah</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="list-jadwal.html">Jadwal</a></li>
                            <li><a href="list-artikel.html">Artikel</a></li>
                            <li><a href="kontak.html">Kontak</a></li>
                        </ul>
                    </nav>
                    <div class="navigation-burger">
                        <span></span>
                    </div>
                </div>
                <div class="menubar-right">
                    <div class="nav-item account">
                        <a href="{{ route('login') }}" class="user" title="Login">
                            <span>Login</span>
                            <div class="box-user">
                                <i class="las la-user"></i>
                            </div>
                        </a>
                    </div>
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
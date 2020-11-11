<footer>
    <div class="footer">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}" class="logo" title="Beranda">
                                <img src="{{ asset(config('addon.images.logo')) }}" alt="Logo BPPT">
                            </a>
                            <h5>@lang('strip.title_header')</h5>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5>@lang('strip.footer_title_1')</h5>
                                    <ul>
                                        <li>
                                            <a href="">Pelatihan Teknis</a>
                                        </li>
                                        <li>
                                            <a href="">Pelatihan Fungsional</a>
                                        </li>
                                        <li>
                                            <a href="">E-Referensi</a>
                                        </li>
                                        <li>
                                            <a href="">Panduan Penggunaan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5>@lang('strip.footer_title_2')</h5>
                                    <ul>
                                        <li>
                                            <a href="">About Us</a>
                                        </li>
                                        <li>
                                            <a href="">Terms Of Use</a>
                                        </li>
                                        <li>
                                            <a href="">Privacy Policy</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5>@lang('strip.footer_title_3')</h5>
                                    <ul>
                                        <li>
                                            {{ $configuration['address'] }}
                                        </li>
                                        <li>
                                            {{ $configuration['phone'] }}
                                        </li>
                                        <li>
                                            <a href="mailto:{{ $configuration['email'] }}">{{ $configuration['email'] }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-xl-between">
                    <div class="f-widget copyright">
                        Copyright © {{ now()->format('Y') }} Pusat Pembinaan, Pendidikan dan Pelatihan BPPT
                    </div>
                    <div class="f-widget developer">
                        Developed By 
                        <a href="https://www.4visionmedia.com/" target="_blank" class="logo-4vm" title="Perusahaan Jasa Pembuatan Website Software Aplikasi Desain Video & Konsultan IT">
                            <img src="{{ asset('assets/tmplts_frontend/images/logo-4vm.svg') }}" alt="Logo 4 Vision Media">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
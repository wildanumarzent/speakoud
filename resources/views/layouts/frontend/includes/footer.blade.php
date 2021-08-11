<footer>
    <div class="footer">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}" class="logo" title="Home">
                                {{-- <img src="{{ asset(config('addon.images.logo')) }}" title="BPPT" alt="Logo BPPT"> --}}
                                {{-- SPEAKOUD --}}
                            </a>
                            <h5>E-learning Manajemen System</h5>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5>@lang('strip.footer_title_1')</h5>
                                    <ul>
                                        @foreach ($pages['layanan'] as $layanan)
                                        <li>
                                            <a href="{{ route('page.read', ['id' => $layanan->id, 'slug' => $layanan->slug]) }}" title="{!! $layanan->judul !!}">{!! $layanan->judul !!}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5>@lang('strip.footer_title_2')</h5>
                                    <ul>
                                        @foreach ($pages['quick_link'] as $quickLink)
                                        <li>
                                            <a href="{{ route('page.read', ['id' => $quickLink->id, 'slug' => $quickLink->slug]) }}" title="{!! $quickLink->judul !!}">{!! $quickLink->judul !!}</a>
                                        </li>
                                        @endforeach
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
                                            {{ $configuration['fax'] }} <br>
                                            {{ $configuration['phone'] }} <br>
                                            {{ $configuration['phone_2'] }} <br>
                                        </li>
                                        <li>
                                            <a href="mailto:{{ $configuration['email'] }}" title="Email">{{ $configuration['email'] }}</a> <br>
                                            <a href="mailto:{{ $configuration['email_2'] }}" title="Email 2">{{ $configuration['email_2'] }}</a> <br>
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
                <div class="d-flex align-items-center justify-content-xl-center">
                    <div class="f-widget copyright">
                        Copyright © {{ now()->format('Y') }} 

SPEAKOUD by Sinergi Digital Powered by Sinergi Consulting

                    </div>
                    {{-- <div class="f-widget developer">
                        Developed By
                        <a href="https://www.4visionmedia.com/" target="_blank" class="logo-4vm" title="Perusahaan Jasa Pembuatan Website Software Aplikasi Desain Video & Konsultan IT">
                            <img src="{{ asset('assets/tmplts_frontend/images/logo-4vm.svg') }}" alt="Logo 4 Vision Media">
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</footer>

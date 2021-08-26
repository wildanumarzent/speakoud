<footer>
    <div class="footer">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-logo">
                            
                            <h5>
                                <a href="{{ route('home') }}" class="logo text-white" title="Home">
                                {{-- <img src="{{ asset(config('addon.images.logo')) }}" title="BPPT" alt="Logo BPPT"> --}}
                                 SPEAKOUD
                               </a> 
                            </h5> 
                            
                            
                            {{-- <h5 style="color: white">E-learning Manajemen System</h5> --}}
                        </div>
                        <ul>
                            <li class="text-white" style="font-family: sans-serif; margin-bottom: 10px"><strong>(+62) 811 977 6386</strong></li>
                            <li class="text-white" style="font-family: sans-serif; margin-bottom: 30px"><strong>contact@sinergi-digital.com</strong></li>
                        </ul>
                       
                        
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5 style="color: white">
                                        @lang('strip.footer_title_1')
                                        {{-- Afiliasi Sinergi --}}
                                    </h5>
                                    <ul>
                                        {{-- @foreach ($pages['layanan'] as $layanan) --}}
                                        {{-- <li>
                                            <a href="{{ route('page.read', ['id' => $layanan->id, 'slug' => $layanan->slug]) }}" title="{!! $layanan->judul !!}" style="color: white">{!! $layanan->judul !!}</a>
                                        </li> --}}
                                        {{-- @endforeach --}}
                                        <li>
                                              <a href="" title="" style="color: white;">Sinergi Digital</a>
                                        </li>
                                        <li>
                                              <a href="" title="" style="color: white; font-family: ">Sinergi Consulting</a>
                                        </li>
                                        <li>
                                              <a href="" title="" style="color: white; font-family: ">e-Learning Platform</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5 style="color: white">
                                        @lang('strip.footer_title_2')
                            
                                    </h5>
                                    <ul>
                                        {{-- @foreach ($pages['quick_link'] as $quickLink) --}}
                                        <li>
                                            <a href="" style="color: white;font-family:  ">Facebook</a>
                                        </li>
                                        <li>
                                            <a href="" title="" style="color: white; font-family: ">Instagram</a>
                                        </li>
                                        <li>
                                            <a href="" title="" style="color: white; font-family: " >Whatsapp</a>
                                        </li>
                                        {{-- @endforeach --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="f-widget">
                                    <h5 style="color: white ; font-family: ">@lang('strip.footer_title_3')</h5>
                                    <ul>
                                        <li style="color: white; font-family: ">
                                            {{-- {{ $configuration['address'] }} --}}
                                            Disclaimer
                                        </li>
                                        <li style="color: white; font-family: ">
                                            {{-- {{ $configuration['fax'] }} <br> --}}
                                            Kebijakan Privasi
                                            {{-- {{ $configuration['phone'] }} <br>
                                            {{ $configuration['phone_2'] }} <br> --}}
                                        </li >
                                        <li style="color: white; font-family: ">
                                            
                                            Terms & Conditions
                                            {{-- <a href="mailto:{{ $configuration['email'] }}" title="Email" style="color: white">{{ $configuration['email'] }}</a> <br>
                                            <a href="mailto:{{ $configuration['email_2'] }}" title="Email 2" style="color: white">{{ $configuration['email_2'] }}</a> <br> --}}
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
                    <div class="f-widget copyright" style="color: white">
                        Copyright © {{ now()->format('Y') }} 
                        SPEAKOUD by Sinergi Consulting Powered by Four vision Media
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

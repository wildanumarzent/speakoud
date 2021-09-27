<footer>
    <div class="footer">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer-logo">

                        <a href="{{ route('home') }}" class="logo" title="Home">
                            <img src="{{ asset(config('addon.images.logo')) }}" title="SPEAKOUD" alt="SPEAKOUD">
                        </a>
                            {{-- <h5>E-learning Manajemen System</h5> --}}
                        </div>
                        {{-- <ul>
                            <li class="text-white" style="font-family: sans-serif; margin-bottom: 10px"><strong>(+62) 8121085805</strong></li>
                            <li class="text-white" style="font-family: sans-serif; margin-bottom: 30px"><strong>contact@speakoud.com</strong></li>
                        </ul>  --}}
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="f-widget">
                                    <h5>
                                        {{-- @lang('strip.footer_title_1') --}}
                                        {{-- Afiliasi Sinergi --}}
                                        SPEAKOUD
                                    </h5>
                                    <ul>
                                        {{-- @foreach ($pages['layanan'] as $layanan) --}}
                                        {{-- <li>
                                            <a href="{{ route('page.read', ['id' => $layanan->id, 'slug' => $layanan->slug]) }}" title="{!! $layanan->judul !!}">{!! $layanan->judul !!}</a>
                                        </li> --}}
                                        {{-- @endforeach --}}
                                        <li>
                                            <a href="https://api.whatsapp.com/send?phone=+628121085805" target="_blank" title="WA">(+62) 8121085805</a>
                                        </li>
                                        <li>
                                            <a href="mailto:contact@speakoud.com" title="Kirim Email" target="_blank">contact@speakoud.com</a>
                                        </li>
                                        {{-- <li>
                                              <a href="" title="">e-Learning Platform</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="f-widget">
                                    <h5>
                                        @lang('strip.footer_title_2')

                                    </h5>
                                    <ul>
                                        {{-- @foreach ($pages['quick_link'] as $quickLink) --}}
                                        <li>
                                            <a href="https://www.facebook.com/PT.SinergiSatuSolusi/" target="_blank">Facebook</a>
                                        </li>
                                        <li>
                                            <a href="https://instagram.com/sinergi.consulting?utm_medium=copy_link" target="_blank" title="">Instagram</a>
                                        </li>
                                        <li>
                                            <a href="https://api.whatsapp.com/send?phone=+628121085805" target="_blank" title="" >Whatsapp</a>
                                        </li>
                                        {{-- @endforeach --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="f-widget">
                                    {{-- <h5 >@lang('strip.footer_title_3')</h5> --}}
                                    <h5 >KETENTUAN PENGGUNAAN</h5>
                                    <ul>
                                        <li>
                                            {{-- {{ $configuration['address'] }} --}}
                                            <a href="{{route('page.read',['id'=>6,'slug'=>'disclaimer'])}}">Disclaimer</a>
                                        </li>
                                        <li>
                                            {{-- {{ $configuration['fax'] }} <br> --}}
                                            <a href="{{route('page.read',['id'=>5,'slug'=>'kebijakan-privasi'])}}">Kebijakan Privasi</a>
                                            {{-- {{ $configuration['phone'] }} <br>
                                            {{ $configuration['phone_2'] }} <br> --}}
                                        </li >
                                        <li>

                                            <a href="{{route('page.read',['id'=>8,'slug'=>'syarat-dan-ketentuan'])}}">Terms & Conditions</a>
                                            {{-- <a href="mailto:{{ $configuration['email'] }}" title="Email">{{ $configuration['email'] }}</a> <br>
                                            <a href="mailto:{{ $configuration['email_2'] }}" title="Email 2">{{ $configuration['email_2'] }}</a> <br> --}}
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
                        SPEAKOUD by Sinergi Consulting Powered by <a href="https://www.4visionmedia.com/id" target="_blank">Four vision Media</a>
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

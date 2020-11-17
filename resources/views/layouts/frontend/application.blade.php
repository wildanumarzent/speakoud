<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="theme-color" content="#064ad0"/>
        <meta name="title" content="{!! isset($data['meta_title']) ? Str::limit(strip_tags($data['meta_title']), 69) : $configuration['meta_title'] !!}">
        <meta name="description" content="{!! isset($data['meta_description']) ? Str::limit(strip_tags($data['meta_description']), 155) : $configuration['meta_description'] !!}">
        <meta name="keywords" content="{!! isset($data['meta_keywords']) ? Str::limit(strip_tags($data['meta_keywords']), 155) : $configuration['meta_keywords'] !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $configuration['website_name'] }} {{ isset($title) ? ': '.$title : '' }}</title>

        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/tmplts_backend/images/favicon.ico') }}" sizes="32x32">

        <meta name="robots" content="index,follow" />
        <meta name="googlebot" content="index,follow" />
        <meta name="revisit-after" content="2 days" />
        <meta name="author" content="4 Vision Media">
        <meta name="expires" content="never" />

        <meta name="google-site-verification" content="{!! $configuration['google_verification'] !!}" />
        <meta name="p:domain_verify" content="{!! $configuration['domain_verification'] !!}"/>

        <meta property="og:locale" content="{{ app()->getlocale().'_'.strtoupper(app()->getlocale()) }}" />
        <meta property="og:site_name" content="{{ route('home') }}">
        <meta property="og:title" content="{{ $configuration['website_name'] }} {{ isset($title) ? ': '.$title : '' }}"/>
        <meta property="og:url" name="url" content="{{ url()->full() }}">
        <meta property="og:description" content="{!! isset($data['meta_description']) ? Str::limit(strip_tags($data['meta_description']), 155) : $configuration['meta_description'] !!}"/>
        <meta property="og:image" content="{!! isset($data['cover']) ? $data['cover'] : asset('assets/tmplts_backend/images/open-graph.jpg') !!}"/>
        <meta property="og:image:width" content="650" />
        <meta property="og:image:height" content="366" />
        <meta property="og:type" content="website" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $configuration['website_name'] }} {{ isset($title) ? ': '.$title : '' }}">
        <meta name="twitter:site" content="{{ url()->full() }}">
        <meta name="twitter:creator" content="{!! isset($data['creator']) ? $data['creator'] : 'administrator' !!}">
        <meta name="twitter:description" content="{!! isset($data['meta_description']) ? Str::limit(strip_tags($data['meta_description']), 155) : $configuration['meta_description'] !!}">
        <meta name="twitter:image" content="{!! isset($data['cover']) ? $data['cover'] : asset('assets/tmplts_backend/images/open-graph.jpg') !!}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

		<!-- Css Global -->
		<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/line-awesome.css') }}">

        <!-- Css Additional -->
        <style type="text/css">
            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background-color: rgba(255,255,255,0.5);
            }
            .preloader .loading {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                font: 14px arial;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/spinkit/spinkit.css') }}">
        @yield('styles')

        {!! $configuration['google_analytics'] !!}

    </head>

	<body>

        <div class="preloader">
            <div class="loading">
                <div class="col-xs-12">
                    <div class="sk-cube-grid sk-primary">
                        <div class="sk-cube sk-cube1"></div>
                        <div class="sk-cube sk-cube2"></div>
                        <div class="sk-cube sk-cube3"></div>
                        <div class="sk-cube sk-cube4"></div>
                        <div class="sk-cube sk-cube5"></div>
                        <div class="sk-cube sk-cube6"></div>
                        <div class="sk-cube sk-cube7"></div>
                        <div class="sk-cube sk-cube8"></div>
                        <div class="sk-cube sk-cube9"></div>
                    </div>
                </div>
            </div>
        </div>

		<div id="page" class="@yield('classes')">
			@yield('layout-content')
		</div>
    </body>

	<!-- jQuery.min.js -->
	<script src="{{ asset('assets/tmplts_frontend/js/jquery.min.js') }}"></script>

	<!-- jQuery Global-->
    <script src="{{ asset('assets/tmplts_frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/tmplts_frontend/js/main.js') }}"></script>
	@yield('scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //PRE-LOAD
        $(document).ready(function(){
			$('.preloader').delay(1000).fadeOut();
			$('#main').delay(1000).fadeIn();
		});

        var str = $(".account").find(".name").text();
        var match = str.match(/\b(\w)/g);
        var txt = match.join('');
        $(".user-profile").text(txt);
    </script>
    @yield('jsbody')

</html>

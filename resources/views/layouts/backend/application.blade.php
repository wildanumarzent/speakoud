<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" class="default-style layout-collapsed layout-fixed">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="title" content="{!! isset($data['meta_title']) ? Str::limit(strip_tags($data['meta_title']), 69) : $configuration['meta_title'] !!}">
    <meta name="description" content="{!! isset($data['meta_description']) ? Str::limit(strip_tags($data['meta_description']), 155) : $configuration['meta_description'] !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>{{ $configuration['website_name'] }} {{ isset($title) ? ': '.$title : '' }}</title>

    <meta property="og:locale" content="{{ app()->getlocale().'_'.strtoupper(app()->getlocale()) }}" />
    <meta property="og:url" name="url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{ route('home') }}">
    <meta property="og:title" content="{!! isset($data['meta_title']) ? Str::limit(strip_tags($data['meta_title']), 69) : $configuration['meta_title'] !!}"/>
    <meta property="og:description" content="{!! isset($data['meta_description']) ? Str::limit(strip_tags($data['meta_description']), 155) : $configuration['meta_description'] !!}"/>
    <meta property="og:image" content="{{ asset('assets/tmplts_backend/images/open-graph.jpg') }}"/>
    <meta property="og:image:width" content="650" />
    <meta property="og:image:height" content="366" />
    <meta property="og:type" content="website" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/tmplts_backend/images/favicon.ico') }}" sizes="32x32">

    <!-- Main font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/fonts/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/fonts/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/fonts/open-iconic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/fonts/pe-icon-7-stroke.css') }}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/rtl/bootstrap.css') }}" class="theme-settings-bootstrap-css">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/rtl/appwork.css') }}" class="theme-settings-appwork-css">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/rtl/theme-corporate.css') }}" class="theme-settings-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/rtl/colors.css') }}" class="theme-settings-colors-css">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/css/rtl/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/css/demo.css') }}">

    <!-- Additional CSS -->
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/css/custom-alsen.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/css/line-awesome.css') }}">

    <!-- Load polyfills -->
    <script src="{{ asset('assets/tmplts_backend/vendor/js/polyfills.js') }}"></script>
    <script>document['documentMode']===10&&document.write('<script src="https://polyfill.io/v3/polyfill.min.js?features=Intl.~locale.en"><\/script>')</script>

    <!-- Layout helpers -->
    <script src="{{ asset('assets/tmplts_backend/vendor/js/layout-helpers.js') }}"></script>

    <!-- Libs -->
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

    <!-- Core scripts -->
    <script src="{{ asset('assets/tmplts_backend/vendor/js/pace.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- `perfect-scrollbar` library required by SideNav plugin -->
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/spinkit/spinkit.css') }}">
    @livewireStyles
    @yield('styles')

</head>
<body class="alsen">

    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>

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


    @yield('layout-content')

    <!-- Core scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/tmplts_backend/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/tmplts_backend/vendor/js/sidenav.js') }}"></script>

    <!-- Libs -->

    <!-- `perfect-scrollbar` library required by SideNav plugin -->
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    @yield('scripts')
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/tmplts_backend/js/demo.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // FILE BROWSE
        function callfileBrowser() {
            $(".custom-file-input").on("change", function() {
                const fileName = Array.from(this.files).map((value, index) => {
                    if (this.files.length == index + 1) {
                        return value.name
                    } else {
                        return value.name + ', '
                    }
                });
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        }
		callfileBrowser();

         // FOCUSED-FORM
		FormControl = function() {
			var e = $(".form-control, label");
			e.length && e.on("focus blur", function(e) {
				var $this = $(this);
				// console.log($this);
				if ($this.val() !== '') {
					$this.parents('.form-group').addClass('completed');
				} else {
					$this.parents('.form-group').removeClass('completed');
				}
				$(this).parents(".form-group").toggleClass("focused", "focus" === e.type)
			}).trigger("blur")
        }();

        //PRE-LOAD
        $(document).ready(function(){
			$('.preloader').delay(1000).fadeOut();
			$('#main').delay(1000).fadeIn();
		});
    </script>

        {{-- tiny mce --}}
        <script src="https://cdn.tiny.cloud/1/6qed0blc4b73g5p5uwh7acq07ay1sli0skekw9shc6wz2sbc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
      selector: 'textarea#RTE',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });

    tinymce.init({
      selector: 'textarea#RTE-M',
      height: 200,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });

    tinymce.init({
      selector: 'textarea#RTE-IMG',
      height: 500,
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste imagetools wordcount"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
        </script>
    {{-- / tiny mce --}}
    @livewireScripts
    @yield('jsbody')

</body>
</html>

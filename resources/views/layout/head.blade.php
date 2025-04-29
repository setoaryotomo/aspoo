<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="icon" type="image/png" href="{!! asset('img/logoaspoo.png') !!}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <title>ASPOO Marketplace</title>

  <title>
    {{$_ENV['APP_NAME']}}
  </title>

  <!-- Fonts and icons -->
	<script src="{!! asset('js/plugins/webfont/webfont.min.js') !!}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{!! asset("css/fonts.min.css") !!}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

  <!-- CSS Files -->
  <!-- Load CSS assets with Vite -->
  @vite
  
  <!-- include Vue.js -->
  @if (env('APP_ENV') == 'PRODUCTION')
  <script src="{!! asset('js/libraries/vue/vue.global.prod.js') !!}"></script>
  @else
  <script src="{!! asset('js/libraries/vue/vue.global.js') !!}"></script>
  @endif

  <script src="{!! asset('js/libraries/vue/vue3-sfc-loader.js') !!}"></script>


  <!-- include Vue Datepicker https://vue3datepicker.com -->
  {{-- <script src="https://unpkg.com/@vuepic/vue-datepicker@latest"></script> --}}
  <script src="{!! asset('js/libraries/vuedatepicker/vuedatepicker.js') !!}"></script>
  {{-- <link rel="stylesheet" href="https://unpkg.com/@vuepic/vue-datepicker@latest/dist/main.css"> --}}
  <link href="{!! asset('css/libraries/vuedatepicker/vdpmain.css') !!}" rel="stylesheet" />

  <!-- include CKEditor 5 (vanilla) -->
  <script src="//cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
  <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- chartjs --->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <!-- viewer js --->
  <script src="{!! asset('js/libraries/viewerjs/viewer.min.js') !!}"></script>
  <link href="{!! asset('css/libraries/viewerjs/viewer.min.css') !!}" rel="stylesheet" />

  <!---- SELECT ---->
  <script src="{!! asset('js/libraries/multiselect/multiselect.global.js') !!}"></script>
  <link href="{!! asset('css/libraries/multiselect/multiselect.css') !!}" rel="stylesheet" />
  <link id="pagestyle" href="{!! asset('css/app.css') !!}" rel="stylesheet" />

  <!---- bootsrap ---->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!---- dropdown js ---->
  {{-- <script>
    const userDropdown = document.getElementById('userDropdown');
    
    userDropdown.addEventListener('mouseenter', function () {
        if (!this.classList.contains('show')) {
            this.click();
        }
    });
  </script> --}}

  

<!-- font -->
<link rel="stylesheet" href="{!! asset('css/fonts.css') !!}">
<!-- Icons -->
<link rel="stylesheet" href="{!! asset('css/font-icons.css') !!}">
<link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
<link rel="stylesheet" href="{!! asset('css/image-compare-viewer.min.css') !!}">
<link rel="stylesheet" href="{!! asset('css/swiper-bundle.min.css') !!}">
<link rel="stylesheet" href="{!! asset('css/animate.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('css/styles.css') !!}">

<!-- Favicon and Touch Icons  -->
<link rel="shortcut icon" href="{!! asset('images/logoaspoo.png') !!}">
<link rel="apple-touch-icon-precomposed" href="{!! asset('images/logoaspoo.png') !!}">
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/jquery.min.js') !!}"></script>
<script src="{!! asset('js/swiper-bundle.min.js') !!}"></script>
<script src="{!! asset('js/carousel.js') !!}"></script>
<script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
<script src="{!! asset('js/lazysize.min.js') !!}"></script>
<script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
<script src="{!! asset('js/count-down.js') !!}"></script>
<script src="{!! asset('js/wow.min.js') !!}"></script>
<script src="{!! asset('js/multiple-modal.js') !!}"></script>
<script src="{!! asset('js/shop.js') !!}"></script>
<script src="{!! asset('js/nouislider.min.js') !!}"></script>
<script src="{!! asset('js/main.js') !!}"></script>
</head>
  
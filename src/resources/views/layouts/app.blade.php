<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', 'Banda Folk di Castello Tesino - Musica Tradizionale dal 1901')</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Meta Tags -->
    <meta name="description" content="@yield('description', 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.')">
    <meta property="og:title" content="@yield('og_title', 'Banda Folk di Castello Tesino - Tradizione dal 1901')">
    <meta property="og:description" content="@yield('og_description', 'Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.')">
    <meta property="og:image" content="@yield('og_image', asset('images/FotoSanIppolito1.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500%7CTeko:300,400,500%7CMaven+Pro:500">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sections.css') }}">
    
    @yield('styles')
    
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="{{ asset('images/ie8-panel/warning_bar_0000_us.jpg') }}" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.">
        </a>
    </div>
    <script src="{{ asset('js/html5shiv.min.js') }}"></script>
    <![endif]-->
</head>
<body>
    <div class="preloader">
        <div class="preloader-body">
            <div class="cssload-container"><span></span><span></span><span></span><span></span></div>
        </div>
    </div>

    <div class="page">
        @include('partials.header')
        
        @yield('content')
        
        @include('partials.footer')
    </div>

    <!-- JavaScript -->
    <script>
        // Make validation translations available to JavaScript
        window.validationMessages = {
            required: "{{ __('validation.js.required') }}",
            email: "{{ __('validation.js.email') }}",
            numeric: "{{ __('validation.js.numeric') }}",
            selected: "{{ __('validation.js.selected') }}"
        };
    </script>
    <script src="{{ asset('js/core.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    {{-- <script src="{{ asset('js/fslightbox.js') }}"></script> --}}
    @yield('scripts')
    
    @if(View::hasSection('structured_data'))
        <script type="application/ld+json">
            @yield('structured_data')
        </script>
    @endif
</body>
</html>

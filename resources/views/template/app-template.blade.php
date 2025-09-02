<!DOCTYPE html>
<html lang="es" translate="no">
    <head>
        <meta charset="utf-8" />
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>Kiosko - Veris</title>
        <meta name="description" content="" />
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.svg" />
        <link rel="icon" type="image/x-icon" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.png" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?display=swap&family=Montserrat:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/fontawesome.css" />
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/> --}}
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-kiosko.css?v=1.0.6')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/keyboard.css?v=1.0.1')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/bootstrap-icons.min.css?v=1.0')}}">

        <!-- Vendors CSS -->
        {{-- <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/swiper/swiper.css" /> --}}
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
        @stack('css')
        
        <script>
            let accessToken = "{{ $accessToken }}";
            let mac = "{{ $mac }}";
            let web_url = "{{ \App\Models\Veris::WEBURL }}";
            const url_payment = "{{ \App\Models\Veris::URLPAYMENT }}";
            const api_url = "{{ \App\Models\Veris::BASE_URL }}";
            const api_url_digitales = "{{ \App\Models\Veris::BASE_URL_DIGITALES }}";
            const api_war_seguridad = "{{ \App\Models\Veris::SEGURIDADES_WAR }}";
            const api_war_digitales = "{{ \App\Models\Veris::BASE_WAR_DIGITALES }}";
            const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
            const _application = "{{ \App\Models\Veris::APPLICATION }}";
            const _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";
            const _applicationLogin = "{{ \App\Models\Veris::APPLICATION_LOGIN }}";
            const _applicationLoginLider = "{{ \App\Models\Veris::APPLICATION_LOGIN_LIDER }}";
            const _idOrganizacionLogin = "{{ \App\Models\Veris::IDORGANIZACION_LOGIN }}";
            let trackId = '';
            let canalOrigen = 'MVE_CMV';
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script> 
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.1.3"></script>
        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/jquery.idle.min.js"></script> --}}
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
    </head>

    <body class="d-flex flex-column min-vh-100 @yield('bodybg')">
        <!-- Layout wrapper -->
        
        @yield('content')

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/i18n/i18n.js"></script> --}}
        <!-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script> -->

        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/swiper/swiper.js"></script> --}}
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/html2canvas.min.js"></script>
        @include('components.modals')

        @stack('scripts')
        <style>
            html, body {
                touch-action: pan-x pan-y; /* Permite solo desplazamiento horizontal y vertical */
            }
            .btn-close {
                box-sizing: content-box;
                width: 1.5em !important;
                height: 1.5em !important;
                padding: .25em .25em;
                color: #000;
                background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center / 2em auto no-repeat !important;
                border: 0;
                border-radius: .25rem;
                opacity: .5;
                background-size: 1.5rem;
            }
        </style>    
    </body>
</html>
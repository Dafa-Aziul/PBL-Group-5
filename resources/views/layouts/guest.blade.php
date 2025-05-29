<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kopcv.jpg') }}">
    @vite(['resources/sass/app.scss','resources/js/app.js'])

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
    @livewireStyles
    </head>

    <body class="">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                {{ $slot }}
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    {{-- @vite('resources/js/app.js') --}}
    @livewireScripts
    </body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kopcv.jpg') }}">
    {{--
    <link rel="manifest" href="../../assets/img/favicon/site.webmanifest"> --}}
    {{--
    <link rel="mask-icon" href="{{ assest('images/kopcv.jpg') }}" color="#ffffff"> --}}
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    @livewireScripts
    </body>

</html>

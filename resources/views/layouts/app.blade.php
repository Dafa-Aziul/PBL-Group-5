<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name')}}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kopcv.jpg') }}">
    {{-- <link rel="manifest" href="../../assets/img/favicon/site.webmanifest"> --}}
    {{-- <link rel="mask-icon" href="{{ assest('images/kopcv.jpg') }}" color="#ffffff"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
    @livewireStyles
  </head>
  <body class="sb-nav-fixed">
    <x-navbar />
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <x-sidebar />
        
      </div>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            {{ $slot }}
          </div>
        </main>
      </div>
    </div>
    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>    
    <script src="{{ asset('js/scripts.js') }}"></script>  
  </body>
  </html>

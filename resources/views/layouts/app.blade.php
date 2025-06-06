<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name')}}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kopcv.jpg') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    @vite(['resources/sass/app.scss'])
    @vite('resources/css/styles.css')
    {{-- Font Awesome --}}
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
    <script>
        document.addEventListener('livewire:load', () => {
            window.initChoices();

            Livewire.hook('message.processed', (message, component) => {
                window.initChoices();
            });
        });
    </script>
    @vite('resources/js/app.js')
    @vite('resources/js/scripts.js')
    @vite('resources/js/chart.js')
    @vite('resources/js/select2.js')
</body>
<script>
    document.addEventListener('livewire:load', () => {
        const initChoices = () => {
            document.querySelectorAll('.select-pelanggan').forEach((el) => {
                if (!el.classList.contains('choices-initialized')) {
                    new Choices(el, {
                        searchEnabled: true,
                        itemSelectText: '',
                    });
                    el.classList.add('choices-initialized');
                }
            });
        };

        initChoices();

        Livewire.hook('message.processed', (message, component) => {
            initChoices();
        });
    });
</script>


</html>

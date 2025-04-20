<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Jenis Kendaraan')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Tooltip (kalau belum ada) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>


    <div class="navbar navbar-dark bg-dark px-3 d-flex justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-light btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Dashboard">
                <i class="fas fa-home"></i>
            </a>
            <span class="navbar-brand mb-0 h1 text-white">Manajemen Kendaraan</span>
        </div>
    </div>

    <!-- <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manajemen Kendaraan</a>
        </div>
    </nav> -->

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


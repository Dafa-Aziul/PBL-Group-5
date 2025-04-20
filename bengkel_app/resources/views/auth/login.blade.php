
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.145.0">
    <title>Log in account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">

<div class="container-fluid ">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle" style="width: 100%; max-width: 420px;">
        <form action="{{ route('login.post') }}" method="POST" class="form-signin">
          @csrf
          <div class="text-center mb-4">
            <i class="bi bi-person-circle fs-1 text-primary"></i>
            <h1 class="h4 fw-bold">Login ke Akun Anda</h1>
            <p class="text-muted small">Masukkan email dan password untuk melanjutkan</p>
          </div>
      
          <div class="form-floating mb-3">
            <input type="email" class="form-control " id="floatingInput" placeholder="name@example.com" name="email" value="{{ old('email') }}" required autofocus>
            <label for="floatingInput">Alamat Email</label>
          </div>
      
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
            <label for="floatingPassword">Kata Sandi</label>
          </div>
          <div>
            @if(session('gagal'))
              <p class="text-danger">*{{ session('gagal') }}</p>
            @endif
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
            <label class="form-check-label" for="rememberMe">
              Ingat saya
            </label>
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
        </form>
    </main>
</div> 
<script defer src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"></script>

    </body>
</html>

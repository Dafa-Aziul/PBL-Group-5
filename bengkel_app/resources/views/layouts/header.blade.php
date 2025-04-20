<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <header class="navbar sticky-top bg-dark flex-md-nowrap p-2" data-bs-theme="dark">
    <!-- Brand -->
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white d-none d-md-block" href="#">
      <img src="kopcv.jpg" class="me-2" alt="" height="25">CV. Razka Pratama
    </a>
  
    <!-- Tombol Mobile -->
    <ul class="navbar-nav d-md-none me-auto">
      <li class="nav-item text-nowrap">
        <button class="nav-link px-3 text-white btn btn-link" type="button"
          data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="bi bi-list"></i>
        </button>
      </li>
    </ul>
  
    <!-- Tombol dan Input Search di Kanan -->
    <ul class="navbar-nav ms-auto align-items-center">
      <!-- Search Desktop -->
      <li class="nav-item d-none d-md-flex align-items-center">
        <div id="navbarSearch" class="collapse d-flex align-items-center">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="nav-link px-3 text-white btn btn-link" type="button" aria-label="Toggle search">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </li>
    
      <!-- Search Mobile (satu baris input + tombol) -->
      <li class="nav-item d-md-none px-3">
          <div id="navbarSearchMobile" class="collapse d-flex align-items-center w-100">
              <input class="form-control me-2 w-100" type="search" placeholder="Search" aria-label="Search">
              <button class="nav-link px-3 text-white btn btn-link" type="button" aria-label="Toggle search">
                <i class="bi bi-search"></i>
              </button>
          </div>
      </li>
    </ul>
    
    <!-- Dropdown User -->
    <div class="d-flex align-items-center ms-3 me-3">
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <!-- Info User (Hanya Desktop) -->
          <div class="d-none d-md-flex flex-column text-end me-2">
            <span class="fw-semibold text-white">Administrator</span>
            <small class="text-light">Admin</small>
          </div>
    
          <!-- Avatar -->
          <img src="https://github.com/mdo.png" alt="Avatar" height="40" class="rounded-circle" />
        </a>
    
        <!-- Dropdown Menu -->
        <ul class="dropdown-menu text-small shadow dropdown-menu-end">
          <!-- Info User (Hanya Mobile) -->
          <li class="px-3 py-2 d-block d-md-none">
            <div class="fw-semibold">Administrator</div>
            <div class="text-muted small">Admin</div>
            <hr class="my-2">
          </li>
    
          <!-- Menu Options -->
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>
  </header>
</body>
</html>

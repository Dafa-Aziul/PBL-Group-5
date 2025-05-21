<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" data-navigate-once>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <x-nav-link wire:current.exact href="{{ route('dashboard') }}" icon="fas fa-tachometer-alt p-2">Dashboard</x-nav-link>
            
            <x-nav-link wire:current.exact href="{{ route('user.view') }}" icon="fas fa-solid fa-user p-2">User</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('karyawan.view') }}" icon="fas fa-solid fa-id-badge p-2">Karyawan</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('jenis_kendaraan.view') }}" icon="fas fa-solid fa-car p-2">Jenis Kendaraan</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('pelanggan.view') }}" icon="fas fa-users  p-2">Pelanggan</x-nav-link>
        
            <x-nav-link wire:current.exact href="{{ route('jasa.view') }}" icon="fa-solid fa-briefcase p-2">Jasa</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('sparepart.view') }}" icon="fa-solid fa-boxes-stacked p-2 ">Sparepart</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('konten.view') }}" icon="fa-solid fa-newspaper p-2 ">Konten</x-nav-link>


        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ auth()->user()->name }}
        <div class="small">Role: {{ auth()->user()->role }}</div>
    </div>
</nav>
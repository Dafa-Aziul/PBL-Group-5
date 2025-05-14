<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" data-navigate-once>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <x-nav-link wire:current.exact href="{{ route('dashboard') }}" icon="fas fa-tachometer-alt p-2">Dashboard
            </x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('user.view') }}" icon="fa-solid fa-user p-2">User</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('pelanggan.view') }}" icon="fa-solid fa-user p-2">Kelola
                Pelanggan</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('jenis_kendaraan.view') }}" icon="fa-solid fa-car">Kelola
                Jenis Kendaraan</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('jenis_jasa.view') }}" icon="fa-solid fa-briefcase">Kelola
                Jenis Jasa</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('sparepart.view') }}" icon="fa-solid fa-boxes-stacked">Kelola
                Sparepart</x-nav-link>


        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ auth()->user()->name }}
        <div class="small">Role: {{ auth()->user()->role }}</div>
    </div>
</nav>
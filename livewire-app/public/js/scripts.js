/*!
 * SB Admin v7.0.7 - Optimized for Livewire
 */

// Inisialisasi semua fitur saat DOM siap
document.addEventListener('DOMContentLoaded', initializeComponents);

// Livewire V3: Navigasi dan Morph
document.addEventListener('livewire:navigated', () => {
    setTimeout(initializeComponents, 50);
});

document.addEventListener('livewire:morph-updated', () => {
    setTimeout(initializeComponents, 50);
});

// Fallback untuk Livewire v2
document.addEventListener('livewire:load', initializeComponents);

// Inisialisasi ulang komponen Bootstrap & fitur lainnya
function initializeComponents() {
    initSidebarToggle();
    initBootstrapComponents();
}

// Sidebar Toggle
function initSidebarToggle() {
    const sidebarToggle = document.querySelector('#sidebarToggle');
    if (!sidebarToggle || sidebarToggle.dataset.bound) return;

    sidebarToggle.addEventListener('click', function (e) {
        e.preventDefault();
        const toggled = document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', toggled);
    });

    sidebarToggle.dataset.bound = 'true';
    handleResponsiveLayout();
}

// Atur ulang tampilan sidebar berdasarkan ukuran layar
function handleResponsiveLayout() {
    const isMobile = window.innerWidth < 992;
    const isToggled = localStorage.getItem('sb|sidebar-toggle') === 'true';

    if (isMobile) {
        document.body.classList.remove('sb-sidenav-toggled');
    } else {
        document.body.classList.toggle('sb-sidenav-toggled', isToggled);
    }
}

window.addEventListener('resize', handleResponsiveLayout);

// Inisialisasi komponen Bootstrap tanpa duplikasi
function initBootstrapComponents() {
    if (!window.bootstrap) {
        console.warn('Bootstrap JS not loaded');
        return;
    }

    // Modal
    document.querySelectorAll('.modal').forEach(el => {
        bootstrap.Modal.getOrCreateInstance(el);
    });

    // Dropdown
    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => {
        if (!el.dataset.bsDropdownBound) {
            bootstrap.Dropdown.getOrCreateInstance(el);
            el.dataset.bsDropdownBound = 'true';
        }
    });

    // Tooltip
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        if (!el.dataset.bsTooltipBound) {
            bootstrap.Tooltip.getOrCreateInstance(el);
            el.dataset.bsTooltipBound = 'true';
        }
    });

    // Collapse
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(el => {
        if (!el.dataset.bsCollapseBound) {
            bootstrap.Collapse.getOrCreateInstance(el, { toggle: false });
            el.dataset.bsCollapseBound = 'true';
        }
    });
}

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Import Select2 dari dist langsung agar dia auto-attach ke jQuery global
import select2 from 'select2';
import 'select2/dist/css/select2.min.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';

select2($);

window.initSelect2 = () => {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: '-- Pilih --',
        allowClear: true,
    });
};

$(document).ready(() => {
    window.initSelect2();
});

// Livewire support
document.addEventListener('livewire:load', () => {
    Livewire.hook('message.processed', () => {
        window.initSelect2();
    });
});

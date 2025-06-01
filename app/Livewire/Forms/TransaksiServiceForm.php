<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransaksiServiceForm extends Form
{
    #[Validate('required|exists:pelanggans,id')]
    public $pelanggan_id;

    #[Validate('required|exists:karyawans,id')]
    public $kasir_id;

    #[Validate('required|in:service,penjualan')]
    public $jenis_transaksi = 'service';

    #[Validate('required|string|unique:transaksis,kode_transaksi')]
    public $kode_transaksi;

    #[Validate('required|numeric|min:0')]
    public $sub_total;

    #[Validate('nullable|numeric|min:0')]
    public $pajak = 0;

    #[Validate('nullable|numeric|min:0|max:100')]
    public $diskon = 0;

    #[Validate('required|numeric|min:0')]
    public $grand_total;

    #[Validate('required|in:lunas,pending')]
    public $status_pembayaran = 'pending';

    #[Validate('nullable|string')]
    public $keterangan;

    public function fillFormModel($service)
    {
        $this->pelanggan_id = $service->kendaraan->pelanggan_id;
        $this->kasir_id = Auth::id();
        $this->sub_total = $service->estimasi_harga;
        $this->jenis_transaksi = 'service';
    }

    public function hitungTotal()
    {
        $diskonValue = $this->sub_total * ($this->diskon / 100);
        $this->grand_total = round($this->sub_total + $this->pajak - $diskonValue, 2);
        if ($this->grand_total < 0) {
            $this->grand_total = 0;
        }
    }
}

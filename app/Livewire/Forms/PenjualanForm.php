<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;

class PenjualanForm extends Form
{
    #[Validate('required|exists:pelanggans,id')]
    public $pelanggan_id;

    #[Validate('required|exists:karyawans,id')]
    public $kasir_id;

    #[Validate('required|in:service,penjualan')]
    public $jenis_transaksi = 'penjualan';

    #[Validate('required|string|unique:transaksis,kode_transaksi')]
    public $kode_transaksi;

    #[Validate('required|numeric|min:0')]
    public $sub_total;

    #[Validate('nullable|numeric|min:0')]
    public $pajak = 0;

    #[Validate('nullable|numeric|min:0|max:100')]
    public $diskon = 0;

    #[Validate('required|numeric|min:0')]
    public $total;

    #[Validate('required|in:lunas,pending')]
    public $status_pembayaran = 'pending';

    #[Validate('nullable|string')]
    public $keterangan;

    public function fillFormModel($penjualan)
    {
        $this->pelanggan_id = $penjualan->pelanggan_id;
        $this->kasir_id = $penjualan->kasir_id;
        $this->jenis_transaksi = $penjualan->jenis_transaksi;
        $this->kode_transaksi = $penjualan->kode_transaksi;
        $this->sub_total = $penjualan->sub_total;
        $this->pajak = $penjualan->pajak;
        $this->diskon = $penjualan->diskon;
        $this->total = $penjualan->total;
        $this->status_pembayaran = $penjualan->status_pembayaran;
        $this->keterangan = $penjualan->keterangan;
        // Jika ada field lain yang perlu diisi, tambahkan di sini
        // $this->foto_lama = $transaksi->foto; // Jika ada foto atau field lain yang perlu diisi
    }
}

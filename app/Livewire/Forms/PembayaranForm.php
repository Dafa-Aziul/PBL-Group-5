<?php

namespace App\Livewire\Forms;

use App\Models\Pembayaran;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PembayaranForm extends Form
{
    #[Validate('required|date')]
    public $tanggal_bayar;

    #[Validate('required|numeric|min:0')]
    public $jumlah_bayar;

    #[Validate('nullable|string|max:255')]
    public $ket;

    public function resetForm()
    {
        $this->tanggal_bayar = now()->format('Y-m-d');
        $this->jumlah_bayar = null;
        $this->ket = '';
    }

    public function simpan($transaksi, $sisaPembayaran)
    {
        $this->validate([
            'jumlah_bayar' => "required|numeric|min:0|max:$sisaPembayaran",
        ], [
            'jumlah_bayar.max' => 'Jumlah bayar tidak boleh lebih besar dari sisa pembayaran.',
        ]);

        $grand_totalSebelumnya = $transaksi->pembayarans->sum('jumlah_bayar');
        $grand_totalSesudah = $grand_totalSebelumnya + $this->jumlah_bayar;

        $status = $grand_totalSesudah >= $transaksi->grand_total ? 'lunas' : 'pending';

        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'tanggal_bayar' => $this->tanggal_bayar,
            'jumlah_bayar' => $this->jumlah_bayar,
            'status_pembayaran' => $status,
            'ket' => $this->ket,
        ]);

        return $status;
    }
}

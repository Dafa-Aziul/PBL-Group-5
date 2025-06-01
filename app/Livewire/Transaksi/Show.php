<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\PembayaranForm;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Livewire\Component;

class Show extends Component
{
    public Transaksi $transaksi;
    public PembayaranForm $form;

    public $sisaPembayaran = 0;

    public function mount($id)
    {
        $this->transaksi = Transaksi::with('pembayarans')->findOrFail($id);
        $this->form->tanggal_bayar = now()->format('Y-m-d');
        $this->hitungSisaPembayaran();
    }

    public function hitungSisaPembayaran()
    {
        $grand_total = $this->transaksi->pembayarans->sum('jumlah_bayar');
        $this->sisaPembayaran = max(0, $this->transaksi->grand_total - $grand_total);
    }


    private function closePaymentModal()
    {
        $this->dispatch('hide-payment-modal');
    }

    public function simpanPembayaran()
    {
        $this->form->validate([
            'jumlah_bayar' => "required|numeric|min:0|max:{$this->sisaPembayaran}",
        ]);

        $statusBaru = $this->form->simpan($this->transaksi, $this->sisaPembayaran);

        $this->transaksi->refresh();
        $this->transaksi->update(['status_pembayaran' => $statusBaru]);

        $this->hitungSisaPembayaran();
        $this->form->resetForm();

        session()->flash('message', 'Pembayaran berhasil disimpan.');
        $this->closePaymentModal();
    }

    public function render()
    {
        return view('livewire.transaksi.show', [
            'transaksi' => $this->transaksi,
            'sisaPembayaran' => $this->sisaPembayaran,
        ]);
    }
}

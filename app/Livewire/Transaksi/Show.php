<?php

namespace App\Livewire\Transaksi;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Livewire\Component;

class Show extends Component
{
    public $transaksi;

    // Untuk modal pembayaran
    public $tanggal_bayar;
    public $jumlah_bayar;
    public $status_pembayaran = 'pending';
    public $sisaPembayaran = 0;
    public $ket;

    public function mount($id)
    {
        $this->transaksi = Transaksi::with('pembayarans')->findOrFail($id);
        $this->tanggal_bayar = now()->format('Y-m-d');
        $this->hitungsisaPembayaran();
    }

    public function hitungsisaPembayaran()
    {
        $totalPembayaran = $this->transaksi->pembayarans->sum('jumlah_bayar');
        $this->sisaPembayaran = $this->transaksi->total - $totalPembayaran;
        if ($this->sisaPembayaran < 0) {
            $this->sisaPembayaran = 0;
        }
    }

    public function openPaymentModal()
    {
        $this->resetValidation();
        $this->tanggal_bayar = now()->format('Y-m-d');
        $this->jumlah_bayar = null;
        $this->status_pembayaran = 'pending';
        $this->ket = '';
        $this->dispatch('open-payment-modal', [
            'transaksiId' => $this->transaksi->id,
        ]);
    }

    public function closePaymentModal()
    {
        $this->dispatch('hide-payment-modal');
    }

    public function simpanPembayaran()
    {
        $this->validate([
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => "required|numeric|min:0|max:{$this->sisaPembayaran}",
            'ket' => 'nullable|string|max:255',
        ], [
            'jumlah_bayar.max' => 'Jumlah bayar tidak boleh lebih besar dari sisa pembayaran.',
        ]);

        // Total pembayaran sebelum ini
        $totalPembayaranSebelumnya = $this->transaksi->pembayarans->sum('jumlah_bayar');
        $totalSetelahPembayaran = $totalPembayaranSebelumnya + $this->jumlah_bayar;

        // Tentukan status pembayaran otomatis
        $statusPembayaranBaru = $totalSetelahPembayaran >= $this->transaksi->total ? 'lunas' : 'pending';

        Pembayaran::create([
            'transaksi_id' => $this->transaksi->id,
            'tanggal_bayar' => $this->tanggal_bayar,
            'jumlah_bayar' => $this->jumlah_bayar,
            'status_pembayaran' => $statusPembayaranBaru,
            'ket' => $this->ket,
        ]);

        $this->jumlah_bayar = null; // Reset jumlah bayar setelah simpan
        $this->tanggal_bayar = now()->format('Y-m-d'); // Reset tanggal bayar ke hari ini
        $this->ket = ''; // Reset keterangan

        $this->transaksi = $this->transaksi->fresh('pembayarans');
        $this->hitungsisaPembayaran();

        // Update status transaksi keseluruhan
        if ($totalSetelahPembayaran >= $this->transaksi->total) {
            $this->transaksi->update(['status_pembayaran' => 'lunas']);
        } else {
            $this->transaksi->update(['status_pembayaran' => 'pending']);
        }

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

<?php

namespace App\Livewire\Penjualan;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Livewire\Component;

class Show extends Component
{
    public $penjualan;

    // Untuk modal pembayaran

    public function mount($id)
    {
        $this->penjualan = Transaksi::with('penjualanDetail')->findOrFail($id);
    }


    public function render()
    {
        return view('livewire.penjualan.show', [
            'penjualan' => $this->penjualan,
        ]);
    }
}

<?php

namespace App\Livewire\Penjualan;

use App\Models\Transaksi;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $penjualans = Transaksi::where('jenis_transaksi', 'penjualan')
            ->with(['pelanggan'])
            ->latest()
            ->paginate(10);
        return view('livewire.penjualan.index', compact('penjualans'));
    }
}

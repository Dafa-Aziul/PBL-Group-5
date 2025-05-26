<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;

class Show extends Component
{
    public $transaksi;

    public function mount($id)
    {
        $this->transaksi = Transaksi::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.transaksi.show', [
            'transaksi' => $this->transaksi,
        ]);
    }
}

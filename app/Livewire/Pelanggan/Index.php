<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Index extends Component
{
    public $pelanggans;

    public function mount()
    {
        $this->pelanggans = Pelanggan::all();
    }

    public function render()
    {
        return view('livewire.pelanggan.index');
    }
}


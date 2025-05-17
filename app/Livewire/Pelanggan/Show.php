<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $pelanggan = Pelanggan::findOrFail($this->id);
        return view('livewire.pelanggan.show', compact('pelanggan'));
    }
}

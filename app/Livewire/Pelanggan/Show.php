<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;

class Show extends Component
{
    
    public function render()
    {
        return view('livewire.pelanggan.show')->with('wire:navigate', true);
    }
}

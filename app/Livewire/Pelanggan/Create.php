<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\PelanggannForm;
use App\Models\Pelanggan;
use Livewire\Component;

class Create extends Component
{   
    public PelanggannForm $form;
    public function submit(){
        $validated = $this->form->validate();
        Pelanggan::create($validated);
        session()->flash('success', 'Pelanggan berhasil ditambahkan!');
        return redirect()->route('pelanggan.view')->with('wire:navigate', true);
    }
    public function render()
    {
        return view('livewire.pelanggan.create');
    }
}

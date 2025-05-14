<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\PelangganForm;
use App\Models\JenisKendaraan;
use Livewire\Component;
use App\Models\Pelanggan;

class Create extends Component
{
    public PelangganForm $form;

    public function simpan()
    {
        
         $validated=$this->form->validate();

        Pelanggan::create($validated);

        session()->flash('success', 'Jenis Kendaraan berhasil ditambahkan!');
            return redirect()->route('pelanggan.view')->with('wire:navigate', true);
        
            
    }
 
    public function render()
    {
        return view('livewire.pelanggan.create', ['jenis_kendaraan' => JenisKendaraan::all()]);
    }
}

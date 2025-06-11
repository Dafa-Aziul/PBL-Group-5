<?php

namespace App\Livewire\JenisKendaraan;

use App\Livewire\Forms\JenisKendaraanForm;
use App\Models\JenisKendaraan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Jenis Kendaraan Baru')]
class Create extends Component
{
    public JenisKendaraanForm $form;

    public function submit()
    {
        $validated = $this->form->validate();
        JenisKendaraan::create($validated);
        session()->flash('success', 'Jenis Kendaraan berhasil ditambahkan!');
        return redirect()->route('jenis_kendaraan.view')->with('wire:navigate', true);
    }

    public function render()
    {
        return view('livewire.jenis-kendaraan.create');
    }
}

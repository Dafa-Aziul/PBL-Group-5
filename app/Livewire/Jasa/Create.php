<?php

namespace App\Livewire\Jasa;

use App\Livewire\Forms\JasaForm;
use App\Models\Jasa;
use App\Models\JenisKendaraan;
use Livewire\Component;

class Create extends Component
{
    public JasaForm $form;

    public function submit()
    {
        $validated = $this->form->validate();

        logger()->info('Data valid:', $validated); // log ke storage/logs/laravel.log

        Jasa::create($validated);
        session()->flash('success', 'Jasa berhasil ditambahkan!');
        return redirect()->route('jasa.view')->with('wire:navigate', true);
    }

    public function render()
    {
        return view('livewire.jasa.create', ['jenis_kendaraan' => JenisKendaraan::all()]);;
    }
}

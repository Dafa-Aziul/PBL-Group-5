<?php

namespace App\Livewire\Jasa;

use App\Livewire\Forms\JasaForm;
use App\Models\Jasa;
use App\Models\JenisKendaraan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Jasa Baru')]
class Create extends Component
{
    public JasaForm $form;

    public function submit()
    {
        // Tambahkan detik jika hanya HH:MM
        if (preg_match('/^\d{2}:\d{2}$/', $this->form->estimasi)) {
            $this->form->estimasi .= ':00';
        }
        $this->form->harga = $this->form->harga ?? 0;
        $validated = $this->form->validate();

        logger()->info('Data valid:', $validated); // log ke storage/logs/laravel.log

        $jasa = Jasa::create($validated);
        session()->flash('success', 'Jasa berhasil ditambahkan!');
        return redirect()->route('jasa.view')->with('wire:navigate', true);
    }

    public function render()
    {
        return view('livewire.jasa.create', ['jenis_kendaraan' => JenisKendaraan::all()]);;
    }
}

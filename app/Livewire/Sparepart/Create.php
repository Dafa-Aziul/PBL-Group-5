<?php

namespace App\Livewire\Sparepart;

use Livewire\Attributes\Validate;
use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Livewire\Component;

class Create extends Component
{
    public SparepartForm $form;
    
    #[Validate('required|unique:spareparts,kode|string|max:255')]
    public string $kode = '';


    public function submit(){
        // Validasi hanya properti kode di komponen ini
        $validatedForm = $this->form->validate();
        $validatedKode = $this->validateOnly('kode');

        // Validasi form object (jika kamu punya field lain di $form)

        // Gabungkan hasil validasi (jika diperlukan)
        $data = array_merge(
            ['kode' => $this->kode],
            $validatedForm
        );

        logger()->info('Data valid:', $data); // log ke storage/logs/laravel.log
        Sparepart::create($data);
        session()->flash('success', 'Sparepart berhasil ditambahkan!');
        return redirect()->route('sparepart.view')->with('wire:navigate', true);
    }
    
    public function render()
    {
        return view('livewire.sparepart.create');
    }
}
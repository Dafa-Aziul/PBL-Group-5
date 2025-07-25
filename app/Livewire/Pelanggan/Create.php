<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\PelangganForm;
use App\Models\Pelanggan;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Pelanggan Baru')]
class Create extends Component
{

    public PelangganForm $form;
    #[Validate('required|email|unique:pelanggans,email')]
    public string $email = '';
    // Validasi hanya properti kode di komponen ini

    public function submit(){
        $validatedForm = $this->form->validate();
        $this->validateOnly('email');
        $data = array_merge(
            ['email' => $this->email],
            $validatedForm
        );

        $validated = $this->form->validate();
        Pelanggan::create($data);
        session()->flash('success', 'Pelanggan berhasil ditambahkan!');
        return redirect()->route('pelanggan.view')->with('wire:navigate', true);
    }
    public function render()
    {
        return view('livewire.pelanggan.create');
    }
}

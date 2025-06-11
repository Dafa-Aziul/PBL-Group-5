<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\PelangganForm;
use App\Models\Pelanggan;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Pelanggan')]
class Edit extends Component
{
    public Pelanggan $pelanggan;
    public PelangganForm $form;

    public function mount($id)
    {
        $this->pelanggan = Pelanggan::findOrFail($id);
        $this->form->fillFromModel($this->pelanggan);
    }

    public function update(){
        $validated = $this->form->validate();
        $this->pelanggan->update($validated);
        // session()->flash('message', 'Data berhasil diperbarui!');
        return redirect()->route('pelanggan.view')->with('success', 'Data berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}

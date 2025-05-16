<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\PelanggannForm;
use App\Models\Pelanggan;
use Livewire\Component;

class Edit extends Component
{
    public Pelanggan $pelanggan;
    public PelanggannForm $form;

    public function mount($id)
    {
        $this->pelanggan = Pelanggan::findOrFail($id);
        $this->form->fillFromModel($this->pelanggan);
    }

    public function update(){
        $validated = $this->form->validate();
        $this->pelangan->update($validated);
        // session()->flash('message', 'Data berhasil diperbarui!');
        return redirect()->route('pelanggan.view')->with('success', 'Data berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}

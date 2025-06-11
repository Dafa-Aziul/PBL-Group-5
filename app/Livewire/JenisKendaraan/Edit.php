<?php

namespace App\Livewire\JenisKendaraan;

use App\Livewire\Forms\JenisKendaraanForm;
use App\Models\JenisKendaraan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Jenis Kendaraan')]
class Edit extends Component
{
    public JenisKendaraan $jenis_kendaraan;
    public JenisKendaraanForm $form;

    public function mount($id)
    {
        $this->jenis_kendaraan = JenisKendaraan::findOrFail($id);
        $this->form->fillFromModel($this->jenis_kendaraan);
    }

    public function update()
    {
        $validated = $this->form->validate();
        $this->jenis_kendaraan->update($validated);

        // session()->flash('message', 'Data berhasil diperbarui!');
        return redirect()->route('jenis_kendaraan.view')->with('success', 'Data berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.jenis-kendaraan.edit');
    }
}

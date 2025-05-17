<?php

namespace App\Livewire\JenisKendaraan;

use App\Livewire\Forms\JenisKendaraanForm;
use App\Models\JenisKendaraan;
use Livewire\Component;

class Edit extends Component
{
    public JenisKendaraan $jenis_kendaraan;
    public JenisKendaraanForm $form;

    public function mount($id)
    {
        $this->jenis_kendaraan = JenisKendaraan::findOrFail($id);

        // $this->form->fillFormModel($this->jenis_kendaraan);
        $this->form->fill($this->jenis_kendaraan->toArray());


    }

    public function update()
    {
        $validated = $this->form->validate();
        $this->jenis_kendaraan->update($validated);

        // session()->flash('success', 'Jenis Kendaraan berhasil diperbarui!');
        return redirect()->route('jenis_kendaraan.view')->with('success', 'Data berhasil diperbarui!');

    }

    public function render()
    {
        return view('livewire.jenis-kendaraan.edit');
    }
}
